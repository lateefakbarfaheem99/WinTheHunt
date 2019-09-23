<?PHP
#############################################################
## iDevAffiliate Version 6
## Copyright - iDevDirect.com L.L.C.
## Website: http://www.idevdirect.com/
## Support: http://www.idevsupport.com/
## Email:   support@idevdirect.com
#############################################################


#############################################################

// DO NOT EDIT BELOW UNLESS YOU WANT TO ALTER THE ACTIONS TAKEN DURING THE RECURRING COMMISSIONS PROCESS
// -----------------------------------------------------------------------------------------------------

// CONNECT TO THE DATABASE @ MAKE SITE CONFIG SETTINGS AVAILABLE
// ----------------------------------------------------------------
require_once("../API/config.php");
require_once("../includes/validation_functions.php");

// QUERY THE DATABASE FOR SECRET KEY
// ----------------------------------------------------------------
$s_key = mysql_query("select secret from idevaff_config");
$s_key = mysql_fetch_array($s_key);
$s_key = $s_key['secret'];

// CHECK VALID SECRET KEY IS PRESENT AND VALID
// - The variable is already sanitized.
// - The variable is already validated through _GET, or _POST.
// ------------------------------------------------------------------------------

$secret = check_type_api('secret');
if ($secret == $s_key) {

// QUERY THE DATABASE FOR DATA
// ----------------------------------------------------------------
$updated = mysql_query("select id from idevaff_recurring");
$updated = number_format(mysql_num_rows($updated));
$removed = mysql_query("select id from idevaff_recurring where pending = 1 and rec_now = 1");
$removed = number_format(mysql_num_rows($removed));
$reset = mysql_query("select id from idevaff_recurring where rec_now = 1");
$reset = number_format(mysql_num_rows($reset));

$date=(date ("Y-m-d"));
$time=(date ("H:i:s"));

// REMOVE 1 DAY FROM CURRENT RECURRING COMMISSIONS
// ----------------------------------------------------------------
mysql_query("update idevaff_recurring set rec_now = rec_now -1");
// ----------------------------------------------------------------

// INSERT NEW COMMISSION IF DAYS ARE COUNTED DOWN TO ZERO
// ----------------------------------------------------------------
$a = mysql_query("select * from idevaff_recurring where rec_now = 0");
if (mysql_num_rows($a)) {
while ($b = mysql_fetch_array($a)) {
$f = $b['id'];
$af = $b['aff_id'];
$ap = $b['amount'];
$tr = $b['tracking'];
$op1 = $b['op1'];
$op2 = $b['op2'];
$op3 = $b['op3'];
$profile = $b['profile'];
$oamount = $b['oamount'];
$type = $b['type'];
$sub_id = $b['sub_id'];
$tid1 = $b['tid1'];
$tid2 = $b['tid2'];
$tid3 = $b['tid3'];
$tid4 = $b['tid4'];
$target_url = $b['target_url'];
$referring_url = $b['referring_url'];

$ct=mysql_query("select tier from idevaff_affiliates where id = $af");
$te=mysql_fetch_array($ct);
$te=$te['tier'];
if (!$profile) { $profile = 9000; }

mysql_query("insert into idevaff_sales (id, date, time, payment, tier, code, tracking, recurring, op1, op2, op3, amount, type, profile, sub_id, tid1, tid2, tid3, tid4, target_url, referring_url) values ('$af', '$date', '$time', '$ap', '$te', '$sale_time', '$tr', '$f', '$op1', '$op2', '$op3', '$oamount', '$type', '$profile', '$sub_id', '$tid1', '$tid2', '$tid3', '$tid4', '$target_url', '$referring_url')");
if ($sale_notify == 1) { include ("../templates/email/admin.recurring_commission.php"); }

// REMOVE COMMISSIONS THAT ARE PENDING REMOVAL
// ----------------------------------------------------------------
mysql_query("delete from idevaff_recurring where pending = 1 and rec_now = 0");
// ----------------------------------------------------------------

// RESET COMMISSIONS BACK TO ORIGINAL COUNT DOWN DAYS FOR REPEAT PROCESSING
// ----------------------------------------------------------------
mysql_query("update idevaff_recurring set rec_now = rec_stamp where id = $f");
// ----------------------------------------------------------------

} }

// EMAIL DAILY ADMIN REPORT
// ----------------------------------------------------------------
include_once($path . "/templates/email/class.phpmailer.php");
include_once($path . "/templates/email/class.smtp.php");
$mail = new PHPMailer();
$mail->IsSMTP();

$mail->SMTPAuth = $smtp_auth;
$mail->SMTPSecure = "$smtp_security";
$mail->CharSet = "$smtp_char_set";
$mail->Host = "$smtp_host";
$mail->Port = $smtp_port;
$mail->Username = "$smtp_user";
$mail->Password = "$smtp_pass";

$mail->Subject = "iDevAffiliate Recurring Commissions Report";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "iDevAffiliate Daily Recurring Commissions Report
----------------------------------------------------------------
Current Recurring Commissions: $updated
New Commissions Created Today: $reset
Rec Commissions Removed Today: $removed";

$mail->Send();
$mail->ClearAddresses();


} else {


// EMAIL FAILED SECRET NOTIFICATION
// ----------------------------------------------------------------
if (!$secret) { $secret = "None"; }
include_once($path . "/templates/email/class.phpmailer.php");
include_once($path . "/templates/email/class.smtp.php");
$mail = new PHPMailer();
$mail->IsSMTP();

$mail->SMTPAuth = $smtp_auth;
$mail->SMTPSecure = "$smtp_security";
$mail->CharSet = "$smtp_char_set";
$mail->Host = "$smtp_host";
$mail->Port = $smtp_port;
$mail->Username = "$smtp_user";
$mail->Password = "$smtp_pass";

$mail->Subject = "iDevAffiliate Recurring Commissions Report";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "Invalid or missing secret key.  No recurring commissions were processed.\n\nKey Used: ". $secret;

$mail->Send();
$mail->ClearAddresses();

}

?>