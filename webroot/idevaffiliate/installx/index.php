<?PHP

include("../includes/validation_functions.php");
include("../includes/data_inserts.php");
include ("../includes/package.php");

function getPlatform() {
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
$platform = "windows";
} else {
$platform = "unix"; }
return($platform); }

function isWritable ($file) {
$rtnVal = false;
$platform = getPlatform();
if($platform == 'windows') {
$dir_separator = "\\"; }
if($platform == 'unix') {
$dir_separator = '/'; }
if (@is_dir($file)) {
if($platform == 'windows') {
$file = preg_replace('/\\\\$/', '', $file). $dir_separator . md5(uniqid('', true));
} else {
$file = preg_replace('/\/\/$/', '', $file) . $dir_separator . md5(uniqid('',true)); }
$unlink = true;
						//	echo('file = ' . $file . "<br/>");            
} else {
$unlink = !file_exists($file); }
if ($fp = @fopen($file, 'ab')) {
@fclose($fp);
if ($unlink) {
@unlink($file); }
$rtnVal = true;
} else {
$rtnVal = false; }
return($rtnVal);
}

$license = false;
function chk( & $var ) {
if ( !isset($var) ) {
return NULL;
} else {
return $var; } }

$installation = 1;
include("../API/config.php");
$version = "6.0";
$ca_version = "1.0.6.05";

if (!isset($_POST['newinstall'])) {
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'idevaff_config'"))==1) {
header("Location: upgrade.php"); exit; } }

if (isset($_POST['license'])) { $license = $_POST['license']; }
if (isset($_POST['license_method'])) { $license_method = $_POST['license_method']; }

# START: Licensing -------------------------------------------------------------------------

function make_token() { return md5('1b1ddcb4ed069d9565cc6a5a9ecf553e'.time()); }

