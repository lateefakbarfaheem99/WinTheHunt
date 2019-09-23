<?PHP
session_start();
if (!$_SESSION['valid_admin']) { header("Location: setup.php"); exit(); }
require("templates/header.php");
$da1 = (date ("Y"));
$da2 = (date ("m"));
$da3 = (date ("d"));
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="orangeHeading">
<tr>
<td width="100%"><b>Create A New Commission</b></td>
</tr>
</table>

<?PHP if (isset($_POST['cfg'])) { ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="redHeading">
<tr>
<td width="50%"><b>New Commission Added</b></td>
<td width="50%"></td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<tr><td width="100%">This commission still needs to be manually approved.&nbsp; <a href="approve_commissions.php">Approve It Here</a>
</td></tr></table>

<?PHP
} 
$chkaffs = mysql_query("select id from idevaff_affiliates where approved = '1'"); 
if (mysql_num_rows($chkaffs )) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<tr><td width="100%">
<b>Manually Enter A Commission For An Affiliate</b><br />Create bonuses, enter offline generated commissions, etc.
</td></tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main">
<form method="POST" action="create_commission.php">
<input type="hidden" name="cfg" value="10">
<input type="hidden" name="currency" value="<?PHP echo $currency; ?>">
<tr>
<td width="25%">Sale Date</td>
<td width="75%"><select size="1" name="month">
  <option value="01" <?PHP if ($da2 == '01') { print "selected"; } ?>>Jan</option>
  <option value="02" <?PHP if ($da2 == '02') { print "selected"; } ?>>Feb</option>
  <option value="03" <?PHP if ($da2 == '03') { print "selected"; } ?>>Mar</option>
  <option value="04" <?PHP if ($da2 == '04') { print "selected"; } ?>>Apr</option>
  <option value="05" <?PHP if ($da2 == '05') { print "selected"; } ?>>May</option>
  <option value="06" <?PHP if ($da2 == '06') { print "selected"; } ?>>Jun</option>
  <option value="07" <?PHP if ($da2 == '07') { print "selected"; } ?>>Jul</option>
  <option value="08" <?PHP if ($da2 == '08') { print "selected"; } ?>>Aug</option>
  <option value="09" <?PHP if ($da2 == '09') { print "selected"; } ?>>Sep</option>
  <option value="10" <?PHP if ($da2 == '10') { print "selected"; } ?>>Oct</option>
  <option value="11" <?PHP if ($da2 == '11') { print "selected"; } ?>>Nov</option>
  <option value="12" <?PHP if ($da2 == '12') { print "selected"; } ?>>Dec</option>
  </select>
  <select size="1" name="day">
  <option value="01" <?PHP if ($da3 == '01') { print "selected"; } ?>>01</option>
  <option value="02" <?PHP if ($da3 == '02') { print "selected"; } ?>>02</option>
  <option value="03" <?PHP if ($da3 == '03') { print "selected"; } ?>>03</option>
  <option value="04" <?PHP if ($da3 == '04') { print "selected"; } ?>>04</option>
  <option value="05" <?PHP if ($da3 == '05') { print "selected"; } ?>>05</option>
  <option value="06" <?PHP if ($da3 == '06') { print "selected"; } ?>>06</option>
  <option value="07" <?PHP if ($da3 == '07') { print "selected"; } ?>>07</option>
  <option value="08" <?PHP if ($da3 == '08') { print "selected"; } ?>>08</option>
  <option value="09" <?PHP if ($da3 == '09') { print "selected"; } ?>>09</option>
  <option value="10" <?PHP if ($da3 == '10') { print "selected"; } ?>>10</option>
  <option value="11" <?PHP if ($da3 == '11') { print "selected"; } ?>>11</option>
  <option value="12" <?PHP if ($da3 == '12') { print "selected"; } ?>>12</option>
  <option value="13" <?PHP if ($da3 == '13') { print "selected"; } ?>>13</option>
  <option value="14" <?PHP if ($da3 == '14') { print "selected"; } ?>>14</option>
  <option value="15" <?PHP if ($da3 == '15') { print "selected"; } ?>>15</option>
  <option value="16" <?PHP if ($da3 == '16') { print "selected"; } ?>>16</option>
  <option value="17" <?PHP if ($da3 == '17') { print "selected"; } ?>>17</option>
  <option value="18" <?PHP if ($da3 == '18') { print "selected"; } ?>>18</option>
  <option value="19" <?PHP if ($da3 == '19') { print "selected"; } ?>>19</option>
  <option value="20" <?PHP if ($da3 == '20') { print "selected"; } ?>>20</option>
  <option value="21" <?PHP if ($da3 == '21') { print "selected"; } ?>>21</option>
  <option value="22" <?PHP if ($da3 == '22') { print "selected"; } ?>>22</option>
  <option value="23" <?PHP if ($da3 == '23') { print "selected"; } ?>>23</option>
  <option value="24" <?PHP if ($da3 == '24') { print "selected"; } ?>>24</option>
  <option value="25" <?PHP if ($da3 == '25') { print "selected"; } ?>>25</option>
  <option value="26" <?PHP if ($da3 == '26') { print "selected"; } ?>>26</option>
  <option value="27" <?PHP if ($da3 == '27') { print "selected"; } ?>>27</option>
  <option value="28" <?PHP if ($da3 == '28') { print "selected"; } ?>>28</option>
  <option value="29" <?PHP if ($da3 == '29') { print "selected"; } ?>>29</option>
  <option value="30" <?PHP if ($da3 == '30') { print "selected"; } ?>>30</option>
  <option value="31" <?PHP if ($da3 == '31') { print "selected"; } ?>>31</option>
  </select>
  <select size="1" name="year">
  <option value="2003" <?PHP if ($da1 == '2003') { print "selected"; } ?>>2003</option>
  <option value="2004" <?PHP if ($da1 == '2004') { print "selected"; } ?>>2004</option>
  <option value="2005" <?PHP if ($da1 == '2005') { print "selected"; } ?>>2005</option>
  <option value="2006" <?PHP if ($da1 == '2006') { print "selected"; } ?>>2006</option>
  <option value="2007" <?PHP if ($da1 == '2007') { print "selected"; } ?>>2007</option>
  <option value="2008" <?PHP if ($da1 == '2008') { print "selected"; } ?>>2008</option>
  <option value="2009" <?PHP if ($da1 == '2009') { print "selected"; } ?>>2009</option>
  <option value="2010" <?PHP if ($da1 == '2010') { print "selected"; } ?>>2010</option>
  <option value="2011" <?PHP if ($da1 == '2011') { print "selected"; } ?>>2011</option>
  <option value="2012" <?PHP if ($da1 == '2012') { print "selected"; } ?>>2012</option>
  <option value="2013" <?PHP if ($da1 == '2013') { print "selected"; } ?>>2013</option>
  <option value="2014" <?PHP if ($da1 == '2014') { print "selected"; } ?>>2014</option>
  <option value="2015" <?PHP if ($da1 == '2015') { print "selected"; } ?>>2015</option>
  <option value="2016" <?PHP if ($da1 == '2016') { print "selected"; } ?>>2016</option>
  <option value="2017" <?PHP if ($da1 == '2017') { print "selected"; } ?>>2017</option>
  
  </select>
