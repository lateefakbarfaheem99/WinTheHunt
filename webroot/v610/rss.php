<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

define('RSSlang', 1); // Language English=1, Chinese=2
define('RSSlogo', 'images/probidlogo.gif'); // logo must be relative to site url
define('RSSdepth', 10); // number of items to display.
define('RSStitle1', 'Just Listed');
define('RSStitle2', 'Closing Soon');
define('RSStitle3', 'Featured Items');
define('RSStitle4', 'Big Ticket');
define('RSStitle5', 'Very Expensive');
define('RSStitle6', 'Under $10');
define('RSStitle7', 'Warm Items');
define('RSStitle8', 'Hot Items');
define('RSStitle9', 'Buy Now');
define('RSS10', 10);     // items $10 and under
define('RSS300', 300);   // items $300 and more
define('RSS1000', 1000); // items $1000 and more
define('RSSwarm', 10);   // items with 10 or more bids
define('RSShot', 25);    // items with 25 or more bids

// DO NOT EDIT BELOW THIS LINE

define ('IN_SITE', 1);

include_once ('includes/global.php');

$charset = 'ISO-8859-1';
$langcode = 'en-us';

function utf8_convert($string) 
{
	return utf8_encode($string);
}

function get_path($node) // look up the parent of this node
{ 
	global $db;
	$path = array(); // save the path in this array
	
	$row = $db->get_sql_row("SELECT parent_id,name FROM " . DB_PREFIX . "categories WHERE category_id='".$node."'");

	if ($row['parent_id']>0) // only continue if this $node isn't the parent node
	{ 
		$path[] = $row['name']; // the last part of the path to $node, is the name of the parent of $node
		$path = array_merge(get_path($row['parent_id']), $path); // add the path to the parent of this node to the path
	}
	return $path; // return the path
}

function unhtmlspecialchars ($string) 
{
	$string = str_replace ('&#039;', '\'', $string);
	$string = str_replace ('%23', '\"', $string);
	$string = str_replace ('&quot;', '\"', $string);
	$string = str_replace ('&lt;', '<', $string);
	$string = str_replace ('&gt;', '>', $string);
	//$string = str_replace ('&amp;', '&', $string);
	$string = str_replace ('&nbsp;', ' ', $string);
	$string = stripslashes($string);

	return $string;
}

function clean_string ($string, $maxchars=1200) 
{

	/*
	* No extra repeat characters.
	* No spaces in begining of field.
	* No spaces in ending of field.
	* No extra spaces in body of field.
	* Remove all quotes.
	* Max field size is approx 1024 characters.
	* Do not truncate words.
	* Do not concatinate words.
	* Remove all html tags.
	* Remove single character words such as @,#,!,^,&,*,(, etc
	*/

	$space = array("&nbsp;","<br>","<BR>","<br/>","<br />","\r\n","\r","\n","\t","\v");
	$tags = array("applet","meta","xml","blink","link","style","script","embed","object","iframe","frame","frameset","ilayer","layer","bgsound","title","base");
	$string = unhtmlspecialchars($string);
	$string = str_replace($space, ' ', $string);
	$string = str_replace("&039;", ' ', $string);
	
	foreach ($tags as $tag) 
	{
		$string = preg_replace("@<".$tag."[^>]*?>.*?</".$tag.">@si", "", $string);
	}
	
	$string = preg_replace('#[\x00-\x1F\"\']#i',"",$string);
	$string = preg_replace('#[\x7F-\xFF\"\']#i',"",$string);
	$string = strip_tags($string);
	$string = stripslashes($string);
	//$string = preg_replace("/[^[:blank:][:alnum:]\+,;.!:$%&@?/)(_-]/", " ", $string);
	$string = preg_replace('/\s+/'," ",$string);
	$string = trim($string);
	$words = explode(" ",$string);
	$string = array();
	$single_chars = array("+",",",";",".","!",":","$","%","&","@","?","/",")","(","_","-");
	
	foreach ($words as $word) 
	{
		foreach ($single_chars as $single_char) 
		{
			$pattern = "/\\".$single_char."+/";
			$word = preg_replace("$pattern",$single_char,$word);
		}
    	if (strlen($word)==1 && !preg_match('/^[aAiIxX\+\-]/',$word)) continue;
		$string[]=$word;
	}
	
	$string = implode(" ",$string); // array to string
	$maxchars = (strlen($string)>$maxchars) ? $maxchars : strlen($string);
	$string = substr($string,0,$maxchars);
	$string = implode(" ",explode(" ",$string,str_word_count($string)-1));

	return $string;
}

