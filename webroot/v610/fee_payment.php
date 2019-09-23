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

if (!$session->value('user_id'))
{
	header_redirect('login.php');
}
else
{
	require ('global_header.php');

	//$msg_changes_saved = '<p align="center" class="contentfont">' . MSG_CHANGES_SAVED . '</p>';

	$template->set('members_area_header', header7(MSG_MEMBERS_AREA_TITLE));

	$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id='" . $session->value('user_id') . "'");

	if ($_REQUEST['do'] == 'clear_balance')
	{
		$fee_type_message = ' - ' . MSG_CLEAR_ACC_BALANCE;

		$balance_fee = new fees();
		$balance_fee->setts = &$setts;

		$user_payment_mode = $fees->user_payment_mode($session->value('user_id'));

		if ($user_payment_mode == 2 && (($user_details['balance']>=$setts['min_invoice_value']) || ($user_details['balance']>0 && $session->value('membersarea') != 'Active')))
		{
			$payment_table_display = $balance_fee->clear_balance($session->value('user_id'), $user_details['balance']);
		}
		else
		{
			$payment_table_display = MSG_ERROR_FEE_PAYMENT_CLEAR_BALANCE;
		}
		$template->set('payment_table_display', $payment_table_display);
	}
	else if ($_REQUEST['do'] == 'credit_account')
	{
		$fee_type_message = ' - ' . MSG_CREDIT_ACCOUNT;

		$balance_fee = new fees();
		$balance_fee->setts = &$setts;

		$user_payment_mode = $fees->user_payment_mode($session->value('user_id'));

		if ($user_payment_mode == 2 && $_REQUEST['credit_amount'] > 0)
		{
			$payment_table_display = $balance_fee->clear_balance($session->value('user_id'), $_REQUEST['credit_amount'], $setts['sitename'] . $fee_type_message);
		}
		else
		{
			$payment_table_display = MSG_ERROR_FEE_PAYMENT_CLEAR_BALANCE;
		}
		$template->set('payment_table_display', $payment_table_display);
	}
	else if ($_REQUEST['do'] == 'subscription_payment')
	{
		$fee_type_message = ' - ' . GMSG_SUBSCRIPTION_PAYMENT;

		$subscr_fee = new fees();
		$subscr_fee->setts = &$setts;

		$is_account = $db->get_sql_number("SELECT a.account_id FROM
			" . DB_PREFIX . "user_accounts a, " . DB_PREFIX . "users u WHERE
			u.account_id=a.account_id AND a.active=1 AND u.user_id=" . $session->value('user_id'));

		if ($is_account)
		{
			$output = $subscr_fee->signup($session->value('user_id'));
			$payment_table_display = $output['display'];
		}
		else
		{
			$payment_table_display = MSG_ERROR_SUBSCRIPTION_PAYMENT;
		}
		$template->set('payment_table_display', $payment_table_display);

	}
	else if ($_REQUEST['do'] == 'setup_fee_payment')
	{
		$fee_type_message = ' - ' . GMSG_SETUP_FEES;

		$setup_fee = new fees();
		$setup_fee->setts = &$setts;
		$setup_fee->live_setup_fee = true;
		
		$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE
			auction_id='" . intval($_REQUEST['auction_id']) . "' AND owner_id='" . $session->value('user_id') . "'");

		$setup_fee->rollback_auction_id = $item_details['auction_id'];		
		
		## add nb of images and videos so the fees for these features are also paid.
		$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
			user_id='" . $session->value('user_id') . "'");

		$fee_output = $setup_fee->setup($user_details, $item_details, null, $item_details['is_relisted_item'], true);

		$template->set('payment_table_display', $fee_output['display']);
	}
	else if ($_REQUEST['do'] == 'sale_fee_payment')
	{
		$fee_type_message = ' - ' . GMSG_ENDAUCTION_FEE;

		$sale_fee = new fees();
		$sale_fee->setts = &$setts;

		$winning_bid_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "winners WHERE winner_id='" . intval($_REQUEST['winner_id']) . "' AND
			(seller_id=" . $session->value('user_id') . " OR buyer_id=" . $session->value('user_id') . ")");

		$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE
			auction_id='" . $winning_bid_details['auction_id'] . "'");## PHP Pro Bid v6.00 since the buyer could also pay for the end of auction fee.

		$fee_output = $sale_fee->sale($winning_bid_details, $item_details);

		$template->set('payment_table_display', $fee_output['display']);

	}
	else if ($_REQUEST['do'] == 'wa_setup_fee_payment')
	{
		$fee_type_message = ' - ' . GMSG_WA_SETUP_FEE;

		$setup_fee = new fees();
		$setup_fee->setts = &$setts;

		$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "wanted_ads WHERE
			wanted_ad_id='" . intval($_REQUEST['wanted_ad_id']) . "' AND owner_id='" . $session->value('user_id') . "'");

		$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
			user_id='" . $session->value('user_id') . "'");

		$fee_output = $setup_fee->wanted_ad_setup($user_details, $item_details);

		$template->set('payment_table_display', $fee_output['display']);
	}
	else if ($_REQUEST['do'] == 'invoice_direct_payment')
	{
		$item = new item();
		$item->setts = &$setts;
		
		$fee_type_message = ' - ' . MSG_DIRECT_PAYMENT . ' [ ' . MSG_INVOICE_ID . ': ' . $_REQUEST['invoice_id'] . ' ]';
		
		$sql_select_products = $db->query("SELECT w.*, a.name, 
			a.direct_payment, a.currency, a.owner_id, a.apply_tax FROM " . DB_PREFIX . "winners w 
			LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id WHERE 
			w.invoice_id='" . intval($_REQUEST['invoice_id']) . "' AND w.buyer_id='" . $session->value('user_id') . "'");
					
		(array) $dp_array = null;
		(array) $items_array = null;
					
		while ($item_details = $db->fetch_array($sql_select_products)) 
		{
			$items_array[] = $item_details;
			$dp_array[] = ($item_details['direct_payment']) ? @explode(',', $item_details['direct_payment']) : null;
		}
					
		(string) $direct_payment_link = null;
		$payment_table_display = $item->direct_payment_multiple_box($_REQUEST['invoice_id'], $items_array, $dp_array, $session->value('user_id'));
		
		
		$template->set('payment_table_display', $payment_table_display);
	}
	else if ($_REQUEST['do'] == 'store_subscription_payment')
	{
		$fee_type_message = ' - ' . GMSG_STORE_SUBSCRIPTION_PAYMENT;

		$store_fee = new fees();
		$store_fee->setts = &$setts;

		$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
			user_id='" . $session->value('user_id') . "'");

		$fee_output = $store_fee->store_subscription($user_details['shop_account_id'], $session->value('user_id'));

		$template->set('payment_table_display', $fee_output['display']);
	}
	else if ($_REQUEST['do'] == 'seller_verification')
	{
		$fee_type_message = ' - ' . GMSG_SELLER_VERIFICATION_PAYMENT;

		$verification_fee = new fees();
		$verification_fee->setts = &$setts;

		$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
			user_id='" . $session->value('user_id') . "'");

		$fee_output = $verification_fee->seller_verification($session->value('user_id'));

		$template->set('payment_table_display', $fee_output['display']);
	}
	else if ($_REQUEST['do'] == 'bidder_verification')
	{
		$fee_type_message = ' - ' . GMSG_BIDDER_VERIFICATION_PAYMENT;

		$verification_fee = new fees();
		$verification_fee->setts = &$setts;

		$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
			user_id='" . $session->value('user_id') . "'");

		$fee_output = $verification_fee->bidder_verification($session->value('user_id'));

		$template->set('payment_table_display', $fee_output['display']);
	}
	else if ($_REQUEST['do'] == 'reverse_setup_fee_payment')
	{
		$fee_type_message = ' - ' . GMSG_REVERSE_SETUP_FEES;

		$setup_fee = new fees(true);
		$setup_fee->setts = &$setts;
		$setup_fee->live_setup_fee = true;
		
		$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "reverse_auctions WHERE
			reverse_id='" . intval($_REQUEST['reverse_id']) . "' AND owner_id='" . $session->value('user_id') . "'");

		$setup_fee->rollback_auction_id = $item_details['reverse_id'];		
		
		## add nb of images and videos so the fees for these features are also paid.
		$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
			user_id='" . $session->value('user_id') . "'");

		$fee_output = $setup_fee->reverse_setup($user_details, $item_details, null, false, true);

		$template->set('payment_table_display', $fee_output['display']);
	}
	else if ($_REQUEST['do'] == 'reverse_bid_fee_payment')
	{
		$fee_type_message = ' - ' . GMSG_REVERSE_BID_FEE;

		$sale_fee = new fees(true);
		$sale_fee->setts = &$setts;

		$bid_id = intval($_REQUEST['bid_id']);
		
		$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
			user_id='" . $session->value('user_id') . "'");

		$item_details = $db->get_sql_row("SELECT r.* 
			FROM " . DB_PREFIX . "reverse_auctions r, " . DB_PREFIX . "reverse_bids b 
			WHERE	b.bid_id='" . $bid_id . "' AND b.bidder_id='" . $session->value('user_id') . "' AND 
			r.reverse_id=b.reverse_id");

		$fee_output = $sale_fee->reverse_bid($user_details, $item_details, $bid_id);

		$template->set('payment_table_display', $fee_output['display']);

	}	else if ($_REQUEST['do'] == 'reverse_sale_fee_payment')
	{
		$fee_type_message = ' - ' . GMSG_REVERSE_ENDAUCTION_FEE;

		$sale_fee = new fees(true);
		$sale_fee->setts = &$setts;

		$winning_bid_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "reverse_winners WHERE winner_id='" . intval($_REQUEST['winner_id']) . "' AND
			(poster_id=" . $session->value('user_id') . " OR provider_id=" . $session->value('user_id') . ")");

		$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "reverse_auctions WHERE
			reverse_id='" . $winning_bid_details['reverse_id'] . "'");## PHP Pro Bid v6.00 since the buyer could also pay for the end of auction fee.

		$fee_output = $sale_fee->reverse_endauction($winning_bid_details, $item_details);

		$template->set('payment_table_display', $fee_output['display']);

	}

	$template->set('fee_payment_header', headercat(MSG_FEE_PAYMENT . $fee_type_message));

	$template_output .= $template->process('fee_payment.tpl.php');

	include_once ('global_footer.php');

	echo $template_output;
}
?>