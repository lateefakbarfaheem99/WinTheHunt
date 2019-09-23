<?
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

include_once ('includes/global.php');

if (!$start)
{
	$db->query("UPDATE " . DB_PREFIX . "categories SET items_counter=0, wanted_counter=0");
	
	$sql_select_wanted_ads = $db->query("SELECT category_id,addl_category_id FROM 
		" . DB_PREFIX . "wanted_ads WHERE active=1 AND closed=0 AND deleted=0");
	
	while ($item_details = mysql_fetch_array($sql_select_wanted_ads)) {
		wanted_counter($item_details['category_id'], 'add');
		wanted_counter($item_details['addl_category_id'], 'add');
	}
}

$limit = 1000;

$where_query = "WHERE active=1 AND approved=1 AND closed=0 AND deleted=0 AND list_in!='store'";

$nb_auctions = $db->count_rows('auctions', $where_query);

$total_steps = ceil($nb_auctions/$limit);

$sql_select_auctions = $db->query("SELECT auction_id,category_id,addl_category_id FROM 
	" . DB_PREFIX . "auctions " . $where_query . " LIMIT " . $start . ", " . $limit);

while ($item_details = $db->fetch_array($sql_select_auctions)) 
{
	auction_counter($item_details['category_id'], 'add', $item_details['auction_id']);
	auction_counter($item_details['addl_category_id'], 'add', $item_details['auction_id']);
}

$next = $start + $limit;

echo 'Counting in progress .. [ Step ' . ($next/$limit) . ' / ' . $total_steps . ' ]';

if ($next < $nb_auctions)
{
		echo '<script language="JavaScript" type="text/javascript">'.
		'window.setTimeout(\'location.href="initialize_counters_step.php?start=' . $next . '"\', 600);</script> ';	
}
else 
{
	echo "<p>Operation Successful. Auctions and Wanted Ads Counters Refreshed.</p>";
}
?>