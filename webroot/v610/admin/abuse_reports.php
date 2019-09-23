<?
#################################################################
## PHP Pro Bid v6.10															##
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
include_once ('../includes/class_item.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	if ($_REQUEST['do'] == 'delete')
	{
		$db->query("DELETE FROM " . DB_PREFIX . "abuses WHERE abuse_id='" . intval($_REQUEST['abuse_id']) . "'");
		$template->set('msg_changes_saved', '<p align="center">' . AMSG_RECORD_DELETED . '</p>');
	}
	
	if ($_REQUEST['do'] == 'delete_auction')
	{
		$item = new item();
		$item->setts = &$setts;

		$item->delete(intval($_REQUEST['auction_id']), 0, true, true);
		$db->query("DELETE FROM " . DB_PREFIX . "abuses WHERE abuse_id='" . intval($_REQUEST['abuse_id']) . "'");
		
		$template->set('msg_changes_saved', '<p align="center">' . AMSG_AUCTION_DELETED . '</p>');		
	}
	
	if ($_REQUEST['do'] == 'suspend_auction')
	{
		$value = intval($_REQUEST['auction_id']);
		$cnt_details = $db->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
			" . DB_PREFIX . "auctions WHERE auction_id='" . intval($value) . "'");

		if ($cnt_details['active'] == 1 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store')
		{
			auction_counter($cnt_details['category_id'], 'remove', $cnt_details['auction_id']);
			auction_counter($cnt_details['addl_category_id'], 'remove', $cnt_details['auction_id']);
		}
		$sql_update_auctions = $db->query("UPDATE " . DB_PREFIX . "auctions SET active=0 WHERE
					auction_id='" . $value . "'");
		
		$template->set('msg_changes_saved', '<p align="center">' . AMSG_AUCTION_SUSPENDED . '</p>');		
	}
	
	$limit = 20;

	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.reg_date';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	//$additional_vars = '&submitted=' . $_REQUEST['submitted'] . '&src_from=' . $_REQUEST['src_from'] . '&src_to=' . $_REQUEST['src_to'] . '&src_rating=' . $_REQUEST['src_rating'];

	$nb_abuses = $db->count_rows('abuses');

	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_abuses));

	$sql_select_abuses = $db->query("SELECT a.*, u.username AS reporter_username, au.name AS auction_name FROM
		" . DB_PREFIX . "abuses AS a
		LEFT JOIN " . DB_PREFIX . "users AS u ON u.user_id=a.user_id
		LEFT JOIN " . DB_PREFIX . "auctions AS au ON au.auction_id=a.auction_id
		ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

	while ($abuse_details = $db->fetch_array($sql_select_abuses))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$abuse_reports_content .= '<tr class="' . $background . '"> '.
    		'	<td valign="top"> <b>' . AMSG_REPORTER . '</b>: ' . $abuse_details['reporter_username'] . '<br> '.
    		'		<b>' . AMSG_REPORTED_USER . '</b>: ' . $abuse_details['abuser_username'] . '</td> '.
    		'	<td valign="top">' . (($abuse_details['auction_id']) ? '<b>' . AMSG_REPORTED_AUCTION . '</b>: #' . $abuse_details['auction_id'] . ' - ' . $abuse_details['auction_name'] . '<hr>' : ''  ) . 
    		'		'	. $abuse_details['comment'] . '</td>'.
			'	<td align="center" class="contentfont"> '.
			'		' . (($abuse_details['auction_id'] && $abuse_details['active']) ? '[ <a href="abuse_reports.php?do=suspend_auction&abuse_id=' . $abuse_details['abuse_id'] . '&auction_id=' . $abuse_details['auction_id'] . $additional_vars . $order_link . $limit_link . '" onclick="return confirm(\'' . AMSG_SUSPEND_AUCTION_CONFIRM . '\');">' . AMSG_SUSPEND_AUCTION . '</a> ]<br> ' : '') .
			'		' . (($abuse_details['auction_id']) ? '[ <a href="abuse_reports.php?do=delete_auction&abuse_id=' . $abuse_details['abuse_id'] . '&auction_id=' . $abuse_details['auction_id'] . $additional_vars . $order_link . $limit_link . '" onclick="return confirm(\'' . AMSG_DELETE_AUCTION_CONFIRM . '\');">' . AMSG_DELETE_AUCTION . '</a> ]<br> ' : '') .
			'		' . (($abuse_details['auction_id']) ? '[ <a href="email_user.php?user_id=' . $abuse_details['owner_id'] . '">' . AMSG_EMAIL_SELLER . '</a> ]<br> ' : '') .
			'		[ <a href="abuse_reports.php?do=delete&abuse_id=' . $abuse_details['abuse_id'] . $additional_vars . $order_link . $limit_link . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE_REPORT . '</a> ]<br> '.
			'		[ <a href="email_user.php?user_id=' . $abuse_details['user_id'] . '">' . AMSG_EMAIL_REPORTER . '</a> ]</td> '.
			'</tr> ';
	}

	$template->set('abuse_reports_content', $abuse_reports_content);

	$pagination = paginate($start, $limit, $nb_abuses, 'abuse_reports.php', $additional_vars . $order_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_ABUSE_REPORTS);

	$template_output .= $template->process('abuse_reports.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>