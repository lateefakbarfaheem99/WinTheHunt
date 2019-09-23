<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);
define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_user.php');
include_once ('../includes/class_fees.php');
include_once ('../includes/class_item.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$level = intval($_REQUEST['level']);
	
	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	
	$limit = 20;

	$show_history_table = false;
	$show_views_table = false;
	
	$user_id = intval($_REQUEST['user_id']);
	$template->set('user_id', $user_id);
	
	if ($_REQUEST['do'] == 'display_accounting')
	{
		(string) $history_table_content = null;
		(string) $views_table_content = null;

		$history_details['start_time'] = get_box_timestamp($_REQUEST, 1);
		$history_details['start_time'] = ($history_details['start_time'] > 0) ? $history_details['start_time'] : 0;
	
		$history_details['end_time'] = get_box_timestamp($_REQUEST, 2);
		$history_details['end_time'] = ($history_details['end_time'] > 0 && $history_details['end_time'] <= CURRENT_TIME) ? $history_details['end_time'] + (24 * 60 * 60 - 1) : CURRENT_TIME;
		
		$template->set('level', $level);

		if ($level == 0)
		{
			$show_history_table = true;
			
			$additional_vars .= '&do=display_accounting&user_id=' . $user_id . 'level=' . $level . '&date1_month=' . $_REQUEST['date1_month'] . 
				'&date1_year=' . $_REQUEST['date1_year'] . '&date1_day=' . $_REQUEST['date1_day'] . 
				'&date2_month=' . $_REQUEST['date2_month'] . '&date2_year=' . $_REQUEST['date2_year'] . 
				'&date2_day=' . $_REQUEST['date2_day'];
			
			$date_query = "AND i.invoice_date>=" . $history_details['start_time'] . " AND i.invoice_date<='" . $history_details['end_time'] . "'";## PHP Pro Bid v6.00 we will generate the history table here.## PHP Pro Bid v6.00 first we select all auction invoices (account mode)## PHP Pro Bid v6.00 then we select all live fees (auction fees, store fees, signup fees)## PHP Pro Bid v6.00 we will only generate invoices for fees, not for payments, so only if invoice_amount>0 => invoice
			$user_query = ($user_id>0) ? "AND i.user_id='" . $user_id . "' " : '';
			
			$invoices_query = "SELECT i.*, sum(i.amount) AS invoice_amount, u.username FROM " . DB_PREFIX . "invoices i 
				LEFT JOIN " . DB_PREFIX . "users u ON i.user_id=u.user_id WHERE
				i.live_fee=0 AND i.item_id>0 " . $date_query . " " . $user_query . "				
				GROUP BY i.item_id
				UNION
				SELECT i.*, sum(i.amount) AS invoice_amount, u.username FROM " . DB_PREFIX . "invoices i 
				LEFT JOIN " . DB_PREFIX . "users u ON i.user_id=u.user_id WHERE
				i.live_fee=0 AND i.wanted_ad_id>0 " . $date_query . " " . $user_query . "
				GROUP BY i.wanted_ad_id
				UNION 
				SELECT i.*, sum(i.amount) AS invoice_amount, u.username FROM " . DB_PREFIX . "invoices i
				LEFT JOIN " . DB_PREFIX . "users u ON i.user_id=u.user_id WHERE
				i.live_fee=0 AND i.reverse_id>0 " . $date_query . " " . $user_query . " 
				GROUP BY i.reverse_id				
				UNION
				SELECT i.*, i.amount AS invoice_amount, u.username FROM " . DB_PREFIX . "invoices i 
				LEFT JOIN " . DB_PREFIX . "users u ON i.user_id=u.user_id WHERE
				i.live_fee=1 " . $date_query . " " . $user_query;
			
			$nb_invoices = $db->get_sql_number($invoices_query);
			$template->set('nb_invoices', $nb_invoices);
			
			$sql_select_invoices = $db->query($invoices_query . "	ORDER BY invoice_id DESC LIMIT " . $start . ", " . $limit);

			(string) $history_table_content = null;

			while ($invoice_details = $db->fetch_array($sql_select_invoices))
			{
				$background = ($counter++%2) ? 'c1' : 'c2';## PHP Pro Bid v6.00 obsolete
				//$total_invoiced += ($invoice_details['invoice_amount'] > 0) ? $invoice_details['invoice_amount'] : 0;
				//$total_paid += (($invoice_details['live_fee'] != 2) && ($invoice_details['invoice_amount'] < 0 || $invoice_details['live_fee'] == 1)) ? abs($invoice_details['invoice_amount']) : 0;
				
				$history_row = $item->history_row($invoice_details);

				$history_table_content .= '<tr class="' . $background . ' contentfont"> '.
					'	<td>[ ' . MSG_ID . ': ' . $invoice_details['user_id'] . ' ] ' . $invoice_details['username'] . '</td> '.
					'	<td align="center">' . $history_row['item_id'] . '</td> '.
					'	<td>' . $history_row['invoice_name'] . '</td> '.
					'	<td align="center">' . $history_row['date'] . '</td> '.
					'	<td align="center">' . $history_row['amount'] . '</td> '.
					//'	<td align="center">' . $history_row['balance'] . '</td> '.
					'</tr>';
			}
			$pagination = paginate($start, $limit, $nb_invoices, 'accounting.php', $additional_vars);
			$template->set('pagination', $pagination);
			
			$total_balance_payments = abs($db->get_sql_field("SELECT sum(i.amount) AS total_amount FROM " . DB_PREFIX . "invoices i WHERE i.amount<0 AND i.live_fee=0 " . $date_query . " " . $user_query, 'total_amount'));
			$total_live_payments = $db->get_sql_field("SELECT sum(i.amount) AS total_amount FROM " . DB_PREFIX . "invoices i WHERE i.amount>0 AND i.live_fee=1 AND i.processor!='' AND i.credit_adjustment=0 " . $date_query . " " . $user_query, 'total_amount');
			$total_invoiced = $db->get_sql_field("SELECT sum(i.amount) AS total_amount FROM " . DB_PREFIX . "invoices i WHERE i.amount>0 " . $date_query . " " . $user_query, 'total_amount');
			$total_paid = $total_balance_payments + $total_live_payments;
			
			$template->set('total_invoiced', $fees->display_amount($total_invoiced, $setts['currency']));
			$template->set('total_paid', $fees->display_amount($total_paid, $setts['currency']));
		}
		else 
		{
			$show_views_table = true;
			
	    	switch ($level) 
	    	{
				case '3':
					$group = "EXTRACT(YEAR_MONTH FROM FROM_UNIXTIME(invoice_date))";
					break;
				case '2':
					$group = "YEARWEEK(FROM_UNIXTIME(invoice_date))";
					break;
				case '1':
					$group = "TO_DAYS(FROM_UNIXTIME(invoice_date))";
					break;
			}

			$user_query = ($user_id>0) ? "AND user_id='" . $user_id . "' " : '';

			$sql_select_views = $db->query("SELECT invoice_date, sum(amount) AS invoice_amount, " . $group . " AS group_field FROM 
				" . DB_PREFIX . "invoices WHERE amount>0 " . $user_query . " GROUP BY group_field ORDER BY group_field DESC");
			
			while ($view_details = $db->fetch_array($sql_select_views))
			{
	    		switch ($level) 
	    		{
					case '3':
						$start = getdate($view_details['invoice_date']);
						$start['mday'] = 1;
						$finish = $start;
						$finish['mday'] = strftime ("%d", mktime(0, 0, 0, $start['mon']+1, 1 ,$start['year']) - 86400);
						$title = date("F, Y", $view_details['invoice_date']);
						break;
					case '2':
						$start = getdate($view_details['invoice_date']);
						$offset = $start["wday"];
						$start = getdate($view_details['invoice_date'] - $offset * 86400);
						$finish = getdate($view_details['invoice_date'] + (6 - $offset) * 86400);
						$title = date("M. j, Y", $view_details['invoice_date'] - $offset * 86400) . " - " . date("M. j, Y", $view_details['invoice_date'] + (6 - $offset) * 86400);
						break;
					case '1':
						$start = getdate($view_details['invoice_date']);
						$finish = $start;
						$title = date("F, j, Y", $view_details['invoice_date']);
						break;
				} 
			  	
				$views_table_content .= '<tr> '.
					'	<td><a href="accounting.php?do=display_accounting&user_id=' . $user_id . '&level=0&date1_month=' . $start['mon'] . 
							'&date1_year=' . $start['year'] . '&date1_day=' . $start['mday'] . 
							'&date2_month=' . $finish['mon'] . '&date2_year=' . $finish['year'] . 
							'&date2_day=' . $finish['mday'] . '">' . $title . '</a></td> '.
					'	<td align="center">' . $fees->display_amount($view_details['invoice_amount'], $setts['currency']) . '</td> ';
			  		'</tr> ';
			}
		}
		
		$template->set('views_table_content', $views_table_content);
		$template->set('history_table_content', $history_table_content);
	}
	
	$template->set('show_views_table', $show_views_table);
	$template->set('show_history_table', $show_history_table);
	
	$start_date_box = date_form_field($history_details['start_time'], 1, 'account_overview_form', false);
	$template->set('start_date_box', $start_date_box);
	
	$end_date_box = date_form_field($history_details['end_time'], 2, 'account_overview_form', false);
	$template->set('end_date_box', $end_date_box);

	$template->set('header_section', AMSG_ACCOUNTING);
	$template->set('subpage_title', AMSG_OVERVIEW);

	$template_output .= $template->process('accounting.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>