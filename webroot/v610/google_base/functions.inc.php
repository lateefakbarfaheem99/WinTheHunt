<?php
/*======================================================================*\
|| #################################################################### ||
|| # functions.inc.php 6.00, for use with PhpProBid v6.00+				 # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright © 2005 RENS Management, LLC. All Rights Reserved.      # ||
|| # This file is licensed under the End User Licensue Agreement at   # ||
|| #                 http://probid.rensmllc.com/eula.pdf              # ||
|| # -----------------  THIS IS NOT FREE SOFTWARE ------------------- # ||
|| #                                                                  # ||
|| #################################################################### ||
\*======================================================================*/

function elapse() 
{
	$time = explode(' ', microtime());
	$usec = (double)$time[0];
	$sec = (double)$time[1];
	return ($sec + $usec);
}

function unhtmlspecialchars ($string) 
{
	$string = str_replace ('&#039;', '\'', $string);
	$string = str_replace ('%23', '\"', $string);
	$string = str_replace ('&quot;', '\"', $string);
	$string = str_replace ('&lt;', '<', $string);
	$string = str_replace ('&gt;', '>', $string);
	$string = str_replace ('&amp;', '&', $string);
	$string = str_replace ('&nbsp;', ' ', $string);
	$string = stripslashes($string);

	return $string;
}

function utf8_convert($string)
{
	return utf8_encode(htmlspecialchars($string,ENT_COMPAT));
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

function clean_string ($string, $maxchars=1024) 
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
	$string = preg_replace("/[^[:blank:][:alnum:]\+,;.!:$%&@?/)(_-]/", " ", $string);
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
?>