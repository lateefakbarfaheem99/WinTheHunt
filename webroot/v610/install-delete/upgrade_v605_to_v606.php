<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `remove_marked_deleted` TINYINT NOT NULL ;";

$db_desc[] = "Applying index to <b>custom_fields_data</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "custom_fields_data` ADD INDEX `user_custom_fields` ( `owner_id` , `page_handle` ) ,
ADD INDEX ( `owner_id` );";

$db_desc[] = "Updating <b>auctions</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD INDEX `owner_id` ( `owner_id` ) ;";

$db_desc[] = "Updating <b>wanted_ads</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "wanted_ads` ADD INDEX `owner_id` ( `owner_id` ) ;";

$db_desc[] = "Applying indexes to <b>iphistory</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "iphistory` ADD INDEX ( `memberid` ) ,
ADD INDEX `member_order` ( `memberid` , `time1` ) ;";

$db_desc[] = "Dropping index from <b>bulktmp</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bulktmp` DROP INDEX `id` ;";

$db_desc[] = "Applying index to <b>bulktmp</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "bulktmp` ADD INDEX ( `userid` ) ;";

$db_desc[] = "Applying index to <b>auction_media</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD INDEX ( `auction_id` );";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `dd_enabled` TINYINT NOT NULL ,
ADD `dd_max_size` INT NOT NULL ,
ADD `dd_expiration` INT NOT NULL ,
ADD `dd_terms` TEXT NOT NULL ,
ADD `max_dd` INT NOT NULL DEFAULT '1',
ADD `dd_folder` VARCHAR( 255 ) NOT NULL DEFAULT 'dd_folder/';";

$db_desc[] = "Updating <b>fees</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees` ADD `dd_fee` DOUBLE( 16, 2 ) NOT NULL ;";

$db_desc[] = "Updating <b>auction_rollbacks</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_rollbacks` ADD `nb_dd` INT NOT NULL ;";

$db_desc[] = "Updating <b>winners</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD `is_dd` TINYINT NOT NULL ,
ADD `dd_active` TINYINT NOT NULL ,
ADD `dd_active_date` INT NOT NULL ,
ADD `dd_nb_downloads` INT NOT NULL ;";

$db_desc[] = "Applying index to <b>auction_media</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD INDEX ( `media_url` ) ;";

$db_desc[] = "Updating <b>auction_media</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD `embedded_code` TEXT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_embedded_media` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>content_pages</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "content_pages` ADD `show_link` TINYINT NOT NULL DEFAULT '1';";

$db_desc[] = "Updating <b>currencies</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "currencies` ADD `currency_symbol` VARCHAR( 50 ) NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_addthis` TINYINT NOT NULL DEFAULT '1';";

$db_desc[] = "Updating <b>blocked_users</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "blocked_users` ADD `block_bid` TINYINT NOT NULL ,
ADD `block_message` TINYINT NOT NULL ,
ADD `block_reputation` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [5]";
$db_query[] = "ALTER TABLE  `" . DB_PREFIX . "gen_setts` ADD  `pg_amazon_access_key` VARCHAR( 255 ) NOT NULL ,
ADD  `pg_amazon_secret_key` VARCHAR( 255 ) NOT NULL;";

$db_desc[] = "Updating <b>users</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE  `" . DB_PREFIX . "users` ADD  `pg_amazon_access_key` VARCHAR( 255 ) NOT NULL ,
ADD  `pg_amazon_secret_key` VARCHAR( 255 ) NOT NULL;";

$db_desc[] = "Populating <b>payment_gateways</b> table (v6.06) [1]";
$db_query[] = "INSERT INTO " . DB_PREFIX . "payment_gateways 
(`pg_id` ,`name` ,`checked` ,`dp_enabled` ,`logo_url` )
VALUES 
(NULL , 'Amazon', '0', '0', 'img/amazon_logo.gif');";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [6]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_private_reputation` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `enable_private_reputation` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>adverts</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "adverts` ADD `section_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [7]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `smtp_host` VARCHAR( 255 ) NOT NULL ,
ADD `smtp_username` VARCHAR( 255 ) NOT NULL ,
ADD `smtp_password` VARCHAR( 255 ) NOT NULL ,
ADD `smtp_port` VARCHAR( 20 ) NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [8]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_force_payment` TINYINT NOT NULL ,
ADD `force_payment_time` INT NOT NULL ;";

$db_desc[] = "Updating <b>winners</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD `temp_purchase` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.06) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `enable_force_payment` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `end_time_cron` INT NOT NULL ;";

$db_desc[] = "Applying index to <b>winners</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX ( `temp_purchase` ) ;";

$db_desc[] = "Updating <b>winners</b> table (v6.06) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD `sale_fee_amount` DOUBLE( 16, 2 ) NOT NULL ,
ADD `sale_fee_invoice_id` INT NOT NULL ,
ADD `sale_fee_payer_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [9]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_refunds` TINYINT NOT NULL ,
ADD `refund_min_days` INT NOT NULL ,
ADD `refund_max_days` INT NOT NULL ,
ADD `refund_start_date` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [10]";
$db_query[] = "UPDATE `" . DB_PREFIX . "gen_setts` SET refund_start_date = UNIX_TIMESTAMP( ) ;";

$db_desc[] = "Updating <b>winners</b> table (v6.06) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD `refund_invoice_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>invoices</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD `refund_request` TINYINT NOT NULL ,
ADD `refund_request_date` INT NOT NULL ;";

