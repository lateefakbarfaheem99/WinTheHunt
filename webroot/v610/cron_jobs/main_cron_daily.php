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


## mark deleted all auctions that are older than closed_auction_deletion_days days
(array) $cron_mark_deleted = null;
$exp_limit = CURRENT_TIME - ($setts['closed_auction_deletion_days'] * 24 * 60 * 60); // closed_auction_deletion_days days ago

$sql_select_exp_items = $db->query("SELECT auction_id FROM " . DB_PREFIX . "auctions WHERE 
	end_time<" . $exp_limit . " AND end_time>0 AND deleted=0 AND creation_in_progress=0");

while ($exp_item = $db->fetch_array($sql_select_exp_items)) 
{
	$cron_mark_deleted[] = $exp_item['auction_id'];
}

if (count($cron_mark_deleted) > 0)
{
	$cron_delete_array = $db->implode_array($cron_mark_deleted);
	$cron_item->delete($cron_delete_array, 0, false, true);
}

## delete winner details which have both s_deleted and b_deleted = 1
$db->query("DELETE FROM " . DB_PREFIX . "winners WHERE s_deleted=1 AND b_deleted=1");

## deleted old cache files
remove_cache_img();

## remove all items with creation_in_progress=1 (after 1 day from their creation)

$sql_select_creation_progress = $db->query("SELECT auction_id FROM " . DB_PREFIX . "auctions WHERE 
	creation_in_progress=1 AND creation_date<" . (CURRENT_TIME - 24 * 60 * 60));

$is_delete_cp = $db->num_rows($sql_select_creation_progress);

if ($is_delete_cp)
{
	(array) $cp_item = null;
	while ($cp_item_details = $db->fetch_array($sql_select_creation_progress))
	{
		$cp_item[] = $cp_item_details['auction_id'];
	}
	
	$cp_delete_array = $db->implode_array($cp_item);
	
	$cron_item->delete($cp_delete_array, 0, true, true);
}

## remove all wanted ads with creation_in_progress=1 (after 1 day from their creation)

$sql_select_wa_creation_progress = $db->query("SELECT wanted_ad_id FROM " . DB_PREFIX . "wanted_ads WHERE 
	creation_in_progress=1 AND creation_date<" . (CURRENT_TIME - 24 * 60 * 60));

$is_wa_delete_cp = $db->num_rows($sql_select_wa_creation_progress);

if ($is_wa_delete_cp)
{
	(array) $wa_cp_item = null;
	while ($wa_cp_item_details = $db->fetch_array($sql_select_wa_creation_progress))
	{
		$wa_cp_item[] = $wa_cp_item_details['wanted_ad_id'];
	}
	
	$wa_cp_delete_array = $db->implode_array($wa_cp_item);
	
	$cron_item->delete_wanted_ad($wa_cp_delete_array, 0, true);
}

## remove all reverse auctions with creation_in_progress=1 (after 1 day from their creation)

$sql_select_reverse_creation_progress = $db->query("SELECT auction_id FROM " . DB_PREFIX . "auctions WHERE 
	creation_in_progress=1 AND creation_date<" . (CURRENT_TIME - 24 * 60 * 60));

$is_reverse_delete_cp = $db->num_rows($sql_select_reverse_creation_progress);

if ($is_reverse_delete_cp)
{
	(array) $reverse_cp_item = null;
	while ($reverse_cp_item_details = $db->fetch_array($sql_select_reverse_creation_progress))
	{
		$reverse_cp_item[] = $reverse_cp_item_details['auction_id'];
	}
	
	$reverse_cp_delete_array = $db->implode_array($reverse_cp_item);
	
	$cron_item->delete_reverse($reverse_cp_delete_array, 0, true, true);
}

if ($setts['remove_marked_deleted'])
{
	$sql_select_auto_marked_deleted = $db->query("SELECT auction_id FROM " . DB_PREFIX . "auctions WHERE deleted=1 LIMIT 50");

	$auto_delete_ids = null;

	while ($auto_deleted_details = $db->fetch_array($sql_select_auto_marked_deleted))
	{
		$auto_delete_ids[] = $auto_deleted_details['auction_id'];
	}

	$auto_delete_array = $db->implode_array($auto_delete_ids);

	$cron_item->delete($auto_delete_array, 0, true, true);
}

// reset refund requests
$refund_date_limit = CURRENT_TIME - 60 * 24 * 60 * 60; // 60 days
$db->query("UPDATE " . DB_PREFIX . "invoices SET refund_request=0 WHERE refund_request!=0 AND refund_request_date<" . $refund_date_limit);

## send email notifications to store owners which will have their subscriptions expire in 2 days or less
$shop_exp_date_days = 2;
$shop_expiration_date = CURRENT_TIME + $shop_exp_date_days * 24 * 60 * 60;

$is_store_expiration = $db->count_rows('users', "WHERE shop_active=1 AND shop_account_id>0 AND 
	shop_next_payment>0 AND shop_next_payment<" . $shop_expiration_date . " AND store_expiration_email=0");

if ($is_store_expiration)
{
	include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/store_expiration_notification.php');
}

?>