function phpaudit_exec_curl($array)
    {
    $array=@explode("?", $array);

    $link=curl_init();
    curl_setopt($link, CURLOPT_URL, $array[0]);
    curl_setopt($link, CURLOPT_POSTFIELDS, $array[1]);
    curl_setopt($link, CURLOPT_VERBOSE, 0);
    curl_setopt($link, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($link, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($link, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($link, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($link, CURLOPT_MAXREDIRS, 6);
    curl_setopt($link, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($link, CURLOPT_TIMEOUT, 15); // 60
    $results=curl_exec($link);
	if (curl_errno($link)>0)
		{
		curl_close($link);
		return false;
		}
    curl_close($link);

	if (@strpos($results, "verify")===false) { return false; }

    return $results;
    }

function phpaudit_exec_socket($http_host, $http_dir, $http_file, $querystring)
	{
	$fp=@fsockopen($http_host, 80, $errno, $errstr, 10); // was 5
	if (!$fp) { return false; }
	else
		{
		$header="POST ".($http_dir.$http_file)." HTTP/1.0\r\n";
		$header.="Host: ".$http_host."\r\n";
		$header.="Content-type: application/x-www-form-urlencoded\r\n";
		$header.="User-Agent: PHPAudit v2 (http://www.phpaudit.com)\r\n";
		$header.="Content-length: ".@strlen($querystring)."\r\n";
		$header.="Connection: close\r\n\r\n";
		$header.=$querystring;

		$data=false;
		if (@function_exists('stream_set_timeout')) { stream_set_timeout($fp, 20); }
		@fputs($fp, $header);

		if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
		else { $status=true; }

		while (!@feof($fp)&&$status) 
			{
			$data.=@fgets($fp, 1024);

			if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
			else 
				{
			    if (@feof($fp)==true) { $status=false; } 
				else { $status=true; }
				}
			}

		@fclose ($fp);

		// echo "<textarea rows='100' cols='100'>".$data."</textarea>"; die;

		if (!strpos($data, '200')) { return false; }
		
		if (!$data) { return false; }

		$data=@explode("\r\n\r\n", $data, 2);

		if (!$data[1]) { return false; }
		if (@strpos($data[1], "verify")===false) { return false; }

		return $data[1];
		}
	}

function path_translated()
	{
	if (isset($_SERVER['PATH_TRANSLATED']))
		{
		return @substr($_SERVER['PATH_TRANSLATED'], 0, @strrpos($_SERVER['PATH_TRANSLATED'], "/"));
		}

	if (isset($_SERVER['SCRIPT_FILENAME']))
		{
		$local_path=substr($_SERVER['SCRIPT_FILENAME'], 0, @strrpos($_SERVER['SCRIPT_FILENAME'], "/"));
		if (!$local_path) 
			{
			$local_path=@substr($_SERVER['SCRIPT_FILENAME'], 0, @strrpos($_SERVER['SCRIPT_FILENAME'], "\\"));
			}

		return $local_path;
		}

	return @substr($_SERVER['ORIG_PATH_TRANSLATED'], 0, @strrpos($_SERVER['ORIG_PATH_TRANSLATED'], "\\"));
	}

function server_addr()
            {
if (isset($_SERVER['SERVER_ADDR'])) {
return ($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:$_SERVER['LOCAL_ADDR'];
} else { }
}


if (isset($_POST['license_submit'])) 
	{
	$server='http://www.idevstore.com/'; // main server
	$methods=array('phpaudit_exec_socket', 'phpaudit_exec_curl', 'file_get_contents');
	
	$enable_dns_spoof='yes';

	$query_string="license=".$_POST['license'];
	$query_string.="&product_id=".$prid;
	$query_string.="&access_directory=".str_replace('install', 'admin', path_translated());
	$query_string.="&access_ip=".server_addr();
	$query_string.="&access_host=".$_SERVER['HTTP_HOST'];
	$query_string.='&access_token=';
	$query_string.=$token=make_token();


	$data=false;
	foreach($methods as $license_method) 
		{
		$sinfo=@parse_url($server);


		if ($license_method=='phpaudit_exec_socket'&&!$data)
			{
			$data=@phpaudit_exec_socket($sinfo['host'], $sinfo['path'], '/validate_internal.php', $query_string);
			}

		
		if ($license_method=='phpaudit_exec_curl'&&!$data)
			{
			$data=@phpaudit_exec_curl("{$server}/validate_internal.php?{$query_string}");
			}

	
		if ($license_method=='file_get_contents'&&!$data)
			{
			$data=@file_get_contents("{$server}validate_internal.php?{$query_string}");
			}

		if ($data) { break; }
		}

	$parser=@xml_parser_create('');
	@xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	@xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	@xml_parse_into_struct($parser, $data, $values, $tags);
	@xml_parser_free($parser);

	$returned=$values[0]['attributes'];
	if (empty($returned)) { $returned['status']="invalid"; }

	if ($returned['status']!="active"&&$returned['status']!="reissued") 
		{
		unset($_POST);
		$errors=false;
		if ($returned['status']=="suspended") 
			{
			$errors='This license has been suspended.'; 
			}
		else if ($returned['status']=="pending") 
			{ 
			$errors='This license is pending admin approval.'; 
			}
		else if ($returned['status']=="expired") 
			{ 
			$errors='This license is expired.'; 
			}
		else if ($returned['status']=='active'
			&&strcmp(md5('1b1ddcb4ed069d9565cc6a5a9ecf553e'.$token), $returned['access_token'])!=0
			&&$enable_dns_spoof=='yes'
			&&!$skip_dns_spoof)
			{
			$errors='This license has an invalid checksum.'; 
			}
		else { $errors='This license appears to be invalid.'; }
		}

	unset($query_string, $per_server, $per_install, $per_site, $server, $data, $parser, $values, $tags, $sinfo, $token);
	}

# END: Licensing -------------------------------------------------------------------------


if (isset($_POST['install_tables'])) {
include("mysql_tables.php");
$random_key = mt_rand(1000000000000,9999999999999);
include("mysql_data.php");

if ($edition == 3) {
include("platinum/mysql_tables.php");
include("platinum/mysql_data.php");
}
include("../admin/updates/patches.php");
}

?>


<html>
<head>
<title>iDevAffiliate <?PHP echo $write_edition; ?> Installation Program</title>
<link rel="STYLESHEET" type="text/css" href="../templates/style.css">
<link href="../templates/greybox/css/gb_styles.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="../lightboxes/source/css/lightbox.css" type="text/css" />

    <script type="text/javascript" language="javascript1.2">
        var GB_ROOT_DIR = "../templates/greybox/";
    </script>

    <script type="text/javascript" language="javascript1.2" src="../templates/greybox/AJS.js"></script>
    <script type="text/javascript" language="javascript1.2" src="../templates/greybox/AJS_fx.js"></script>
    <script type="text/javascript" language="javascript1.2" src="../templates/greybox/gb_scripts.js"></script>

<script type="text/javascript" language="javascript1.2" src="../lightboxes/source/js/prototype.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript1.2" src="../lightboxes/source/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" language="javascript1.2" src="../lightboxes/source/js/lightbox.js" type="text/javascript"></script>

<script type="text/javascript" language="javascript1.2">
	var fileLoadingImage = "../lightboxes/source/images/loading.gif";	
	var fileBottomNavCloseImage = "../lightboxes/source/images/closelabel.gif";
</script>

</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#838383">
<br /><br />


<?PHP if ($installcheck != 1) { ?>

<table border="0" cellspacing="1" width="700" bgcolor="#CC0000" cellpadding="0" align="center">
<tr><td>

<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr><td width="100%" bgcolor="#CC0000"><font color="#FFFFFF"><b>Error Detected</b></font></td></tr>
<tr><td width="100%" bgcolor="#EFEFEF">

<table border="0" cellspacing="2" width="100%" cellpadding="4">
<tr><td width="100%" bgcolor="#FFFFFF">iDevAffiliate could not detect the server path correctly.</td></tr>
<tr><td width="100%" bgcolor="#FFFFFF"><font color="#CC0000"><b>Possibility</b></font><br />Your <b>install_directory_name</b> isn't set correctly in <font color="#CC0000">API/config.php</font>.</td></tr>
<tr><td width="100%" bgcolor="#FFFFFF"><font color="#CC0000"><b>Technical Support</b></font><br />If you're positive this setting is correct, please contact <a href="http://www.idevsupport.com/" target="_blank">technical support</a> for help.</td></tr>
</table></td></tr>
<tr><td width="100%" bgcolor="#CC0000" align="right"><b><font color="#FFFFFF">Copyright 2007 - iDevDirect.com L.L.C. - </font></b><a href="http://www.idevdirect.com/" target="_blank"><font color="#FF9966"><b>iDevAffiliate</b></font></a></td></tr>
</table></td></tr></table>
<?PHP
} else {

if ((!chk($_POST['step'])) || ($_POST['step'] == 1)) { $color1 = "#C8C8F2"; } else { $color1 = "#EEEEFB"; }
if ((chk($_POST['step']) == 2) || ($_POST['step'] == 3)) { $color2 = "#C8C8F2"; } else { $color2 = "#EEEEFB"; }
if (chk($_POST['step']) == 4) { $color3 = "#C8C8F2"; } else { $color3 = "#EEEEFB"; }
if (chk($_POST['step']) == 5) { $color4 = "#C8C8F2"; } else { $color4 = "#EEEEFB"; }
?>

<table border="0" cellpadding="4" cellspacing="0" width="700" align="center">
<tr>
<td width="50%" bgcolor="#FFFFFF"><img border="0" src="../images/admin_logo.gif" width="198" height="29"></td>
<td width="50%" align="right" bgcolor="#FFFFFF"><img border="0" src="../images/installation.gif" width="198" height="29"></td>
</tr>
</table>

  <table border="0" cellpadding="4" cellspacing="1" width="700" align="center">
    <tr>
      <td width="25%" bgcolor="#3333CC"><font color="#FFFFFF"><b>Step 1</b></font></td>
      <td width="25%" bgcolor="#3333CC"><font color="#FFFFFF"><b>Step 2</b></font></td>
      <td width="25%" bgcolor="#3333CC"><font color="#FFFFFF"><b>Step 3</b></font></td>
      <td width="25%" bgcolor="#3333CC"><font color="#FFFFFF"><b>Step 4</b></font></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="<?PHP print $color1; ?>">Install License</td>
      <td width="25%" bgcolor="<?PHP print $color2; ?>">Build Database</td>
      <td width="25%" bgcolor="<?PHP print $color3; ?>">Create Admin Login</td>
      <td width="25%" bgcolor="<?PHP print $color4; ?>">Done!</td>
    </tr>
  </table>




<table border="0" cellspacing="0" width="700" bgcolor="#3333CC" cellpadding="0" align="center">
<tr><td>

<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr><td width="100%" bgcolor="#3333CC"><font color="#FFFFFF"><b>iDevAffiliate <?PHP echo $write_edition; ?> Installation</b></font></td></tr>
<tr><td width="100%" bgcolor="#EEEEFB">

<table border="0" cellspacing="2" width="100%" cellpadding="4">

<?PHP if ((!isset($_POST['step'])) || ($_POST['step'] == 1)) { ?>

<?PHP 
if (isset($errors)) { echo "<br /><b>Licensing Error</b><br /><font color='#CC0000'><b>{$errors}</b></font><br /><br />"; }
?>


<tr><td width="100%" bgcolor="#FFFFFF" colspan="2">Please enter your iDevAffiliate license key. Your license key can be found by logging into the <a href="http://www.idevstore.com/client_area.php" target="_blank"><b>Client Center</b></a> on our website. </td></tr>
<tr><td width="30%" bgcolor="#FFFFFF" align="right">License Key:</td>
<td width="70%" bgcolor="#FFFFFF">
<form method="POST" action="index.php">

<?PHP if (isset($_POST['license'])) { ?>
<font color="#CC0000">License Key Accepted</font></td></tr>
<input type="hidden" name="step" value="2">
<input type="hidden" name="newinstall" value="1">

<tr><td width="100%" colspan="2" bgcolor="#FFFFFF" align="right">
<input type="submit" value="Continue To Next Step">
<input type="hidden" name="license" value="<?PHP echo $license; ?>">
<input type="hidden" name="license_method" value="<?PHP echo $license_method; ?>">
</td></form></tr>

<?PHP } else { ?>

<input type="text" name="license" size="25" value='<?PHP echo ($license)?$license:''; ?>' /></td></tr>
<input type="hidden" name="step" value="1">
<input type="hidden" name="license_submit" value="1">

<tr><td width="30%" bgcolor="#FFFFFF"></td><td width="70%" bgcolor="#FFFFFF"><input type="submit" value="Submit License Key"></td></form></tr>

<?PHP } ?>

</table>
</td></tr>
</td></tr>
</table>

<table border="0" cellpadding="4" cellspacing="0" width="700">
<tr><td width="100%" bgcolor="#3333CC"><font color="#FFFFFF"><b>Required Folder Permissions</b></font></td></tr>
<tr><td width="100%" bgcolor="#EEEEFB">

<table border="0" cellspacing="2" width="100%" cellpadding="4">

<?PHP


function directory_status_label($dir_name) {
$write_successful = false;
$result = false;
if(file_exists($dir_name)) {
$write_successful = isWritable($dir_name);
if(!$write_successful) {
$dir_name = str_replace("..", "", $dir_name);
echo "<font color='#CC0000'>" . $dir_name . "</font>";
} else {
$dir_name = str_replace("..", "", $dir_name);
echo $dir_name; } } }

function directory_status($dir_name) {
$write_successful = false;
$result = false;
if(file_exists($dir_name)) {
$write_successful = isWritable($dir_name);
if(!$write_successful) {
echo "Not Writable";
} else {
echo "Writable"; } } }

function directory_status_image($dir_name) {
$write_successful = false;
$result = false;
if(file_exists($dir_name)) {
$write_successful = isWritable($dir_name);
if(!$write_successful) {
echo "<img src='../images/disabled.png' height='16' width='16' border='0'>";
} else {
echo "<img src='../images/mark.gif' height='16' width='16' border='0'>"; } } }




?>

<tr>
<td width="100%" colspan="11" bgcolor="#FFFFFF">

<table border="0" cellspacing="0" width="100%" cellpadding="0">
<tr>
<td width="70%">The following iDevAffiliate folders need <u>write</u> permissions. [ <a href="help/permissions.php" title="Directory Permissions" rel="gb_page_center[500, 300]">Learn More</a> ]</td>
<td width="30%" align="center"><form  method="post" action="index.php">
  <input type="submit" name="button" value="Refresh This Page" class="install_button" />
</td></form>
</tr>
</table>

</td>
</tr>


<tr>
<td width="15%" bgcolor="#FFFFFF"><b>Folder Name</b></td>
<td width="15%" colspan="2" bgcolor="#FFFFFF"><b>Status</b></td>
<td width="5%" rowspan="4" bgcolor="#FFFFFF">&nbsp;</td>
<td width="15%" bgcolor="#FFFFFF"><b>Folder Name</b></td>
<td width="15%" colspan="2" bgcolor="#FFFFFF"><b>Status</b></td>
<td width="5%" rowspan="4" bgcolor="#FFFFFF">&nbsp;</td>
<td width="15%" bgcolor="#FFFFFF"><b>Folder Name</b></td>
<td width="15%" colspan="2" bgcolor="#FFFFFF"><b>Status</b></td>
</tr>


<tr>
<td width="15%" bgcolor="#FFFFFF"><?PHP directory_status_label("../backups/"); ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP directory_status("../backups/"); ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP directory_status_image("../backups/"); ?></td>
<td width="15%" bgcolor="#FFFFFF"><?PHP directory_status_label("../banners/"); ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP directory_status("../banners/"); ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP directory_status_image("../banners/"); ?></td>
<td width="15%" bgcolor="#FFFFFF"><?PHP directory_status_label("../cache/"); ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP directory_status("../cache/"); ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP directory_status_image("../cache/"); ?></td>
</tr>

<tr>
<td width="15%" bgcolor="#FFFFFF"><?PHP directory_status_label("../docs/"); ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP directory_status("../docs/"); ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP directory_status_image("../docs/"); ?></td>
<td width="15%" bgcolor="#FFFFFF"><?PHP directory_status_label("../lightboxes/"); ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP directory_status("../lightboxes/"); ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP directory_status_image("../lightboxes/"); ?></td>
<td width="15%" bgcolor="#FFFFFF"><?PHP directory_status_label("../logos/"); ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP directory_status("../logos/"); ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP directory_status_image("../logos/"); ?></td>
</tr>

<tr>
<td width="15%" bgcolor="#FFFFFF"><?PHP directory_status_label("../peels/"); ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP directory_status("../peels/"); ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP directory_status_image("../peels/"); ?></td>
<td width="15%" bgcolor="#FFFFFF"><?PHP directory_status_label("../uploads/"); ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP directory_status("../uploads/"); ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP directory_status_image("../uploads/"); ?></td>
<td width="30%" colspan="3" bgcolor="#FFFFFF"></td>
</tr>

</table>

</td></tr></table>




<table border="0" cellpadding="4" cellspacing="0" width="700">
<tr><td width="100%" bgcolor="#3333CC"><font color="#FFFFFF"><b>Enhanced Server Environment</b></font></td></tr>
<tr><td width="100%" bgcolor="#EEEEFB">

<table border="0" cellspacing="2" width="100%" cellpadding="4">

<?PHP

$something_bad = 0;

// CHECK GD & FREETYPE STATUS
// --------------------------------------
$prereqs = false;
if (extension_loaded('gd') && function_exists('gd_info')) {
$arr_gd_info = gd_info();
if($arr_gd_info['FreeType Support'] == true) {
$prereqs = true; } else { } } else { }

// $prereqs = null;
if($prereqs) {
	$gd_free_label = "GD Library w/ Freetype";
	$gd_free_desc = "Needed to use the captcha security image on the affiliate signup form.";
	$gd_free_result = "Enabled";
	$gd_free_image = "<img src='../images/mark.gif' height='16' width='16' border='0'>";
} else {
	$gd_free_label = "<font color='#CC0000'>GD Library w/ Freetype</font>";
	$gd_free_desc = "<font color='#CC0000'>Needed to use the captcha security image on the affiliate signup form.</font>";
	$gd_free_result = "<font color='#CC0000'>Disabled</font>";
	$gd_free_image = "<img src='../images/disabled.png' height='16' width='16' border='0'>";
	$something_bad = 1;
}

// CHECK CURL STATUS
// --------------------------------------
if (function_exists("curl_init")) {
	$curl_label = "cURL";
	$curl_desc = "Offer affiliate training videos and receive both upgrade notices and latest cart info.";
	$curl_result = "Enabled";
	$curl_image = "<img src='../images/mark.gif' height='16' width='16' border='0'>";
} else {
	$curl_label = "<font color='#CC0000'>cURL</font>";
	$curl_desc = "<font color='#CC0000'>Offer affiliate training videos and receive both upgrade notices and latest cart info.</font>";
	$curl_result = "<font color='#CC0000'>Disabled</font>";
	$curl_image = "<img src='../images/disabled.png' height='16' width='16' border='0'>";
	$something_bad = 1;
}

?>

<tr>
<td width="100%" colspan="4" bgcolor="#FFFFFF">

<table border="0" cellspacing="0" width="100%" cellpadding="0">
<tr>
<td width="75%">The following items are optional but will allow you to get the most out of iDevAffiliate. [ <a href="help/enhanced.php" title="Enhanced Server Environment" rel="gb_page_center[500, 150]">Learn More</a> ]</td>
<td width="25%" align="center"><form  method="post" action="index.php">
  <input type="submit" name="button" value="Refresh This Page" class="install_button" />
</td></form>
</tr>
</table>

</td>
</tr>

<tr>
<td width="20%" bgcolor="#FFFFFF"><b>Feature</b></td>
<td width="15%" colspan="2" bgcolor="#FFFFFF"><b>Status</b></td>
<td width="65%" bgcolor="#FFFFFF"><b>Reason For Feature Being Enabled</b></td>
</tr>

<tr>
<td width="20%" bgcolor="#FFFFFF"><?PHP echo $curl_label; ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP echo $curl_result; ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP echo $curl_image; ?></td>
<td width="65%" bgcolor="#FFFFFF"><?PHP echo $curl_desc; ?></td>
</tr>

<tr>
<td width="20%" bgcolor="#FFFFFF"><?PHP echo $gd_free_label; ?></td>
<td width="10%" bgcolor="#FFFFFF" align="center"><?PHP echo $gd_free_result; ?></td>
<td width="5%" bgcolor="#FFFFFF" align="center"><?PHP echo $gd_free_image; ?></td>
<td width="65%" bgcolor="#FFFFFF"><?PHP echo $gd_free_desc; ?></td>
</tr>

</table>

</td></tr></table>

<?PHP } ?>



























<?PHP if ((isset($_POST['step'])) && ($_POST['step'] == 2)) { ?>
<form method="POST" action="index.php">
<input type="hidden" name="license" value="<?PHP echo $license; ?>">
<input type="hidden" name="license_method" value="<?PHP echo $license_method; ?>">

<?PHP if (!isset($_POST['install_tables'])) { ?>
<input type="hidden" name="step" value="2">
<input type="hidden" name="newinstall" value="1">
<input type="hidden" name="install_tables" value="1">
<tr><td width="50%" bgcolor="#FFFFFF">Next we will install the database</td>
<td width="50%" bgcolor="#FFFFFF"><input type="submit" value="Continue"></td></form>
</tr>
<?PHP } else { ?>
<input type="hidden" name="step" value="3">
<input type="hidden" name="newinstall" value="1">
<input type="hidden" name="license" value="<?PHP echo $license; ?>">
<input type="hidden" name="license_method" value="<?PHP echo $license_method; ?>">

<tr>
<td width="50%" bgcolor="#FFFFFF">Tables Installed: <?PHP echo $tabnum; ?></td>
<td width="50%" bgcolor="#FFFFFF"><input type="submit" value="Continue To Next Step"></td></form>
</tr>

<?PHP } } ?>



<?PHP if ((isset($_POST['step'])) && ($_POST['step'] == 3)) {
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'idevaff_config'"))==1) {
$valcheck = 1; }
$checkdata = mysql_query("select * from idevaff_config");
$checkdata = mysql_num_rows($checkdata);
if ($checkdata) {
$valcheck = $valcheck + 1; }
if ($valcheck == 2) {
$val1 = "<font color=\"#CC0000\">Complete!</font>";
} else {
$val1 = "<font color=\"#CC0000\"><b>Error - Database Install Failed</b></font><br />Installation cannot continue.&nbsp; <a href=\"http://www.idevsupport.com/\" target=\"_blank\">Contact Support</a>"; }
$getad = mysql_query("select record from idevaff_admin");
$getad = mysql_num_rows($getad);
if ($getad) {
$nextstep = 5;
$val2 = "<font color=\"#CC0000\">Done</font> - Admin Account Exists";
} else {
$nextstep = 4;
$val2 = "<font color=\"#CC0000\">Complete!</font>"; }
?>
<form method="POST" action="index.php">
<input type="hidden" name="license" value="<?PHP echo $license; ?>">
<input type="hidden" name="license_method" value="<?PHP echo $license_method; ?>">
<input type="hidden" name="step" value="<?PHP echo $nextstep; ?>">
<input type="hidden" name="newinstall" value="1">
<tr>
<td width="50%" bgcolor="#FFFFFF">Verifying database installation.</td>
<td width="50%" bgcolor="#FFFFFF"><?PHP echo $val1; ?></td>
</tr>
<tr>
<td width="50%" bgcolor="#FFFFFF">Verifying no admin account exists.</td>
<td width="50%" bgcolor="#FFFFFF"><?PHP echo $val2; ?></td>
</tr>
<tr>
<td width="100%" bgcolor="#FFFFFF" colspan="2"><input type="submit" value="Continue To Next Step"></td></form>
</tr>
<?PHP } ?>



<?PHP
if ((isset($_POST['step'])) && ($_POST['step'] == 4)) {
$logingood = '';
$error = '';


if (isset($_POST['create'])) {
$error = '';

if(strlen(trim($_POST['ad_username'])) < 4) {
$error .= "- Username Must Be 4-12 characters in length.<br />"; }

if(strlen(trim($_POST['ad_username'])) > 12) {
$error .= "- Username Must Be 4-12 characters in length.<br />"; }

if(strlen(trim($_POST['ad_password'])) < 4) {
$error .= "- Password Must Be 4-12 characters in length.<br />"; }

if(strlen(trim($_POST['ad_password'])) > 12) {
$error .= "- Password Must Be 4-12 characters in length.<br />"; }

if((preg_match("/[^a-z0-9_]/i", $_POST['ad_username']))) {
$error .= "- Username may only contain letters, numbers and underscores.<br />"; }

if((preg_match("/[^a-z0-9_]/i", $_POST['ad_password']))) {
$error .= "- Password may only contain letters, numbers and underscores.<br />"; }

if (!$_POST['ad_username']) {
$error .= "- Missing Username<br />"; }

if (!$_POST['ad_password']) {
$error .= "- Missing Password<br />"; }

if (($_POST['ad_password']) != ($_POST['vr_password'])) {
$error .= "- Passwords Do Not Match<br />"; }

function email_valid($credential) {
$rtn_value = false;
if (get_magic_quotes_gpc()) {
$credential = stripslashes($credential); }
if ((preg_match("/^([a-zA-Z0-9_]|\\-|\\.)+@(([a-zA-Z0-9_]|\\-)+\\.)+[a-z]{2,4}\$/i", $credential))) {
$rtn_value=true; } return $rtn_value; }

$email = $_POST['email'];
if (!email_valid($email)) { $error .= "- Invalid email address.<br />"; }


if (!$error) {
$writeadmin = quote_smart($_POST['ad_username']);
$writepassw = quote_smart($_POST['ad_password']);
$writeemail = quote_smart($_POST['email']);
$writepassw = sha1($secret_unlock_key.$writepassw);
mysql_query ("insert into idevaff_admin (adminid, adminpass, super, email) values ('$writeadmin', '$writepassw', 1, '$writeemail')");
mysql_query ("update idevaff_email_settings set address = '$writeemail', alternate_email_address = '$writeemail'");
$logingood = 1; } }

?>


<tr><td width="100%" bgcolor="#FFFFFF" colspan="3" height="35"><b>Create Your Admin Username & Password</b> [ <a href="help/account.php" title="Admin Account Help" rel="gb_page_center[500, 100]">View Requirements</a> ]</td></tr>
<?PHP if ($error) { ?>
<tr><td width="100%" bgcolor="#ff7800" colspan="3"><font color="#FFFFFF"><b>Processing Error</b><br /><?PHP echo $error; ?></font></td></tr>
<?PHP } ?>
<?PHP if ($logingood) { ?>
<tr><td width="100%" bgcolor="#3399FF" colspan="3"><font color="#FFFFFF"><b>Administrative Login Successfully Created!</b></font></td></tr>
<?PHP } ?>
<tr><td width="30%" bgcolor="#FFFFFF" align="right">Create Admin Username:</td>
<form method="POST" action="index.php">
<input type="hidden" name="license" value="<?PHP echo $license; ?>">
<?PHP if (!$logingood) { ?>
<input type="hidden" name="step" value="4">
<input type="hidden" name="newinstall" value="1">
<input type="hidden" name="create" value="1">
<?PHP } else { ?>
<input type="hidden" name="step" value="5">
<input type="hidden" name="newinstall" value="1">
<?PHP } ?>
<td width="70%" bgcolor="#FFFFFF" colspan="2"><input type="text" name="ad_username" size="20" value="<?PHP if(!isset($_POST['ad_username'])) { echo "admin"; } else { print $_POST['ad_username'];} ?>"></td></tr>
<tr><td width="30%" bgcolor="#efefef" align="right">Create Admin Password</td>
<td width="35%" bgcolor="#efefef"><input type="password" name="ad_password" size="20" value="<?PHP if(isset($_POST['ad_password'])) { echo $_POST['ad_password']; } ?>"></td>
<?PHP if (!$logingood) { ?>
<td width="35%" bgcolor="#FFFFFF" rowspan="2" align="center"><font color="#CC0000"><b>Passwords Must Match!</b></font></td>
<?PHP } else { ?>
<td width="35%" bgcolor="#FFFFFF" rowspan="2" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#000000">
<tr><td width="100%"><table border="0" cellspacing="1" width="100%">
<tr><td width="100%" colspan="2">&nbsp;<b><font color="#FFFFFF">Administrative Login</font></b></td></tr>
<tr><td width="40%" bgcolor="#EFEFEF">&nbsp;<b>Username:</b></td><td width="60%" bgcolor="#EFEFEF">&nbsp;<font color="#CC0000"><?PHP if (isset($_POST['ad_username'])) { echo $_POST['ad_username']; } ?></font></td></tr>
<tr><td width="40%" bgcolor="#EFEFEF">&nbsp;<b>Password:</b></td><td width="60%" bgcolor="#EFEFEF">&nbsp;<font color="#CC0000"><?PHP if (isset($_POST['ad_password'])) { echo $_POST['ad_password']; } ?></font></td></tr>
</table></td></tr></table>
</td>
<?PHP } ?>
</tr>
<tr>
<td width="30%" bgcolor="#efefef" align="right">Verify Admin Password</td>
<td width="35%" bgcolor="#efefef"><input type="password" name="vr_password" size="20" value="<?PHP if (isset($_POST['vr_password'])) { echo $_POST['vr_password']; } ?>"></td></tr>

<tr>
<td width="30%" bgcolor="#FFFFFF" align="right">Email Address</td>
<td width="35%" bgcolor="#FFFFFF" colspan="2"><input type="text" name="email" size="30" value="<?PHP if (isset($_POST['email'])) { echo $_POST['email']; } ?>"></td></tr>
<tr>

<?PHP if (!$logingood) { ?>
<td width="30%" bgcolor="#FFFFFF"></td><td width="70%" bgcolor="#FFFFFF" colspan="2"><input type="submit" value="Create My Login"></td></form>
<?PHP } else { ?>
<td width="100%" bgcolor="#FFFFFF" colspan="3" align="right"><input type="submit" value="Continue To Next Step"></td></form>
<?PHP } ?>
</tr>
<?PHP } ?>


<?PHP if ((isset($_POST['step'])) && ($_POST['step'] == 5)) { ?>



<tr>
<td width="100%" bgcolor="#FFFFFF">

<table border="0" cellspacing="0" width="100%" cellpadding="0">
<tr><td width="100%" colspan="2"><font size="3" color="#CC0000"><b>Congratulations! Your Installation Is Complete!</b></font></td></tr>
<tr><td width="100%" colspan="2" height="10"></td></tr>
<tr><td width="5%" align="center"><img src="../images/mark.gif" height="16" width="16"></td><td width="95%">Rename or remove the <b><font color="#CC0000">/install/</font></b> directory.&nbsp; You cannot login to your admin center until you perform this task.</td></tr>
<tr><td width="100%" colspan="2" height="10"></td></tr>
</table>

</td>
</tr>

<tr>
<td width="100%" bgcolor="#FFFFFF">
<table border="0" cellspacing="0" width="100%" cellpadding="6">
<tr><td width="100%"height="20" colspan="2"></td></tr>
<tr>
<td width="50%" align="right">
<form method="post" action="../admin/index.php" target="_blank">
<input type="submit" name="admin" value="Login To Admin Center" style=width:200px; />
</td></form>
<td width="50%" align="left">
<form method="post" action="../index.php" target="_blank">
<input type="submit" name="admin" value="View Affiliate Control Panel" style=width:200px; />
</td></form>
</tr>
<tr><td width="100%"height="20" colspan="2"></td></tr>
</table>
</td>
</tr>


<?PHP if (($edition == 2) || ($edition == 3)) { ?>

<tr>
<td width="100%" bgcolor="#FFFFFF">
<table border="0" cellspacing="0" width="100%" cellpadding="0">
<tr><td width="100%"><font size="3"><b><?PHP echo $write_edition; ?> Note</b></td></tr>
<tr><td width="100%"height="10"></td></tr>
<tr><td width="100%">Unzip "commissionalert_admin.zip" found in the /commissionalert/ directory.&nbsp; Find the location you unzipped the file to on your hard drive and run the setup.exe program. Once installed, click <font color="#CC000">Start</font> -> <font color="#CC000">Programs</font> -> <font color="#CC000">CommissionAlert</font> and start the program.&nbsp; Right click the shopping cart icon then click on <b>Settings</b>.  Fill in the form and you now have CommissionAlert installed.</td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
</td>
</tr>

<?PHP } ?>


<tr>
<td width="100%" bgcolor="#FFFFFF">
<table border="0" cellspacing="0" width="100%" cellpadding="0">
<tr><td width="100%" colspan="2"><font size="3"><b>Post Installation Notes</b></td></tr>
<tr><td width="100%" colspan="2" height="10"></td></tr>
<tr><td width="5%" align="center"><img src="../images/mark.gif" height="16" width="16"></td><td width="95%">You can now login to your admin center.&nbsp; Once you're logged in, click on the <a href="help/images/qsg.png" width="756" height="208" title="Quick Setup Guide" rel="lightbox"><b>Quick Setup Guide</b></a> link to continue your configuration.</td></tr>
<tr><td width="100%" colspan="2" height="10"></td></tr>
<tr><td width="5%" align="center"><img src="../images/mark.gif" height="16" width="16"></td><td width="95%">Be sure to watch the <a href="help/images/advt.png" width="756" height="208" title="Admin Training Videos" rel="lightbox"><b>Admin Training Videos</b></a> so you can learn how to use all the features iDevAffiliate has to offer.</td></tr>
<tr><td width="100%" colspan="2" height="10"></td></tr>
<tr><td width="5%" align="center"><img src="../images/mark.gif" height="16" width="16"></td><td width="95%"><a href="help/images/affvt.png" width="756" height="208" title="Affiliate Training Videos" rel="lightbox"><b>Affiliate Training Videos</b></a> are a great way to increase affiliate activity and sales, right out of the gate.</td></tr>
<tr><td width="100%" colspan="2" height="10"></td></tr>
</table>
</td>
</tr>

<?PHP } ?>

</table>
</td></tr>




<table border="0" cellspacing="1" width="700" cellpadding="0" align="center">
<tr><td width="100%" bgcolor="#3333CC" align="right" height="20"><b><font color="#FFFFFF">Copyright <?PHP echo "2002-" . date("Y"); ?> - iDevDirect.com L.L.C. - </font></b><a href="http://www.idevdirect.com/" target="_blank"><font color="yellow"><b>iDevAffiliate</b></font></a> &nbsp;</td></tr>
</table>

<?PHP } ?>
</body>
</html>
