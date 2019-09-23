<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$db_desc[] = "Updating <b>gen_setts</b> table (v6.03)";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_enhanced_ssl` TINYINT NOT NULL ,
ADD `watermark_text` TEXT NOT NULL ,
ADD `watermark_size` INT( 20 ) NOT NULL DEFAULT '500' ,
ADD `watermark_pos` TINYINT( 4 ) NOT NULL ;";
?>