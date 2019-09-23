<?
#################################################################
## PHP Pro Bid v6.05															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');

include_once ('global_header.php');

$seller_username = $db->get_sql_field("SELECT username FROM " . DB_PREFIX . "users WHERE user_id=" . intval($_REQUEST['owner_id']), 'username');
$header_browse_auctions = header5(MSG_OTHER_ITEMS_FROM . ' ' . $seller_username);
/**
 * below we have the variables that need to be declared in each separate browse page
 */
$page_url = 'other_items';
$where_query = "WHERE a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0 AND list_in!='store' AND 
	a.owner_id='" . intval($_REQUEST['owner_id']) . "' AND a.creation_in_progress=0";

$order_field = (in_array($_REQUEST['order_field'], $auction_ordering)) ? $_REQUEST['order_field'] : 'a.end_time'; 
$order_type = (in_array($_REQUEST['order_type'], $order_types)) ? $_REQUEST['order_type'] : 'ASC';

$additional_vars = '&owner_id=' . intval($_REQUEST['owner_id']);

include_once('includes/page_browse_auctions.php');

include_once ('global_footer.php');

echo $template_output;

?>