<?PHP
/*======================================================================*\
|| #################################################################### ||
|| # gbase.php 6.00, for use with PhpProBid script v6.00		          # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright © 2006 RENS Management, LLC. All Rights Reserved.      # ||
|| # This file is licensed under the End User Licensue Agreement at   # ||
|| #                 http://probid.rensmllc.com/eula.pdf              # ||
|| # -----------------  THIS IS NOT FREE SOFTWARE ------------------- # ||
|| #                                                                  # ||
|| # 5.22.1 5/24/2006 Search for Buy it Now items only. Discard items # ||
|| # ending within 24 hours of enddate, Google publishing lag time.   # ||
|| # 5.22.0 First release                                             # ||
|| #################################################################### ||
\*======================================================================*/

$path = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
array_pop($path);
$path = implode(DIRECTORY_SEPARATOR, $path);
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
define('Dir_parent', dirname(__FILE__) . DIRECTORY_SEPARATOR); // Path to this script folder, console mode

define ('IN_PLUGIN', 1);

include_once ('../includes/global.php');
include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_user.php');
include_once ('../includes/class_fees.php');
include_once ('../includes/class_item.php');


include_once ('gbase.cfg.php');
include_once ('functions.inc.php');

$startime = elapse();

// convert args to vars
for ($i=1; $i < $argc; $i++)
{
	parse_str($argv[$i]);
}

// check lock for correct process id
$lockfile = explode(".",Gbase_datafeed);
$extension = array_pop($lockfile);
$lockfile = $lockfile[0].".loc";
$handle = fopen(Dir_parent.$lockfile,'r+b');
fseek($handle,10);
$buffer = fgets($handle,32+1);// fgets reads length-1
/*
if ($buffer!=$process_id) // wrong process
{
	fclose($handle);
	return;
}
*/

// set next update time in datafeed file (11pm tomorrow is default)
$gbase_update_time = (explode(":",Gbase_update_time));
$gbase_update_time[0] = @ltrim($gbase_update_time[0],'0')+0;
$gbase_update_time[1] = @ltrim($gbase_update_time[1],'0')+0;

if (is_numeric($gbase_update_time[0]))
{
	$gbase_update_time[0] = ($gbase_update_time[0]<0 || $gbase_update_time[0]>23) ? 0 : $gbase_update_time[0];
}
else
{
	$gbase_update_time[0] = 0;
}

if (is_numeric($gbase_update_time[1]))
{
	$gbase_update_time[1] = ($gbase_update_time[1]<0 || $gbase_update_time[1]>59) ? $gbase_update_time[1] : $gbase_update_time[1];
}
else
{
	$gbase_update_time[1] = 1;
}

$tomorrow = mktime($gbase_update_time[0]+0, $gbase_update_time[1]+0, 0, date("m"), date("d")+1, date("Y"));

fseek($handle, 0);
ftruncate($handle, 0);
fwrite($handle, $tomorrow);
fclose($handle);

// setup vars
$destination = $setts['admin_email'];
$mailheader = "From: ".$setts['admin_email']."\n";

if (is_numeric(Gbase_description))
{
	$gbase_description=(Gbase_description>0 || Gbase_description<=65536) ? Gbase_description : 1024;
}
else
{
	$gbase_description=1024;
}

if (is_numeric(Plugin_timeout) && Plugin_timeout>0)
{
	$plugin_timeout=Plugin_timeout;
}
else
{
	$plugin_timeout=60;
}

if (is_numeric(Gbase_images))
{
	$gbase_images=(Gbase_images>0 || Gbase_images<=10) ? Gbase_images : 0;
}
else
{
	$gbase_images=0;
}

$gz = (strtolower($extension) == 'gz') ? true : false; // gz means use compression on datafeed file
$tab="\t";
$errmsg=NULL;
$retry=TRUE;

// fetch items per Google Base TOS
$end_time_gbase = CURRENT_TIME + 24 * 60 * 60;

