<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');

include_once ('global_header.php');

$header_browse_auctions = header5(MSG_AUCTION_SEARCH);
/**
 * below we have the variables that need to be declared in each separate browse page
 */
$page_url = 'auction_search';## PHP Pro Bid v6.00 we will now build the addl_query variable depending on the search type requested
(array) $query = null;
(string) $where_query = null;


if ($_REQUEST['option'] == 'basic_search')## PHP Pro Bid v6.00 quick search - header form
{
	$query[] = "a.closed=0";
}
else if ($_REQUEST['option'] == 'seller_search')
{
	if (!empty($_REQUEST['username']))
	{
		$username = $db->rem_special_chars($_REQUEST['username']);
		$where_query = "LEFT JOIN " . DB_PREFIX . "users su ON su.user_id=a.owner_id ";
		$query[] = "MATCH su.username AGAINST ('" . $username . "*' IN BOOLEAN MODE) AND su.active=1";
	}
}
else if ($_REQUEST['option'] == 'buyer_search')## PHP Pro Bid v6.00 search auctions on which the buyer requested has placed bids
{
	if (!empty($_REQUEST['username']))
	{
		$username = $db->rem_special_chars($_REQUEST['username']);
		$where_query = "LEFT JOIN " . DB_PREFIX . "bids b ON b.auction_id=a.auction_id
			LEFT JOIN " . DB_PREFIX . "users bu ON bu.user_id=b.bidder_id ";
		$query[] = "MATCH bu.username AGAINST ('" . $username . "*' IN BOOLEAN MODE) AND bu.active=1";
	}	
}

if (count($query))
{
	$addl_query = " AND " . $db->implode_array($query, ' AND ');
}
	
$where_query .= "WHERE a.active=1 AND a.approved=1 AND a.deleted=0 AND a.creation_in_progress=0 " . $addl_query;

$order_field = (in_array($_REQUEST['order_field'], $auction_ordering)) ? $_REQUEST['order_field'] : 'a.end_time'; 
$order_type = (in_array($_REQUEST['order_type'], $order_types)) ? $_REQUEST['order_type'] : 'ASC';

## if we are on the page for the first time, we will override the ordering variables
if (!empty($_REQUEST['ordering']))
{
	switch ($_REQUEST['ordering'])
	{
		case 'end_time_asc':
			$order_field = 'a.end_time';
			$order_type = 'ASC';
			break;
		case 'end_time_desc':
			$order_field = 'a.end_time';
			$order_type = 'DESC';
			break;
		case 'start_price_asc':
			$order_field = 'a.start_price';
			$order_type = 'ASC';
			break;
	}
}

include_once('includes/page_browse_auctions.php');

include_once ('global_footer.php');

echo $template_output;

?>