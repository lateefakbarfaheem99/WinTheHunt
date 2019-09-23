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
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_item.php');
include_once ('includes/functions_login.php');

$manual_cron = true;
@include_once ($fileExtension . 'cron_jobs/main_cron.php');

$sep = "[]";

$types=array(
	'title'=>text,				// item title
	'desc'=>text,          	// item description
	'category'=>int,       	// category id for auction
	'category2'=>int,   		// category id for auction
	'qty'=>int,            	// quantity
	'auctiontype'=>ds,     	// auction type standard or dutch
	'currency'=>text,      	// currency used for item
	'price'=>float,        	// item start price
	'usereserve'=>digiyn,  	// use reserve value
	'reserve'=>float,      	// reserve value
	'usebuynow'=>digiyn,   	// use buy it now option
	'buynow'=>float,       	// buy it now value
	'useinc'=>digiyn,      	// use increment or not
	'inc'=>float,          	// increment value to be used
	'duration'=>int,       	// duration of auction
	'whopays'=>digipm,     	// who pays postage
	'shipinter'=>digiyn,   	// will ship international
	'paydirect'=>text,     	// direct payments
	'paymethods'=>text,    	// other choice of payment
	'postcosts'=>float,    	// postage costs for item
	'postnote'=>text,      	// postage details string
	'service'=>text,       	// postage service to be used
	'insurance'=>float,    	// insurance costs for item
	'homefeat'=>digiyn,    	// homepage featured
	'homefeatdesc'=>text,  	// homepage featured description
	'catfeat'=>digiyn,     	// category featured
	'bold'=>digiyn,        	// bold option for auction
	'highlight'=>digiyn,   	// highlighted auction
	'private'=>digiyn,     	// private auction or not
	'relist'=>digiyn,      	// relist item
	'relistalways'=>digiyn,	// relist always
	'relisttimes'=>int,    	//reserved custom field
	'allowswap'=>digiyn,   	// allow swaps on auction item
	'voucher'=>text,       	// voucher string used
	'hasimage'=>digiyn,    	// advert has images or not
	'pictures'=>picarray,  	// array of images supplied for ad including merged url images
	'auctionstore'=>text,  	// auction,store or both ..default is auction
	'movie'=>movarray,     	// movie file upload
	'usebuyout'=>digiyn,   	// use buy out
	'buyout1'=>float,      	// buyout 1
	'buyout2'=>float,      	// buyout 2
	'customdata'=>text		//reserved custom field
);   

function checkvar($type, $value) 
{
	global $types;
	switch ($type) 
	{
		case "int":
			$value=(int)$value;
			break;

		case "text":
			// $value = remSpecialChars($value); /// REMOVED to prevent no desc submitted
			if (preg_match("/(select|insert|delete|drop).*(from|into)/is",$value)) $value="";
			if (strlen($value)>1000000) $value=substr($value,0,1000000);
			break;

		case "ds":
			$value=strtolower($value);
			if ($value!="dutch") $value="standard";
			break;
			
		case "digiyn":
			if ($value!="1") $value="0";
			break;
			
		case "digipm":
			if ($value!="2") $value="1";
			break;
			
		case "yn":
			$value=strtoupper($value);
			if ($value!="Y") $value="N";
			break;

		case "float":
			$value=(float)$value;
			break;

		case "file":
			break;
	}
	
	return $value;
}

/////////////////   MOVIE FILE UPLOAD FUNCTION //////////////////
function uploadmovie($movs) 
{
	global $setts,$userinfo;

	$moviefile = $movs;
	$myreturn  = "";
	$movieName = "";
	
	if ($moviefile!="" AND $setts['media_max_size']>0)
	{
		if (!stristr($moviefile, "http://"))
		{
			if ($_FILES['userfile2']['name'][0]!="")
			{
				dump ("Movupl - $moviefile");
				$tempNumber = md5(uniqid(rand(2, 999999999)));
				$fileExtension2 = substr(strrchr($_FILES['userfile2']['name'][0], "."), 1);
				$movieName = "bulk_mov_".$userinfo['user_id']."_".$tempNumber."_movie.".$fileExtension2;
				$movMaxSize = $setts['media_max_size']*1000;
				$mysize = $_FILES['userfile2']['size'][0];
				if ($mysize<$movMaxSize)
				{
					if (move_uploaded_file($_FILES['userfile2']['tmp_name'][0],"uplimg/".$movieName))
					{
						$myreturn=$movieName;
						chmod("uplimg/".$movieName,0777);
					}
					else
					{
						dump ("Movie Move error - $moviefile");
					}
				}
				else
				{
					dump ("Movie Size error - $moviefile");
				}
			}
		}
		else
		{
			$myreturn=$moviefile;
		}
	}
	
	return $myreturn;
}

