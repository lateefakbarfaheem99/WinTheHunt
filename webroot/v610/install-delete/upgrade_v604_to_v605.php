<?
#################################################################
## PHP Pro Bid v6.05															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$db_desc[] = "Creating <b>gc_transactions</b> table (v6.05)";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "gc_transactions` (
`trx_id` INT NOT NULL AUTO_INCREMENT ,
`seller_id` INT NOT NULL ,
`buyer_id` INT NOT NULL ,
`google_order_number` VARCHAR( 255 ) NOT NULL ,
`gc_custom` VARCHAR( 50 ) NOT NULL ,
`gc_table` VARCHAR( 50 ) NOT NULL ,
`gc_price` DOUBLE( 16, 2 ) NOT NULL ,
`gc_currency` VARCHAR( 10 ) NOT NULL ,
`gc_payment_description` VARCHAR( 255 ) NOT NULL ,
`reg_date` INT NOT NULL ,
PRIMARY KEY ( `trx_id` ) 
) ENGINE = MYISAM ;";


$db_desc[] = "Updating <b>gen_setts</b> table (v6.05)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` CHANGE `watermark_size` `watermark_size` INT( 11 ) NOT NULL DEFAULT '500' ;";

$db_desc[] = "Updating <b>tax_settings</b> table (v6.05)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "tax_settings` ADD `seller_countries_id` TEXT NOT NULL ;";

$db_desc[] = "Updating <b>auction_rollbacks</b> table (v6.05)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_rollbacks` ADD `is_offer` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>iphistory</b> table (v6.05)";
$db_query[] = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "iphistory (
`memberid` INT NOT NULL, 
`time1` INT NOT NULL, 
`time2` INT NOT NULL, 
`ip` VARCHAR(20) NOT NULL);";
?>