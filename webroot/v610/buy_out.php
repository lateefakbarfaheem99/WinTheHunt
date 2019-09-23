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

	$actions_array = array('buy_out_confirm', 'buy_out_submit', 'buy_out_success', 'buy_out_error');
	$action = (in_array($_REQUEST['action'], $actions_array)) ? $_REQUEST['action'] : 'buy_out_confirm';


	$item_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "auctions WHERE auction_id='" . intval($_REQUEST['auction_id']) . "'");

	$user_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);
	$template->set('user_details', $user_details);	
	
	$voucher_details = null;
	$voucher_code = $db->rem_special_chars($_REQUEST['voucher_code']);
	
	if (!empty($voucher_code))
	{
		$voucher_details = $item->check_voucher($voucher_code, 'seller_voucher', false, $item_details['owner_id']);
		$template->set('check_voucher_message', $voucher_details['display']);			
	}
	
	$quantity = ($_REQUEST['quantity']) ? $_REQUEST['quantity'] : 1;

	$blocked_user = blocked_user($session->value('user_id'), $item_details['owner_id']);

	$force_payment_enabled = force_payment_enabled($item_details['owner_id'], $item_details);
	if ($force_payment_enabled)
	{
		$template->set('force_payment_expl', '<div class="border c3" style="padding: 5px;">' . MSG_BUYOUT_FORCE_PAYMENT_ALERT_BUYER . '</div>');	
	}
		
	if (!show_buyout($item_details) || $session->is_set('buyout_id') || $session->value('user_id') == $item_details['owner_id'] || $blocked_user)
	{
		$action = 'buy_out_error';
	}
	else if ($quantity>$item_details['quantity'])
	{
		$action = 'buy_out_confirm';
		$template->set('buy_out_error_message', '<p align="center">' . MSG_NOT_ENOUGH_QUANTITY_BUYOUT . '</p>');
	}
	else if ($action == 'buy_out_submit')
	{## PHP Pro Bid v6.00 check if another bid is in progress, if not mark as in progress
		$bid_loop = 1;
		$bid_placement_time = time(); // we will wait for 5 seconds and then place the bid, even if bid_in_progress = 1;

		while ($bid_loop == 1)
		{
			$bid_loop = $db->get_sql_field("SELECT bid_in_progress FROM " . DB_PREFIX . "auctions WHERE
				auction_id='" . $item_details['auction_id'] . "'",'bid_in_progress');

			$bid_current_time = time();

			$bid_loop = (($bid_current_time - $bid_placement_time) > 5) ? 0 : $bid_loop;

			if ($bid_loop)
			{
				sleep(1);## PHP Pro Bid v6.00 we dont want to create a huge load on the database.
			}
		}

		$mark_in_progress = $db->query("UPDATE " . DB_PREFIX . "auctions SET
			bid_in_progress=1 WHERE auction_id='" . $item_details['auction_id'] . "'");## PHP Pro Bid v6.00 we will assign the winner, and then close the auction if the case.

		$session->set('buyout_id', $_REQUEST['auction_id']);

		$purchase_result = $item->assign_winner($item_details, 'buy_out', $session->value('user_id'), $quantity, null, $force_payment_enabled, $voucher_code);
		
		if ($purchase_result['auction_close'])
		{
			$item->close($item_details);
		}

		$unmark_in_progress = $db->query("UPDATE " . DB_PREFIX . "auctions SET
			bid_in_progress=0 WHERE auction_id='" . $item_details['auction_id'] . "'");

		$action = 'buy_out_success';
	}

	$template->set('item_details', $item_details);

	(string) $buy_out_page_content = null;## PHP Pro Bid v6.00 now we display the page
	if (!$item_details || $action == 'buy_out_error')
	{
		$template->set('buy_out_header_message', header5(MSG_ERROR));
		if ($blocked_user)
		{
			$buy_out_page_content = block_reason($session->value('user_id'), $item_details['owner_id']);
		}
		else if ($session->is_set('buyout_id'))
		{
			$buy_out_page_content = '<p align="center" class="contentfont">' . MSG_DOUBLE_POST_ERROR . '</p>';
		}
		else
		{
			$buy_out_page_content = '<p align="center" class="contentfont">' . MSG_CANT_BUYOUT_ITEM . '</p>';
		}
	}
	else if ($action == 'buy_out_confirm')
	{
		$template->set('buy_out_header_message', header5(GMSG_BUYOUT));

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

		$template->set('action', 'buy_out_submit');

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
		
		$buy_out_page_content = $template->process('buy_out_confirm.tpl.php');
	}
	else if ($action == 'buy_out_success')
	{
		$template->set('buy_out_header_message', header5(MSG_PURCHASE_SUCCESS));

		if (!empty($voucher_code))
		{
			$voucher_fee = new fees();
			$voucher_fee->setts = &$setts;
			
			if ($voucher_details['reduction'] > 0 && $voucher_details['valid'])
			{
				$item_details['buyout_price'] = $voucher_fee->round_number($item_details['buyout_price'] - ($item_details['buyout_price'] * $voucher_details['reduction'] / 100));
			}
			$template->set('item_details', $item_details);
		}

		$buy_out_success_message = '<p align="center" class="contentfont"><b>' . MSG_PURCHASE_SUCCESS_EXPL . '</b></p>'.
			'<p align="center" class="contentfont">[ <a href="other_items.php?owner_id=' . $user_details['user_id'] . '">' . MSG_CONTINUE_SHOPPING . '</a> ]</p>';
		$template->set('buy_out_success_message', $buy_out_success_message);

		$direct_payment_box = $item->direct_payment_box($item_details, $session->value('user_id'), $purchase_result['winner_id']);
		$template->set('direct_payment_box', $direct_payment_box[0]);

		$template->set('quantity', $quantity);

		$buy_out_page_content = $template->process('buy_out_success.tpl.php');
	}

	$template->set('buy_out_page_content', $buy_out_page_content);
	$template_output .= $template->process('buy_out.tpl.php');

	include_once ('global_footer.php');

	echo $template_output;
}
?>