<?
#################################################################
## PHP Pro Bid v6.01															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$db_desc[] = "Updating <b>abuses</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "abuses` CHANGE `id` `abuse_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `reporterid` `user_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `abuserusern` `abuser_username` VARCHAR( 100 ) NOT NULL ,
CHANGE `reportdate` `reg_date` INT( 11 ) NOT NULL DEFAULT '0',
DROP `reporterusern` ;";

$db_desc[] = "Updating <b>admin_notes</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "admin_notes` CHANGE `id` `comment_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `userid` `user_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `regdate` `reg_date` INT( 11 ) NOT NULL DEFAULT '0';";

$db_desc[] = "Updating <b>admins</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "admins` CHANGE `created` `date_created` INT NOT NULL ,
CHANGE `lastlogin` `date_lastlogin` INT NOT NULL ;";

$db_desc[] = "Dropping <b>adultfilter</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "adultfilter` ;";

$db_desc[] = "Updating <b>adverts</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "adverts` ADD `advert_type_tmp` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>adverts</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "adverts` SET advert_type_tmp=IF(type='custom', 1, 2);";

$db_desc[] = "Updating <b>adverts</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "adverts` DROP `name` ,
DROP `company` ,
DROP `email` ,
DROP `type` ,
CHANGE `id` `advert_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `url` `advert_url` VARCHAR( 255 ) NOT NULL ,
CHANGE `imgpath` `advert_img_path` VARCHAR( 255 ) NOT NULL ,
CHANGE `alttext` `advert_alt_text` VARCHAR( 255 ) NOT NULL ,
CHANGE `textunder` `advert_text_under` VARCHAR( 255 ) NOT NULL ,
CHANGE `views_p` `views_purchased` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `clicks_p` `clicks_purchased` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `cat_filter` `advert_categories` TEXT NOT NULL ,
CHANGE `keyword_filter` `advert_keywords` TEXT NOT NULL ,
CHANGE `banner_code` `advert_code` LONGTEXT NOT NULL ,
CHANGE `advert_type_tmp` `advert_type` TINYINT NOT NULL ;";

$db_desc[] = "Renaming <b>auction_images</b> table to <b>auction_media</b>";
$db_query[] = "RENAME TABLE `" . DB_PREFIX . "auction_images` TO `" . DB_PREFIX . "auction_media`;";

$db_desc[] = "Updating <b>auction_media</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` CHANGE `id` `media_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `name` `media_url` VARCHAR( 255 ) NOT NULL ,
CHANGE `auctionid` `auction_id` INT( 11 ) NOT NULL DEFAULT '0' ,
ADD `media_type` TINYINT NOT NULL ,
ADD `upload_in_progress` TINYINT NOT NULL , 
ADD `wanted_ad_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>auction_offers</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_offers` ADD `accepted_tmp` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>auction_offers</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "auction_offers` SET accepted_tmp=IF(accepted='yes', 1, 0);";

$db_desc[] = "Updating <b>auction_offers</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_offers` DROP `expires` ,
DROP `status` ,
DROP `accepted` ,
CHANGE `id` `offer_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `auctionid` `auction_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `buyerid` `buyer_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `sellerid` `seller_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `accepted_tmp` `accepted` TINYINT NOT NULL DEFAULT '0';";

$db_desc[] = "Creating <b>auction_rollbacks</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "auction_rollbacks` (
  `rollback_id` int(11) NOT NULL auto_increment,
  `auction_id` int(11) NOT NULL default '0',
  `start_price` double(16,2) NOT NULL default '0.00',
  `reserve_price` double(16,2) NOT NULL default '0.00',
  `buyout_price` double(16,2) NOT NULL default '0.00',
  `category_id` int(11) NOT NULL default '0',
  `active` tinyint(4) NOT NULL default '0',
  `payment_status` varchar(50) NOT NULL default '',
  `hpfeat` tinyint(4) NOT NULL default '0',
  `catfeat` tinyint(4) NOT NULL default '0',
  `bold` tinyint(4) NOT NULL default '0',
  `hl` tinyint(4) NOT NULL default '0',
  `addl_category_id` int(11) NOT NULL default '0',
  `balance` double(16,2) NOT NULL default '0.00',
  `nb_images` int(11) NOT NULL default '0',
  `nb_videos` int(11) NOT NULL default '0',
  PRIMARY KEY  (`rollback_id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;";

$db_desc[] = "Updating <b>auction_watch</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_watch`
DROP `useremail`,
DROP `itemname`,
CHANGE `userid` `user_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `auctionid` `auction_id` INT( 11 ) NOT NULL DEFAULT '0';";

$db_desc[] = "Updating <b>banned</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "banned` ADD `address_type_tmp` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>banned</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "banned` SET address_type_tmp=IF(type='IP', 1, 2);";

$db_desc[] = "Updating <b>banned</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "banned` DROP `type` ,
CHANGE `id` `banned_id` INT NOT NULL AUTO_INCREMENT ,
CHANGE `bannedadr` `banned_address` VARCHAR( 255 ) NOT NULL ,
CHANGE `address_type_tmp` `address_type` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>bid_increments</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bid_increments` CHANGE `bfrom` `value_from` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `bto` `value_to` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00';";

$db_desc[] = "Updating <b>bids</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bids` ADD `bid_date_tmp` INT NOT NULL ;";

$db_desc[] = "Updating <b>bids</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "bids` SET bid_date_tmp=UNIX_TIMESTAMP(date);";

$db_desc[] = "Updating <b>bids</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bids` DROP `date` ,
CHANGE `id` `bid_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `auctionid` `auction_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `bidderid` `bidder_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `bidamount` `bid_amount` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `bid_date_tmp` `bid_date` INT NOT NULL ,
CHANGE `proxy` `bid_proxy` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `out` `bid_out` TINYINT( 4 ) NOT NULL DEFAULT '0',
CHANGE `invalid` `bid_invalid` TINYINT( 4 ) NOT NULL DEFAULT '0',
CHANGE `emailsent` `email_sent` TINYINT( 4 ) NOT NULL DEFAULT '0',
CHANGE `rpwinner` `rp_winner` TINYINT( 4 ) NOT NULL DEFAULT '0';";

$db_desc[] = "Dropping <b>bids_history</b>, <b>announcements</b>, <b>chatrooms</b>, <b>public_msg</b> tables";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "bids_history` , `" . DB_PREFIX . "announcements` , 
`" . DB_PREFIX . "chatrooms` , `" . DB_PREFIX . "public_msg` ;";

$db_desc[] = "Updating <b>blocked_users</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "blocked_users` DROP `min_fb` ,
DROP `username` ,
CHANGE `id` `block_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `userid` `user_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `ownerid` `owner_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `regdate` `reg_date` INT( 11 ) NOT NULL DEFAULT '0';";


$db_desc[] = "Dropping <b>bulk</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "bulk` ;";

$db_desc[] = "Updating <b>categories</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "categories` ADD `custom_fees_tmp` INT NOT NULL ;";

$db_desc[] = "Updating <b>categories</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "categories` SET custom_fees_tmp=IF(custom_fees='Y', 1, 0);";

$db_desc[] = "Updating <b>categories</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "categories`
DROP `custom_fees` ,
DROP `color`,
DROP `image`,
CHANGE `id` `category_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `parent` `parent_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `name` `name` VARCHAR( 100 ) NOT NULL ,
CHANGE `theorder` `order_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `hidden` `hidden` TINYINT( 4 ) NOT NULL DEFAULT '0',
CHANGE `items_counter` `items_counter` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `hover_title` `hover_title` VARCHAR( 255 ) NOT NULL ,
CHANGE `meta_description` `meta_description` MEDIUMTEXT NOT NULL ,
CHANGE `meta_keywords` `meta_keywords` MEDIUMTEXT NOT NULL ,
CHANGE `imagepath` `image_path` VARCHAR( 255 ) NOT NULL ,
CHANGE `wanted_counter` `wanted_counter` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `issubcat` `is_subcat` VARCHAR( 5 ) NOT NULL ,
CHANGE `userid` `user_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `custom_fees_tmp` `custom_fees` TINYINT ( 4 ) NOT NULL DEFAULT '0',
ADD `minimum_age` TINYINT NOT NULL;";

$db_desc[] = "Creating <b>content_pages</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "content_pages` (
`topic_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`topic_name` VARCHAR( 255 ) NOT NULL ,
`topic_content` TEXT NOT NULL ,
`topic_lang` VARCHAR( 255 ) NOT NULL ,
`topic_order` INT NOT NULL ,
`reg_date` INT NOT NULL ,
`page_id` VARCHAR( 255 ) NOT NULL ,
`page_handle` VARCHAR( 50 ) NOT NULL ,
INDEX ( `topic_order` , `reg_date` ) ,
FULLTEXT (
`topic_lang` 
)
) ENGINE = MYISAM ;";