$is_gbase_auctions = $db->count_rows('auctions', "WHERE start_time<" . CURRENT_TIME . " AND end_time>" . $end_time_gbase . " AND
	closed=0 AND active=1 AND approved=1 AND deleted=0 AND buyout_price>0");

$is_gbase_auctions;

if ($is_gbase_auctions > 0) // found some items
{
	$fp = ($gz) ? gzopen(Dir_parent.Gbase_datafeed, "wb") : fopen(Dir_parent.Gbase_datafeed, "wb");

	for($r=0; $r<=$is_gbase_auctions; $r+=MaxChunkSize)
	{
		$results = $db->query("SELECT a.*, c.name AS country_name FROM " . DB_PREFIX . "auctions a
			LEFT JOIN " . DB_PREFIX . "countries c ON c.id=a.country	WHERE 
			a.start_time<" . CURRENT_TIME . " AND a.end_time>" . $end_time_gbase . " AND 
			a.closed=0 AND a.active=1 AND a.approved=1 AND a.deleted=0 AND a.buyout_price>0
			GROUP BY a.auction_id ORDER BY start_time LIMIT " . $r . ", " . MaxChunkSize);

		if (!$results) continue;
		set_time_limit($plugin_timeout); // extent php script timeout
		$items=array();
		$i=0;

		$item = new item();
		$item->setts = &$setts;

		$tax = new tax();

		while ($row = mysql_fetch_assoc($results)) // loop through database fields & build item array
		{
			$labels = NULL;
			$category = get_path($row['category_id']);

			$labels = $db->implode_array($category);

			(string) $payment_accepted = null;
			(array) $payment_acc = null;
			if (!empty($row['direct_payment']))
			{
				$dp_methods = $item->select_direct_payment($row['direct_payment'], $row['owner_id'], true, true);

				$payment_acc[] = MSG_DIRECT_PAYMENT . ': ' . $db->implode_array($dp_methods, ', ');
			}

			if (!empty($row['payment_methods']))
			{
				$offline_payments = $item->select_offline_payment($row['payment_methods'], true, true);

				$payment_acc[] = MSG_OFFLINE_PAYMENT . ': ' . $db->implode_array($offline_payments, ', ');
			}

			$payment_accepted = $db->implode_array($payment_acc, '<br>');

			(string) $images = null;
			(array) $images_array = null;
			if ($gbase_images > 0)
			{
				$sql_select_media = $db->query("SELECT am.media_url FROM " . DB_PREFIX . "auction_media am WHERE
					am.auction_id='" . $row['auction_id'] . "' AND am.media_type=1 AND am.upload_in_progress=0 LIMIT " . $gbase_images);

				$is_media = $db->num_rows($sql_select_media);

				if ($is_media)
				{
					while ($media_row = $db->fetch_array($sql_select_media))
					{
						$images_array[] = "{$setts['site_path']}{$media_row['media_url']}";
					}

					$images = $db->implode_array($images_array, ', ');
				}
			}

			$items[$i]['title'] = utf8_convert(clean_string($row['name']));
			$items[$i]['description'] = utf8_convert(clean_string($row['description'], $gbase_description));
			$items[$i]['link'] = utf8_convert($setts['site_path'] . 'auction_details.php?auction_id=' . $row['auction_id']);
			$items[$i]['image_link'] = utf8_convert($images);
			$items[$i]['id'] = utf8_convert($setts['site_path'] . 'auction_details.php?auction_id=' . $row['auction_id']);
			$items[$i]['expiration_date'] = date("Y-m-d",$row['end_time']);
			$items[$i]['labels'] = utf8_convert($labels);
			$items[$i]['price'] = utf8_convert($row['buyout_price']);
			$items[$i]['price_type'] = utf8_convert("starting");
			$items[$i]['currency'] = $row['currency'];
			$items[$i]['delivery_notes'] = utf8_convert($row['shipping_details']);
			$items[$i]['payment_accepted'] = utf8_convert($payment_accepted);
			$items[$i]['payment_notes'] = '';
			$items[$i]['quantity'] = $row['quantity'];
			$items[$i]['brand'] = '';
			$items[$i]['upc'] = '';
			$items[$i]['isbn'] = '';
			$items[$i]['manufacturer'] = '';
			$items[$i]['manufacturer_id'] = '';
			$items[$i]['memory'] = '';
			$items[$i]['processor_speed'] = '';
			$items[$i]['model_number'] = '';
			$items[$i]['size'] = '';
			$items[$i]['weight'] = '';
			$items[$i]['condition'] = '';
			$items[$i]['color'] = '';
			$items[$i]['actor'] = '';
			$items[$i]['artist'] = '';
			$items[$i]['author'] = '';
			$items[$i]['format'] = '';
			$items[$i]['product_type']= utf8_convert((product_type=='') ? $category[0] : product_type);

			$items[$i]['location'] = $item->item_location($row) . ', ' . $tax->display_countries($row['country']);

			if ($r == 0 && $i == 0)
			{ // write header
				$header = implode($tab, array_keys($items[0]));
				if ($lockfile[1]=='gz')
				{
					gzputs($fp, $header."\n"); // write header compressed
				}
				else
				{
					fputs($fp, $header."\n");   // write header in plain text
				}
			}
			$i++;
		} // end while

		// build datafeed file with item chunks
		(string) $body = null;
		foreach ($items as $item)
		{
			foreach ($item as $value)
			{
				$body .= $value . $tab;
			}

			$body = substr($body, 0, -1); // get rid of last tab
			$body .= "\n";
		}

		if ($gz)
		{
			gzputs($fp, $body);
		}
		else
		{
			fputs($fp, $body);
		}

	} // end for

	if ($gz)
	{
		gzclose($fp);
		$transfer_mode = FTP_BINARY;
	}
	else
	{
		fclose($fp);
		$transfer_mode=FTP_ASCII;
	}

	// send feed to Google Base via ftp
	$fs = filesize(Dir_parent . Gbase_datafeed);
	$fs = ceil($fs/pow(1024,2));
	set_time_limit($plugin_timeout * $fs); // extent php script timeout * file size in MB
	$conn_id = ftp_connect(Gbase_server);
	$login_result = @ftp_login($conn_id, Gbase_userid, Gbase_password);
	@ftp_pasv ( $conn_id, true ); // turn passive mode on

	if ((!$conn_id) || (!$login_result))
	{
		$errmsg .= "FTP connection has failed connecting to ".Gbase_server." for user ".Gbase_userid;
	}
	else
	{
		// upload a file
		set_time_limit($plugin_timeout); // extent php script timeout
		if (ftp_put($conn_id, Gbase_datafeed, Dir_parent.Gbase_datafeed, $transfer_mode))
		{
			$retry=FALSE;
			$errmsg.="Successfully uploaded {$setts['sitename']} Google Base Feed:\n\n".Dir_parent.Gbase_datafeed;
		}
		else
		{
			$errmsg.="Error uploading ".Dir_parent.Gbase_datafeed;
		}
		@ftp_close($conn_id); // close the connection
	}
}
else
{ // nothing found
	$errmsg.="Error - No listings found for Google Base upload";
}

if ($retry)
{ // got error. set to retry in 1 hour.
	$retry=time()+3600;
	$handle = fopen(Dir_parent.$lockfile,'wb');
	fwrite($handle, $retry);
	fclose($handle);
	$errmsg.=". Will retry in 1 hour.";
}

$startime=round((elapse()-$startime),2);
error_log($errmsg."\n\nTotal processing time $startime seconds.", 1, $destination, $mailheader);
?>