/////////////////   IMAGE FILE(s) UPLOAD FUNCTION //////////////////
function uploadfiles($pics) 
{
	global $setts,$userinfo;
	$pictures = explode ("|",$pics);
	$c=0;
	$cc=0;
	for ($i=0; $i<5; $i++) 
	{
		if ($pictures[$i]!=""&&!stristr($pictures[$i], "http://")) 
		{
			if ($_FILES['userfile']['name'][$cc]!="") 
			{
				dump ("$i - upl");
				$tempNumber = md5(uniqid(rand(2, 999999999)));
				$fileExtension = substr(strrchr($_FILES['userfile']['name'][$cc],"."), 1);
				$imageName = "bulk_img_mb".$userinfo['user_id']."_".$tempNumber."_image".$c.".".$fileExtension;
				$imgMaxSize = $setts['images_max_size']*1000;
				
				if ($_FILES['userfile']['size'][$cc]<$imgMaxSize) 
				{
					if (move_uploaded_file($_FILES['userfile']['tmp_name'][$cc],"uplimg/".$imageName)) 
					{
						$return[$i]=$imageName;
						chmod("uplimg/".$imageName,0777);
						$c++;
					}
					else
					{
						dump ("Pic Move error - $imageName");
					}
				}
				else
				{
					dump ("Pic size error - $imageName");
				}
			}
			$cc++;
		} 
		else if (stristr($pictures[$i], "http://"))
		{
			//dump("$i - http");
			$return[$i]=$pictures[$i];
		}
	}
	if ($return) $return=implode("|",$return);

	return $return;
}

///////////////////  LOGGING FUNCTION - MAKE SURE DUMP LOG EXISTS AND IS CHMOD 777 ///////////////
function dump($str) 
{
	$fp=fopen("dump.log","a");
	fwrite($fp,date("d-m-Y H:i:s")." -> ".$str);
	fwrite($fp,"\n----------------------\n");
	fclose($fp);
}

///////////////////  DO LOGIN CHECK   ////////////////////////
if ($_POST['username'] && $_POST['password'])
{
	$password=$_SESSION['password']=$_POST['password'];
	$username=$_SESSION['username']=$_POST['username'];
}
else{
	$password=$_SESSION['password'];
	$username=$_SESSION['username'];
}

$salt = $db->get_sql_field("SELECT salt FROM " . DB_PREFIX . "users WHERE username='" . $username . "'", "salt");

$password_hashed = password_hash($password, $salt);
$password_old = substr(md5($password), 0, 30); ## added for backward compatibility (v5.25 and older versions)

