<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$db_desc[] = "Creating <b>bulk_listings</b> table (v6.10)";
$db_query[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "bulk_listings` (
  `auction_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `list_in` varchar(50) NOT NULL DEFAULT 'auction',
  `auction_type` varchar(30) NOT NULL DEFAULT '',
  `start_time` int(11) NOT NULL DEFAULT '0',
  `start_time_type` enum('now','custom') NOT NULL DEFAULT 'now',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `end_time_type` enum('duration','custom') NOT NULL DEFAULT 'duration',
  `duration` smallint(6) NOT NULL DEFAULT '0',
  `quantity` smallint(6) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `addl_category_id` int(11) NOT NULL DEFAULT '0',
  `currency` varchar(100) NOT NULL DEFAULT '',
  `start_price` double(16,2) NOT NULL DEFAULT '0.00',
  `reserve_price` double(16,2) NOT NULL DEFAULT '0.00',
  `buyout_price` double(16,2) NOT NULL DEFAULT '0.00',
  `is_offer` tinyint(4) NOT NULL DEFAULT '0',
  `offer_min` double(16,2) NOT NULL DEFAULT '0.00',
  `offer_max` double(16,2) NOT NULL DEFAULT '0.00',
  `enable_swap` tinyint(4) NOT NULL DEFAULT '0',
  `bid_increment_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `zip_code` varchar(50) NOT NULL DEFAULT '',
  `state` varchar(100) NOT NULL DEFAULT '',
  `country` varchar(100) NOT NULL DEFAULT '',
  `postage_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `insurance_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `item_weight` int(11) NOT NULL,
  `shipping_method` tinyint(4) NOT NULL DEFAULT '0',
  `shipping_int` tinyint(4) NOT NULL DEFAULT '0',
  `type_service` varchar(50) NOT NULL DEFAULT '',
  `shipping_details` mediumtext NOT NULL,
  `payment_methods` text NOT NULL,
  `direct_payment` text,
  `hpfeat` tinyint(4) NOT NULL DEFAULT '0',
  `catfeat` tinyint(4) NOT NULL DEFAULT '0',
  `bold` tinyint(4) NOT NULL DEFAULT '0',
  `hl` tinyint(4) NOT NULL DEFAULT '0',
  `hidden_bidding` tinyint(4) NOT NULL DEFAULT '0',
  `apply_tax` tinyint(4) NOT NULL DEFAULT '0',
  `auto_relist_bids` tinyint(4) NOT NULL DEFAULT '0',
  `auto_relist_nb` tinyint(4) NOT NULL DEFAULT '0',
  `force_payment` tinyint(4) NOT NULL,
  `fb_decrement_amount` double(16,2) NOT NULL,
  `fb_decrement_interval` int(11) NOT NULL,
  `fb_next_decrement` int(11) NOT NULL,
  `images_details` TEXT NOT NULL,
  `media_details` TEXT NOT NULL,
  `dd_details` TEXT NOT NULL ,
  `custom_fields_details` TEXT NOT NULL,
  `import_date` INT NOT NULL, 
  PRIMARY KEY (`auction_id`),
  KEY `user_auctions` (`owner_id`), 
  KEY `order_date` ( `owner_id` , `import_date` ) 
) ENGINE=MyISAM  AUTO_INCREMENT=100001 ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `bulk_list` TINYINT NOT NULL , 
ADD INDEX `bulk_pending` ( `owner_id` , `bulk_list` ) ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` 
	ADD `email_admin_title` VARCHAR( 100 ) NOT NULL DEFAULT 'Site Administrator',
	ADD `browse_thumb_size` INT NOT NULL DEFAULT '50' ,
	ADD `display_free_fees` TINYINT NOT NULL ,
	ADD `enable_proxy_bidding` TINYINT NOT NULL DEFAULT '1' , 
	ADD `free_category_change` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `enable_item_counter` TINYINT NOT NULL DEFAULT '1' ;";

$db_desc[] = "Updating <b>auction_durations</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_durations` ADD `order_id` INT NOT NULL ,
	ADD INDEX ( `order_id` ) ;";

$db_desc[] = "Updating <b>layout_setts</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "layout_setts` ADD `enable_site_fees_page` TINYINT NOT NULL DEFAULT '1' ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.10) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `bulk_id` INT NOT NULL , 
	ADD INDEX ( `bulk_id` ) ;";

$db_desc[] = "Updating <b>fees</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees` ADD `swap_fee_calc_type` ENUM( 'flat', 'percent' ) NOT NULL DEFAULT 'flat' , 
	ADD `endauction_calc_type` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `store_password` VARCHAR( 100 ) NOT NULL ,
	ADD `show_makeoffer_ranges` TINYINT NOT NULL DEFAULT '1', 
	CHANGE `pc_postage_calc_type` `pc_postage_calc_type` ENUM( 'default', 'custom', 'carriers' ) NOT NULL ;";

