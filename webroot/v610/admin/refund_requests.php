<?
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');
include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_user.php');
include_once ('../includes/class_fees.php');
include_once ('../includes/class_item.php');
include_once ('../includes/functions_item.php');
include_once ('../includes/functions_login.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	$item->relative_path = '../'; /* declared because we are in the admin */

	(string) $management_box = NULL;
	(string) $page_handle = 'auction';

	$form_submitted = false;

	$limit = 20;

	if ($_REQUEST['do'] == 'process_refund')
	{
		$output = $item->process_refund_request(intval($_REQUEST['invoice_id']), intval($_REQUEST['refund_request']), true);
			
		$template->set('msg_changes_saved', '<p align="center">' . $output['display'] . '</p>');		
	}
	
	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'i.refund_request_date';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$additional_vars = '&status=' . $_REQUEST['status'] . '&keywords=' . $_REQUEST['keywords'] . '&src_auction_id=' . $_REQUEST['src_auction_id'] . '&owner_id=' . $_REQUEST['owner_id'];
	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	$show_link = '&show=' . $_REQUEST['show'];

	$template->set('management_box', $management_box);

	(string) $search_filter = null;

	$subpage_title = AMSG_REFUND_REQUESTS;

	$nb_requests = $db->count_rows('invoices', "WHERE refund_request!=0");

	$template->set('nb_requests', $nb_requests);
	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_requests));



	$sql_select_items = $db->query("SELECT w.*, a.name AS auction_name, a.currency, 
		b.username AS buyer_username,	b.name AS buyer_name,
		s.username AS seller_username, s.name AS seller_name, 
		i.user_id AS payer_id, i.refund_request, i.refund_request_date FROM " . DB_PREFIX . "invoices i
		LEFT JOIN " . DB_PREFIX . "winners w ON w.refund_invoice_id=i.invoice_id
		LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
		LEFT JOIN " . DB_PREFIX . "users b ON b.user_id=w.buyer_id
		LEFT JOIN " . DB_PREFIX . "users s ON s.user_id=w.seller_id
		WHERE i.refund_request!=0 
		ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

	while ($item_details = $db->fetch_array($sql_select_items))
	{
		$refund_options_array = null;
		$background = ($counter++%2) ? 'c1' : 'c2';

		$refund_status = $item->refund_status($item_details['refund_request']);
		
		if (in_array($item_details['refund_request'], array(1, 3)))
		{
			$refund_options_array[] = '[ <a href="refund_requests.php?do=process_refund&invoice_id=' . $item_details['refund_invoice_id'] . '&refund_request=2' . $additional_vars . $order_link . $limit_link . $show_link . '">' . GMSG_APPROVE_REFUND . '</a> ]';
		}
		if (in_array($item_details['refund_request'], array(1)))
		{
			$refund_options_array[] = '[ <a href="refund_requests.php?do=process_refund&invoice_id=' . $item_details['refund_invoice_id'] . '&refund_request=3' . $additional_vars . $order_link . $limit_link . $show_link . '">' . GMSG_DECLINE_REFUND . '</a> ]';
		}
		
		$refund_options = $db->implode_array($refund_options_array, '<br>', true, '');
		
		$auctions_content .= '<tr class="' . $background . '"> '.
			'	<td valign="top">' . $item_details['auction_name'] . '<br>' .
			'		[ <a href="../auction_details.php?auction_id=' . $item_details['auction_id'] . '" target="_blank">' . GMSG_VIEW . '</a> ]</td> '.
			'	<td valign="top">' . MSG_WINNING_BID . ': <b>' . $fees->display_amount($item_details['bid_amount'], $item_details['currency']) . '</b><br>' .
			'		' . MSG_QUANTITY_PURCHASED . ': <b>' . $item_details['quantity_offered'] . '</b></td> '.
			'	<td align="center" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border smallfont"> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td>' . MSG_USERNAME . '</td> '.
			'			<td>' . $item_details['buyer_username'] . '</td> '.
			'		</tr> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td>' . MSG_FULL_NAME . '</td> '.
			'			<td>' . $item_details['buyer_name'] . '</td> '.
			'		</tr> '.
			(($item_details['payer_id'] == $item_details['buyer_id']) ? '<tr><td colspan="2" align="center" style="color: red;"><b>' . GMSG_REQUESTED_REFUND . '</b></td></tr>' : '').
			'	</table></td> '.
			'	<td align="center" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border smallfont"> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td>' . MSG_USERNAME . '</td> '.
			'			<td>' . $item_details['seller_username'] . '</td> '.
			'		</tr> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td>' . MSG_FULL_NAME . '</td> '.
			'			<td>' . $item_details['seller_name'] . '</td> '.
			'		</tr> '.
			(($item_details['payer_id'] == $item_details['seller_id']) ? '<tr><td colspan="2" align="center" style="color: red;"><b>' . GMSG_REQUESTED_REFUND . '</b></td></tr>' : '').
			'	</table></td> '.
			'	<td align="center" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border smallfont"> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td align="center">' . show_date($item_details['purchase_date']) . '</td> '.
			'		</tr> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td align="center">' . $item->flag_paid($item_details['flag_paid'], $item_details['direct_payment_paid']) . '</td> '.
			'		</tr> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td align="center">' . $item->flag_status($item_details['flag_status']) . '</td> '.
			'		</tr> '.
			'		<tr> '.
			'			<td align="center">' . GMSG_REFUND_STATUS . ': <b>' . $refund_status . '</b></td> '.
			'		</tr> '.
			'		<tr> '.
			'			<td align="center">' . GMSG_REQUEST_DATE . ': <b>' . show_date($item_details['refund_request_date']) . '</b></td> '.
			'		</tr> '.
			'	</table></td>'.
			'<td align="center">' . $refund_options . '</td>'.
			'</tr> ';
	}

	$template->set('auctions_content', $auctions_content);

	$pagination = paginate($start, $limit, $nb_requests, 'refund_requests.php', $additional_vars . $order_link . $show_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_FEES);
	$template->set('subpage_title', $subpage_title);

	$template_output .= $template->process('refund_requests.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>