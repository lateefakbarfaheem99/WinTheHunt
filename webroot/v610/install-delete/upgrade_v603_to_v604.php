<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$db_desc[] = "Updating <b>gen_setts</b> table (v6.04)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_auto_relist` TINYINT NOT NULL DEFAULT '1' ,
ADD `pg_paymate_merchant_id` VARCHAR( 255 ) NOT NULL ,
ADD `enable_skin_change` TINYINT NOT NULL ,
ADD `preferred_days` INT NOT NULL ,
ADD `pg_gc_merchant_id` VARCHAR( 255 ) NOT NULL ,
ADD `pg_gc_merchant_key` VARCHAR( 255 ) NOT NULL ,
ADD `enable_second_chance` TINYINT NOT NULL ,
ADD `second_chance_days` INT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.04)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `default_currency` VARCHAR( 100 ) NOT NULL ,
ADD `default_direct_payment` TEXT NOT NULL ,
ADD `pg_paymate_merchant_id` VARCHAR( 255 ) NOT NULL ,
ADD `preferred_seller_exp_date` INT NOT NULL ,
ADD `pg_gc_merchant_id` VARCHAR( 255 ) NOT NULL ,
ADD `pg_gc_merchant_key` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>fees</b> table (v6.04)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees` ADD `free_images` INT NOT NULL ,
ADD `free_media` INT NOT NULL ;";

$db_desc[] = "Adding rows to the <b>payment_gateways</b> table (v6.04)";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "payment_gateways` 
(`pg_id` ,`name` ,`checked` ,`dp_enabled` ,`logo_url` ) VALUES 
(NULL , 'Paymate', '0', '0', 'img/paymate_logo.gif'), 
(NULL , 'Google Checkout', '0', '0', 'img/google_checkout_logo.gif');";

$db_desc[] = "Updating <b>messaging</b> table (v6.04)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "messaging` ADD `admin_message` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.04)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` 
CHANGE `listing_type` `listing_type` ENUM( 'full', 'quick', 'buy_out' ) NOT NULL DEFAULT 'full' ;";

$db_desc[] = "Updating <b>abuses</b> table (v6.04)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "abuses` ADD `auction_id` INT NOT NULL ;";

/*
$db_desc[] = "Creating <b>iphistory</b> table (v6.04)";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "iphistory` (
  `memberid` int(11) NOT NULL,
  `time1` int(11) NOT NULL,
  `time2` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=MyISAM ;";
*/
?>