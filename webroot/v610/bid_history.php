<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_user.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_item.php');
include_once ('includes/functions_item.php');

require ('global_header.php');

(array) $user_details = null;

$start_time_id = 1;
$end_time_id = 2;

$item = new item();
$item->setts = &$setts;
$item->layout = &$layout;

$page_handle = 'auction';

$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE
	auction_id='" . $_REQUEST['auction_id'] . "'");

if ($item->count_contents($item_details))
{
	if ($_REQUEST['option'] == 'retract_bid' && $session->value('user_id') == $item_details['owner_id'] && !$item->under_time($item_details))
	{
		$retract_output = $item->retract_bid($_REQUEST['bidder_id'], $_REQUEST['auction_id']);

		$template->set('msg_changes_saved', '<p align="center">' . $retract_output['display'] . '</p>');
	}

	$template->set('bid_history_header', header5(MSG_VIEW_BID_HISTORY));

	$template->set('item_details', $item_details);

	//$template->set('fees', $fees);
	$template->set('session', $session);
	$template->set('item', $item);

	$sql_select_history = $db->query("SELECT b.*, u.user_id, u.username FROM " . DB_PREFIX . "bids b LEFT JOIN
		" . DB_PREFIX . "users u ON u.user_id=b.bidder_id WHERE
		b.auction_id='".$_REQUEST['auction_id']."' ORDER BY b.bid_out ASC, b.bid_id DESC");

	(string) $bid_history_content = null;

	$remaining_quantity = $item_details['quantity'];

	$show_hidden_bid = ($item_details['owner_id'] == $session->value('user_id') || $session->value('adminarea') == 'Active' || $item_details['closed'] == 1) ? true : false;
	
	while ($bid_details = $db->fetch_array($sql_select_history))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';
		$background .= (!$bid_details['bid_out']) ? ' bold_item hl_item' : '';

		$reserve_icons = null;
		
		if ($item_details['reserve_price'] > 0)
		{
			$reserve_icons = ($bid_details['bid_amount'] < $item_details['reserve_price']) ? '<img src="images/reserve_not_met.gif" />' : '<img src="images/reserve_met.gif">';
			$reserve_icons = '<div style="padding-top: 4px;">' . $reserve_icons . '</div>';
		}
		$bid_history_content .= '<tr class="' . $background . '"> '.
    		'	<td> '.
    		(($item_details['hidden_bidding'] && !$show_hidden_bid) ? MSG_BIDDER_ID_HIDDEN : $bid_details['username'] . user_pics($bid_details['user_id'])) /*add feedback*/ .
    		(($bid_details['rp_winner'] && !$bid_details['bid_out']) ? '[ <span class="greenfont">' . MSG_RP_WINNER . '</span> ]' : '') .
			'	</td>'.
			'	<td align="center">' . $fees->display_amount($bid_details['bid_amount'], $item_details['currency']) . $reserve_icons .'</td>'.
			(($session->value('adminarea')=='Active') ? '<td align="center">' . $fees->display_amount($bid_details['bid_proxy'], $item_details['currency']) . '</td>' : '').
    		'	<td align="center">' . show_date($bid_details['bid_date']) . '</td>';

    	if ($item_details['quantity']>1)
    	{
    		$bid_history_content .= '<td align="center" class="contentfont">' . $bid_details['quantity'];

    		if (!$bid_details['bid_out'])
    		{
    			$bid_history_content .= ($remaining_quantity >= $bid_details['quantity']) ? ' (' . $bid_details['quantity'] . ')' : ' (' . $remaining_quantity . ')';
	    		$remaining_quantity -= $bid_details['quantity'];
    		}
    		else
    		{
    			$bid_history_content .= ' (0)';
    		}
    		$bid_history_content .= '</td> ';
		}

		if ($item_details['owner_id']==$session->value('user_id') && $setts['enable_bid_retraction'])
		{
			if ($item_details['closed']==0 && $item_details['deleted']==0)
			{
				if ($item->under_time($item_details))
				{
					$bid_history_content .= '<td align="center">' . GMSG_NA . '</td>';					
				}
				else 
				{
					$bid_history_content .= '<td align="center" class="contentfont"> '.
						'	[ <a href="' . process_link('bid_history', array('option' => 'retract_bid', 'bidder_id' => $bid_details['bidder_id'], 'auction_id' => $item_details['auction_id'])) . '" onclick="return confirm(\'' . MSG_RETRACT_CONFIRM_ADMIN . '\');">' . MSG_RETRACT_BID . '</a> ]</td>';
				}
			}
			else
			{
				$bid_history_content .= '<td align=center>' . MSG_REMOVAL_IMPOSSIBLE . '</td>';
			}
		}
		$bid_history_content .= '</tr> ';

		$template->set('bid_history_content', $bid_history_content);
	}

	$template_output .= $template->process('bid_history.tpl.php');
}
else
{
	$template->set('message_header', header5(MSG_VIEW_BID_HISTORY));
	$template->set('message_content', '<p align="center">' . MSG_AUCTION_DETAILS_ERROR_CONTENT . '</p>');

	$template_output .= $template->process('single_message.tpl.php');
}

include_once ('global_footer.php');

echo $template_output;
?>