$db_desc[] = "Updating <b>countries</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "countries` CHANGE `theorder` `country_order` INT( 11 ) NOT NULL DEFAULT '0',
ADD `parent_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>currencies</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "currencies` DROP `active` ,
CHANGE `converter` `convert_rate` DOUBLE( 16, 6 ) NOT NULL DEFAULT '1.000000',
CHANGE `converter_lastupdate` `convert_date` INT( 11 ) NOT NULL DEFAULT '0';";

$db_desc[] = "Creating <b>custom_fields</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "custom_fields` (
  `field_id` int(11) NOT NULL auto_increment,
  `field_name` varchar(255) NOT NULL default '',
  `field_order` int(11) NOT NULL default '0',
  `active` tinyint(4) NOT NULL default '0',
  `page_handle` varchar(25) NOT NULL default '',
  `section_id` int(11) NOT NULL default '0',
  `category_id` int(11) NOT NULL default '0',
  `field_description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`field_id`),
  KEY `field_order` (`field_order`),
  KEY `active` (`active`),
  KEY `page_handle` (`page_handle`),
  KEY `section_id` (`section_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;";

$db_desc[] = "Creating <b>custom_fields_boxes</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "custom_fields_boxes` (
  `box_id` int(11) NOT NULL auto_increment,
  `field_id` int(11) NOT NULL default '0',
  `box_name` text NOT NULL,
  `box_value` text NOT NULL,
  `box_order` int(11) NOT NULL default '0',
  `box_type` int(11) NOT NULL default '0',
  `mandatory` enum('0','1') NOT NULL default '0',
  `box_type_special` int(11) NOT NULL default '0',
  `formchecker_functions` text NOT NULL,
  `box_searchable` tinyint(4) NOT NULL,
  PRIMARY KEY  (`box_id`),
  KEY `field_id` (`field_id`),
  KEY `box_order` (`box_order`),
  KEY `box_type` (`box_type`),
  KEY `box_searchable` (`box_searchable`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;";

$db_desc[] = "Creating <b>custom_fields_data</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "custom_fields_data` (
  `data_id` int(11) NOT NULL auto_increment,
  `box_id` int(11) NOT NULL default '0',
  `owner_id` int(11) NOT NULL default '0',
  `box_value` text NOT NULL,
  `page_handle` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`data_id`),
  KEY `box_id` (`box_id`),
  FULLTEXT KEY `box_value` (`box_value`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;";

$db_desc[] = "Creating <b>custom_fields_sections</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "custom_fields_sections` (
  `section_id` int(11) NOT NULL auto_increment,
  `section_name` varchar(255) NOT NULL default '',
  `page_handle` varchar(25) NOT NULL default '',
  `order_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`section_id`),
  KEY `page_handle` (`page_handle`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;";

$db_desc[] = "Creating <b>custom_fields_special</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "custom_fields_special` (
  `type_id` int(11) NOT NULL auto_increment,
  `box_name` varchar(255) NOT NULL default '',
  `box_type` int(11) NOT NULL default '0',
  `table_name_raw` varchar(255) NOT NULL default '',
  `box_value_code` text NOT NULL,
  PRIMARY KEY  (`type_id`),
  KEY `box_type` (`box_type`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;";

$db_desc[] = "Creating <b>custom_fields_types</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "custom_fields_types` (
  `type_id` int(11) NOT NULL auto_increment,
  `box_type` varchar(100) NOT NULL default '',
  `maxfields` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=7 ;
";

$db_desc[] = "Populating <b>custom_fields_types</b> table";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "custom_fields_types` VALUES (1, 'text', 1),
	(2, 'textarea', 1),
	(3, 'list', 15),
	(4, 'checkbox', 10),
	(5, 'radio', 10),
	(6, 'password', 1);";

$db_desc[] = "Dropping <b>custom_rep</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "custom_rep` ;";

$db_desc[] = "Dropping <b>custom_rep_data</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "custom_rep_data` ;";

$db_desc[] = "Dropping <b>direct_payment</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "direct_payment` ;";

$db_desc[] = "Updating <b>favourite_stores</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "favourite_stores` CHANGE `storeid` `store_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `userid` `user_id` INT( 11 ) NOT NULL DEFAULT '0';";

$db_desc[] = "Renaming <b>feebacks</b> table to <b>reputation</b>";
$db_query[] = "RENAME TABLE `" . DB_PREFIX . "feedbacks` TO `" . DB_PREFIX . "reputation` ;";

$db_desc[] = "Updating <b>fees</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees` ADD `fee_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ,
DROP `is_signup_fee` ,
DROP `is_setup_fee` ,
DROP `is_endauction_fee` ,
DROP `is_pic_fee` ,
DROP `piclimit` ,
DROP `val_pic_fee2` ,
DROP `is_hlitem_fee` ,
DROP `is_hlitem_percent` ,
DROP `hlitemlimit` ,
DROP `val_hlitem_fee2` ,
DROP `is_bolditem_fee` ,
DROP `is_bolditem_percent` ,
DROP `bolditemlimit` ,
DROP `val_bolditem_fee2` ,
DROP `is_hpfeat_fee` ,
DROP `is_hpfeat_percent` ,
DROP `hpfeatlimit` ,
DROP `val_hpfeat_fee2` ,
DROP `is_catfeat_fee` ,
DROP `is_catfeat_percent` ,
DROP `catfeatlimit` ,
DROP `val_catfeat_fee2` ,
DROP `is_rp_fee` ,
DROP `is_swap_fee` ,
DROP `is_store_fee` ,
DROP `store_fee` ,
DROP `store_fee_type` ,
DROP `store_fee_cycle` ,
CHANGE `val_signup_fee` `signup_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `val_pic_fee` `picture_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `val_hlitem_fee` `hlitem_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `val_bolditem_fee` `bolditem_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `val_hpfeat_fee` `hpfeat_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `val_catfeat_fee` `catfeat_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `val_rp_fee` `rp_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `val_swap_fee` `swap_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `bin_fee` `buyout_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `wantedad_fee` `wanted_ad_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `custom_st_fee` `custom_start_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `videofile_fee` `video_fee` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
ADD `makeoffer_fee` DOUBLE( 16, 2 ) NOT NULL,
ADD `verification_fee` DOUBLE( 16, 2 ) NOT NULL ,
ADD `verification_recurring` INT NOT NULL ;";

$db_desc[] = "Updating <b>fees_tiers</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees_tiers` CHANGE `id` `tier_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
ADD `store_featured` TINYINT NOT NULL ;";

$db_desc[] = "Dropping <b>fields</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "fields`";

$db_desc[] = "Dropping <b>fields_data</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "fields_data`";

$db_desc[] = "Dropping <b>fields_types</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "fields_types`";

$db_desc[] = "Updating <b>gen_setts</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_bcc_tmp` TINYINT NOT NULL ,
ADD `enable_asq_tmp` TINYINT NOT NULL ,
ADD `auto_vat_exempt_tmp` TINYINT NOT NULL ,
ADD `enable_bid_retraction_tmp` TINYINT NOT NULL ,
ADD `enable_cat_counters_tmp` TINYINT NOT NULL ,
ADD `enable_display_phone_tmp` TINYINT NOT NULL ,
ADD `enable_auctions_approval_tmp` TINYINT NOT NULL ,
ADD `is_mod_rewrite_tmp` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "gen_setts` SET default_theme='v6', enable_bcc_tmp=IF(enable_bcc='Y', 1, 0), 
enable_asq_tmp=IF(enable_asq='Y', 1, 0), auto_vat_exempt_tmp=IF(auto_vat_exempt='Y', 1, 0), 
enable_bid_retraction_tmp=IF(enable_bid_retraction='Y', 1, 0), enable_cat_counters_tmp=IF(enable_cat_counters='Y', 1, 0), 
enable_display_phone_tmp=IF(enable_display_phone='Y', 1, 0), enable_auctions_approval_tmp=IF(enable_auctions_approval='Y', 1, 0), 
is_mod_rewrite_tmp=IF(is_mod_rewrite='Y', 1, 0);";

$db_desc[] = "Updating <b>gen_setts</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ,
DROP `addr_val` ,
DROP `error_text` ,
DROP `error_email` ,
DROP `user_deletion` ,
DROP `lkey` ,
DROP `paypaldirectpayment` ,
DROP `smtp_host` ,
DROP `smtp_port` ,
DROP `smtp_auth` ,
DROP `smtp_username` ,
DROP `smtp_password` ,
DROP `verify_strikes` ,
DROP `verify_strikes_duration` ,
DROP `vat_rate` ,
DROP `enable_mlc` ,
DROP `enable_movie_upload` ,
DROP `movie_upload_max_size` ,
DROP `enable_bcc` ,
DROP `enable_asq` ,
DROP `auto_vat_exempt` ,
DROP `enable_bid_retraction` ,
DROP `enable_cat_counters` ,
DROP `enable_display_phone` ,
DROP `enable_auctions_approval` ,
DROP `is_mod_rewrite` ,
CHANGE `siteurl` `site_path` VARCHAR(255) NOT NULL, 
CHANGE `adminemail` `admin_email` VARCHAR(255) NOT NULL, 
CHANGE `paypalemail` `pg_paypal_email` VARCHAR(255) NOT NULL, 
CHANGE `worldpayid` `pg_worldpay_id` VARCHAR(50) NOT NULL, 
CHANGE `checkoutid` `pg_checkout_id` VARCHAR(50) NOT NULL, 
CHANGE `ikobombid` `pg_ikobo_username` VARCHAR(100) NOT NULL, 
CHANGE `ikoboipn` `pg_ikobo_password` VARCHAR(100) NOT NULL, 
CHANGE `protxname` `pg_protx_username` VARCHAR(100) NOT NULL, 
CHANGE `protxpass` `pg_protx_password` VARCHAR(100) NOT NULL, 
CHANGE `authnetid` `pg_authnet_username` VARCHAR(100) NOT NULL, 
CHANGE `authnettranskey` `pg_authnet_password` VARCHAR(100) NOT NULL, 
CHANGE `currency_symbol` `currency` VARCHAR(10) NOT NULL, 
CHANGE `money_format` `amount_format` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `digits` `amount_digits` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `position` `currency_position` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `pic_gal_max_nb` `max_images` TINYINT(4) NOT NULL DEFAULT '4', 
CHANGE `pic_gal_max_size` `images_max_size` INT(11) NOT NULL DEFAULT '150', 
CHANGE `hp_feat` `enable_hpfeat` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `cat_feat` `enable_catfeat` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `bold_item` `enable_bold` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `hl_item` `enable_hl` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `swap_items` `enable_swaps` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `cron_job` `cron_job_type` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `h_counter` `enable_header_counter` TINYINT(4) NOT NULL DEFAULT '0',
CHANGE `ssl_address` `site_path_ssl` VARCHAR(255) NOT NULL, 
CHANGE `auction_deletion` `closed_auction_deletion_days` SMALLINT(6) NOT NULL DEFAULT '0', 
CHANGE `shipping_costs` `enable_shipping_costs` TINYINT NOT NULL, 
CHANGE `default_lang` `site_lang` VARCHAR(30) NOT NULL, 
CHANGE `alwaysshowbuynow` `always_show_buyout` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `secondcategory` `enable_addl_category` TINYINT(4) NOT NULL DEFAULT '0',
CHANGE `userlang` `user_lang` TINYINT(4) NOT NULL DEFAULT '0',
CHANGE `sniping_feature` `enable_sniping_feature` TINYINT NOT NULL DEFAULT '1', 
CHANGE `private_site` `enable_private_site` TINYINT NOT NULL DEFAULT '0', 
CHANGE `pref_sellers` `enable_pref_sellers` TINYINT NOT NULL DEFAULT '0', 
CHANGE `enable_ra` `enable_reg_approval` TINYINT NOT NULL DEFAULT '0', 
CHANGE `enable_wantedads` `enable_wanted_ads` TINYINT NOT NULL DEFAULT '1', 
CHANGE `hpfeat_desc` `enable_hpfeat_desc` TINYINT NOT NULL DEFAULT '0', 
CHANGE `moneybookersemail` `pg_mb_email` VARCHAR(255) NOT NULL, 
CHANGE `stores_enabled` `enable_stores` TINYINT NOT NULL DEFAULT '1', 
CHANGE `enable_vat` `enable_tax` TINYINT(4) NULL DEFAULT '0', 
CHANGE `video_gal_max_size` `media_max_size` INT(11) NOT NULL DEFAULT '2048',
DROP `bidretraction` ,
CHANGE `enable_bcc_tmp` `enable_bcc` TINYINT NOT NULL DEFAULT '0',
CHANGE `enable_asq_tmp` `enable_asq` TINYINT NOT NULL DEFAULT '1',
CHANGE `auto_vat_exempt_tmp` `auto_vat_exempt` TINYINT NOT NULL DEFAULT '0',
CHANGE `enable_bid_retraction_tmp` `enable_bid_retraction` TINYINT NOT NULL DEFAULT '0',
CHANGE `enable_cat_counters_tmp` `enable_cat_counters` TINYINT NOT NULL DEFAULT '1',
CHANGE `enable_display_phone_tmp` `enable_display_phone` TINYINT NOT NULL DEFAULT '1',
CHANGE `enable_auctions_approval_tmp` `enable_auctions_approval` TINYINT NOT NULL DEFAULT '0',
CHANGE `is_mod_rewrite_tmp` `is_mod_rewrite` TINYINT NOT NULL DEFAULT '0',
ADD `site_logo_path` VARCHAR( 255 ) NOT NULL DEFAULT 'images/probidlogo.gif',
DROP `pic_gal_active`,
ADD `time_offset` TINYINT NOT NULL ,
ADD `max_media` TINYINT NOT NULL DEFAULT '1',
ADD `enable_other_items_adp` TINYINT NOT NULL ,
ADD `debug_load_time` TINYINT NOT NULL DEFAULT '1',
ADD `debug_load_memory` TINYINT NOT NULL DEFAULT '0',
ADD `pg_nochex_email` VARCHAR( 255 ) NOT NULL ,
ADD `signup_settings` TINYINT NOT NULL ,
ADD `mcrypt_enabled` TINYINT NOT NULL ,
ADD `mcrypt_key` VARCHAR( 255 ) NOT NULL ,
ADD `makeoffer_process` TINYINT NOT NULL ,
ADD `enable_duration_change` TINYINT NOT NULL ,
ADD `duration_change_days` INT NOT NULL ,
ADD `enable_seller_verification` TINYINT NOT NULL ,
ADD `makeoffer_private` TINYINT NOT NULL ,
ADD `seller_verification_mandatory` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>invoices</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD `live_fee_tmp` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>invoices</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "invoices` SET live_fee_tmp=IF(transtype='payment', 1, 0);";

$db_desc[] = "Updating <b>invoices</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` 
DROP `transtype` ,
CHANGE `id` `invoice_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `userid` `user_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `auctionid` `item_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `feename` `name` VARCHAR( 255 ) NOT NULL ,
CHANGE `feevalue` `amount` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `feedate` `invoice_date` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `balance` `current_balance` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `live_fee_tmp` `live_fee` TINYINT NOT NULL DEFAULT '0',
CHANGE `processor` `processor` VARCHAR( 50 ) NOT NULL ,
ADD `can_rollback` TINYINT NOT NULL ,
ADD `wanted_ad_id` INT NOT NULL ,
ADD `credit_adjustment` TINYINT NOT NULL;";


$db_desc[] = "Updating <b>keywords_watch</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "keywords_watch` CHANGE `id` `keyword_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `bidderid` `user_id` INT( 11 ) NOT NULL DEFAULT '0';";

$db_desc[] = "Updating <b>layout_setts</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "layout_setts` ADD `is_faq_tmp` TINYINT NOT NULL ,
ADD `is_about_tmp` TINYINT NOT NULL ,
ADD `is_terms_tmp` TINYINT NOT NULL ,
ADD `is_contact_tmp` TINYINT NOT NULL ,
ADD `is_pp_tmp` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>layout_setts</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "layout_setts` SET is_faq_tmp=IF(is_faq='Y', 1, 0) ,
is_about_tmp=IF(is_about='Y', 1, 0) ,
is_terms_tmp=IF(is_terms='Y', 1, 0) ,
is_contact_tmp=IF(is_contact='Y', 1, 0) ,
is_pp_tmp=IF(is_pp='Y', 1, 0) ;";

$db_desc[] = "Updating <b>layout_setts</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "layout_setts` ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ,
DROP `logo_path` ,
DROP `site_align` ,
DROP `act_newsletter` ,
DROP `act_proxy` ,
DROP `is_faq` ,
DROP `is_about` ,
DROP `is_terms` ,
DROP `is_contact` ,
DROP `is_pp` ,
CHANGE `nb_feat_hp` `hpfeat_nb` TINYINT NOT NULL DEFAULT '0', 
CHANGE `w_feat_hp` `hpfeat_width` SMALLINT NOT NULL DEFAULT '0', 
CHANGE `max_feat_hp` `hpfeat_max` TINYINT NOT NULL DEFAULT '0', 
CHANGE `nb_feat_cat` `catfeat_nb` TINYINT NOT NULL DEFAULT '0', 
CHANGE `w_feat_cat` `catfeat_width` SMALLINT NOT NULL DEFAULT '0', 
CHANGE `max_feat_cat` `catfeat_max` TINYINT NOT NULL DEFAULT '0', 
CHANGE `nb_last_auct` `nb_recent_auct` SMALLINT NOT NULL DEFAULT '0', 
CHANGE `nb_hot_auct` `nb_popular_auct` SMALLINT NOT NULL DEFAULT '0', 
CHANGE `nb_end_auct` `nb_ending_auct` SMALLINT NOT NULL DEFAULT '0', 
CHANGE `act_buynow` `enable_buyout` TINYINT NOT NULL DEFAULT '0', 
CHANGE `d_acc_text` `enable_reg_terms` TINYINT NOT NULL DEFAULT '0', 
CHANGE `acc_text` `reg_terms_content` BLOB NOT NULL, 
CHANGE `d_tc_text` `enable_auct_terms` TINYINT NOT NULL DEFAULT '0', 
CHANGE `tc_text` `auct_terms_content` BLOB NOT NULL, 
CHANGE `is_faq_tmp` `is_faq` TINYINT NOT NULL DEFAULT '1', 
CHANGE `is_about_tmp` `is_about` TINYINT NOT NULL DEFAULT '1', 
CHANGE `is_terms_tmp` `is_terms` TINYINT NOT NULL DEFAULT '1', 
CHANGE `is_contact_tmp` `is_contact` TINYINT NOT NULL DEFAULT '1', 
CHANGE `is_pp_tmp` `is_pp` TINYINT NOT NULL DEFAULT '1' ;";

$db_desc[] = "Dropping <b>login_attempts</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "login_attempts`;";

$db_desc[] = "Creating <b>messaging</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "messaging` (
  `message_id` int(11) NOT NULL auto_increment,
  `auction_id` int(11) NOT NULL default '0',
  `topic_id` int(11) NOT NULL default '0',
  `sender_id` int(11) NOT NULL default '0',
  `receiver_id` int(11) NOT NULL default '0',
  `is_question` int(11) NOT NULL default '0',
  `message_title` varchar(255) NOT NULL default '',
  `message_content` text NOT NULL,
  `reg_date` int(11) NOT NULL default '0',
  `is_read` tinyint(4) NOT NULL default '0',
  `message_handle` tinyint(4) NOT NULL default '1',
  `sender_deleted` tinyint(4) NOT NULL default '0',
  `receiver_deleted` tinyint(4) NOT NULL default '0',
  `winner_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`message_id`),
  KEY `topic_id` (`topic_id`,`is_question`),
  KEY `public_questions` (`auction_id`,`message_handle`,`is_question`,`reg_date`),
  KEY `sent_messages` (`sender_id`,`reg_date`,`sender_deleted`),
  KEY `received_messages` (`receiver_id`,`receiver_deleted`,`reg_date`),
  KEY `is_read` (`is_read`),
  KEY `auction_read` (`auction_id`,`is_read`),
  KEY `topic_read` (`topic_id`,`is_read`)
) ENGINE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1 ;";

$db_desc[] = "Creating <b>newsletters</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "newsletters` (
  `newsletter_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `newsletter_subject` VARCHAR( 255 ) NOT NULL ,
  `newsletter_content` TEXT NOT NULL 
) ENGINE = MYISAM ;";

$db_desc[] = "Creating <b>newsletter_recipients</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "newsletter_recipients` (
  `recipient_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `username` VARCHAR( 255 ) NOT NULL ,
  `email` VARCHAR( 255 ) NOT NULL ,
  `newsletter_id` INT NOT NULL ,
  INDEX ( `newsletter_id` ) 
) ENGINE = MYISAM ;";

$db_desc[] = "Updating <b>payment_gateways</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "payment_gateways` CHANGE `id` `pg_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `value` `checked` TINYINT NOT NULL ,
ADD `dp_enabled` TINYINT NOT NULL ,
ADD `logo_url` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Truncating <b>payment_gateways</b> table";
$db_query[] = "TRUNCATE TABLE `" . DB_PREFIX . "payment_gateways` ;";

$db_desc[] = "Populating <b>payment_gateways</b> table";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "payment_gateways` (name, checked, dp_enabled, logo_url) VALUES 
('PayPal', 1, 1, 'img/paypal_logo.gif'),
('Worldpay', 0, 1, 'img/worldpay_logo.gif'),
('2Checkout', 1, 0, 'img/checkout_logo.gif'),
('Nochex', 1, 0, 'img/nochex_logo.gif'),
('Ikobo', 0, 0, 'img/ikobo_logo.gif'),
('Protx', 0, 0, 'img/protx_logo.gif'),
('Authorize.net', 0, 0, 'img/authorize_logo.gif'),
('Test Mode', 1, 1, 'img/testmode_logo.gif'),
('Moneybookers', 0, 0, 'img/mb_logo.gif');";

$db_desc[] = "Renaming <b>payment_methods</b> table to <b>payment_options</b>";
$db_query[] = "RENAME TABLE `" . DB_PREFIX . "payment_methods` TO `" . DB_PREFIX . "payment_options` ;";

$db_desc[] = "Updating <b>payment_options</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "payment_options` CHANGE `logourl` `logo_url` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Truncating <b>payment_options</b> table";
$db_query[] = "TRUNCATE TABLE `" . DB_PREFIX . "payment_options`;";

$db_desc[] = "Populating <b>payment_options</b> table";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "payment_options` VALUES (4, 'American Express', 'uplimg/img_AmericanExpress_5cc36bd466d9fcfdb8d2a982b06bc617.jpg'),
(5, 'Diners Club', 'uplimg/img_DinersClub_1a50904e00f3ef2e8d1a82915f977c31.gif'),
(6, 'Mastercard', 'uplimg/img_Mastercard_be77dda789e3eef0ef7fd84072122ab2.jpg'),
(7, 'Solo', 'uplimg/img_Solo_59345ad1f0c5cf7ff59552ddebfa6da7.jpg'),
(8, 'Switch', 'uplimg/img_Switch_83ed84d872590270e5be1169999ce5b3.jpg'),
(9, 'Visa', 'uplimg/img_Visa_1edf5a4623e812b4b4774b827b080fc0.jpg'),
(10, 'Western Union', 'uplimg/img_WesternUnion_850c106f03c0c08974fab9e469d6ee4c.gif');";

$db_desc[] = "Updating <b>proxybid</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "proxybid` CHANGE `id` `proxy_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `auctionid` `auction_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `bidderid` `bidder_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `bidamount` `bid_amount` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00';";

$db_desc[] = "Updating <b>reputation</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "reputation` ADD `reg_date_tmp` INT NOT NULL ;";

$db_desc[] = "Updating <b>reputation</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "reputation` SET reg_date_tmp=UNIX_TIMESTAMP(date);";

$db_desc[] = "Updating <b>reputation</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "reputation` DROP `usernick` ,
DROP `date` ,
CHANGE `id` `reputation_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `userid` `user_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `feedback` `reputation_content` TEXT NOT NULL ,
CHANGE `rate` `reputation_rate` INT NOT NULL DEFAULT '0',
CHANGE `reg_date_tmp` `reg_date` INT NULL DEFAULT NULL ,
CHANGE `fromid` `from_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `submitted` `submitted` TINYINT( 4 ) NOT NULL DEFAULT '0',
CHANGE `auctionid` `auction_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `type` `reputation_type` VARCHAR ( 15 ) NOT NULL,
ADD `winner_id` INT NOT NULL;";

$db_desc[] = "Updating <b>swaps</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "swaps` CHANGE `id` `swap_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `auctionid` `auction_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `sellerid` `seller_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `buyerid` `buyer_id` INT( 11 ) NOT NULL DEFAULT '0',
ADD `winner_id` INT NOT NULL;";

$db_desc[] = "Creating <b>tax_settings</b> table";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "tax_settings` (
  `tax_id` int(11) NOT NULL auto_increment,
  `tax_name` varchar(100) NOT NULL default '',
  `amount` double(16,2) NOT NULL default '0.00',
  `countries_id` text NOT NULL,
  `tax_user_types` varchar(20) NOT NULL default 'a',
  `site_tax` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`tax_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;";

$db_desc[] = "Updating <b>timesettings</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "timesettings` ADD `active_tmp` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>timesettings</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "timesettings` SET active_tmp=IF(active='selected', 1, 0);";

$db_desc[] = "Updating <b>timesettings</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "timesettings` 
DROP `active`, 
CHANGE `active_tmp` `active` TINYINT NOT NULL ;";

$db_desc[] = "Dropping <b>txn_ids</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "txn_ids` ;";


$db_desc[] = "Updating <b>vouchers</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "vouchers` CHANGE `id` `voucher_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `regdate` `reg_date` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `expdate` `exp_date` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `nbuses` `nb_uses` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `usesleft` `uses_left` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `reduction` `voucher_reduction` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `duration` `voucher_duration` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `assignto` `assigned_fees` VARCHAR( 255 ) NOT NULL ,
DROP `active` ;";

$db_desc[] = "Updating <b>wanted_ads</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wanted_ads` ADD `start_time_tmp` INT NOT NULL ,
ADD `end_time_tmp` INT NOT NULL ;";

$db_desc[] = "Updating <b>wanted_ads</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "wanted_ads` SET start_time_tmp=UNIX_TIMESTAMP(startdate), 
end_time_tmp=UNIX_TIMESTAMP(enddate);";

$db_desc[] = "Updating <b>wanted_ads</b> table - part 3";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "auction_media` (media_url, wanted_ad_id) 
SELECT picpath, id FROM `" . DB_PREFIX . "wanted_ads` WHERE picpath!='';";

$db_desc[] = "Updating <b>wanted_ads</b> table - part 4";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wanted_ads` 
DROP `startdate` ,
DROP `enddate` ,
DROP `picpath` ,
CHANGE `id` `wanted_ad_id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT ,
CHANGE `itemname` `name` VARCHAR( 255 ) NOT NULL ,
CHANGE `description` `description` LONGTEXT NOT NULL ,
CHANGE `zip` `zip_code` VARCHAR( 50 ) NOT NULL ,
CHANGE `category` `category_id` INT NOT NULL ,
CHANGE `nrbids` `nb_bids` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `clicks` `nb_clicks` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `ownerid` `owner_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `addlcategory` `addl_category_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `amountpaid` `live_pm_amount` DOUBLE( 16, 2 ) NOT NULL DEFAULT '0.00',
CHANGE `paymentdate` `live_pm_date` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `processor` `live_pm_processor` VARCHAR( 50 ) NOT NULL ,
CHANGE `start_time_tmp` `start_time` INT NOT NULL ,
CHANGE `end_time_tmp` `end_time` INT NOT NULL ,
ADD `state` VARCHAR( 100 ) NOT NULL ,
ADD `creation_in_progress` TINYINT NOT NULL ,
ADD `creation_date` INT NOT NULL ;";

$db_desc[] = "Updating <b>wanted_offers</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wanted_offers` DROP `ownerid` ,
DROP `sellerid` ,
DROP `comment` ,
CHANGE `id` `offer_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `wantedadid` `wanted_ad_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `auctionid` `auction_id` INT( 11 ) NOT NULL DEFAULT '0';";


$db_desc[] = "Dropping <b>wanted_fields</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "wanted_fields` ;";

$db_desc[] = "Dropping <b>wanted_fields_data</b> table";
$db_query[] = "DROP TABLE `" . DB_PREFIX . "wanted_fields_data` ;";

$db_desc[] = "Updating <b>winners</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` DROP `txnid` ,
DROP `auctiontype` ,
CHANGE `id` `winner_id` INT(11) NOT NULL AUTO_INCREMENT, 
CHANGE `sellerid` `seller_id` INT(11) NOT NULL DEFAULT '0', 
CHANGE `buyerid` `buyer_id` INT(11) NOT NULL DEFAULT '0', 
CHANGE `amount` `bid_amount` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `quant_req` `quantity_requested` INT(11) NOT NULL DEFAULT '0', 
CHANGE `quant_offered` `quantity_offered` INT(11) NOT NULL DEFAULT '0', 
CHANGE `auctionid` `auction_id` INT(11) NOT NULL DEFAULT '0', 
CHANGE `amountpaid` `live_pm_amount` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `emailsent` `email_sent` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `paymentdate` `live_pm_date` INT(11) NOT NULL DEFAULT '0', 
CHANGE `processor` `live_pm_processor` VARCHAR(50) NOT NULL, 
CHANGE `directpayment_paid` `direct_payment_paid` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `bnpurchase` `buyout_purchase` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `delivery_included` `postage_included` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `insurance` `insurance_amount` DOUBLE(10,2) NULL DEFAULT '0.00',
ADD `messaging_topic_id` INT NOT NULL,
ADD `invoice_id` INT NOT NULL,
ADD `postage_amount` DOUBLE( 16, 2 ) NOT NULL;";

$db_desc[] = "Dropping <b>help_categories</b>, <b>faq_questions</b>, <b>help_topics</b>, <b>news</b>, 
<b>pages_additional</b>, <b>pages</b> tables";

$db_query[] = "DROP TABLE `" . DB_PREFIX . "help_categories` ,
`" . DB_PREFIX . "faq_questions` ,
`" . DB_PREFIX . "help_topics` ,
`" . DB_PREFIX . "news` ,
`" . DB_PREFIX . "pages_additional` ,
`" . DB_PREFIX . "pages` ;";

$db_desc[] = "Updating <b>auctions</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `shipping_method_tmp` TINYINT NOT NULL ,
ADD `shipping_int_tmp` TINYINT NOT NULL ,
ADD `hpfeat_tmp` TINYINT NOT NULL ,
ADD `catfeat_tmp` TINYINT NOT NULL ,
ADD `bold_tmp` TINYINT NOT NULL ,
ADD `hl_tmp` TINYINT NOT NULL ,
ADD `hidden_bidding_tmp` TINYINT NOT NULL ,
ADD `enable_swap_tmp` TINYINT NOT NULL ,
ADD `auto_relist_bids_tmp` TINYINT NOT NULL ,
ADD `end_time_type_tmp` ENUM( 'duration', 'custom' ) NOT NULL DEFAULT 'duration' ,
ADD `start_time_tmp` INT NOT NULL ,
ADD `end_time_tmp` INT NOT NULL ;";

$db_desc[] = "Updating <b>auctions</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "auctions` SET shipping_method_tmp=IF(sc='BP', 1, 2), 
shipping_int_tmp=IF(scint='Y', 1, 0) ,
hpfeat_tmp=IF(hpfeat='Y', 1, 0) ,
catfeat_tmp=IF(catfeat='Y', 1, 0) ,
bold_tmp=IF(bolditem='Y', 1, 0) ,
hl_tmp=IF(hlitem='Y', 1, 0) ,
hidden_bidding_tmp=IF(private='Y', 1, 0) ,
enable_swap_tmp=IF(isswap='Y', 1, 0) ,
auto_relist_bids_tmp=IF(auto_relist_bids='Y', 1, 0) ,
end_time_type_tmp=IF(endtime_type='customtime', 'custom', 'duration') ,
start_time_tmp=UNIX_TIMESTAMP(startdate) , 
end_time_tmp=UNIX_TIMESTAMP(enddate) ,
approved=1 ;";

$db_desc[] = "Updating <b>auctions</b> table - part 3";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "auction_media` (media_url, auction_id) 
SELECT picpath, id FROM `" . DB_PREFIX . "auctions` WHERE picpath!='';";

$db_desc[] = "Updating <b>auctions</b> table - part 4";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` DROP `rp` ,
DROP `bn` ,
DROP `bi` ,
DROP `keywords` ,
DROP `acceptdirectpayment` ,
DROP `directpaymentemail` ,
DROP `auto_relist` , 
DROP `videofile_path` , 
DROP `endauction_notification` ,
DROP `picpath` , 
DROP `sc` , 
DROP `scint` , 
DROP `startdate` ,
DROP `enddate` ,
DROP `hpfeat` ,
DROP `catfeat` ,
DROP `bolditem` ,
DROP `hlitem` ,
DROP `private` ,
DROP `isswap` ,
DROP `auto_relist_bids` ,
DROP `endtime_type` ,
CHANGE `id` `auction_id` BIGINT(20) NOT NULL AUTO_INCREMENT, 
CHANGE `itemname` `name` VARCHAR(255) NOT NULL, 
CHANGE `auctiontype` `auction_type` VARCHAR(30) NOT NULL, 
CHANGE `bidstart` `start_price` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `rpvalue` `reserve_price` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `bnvalue` `buyout_price` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `bivalue` `bid_increment_amount` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `zip` `zip_code` VARCHAR(50) NOT NULL, 
CHANGE `shipping_method_tmp` `shipping_method` TINYINT NOT NULL, 
CHANGE `shipping_int_tmp` `shipping_int` TINYINT NOT NULL, 
CHANGE `pm` `payment_methods` TEXT NOT NULL, 
CHANGE `category` `category_id` INT(11) NOT NULL DEFAULT '0', 
CHANGE `nrbids` `nb_bids` INT(11) NOT NULL DEFAULT '0', 
CHANGE `maxbid` `max_bid` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `clicks` `nb_clicks` INT(11) NOT NULL DEFAULT '0', 
CHANGE `ownerid` `owner_id` INT(11) NOT NULL DEFAULT '0', 
CHANGE `hpfeat_tmp` `hpfeat` TINYINT NOT NULL DEFAULT '0', 
CHANGE `catfeat_tmp` `catfeat` TINYINT NOT NULL DEFAULT '0', 
CHANGE `bold_tmp` `bold` TINYINT NOT NULL DEFAULT '0', 
CHANGE `hl_tmp` `hl` TINYINT NOT NULL DEFAULT '0',
CHANGE `hidden_bidding_tmp` `hidden_bidding` TINYINT NOT NULL DEFAULT '0', 
CHANGE `swapped` `auction_swapped` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `postage_costs` `postage_amount` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `insurance` `insurance_amount` DOUBLE(16,2) NOT NULL, 
CHANGE `enable_swap_tmp` `enable_swap` TINYINT NOT NULL DEFAULT '0', 
CHANGE `paidwithdirectpayment` `direct_payment_paid` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `addlcategory` `addl_category_id` INT(11) NOT NULL DEFAULT '0', 
CHANGE `amountpaid` `live_pm_amount` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `paymentdate` `live_pm_date` INT(11) NOT NULL DEFAULT '0', 
CHANGE `processor` `live_pm_processor` VARCHAR(50) NOT NULL, 
CHANGE `hpfeat_desc` `hpfeat_desc` TEXT NOT NULL, 
CHANGE `reserveoffer` `reserve_offer` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `rpwinner` `reserve_offer_winner_id` INT(11) NOT NULL DEFAULT '0', 
CHANGE `listin` `list_in` VARCHAR(50) NOT NULL DEFAULT 'auction', 
CHANGE `accept_payment_systems` `direct_payment` TEXT NULL DEFAULT NULL, 
CHANGE `apply_vat` `apply_tax` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `auto_relist_bids_tmp` `auto_relist_bids` TINYINT NOT NULL DEFAULT '0', 
CHANGE `end_time_type_tmp` `end_time_type` ENUM('duration','custom') NOT NULL DEFAULT 'duration', 
CHANGE `offer_active` `is_offer` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `offer_range_min` `offer_min` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `offer_range_max` `offer_max` DOUBLE(16,2) NOT NULL DEFAULT '0.00' ,
CHANGE `description` `description` LONGTEXT NOT NULL ,
CHANGE `start_time_tmp` `start_time` INT NOT NULL ,
CHANGE `end_time_tmp` `end_time` INT NOT NULL ,
ADD `creation_in_progress` TINYINT NOT NULL ,
ADD `creation_date` INT NOT NULL ,
ADD `state` VARCHAR( 100 ) NOT NULL ,
ADD `start_time_type` ENUM( 'now', 'custom' ) NOT NULL DEFAULT 'now', 
ADD `retract_in_progress` TINYINT NOT NULL ,
ADD `notif_item_relisted` TINYINT NOT NULL ,
ADD `is_draft` TINYINT NOT NULL ,
ADD `nb_offers` INT NOT NULL ,
ADD `is_relisted_item` tinyint(4) NOT NULL default '0' ;";

$db_desc[] = "Updating <b>users</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `enable_aboutme_page_tmp` TINYINT NOT NULL ,
ADD `newsletter_tmp` TINYINT NOT NULL ,
ADD `is_seller_tmp` TINYINT NOT NULL ,
ADD `preferred_seller_tmp` TINYINT NOT NULL ,
ADD `tax_apply_exempt_tmp` TINYINT NOT NULL ,
ADD `tax_exempted_tmp` TINYINT NOT NULL ,
ADD `default_hidden_bidding_tmp` TINYINT NOT NULL ,
ADD `default_enable_swap_tmp` TINYINT NOT NULL ,
ADD `default_shipping_method_tmp` TINYINT NOT NULL ,
ADD `default_shipping_int_tmp` TINYINT NOT NULL ,
ADD `default_public_questions_tmp` TINYINT NOT NULL ,
ADD `default_bid_placed_email_tmp` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "users` SET enable_aboutme_page_tmp=IF(isaboutme='BP', 1, 2), 
newsletter_tmp=IF(newsletter='Y', 1, 0) ,
is_seller_tmp=IF(is_seller='Y', 1, 0) ,
preferred_seller_tmp=IF(preferred_seller='Y', 1, 0) ,
tax_apply_exempt_tmp=IF(apply_vat_exempt='Y', 1, 0) ,
tax_exempted_tmp=IF(vat_exempted='Y', 1, 0) ,
default_hidden_bidding_tmp=IF(default_private='Y', 1, 0) ,
default_enable_swap_tmp=IF(default_isswap='Y', 1, 0) ,
default_shipping_method_tmp=IF(default_sc='BP', 1, 2) ,
default_shipping_int_tmp=IF(default_scint='Y', 1, 0) ,
default_public_questions_tmp=IF(default_public_questions='Y', 1, 0) ,
default_bid_placed_email_tmp=IF(default_bid_placed_email='Y', 1, 0) ;";

$db_desc[] = "Updating <b>users</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` DROP `accsusp` ,
DROP `inactivated` ,
DROP `default_acceptdirectpayment` ,
DROP `default_directpaymentemail` ,
DROP `isaboutme` ,
DROP `newsletter` ,
DROP `is_seller` ,
DROP `preferred_seller` ,
DROP `apply_vat_exempt` ,
DROP `vat_exempted` ,
DROP `default_private` ,
DROP `default_isswap` ,
DROP `default_sc` ,
DROP `default_scint` ,
DROP `default_public_questions` ,
DROP `default_bid_placed_email` ,
CHANGE `id` `user_id` INT(11) NOT NULL AUTO_INCREMENT, 
CHANGE `zip` `zip_code` VARCHAR(30) NOT NULL, 
CHANGE `username` `username` VARCHAR(255) NOT NULL, 
CHANGE `password` `password` VARCHAR(32) NOT NULL, 
CHANGE `enable_aboutme_page_tmp` `enable_aboutme_page` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `aboutmepage` `aboutme_page_content` TEXT NOT NULL, 
CHANGE `shop_logo` `shop_logo_path` VARCHAR(255) NOT NULL, 
CHANGE `aboutpage_type` `aboutme_page_type` TINYINT(4) NULL DEFAULT NULL, 
CHANGE `newsletter_tmp` `newsletter` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `regdate` `reg_date` INT(11) NOT NULL DEFAULT '0', 
CHANGE `mailactivated` `mail_activated` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `amountpaid` `live_pm_amount` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `paymentdate` `live_pm_date` INT(11) NOT NULL DEFAULT '0', 
CHANGE `processor` `live_pm_processor` VARCHAR(50) NOT NULL, 
CHANGE `is_seller_tmp` `is_seller` TINYINT NOT NULL, 
CHANGE `preferred_seller_tmp` `preferred_seller` TINYINT NOT NULL, 
CHANGE `tax_apply_exempt_tmp` `tax_apply_exempt` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `vat_uid_number` `tax_reg_number` VARCHAR(100) NOT NULL, 
CHANGE `tax_exempted_tmp` `tax_exempted` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `store_active` `shop_active` TINYINT(4) NOT NULL DEFAULT '0', 
CHANGE `store_lastpayment` `shop_last_payment` INT(11) NOT NULL DEFAULT '0', 
CHANGE `default_hidden_bidding_tmp` `default_hidden_bidding` TINYINT( 4 ) NOT NULL DEFAULT '0',
CHANGE `default_enable_swap_tmp` `default_enable_swap` TINYINT( 4 ) NOT NULL DEFAULT '0',
CHANGE `default_shipping_method_tmp` `default_shipping_method` TINYINT( 4 ) NOT NULL DEFAULT '0',
CHANGE `default_shipping_int_tmp` `default_shipping_int` TINYINT NOT NULL, 
CHANGE `default_pm` `default_payment_methods` TEXT NOT NULL, 
CHANGE `default_postage_costs` `default_postage_amount` DOUBLE(16,2) NOT NULL DEFAULT '0.00', 
CHANGE `default_insurance` `default_insurance_amount` DOUBLE(16,2) NOT NULL, 
CHANGE `referredby` `referred_by` VARCHAR(200) NOT NULL, 
CHANGE `store_account_type` `shop_account_id` INT(11) NOT NULL DEFAULT '0', 
CHANGE `store_categories` `shop_categories` TEXT NOT NULL, 
CHANGE `store_nextpayment` `shop_next_payment` INT(11) NOT NULL DEFAULT '0', 
CHANGE `store_name` `shop_name` VARCHAR(255) NOT NULL, 
CHANGE `allowed_credit` `max_credit` DOUBLE(16,2) NULL DEFAULT '0.00', 
CHANGE `default_public_questions_tmp` `default_public_questions` TINYINT NOT NULL, 
CHANGE `default_bid_placed_email_tmp` `default_bid_placed_email` TINYINT NOT NULL, 
CHANGE `mail_accsusp` `mail_account_suspended` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_auctionsold` `mail_item_sold` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_auctionwon` `mail_item_won` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_buyerdetails` `mail_buyer_details` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_sellerdetails` `mail_seller_details` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_itemwatch` `mail_item_watch` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_auctionclosed` `mail_item_closed` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_wantedoffer` `mail_wanted_offer` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_outbid` `mail_outbid` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_keywordmatch` `mail_keyword_match` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `mail_conftosell` `mail_confirm_to_seller` TINYINT(4) NOT NULL DEFAULT '1', 
CHANGE `nb_items` `shop_nb_items` INT(11) NOT NULL DEFAULT '0', 
CHANGE `store_template` `shop_template_id` SMALLINT(6) NOT NULL DEFAULT '0', 
CHANGE `companyname` `tax_company_name` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `paypalemail` `pg_paypal_email` VARCHAR(255) NULL DEFAULT NULL, 
CHANGE `worldpayid` `pg_worldpay_id` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `ikoboid` `pg_ikobo_username` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `ikoboipn` `pg_ikobo_password` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `checkoutid` `pg_checkout_id` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `protxname` `pg_protx_username` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `protxpassword` `pg_protx_password` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `authnetid` `pg_authnet_username` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `authnettranskey` `pg_authnet_password` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `nochexemail` `pg_nochex_email` VARCHAR(100) NULL DEFAULT NULL, 
CHANGE `store_about` `shop_about` TEXT NOT NULL, 
CHANGE `store_specials` `shop_specials` TEXT NOT NULL, 
CHANGE `store_shippinginfo` `shop_shipping_info` TEXT NOT NULL, 
CHANGE `store_policies` `shop_company_policies` TEXT NOT NULL, 
CHANGE `store_featured_items` `shop_nb_feat_items` INT(11) NOT NULL DEFAULT '0', 
CHANGE `store_endingsoon_items` `shop_nb_ending_items` INT(11) NOT NULL DEFAULT '0', 
CHANGE `store_recentlylisted_items` `shop_nb_recent_items` INT(11) NOT NULL DEFAULT '0', 
CHANGE `store_metatags` `shop_metatags` TEXT NOT NULL, 
CHANGE `default_itemname` `default_name` VARCHAR(255) NOT NULL, 
CHANGE `auction_approval` `auction_approval` TINYINT NOT NULL DEFAULT '0',
ADD `approved` TINYINT NOT NULL DEFAULT '1',
ADD `mail_messaging_received` TINYINT NOT NULL DEFAULT '1',
ADD `mail_messaging_sent` TINYINT NOT NULL DEFAULT '0',
ADD `pg_mb_email` VARCHAR( 255 ) NOT NULL ,
ADD `seller_verified` TINYINT NOT NULL ,
ADD `seller_verif_last_payment` INT NOT NULL ,
ADD `seller_verif_next_payment` INT NOT NULL ,
ADD `tax_account_type` TINYINT NOT NULL ,
ADD `salt` CHAR( 3 ) NOT NULL ;";

$db_desc[] = "Changing the engine for <b>auctions</b> tables to MyISAM";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ENGINE=MYISAM ;";

$db_desc[] = "Changing the engine for <b>banned</b> tables to MyISAM";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "banned` ENGINE=MYISAM ;";

$db_desc[] = "Changing the engine for <b>countries</b> tables to MyISAM";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "countries` ENGINE=MYISAM ;";

$db_desc[] = "Changing the engine for <b>users</b> tables to MyISAM";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ENGINE=MYISAM ;";

$db_desc[] = "Changing the engine for <b>wanted_ads</b> tables to MyISAM";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wanted_ads` ENGINE=MYISAM ;";

$db_desc[] = "Changing the engine for <b>wordfilter</b> tables to MyISAM";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wordfilter` ENGINE=MYISAM ;";

$db_desc[] = "Applying indexes for <b>abuses</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "abuses` ADD INDEX ( `reg_date` ) ;";

$db_desc[] = "Applying indexes for <b>admin_notes</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "admin_notes` ADD INDEX ( `user_id` ) ;";

$db_desc[] = "Applying indexes for <b>adverts</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "adverts` ADD INDEX ( `views` , `clicks` , `views_purchased` , `clicks_purchased` , `advert_type` ) ;";

$db_desc[] = "Applying indexes for <b>auction_offers</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_offers` ADD INDEX ( `auction_id` , `buyer_id` , `seller_id` , `accepted` ) ;";

$db_desc[] = "Applying indexes for <b>auction_watch</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_watch` ADD INDEX ( `user_id` ), 
ADD INDEX ( `auction_id` ) ;";

$db_desc[] = "Applying indexes for <b>banned</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "banned` ADD FULLTEXT ( `banned_address` ),
ADD INDEX ( `address_type` ) ;";

$db_desc[] = "Applying indexes for <b>bid_increments</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bid_increments` ADD INDEX ( `value_from` , `value_to` ) ;";

$db_desc[] = "Applying indexes for <b>blocked_users</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "blocked_users` ADD INDEX `block_src` ( `user_id` , `owner_id` ) ,
ADD INDEX `reg_src` (  `owner_id` , `reg_date` ) ;";

$db_desc[] = "Applying indexes for <b>categories</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "categories` ADD INDEX ( `parent_id` ) ,
ADD INDEX ( `parent_id` , `order_id` , `name` ) ,
ADD INDEX ( `parent_id` , `user_id` ) ;";

$db_desc[] = "Applying indexes for <b>countries</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "countries` ADD INDEX ( `country_order` ) ,
ADD INDEX ( `parent_id` ) ,
ADD FULLTEXT ( `name` ) ;";

$db_desc[] = "Applying indexes for <b>favourite_stores</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "favourite_stores` ADD INDEX ( `store_id` ) ,
ADD INDEX ( `user_id` ) ,
ADD INDEX ( `store_id` , `user_id` ) ;";

$db_desc[] = "Applying indexes for <b>fees_tiers</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees_tiers` ADD INDEX ( `category_id` ) ,
ADD INDEX ( `fee_type` ) ;";

$db_desc[] = "Applying indexes for <b>invoices</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD INDEX ( `can_rollback` ) ;";

$db_desc[] = "Applying indexes for <b>invoices</b> table - part 2";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD INDEX `account_history_item` ( `user_id` , `item_id` , `invoice_date` , `live_fee` , `invoice_id` ) ;";

$db_desc[] = "Applying indexes for <b>invoices</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD INDEX `account_history_wa` ( `user_id` , `wanted_ad_id` , `invoice_date` , `live_fee` , `invoice_id` ) ;";

$db_desc[] = "Applying indexes for <b>invoices</b> table - part 4";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD INDEX `account_history_live` ( `user_id` , `invoice_date` , `live_fee` , `invoice_id` ) ;";

$db_desc[] = "Applying indexes for <b>keywords_watch</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "keywords_watch` ADD INDEX ( `user_id` ) ,
ADD FULLTEXT ( `keyword` ) ;";

$db_desc[] = "Applying indexes for <b>payment_gateways</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "payment_gateways` ADD INDEX ( `checked` ) ,
ADD INDEX ( `dp_enabled` ) ;";

$db_desc[] = "Applying indexes for <b>invoices</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "proxybid` ADD INDEX ( `auction_id` ) ,
ADD INDEX ( `bidder_id` ) ,
ADD INDEX `select_bids` ( `auction_id` , `bidder_id` ) ;";

$db_desc[] = "Applying indexes for <b>reputation</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "reputation` ADD INDEX `rep_calculation` ( `user_id` , `reputation_rate` , `submitted` ) ;";

$db_desc[] = "Applying indexes for <b>reputation</b> table - part 2";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "reputation` ADD INDEX `rep_received` ( `submitted` , `user_id` , `reg_date` ) ;";

$db_desc[] = "Applying indexes for <b>reputation</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "reputation` ADD INDEX `rep_sent` ( `from_id` , `submitted` , `reg_date` ) ;";

$db_desc[] = "Applying indexes for <b>swaps</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "swaps` ADD INDEX ( `auction_id` , `seller_id` ) ;";

$db_desc[] = "Applying indexes for <b>wanted_offers</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wanted_offers` ADD INDEX ( `wanted_ad_id` ) ;";

$db_desc[] = "Applying indexes for <b>wordfilter</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wordfilter` ADD FULLTEXT ( `word` ) ;";

## winners table indexes
$db_desc[] = "Applying indexes for <b>winners</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX ( `auction_id` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 2";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX ( `invoice_id` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `won_items_auction` ( `buyer_id` , `b_deleted` , `invoice_id` , `auction_id` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 4";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `won_items_bid` ( `buyer_id` , `b_deleted` , `invoice_id` , `bid_amount` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 5";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `won_items_quantity` ( `buyer_id` , `b_deleted` , `invoice_id` , `quantity_offered` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 6";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `won_items_purchase_date` ( `buyer_id` , `b_deleted` , `invoice_id` , `purchase_date` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 7";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `sold_items_auction` ( `seller_id` , `s_deleted` , `invoice_id` , `auction_id` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 8";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `sold_items_bid` ( `seller_id` , `s_deleted` , `invoice_id` , `bid_amount` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 9";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `sold_items_quantity` ( `seller_id` , `s_deleted` , `invoice_id` , `quantity_offered` ) ;";

$db_desc[] = "Applying indexes for <b>winners</b> table - part 10";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `sold_items_purchase_date` ( `seller_id` , `s_deleted` , `invoice_id` , `purchase_date` ) ;";

## users table indexes
$db_desc[] = "Applying indexes for <b>users</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD INDEX `active` ( `active` ) ;";

$db_desc[] = "Applying indexes for <b>users</b> table - part 2";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD INDEX `shop_active` ( `user_id` , `active` , `shop_active` ) ;";

$db_desc[] = "Applying indexes for <b>users</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD INDEX `stores_list` ( `active` , `shop_active` , `shop_nb_items` ) ;";

$db_desc[] = "Applying indexes for <b>users</b> table - part 4";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD FULLTEXT ( `shop_name` ) ;";

$db_desc[] = "Applying indexes for <b>users</b> table - part 5";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD INDEX `active_users` ( `active` , `approved` , `reg_date` ) ;";

$db_desc[] = "Applying indexes for <b>users</b> table - part 6";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD INDEX `acc_overdue_users` ( `payment_mode` , `reg_date` ) ;";

$db_desc[] = "Applying indexes for <b>users</b> table - part 7";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD INDEX `users_tax_acc_type` ( `tax_account_type` , `reg_date` ) ;";

$db_desc[] = "Applying indexes for <b>users</b> table - part 8";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD INDEX `users_tax_exempt` ( `tax_apply_exempt` , `tax_exempted` , `reg_date` ) ;";

## wanted ads indexes
$db_desc[] = "Applying indexes for <b>wanted_ads</b> table";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wanted_ads` ADD INDEX `wa_id` ( `owner_id` , `closed` , `deleted` , `creation_in_progress` , `wanted_ad_id` ) ,
ADD INDEX `wa_start_time` ( `owner_id` , `closed` , `deleted` , `creation_in_progress` , `start_time` ) ,
ADD INDEX `wa_end_time` ( `owner_id` , `closed` , `deleted` , `creation_in_progress` , `end_time` ) ,
ADD INDEX `wa_nb_bids` ( `owner_id` , `closed` , `deleted` , `creation_in_progress` , `nb_bids` ) ,
ADD INDEX `wa_admin_id` ( `creation_in_progress` , `active` , `closed` , `wanted_ad_id` ) ,
ADD INDEX `wa_admin_start_time` ( `creation_in_progress` , `active` , `closed` , `start_time` ) ,
ADD FULLTEXT `wa_keywords` ( `name` , `description` ) ,
ADD INDEX `wa_browse_end_time` ( `active` , `closed` , `deleted` , `wanted_ad_id` , `end_time` ) ,
ADD INDEX `wa_browse_nb_bids` ( `active` , `closed` , `deleted` , `wanted_ad_id` , `nb_bids` ) ,
ADD INDEX `wa_mainpage` ( `closed` , `active` , `deleted` , `creation_in_progress` , `start_time` ) ;";

## auction_media indexes
$db_desc[] = "Applying indexes for <b>auction_media</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD INDEX `select_media_simple` ( `auction_id` , `upload_in_progress` ) ;";

$db_desc[] = "Applying indexes for <b>auction_media</b> table - part 2";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD INDEX `select_wa_media_simple` ( `wanted_ad_id` , `upload_in_progress` ) ;";

$db_desc[] = "Applying indexes for <b>auction_media</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD INDEX `select_media_advanced` ( `auction_id` , `media_type` , `upload_in_progress` ) ;";

## bids indexes

$db_desc[] = "Applying indexes for <b>bids</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bids` ADD INDEX ( `auction_id` ) ;";

$db_desc[] = "Applying indexes for <b>bids</b> table - part 2";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bids` ADD INDEX `high_bids` ( `auction_id` , `bid_amount` ) ;";

$db_desc[] = "Applying indexes for <b>bids</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bids` ADD INDEX `bid_types` ( `auction_id` , `bid_out` , `bid_invalid` ) ;";

$db_desc[] = "Applying indexes for <b>bids</b> table - part 4";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bids` ADD INDEX `auction_bids` ( `auction_id` , `bidder_id` ) ;";

## auctions indexes

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `user_auctions` ( `owner_id` , `closed` , `deleted` , `creation_in_progress` , `is_draft` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 2";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `user_auctions_end_time` ( `closed` , `owner_id` , `end_time` , `deleted` , `creation_in_progress` , `is_draft` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD FULLTEXT ( `name` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 4";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD FULLTEXT ( `description` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 5";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD FULLTEXT ( `zip_code` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 6";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `hp_featured` ( `hpfeat` , `active` , `approved` , `closed` , `creation_in_progress` , `deleted` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 7";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `cat_featured` ( `catfeat` , `active` , `approved` , `closed` , `creation_in_progress` , `deleted` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 8";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `stats_drafts` ( `is_draft` , `owner_id` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 9";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `mb_auctions_id` ( `owner_id` , `closed` , `deleted` , `creation_in_progress` , `auction_id` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 10";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `auctions_start_time` ( `active` , `approved` , `deleted` , `closed` , `creation_in_progress` , `start_time` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 11";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `auctions_nb_bids` ( `active` , `approved` , `deleted` , `closed` , `creation_in_progress` , `nb_bids` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 12";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `auctions_max_bid` ( `active` , `approved` , `deleted` , `closed` , `creation_in_progress` , `max_bid` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 13";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `auctions_end_time` ( `active` , `approved` , `deleted` , `closed` , `creation_in_progress` , `end_time` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 14";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `auctions_start_price` ( `active` , `approved` , `deleted` , `closed` , `creation_in_progress` , `start_price` ) ;";

$db_desc[] = "Applying indexes for <b>auctions</b> table - part 15";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `auctions_name` ( `active` , `approved` , `deleted` , `closed` , `creation_in_progress` , `name` ) ;";

$db_desc[] = "Updating <b>auction_media</b> table - part 2";
$db_query[] = "UPDATE `" . DB_PREFIX . "auction_media` SET media_type=1;";

$db_desc[] = "Updating countries for the <b>auctions</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `country_tmp` VARCHAR( 100 ) NOT NULL ;";

$db_desc[] = "Updating countries for the <b>auctions</b> table - part 2";
$db_query[] = "UPDATE " . DB_PREFIX . "auctions SET 
country_tmp=(SELECT id FROM " . DB_PREFIX . "countries WHERE name=country) ;";

$db_desc[] = "Updating countries for the <b>auctions</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` 
DROP `country` , 
CHANGE `country_tmp` `country` VARCHAR( 100 ) NOT NULL ;";

$db_desc[] = "Updating countries for the <b>users</b> table - part 1";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `country_tmp` VARCHAR( 100 ) NOT NULL ;";

$db_desc[] = "Updating countries for the <b>users</b> table - part 2";
$db_query[] = "UPDATE " . DB_PREFIX . "users SET 
country_tmp=(SELECT id FROM " . DB_PREFIX . "countries WHERE name=country) ;";

$db_desc[] = "Updating countries for the <b>users</b> table - part 3";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` 
DROP `country` , 
CHANGE `country_tmp` `country` VARCHAR( 100 ) NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table - part 4";
$db_query[] = "UPDATE " . DB_PREFIX . "gen_setts SET 
cron_job_type='2', suspend_over_bal_users='0', account_mode='2', account_mode_personal='0', 
enable_auctions_approval='0';";

$db_desc[] = "Updating <b>users</b> table rows";
$db_query[] = "UPDATE " . DB_PREFIX . "users SET approved='1', auction_approval='0';";

$db_desc[] = "Updating <b>auctions</b> table rows";
$db_query[] = "UPDATE " . DB_PREFIX . "auctions SET approved='1';";

?>