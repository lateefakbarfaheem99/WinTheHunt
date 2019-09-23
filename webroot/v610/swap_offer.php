<?
#################################################################
## PHP Pro Bid v6.06															##
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

if ($session->value('membersarea') != 'Active')
{
	header_redirect('login.php?redirect=auction_details.php?auction_id=' . $_REQUEST['auction_id']);
}
else
{
	require ('global_header.php');

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;

	//$template->set('fees', $fees);
	$template->set('session', $session);
	$template->set('item', $item);

	$actions_array = array('swap_offer_confirm', 'swap_offer_submit', 'swap_offer_success', 'swap_offer_error');
	$action = (in_array($_REQUEST['action'], $actions_array)) ? $_REQUEST['action'] : 'swap_offer_confirm';


	$item_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "auctions WHERE auction_id='" . intval($_REQUEST['auction_id']) . "'");

	$user_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);
	$template->set('user_details', $user_details);	
	
	$quantity = ($_REQUEST['quantity']) ? $_REQUEST['quantity'] : 1;
	$description = $db->rem_special_chars($_POST['description']);

	$blocked_user = blocked_user($session->value('user_id'), $item_details['owner_id']);

	if (!$item_details['enable_swap'] || $session->is_set('swap_offer_id') || $session->value('user_id') == $item_details['owner_id'] || $blocked_user)
	{
		$action = 'swap_offer_error';
	}
	else if ($quantity>$item_details['quantity'])
	{
		$action = 'swap_offer_confirm';
		$template->set('swap_offer_error_message', '<p align="center">' . MSG_NOT_ENOUGH_QUANTITY_SWAP . '</p>');
	}
	else if ($action == 'swap_offer_submit')
	{
		if (!empty($_POST['description']))
		{## PHP Pro Bid v6.00 we will save the offer in the 'auction_offers' table
			$item->place_offer($item_details, $session->value('user_id'), $description, $quantity, 'swap_offer');

			$session->set('swap_offer_id', $_REQUEST['auction_id']);

			$action = 'swap_offer_success';
		}
		else
		{
			$action = 'swap_offer_confirm';
			$template->set('swap_offer_error_message', '<p align="center">' . MSG_ERROR_DESC_EMPTY . '</p>');
		}
	}

	$template->set('item_details', $item_details);
	$template->set('description', $description);

	(string) $swap_offer_page_content = null;## PHP Pro Bid v6.00 now we display the page
	if (!$item_details || $action == 'swap_offer_error')
	{
		$template->set('swap_offer_header_message', header5(MSG_ERROR));
		if ($blocked_user)
		{
			$swap_offer_page_content = block_reason($session->value('user_id'), $item_details['owner_id']);
		}
		else if ($session->is_set('swap_offer_id'))
		{
			$swap_offer_page_content = '<p align="center" class="contentfont">' . MSG_DOUBLE_POST_ERROR . '</p>';
		}
		else
		{
			$swap_offer_page_content = '<p align="center" class="contentfont">' . MSG_CANT_SWAPOFFER_ITEM . '</p>';
		}
	}
	else if ($action == 'swap_offer_confirm')
	{
		$template->set('swap_offer_header_message', header5(GMSG_OFFER_SWAP));

		if (!empty($item_details['direct_payment']))
		{
			$dp_methods = $item->select_direct_payment($item_details['direct_payment'], $user_details['user_id'], true, true);

			$template->set('direct_payment_methods_display', $db->implode_array($dp_methods, ', '));
		}

		if (!empty($item_details['payment_methods']))
		{
			$offline_payments = $item->select_offline_payment($item_details['payment_methods'], true, true);

			$template->set('offline_payment_methods_display', $db->implode_array($offline_payments, ', '));
		}

		/*
		$tax = new tax();
		$auction_tax = $tax->auction_tax($item_details['owner_id'], $setts['enable_tax'], $session->value('user_id'));
		$template->set('auction_tax', $auction_tax);
		*/

		$template->set('quantity', $quantity);

		$template->set('action', 'swap_offer_submit');

		$swap_offer_page_content = $template->process('swap_offer_confirm.tpl.php');
	}
	else if ($action == 'swap_offer_success')
	{
		$template->set('swap_offer_header_message', header5(MSG_SWAPOFFER_SUCCESS));

		$swap_offer_page_content = '<p align="center" class="contentfont"><b>' . MSG_MAKEOFFER_SUCCESS_EXPL . '</b></p>';

		$template->set('quantity', $quantity);
	}

	$template->set('swap_offer_page_content', $swap_offer_page_content);
	$template_output .= $template->process('swap_offer.tpl.php');

	include_once ('global_footer.php');

	echo $template_output;
}
?>