$login_query = $db->query("SELECT * FROM " . DB_PREFIX . "users WHERE username='" . $username . "' AND 
	(password='" . $password_hashed . "' OR password='" . $password_old . "') LIMIT 0,1");

$is_login = $db->num_rows($login_query);

if(!$is_login)
{
	die("<BADLOGIN>");
}

$result=$db->query("SELECT * FROM " . DB_PREFIX . "users WHERE	username='" . $username . "' AND 
	(password='" . $password_hashed . "' OR password='" . $password_old . "') LIMIT 0,1");

if ($userinfo=mysql_fetch_array($result))
	print("<GOODLOGIN>\n");

$_SESSION['memberid']    = $userinfo['user_id'];
$_SESSION['membersarea'] = "Active";
$_SESSION['sess_lang']   = $userinfo['lang'];
$_SESSION['membername']  = $userinfo['name'];
$_SESSION['memberusern'] = $userinfo['username'];
$_SESSION['city']        = $userinfo['city'];
$_SESSION['state']       = $userinfo['state'];
$_SESSION['zip']         = $userinfo['zip_code'];
$_SESSION['country']     = $userinfo['country'];

if ($setts['private_site']=="Y") $_SESSION['is_seller']=$userinfo['is_seller'];
else $_SESSION['is_seller']="Y";

////////////////  ITEM SUBMITTED DATA  //////////////////
if ($_POST['title']) 
{
	foreach($types as $key=>$value) 
	{
		$_POST[$key]=checkvar($types[$key],$_POST[$key]);
		$query[]="'".$_POST[$key]."'";
	}
	///////////////  UPLOAD THE MOVIE   /////////////////////
	$loadmovie=uploadmovie($_POST['movie']);
	if ($loadmovie != "") 
	{
		$query[37]="'".$loadmovie."'";
	} 
	else 
	{
		$query[37]="''";
	}
	///////////////  UPLOAD THE IMAGES  /////////////////////
	$loadfile=uploadfiles($_POST['pictures']);
	if ($loadfile !="") 
	{
		$query[34]="'1'";
		$query[35]="'".$loadfile."'";
	} 
	else 
	{
		$query[34]="'0'";
		$query[35]="''";
	}

	$query=implode(",",$query);
	///////////////  PLACE SUBMITTED VALUES INTO TMP TABLE   ///////////////////
	mysql_query("INSERT INTO " . DB_PREFIX . "bulktmp VALUES(null,'$userinfo[user_id]',$query)");
	dump(mysql_error());
	print("Successfully uploaded");
	exit("");
}
///////////////  UPDATE ITEM FEATURES IN TMP TABLE ////////////////
if ($_POST['lot']) 
{
	foreach($_POST['lot'] as $key=>$value) 
	{
		if ($_POST['homefeat'][$value]=="on") $query[]="homefeat='1'";
		else $query[]="hpfeat='0'";
		if ($_POST['catfeat'][$value]=="on") $query[]="catfeat='1'";
		else $query[]="catfeat='0'";
		if ($_POST['highlight'][$value]=="on") $query[]="highlight='1'";
		else $query[]="highlight='0'";
		if ($_POST['bold'][$value]=="on") $query[]="bold='1'";
		else $query[]="bold='0'";

		if ($query) 
		{
			$query=implode(",",$query);
			mysql_query("UPDATE " . DB_PREFIX . "bulktmp SET $query WHERE id='$value'");
			unset($query);
		}
	}
}

if (!(int)$p) $p=1;
////////////////   LOAD IN SELLERS ITEMS FROM TMP TABLE  ////////////////////
$result=mysql_query("SELECT * FROM " . DB_PREFIX . "bulktmp WHERE userid='".$userinfo['user_id']."' ORDER BY id");

$aucount = 0;
$setup_fee = new fees();
$setup_fee->setts = &$setts;
///////////////  PREPARE TO SUBMIT TO PROBID AUCTIONS TABLE  ////////////////
while ($row=mysql_fetch_array($result)) 
{
	if ($_POST['finished']) 
	{
		$user_payment_mode = $setup_fee->user_payment_mode($_SESSION[memberid]);
		
		$auto_approved  = 1;  // Set this to zero if auctions need to be approved by admin.
		$active         = ($user_payment_mode == 2) ? 1 : 0;
		$myendtype      = "duration";
		$mystarttype    = "now";
		$startDate      = time();
		$myduration     = $row['duration']*86400;
		$closingdate    = $startDate + $myduration;
		$payment_status = ($user_payment_mode == 2) ? 'confirmed' : '';
		$voucher_details= $row['voucher'];
		$auid           = 0;
		$aucount        = 0;

		$bi = ($row['inc']>0) ? 1 : 0;
		if($setts['buyout_process'] == 0)
		{
			$row['usebuyout'] = "0";
			$row['buyout1']   = "0.00";
			$row['buyout2']   = "0.00";
		}

		$pictures=explode("|",$row['pictures']);
		$mymovie=$row['movie'];
		if ($mymovie != "")
		{
			if (!stristr($mymovie, "http://"))
			$mymovie="uplimg/$mymovie";
		}
		else $mymovie="";
		
		///////////////  INSERT INTO PROBID AUCTIONS TABLE  ////////////////
		mysql_query("INSERT INTO " . DB_PREFIX . "auctions
		(name,description,quantity,auction_type,start_price,reserve_price,
		buyout_price,bid_increment_amount,duration,country,zip_code,shipping_method,shipping_int,
		direct_payment,payment_methods,category_id,addl_category_id,active,payment_status,closed,owner_id,
		hpfeat,catfeat,bold,hl,hidden_bidding,auto_relist_nb,auto_relist_bids,currency,enable_swap,postage_amount,
		shipping_details,insurance_amount,type_service,deleted,hpfeat_desc,list_in,is_offer,offer_min,offer_max,
		end_time_type,listing_type,start_time,end_time,creation_date,state,start_time_type,approved)
		VALUES 
		('$row[title]','$row[desc]','$row[qty]','$row[auctiontype]','$row[price]','$row[reserve]',
		'$row[buynow]','$row[inc]','$row[duration]','$_SESSION[country]','$_SESSION[zip]','$row[whopays]','$row[shipinter]',
		'$row[paydirect]','$row[paymethods]','$row[category]','$row[category2]','$active','$payment_status','0','$_SESSION[memberid]',
		'$row[homefeat]','$row[catfeat]','$row[bold]','$row[highlight]','$row[private]','$row[relisttimes]','$row[relistalways]','$row[currency]','$row[allowswap]','$row[postcosts]',
		'$row[postnote]','$row[insurance]','$row[service]','0','$row[homefeatdesc]','$row[auctionstore]','$row[usebuyout]','$row[buyout1]','$row[buyout2]',
		'$myendtype','full','$startDate','$closingdate','$startDate','$_SESSION[state]','$mystarttype','$auto_approved')") or die(mysql_error());
		
		if(mysql_affected_rows());
		{
			$auid=mysql_insert_id();
			$aucount = 1;
		}
		////////////////  ADD IMAGES TO MEDIA TABLE   //////////////////////
		for($ii=0; $ii<5;$ii++) 
		{
			if ($pictures[$ii]) 
			{
				if (stristr($pictures[$ii], "http://"))
				{
					$addpic = $pictures[$ii];
				}
				else
				{
					$addpic = "uplimg/".$pictures[$ii];
				}
				mysql_query("INSERT INTO " . DB_PREFIX . "auction_media(media_url,auction_id,media_type) VALUES('$addpic','$auid',1)");
			}
		}
		
		////////////////  ADD MOVIE TO MEDIA TABLE   //////////////////////
		if ($mymovie != "") 
		{
			if (stristr($mymovei, "http://")) $addmov = $mymovie;
			else $addmov = $mymovie;
			mysql_query("INSERT INTO " . DB_PREFIX . "auction_media(media_url,auction_id,media_type) VALUES('$addmov','$auid','2')");
		}
		
		///////////////  DO TOPAY ACCOUNTING  ////////////////////////////
		if($aucount >= 1)
		{
			$user_details = $userinfo;
			$auction_result=$db->query("SELECT * FROM " . DB_PREFIX . "auctions WHERE auction_id='" . $auid . "' LIMIT 0,1");
			$item_details = mysql_fetch_array($auction_result);
			$setup_result = $setup_fee->setup($user_details, $item_details, $voucher_details);
		}

		if($aucount >= 1)
		{
			echo "<ADDED>$auid$sep$aucount$sep$septup_result$sep\n";
		}
	}
}

if ($_POST['finished']) 
{
	mysql_query("DELETE FROM " . DB_PREFIX . "bulktmp WHERE userid='".$_SESSION['memberid']."'");
}

if ($_POST['prestart']) 
{
	mysql_query("DELETE FROM " . DB_PREFIX . "bulktmp WHERE userid='".$_SESSION['memberid']."'");
	$pre_del = mysql_affected_rows();
	echo "<PREDELETED>$pre_del$sep";
}
?>
