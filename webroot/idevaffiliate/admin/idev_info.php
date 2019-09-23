<?PHP
session_start();
if (!isset($_SESSION['valid_admin'])) { header("Location: setup.php"); exit(); }

if (isset($_POST['new_license'])) {
include("../API/config.php");
$new_lic = mt_rand(1000000000000,9999999999999);
mysql_query("update idevaff_config set secret = '$new_lic'");
$sec_upd = "<font color=\"#CC0000\">&nbsp;<b>Secret Key Updated!</b>&nbsp; Be sure to update your CRONs and script calls!</font>"; }
require("templates/header.php");

?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="orangeHeading">
<tr>
<td width="30%"><b>iDevAffiliate Information</b></font></td>
<td width="70%" align="right"><?PHP if(isset($sec_upd)){echo"$sec_upd";}?></td>
</tr>
</table>

  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="main">
    <tr>
      <td width="25%">iDevAffiliate License</td>
      <td width="75%"><input type="text" name="license" value="<?PHP echo $license; ?>" size="40"></td>
    </tr>
    <tr>
      <td width="25%">License Type</td>
      <td width="75%">Owned - Valid For 1 Domain</td>
    </tr>
    <tr>
      <td width="25%">License Expires</td>
      <td width="75%">Never</td>
    </tr>
    <tr>
      <td width="25%">iDevAffiliate Version</td>
      <td width="75%">Version: <?PHP echo $version; ?></td>
    </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="greenHeading">
<tr>
<td width="50%"><b>General Utilities</b></font></td>
<td width="50%" align="right"></td>
</tr>
</table>
  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="main">
    <form method="POST" action="idev_info.php">
<input type="hidden" name="cfg" value="105">
	    <tr>
      <td width="25%">Debug Mode</td>
      <td width="75%"><select size="1" name="debug_mode" style="width=60;">
	  <option value="0" <?PHP if ($debug_mode == 0) { ?> selected <?PHP } ?>>Disabled</option>
	  <option value="1" <?PHP if ($debug_mode == 1) { ?> selected <?PHP } ?>>Enabled</option>
</select>
<img src="../images/help.gif" height="12" width="12" title="header=[Debug Mode] body=[Enable this feature if you want to display errors to the browser. Useful when troubleshooting and usually only used by iDevDirect staff.]" style="cursor:pointer;">
</td>
    </tr>
<tr>
<td width="25%">Maintenance Mode</td>
<td width="75%"><select size="1" name="maint_mode">
<option value="0" <?PHP if ($maint_mode == 0) { ?> selected <?PHP } ?>>Disabled</option>
<option value="1" <?PHP if ($maint_mode == 1) { ?> selected <?PHP } ?>>Enabled</option>
</select>
<img src="../images/help.gif" height="12" width="12" title="header=[Maintenance Mode] body=[This will disable signups to your affiliate program.]" style="cursor:pointer;">
</td>
</tr>
	<tr>
      <td width="25%"></td>
      <td width="75%"><input type="submit" value="Update Utilities Settings"></td></form>
    </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="blueHeading">
<tr>
<td width="50%"><b>Secret Key For API Scripts</b></font></td>
<td width="50%" align="right"></td>
</tr>
</table>

  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="main">
<form method="POST" action="idev_info.php">
    <tr>
      <td width="25%">Secret Key</td>
      <td width="75%"><input type="text" name="new_license" value="<?PHP echo $secret; ?>" size="20"> <?PHP if(isset($sec_upd)){echo"$sec_upd";}?></td>
    </tr>
    <tr>
      <td width="25%"></td>
      <td width="75%"><input type="submit" value="Generate A New Secret Key"></td></form>
    </tr>
  </table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="redHeading">
<tr>
<td width="50%"><b>Secret Key Warning</b></font></td>
<td width="50%" align="right"></td>
</tr>
</table>

  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
    <tr>
      <td width="100%">Your secret key is used by API files and CRON jobs to access files.&nbsp; It is designed to ensure only you are accesssing the files.&nbsp; If you reset this key, 
you need to make sure you update any CRON jobs or API calls that use this key.<br /><br />It's only advisable to reset this key if you believe it has become compromised.</td>
    </tr>
</table>

<?PHP include("templates/footer.php"); ?>