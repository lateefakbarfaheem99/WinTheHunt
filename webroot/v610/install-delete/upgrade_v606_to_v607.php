<?
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$db_desc[] = "Updating <b>users</b> table (v6.07) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` CHANGE `pc_postage_type` `pc_postage_type` ENUM( 'item', 'weight', 'amount', 'flat' ) NOT NULL ;";

$db_desc[] = "Populating <b>payment_gateways</b> table (v6.07)";
$db_query[] = "INSERT INTO " . DB_PREFIX . "payment_gateways 
(`pg_id` ,`name` ,`checked` ,`dp_enabled` ,`logo_url` )
VALUES 
(NULL , 'AlertPay', '0', '0', 'img/alertpay_logo.gif');";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.07) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `pg_alertpay_id` VARCHAR( 255 ) NOT NULL ,
ADD `pg_alertpay_securitycode` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.07) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `pg_alertpay_id` VARCHAR( 255 ) NOT NULL , 
ADD `pg_alertpay_securitycode` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.07) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_buyer_create_invoice` TINYINT NOT NULL DEFAULT '1' ,
ADD `fulltext_search_method` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.07) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `exceeded_balance_email` TINYINT NOT NULL , 
ADD `default_bank_details` TEXT NOT NULL ,
ADD `default_auto_relist` TINYINT NOT NULL ,
ADD `default_auto_relist_bids` TINYINT NOT NULL ,
ADD `default_auto_relist_nb` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.07) [3]";
$db_query[] = "UPDATE `" . DB_PREFIX . "users` SET mail_activated=1 WHERE active=1 AND approved=1 ; ";

?>