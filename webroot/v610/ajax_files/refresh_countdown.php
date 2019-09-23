<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 
header("Expires: Fri, 1 Jan 2010 08:00:00 GMT"); // Date in the past 

session_start();

define ('IN_SITE', 1);
define ('IN_AJAX', 1);

include_once('../includes/global.php');

$auction_id = intval($_REQUEST['auction_id']);

$end_time = $db->get_sql_field("SELECT end_time FROM " . DB_PREFIX . "auctions WHERE auction_id='" . $auction_id . "'", 'end_time');

echo $end_time - CURRENT_TIME;
?>