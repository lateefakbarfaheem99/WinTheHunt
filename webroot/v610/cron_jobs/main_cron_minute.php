<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

if (!$manual_cron || IN_ADMIN == 1)
{
	include_once ('../includes/global.php');
	$parent_dir = '../';
}
else
{
	$parent_dir = '';
}

include_once ($parent_dir . 'includes/class_formchecker.php');
include_once ($parent_dir . 'includes/class_custom_field.php');
include_once ($parent_dir . 'includes/class_user.php');
include_once ($parent_dir . 'includes/class_fees.php');
include_once ($parent_dir . 'includes/class_shop.php');
include_once ($parent_dir . 'includes/class_item.php');
include_once ($parent_dir . 'includes/functions_item.php');
include_once ($parent_dir . 'includes/class_messaging.php');


$sql_select_cron_wa = $db->query("SELECT * FROM " . DB_PREFIX . "wanted_ads WHERE
	active=1 AND closed=0 AND end_time<'" . CURRENT_TIME . "' LIMIT 0, 50");

$nb_cron_wa = $db->num_rows($sql_select_cron_wa);

if ($nb_cron_wa)
{
	(array) $cron_wa = null;
	(array) $cron_wa_id = null;
	(array) $poster_counter = null;
	(array) $wa_counter = null;

	while ($wa_row = $db->fetch_array($sql_select_cron_wa))
	{
		## add counter removal
		wanted_counter($wa_row['category_id'], 'remove');
		wanted_counter($wa_row['addl_category_id'], 'remove');
		
		$cron_wa[] = $wa_row;
		$cron_wa_id[] = $wa_row['wanted_ad_id'];
	}

	$cron_wa_id_array = $db->implode_array($cron_wa_id);

	$db->query("UPDATE " . DB_PREFIX . "wanted_ads SET closed=1 WHERE
		wanted_ad_id IN (" . $cron_wa_id_array . ")");

	for ($i=0; $i<$nb_cron_wa; $i++)
	{
		$poster_counter[$cron_wa[$i]['owner_id']] ++; 
		$wa_counter[$cron_wa[$i]['owner_id']] = $cron_wa[$i]['wanted_ad_id']; 
	}
	
	foreach ($poster_counter as $key => $value)
	{
		if ($value == 1)
		{
			$mail_input_id = $wa_counter[$key];
			include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/wa_closed_seller_notification.php');
		}
		else if ($value > 1)
		{
			$mail_input_id = $key;
			include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/wa_closed_seller_notification_multiple.php');			
		}
	}
}
/**
 * Close auctions - relist/assign winners etc
 */

$cron_item = new item();
$cron_item->setts = &$setts;
$cron_item->layout = &$layout;

$cron_item->extension = $parent_dir;

/**
 * Possible solution to avoiding the cron to create more winner rows than necessary.
 * 
 * if there are any auctions that need to be closed, we will lock the auctions table for exclusive access so that no other
 * cron will try to read from the table and select and close the same auction 
 */

$db->query("LOCK TABLE " . DB_PREFIX . "auctions READ, " . DB_PREFIX . "auctions AS a_update WRITE");

## basically we will close up to 50 auctions at a time to avoid any server load.
$sql_select_cron_auctions = $db->query("SELECT * FROM " . DB_PREFIX . "auctions WHERE
	closed=0 AND deleted=0 AND 
	(
		(end_time<'" . CURRENT_TIME . "' AND auction_type!='first_bidder') OR 
		(reserve_price>=fb_current_bid AND auction_type='first_bidder')
	)
	AND close_in_progress=0 AND bid_in_progress=0 AND creation_in_progress=0	
	LIMIT 0, 50"); ## the query only uses where

$nb_cron_auctions = $db->num_rows($sql_select_cron_auctions);

if ($nb_cron_auctions)
{
	## create an array of the auctions
	(array) $cron_auction = null;
	(array) $cron_auction_id = null;
	(array) $seller_counter = null;
	(array) $auction_counter = null;

	while ($auction_row = $db->fetch_array($sql_select_cron_auctions))
	{
		$cron_auction[] = $auction_row;
		$cron_auction_id[] = $auction_row['auction_id']; ## used to mark close_in_progress.
	}

	$cron_auction_id_array = $db->implode_array($cron_auction_id);

	$db->query("UPDATE " . DB_PREFIX . "auctions AS a_update SET close_in_progress=1 WHERE
		auction_id IN (" . $cron_auction_id_array . ")");
}
$db->query("UNLOCK TABLES");

if ($nb_cron_auctions)
{
	for ($i=0; $i<$nb_cron_auctions; $i++)
	{
		$winner_output = $cron_item->assign_winner($cron_auction[$i]);

		$cron_item->close($cron_auction[$i], true);

		## only add to counter if no sale - the closed item notifs are made only if 
		## there was no sale for the item that was just closed
		if (!$winner_output['result'])
		{
			$seller_counter[$cron_auction[$i]['owner_id']] ++; 
			$auction_counter[$cron_auction[$i]['owner_id']] = $cron_auction[$i]['auction_id']; 
		}
	}
	
	if (count($seller_counter))
	{	
		foreach ($seller_counter as $key => $value)
		{
			if ($value == 1)
			{
				$mail_input_id = $auction_counter[$key];
				include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/no_sale_seller_notification.php');
			}
			else if ($value > 1)
			{
				$mail_input_id = $key;
				include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/no_sale_seller_notification_multiple.php');			
			}
		}
	}

	$db->query("UPDATE " . DB_PREFIX . "auctions SET close_in_progress=0 WHERE
		auction_id IN (" . $cron_auction_id_array . ")");
}

## start scheduled auctions
(array) $cron_scheduled_id = null;
$sql_select_sch_cron_items = $db->query("SELECT * FROM " . DB_PREFIX . "auctions WHERE 
	active=1 AND start_time<" . CURRENT_TIME . " AND end_time>" . CURRENT_TIME . " AND closed=1 AND approved=1 AND deleted=0");

while ($scheduled_item = $db->fetch_array($sql_select_sch_cron_items)) 
{
	$cron_scheduled_id[] = $scheduled_item['auction_id'];
}

if (count($cron_scheduled_id) > 0)
{
	$cron_scheduled_array = $db->implode_array($cron_scheduled_id);

	## auctions counter - add process - multiple auctions (start scheduled auctions)
	foreach ($cron_scheduled_id as $value)
	{
		$cnt_details = $db->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
			" . DB_PREFIX . "auctions WHERE auction_id='" . intval($value) . "'");

		if ($cnt_details['active'] == 1 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 1 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store')
		{
			auction_counter($cnt_details['category_id'], 'add', $cnt_details['auction_id']);
			auction_counter($cnt_details['addl_category_id'], 'add', $cnt_details['auction_id']);
		}
	}

	$db->query("UPDATE " . DB_PREFIX . "auctions SET closed=0 WHERE auction_id IN (" . $cron_scheduled_array . ")");
}

## inactivate stores - no items are inactivated!
$db->query("UPDATE " . DB_PREFIX . "users SET shop_active=0, store_expiration_email=0 WHERE shop_active=1 AND shop_account_id>0 AND 
	shop_next_payment>0 AND shop_next_payment<" . CURRENT_TIME);

## unverify sellers - no items are inactivated!
$db->query("UPDATE " . DB_PREFIX . "users SET seller_verified=0 WHERE seller_verified=1 AND 
	seller_verif_next_payment>0 AND seller_verif_next_payment<" . CURRENT_TIME);

$db->query("UPDATE " . DB_PREFIX . "users SET bidder_verified=0 WHERE bidder_verified=1 AND 
	bidder_verif_next_payment>0 AND bidder_verif_next_payment<" . CURRENT_TIME);

## email auction listed notifications to all relisted items
$is_relisted_items = $db->count_rows('auctions', "WHERE is_relisted_item=1 AND notif_item_relisted=0");

if ($is_relisted_items)
{
	include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/seller_relist_notification_multiple.php');
	$db->query("UPDATE " . DB_PREFIX . "auctions SET notif_item_relisted=1 WHERE 
		is_relisted_item=1 AND notif_item_relisted=0");
}

## suspend users in account mode that have their credit limit exceeded.
$remove_session = suspend_debit_users();
if ($remove_session)
{
	$session->unregister('membersarea');
}

/**
 * Workaround: unmark close_in_progress and bid_in_progress for auctions with the end_time which
 * expired 30 minutes ago and closed=0
 */

$half_hour = 60 * 30;
$db->query("UPDATE " . DB_PREFIX . "auctions SET bid_in_progress=0, close_in_progress=0 WHERE 
	closed=0 AND end_time<" . (CURRENT_TIME - $half_hour));

if ($setts['preferred_days'] > 0)
{
	$db->query("UPDATE " . DB_PREFIX . "users SET preferred_seller=0 WHERE 
		preferred_seller=1 AND preferred_seller_exp_date<" . CURRENT_TIME . " AND preferred_seller_exp_date>0");
}

// now revert any transactions for which temp_purchase=1
if ($setts['enable_force_payment'])
{
	$time_limit = CURRENT_TIME - $setts['force_payment_time'] * 60;
	
	$sql_select_reverted = $db->query("SELECT w.*, a.closed, a.deleted, 
		a.end_time, a.end_time_cron, a.auction_type FROM " . DB_PREFIX . "winners w 
		LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id 
		WHERE w.temp_purchase=1 AND w.purchase_date<" . $time_limit);
	
	while ($winner_details = $db->fetch_array($sql_select_reverted))
	{
		revert_sale($winner_details);
	}
} 

// alter the current bid value for first bidder auctions
$db->query("UPDATE " . DB_PREFIX . "auctions SET 
	fb_next_decrement=fb_next_decrement+fb_decrement_interval, 
	fb_current_bid=fb_current_bid-fb_decrement_amount WHERE 
	fb_next_decrement<'" . CURRENT_TIME . "' AND closed=0");

/* close reverse auctions */
$sql_select_cron_reverse = $db->query("SELECT * FROM " . DB_PREFIX . "reverse_auctions WHERE
	active=1 AND closed=0 AND end_time<'" . CURRENT_TIME . "' LIMIT 0, 50");

$nb_cron_reverse = $db->num_rows($sql_select_cron_reverse);

if ($nb_cron_reverse)
{
	(array) $cron_reverse = null;
	(array) $cron_reverse_id = null;
	(array) $poster_counter = null;
	(array) $reverse_counter = null;

	while ($reverse_row = $db->fetch_array($sql_select_cron_reverse))
	{
		## add counter removal
		reverse_counter($reverse_row['category_id'], 'remove');
		reverse_counter($reverse_row['addl_category_id'], 'remove');
		
		$cron_reverse[] = $reverse_row;
		$cron_reverse_id[] = $reverse_row['reverse_id'];
	}

	$cron_reverse_id_array = $db->implode_array($cron_reverse_id);

	$db->query("UPDATE " . DB_PREFIX . "reverse_auctions SET closed=1 WHERE
		reverse_id IN (" . $cron_reverse_id_array . ")");

	for ($i=0; $i<$nb_cron_reverse; $i++)
	{
		$poster_counter[$cron_reverse[$i]['owner_id']] ++; 
		$reverse_counter[$cron_reverse[$i]['owner_id']] = $cron_reverse[$i]['reverse_id']; 
	}
	
	foreach ($poster_counter as $key => $value)
	{
		if ($value == 1)
		{
			$mail_input_id = $reverse_counter[$key];
			include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/reverse_closed_seller_notification.php');
		}
		else if ($value > 1)
		{
			$mail_input_id = $key;
			include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/reverse_closed_seller_notification_multiple.php');			
		}
	}
}

// rebill expired store subscriptions in account mode
$is_expired_stores = $db->count_rows('users', "WHERE active=1 AND approved=1 AND shop_active=0 AND shop_account_id>0 
	AND shop_next_payment>0 AND shop_next_payment<" . CURRENT_TIME);

if ($is_expired_stores)
{
	$store_fee = new fees();
	$store_fee->setts = &$setts;
	
	$sql_select_expired_stores = $db->query("SELECT user_id, shop_account_id FROM " . DB_PREFIX . "users 
		WHERE active=1 AND approved=1 AND shop_active=0 AND shop_account_id>0 
		AND shop_next_payment>0 AND shop_next_payment<" . CURRENT_TIME);
	
	while ($exp_store = $db->fetch_array($sql_select_expired_stores)) 
	{
		$fee_output = $store_fee->store_subscription($exp_store['shop_account_id'], $exp_store['user_id']);
		
	}
}

?>