$user_id = intval($_REQUEST['user_id']);

$feed = intval($_REQUEST['feed']);
$feed = (!$feed) ? 1 : $feed;

switch ($feed)
{
	case 1: 
		$RSStitle = RSStitle1; // items listed in the last 24 hours
		$postdate = 'start_time';
		$sort = 'DESC';
		$subquery = 'start_time<=' . CURRENT_TIME . ' AND start_time>' . (CURRENT_TIME - (24 * 60 * 60));
		break;

	case 2: 
		$RSStitle = RSStitle2; // items closing in 24 hours or less
		$postdate='end_time';
		$sort = 'ASC';
		$subquery = 'start_time<=' . CURRENT_TIME . ' AND end_time<=' . (CURRENT_TIME + (24 * 60 * 60));
		break;

	case 3: 
		$RSStitle=RSStitle3; // homepage items
		$postdate = 'start_time';
		$sort = 'DESC';
		$subquery = 'start_time<=' . CURRENT_TIME . ' AND hpfeat=1';
		break;

	case 4: 
		$RSStitle = RSStitle4; // items over 300.00
		$postdate = 'end_time'; 
		$sort = 'ASC';
		$subquery = 'start_time<=' . CURRENT_TIME . ' AND (max_bid >= ' . RSS300 . ' OR start_price >= ' . RSS300 . ' OR buyout_price >= ' . RSS300 . ')';
		break;

	case 5: 
		$RSStitle = RSStitle5; // items over 1000.00
		$postdate = 'end_time'; 
		$sort = 'ASC';
		$subquery = 'start_time<=' . CURRENT_TIME . ' AND (max_bid >= ' . RSS1000 . ' OR start_price >= ' . RSS1000 . ' OR buyout_price >= ' . RSS1000 . ')';
		break;

	case 6: 
		$RSStitle = RSStitle6;
		$postdate = 'start_time';
		$sort = 'DESC';
		$subquery = 'start_time<=' . CURRENT_TIME . ' AND (max_bid <= ' . RSS10 . ' AND start_price <= ' . RSS10 . ')';
		break;

	case 7: 
		$RSStitle = RSStitle7; // items with 10 or more bids
		$postdate = 'start_time';
		$sort = 'DESC';
		$subquery = 'nb_bids >= ' . RSSwarm;
		break;

	case 8: 
		$RSStitle = RSStitle8; // items with 25 or more bids
		$postdate = 'start_time';
		$sort = 'DESC';
		$subquery = 'nb_bids >= ' . RSShot;
		break;

	case 9: 
		$RSStitle = RSStitle9; // item with a Buy Now
		$postdate = 'start_time';
		$sort = 'DESC';
		$subquery = 'start_time<=' . CURRENT_TIME . ' AND buyout_price>0';
		break;

	default:
		if ($user_id>0) // setup query for specific users
		{ 
			$username = ucfirst($db->get_sql_field("SELECT username FROM " . DB_PREFIX . "users WHERE user_id='" . $user_id . "'", 'username'));
			$postdate = 'start_time';
			$sort = 'DESC';
			$subquery = 'start_time<=' . CURRENT_TIME . ' AND end_time>' . CURRENT_TIME . ' AND owner_id=' . $user_id;
			$RSStitle = 'Listings posted by ' . $username;
		} 
		else // no user specified
		{
			$RSStitle = RSStitle1;
			$postdate = 'start_date';
			$sort = 'DESC';
			$subquery = 'start_time<=' . CURRENT_TIME . ' AND start_time>' . (CURRENT_TIME - (24 * 60 * 60));
		}
		break;
}

