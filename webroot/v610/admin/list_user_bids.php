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
include_once ('../includes/class_item.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$form_submitted = false;

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;

	if ($_REQUEST['option'] == 'retract_bid')
	{
		$retract_output = $item->retract_bid($_REQUEST['bidder_id'], $_REQUEST['auction_id']);

		$template->set('msg_changes_saved', '<p align="center">' . $retract_output['display'] . '</p>');
	}

	$limit = 20;

	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.auction_id';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	$additional_vars = '&user_id=' . intval($_REQUEST['user_id']);

	(string) $search_filter = null;

	$nb_bids = $db->count_rows('bids b', "WHERE b.bidder_id='" . intval($_REQUEST['user_id']) . "'");

	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_bids));

	$template->set('username', $db->get_sql_field("SELECT username FROM " . DB_PREFIX . "users WHERE user_id='" . intval($_REQUEST['user_id']) . "'", 'username'));

	$sql_select_bids = $db->query("SELECT b.*, a.name, a.currency, a.closed, a.deleted, a.active FROM
		" . DB_PREFIX ."bids b
		LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
		WHERE b.bidder_id='" . intval($_REQUEST['user_id']) . "'
		ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

	while ($bid_details = $db->fetch_array($sql_select_bids))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$bid_history_content .= '<tr class="' . $background . '"> '.
    		'	<td> ' . $bid_details['auction_id'] . '</td>'.
    		'	<td> ' . $bid_details['name'] . '</td>'.
			'	<td align="center">' . $fees->display_amount($bid_details['bid_amount'], $bid_details['currency']) . '</td>'.
    		'	<td align="center">' . show_date($bid_details['bid_date']) . '</td>'.
    		'	<td align="center" class="contentfont">' . $bid_details['quantity'] . '</td> '.
    		'	<td align="center" class="contentfont">' . $item->item_status($bid_details['active']) . '</td> '.
    		'	<td align="center" class="contentfont">' . field_display($bid_details['bid_out'], GMSG_ACTIVE, GMSG_INACTIVE) . '</td> ';

		if ($bid_details['closed']==0 && $bid_details['deleted']==0)
		{
			$bid_history_content .= '<td align="center" class="contentfont"> '.
				'	[ <a href="list_user_bids.php?option=retract_bid&bidder_id=' . $bid_details['bidder_id'] . '&auction_id=' . $bid_details['auction_id'] . $additional_vars . $order_link . $limit_link . '" onclick="return confirm(\'' . MSG_RETRACT_CONFIRM_ADMIN . '\');">' . MSG_RETRACT_BID . '</a> ]</td>';
		}
		else
		{
			$bid_history_content .= '<td align=center>' . MSG_REMOVAL_IMPOSSIBLE . '</td>';
		}
		$bid_history_content .= '</tr> ';
	}

	$template->set('bid_history_content', $bid_history_content);

	$pagination = paginate($start, $limit, $nb_bids, 'list_user_bids.php', $additional_vars . $order_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_VIEW_BIDS);

	$template->set('page_order_auction_id', page_order('list_user_bids.php', 'b.auction_id', $start, $limit, $additional_vars , MSG_AUCTION_ID));
	$template->set('page_order_bid_amount', page_order('list_user_bids.php', 'b.bid_amount', $start, $limit, $additional_vars, MSG_BID_AMOUNT));
	$template->set('page_order_bid_date', page_order('list_user_bids.php', 'b.bid_date', $start, $limit, $additional_vars, GMSG_DATE));

	$template_output .= $template->process('list_user_bids.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>