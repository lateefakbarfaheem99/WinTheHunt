<?
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$db_desc[] = "Updating <b>categories</b> table (v6.02)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "categories` ADD `custom_skin` VARCHAR( 100 ) NOT NULL ;";

$db_desc[] = "Updating <b>messaging</b> table (v6.02)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "messaging` ADD `wanted_ad_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.02)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_profile_page` TINYINT NOT NULL ,
ADD `enable_store_only_mode` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.02)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `enable_profile_page` TINYINT NOT NULL ,
ADD `profile_www` VARCHAR( 255 ) NOT NULL ,
ADD `profile_msn` VARCHAR( 255 ) NOT NULL ,
ADD `profile_icq` VARCHAR( 255 ) NOT NULL ,
ADD `profile_aim` VARCHAR( 255 ) NOT NULL ,
ADD `profile_yim` VARCHAR( 255 ) NOT NULL ,
ADD `profile_skype` VARCHAR( 255 ) NOT NULL ,
ADD `profile_show_birthdate` TINYINT NOT NULL ,
ADD `paypal_address_override` TINYINT NOT NULL ,
ADD `paypal_first_name` VARCHAR( 32 ) NOT NULL ,
ADD `paypal_last_name` VARCHAR( 64 ) NOT NULL ,
ADD `paypal_address1` VARCHAR( 100 ) NOT NULL ,
ADD `paypal_address2` VARCHAR( 100 ) NOT NULL ,
ADD `paypal_city` VARCHAR( 100 ) NOT NULL ,
ADD `paypal_state` VARCHAR( 100 ) NOT NULL ,
ADD `paypal_zip` VARCHAR( 32 ) NOT NULL ,
ADD `paypal_country` VARCHAR( 100 ) NOT NULL ,
ADD `paypal_email` VARCHAR( 255 ) NOT NULL ,
ADD `paypal_night_phone_a` VARCHAR( 3 ) NOT NULL ,
ADD `paypal_night_phone_b` VARCHAR( 16 ) NOT NULL ,
ADD `paypal_night_phone_c` VARCHAR( 4 ) NOT NULL ;";

?>