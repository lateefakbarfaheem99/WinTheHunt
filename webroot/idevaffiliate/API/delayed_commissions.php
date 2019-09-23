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

// CONNECT TO THE DATABASE & MAKE SITE CONFIG SETTINGS AVAILABLE
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
$total_delayed = mysql_query("select id from idevaff_sales where delay > 1 and payment > 0");
$total_delayed = number_format(mysql_num_rows($total_delayed));
$processing = mysql_query("select id from idevaff_sales where delay = 1 and payment > 0");
$processing = number_format(mysql_num_rows($processing));

$date=(date ("Y-m-d"));
$time=(date ("H:i:s"));

// PROCESS COMMISSION IF DAYS ARE COUNTED DOWN TO ZERO
// ----------------------------------------------------------------
$a = mysql_query("select * from idevaff_sales where delay > 0 and payment > 0");
if (mysql_num_rows($a)) {
while ($qry = mysql_fetch_array($a)) {

$uid = $qry['record'];
$id = $qry['id'];
$date = $qry['date'];
$time = $qry['time'];
$payment = $qry['payment'];
$tier = $qry['tier'];
$tracking_code = $qry['tracking'];
$sales_code = $qry['code'];
$recstatus = $qry['recurring'];
$ov1 = $qry['op1'];
$ov2 = $qry['op2'];
$ov3 = $qry['op3'];
if (!$ov1) { $ov1 = null; }
if (!$ov2) { $ov2 = null; }
if (!$ov3) { $ov3 = null; }
$profile = $qry['profile'];
$type = $qry['type'];
$ip = $qry['ip'];
$amount = $qry['amount'];
$delay = $qry['delay'];
$sub_id = $qry['sub_id'];
$tid1 = $qry['tid1'];
$tid2 = $qry['tid2'];
$tid3 = $qry['tid3'];
$tid4 = $qry['tid4'];
$target_url = $qry['target_url'];
$referring_url = $qry['referring_url'];

if ($delay_action == 1) {

mysql_query("update idevaff_sales set approved = 1 where delay = 1");
if ($rewards == 1) {
if (($rew_app == 1) || ($rew_app == 3)) { $update_account_process = $id; include("$path/includes/process_rewards.php"); } }

if ($delay == 1) {
if ($sale_notify_affiliate == 1) {
$email = 'top'; $payout = $payment;
include("$path/templates/email/affiliate.new_commission.php");
}

if ($tier > 0) { $tiernumber = $tier; } else { $tiernumber = 0; }

if ($tiernumber > 0) {
$lastrec=mysql_query("select max(record) as latest from idevaff_sales");
$lastres=mysql_fetch_array($lastrec);
$lastres=$lastres['latest'];
if ($tpaystyle == 2) { $tpay = $tier_payout_flat; } else {
$tpay = $payment * $tier_payout;
$tpay = (number_format($tpay,2)); }
if ($tpay >= .01) {
mysql_query("insert into idevaff_sales (id, date, time, payment, top_tier_tag, approved, code, tracking, tier_id, rec_id, amount, op1, op2, op3, type, profile, sub_id, tid1, tid2, tid3, tid4, target_url, referring_url) values ('$tiernumber', '$cdate', '$ctime', '$tpay', '1', '1', $sales_code, '$tracking_code', '$id', '$lastres', '$amount', '$ov1', '$ov2', '$ov3', '$type', '$profile', '$sub_id', '$tid1', '$tid2', '$tid3', '$tid4', '$target_url', '$referring_url')");
if ($sale_notify_affiliate == 1) {
$id = $tiernumber; $email = 'tier'; $payout = $tpay;
include("$path/templates/email/affiliate.new_commission.php");
}
} } }

} else {

mysql_query("update idevaff_sales set approved = 0 where delay = 1"); }

} }

// REMOVE 1 DAY FROM CURRENT DELAYED COMMISSIONS
// ----------------------------------------------------------------
mysql_query("update idevaff_sales set delay = delay -1 where delay > 0 and payment > 0");
// ----------------------------------------------------------------


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

$mail->Subject = "iDevAffiliate Delayed Commissions Report";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "iDevAffiliate Daily Delayed Commissions Report
----------------------------------------------------------------
Total Delayed Commissions In Queue: $total_delayed
Delayed Commissions Processed Today: $processing";

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

$mail->Subject = "iDevAffiliate Delayed Commissions Report";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "Invalid or missing secret key.  No delayed commissions were processed.\n\nKey Used: ". $secret;

$mail->Send();
$mail->ClearAddresses();

}

?>