$db_desc[] = "Applying index to <b>invoices</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD INDEX `refund_requests` ( `refund_request` , `refund_request_date` ) ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [11]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `end_auction_early` TINYINT NOT NULL ;";

$db_desc[] = "Creating <b>postage_calc_tiers</b> table (v6.06)";
$db_query[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "postage_calc_tiers` (
  `tier_id` int(11) NOT NULL AUTO_INCREMENT,
  `tier_from` double(16,2) NOT NULL,
  `tier_to` double(16,2) NOT NULL,
  `postage_amount` double(16,2) NOT NULL,
  `tier_type` enum('weight','amount') NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`tier_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM ;";

$db_desc[] = "Updating <b>users</b> table (v6.06) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `pc_free_postage` TINYINT NOT NULL ,
ADD `pc_free_postage_amount` DOUBLE( 16, 2 ) NOT NULL ,
ADD `pc_postage_type` ENUM( 'item', 'weight', 'amount', 'flat' ) NOT NULL ,
ADD `pc_weight_unit` VARCHAR( 50 ) NOT NULL ,
ADD `pc_postage_calc_type` ENUM( 'default', 'custom' ) NOT NULL ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.06) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `item_weight` INT NOT NULL ;";

$db_desc[] = "Updating <b>winners</b> table (v6.06) [5]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD `pc_postage_type` ENUM( 'item', 'weight', 'amount', 'flat' ) NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [12]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_reverse_auctions` TINYINT NOT NULL ;";

$db_desc[] = "Creating <b>reverse_categories</b> table (v6.06)";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "reverse_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `items_counter` int(11) NOT NULL DEFAULT '0',
  `hover_title` varchar(255) NOT NULL DEFAULT '',
  `meta_description` mediumtext NOT NULL,
  `meta_keywords` mediumtext NOT NULL,
  `image_path` varchar(255) NOT NULL DEFAULT '',
  `is_subcat` varchar(5) NOT NULL DEFAULT '',
  `custom_fees` tinyint(4) NOT NULL DEFAULT '0',
  `custom_skin` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `parent_id` (`parent_id`),
  KEY `parent_id_2` (`parent_id`,`order_id`,`name`)
) ENGINE=MyISAM ;";

$db_desc[] = "Populating <b>reverse_categories</b> table (v6.06)";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "reverse_categories` (`name`) VALUES
('Design &amp; Multimedia'),
('Finance &amp; Management'),
('Legal'),
('Sales &amp; Marketing'),
('Web &amp; Programming'),
('Writing &amp; Translation');";

$db_desc[] = "Creating <b>reverse_budgets</b> table (v6.06)";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "reverse_budgets` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`value_from` DOUBLE( 16, 2 ) NOT NULL ,
`value_to` DOUBLE( 16, 2 ) NOT NULL ,
`order_id` INT NOT NULL 
) ENGINE = MYISAM ;";

$db_desc[] = "Updating <b>layout_setts</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "layout_setts` ADD `r_hpfeat_nb` TINYINT NOT NULL ,
ADD `r_hpfeat_max` TINYINT NOT NULL ,
ADD `r_catfeat_nb` TINYINT NOT NULL ,
ADD `r_catfeat_max` TINYINT NOT NULL ;";

$db_desc[] = "Populating <b>reverse_budgets</b> table (v6.06)";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "reverse_budgets` (`value_from`, `value_to`) VALUES
(0.00, 100.00),
(100.00, 500.00),
(500.00, 1000.00),
(1000.00, 5000.00),
(5000.00, 0.00);";

$db_desc[] = "Updating <b>fees</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees` ADD `reverse_fees` TEXT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [13]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_fb_auctions` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.06) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `fb_decrement_amount` DOUBLE( 16, 2 ) NOT NULL ,
ADD `fb_decrement_interval` INT NOT NULL ,
ADD `fb_next_decrement` INT NOT NULL ,
ADD `fb_current_bid` DOUBLE( 16, 2 ) NOT NULL ;";

