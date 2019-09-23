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

$option = (in_array($_REQUEST['option'], array('featured', 'recent', 'popular', 'ending'))) ? $_REQUEST['option'] : 'popular';

switch ($option)
{
	case 'featured':
		$page_header_msg = MSG_FEATURED_AUCTIONS;
		$where_query = "WHERE a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0 AND 
			a.list_in!='store' AND a.close_in_progress=0 AND a.hpfeat=1";
		
		$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.end_time'; 
		$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'ASC'; 
		
		break;
	case 'recent':
		$page_header_msg = MSG_RECENTLY_LISTED_AUCTIONS;
		$where_query = "WHERE a.closed=0 AND a.active=1 AND a.approved=1 AND a.deleted=0 AND 
			a.creation_in_progress=0 AND a.list_in!='store'";
		
		$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.start_time'; 
		$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC'; 

		break;
	case 'popular':
		$page_header_msg = MSG_POPULAR_AUCTIONS;
		$where_query = "WHERE a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0 AND 
			a.list_in!='store' AND a.creation_in_progress=0 AND a.nb_bids>0 ";
		//"WHERE a.closed=0 AND a.active=1 AND a.approved=1 AND a.deleted=0 AND a.crea"
		$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.max_bid'; 
		$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC'; 
		break;
	case 'ending':
		$page_header_msg = MSG_ENDING_SOON_AUCTIONS;
		$where_query = "WHERE a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0 AND 
			a.list_in!='store' AND a.creation_in_progress=0";

		$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.end_time'; 
		$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'ASC'; 
		break;
}

$header_browse_auctions = header5($page_header_msg);
/**
 * below we have the variables that need to be declared in each separate browse page
 */
$page_url = 'auctions_show';

$order_field = (in_array($order_field, $auction_ordering)) ? $order_field : 'a.end_time'; 
$order_type = (in_array($order_type, $order_types)) ? $order_type : 'ASC';

$additional_vars = '&option=' . $_REQUEST['option'];

include_once('includes/page_browse_auctions.php');

include_once ('global_footer.php');

echo $template_output;

?>