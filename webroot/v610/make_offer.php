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

	$actions_array = array('make_offer_confirm', 'make_offer_submit', 'make_offer_success', 'make_offer_error');
	$action = (in_array($_REQUEST['action'], $actions_array)) ? $_REQUEST['action'] : 'make_offer_confirm';


	$item_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "auctions WHERE auction_id='" . intval($_REQUEST['auction_id']) . "'");

	$user_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);
	$template->set('user_details', $user_details);		
	
	$quantity = ($_REQUEST['quantity']) ? $_REQUEST['quantity'] : 1;
	$amount = numeric_format($_POST['amount']);

	$blocked_user = blocked_user($session->value('user_id'), $item_details['owner_id']);

	if (!show_makeoffer($item_details) || $session->is_set('make_offer_id') || $session->value('user_id') == $item_details['owner_id'] || $blocked_user)
	{
		$action = 'make_offer_error';
	}
	else if (!$item->check_bidding_limit($item_details['auction_id'], $session->value('user_id'), $item_details['owner_id'], 'make_offer'))
	{
		$action = 'make_offer_confirm';
		$template->set('make_offer_error_message', '<p align="center" class="errormessage">' . MSG_CANTBID_OFFER_LIMIT_REACHED . '</p>');		
	}
	else if ($quantity>$item_details['quantity'])
	{
		$action = 'make_offer_confirm';
		$template->set('make_offer_error_message', '<p align="center">' . MSG_NOT_ENOUGH_QUANTITY_BUYOUT . '</p>');
	}
	else if ($action == 'make_offer_submit')
	{		
		if ($item->can_place_offer($item_details, $_POST['amount']))
		{## PHP Pro Bid v6.00 we will save the offer in the 'auction_offers' table
			$item->place_offer($item_details, $session->value('user_id'), $amount, $quantity);

			$session->set('make_offer_id', $_REQUEST['auction_id']);

			$action = 'make_offer_success';
		}
		else
		{
			$action = 'make_offer_confirm';
			$template->set('make_offer_error_message', '<p align="center">' . MSG_OFFER_NOT_IN_RANGE . '</p>');
		}
	}

	$template->set('item_details', $item_details);
	$template->set('amount', $amount);

	(string) $make_offer_page_content = null;## PHP Pro Bid v6.00 now we display the page
	if (!$item_details || $action == 'make_offer_error')
	{
		$template->set('make_offer_header_message', header5(MSG_ERROR));
		if ($blocked_user)
		{
			$make_offer_page_content = block_reason($session->value('user_id'), $item_details['owner_id']);
		}
		else if ($session->is_set('make_offer_id'))
		{
			$make_offer_page_content = '<p align="center" class="contentfont">' . MSG_DOUBLE_POST_ERROR . '</p>';
		}
		else
		{
			$make_offer_page_content = '<p align="center" class="contentfont">' . MSG_CANT_MAKEOFFER_ITEM . '</p>';
		}
	}
	else if ($action == 'make_offer_confirm')
	{
		$template->set('make_offer_header_message', header5(GMSG_MAKE_OFFER));

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

		$tax = new tax();
		$auction_tax = $tax->auction_tax($item_details['owner_id'], $setts['enable_tax'], $session->value('user_id'));
		$template->set('auction_tax', $auction_tax);

		$template->set('quantity', $quantity);

		$template->set('action', 'make_offer_submit');

		/* warn if the seller doesnt ship in the buyers location */
		$shipping_locations_warning = null;
		if ($user_details['pc_shipping_locations'] == 'local')
		{
			$buyer_details = $db->get_sql_row("SELECT country, state FROM " . DB_PREFIX . "users WHERE user_id='" . $session->value('user_id') . "'");
			
			$loc_details = user_location($user_details['user_id'], $buyer_details['country'], $buyer_details['state']);
			
			if (!$loc_details['valid'])
			{
				$shipping_locations_warning = '<tr><td></td><td>' . MSG_SHIPPING_LOCATION_UNSUPPORTED_WARNING . '</td></tr>';
			}
		}
		$template->set('shipping_locations_warning', $shipping_locations_warning);		
		
		$make_offer_page_content = $template->process('make_offer_confirm.tpl.php');
	}
	else if ($action == 'make_offer_success')
	{
		$template->set('make_offer_header_message', header5(MSG_MAKEOFFER_SUCCESS));

		$make_offer_success_message = '<p align="center" class="contentfont"><b>' . MSG_MAKEOFFER_SUCCESS_EXPL . '</b></p>';
		$template->set('make_offer_success_message', $make_offer_success_message);

		$template->set('quantity', $quantity);

		$make_offer_page_content = $template->process('make_offer_success.tpl.php');
	}

	$template->set('make_offer_page_content', $make_offer_page_content);
	$template_output .= $template->process('make_offer.tpl.php');

	include_once ('global_footer.php');

	echo $template_output;
}
?>