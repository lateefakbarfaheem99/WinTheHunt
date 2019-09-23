<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
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

		$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

		$form_submitted = false;

		$limit = 20;

		$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'b.retraction_date';
		$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

		$additional_vars = null;
		$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
		$limit_link = '&start=' . $start . '&limit=' . $limit;
		$show_link = null;

		$form_details = array ('order_field' => $order_field, 'order_type' => $order_type,
			'start' => $start);

		$template->set('form_details', $form_details);

		if (isset($_REQUEST['form_save_settings']))
		{
			$template->set('msg_changes_saved', $msg_changes_saved);
			
			if (count($_REQUEST['delete'])>0)
			{
				$delete_array = $db->implode_array($_REQUEST['delete']);

				$db->query("DELETE FROM " . DB_PREFIX . "bids_retracted WHERE bid_id IN (" . $delete_array . ")");
			}			
		}
		
		(string) $search_filter = null;
		$nb_bids = $db->count_rows('bids_retracted b', $search_filter);

		$template->set('nb_bids', $nb_bids);
		$template->set('query_results_message', display_pagination_results($start, $limit, $nb_bids));

		$sql_select_items = $db->query("SELECT a.name, a.currency, b.*, u.username FROM
			" . DB_PREFIX ."bids_retracted b
			LEFT JOIN " . DB_PREFIX . "users u ON b.bidder_id=u.user_id
			LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
			" . $search_filter . "
			ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

		while ($item_details = $db->fetch_array($sql_select_items))
		{
			$background = ($counter++%2) ? 'c1' : 'c2';

			$retracted_bids_content .= '<tr class="' . $background . '"> '.
	      	'	<td valign="top">' . $item_details['name'] . 
	      	'		<br>' .
	      	'		[ <a href="../auction_details.php?auction_id=' . $item_details['auction_id'] . '" target="_blank">' . GMSG_VIEW . '</a> ] '.
	      	(($item_details['deleted'] == 1) ? '<br>[ <b>' . AMSG_AUCT_MARKED_DELETED . '</b> ]' : '');


	      $retracted_bids_content .= '</td> '.
				'	<td align="center">' . $item_details['username'] . '</td>' .
				'	<td align="center">' . $fees->display_amount($item_details['bid_amount'], $item_details['currency']) . '</td>' .
				'	<td align="center">' . $item_details['quantity'] . '</td>' .
				'	<td align="center">' . $fees->display_amount($item_details['bid_proxy'], $item_details['currency']) . '</td>' .
				'	<td align="center" width="100">' . show_date($item_details['bid_date']) . '</td>' .
				'	<td align="center" width="100">' . show_date($item_details['retraction_date']) . '</td>';

			$retracted_bids_content .= '<td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="' . $item_details['bid_id'] . '" class="checkdelete"></td>'.
				'</tr> ';
		}

		$template->set('retracted_bids_content', $retracted_bids_content);

		$pagination = paginate($start, $limit, $nb_bids, 'list_retracted_bids.php', $additional_vars . $order_link . $show_link);

		$template->set('pagination', $pagination);

		$template->set('header_section', AMSG_AUCTIONS_MANAGEMENT);
		$template->set('subpage_title', AMSG_VIEW_RETRACTED_BIDS);

		$template_output .= $template->process('list_retracted_bids.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>