<?php
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################
define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');
include_once ('includes/functions_login.php');

include ("pbulkupdate.php");

if(!isset($_REQUEST['username']) || ($_REQUEST['username']=="") || !isset($_REQUEST['password']) || ($_REQUEST['password']=="") || !isset($_REQUEST['request']) || ($_REQUEST['request']==""))
die("<BADLOGIN>");

$username			= $_REQUEST['username'];
$pwd    	      	= $_REQUEST['password'];
$password			= $pwd; ## the error!
$request	      	= $_REQUEST['request'];
$paxreq           = $_REQUEST['paxreq'];
$buildversion     = "1.02";

# do not edit these values
$prefilled        = "";
$customcatfields  = "";
$customcattypes   = "";
$active_store     = "0";
$store_cats       = "";
$sep              = "[]";
$bannertype       = 2;
$bannertime       = "20000"; // 1000 per second.. min time 10 seconds maximum time 120 seconds

## Set your version
$pwdlen=30;

if($request == "config") 
{
	## if config is required
	$salt = $db->get_sql_field("SELECT salt FROM " . DB_PREFIX . "users WHERE username='" . $username . "'", "salt");
	
	$password_hashed = password_hash($password, $salt);
	$password_old = substr(md5($password), 0, 30); ## added for backward compatibility (v5.25 and older versions)
	
	$login_query = $db->query("SELECT * FROM " . DB_PREFIX . "users WHERE username='" . $username . "' AND 
		(password='" . $password_hashed . "' OR password='" . $password_old . "') LIMIT 0,1");
	
	$is_login = $db->num_rows($login_query);
	if(!$is_login)
	{
		echo "<BADLOGIN>";
		die;
	}
	$result=$db->query("SELECT * FROM " . DB_PREFIX . "users WHERE	username='" . $username . "' AND 
		(password='" . $password_hashed . "' OR password='" . $password_old . "') LIMIT 0,1");

	if ($userinfo=mysql_fetch_array($result)) 
	{
		## Get prefilled defaults

		$active_store            = $userinfo['shop_active'];
		$store_cats              = $userinfo['shop_categories'];
		$def_duration            = $userinfo['default_duration'];
		$def_private             = $userinfo['default_hidden_bidding'];
		$def_isswap              = $userinfo['default_enable_swap'];
		$def_sc                  = $userinfo['default_shipping_method'];
		$def_scint               = $userinfo['default_shipping_int'];
		$def_pm                  = $userinfo['default_payment_methods'];
		$def_postage_costs       = $userinfo['default_postage_amount'];
		$def_insurance           = $userinfo['default_insurance_amount'];
		$def_type_service        = $userinfo['default_type_service'];
		$def_shipping_details    = $userinfo['default_shipping_details'];
		$cat_userid              = $userinfo['user_id'];

		$def_city                = $userinfo['city'];
		$def_zip                 = $userinfo['zip_code'];

		$def_state               = $userinfo['state'];
		$mystate  = mysql_query("SELECT * FROM " . DB_PREFIX . "countries WHERE id = $def_state");
		$myres1=mysql_fetch_row($mystate);
		$def_state = $myres1[1];
		mysql_free_result($mystate);

		$def_country             = $userinfo['country'];
		$mycountry  = mysql_query("SELECT * FROM " . DB_PREFIX . "countries WHERE id = $def_country");
		$myres2=mysql_fetch_row($mycountry);
		$def_country = $myres2[1];
		mysql_free_result($mycountry);
		$prefilled               = "$def_duration$sep$def_private$sep$def_isswap$sep$def_sc$sep$def_scint$sep$def_pm$sep$def_postage_costs$sep$def_insurance$sep$def_type_service$sep$def_shipping_details$sep";

		## Get durations...

		$getdurations  =mysql_query("SELECT * FROM " . DB_PREFIX . "auction_durations WHERE 1 ORDER BY days");
		$num_durations = mysql_num_rows($getdurations);
		
		if ($num_durations) 
		{
			while ($myrow = mysql_fetch_row($getdurations)) echo "<PDUR>$myrow[1]\n";
		}
		mysql_free_result($getdurations);

		## Get currencies...

		$getcurrencies  = mysql_query("SELECT * FROM " . DB_PREFIX . "currencies WHERE 1");
		$num_currencies = mysql_num_rows($getcurrencies);
		
		if ($num_currencies) 
		{
			while ($myrow = mysql_fetch_row($getcurrencies)) echo "<PCURR>$myrow[1]\n";
		}
		mysql_free_result($getcurrencies);

		## Get countries...  	# 1 = name ; 2 = theorder

		$getcountries  = mysql_query("SELECT * FROM " . DB_PREFIX . "countries WHERE 1");
		$num_countries = mysql_num_rows($getcountries);
		if ($num_countries) 
		{
			while ($myrow = mysql_fetch_row($getcountries)) echo "<PLOC>$myrow[1]$sep$myrow[2]$sep$myrow[3]$sep\n";
		}
		mysql_free_result($getcountries);

		## Get payment methods...

		$getpaymethods  = mysql_query("SELECT * FROM " . DB_PREFIX . "payment_gateways WHERE dp_enabled = 1");
		$num_paymethods = mysql_num_rows($getpaymethods);
		if ($num_paymethods) 
		{
			while ($myrow = mysql_fetch_row($getpaymethods))
			{
				(string) $dp_status = null;
				$dp_id = $myrow[0];
				$dp_name = $myrow[1];
				switch ($dp_name)
				{
					case 'PayPal':
						$dp_status = ($userinfo['pg_paypal_email']) ? '' : 'disabled';
						break;
					case 'Worldpay':
						$dp_status = ($userinfo['pg_worldpay_id']) ? '' : 'disabled';
						break;
					case '2Checkout':
						$dp_status = ($userinfo['pg_checkout_id']) ? '' : 'disabled';
						break;
					case 'Nochex':
						$dp_status = ($userinfo['pg_nochex_email']) ? '' : 'disabled';
						break;
					case 'Ikobo':
						$dp_status = ($userinfo['pg_ikobo_username'] && $userinfo['pg_ikobo_password']) ? '' : 'disabled';
						break;
					case 'Protx':
						$dp_status = ($userinfo['pg_protx_username'] && $userinfo['pg_protx_password']) ? '' : 'disabled';
						break;
					case 'Authorize.net':
						$dp_status = ($userinfo['pg_authnet_username'] && $userinfo['pg_authnet_password']) ? '' : 'disabled';
						break;
				}
				if($dp_status != 'disabled')
				echo "<PMETH>$dp_id*$dp_name\n";
			}
		}
		mysql_free_result($getpaymethods);
		## Get payment methods...OPTIONS

		$getpaymethods  = mysql_query("SELECT * FROM " . DB_PREFIX . "payment_options WHERE 1");
		$num_paymethods = mysql_num_rows($getpaymethods);
		if ($num_paymethods) 
		{
			while ($myrow = mysql_fetch_row($getpaymethods)) echo "<PMETH2>$myrow[0]*$myrow[1]\n";
		}
		mysql_free_result($getpaymethods);

		## Get shipping options...

		$getshipoptions  = mysql_query("SELECT * FROM " . DB_PREFIX . "shipping_options WHERE 1");
		$num_shipoptions = mysql_num_rows($getshipoptions);
		
		if ($num_shipoptions){
			while ($myrow = mysql_fetch_row($getshipoptions)) echo "<PSHIP>$myrow[1]\n";
		}
		mysql_free_result($getshipoptions);

		## Get categories...  2 = name ; 0 = id ; 1 = parent ; 5 = thorder

		$getcategories  = mysql_query("SELECT * FROM " . DB_PREFIX . "categories WHERE 1");
		$num_categories = mysql_num_rows($getcategories);
		
		if ($num_categories)
		{
			while ($myrow = mysql_fetch_row($getcategories))
			{
				if($myrow[12] == 0 or $myrow[12]==$cat_userid)
				{
					if($myrow[4] == 0)
					{
						echo "<PCATS>$myrow[2]$sep$myrow[0]$sep$myrow[1]$sep$myrow[3]$sep\n";
					}
				}
			}
		}
		mysql_free_result($getcategories);

		mysql_free_result($result);

		echo "<PREFILLED>$prefilled\n";
		echo "<STOREACTIVE>$active_store\n";
		echo "<STORECATS>$store_cats\n";
		echo "<MAXRELIST>$setts[nb_autorelist_max]\n";
		echo "<MYIMPORTS>$usemyimports\n";
		echo "<VOUCHERS>$usevouchers\n";
		echo "<MYEBAY>$usemyebay\n";
		echo "<PPICSIZE>$setts[images_max_size]\n";
		echo "<PSITENAME>$setts[sitename]\n";
		echo "<PSITEURL>$setts[site_path]\n";
		echo "<PCURRSYM>$setts[currency]\n";
		echo "<ALLOWHPDESC>$setts[enable_hpfeat_desc]\n";
		echo "<ALLOWSWAP>$setts[enable_swaps]\n";
		echo "<MYCITY>$def_city\n";
		echo "<MYSTATE>$def_state\n";
		echo "<MYAREA>$def_zip\n";
		echo "<MYCOUNTRY>$def_country\n";
		echo "<MAXMOVIE>$setts[media_max_size]\n";  // Value is numeric
		echo "<BUYOUT>$setts[buyout_process]\n";  // Value is 1 or 0
		echo "<UPGRADEPATH>$download_path\n";
		echo "<BUILDVER>$buildversion\n";         // new version number
	} 
	else 
	{
		echo "<BADLOGIN>";
	}

	## end of if config is required
} 
else if($request == "loginchk") 
{

	## if login check is required

	$salt = $db->get_sql_field("SELECT salt FROM " . DB_PREFIX . "users WHERE username='" . $username . "'", "salt");

	$password_hashed = password_hash($password, $salt);
	$password_old = substr(md5($password), 0, 30); ## added for backward compatibility (v5.25 and older versions)

	$login_query = $db->query("SELECT user_id, username, active, approved, salt, payment_status, 
		is_seller FROM " . DB_PREFIX . "users WHERE username='" . $username . "' AND 
		(password='" . $password_hashed . "' OR password='" . $password_old . "') LIMIT 0,1");

	$is_login = $db->num_rows($login_query);
	
	/*
	$fp = fopen('bulk_debug.txt', 'a');
	fwrite($fp, 'Username: ' . $username . '; Password: ' . $password . '; IS Login: ' . $is_login . '\n');
	fclose($fp);
	*/
	
	if($is_login)
	{
		echo "<GOODLOGIN>";
	}
	else
	{
		echo "<BADLOGIN>";
		die;
	}


	## end of if login check is required
}
else if($request == "versionchk") 
{
	## if version check is required
	$salt = $db->get_sql_field("SELECT salt FROM " . DB_PREFIX . "users WHERE username='" . $username . "'", "salt");

	$password_hashed = password_hash($password, $salt);
	$password_old = substr(md5($password), 0, 30); ## added for backward compatibility (v5.25 and older versions)

	$login_query = $db->query("SELECT user_id, username, active, approved, salt, payment_status, 
		is_seller FROM " . DB_PREFIX . "users WHERE username='" . $username . "' AND 
		(password='" . $password_hashed . "' OR password='" . $password_old . "') LIMIT 0,1");

	$is_login = $db->num_rows($login_query);
	
	if($is_login)
	{
		echo "<UPGRADEPATH>$download_path\n";
		echo "<BUILDVER>$buildversion\n";         // new version number
	}
	else
	{
		echo "<BADLOGIN>";
		die;
	}
	## end of if version check is required
}
else if($request == "banner")
{
	if($bannertype > 0)
	{
		//seehere
		$getAdvert=mysql_query("SELECT * FROM " . DB_PREFIX . "adverts WHERE
			(views_purchased=0 OR views_purchased>=views) AND (clicks_purchased=0 OR clicks_purchased>=clicks) AND advert_type = '0' ORDER BY RAND() LIMIT 0,1");

		while ($bannerDetails = mysql_fetch_array($getAdvert)) 
		{
			$addView = mysql_query ("UPDATE " . DB_PREFIX . "adverts SET views=views+1 WHERE id='".$bannerDetails['id']."'");
			echo "<BCONFIG>$sep$bannertime\n";
			
			if ($bannerDetails['advert_type']=="0") 
			{
				$val1 = $bannerDetails['advert_id'];
				$val2 = $bannerDetails['advert_img_path'];
				echo "click.php?refid=$val1$sep$val2$sep";
			} 
			else if ($bannerDetails['advert_type']=="1") 
			{
				echo $bannerDetails['advert_code'];
			}
		}
		mysql_free_result($getAdvert);
	}
	else
	echo "<NOBANNERS>\n";
}

else if($request == "import") 
{
	## if config is required

	$sep2="|";

	$salt = $db->get_sql_field("SELECT salt FROM " . DB_PREFIX . "users WHERE username='" . $username . "'", "salt");

	$password_hashed = password_hash($password, $salt);
	$password_old = substr(md5($password), 0, 30); ## added for backward compatibility (v5.25 and older versions)

	$login_query = $db->query("SELECT * FROM " . DB_PREFIX . "users WHERE username='" . $username . "' AND 
		(password='" . $password_hashed . "' OR password='" . $password_old . "') LIMIT 0,1");
	$is_login = $db->num_rows($login_query);
	
	if(!$is_login)
	{
		echo "<BADLOGIN>";
		die;
	}
	if ($userinfo=mysql_fetch_array($login_query)) 
	{
		$useridnum = $userinfo['user_id'];

		if($paxreq == "closed")
		{
			$rs_sqlitems = "SELECT * FROM " . DB_PREFIX . "auctions WHERE owner_id = '$useridnum' AND closed = '1' AND active = '1' LIMIT 2000";
			$rs_items=mysql_query($rs_sqlitems);
			
			while ($row = mysql_fetch_array($rs_items))
			{
				$pid                  = $row['auction_id'];
				$pownerid             = $row['owner_id'];
				$pitemname      	  = $row['name'];
				$pdescription   	  = $row['description'];
				$pcategory      	  = $row['category_id'];
				$pcategory2      	  = $row['addl_category_id'];
				$pquantity      	  = $row['quantity'];
				$pauctiontype   	  = $row['auction_type'];
				$pcurrency      	  = $row['currency'];
				$pbidstart            = $row['start_price'];
				$prp                  = "0";
				$prpvalue       	  = $row['reserve_price'];
				if($prpvalue != 0.00)
				$prp                = "1";
				$pbn                  = "0";
				$pbnvalue       	  = $row['buyout_price'];
				if($pbnvalue != 0.00)
				$pbn                  = "1";
				$pbi                  = "0";
				$pbivalue       	  = $row['bid_increment_amount'];
				if($pbivalue != 0.00)
				$pbi                  = "1";
				$pduration      	  = $row['duration'];
				$psc            	  = $row['shipping_method'];
				$pscint         	  = $row['shipping_int'];
				$pdpm                 = $row['direct_payment'];
				$ppm            	  = $row['payment_methods'];
				$ppostage_costs 	  = $row['postage_amount'];
				$pshipping_details    = $row['shipping_details'];
				$ptype_service        = $row['type_service'];
				$pinsurance           = $row['insurance_amount'];
				$phpfeat              = $row['hpfeat'];
				$phpfeat_desc         = $row['hpfeat_desc'];
				$pcatfeat             = $row['catfeat'];
				$pbolditem            = $row['bold'];
				$phlitem              = $row['hl'];
				$pprivate             = $row['hidden_bidding'];

				$relisttimes          = $row['auto_relist_nb'];
				$relist               = "0";
				if($relisttimes >0)
				$relist               = "1";
				$relistalways         = $row['auto_relist_bids'];
				$pisswap              = $row['enable_swap'];
				$ppicpath             = "";
				$phasimg              = "0";
				$potherpics           = "";
				$customdata           = "";
				$listin               = $row['list_in'];
				$pactive              = $row['active'];
				$pclosed              = $row['closed'];
				$usebuyout            = "0";
				$buyout1              = "0.00";
				$buyout2              = "0.00";

				if($setts['buyout_process']>0)
				{
					$usebuyout            = $row['is_offer'];
					$buyout1              = $row['offer_min'];
					$buyout2              = $row['offer_max'];
				}
				$pdescription = html_entity_decode($pdescription);
				/////////////// catname extraction /////////////
				$pcategory_name  = "";
				$pcategory2_name = "";

				if($pcategory != "")
				{
					$catresult=mysql_query("SELECT * FROM " . DB_PREFIX . "categories WHERE category_id='$pcategory'");
					if ($catinfo=mysql_fetch_array($catresult)) {
						$pcategory_name = $catinfo['name'];
					}
				}
				if($pcategory2 != "")
				{
					$catresult=mysql_query("SELECT * FROM " . DB_PREFIX . "categories WHERE category_id='$pcategory2'");
					if ($catinfo=mysql_fetch_array($catresult)) {
						$pcategory2_name = $catinfo['name'];
					}
				}

				$curr_pic=0;
				$rs_pics = "SELECT * FROM " . DB_PREFIX . "auction_media WHERE auction_id = '$pid' AND media_type = 1";
				$rs_picsquery=mysql_query($rs_pics);

				while($picsquery=mysql_fetch_array($rs_picsquery))
				{
					$phasimg="1";
					if($curr_pic == 0)
					{
						$ppicpath = $picsquery['media_url'];
					}
					else{
						$potherpics .= $picsquery['media_url'].$sep2;
					}
					$curr_pic++;
				}

				mysql_free_result($rs_picsquery);

				$customdata           = "";
				$moviepath            = "";

				$rs_movie = "SELECT * FROM " . DB_PREFIX . "auction_media WHERE auction_id = '$pid' AND media_type = 2";
				$rs_moviequery=mysql_query($rs_movie);
				$moviequery=mysql_fetch_array($rs_moviequery);
				if($moviequery)
				{
					$moviepath = $moviequery['media_url'];
				}
				mysql_free_result($rs_moviequery);


				echo "<PBCLOSED>$pitemname$sep$pdescription$sep$pcategory$sep$pcategory2$sep$pquantity$sep$pauctiontype$sep$pcurrency$sep$pbidstart$sep$prp$sep$prpvalue$sep$pbn$sep$pbnvalue$sep$pbi$sep$pbivalue$sep$pduration$sep$psc$sep$pscint$sep$ppdm$sep$ppm$sep$ppostage_costs$sep$pshipping_details$sep$ptype_service$sep$pinsurance$sep$phpfeat$sep$phpfeat_desc$sep$pcatfeat$sep$pbolditem$sep$phlitem$sep$pprivate$sep$relist$sep$relistalways$sep$relisttimes$sep$pisswap$sep$ppicpath$sep$phasimg$sep$potherpics$sep$customdata$sep$listin$sep$moviepath$sep$usebuyout$sep$buyout1$sep$buyout2$sep$pcategory_name$sep$pcategory2_name$sep$pactive$sep$pclosed$sep$pownerid$sep\n";
			}// end of while
			mysql_free_result($rs_items);
		}// end of if = closed
		else if($paxreq == "open")
		{
			$rs_sqlitems = "SELECT * FROM " . DB_PREFIX . "auctions WHERE owner_id = '$useridnum' AND closed = '0' AND active = '1' LIMIT 2000";
			$rs_items=mysql_query($rs_sqlitems);
			while ($row = mysql_fetch_array($rs_items))
			{
				$pid                  = $row['auction_id'];
				$pownerid             = $row['owner_id'];
				$pitemname      	  = $row['name'];
				$pdescription   	  = $row['description'];
				$pcategory      	  = $row['category_id'];
				$pcategory2      	  = $row['addl_category_id'];
				$pquantity      	  = $row['quantity'];
				$pauctiontype   	  = $row['auction_type'];
				$pcurrency      	  = $row['currency'];
				$pbidstart            = $row['start_price'];
				$prp                  = "0";
				$prpvalue       	  = $row['reserve_price'];
				if($prpvalue != 0.00)
				$prp                = "1";
				$pbn                  = "0";
				$pbnvalue       	  = $row['buyout_price'];
				if($pbnvalue != 0.00)
				$pbn                  = "1";
				$pbi                  = "0";
				$pbivalue       	  = $row['bid_increment_amount'];
				if($pbivalue != 0.00)
				$pbi                  = "1";
				$pduration      	  = $row['duration'];
				$psc            	  = $row['shipping_method'];
				$pscint         	  = $row['shipping_int'];
				$pdpm                 = $row['direct_payment'];
				$ppm            	  = $row['payment_methods'];
				$ppostage_costs 	  = $row['postage_amount'];
				$pshipping_details    = $row['shipping_details'];
				$ptype_service        = $row['type_service'];
				$pinsurance           = $row['insurance_amount'];
				$phpfeat              = $row['hpfeat'];
				$phpfeat_desc         = $row['hpfeat_desc'];
				$pcatfeat             = $row['catfeat'];
				$pbolditem            = $row['bold'];
				$phlitem              = $row['hl'];
				$pprivate             = $row['hidden_bidding'];

				$relisttimes          = $row['auto_relist_nb'];
				$relist               = "0";
				if($relisttimes >0)
				$relist               = "1";
				$relistalways         = $row['auto_relist_bids'];
				$pisswap              = $row['enable_swap'];
				$ppicpath             = $row['picpath'];
				$phasimg              = "0";
				$potherpics           = "";
				$customdata           = "";
				$listin               = $row['list_in'];
				$pactive              = $row['active'];
				$pclosed              = $row['closed'];
				$usebuyout            = "0";
				$buyout1              = "0.00";
				$buyout2              = "0.00";

				if($setts['buyout_process']>0)
				{
					$usebuyout            = $row['is_offer'];
					$buyout1              = $row['offer_min'];
					$buyout2              = $row['offer_max'];
				}
				$pdescription = html_entity_decode($pdescription);
				/////////////// catname extraction /////////////
				$pcategory_name  = "";
				$pcategory2_name = "";

				if($pcategory != "")
				{
					$catresult=mysql_query("SELECT * FROM " . DB_PREFIX . "categories WHERE category_id='$pcategory'");
					if ($catinfo=mysql_fetch_array($catresult)) {
						$pcategory_name = $catinfo['name'];
					}
				}
				if($pcategory2 != "")
				{
					$catresult=mysql_query("SELECT * FROM " . DB_PREFIX . "categories WHERE category_id='$pcategory2'");
					if ($catinfo=mysql_fetch_array($catresult)) {
						$pcategory2_name = $catinfo['name'];
					}
				}

				$curr_pic=0;
				$rs_pics = "SELECT * FROM " . DB_PREFIX . "auction_media WHERE auction_id = '$pid' AND media_type = 1";
				$rs_picsquery=mysql_query($rs_pics);

				while($picsquery=mysql_fetch_array($rs_picsquery))
				{
					$phasimg="1";
					if($curr_pic == 0)
					{
						$ppicpath = $picsquery['media_url'];
					}
					else{
						$potherpics .= $picsquery['media_url'].$sep2;
					}
					$curr_pic++;
				}

				mysql_free_result($rs_picsquery);

				$customdata           = "";
				$moviepath            = "";

				$rs_movie = "SELECT * FROM " . DB_PREFIX . "auction_media WHERE auction_id = '$pid' AND media_type = 2";
				$rs_moviequery=mysql_query($rs_movie);
				$moviequery=mysql_fetch_array($rs_moviequery);
				if($moviequery)
				{
					$moviepath = $moviequery['media_url'];
				}
				mysql_free_result($rs_moviequery);


				echo "<PBOPEN>$pitemname$sep$pdescription$sep$pcategory$sep$pcategory2$sep$pquantity$sep$pauctiontype$sep$pcurrency$sep$pbidstart$sep$prp$sep$prpvalue$sep$pbn$sep$pbnvalue$sep$pbi$sep$pbivalue$sep$pduration$sep$psc$sep$pscint$sep$ppdm$sep$ppm$sep$ppostage_costs$sep$pshipping_details$sep$ptype_service$sep$pinsurance$sep$phpfeat$sep$phpfeat_desc$sep$pcatfeat$sep$pbolditem$sep$phlitem$sep$pprivate$sep$relist$sep$relistalways$sep$relisttimes$sep$pisswap$sep$ppicpath$sep$phasimg$sep$potherpics$sep$customdata$sep$listin$sep$moviepath$sep$usebuyout$sep$buyout1$sep$buyout2$sep$pcategory_name$sep$pcategory2_name$sep$pactive$sep$pclosed$sep$pownerid$sep\n";

			}// end of while
			mysql_free_result($rs_items);
		}// end of if = open
		else if($paxreq == "opencount")
		{
			$found = "0";
			$sqlitems = "SELECT * FROM " . DB_PREFIX . "auctions WHERE owner_id = '$useridnum' AND active = '1' AND closed = '0' LIMIT 1000";
			$rs_items=mysql_query($sqlitems);
			while ($row = mysql_fetch_array($rs_items))
			$found++;
			mysql_free_result($rs_items);
			print("<OPCOUNT>$found");
		}
		else if($paxreq == "closedcount")
		{
			$found = "0";
			$sqlitems = "SELECT * FROM " . DB_PREFIX . "auctions WHERE owner_id = '$useridnum' AND active = '1' AND closed != '0' LIMIT 1000";
			$rs_items=mysql_query($sqlitems);
			while ($row = mysql_fetch_array($rs_items))
			$found++;
			mysql_free_result($rs_items);
			print("<CLCOUNT>$found");
		}
	}
	else 
	{
		echo "<BADLOGIN>";
	}
	## end of if config is required
}
?>