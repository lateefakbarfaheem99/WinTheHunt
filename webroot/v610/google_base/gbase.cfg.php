<?PHP
/*======================================================================*\
|| #################################################################### ||
|| # gbase.cfg.php 6.00, for use with PhpProBid script 6.00		       # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright © 2005 RENS Management, LLC. All Rights Reserved.      # ||
|| # This file is licensed under the End User Licensue Agreement at   # ||
|| #                 http://probid.rensmllc.com/eula.pdf              # ||
|| # -----------------  THIS IS NOT FREE SOFTWARE ------------------- # ||
|| #                                                                  # ||
|| #################################################################### ||
\*======================================================================*/

#Google Base user defines
define('Gbase_server', ''); 	// Google's FTP address
define('Gbase_userid', ''); 		// Your Google Base FTP username
define('Gbase_password', ''); // Your Google Base FTP password
define('Gbase_datafeed', 'gbase.txt'); 		// Your primary Google Base datafeed filename, must be .txt or .gz (.gz will auto compress the datafeed)
define('Gbase_description', ''); 		// Maximum size of description sent to Google Base, Blank=1024 characters, Max 65536
define('Gbase_images', '3');			// Maximum number of images for Google Base to reference, Blank=no images, valid range 1 to 10
define('Gbase_update_time', ''); 		// Time each day to upload your Google Base datafeed, 24 hour format HH:MM, Blank=23:00 the default
define('product_type', ''); 			// Your main product. Leave blank to use each item's top level category

// DO NOT EDIT BELOW THIS LINE
define('Plugin_timeout','60');			// Plug-in timeout, leave blank unless instructed to change
define('MaxNumItems',100000);			// 100,000 Max items per Google Base
define('MaxChunkSize',100);			// larger requires more memory
define('Gbase_path', 'google_base/'); 	// Path to this script folder, http mode

?>