</tr>
<tr>
<td width="25%">Affiliate</td>
<td width="75%"><select size=1 name="affiliate_id">
<?PHP
$getnames = mysql_query("select id, username from idevaff_affiliates order by id"); 
if (mysql_num_rows($getnames)) {
while ($qry = mysql_fetch_array($getnames)) {
$chid=$qry[id];
$chuser=$qry[username];
print "<option value='$chid'";
if ((isset($id)) && ($chid == $id)) { print ' selected'; }
print ">Affiliate ID: $chid - Username: $chuser</option>\n"; } }
?>
</select>
</tr>

<tr>
<td width="25%">Commission Amount</td>
<td width="75%"><input type="text" name="payout" value="10.00" size="10" style="width=40";>&nbsp; (<b><?PHP echo $currency; ?></b>)
</tr>

<tr>
<td width="25%">Order Number</td>
<td width="75%"><input type="text" name="track_name" value="" size="25" style="width=100";>&nbsp; (optional)
</tr>

<tr>
<td width="25%"></td>
<td width="75%"><input type="submit" value="Create This Commission">
</td></form></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="greenHeading">
<tr>
<td width="50%"><b>Manual Commission Notes</b></td>
<td width="50%"></td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<tr>
<td width="100%">All commissions entered on this page will need approved.<br />After you enter the commission, click on <a href=approve_commissions.php>Approve Commissions</a>.&nbsp; You will see the new commission listed.
</td></tr>
</table>

<?PHP } else { ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main">
<tr><td width="100%">No <font color=#CC0000>Approved</font> Affiliates Exist In The Database</td></tr>
<table>

<?PHP } include("templates/footer.php"); ?>