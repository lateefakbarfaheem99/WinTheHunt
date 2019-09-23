<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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

	$template->set('reverse', true);
	
	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	$item->relative_path = '../'; /* declared because we are in the admin */

	(string) $management_box = NULL;
	(string) $page_handle = 'auction';

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$form_submitted = false;

	$limit = 20;

	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'r.reverse_id';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$additional_vars = '&status=' . $_REQUEST['status'] . '&keywords=' . $_REQUEST['keywords'] . '&src_auction_id=' . $_REQUEST['src_auction_id'] . '&owner_id=' . $_REQUEST['owner_id'];
	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	$show_link = '&show=' . $_REQUEST['show'];

	if (isset($_REQUEST['form_save_settings']))
	{
		if (count($_REQUEST['delete'])>0)
		{
			$delete_array = $db->implode_array($_REQUEST['delete']);

			$db->query("DELETE FROM " . DB_PREFIX . "reverse_winners WHERE winner_id IN (" . $delete_array . ")");
		}
	}

	$template->set('management_box', $management_box);

	(string) $search_filter = null;

	$subpage_title = AMSG_AWARDED_PROJECTS;

	$nb_winners = $db->count_rows('reverse_winners w');

	$template->set('nb_winners', $nb_winners);
	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_winners));



	$sql_select_items = $db->query("SELECT w.*, r.name AS auction_name, r.currency, b.username AS provider_username,
		b.name AS provider_name, s.username AS poster_username, s.name AS poster_name FROM " . DB_PREFIX . "reverse_winners w
		LEFT JOIN " . DB_PREFIX . "reverse_auctions r ON r.reverse_id=w.reverse_id
		LEFT JOIN " . DB_PREFIX . "users b ON b.user_id=w.provider_id
		LEFT JOIN " . DB_PREFIX . "users s ON s.user_id=w.poster_id
		WHERE w.winner_id>0					
		ORDER BY w.winner_id DESC, " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

	while ($item_details = $db->fetch_array($sql_select_items))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$auctions_content .= '<tr class="' . $background . '"> '.
			'	<td valign="top">' . $item_details['auction_name'] . '<br>' .
			'		[ <a href="../reverse_details.php?reverse_id=' . $item_details['reverse_id'] . '" target="_blank">' . GMSG_VIEW . '</a> ]</td> '.
			'	<td>' . MSG_WINNING_BID . ': <b>' . $fees->display_amount($item_details['bid_amount'], $item_details['currency']) . '</b></td> '.
			'	<td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border smallfont"> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td>' . MSG_USERNAME . '</td> '.
			'			<td>' . $item_details['provider_username'] . '</td> '.
			'		</tr> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td>' . MSG_FULL_NAME . '</td> '.
			'			<td>' . $item_details['provider_name'] . '</td> '.
			'		</tr> '.
			'	</table></td> '.
			'	<td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border smallfont"> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td>' . MSG_USERNAME . '</td> '.
			'			<td>' . $item_details['poster_username'] . '</td> '.
			'		</tr> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td>' . MSG_FULL_NAME . '</td> '.
			'			<td>' . $item_details['poster_name'] . '</td> '.
			'		</tr> '.
			'	</table></td> '.
			'	<td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border smallfont"> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td align="center">' . show_date($item_details['purchase_date']) . '</td> '.
			'		</tr> '.
			'		<tr bgcolor="#FFFFF"> '.
			'			<td align="center">' . $item->flag_paid($item_details['flag_paid'], $item_details['direct_payment_paid']) . '</td> '.
			'		</tr> '.
			'	</table></td>'.'<td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="' . $item_details['winner_id'] . '" class="checkdelete"></td>'.
			'</tr> ';
	}

	$template->set('auctions_content', $auctions_content);

	$pagination = paginate($start, $limit, $nb_winners, 'list_awarded_reverse.php', $additional_vars . $order_link . $show_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_REVERSE_AUCTIONS_MANAGEMENT);
	$template->set('subpage_title', $subpage_title);

	$template_output .= $template->process('list_sold_items.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>