$limit = ($user_id > 0) ? '' : 'LIMIT ' . RSSdepth;

$results = $db->query("SELECT a.auction_id, a.name, a." . $postdate . " AS postdate, a.description, a.max_bid, 
	a.nb_bids, a.currency, a.category_id, a.closed, a.bold, a.hl, a.buyout_price, a.is_offer, a.start_price, 
	a.reserve_price, am.media_url, u.username FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "auction_media am ON a.auction_id=am.auction_id AND am.media_type=1 AND am.upload_in_progress=0 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.closed=0 AND a.active=1 AND a.approved=1 AND a.deleted=0 
	" . ((!empty($subquery)) ? " AND " . $subquery : "") . "	
	GROUP BY a.auction_id ORDER BY " . $postdate . " " . $sort . " " . $limit);

$numrows = $db->num_rows($results);

// RSS 2.0 item information
$items=array();

$timezone = $db->get_sql_field("SELECT value FROM " . DB_PREFIX . "timesettings WHERE active=1", 'value');
$timezone = explode('-', $timezone);
$tz = sprintf('%05s', $timezone[count($timezone)-1] . ':00');
$timezone = (count($timezone)-1) ? '-' . $tz : '+' . $tz;

while ($row=@mysql_fetch_assoc($results)) // loop through database fields & build item array
{
	$price = $fees->display_amount(($row['max_bid']>0) ? $row['max_bid'] : $row['start_price'], $row['currency']);

	$picpath = null;
	if (!empty($row['media_url'])) 
	{
		$picpath = '<img alt="' . $row['name'] . '" border="0" src="' . SITE_PATH . 'thumbnail.php?pic=' . $row['media_url'] . '&w=100"><br><br>';
	}

	$items['title'][]	= utf8_convert(clean_string($row['name'])). ' - ' . $price;
	$items['link'][]		= utf8_encode(SITE_PATH . 'auction_details.php?auction_id=' . $row['auction_id']);
	$items['desc'][]		= utf8_convert(clean_string($row['description']));
	$items['pubDate'][]	= utf8_encode(date('Y-m-d', $row['postdate']) . 'T' . date('H:i:s', $row['postdate']) . $timezone);
	$items['category'][]	= utf8_convert(clean_string(implode(' : ', get_path($row['category_id']))));
	$items['creator'][]	= utf8_convert(ucfirst($row['username']));
}

header("Content-Type: text/xml;charset=" . $charset);

// display RSS 2.0 channel information
$RSSlogo=RSSlogo;

echo <<<START
<?xml version="1.0" encoding="$charset"?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
	<title>$RSStitle: {$setts['sitename']}</title>
	<link>{$setts['site_path']}</link>
	<description>{$setts['sitename']}</description>
<image>
	<url>{$setts['site_path']}$RSSlogo</url>
	<title>{$setts['sitename']}</title>
	<link>{$setts['site_path']}</link>
</image>

<language>$langcode</language>
<copyright>Copyright {$setts['sitename']}. The contents of this feed are available for non-commercial use only.</copyright>
<generator>{$setts['site_path']}</generator>
<!-- RSS-Items -->
START;

// display items
for ($i=0; $i<$numrows; $i++) {

	echo <<<ITEM

<item>
	<title>{$items['title'][$i]}</title>
	<link>{$items['link'][$i]}</link>
	<guid isPermaLink="true">{$items['link'][$i]}</guid>
	<description>{$items['desc'][$i]}</description>
    <dc:creator>{$items['creator'][$i]}</dc:creator>
	<dc:date>{$items['pubDate'][$i]}</dc:date>
    <category>{$items['category'][$i]}</category>
</item>

ITEM;

}


echo <<<END
<!-- / RSS-Items PHP/RSS -->
</channel>
</rss>

END;

?>