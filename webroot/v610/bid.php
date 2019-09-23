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

	$actions_array = array('bid_confirm', 'bid_submit', 'bid_success_proxy', 'bid_success', 'bid_error');
	$action = (in_array($_REQUEST['action'], $actions_array)) ? $_REQUEST['action'] : 'bid_confirm';

	$max_bid = numeric_format($_REQUEST['max_bid']);
	$max_bid = ($max_bid>0 && is_numeric($max_bid)) ? $max_bid : 0;

	$item_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "auctions WHERE auction_id='" . intval($_REQUEST['auction_id']) . "'");

	$quantity = ($item_details['auction_type'] == 'dutch') ? $_REQUEST['quantity'] : 1;
	
	if ($item_details['auction_type'] == 'first_bidder')
	{
		$max_bid = $item_details['fb_current_bid'];	
	}
	
	$user_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);
	$template->set('user_details', $user_details);	
	
	$minimum_bid = $item->min_bid_amount($item_details);
	$item->min_bid = $minimum_bid;

	$template->set('minimum_bid', $minimum_bid);

	$item_can_bid = $item->can_bid($session->value('user_id'), $item_details, $max_bid, $minimum_bid);

	/**
	 * first we need to establish the value of the $action variable:
	 * IF: bid_submit & can_bid = true: proceed with the bid
	 * IF: bid_submit & can_bid & user = high bidder: bid_proxy
	 * IF: bid_submit & !can_bid: bid_confirm
	 */
	$blocked_user = blocked_user($session->value('user_id'), $item_details['owner_id']);

	if ($session->is_set('bid_id') || $blocked_user)
	{
		$action = 'bid_error';
	}
	else if ($action == 'bid_submit')
	{
		if ($item_can_bid['result'])
		{## PHP Pro Bid v6.00 check if another bid is in progress, if not mark as in progress
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
				bid_in_progress=1 WHERE auction_id='" . $item_details['auction_id'] . "'");

			$proxy_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "proxybid WHERE
				auction_id=" . $item_details['auction_id']);

			if ($setts['enable_proxy_bidding'] && $session->value('user_id') == $proxy_details['bidder_id'] && $item_details['auction_type'] == 'standard')
			{## PHP Pro Bid v6.00 we have a proxy bid increase
				$proxy_bid_result = $item->bid_update_proxy($max_bid, $item_details, $proxy_details);

				if ($proxy_bid_result)
				{
					$action = 'bid_success_proxy';
					$session->set('bid_id', $_REQUEST['auction_id']);

					$item_details = $db->get_sql_row("SELECT * FROM
						" . DB_PREFIX . "auctions WHERE auction_id='".$_REQUEST['auction_id']."'");
				}
				else
				{
					$action = 'bid_confirm';
					// we will override the below value to match the proxy error.
					$item_can_bid['display'] = MSG_PROXY_TOO_LOW . ' (' . $fees->display_amount($proxy_details['bid_amount'], $item_details['currency']) . ')';
				}
			}
			else
			{## PHP Pro Bid v6.00 we have a new bid
				$bid_result = $item->bid($max_bid, $quantity, $session->value('user_id'), $item_details, $proxy_details);

				if ($bid_result['result'])
				{
					$action = 'bid_success';
					$session->set('bid_id', $_REQUEST['auction_id']);
					$bid_sucess_msg = ($bid_result['display']) ? $bid_result['display'] : MSG_BID_SUCCESSFUL;

					if ($item_details['auction_type'] == 'first_bidder')
					{
						$purchase_result = $item->assign_winner($item_details, 'first_bidder', $session->value('user_id'), $quantity);
						
						if ($purchase_result['auction_close'])
						{
							$item->close($item_details);
							$bid_sucess_msg = MSG_FB_PURCHASE_SUCCESS_EXPL;
						}
					}
										
					$item_details = $db->get_sql_row("SELECT * FROM
						" . DB_PREFIX . "auctions WHERE auction_id='".$_REQUEST['auction_id']."'");
					
					$mail_bidder_id = $session->value('user_id');
					$mail_input_id = $item_details['auction_id'];
					include('language/' . $setts['site_lang'] . '/mails/bid_seller_notification.php');## PHP Pro Bid v6.00 email all users watching this auction that a bid was placed.
					include('language/' . $setts['site_lang'] . '/mails/auction_watch_notification.php');## PHP Pro Bid v6.00 email all outbid bidders that they were outbid
					include('language/' . $setts['site_lang'] . '/mails/outbid_bidder_notification.php');## PHP Pro Bid v6.00 now mark all outbid rows as email sent
					$db->query("UPDATE " . DB_PREFIX . "bids SET email_sent=1 WHERE auction_id='" . $item_details['auction_id'] . "' AND 
						bid_out=1 AND bidder_id!='" . $session->value('user_id') . "'");
				}
				else
				{
					$action = 'bid_confirm';
					$item_can_bid['display'] = $bid_result['display'];

					$item_details = $db->get_sql_row("SELECT * FROM
						" . DB_PREFIX . "auctions WHERE auction_id='".$_REQUEST['auction_id']."'");

					$minimum_bid = $item->min_bid_amount($item_details);
				}
			}

			$unmark_in_progress = $db->query("UPDATE " . DB_PREFIX . "auctions SET
				bid_in_progress=0 WHERE auction_id='" . $item_details['auction_id'] . "'");
		}
		else
		{
			$action = 'bid_confirm';
		}
	}

	$template->set('item_details', $item_details);

	$template->set('minimum_bid', $minimum_bid);

	(string) $bidding_page_content = null;## PHP Pro Bid v6.00 now we display the page
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

		$template->set('max_bid', $max_bid);
		$template->set('quantity', $quantity);

		$template->set('action', 'bid_submit');
		
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
		

		$bidding_page_content = $template->process('bid_confirm.tpl.php');
	}
	else if ($action == 'bid_success')
	{
		$template->set('bid_header_message', header5(MSG_BID_SUCCESS));

		$bidding_success_message = '<p align="center" class="contentfont"><b>' . $bid_sucess_msg . '</b></p>';
		$template->set('bidding_success_message', $bidding_success_message);

		$bidding_page_content = $template->process('bid_success.tpl.php');
	}
	else if ($action == 'bid_success_proxy')
	{
		$template->set('bid_header_message', header5(MSG_BID_SUCCESS));

		$bidding_success_message = '<p align="center" class="contentfont"><b>' . MSG_PROXY_VALUE_UPDATED . '</b></p>';
		$template->set('bidding_success_message', $bidding_success_message);

		$bidding_page_content = $template->process('bid_success.tpl.php');
	}

	$template->set('bidding_page_content', $bidding_page_content);
	$template_output .= $template->process('bid.tpl.php');

	include_once ('global_footer.php');

	echo $template_output;
}
?>