$db_desc[] = "Updating <b>winners</b> table (v6.06) [6]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD `invoice_comments` TEXT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.06) [5]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `pc_shipping_locations` ENUM( 'global', 'local' ) NOT NULL DEFAULT 'global';";

$db_desc[] = "Creating <b>shipping_locations</b> table (v6.06)";
$db_query[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "shipping_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locations_id` text NOT NULL,
  `amount` double(16,2) NOT NULL,
  `amount_type` enum('flat','percent') NOT NULL DEFAULT 'flat',
  `pc_default` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM ;";

$db_desc[] = "Updating <b>users</b> table (v6.06) [6]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `pc_flat_first` DOUBLE( 16, 2 ) NOT NULL ,
ADD `pc_flat_additional` DOUBLE( 16, 2 ) NOT NULL ,
ADD `shop_nb_feat_items_row` INT NOT NULL ;";

$db_desc[] = "Creating <b>reverse_auctions</b> table (v6.06)";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "reverse_auctions` (
  `reverse_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `currency` varchar(100) NOT NULL DEFAULT '',
  `budget_id` double(16,2) NOT NULL DEFAULT '0.00',
  `duration` smallint(6) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `addl_category_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` varchar(20) NOT NULL DEFAULT '',
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `nb_bids` int(11) NOT NULL DEFAULT '0',
  `nb_clicks` int(11) NOT NULL DEFAULT '0',
  `hpfeat` tinyint(4) NOT NULL DEFAULT '0',
  `catfeat` tinyint(4) NOT NULL DEFAULT '0',
  `bold` tinyint(4) NOT NULL DEFAULT '0',
  `hl` tinyint(4) NOT NULL DEFAULT '0',
  `hidden_bidding` tinyint(4) NOT NULL DEFAULT '0',
  `live_pm_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `live_pm_date` int(11) NOT NULL DEFAULT '0',
  `live_pm_processor` varchar(50) NOT NULL DEFAULT '',
  `bid_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `close_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `count_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `start_time` int(11) NOT NULL DEFAULT '0',
  `start_time_type` enum('now','custom') NOT NULL DEFAULT 'now',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `end_time_type` enum('duration','custom') NOT NULL DEFAULT 'duration',
  `creation_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `creation_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reverse_id`),
  KEY `user_auctions` (`owner_id`,`closed`,`deleted`,`creation_in_progress`),
  KEY `mb_auctions_id` (`deleted`,`owner_id`,`closed`,`creation_in_progress`,`reverse_id`),
  KEY `user_auctions_end_time` (`closed`,`owner_id`,`end_time`,`deleted`,`creation_in_progress`),
  KEY `auctions_start_time` (`active`,`deleted`,`closed`,`creation_in_progress`,`start_time`),
  KEY `auctions_nb_bids` (`active`,`deleted`,`closed`,`creation_in_progress`,`nb_bids`),
  KEY `auctions_name` (`active`,`deleted`,`closed`,`creation_in_progress`,`name`),
  KEY `auctions_end_time` (`active`,`deleted`,`closed`,`creation_in_progress`,`end_time`),
  KEY `hp_featured` (`hpfeat`,`active`,`closed`,`creation_in_progress`,`deleted`),
  KEY `cat_featured` (`catfeat`,`active`,`closed`,`creation_in_progress`,`deleted`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM ;";

$db_desc[] = "Updating <b>messaging</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "messaging` ADD `reverse_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>auction_media</b> table (v6.06) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD `reverse_id` INT NOT NULL ;";

$db_desc[] = "Applying index to <b>auction_media</b> table (v6.06) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD INDEX `select_reverse_media_simple` ( `reverse_id` , `upload_in_progress` ) ;";

$db_desc[] = "Updating <b>fees</b> table (v6.06) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees` ADD `reverse_category_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>invoices</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD `reverse_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>auction_rollbacks</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_rollbacks` ADD `reverse_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [14]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `max_portfolio_files` INT NOT NULL DEFAULT '10';";

$db_desc[] = "Updating <b>users</b> table (v6.06) [7]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `provider_profile` TEXT NOT NULL ;";

$db_desc[] = "Updating <b>auction_media</b> table (v6.06) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD `profile_id` INT NOT NULL ;";

$db_desc[] = "Applying index to <b>auction_media</b> table (v6.06) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_media` ADD INDEX `select_profile_media_simple` ( `profile_id` , `upload_in_progress` ) ;";

$db_desc[] = "Creating <b>reverse_bids</b> table (v6.06)";
$db_query[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "reverse_bids` (
  `bid_id` int(11) NOT NULL AUTO_INCREMENT,
  `reverse_id` int(11) NOT NULL DEFAULT '0',
  `bidder_id` int(11) NOT NULL DEFAULT '0',
  `bid_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `bid_date` int(11) NOT NULL DEFAULT '0',
  `bid_description` TEXT NOT NULL,
  `delivery_days` int(11) NOT NULL DEFAULT '0',
  `winner_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` varchar(20) NOT NULL DEFAULT '',
  `live_pm_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `email_sent` tinyint(4) NOT NULL DEFAULT '0',
  `live_pm_date` int(11) NOT NULL DEFAULT '0',
  `live_pm_processor` varchar(50) NOT NULL DEFAULT '',
  `messaging_topic_id` int(11) NOT NULL DEFAULT '0',
  `bid_status` ENUM( 'pending', 'accepted', 'declined' ) NOT NULL DEFAULT 'pending' ,
  `apply_tax` TINYINT NOT NULL ,
  PRIMARY KEY (`bid_id`),
  KEY `reverse_id` (`reverse_id`),
  KEY `auction_bids` (`reverse_id`,`bidder_id`)
) ENGINE=MyISAM ;";

$db_desc[] = "Creating <b>reverse_winners</b> table (v6.06)";
$db_query[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "reverse_winners` (
  `winner_id` int(11) NOT NULL AUTO_INCREMENT,
  `poster_id` int(11) NOT NULL DEFAULT '0',
  `provider_id` int(11) NOT NULL DEFAULT '0',
  `bid_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `reverse_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` varchar(20) NOT NULL DEFAULT '',
  `live_pm_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `email_sent` tinyint(4) NOT NULL DEFAULT '0',
  `live_pm_date` int(11) NOT NULL DEFAULT '0',
  `live_pm_processor` varchar(50) NOT NULL DEFAULT '',
  `s_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `b_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `flag_paid` tinyint(4) NOT NULL DEFAULT '0',
  `flag_status` tinyint(4) NOT NULL DEFAULT '0',
  `direct_payment_paid` tinyint(4) NOT NULL DEFAULT '0',
  `purchase_date` int(11) NOT NULL DEFAULT '0',
  `invoice_sent` tinyint(4) NOT NULL DEFAULT '0',
  `invoice_id` int(11) NOT NULL,
  `tax_amount` DOUBLE( 16, 4 ) NOT NULL ,
  `tax_rate` DOUBLE( 16, 2 ) NOT NULL ,
  `tax_calculated` TINYINT NOT NULL , 
  PRIMARY KEY (`winner_id`),
  KEY `reverse_id` (`reverse_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `won_items_auction` (`provider_id`,`b_deleted`,`invoice_id`,`reverse_id`),
  KEY `won_items_bid` (`provider_id`,`b_deleted`,`invoice_id`,`bid_amount`),
  KEY `won_items_purchase_date` (`provider_id`,`b_deleted`,`invoice_id`,`purchase_date`),
  KEY `sold_items_auction` (`poster_id`,`s_deleted`,`invoice_id`,`reverse_id`),
  KEY `sold_items_bid` (`poster_id`,`s_deleted`,`invoice_id`,`bid_amount`),
  KEY `sold_items_purchase_date` (`poster_id`,`s_deleted`,`invoice_id`,`purchase_date`),
  KEY `calculate_tax` ( `invoice_sent` , `tax_calculated` )
) ENGINE=MyISAM ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [15]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `max_additional_files` INT NOT NULL DEFAULT '5' ;";

$db_desc[] = "Updating <b>users</b> table (v6.06) [8]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `reverse_earnings` DOUBLE( 16, 2 ) NOT NULL ;";

$db_desc[] = "Updating <b>reputation</b> table (v6.06) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "reputation` ADD `reverse_id` INT NOT NULL ,
ADD `reverse_winner_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>messaging</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "messaging` ADD `bid_id` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [16]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_swdefeat` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>layout_setts</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "layout_setts` ADD `r_recent_nb` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.06) [9]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `notif_a` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>invoices</b> table (v6.06) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD `tax_amount` DOUBLE( 16, 4 ) NOT NULL ,
ADD `tax_rate` DOUBLE( 16, 2 ) NOT NULL ,
ADD `tax_calculated` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>winners</b> table (v6.06) [7]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD `tax_amount` DOUBLE( 16, 4 ) NOT NULL ,
ADD `tax_rate` DOUBLE( 16, 2 ) NOT NULL ,
ADD `tax_calculated` TINYINT NOT NULL ;";

$db_desc[] = "Applying index to <b>winners</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD INDEX `calculate_tax` ( `invoice_sent` , `tax_calculated` ) ;";

$db_desc[] = "Applying index to <b>invoices</b> table (v6.06) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "invoices` ADD INDEX ( `tax_calculated` ) ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [17]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_custom_end_time` TINYINT NOT NULL DEFAULT '1' ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.06) [18]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `ga_code` TEXT NOT NULL ;";

?>