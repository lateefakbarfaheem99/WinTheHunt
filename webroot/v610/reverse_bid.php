<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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

if ($session->value('membersarea') != 'Active')
{
	header_redirect('login.php?redirect=reverse_details.php?reverse_id=' . $_REQUEST['reverse_id']);
}
else
{
	require ('global_header.php');

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;

	$template->set('session', $session);
	$template->set('item', $item);

	$actions_array = array('bid_confirm', 'bid_submit', 'bid_success', 'bid_error');
	$action = (in_array($_REQUEST['action'], $actions_array)) ? $_REQUEST['action'] : 'bid_confirm';

	$max_bid = numeric_format($_REQUEST['max_bid']);
	$max_bid = ($max_bid>0 && is_numeric($max_bid)) ? $max_bid : 0;
	$description = $db->rem_special_chars($_POST['description']);
	$delivery_days = intval($_REQUEST['delivery_days']);
	$apply_tax = intval($_REQUEST['apply_tax']);

	$item_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "reverse_auctions WHERE reverse_id='" . intval($_REQUEST['reverse_id']) . "'");

	$user_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);
	$bidder_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "users WHERE user_id=" . $session->value('user_id'));
	
	$template->set('user_details', $user_details);	
	
	$item_can_bid = $item->reverse_can_bid($session->value('user_id'), $item_details, $max_bid);

	$blocked_user = blocked_user($session->value('user_id'), $item_details['owner_id']);

	$tax = new tax();
	$can_add_tax = $tax->can_add_tax($session->value('user_id'), $setts['enable_tax']);
	$template->set('can_add_tax', $can_add_tax['can_add_tax']);
	
	$bid_id = null;
	if ($session->is_set('reverse_bid_id') || $blocked_user)
	{
		$action = 'bid_error';
	}
	else if ($action == 'bid_submit')
	{
		if ($item_can_bid['result'] && !empty($description))
		{
			$bid_id = $item->reverse_bid($item_details, $session->value('user_id'), $max_bid, $description, $delivery_days, $apply_tax);

			$session->set('reverse_bid_id', $_REQUEST['reverse_id']);

			$action = 'bid_success';
		}
		else
		{
			if (empty($description))
			{
				$item_can_bid['display'] = MSG_BID_DESCRIPTION_EMPTY;
			}
			$action = 'bid_confirm';
		}
	}

	$template->set('item_details', $item_details);
	$template->set('description', $description);
	$template->set('delivery_days', $delivery_days);

	(string) $bidding_page_content = null;
	if (!$item_details || $action == 'bid_error')
	{
		$template->set('bid_header_message', header5(MSG_ERROR));

		if ($blocked_user)
		{
			$bidding_page_content = block_reason($session->value('user_id'), $item_details['owner_id']);
		}
		else if ($session->is_set('bid_id'))
		{
			$bidding_page_content = '<p align="center" class="contentfont">' . MSG_DOUBLE_POST_ERROR . '</p>';
		}
		else
		{
			$bidding_page_content = '<p align="center" class="contentfont">' . MSG_CANT_BID_ON_ITEM . '</p>';
		}
	}
	else if ($action == 'bid_confirm')
	{
		$template->set('bidding_error_message', '<p align="center" class="contentfont">' . $item_can_bid['display'] . '</p>');

		$template->set('bid_header_message', header5(MSG_CONFIRM_BID));

		$template->set('max_bid', $max_bid);

		$template->set('action', 'bid_submit');

		$bidding_page_content = $template->process('reverse_bid_confirm.tpl.php');
	}
	else if ($action == 'bid_success')
	{
		$template->set('bid_header_message', header5(MSG_BID_SUCCESS));

		$bidding_success_message = '<p align="center" class="contentfont"><b>' . $bid_sucess_msg . '</b></p>';
		$template->set('bidding_success_message', $bidding_success_message);
		$template->set('max_bid', $max_bid);

		// now also pay for the bid.
		$bid_fee = new fees(true);
		$bid_fee->setts = &$setts;
		$bid_fee->reverse_auction = true;	
		
		$fee_result = $bid_fee->reverse_bid($bidder_details, $item_details, $bid_id);
		$template->set('reverse_bid_output', $fee_result['display']);

		$bidding_page_content = $template->process('reverse_bid_success.tpl.php');
	}

	$template->set('bidding_page_content', $bidding_page_content);
	$template_output .= $template->process('reverse_bid.tpl.php');

	include_once ('global_footer.php');

	echo $template_output;
}
?>