$db_desc[] = "Updating <b>categories</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "categories` ADD `cat_password` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.10) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `disable_sniping` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `csv_delimiter` ENUM( 'comma', 'semicolon' ) NOT NULL DEFAULT 'comma' ;";

$db_desc[] = "Creating <b>shipping_carriers</b> table (v6.10)";
$db_query[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "shipping_carriers` (
  `carrier_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `enabled` tinyint(4) NOT NULL,
  `weight_unit` varchar(100) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  PRIMARY KEY (`carrier_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;";

$db_desc[] = "Populating <b>shipping_carriers</b> table (v6.10)";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "shipping_carriers` (`carrier_id`, `name`, `enabled`, `weight_unit`, `logo_url`) VALUES
(3, 'USPS', 0, 'pounds', 'img/usps_logo.gif'),
(4, 'FedEx', 0, 'lbs', 'img/fedex_logo.gif'),
(5, 'UPS', 0, 'lbs', 'img/ups_logo.gif');";

$db_desc[] = "Updating <b>users</b> table (v6.10) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `shipping_carriers` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>winners</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "winners` ADD `carrier_id` INT NOT NULL ,
ADD `shipping_method` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `carrier_setts` TEXT NOT NULL ;";

$db_desc[] = "Dropping <b>countries</b> table (v6.10)";
$db_query[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "countries`;";

$db_desc[] = "Creating <b>countries</b> table (v6.10)";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "countries` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate latin1_general_ci NOT NULL default '',
  `country_order` int(11) NOT NULL default '0',
  `parent_id` int(11) NOT NULL default '0',
  `country_iso_code` varchar(10) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `country_order` (`country_order`),
  KEY `parent_id` (`parent_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  COMMENT='Table with countries' ;";

$db_desc[] = "Populating <b>countries</b> table (v6.10)";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "countries` (`id`, `name`, `country_order`, `parent_id`, `country_iso_code`) VALUES
(1865, 'Afghanistan', 1000, 0, 'af'),
(1866, 'Albania', 1000, 0, 'al'),
(1874, 'Argentina', 1000, 0, 'ar'),
(1875, 'Armenia', 1000, 0, 'am'),
(1877, 'Australia', 1000, 0, 'au'),
(1878, 'Austria', 1000, 0, 'at'),
(1879, 'Azerbaijan', 1000, 0, 'az'),
(1880, 'Bahamas', 1000, 0, 'bs'),
(1881, 'Bahrain', 1000, 0, 'bh'),
(1882, 'Bangladesh', 1000, 0, 'bd'),
(1883, 'Barbados', 1000, 0, 'bb'),
(1884, 'Belarus', 1000, 0, 'by'),
(1885, 'Belgium', 1000, 0, 'be'),
(1886, 'Belize', 1000, 0, 'bz'),
(1887, 'Benin', 1000, 0, 'bj'),
(1888, 'Bermuda', 1000, 0, 'bm'),
(1889, 'Bhutan', 1000, 0, 'bt'),
(1890, 'Bolivia', 1000, 0, 'bo'),
(1891, 'Bosnia and Herzegowina', 1000, 0, 'ba'),
(1892, 'Botswana', 1000, 0, 'bw'),
(1893, 'Bouvet Island', 1000, 0, 'bv'),
(1894, 'Brazil', 1000, 0, 'br'),
(1895, 'British Indian Ocean Territory', 1000, 0, 'io'),
(1896, 'Brunei Darussalam', 1000, 0, 'bn'),
(1897, 'Bulgaria', 1000, 0, 'bg'),
(1898, 'Burkina Faso', 1000, 0, 'bf'),
(1899, 'Burma', 1000, 0, 'mm'),
(1900, 'Burundi', 1000, 0, 'bi'),
(1901, 'Cambodia', 1000, 0, 'kh'),
(1902, 'Cameroon', 1000, 0, 'cm'),
(1903, 'Canada', 1000, 0, 'ca'),
(1904, 'Cape Verde', 1000, 0, 'cv'),
(1905, 'Cayman Islands', 1000, 0, 'ky'),
(1906, 'Central African Republic', 1000, 0, 'gf'),
(1907, 'Chad', 1000, 0, 'td'),
(1908, 'Chile', 1000, 0, 'cl'),
(1909, 'China', 1000, 0, 'cn'),
(1910, 'Christmas Island', 1000, 0, 'cx'),
(1911, 'Cocos (Keeling) Islands', 1000, 0, 'cc'),
(1912, 'Colombia', 1000, 0, 'co'),
(1913, 'Comoros', 1000, 0, 'km'),
(1914, 'Congo', 1000, 0, 'cg'),
(1915, 'Congo, the Democratic Republic', 1000, 0, 'cd'),
(1916, 'Cook Islands', 1000, 0, 'ck'),
(1917, 'Costa Rica', 1000, 0, 'cr'),
(1918, 'Cote d&#039;Ivoire', 1000, 0, 'ci'),
(1919, 'Croatia', 1000, 0, 'hr'),
(1920, 'Cyprus', 1000, 0, 'cy'),
(1921, 'Czech Republic', 1000, 0, 'cz'),
(1922, 'Denmark', 1000, 0, 'dk'),
(1923, 'Djibouti', 1000, 0, 'dj'),
(1924, 'Dominica', 1000, 0, 'dm'),
(1925, 'Dominican Republic', 1000, 0, 'do'),
(1926, 'East Timor', 1000, 0, 'tl'),
(1927, 'Ecuador', 1000, 0, 'ec'),
(1928, 'Egypt', 1000, 0, 'eg'),
(1929, 'El Salvador', 1000, 0, 'sv'),
(1931, 'Equatorial Guinea', 1000, 0, 'gq'),
(1932, 'Eritrea', 1000, 0, 'er'),
(1933, 'Estonia', 1000, 0, 'ee'),
(1934, 'Ethiopia', 1000, 0, 'et'),
(1935, 'Falkland Islands', 1000, 0, 'fk'),
(1936, 'Faroe Islands', 1000, 0, 'fo'),
(1937, 'Fiji', 1000, 0, 'fj'),
(1938, 'Finland', 1000, 0, 'fi'),
(1939, 'France', 1000, 0, 'fr'),
(1940, 'French Guiana', 1000, 0, 'gf'),
(1941, 'French Polynesia', 1000, 0, 'pf'),
(1942, 'French Southern Territories', 1000, 0, 'tf'),
(1943, 'Gabon', 1000, 0, 'ga'),
(1944, 'Gambia', 1000, 0, 'gm'),
(1945, 'Georgia', 1000, 0, 'ge'),
(1946, 'Germany', 1000, 0, 'de'),
(1947, 'Ghana', 1000, 0, 'gh'),
(1948, 'Gibraltar', 1000, 0, 'gi'),
(1949, 'Greece', 1000, 0, 'gr'),
(1950, 'Greenland', 1000, 0, 'gl'),
(1951, 'Grenada', 1000, 0, 'gd'),
(1952, 'Guadeloupe', 1000, 0, 'gp'),
(1953, 'Guam', 1000, 0, 'gu'),
(1954, 'Guatemala', 1000, 0, 'gt'),
(1955, 'Guinea', 1000, 0, 'gn'),
(1956, 'Guinea-Bissau', 1000, 0, 'gw'),
(1957, 'Guyana', 1000, 0, 'gy'),
(1958, 'Haiti', 1000, 0, 'ht'),
(1959, 'Heard and Mc Donald Islands', 1000, 0, 'hm'),
(1960, 'Holy See (Vatican City State)', 1000, 0, 'va'),
(1961, 'Honduras', 1000, 0, 'hn'),
(1962, 'Hong Kong', 1000, 0, 'hk'),
(1963, 'Hungary', 1000, 0, 'hu'),
(1964, 'Iceland', 1000, 0, 'is'),
(1965, 'India', 1000, 0, 'in'),
(1966, 'Indonesia', 1000, 0, 'id'),
(1968, 'Israel', 1000, 0, 'il'),
(1969, 'Italy', 1000, 0, 'it'),
(1970, 'Jamaica', 1000, 0, 'jm'),
(1971, 'Japan', 1000, 0, 'jp'),
(1972, 'Jordan', 1000, 0, 'jo'),
(1973, 'Kazakhstan', 1000, 0, 'kz'),
(1974, 'Kenya', 1000, 0, 'ke'),
(1975, 'Kiribati', 1000, 0, 'ki'),
(1976, 'Korea (South)', 1000, 0, 'kr'),
(1977, 'Kuwait', 1000, 0, 'kw'),
(1978, 'Kyrgyzstan', 1000, 0, 'kg'),
(1980, 'Latvia', 1000, 0, 'lv'),
(1981, 'Lebanon', 1000, 0, 'lb'),
(1982, 'Lesotho', 1000, 0, 'ls'),
(1983, 'Liberia', 1000, 0, 'lr'),
(1984, 'Liechtenstein', 1000, 0, 'li'),
(1985, 'Lithuania', 1000, 0, 'lt'),
(1986, 'Luxembourg', 1000, 0, 'lu'),
(1987, 'Macau', 1000, 0, 'mo'),
(1988, 'Macedonia', 1000, 0, 'mk'),
(1989, 'Madagascar', 1000, 0, 'mg'),
(1990, 'Malawi', 1000, 0, 'mw'),
(1991, 'Malaysia', 1000, 0, 'my'),
(1992, 'Maldives', 1000, 0, 'mv'),
(1993, 'Mali', 1000, 0, 'ml'),
(1994, 'Malta', 1000, 0, 'mt'),
(1995, 'Marshall Islands', 1000, 0, 'mh'),
(1996, 'Martinique', 1000, 0, 'mq'),
(1997, 'Mauritania', 1000, 0, 'mr'),
(1998, 'Mauritius', 1000, 0, 'mu'),
(1999, 'Mayotte', 1000, 0, 'yt'),
(2000, 'Mexico', 1000, 0, 'mx'),
(2001, 'Micronesia, Federated States o', 1000, 0, 'fm'),
(2002, 'Moldova, Republic of', 1000, 0, 'md'),
(2003, 'Monaco', 1000, 0, 'mc'),
(2004, 'Mongolia', 1000, 0, 'mn'),
(2005, 'Montserrat', 1000, 0, 'ms'),
(2006, 'Morocco', 1000, 0, 'ma'),
(2007, 'Mozambique', 1000, 0, 'mz'),
(2008, 'Namibia', 1000, 0, 'na'),
(2009, 'Nauru', 1000, 0, 'nr'),
(2010, 'Nepal', 1000, 0, 'np'),
(2011, 'Netherlands', 1000, 0, 'nl'),
(2012, 'Netherlands Antilles', 1000, 0, 'an'),
(2013, 'New Caledonia', 1000, 0, 'nc'),
(2014, 'New Zealand', 1000, 0, 'nz'),
(2015, 'Nicaragua', 1000, 0, 'ni'),
(2016, 'Niger', 1000, 0, 'ne'),
(2017, 'Nigeria', 1000, 0, 'ng'),
(2018, 'Niuev', 1000, 0, 'nu'),
(2019, 'Norfolk Island', 1000, 0, 'nf'),
(2020, 'Northern Ireland', 1000, 0, ''),
(2021, 'Northern Mariana Islands', 1000, 0, 'mp'),
(2022, 'Norway', 1000, 0, 'no'),
(2023, 'Oman', 1000, 0, 'om'),
(2024, 'Pakistan', 1000, 0, 'pk'),
(2025, 'Palau', 1000, 0, 'pw'),
(2026, 'Panama', 1000, 0, 'pa'),
(2027, 'Papua New Guinea', 1000, 0, 'pg'),
(2028, 'Paraguay', 1000, 0, 'py'),
(2029, 'Peru', 1000, 0, 'pe'),
(2030, 'Philippines', 1000, 0, 'ph'),
(2031, 'Pitcairn', 1000, 0, 'pn'),
(2032, 'Poland', 1000, 0, 'pl'),
(2033, 'Portugal', 1000, 0, 'pt'),
(2034, 'Puerto Rico', 1000, 0, 'pr'),
(2035, 'Qatar', 1000, 0, 'qa'),
(2098, 'Rep Of Ireland', 1000, 0, 'ie'),
(2036, 'Reunion', 1000, 0, 're'),
(2037, 'Romania', 1000, 0, 'ro'),
(2038, 'Russian Federation', 1000, 0, 'ru'),
(2039, 'Rwanda', 1000, 0, 'rw'),
(2040, 'Saint Kitts and Nevis', 1000, 0, 'kn'),
(2041, 'Saint Lucia', 1000, 0, 'lc'),
(2042, 'Saint Vincent and the Grenadin', 1000, 0, 'vc'),
(2043, 'Samoa (Independent)', 1000, 0, 'ws'),
(2044, 'San Marino', 1000, 0, 'sm'),
(2045, 'Sao Tome and Principe', 1000, 0, 'st'),
(2046, 'Saudi Arabia', 1000, 0, 'sa'),
(2048, 'Senegal', 1000, 0, 'sn'),
(2049, 'Seychelles', 1000, 0, 'sc'),
(2050, 'Sierra Leone', 1000, 0, 'sl'),
(2051, 'Singapore', 1000, 0, 'sg'),
(2052, 'Slovakia', 1000, 0, 'sk'),
(2053, 'Slovenia', 1000, 0, 'si'),
(2054, 'Solomon Islands', 1000, 0, 'sb'),
(2055, 'Somalia', 1000, 0, 'so'),
(2056, 'South Africa', 1000, 0, 'za'),
(2057, 'South Georgia and the South Sa', 1000, 0, 'gs'),
(2058, 'Spain', 1000, 0, 'es'),
(2059, 'Sri Lanka', 1000, 0, 'lk'),
(2060, 'St. Helena', 1000, 0, 'sh'),
(2061, 'St. Pierre and Miquelon', 1000, 0, 'pm'),
(2062, 'Suriname', 1000, 0, 'sr'),
(2063, 'Svalbard and Jan Mayen Islands', 1000, 0, 'sj'),
(2064, 'Swaziland', 1000, 0, 'sz'),
(2065, 'Sweden', 1000, 0, 'se'),
(2066, 'Switzerland', 1000, 0, 'ch'),
(2067, 'Taiwan', 1000, 0, 'tw'),
(2068, 'Tajikistan', 1000, 0, 'tj'),
(2069, 'Tanzania', 1000, 0, 'tz'),
(2070, 'Thailand', 1000, 0, 'th'),
(2071, 'Togo', 1000, 0, 'tg'),
(2072, 'Tokelau', 1000, 0, 'tk'),
(2073, 'Tonga', 1000, 0, 'to'),
(2074, 'Trinidad and Tobago', 1000, 0, 'tt'),
(2075, 'Tunisia', 1000, 0, 'tn'),
(2076, 'Turkey', 1000, 0, 'tr'),
(2077, 'Turkmenistan', 1000, 0, 'tm'),
(2078, 'Turks and Caicos Islands', 1000, 0, 'tc'),
(2079, 'Tuvalu', 1000, 0, 'tv'),
(2080, 'Uganda', 1000, 0, 'ug'),
(2081, 'Ukraine', 1000, 0, 'ua'),
(2082, 'United Arab Emiratesv', 1000, 0, 'ae'),
(2083, 'United Kingdom', 1, 0, 'gb'),
(2084, 'United States', 2, 0, 'us'),
(2085, 'Uruguay', 1000, 0, 'uy'),
(2086, 'Uzbekistan', 1000, 0, 'uz'),
(2087, 'Vanuatu', 1000, 0, 'vu'),
(2088, 'Venezuela', 1000, 0, 've'),
(2089, 'Vietnam', 1000, 0, 'vn'),
(2090, 'Virgin Islands (British)', 1000, 0, 'vg'),
(2091, 'Virgin Islands (U.S.)', 1000, 0, 'vi'),
(2232, 'Australian Capital Territory', 1000, 1877, ''),
(2093, 'Wallis and Futuna Islands', 1000, 0, 'wf'),
(2094, 'Western Sahara', 1000, 0, 'eh'),
(2095, 'Yemen', 1000, 0, 'ye'),
(2096, 'Zambia', 1000, 0, 'zm'),
(2097, 'Zimbabwe', 1000, 0, 'zw'),
(2109, 'Arizona', 1000, 2084, 'az'),
(2108, 'Alaska', 1000, 2084, 'ak'),
(2107, 'Alabama', 1000, 2084, 'al'),
(2104, 'Aberdeenshire', 1000, 2083, ''),
(2105, 'Anglesey', 1000, 2083, ''),
(2106, 'Alderney', 1000, 2083, ''),
(2110, 'Arkansas', 1000, 2084, 'ar'),
(2111, 'California', 1000, 2084, 'ca'),
(2112, 'Colorado', 1000, 2084, 'co'),
(2113, 'Connecticut', 1000, 2084, 'ct'),
(2114, 'Delaware', 1000, 2084, 'de'),
(2115, 'Florida', 1000, 2084, 'fl'),
(2116, 'Georgia', 1000, 2084, 'ga'),
(2117, 'Hawaii', 1000, 2084, 'hi'),
(2118, 'Idaho', 1000, 2084, 'id'),
(2119, 'Illinois', 1000, 2084, 'il'),
(2120, 'Indiana', 1000, 2084, 'in'),
(2121, 'Iowa', 1000, 2084, 'ia'),
(2122, 'Kansas', 1000, 2084, 'ks'),
(2123, 'Kentucky', 1000, 2084, 'ky'),
(2124, 'Louisiana', 1000, 2084, 'la'),
(2125, 'Maine', 1000, 2084, 'me'),
(2126, 'Maryland', 1000, 2084, 'md'),
(2127, 'Massachusetts', 1000, 2084, 'ma'),
(2128, 'Michigan', 1000, 2084, 'mi'),
(2129, 'Minnesota', 1000, 2084, 'mn'),
(2130, 'Mississippi', 1000, 2084, 'ms'),
(2131, 'Missouri', 1000, 2084, 'mo'),
(2132, 'Montana', 1000, 2084, 'mt'),
(2133, 'Nebraska', 1000, 2084, 'ne'),
(2134, 'Nevada', 1000, 2084, 'nv'),
(2135, 'New Hampshire', 1000, 2084, 'nh'),
(2136, 'New Jersey', 1000, 2084, 'nj'),
(2137, 'New Mexico', 1000, 2084, 'nm'),
(2138, 'New York', 1000, 2084, 'ny'),
(2139, 'North Carolina', 1000, 2084, 'nc'),
(2140, 'North Dakota', 1000, 2084, 'nd'),
(2141, 'Ohio', 1000, 2084, 'oh'),
(2142, 'Oklahoma', 1000, 2084, 'ok'),
(2143, 'Oregon', 1000, 2084, 'or'),
(2144, 'Pennsylvania', 1000, 2084, 'pa'),
(2145, 'Rhode Island', 1000, 2084, 'ri'),
(2146, 'South Carolina', 1000, 2084, 'sc'),
(2147, 'South Dakota', 1000, 2084, 'sd'),
(2148, 'Tennessee', 1000, 2084, 'tn'),
(2149, 'Texas', 1000, 2084, 'tx'),
(2150, 'Utah', 1000, 2084, 'ut'),
(2151, 'Vermont', 1000, 2084, 'vt'),
(2152, 'Virginia', 1000, 2084, 'va'),
(2153, 'Washington', 1000, 2084, 'wa'),
(2154, 'West Virginia', 1000, 2084, 'wv'),
(2155, 'Wisconsin', 1000, 2084, 'wi'),
(2156, 'Wyoming', 1000, 2084, 'wy'),
(2157, 'Angus', 1000, 2083, ''),
(2158, 'Co. Antrim', 1000, 2083, ''),
(2159, 'Argyllshire', 1000, 2083, ''),
(2160, 'Co. Armagh', 1000, 2083, ''),
(2161, 'Avon', 1000, 2083, ''),
(2162, 'Ayrshire', 1000, 2083, ''),
(2163, 'Banffshire', 1000, 2083, ''),
(2164, 'Bedfordshire', 1000, 2083, ''),
(2165, 'Berwickshire', 1000, 2083, ''),
(2166, 'Buckinghamshire', 1000, 2083, ''),
(2167, 'Borders', 1000, 2083, ''),
(2168, 'Breconshire', 1000, 2083, ''),
(2169, 'Berkshire', 1000, 2083, ''),
(2170, 'Bute', 1000, 2083, ''),
(2171, 'Caernarvonshire', 1000, 2083, ''),
(2172, 'Caithness', 1000, 2083, ''),
(2173, 'Cambridgeshire', 1000, 2083, ''),
(2174, 'Channel Islands', 1000, 2083, ''),
(2175, 'Cheshire', 1000, 2083, ''),
(2176, 'Cleveland', 1000, 2083, ''),
(2177, 'Cumbria', 1000, 2083, ''),
(2178, 'Carmarthenshire', 1000, 2083, ''),
(2179, 'Cornwall', 1000, 2083, ''),
(2180, 'Cumberland', 1000, 2083, ''),
(2181, 'Derbyshire', 1000, 2083, ''),
(2182, 'Devon', 1000, 2083, ''),
(2183, 'Dumfries-shire', 1000, 2083, ''),
(2184, 'Dumfries and Galloway', 1000, 2083, ''),
(2185, 'Dunbartonshire', 1000, 2083, ''),
(2186, 'Dorset', 1000, 2083, ''),
(2187, 'Durham', 1000, 2083, ''),
(2188, 'Co. Down', 1000, 2083, ''),
(2189, 'East Lothian', 1000, 2083, ''),
(2190, 'Essex', 1000, 2083, ''),
(2191, 'Fife', 1000, 2083, ''),
(2192, 'Co. Fermanagh', 1000, 2083, ''),
(2193, 'Glamorgan', 1000, 2083, ''),
(2194, 'Gloucestershire', 1000, 2083, ''),
(2195, 'Grampian', 1000, 2083, ''),
(2196, 'Gwent', 1000, 2083, ''),
(2197, 'Hampshire', 1000, 2083, ''),
(2198, 'Herefordshire', 1000, 2083, ''),
(2199, 'Hertfordshire', 1000, 2083, ''),
(2200, 'Humberside', 1000, 2083, ''),
(2201, 'Isle of Man', 1000, 2083, ''),
(2202, 'Isle of Wight', 1000, 2083, ''),
(2203, 'Kent', 1000, 2083, ''),
(2204, 'Lancashire', 1000, 2083, ''),
(2205, 'Leicestershire', 1000, 2083, ''),
(2206, 'Lincolnshire', 1000, 2083, ''),
(2207, 'Lanarkshire', 1000, 2083, ''),
(2208, 'London', 1000, 2083, ''),
(2209, 'Lothian', 1000, 2083, ''),
(2210, 'Middlesex', 1000, 2083, ''),
(2211, 'Merionethshire', 1000, 2083, ''),
(2212, 'Midlothian', 1000, 2083, ''),
(2213, 'Northumberland', 1000, 2083, ''),
(2214, 'Norfolk', 1000, 2083, ''),
(2215, 'Northamptonshire', 1000, 2083, ''),
(2216, 'Nottinghamshire', 1000, 2083, ''),
(2217, 'Oxfordshire', 1000, 2083, ''),
(2218, 'Orkney', 1000, 2083, ''),
(2219, 'Pembrokeshire', 1000, 2083, ''),
(2220, 'Perth', 1000, 2083, ''),
(2221, 'Rutland', 1000, 2083, ''),
(2222, 'Shropshire', 1000, 2083, ''),
(2223, 'Suffolk', 1000, 2083, ''),
(2224, 'Shetland', 1000, 2083, ''),
(2225, 'Somerset', 1000, 2083, ''),
(2226, 'Surrey', 1000, 2083, ''),
(2227, 'Sussex', 1000, 2083, ''),
(2228, 'Staffordshire', 1000, 2083, ''),
(2229, 'Warwickshire', 1000, 2083, ''),
(2230, 'Wiltshire', 1000, 2083, ''),
(2231, 'Yorkshire', 1000, 2083, ''),
(2233, 'New South Wales', 1000, 1877, ''),
(2234, 'Victoria', 1000, 1877, ''),
(2235, 'Queensland', 1000, 1877, ''),
(2236, 'South Australia', 1000, 1877, ''),
(2237, 'Western Australia', 1000, 1877, ''),
(2238, 'Tasmania', 1000, 1877, ''),
(2239, 'Northern Territory', 1000, 1877, ''),
(2241, 'Dublin', 1000, 2098, ''),
(2242, 'Wicklow', 1000, 2098, ''),
(2243, 'Wexford', 1000, 2098, ''),
(2244, 'Carlow', 1000, 2098, ''),
(2245, 'Kildare', 1000, 2098, ''),
(2246, 'Meath', 1000, 2098, ''),
(2247, 'Louth', 1000, 2098, ''),
(2248, 'Monaghan', 1000, 2098, ''),
(2249, 'Cavan', 1000, 2098, ''),
(2250, 'Longford', 1000, 2098, ''),
(2251, 'Westmeath', 1000, 2098, ''),
(2252, 'Offaly', 1000, 2098, ''),
(2253, 'Laois', 1000, 2098, ''),
(2254, 'Kilkenny', 1000, 2098, ''),
(2255, 'Waterford', 1000, 2098, ''),
(2256, 'Cork', 1000, 2098, ''),
(2257, 'Kerry', 1000, 2098, ''),
(2258, 'Limerick', 1000, 2098, ''),
(2259, 'Tipperary', 1000, 2098, ''),
(2260, 'Clare', 1000, 2098, ''),
(2261, 'Galway', 1000, 2098, ''),
(2262, 'Mayo', 1000, 2098, ''),
(2263, 'Roscommon', 1000, 2098, ''),
(2264, 'Sligo', 1000, 2098, ''),
(2265, 'Leitrim', 1000, 2098, ''),
(2266, 'Donegal', 1000, 2098, ''),
(2267, 'Ontario', 1000, 1903, ''),
(2268, 'Quebec', 1000, 1903, ''),
(2269, 'Nova Scotia', 1000, 1903, ''),
(2270, 'New Brunswick', 1000, 1903, ''),
(2271, 'Manitoba', 1000, 1903, ''),
(2272, 'British Columbia', 1000, 1903, ''),
(2273, 'Prince Edward Island', 1000, 1903, ''),
(2274, 'Saskatchewan', 1000, 1903, ''),
(2275, 'Alberta', 1000, 1903, ''),
(2276, 'Newfoundland and Labrador', 1000, 1903, ''),
(2277, 'Western Cape', 1000, 2056, ''),
(2278, 'Northern Cape', 1000, 2056, ''),
(2279, 'Eastern Cape', 1000, 2056, ''),
(2280, 'KwaZulu-Natal', 1000, 2056, ''),
(2281, 'Free State', 1000, 2056, ''),
(2282, 'North West', 1000, 2056, ''),
(2283, 'Gauteng', 1000, 2056, ''),
(2284, 'Mpumalanga', 1000, 2056, ''),
(2285, 'Limpopo', 1000, 2056, ''),
(2287, 'Clacton on Sea', 1000, 2190, ''); ";

$db_desc[] = "Updating <b>users</b> table (v6.10) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `store_expiration_email` TINYINT NOT NULL ,
ADD INDEX ( `store_expiration_email` ) ;";

$db_desc[] = "Creating <b>bids_retracted</b> table (v6.10)";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "bids_retracted` (
`bid_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`auction_id` INT NOT NULL ,
`bidder_id` INT NOT NULL ,
`bid_amount` DOUBLE( 16, 2 ) NOT NULL ,
`bid_date` INT NOT NULL ,
`quantity` INT NOT NULL ,
`bid_proxy` DOUBLE( 16, 2 ) NOT NULL ,
`retraction_date` INT NOT NULL , 
KEY `retraction_date_idx` ( `retraction_date` )
) ENGINE = MYISAM ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [3]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `limit_nb_bids` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [5]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `limit_offers` INT NOT NULL ,
ADD `limit_bids` INT NOT NULL ;";

$db_desc[] = "Updating <b>auction_durations</b> table (v6.10) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auction_durations` ADD `selected` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>fees</b> table (v6.10) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees` ADD `durations_fee` TEXT NOT NULL ;";

$db_desc[] = "Creating <b>saved_searches</b> table (v6.10)";
$db_query[] = "CREATE TABLE `" . DB_PREFIX . "saved_searches` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`search_url` TEXT NOT NULL ,
`user_id` INT NOT NULL ,
`reg_date` INT NOT NULL , 
KEY `user_reg_date_idx` ( `user_id` , `reg_date` )
) ENGINE = MYISAM ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [6]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `suspension_date` INT NOT NULL ,
ADD INDEX ( `suspension_date` ) ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `suspension_date_days` INT NOT NULL , 
	ADD `seller_verification_refund` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>vouchers</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "vouchers` ADD `user_id` INT NOT NULL ,
ADD INDEX ( `user_id` ) ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.10) [4]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` CHANGE `item_weight` `item_weight` DOUBLE( 16, 2 ) NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [7]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `seller_tax_amount` DOUBLE( 16, 2 ) NOT NULL , 
	ADD `show_watch_list` TINYINT NOT NULL DEFAULT '1' ;";

$db_desc[] = "Updating <b>saved_searches</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "saved_searches` ADD `name` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>categories</b> table (v6.10) [1]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "categories` ADD `enable_auctions` TINYINT NOT NULL DEFAULT '1',
	ADD `enable_wanted` TINYINT NOT NULL DEFAULT '1' , 
	ADD INDEX ( `enable_auctions` ) , 
	ADD INDEX ( `enable_wanted` ) ;";

$db_desc[] = "Updating <b>categories</b> table (v6.10) [2]";
$db_query[] = "UPDATE `" . DB_PREFIX . "categories` SET enable_auctions =1,
enable_wanted =1 WHERE parent_id =0 ;";

$db_desc[] = "Populating <b>payment_gateways</b> table (v6.10) []";
$db_query[] = "INSERT INTO `" . DB_PREFIX . "payment_gateways` 
(`pg_id` ,`name` ,`checked` ,`dp_enabled` ,`logo_url` )
VALUES 
(NULL , 'GUNPAL', '0', '0', 'img/gunpal_logo.gif');";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [5]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `pg_gunpal_id` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [8]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `pg_gunpal_id` VARCHAR( 255 ) NOT NULL ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.10) [5]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions` ADD `seller_ip` VARCHAR( 20 ) NOT NULL ;";

$db_desc[] = "Updating <b>fees</b> table (v6.10) [2]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "fees` ADD `bidder_verification_fee` DOUBLE( 16, 2 ) NOT NULL ,
ADD `bidder_verification_recurring` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [6]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_bidder_verification` TINYINT NOT NULL ,
ADD `bidder_verification_mandatory` INT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [9]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `bidder_verified` TINYINT NOT NULL ,
ADD `bidder_verif_last_payment` INT NOT NULL ,
ADD `bidder_verif_next_payment` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [7]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `hide_empty_stores` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [10]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `is_vacation` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>currencies</b> table (v6.10) [1]";
$db_query[] = "UPDATE `" . DB_PREFIX . "currencies` SET `symbol`='RUB' WHERE `symbol`='RUR' ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [11]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `first_name` VARCHAR( 100 ) NOT NULL ,
ADD `last_name` VARCHAR( 100 ) NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [8]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `store_listing_type` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [9]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `enable_store_upgrade` TINYINT NOT NULL ,
ADD `store_upgrade_days` INT NOT NULL ;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [10]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `bidder_verification_refund` TINYINT NOT NULL ;";

$db_desc[] = "Updating <b>users</b> table (v6.10) [11]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "users` ADD `store_inactivated` tinyint NOT NULL;";

$db_desc[] = "Updating <b>gen_setts</b> table (v6.10) [11]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "gen_setts` ADD `thumb_display_type` enum('v','h') NOT NULL DEFAULT 'h' ;";

$db_desc[] = "Updating <b>auctions</b> table (v6.10) [6]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions`
ADD INDEX (`creation_in_progress`, `creation_date`);";

$db_desc[] = "Updating <b>auctions</b> table (v6.10) [7]";
$db_query[] = "ALTER TABLE `" . DB_PREFIX . "auctions`
ADD INDEX (`is_relisted_item`, `notif_item_relisted`);";

?>