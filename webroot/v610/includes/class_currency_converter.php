<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

class currency_converter
{
	var $title;
	var $date;
	var $description;
}

function start_element($parser, $name, $attributes)
{
	global $current_tag;

	$current_tag .= "^$name";

}

function end_element($parser, $name) 
{
	global $current_tag;

	$caret_pos = strrpos($current_tag, '^');

	$current_tag = substr($current_tag, 0, $caret_pos);
}

function character_data($parser, $data) 
{ 
	global $current_tag; 
	global $c_title, $c_date, $c_description;

	// now get the items
	global $currencies, $items_count;
	$item_title = "^RSS^CHANNEL^ITEM^TITLE";
	$item_date = "^RSS^CHANNEL^ITEM^PUBDATE";
	$item_description = "^RSS^CHANNEL^ITEM^DESCRIPTION";
	
	if ($current_tag == $item_title) 
	{
		// make new currency_converter
		$currencies[$items_count] = new currency_converter();
	
		// set new item object's properties
		$currencies[$items_count]->title = $data;
	}
	else if ($current_tag == $item_date) 
	{
		$currencies[$items_count]->date = $data;
	}
	else if ($current_tag == $item_description) 
	{
		$currencies[$items_count]->description = $data;
		// increment item counter
		$items_count++;
	}
}

function update_currency_data($currencies, $default_currency)
{
	global $db;
	
	$data = array();
	//add the default currency to the array since it isn't in the feed
	$data[] = array(
		'symbol' => $default_currency, 
		'convert_date' => CURRENT_TIME, 
		'convert_rate' => 1
	);

	for ($i=0;$i<count($currencies);$i++) 
	{
		$converter = $currencies[$i];			
		
		$symbol = array_shift(explode('/', $converter->title));
		$convert_date = strtotime($converter->date);
 		$conversion = explode(' ',trim(array_pop(explode('=', $converter->description))));
 		$convert_rate = array_shift($conversion);

 		$data[] = array(
 			'symbol' => $symbol,
			'convert_date'=>$convert_date,
 			'convert_rate'=>$convert_rate
 		);
	}
	
	// now update currencies table
	foreach ($data as $value)
	{
		$db->query("UPDATE " . DB_PREFIX . "currencies SET 
			convert_rate='" . doubleval($value['convert_rate']) . "', 
			convert_date='" . intval($value['convert_date']) . "' WHERE 
			symbol='" . $db->rem_special_chars($value['symbol']) . "'");
	}
}

// general vars
$c_title = null;
$c_date = null;
$c_description = null;
$currencies = array();
$items_count = 0;

// rss url goes here
$xml_file = RSS_FEED;

// main loop
$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "start_element", "end_element");
xml_set_character_data_handler($xml_parser, "character_data");

if (($fp = fopen($xml_file,"r"))) 
{
	while ($data = fread($fp, 4096)) 
	{
		xml_parse($xml_parser, $data, feof($fp));
	}	
}

xml_parser_free($xml_parser);


?>