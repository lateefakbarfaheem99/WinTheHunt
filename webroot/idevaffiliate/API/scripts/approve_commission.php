<?PHP
#############################################################
## iDevAffiliate Version 6
## Copyright - iDevDirect.com L.L.C.
## Website: http://www.idevdirect.com/
## Support: http://www.idevsupport.com/
## Email:   support@idevdirect.com
#############################################################

// ----------------------------------------------------------------
// We've designed this API file as simple as possible.  We didn't use any 
// complex queries and everything should be fairly self explanatory.
// Have fun customizing this API file to meet your needs.
// ----------------------------------------------------------------

// CONNECT TO THE DATABASE & MAKE SITE CONFIG SETTINGS AVAILABLE
// ----------------------------------------------------------------
require_once("../../API/config.php");
require_once("../../includes/validation_functions.php");

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

// QUERY & SANITIZE ALL INCOMING DATA
// ----------------------------------------------------------------
if (isset($_REQUEST['order_number'])) { $order_number = quote_smart($_REQUEST['order_number']); } else { $order_number = null; }

// CHECK IF ORDER NUMBER EXISTS
// ----------------------------------------------------------------
if ($order_number) {

// GATHER COMMISSION DATA
// ----------------------------------------------------------------
$check_order_number = mysql_query("select * from idevaff_sales where tracking = '$order_number' and approved = 0");
if (mysql_num_rows($check_order_number)) {
$commission_data = mysql_fetch_array($check_order_number);
$record = $commission_data['record'];
$aff_id = $commission_data['id'];
$cust_ip = $commission_data['ip'];
$payment = $commission_data['payment'];
$tier = $commission_data['tier'];

$getpaylevel=mysql_query("select level, type from idevaff_affiliates where id = $aff_id");
$paylevel=mysql_fetch_array($getpaylevel);
$level=$paylevel['level'];
$type=$paylevel['type'];

// APPROVE THE COMMISSION
// ----------------------------------------------------------------
mysql_query("update idevaff_sales set approved = 1 where tracking = '$order_number'");

$email_notice = "The API file (approve_commission.php) successfully approved a commission.

Order Number: " . $order_number;

// UPDATE MARKETING STATS
// ----------------------------------------------------------------
if ($aff_lock == 1) { $unlock = " order by id desc"; } else { $unlock = null; }
$checkip = mysql_query("select src1, src2 from idevaff_iptracking where ip = '$cust_ip'{$unlock}");				
$ipdata = mysql_fetch_array($checkip);
$src1 = $ipdata['src1'];
$src2 = $ipdata['src2'];

if (($src1) && ($src2)) {
if ($src1 == 1) { $table = "banners"; $col = "number"; }
if ($src1 == 2) { $table = "ads"; $col = "id"; }
if ($src1 == 3) { $table = "links"; $col = "id"; }
if ($src1 == 4) { $table = "htmlads"; $col = "id"; }
if ($src1 == 5) { $table = "email_templates"; $col = "id"; }
if ($src1 == 6) { $table = "peels"; $col = "number"; }
mysql_query("update idevaff_$table set conv = conv+1 where $col = '$src2'"); }
if ($type == 3) { mysql_query("update idevaff_affiliates set conv = conv+1 where id = $aff_id"); }

// EMAIL AFFILIATE - NEW COMMISSION: IF ENABLED
// ----------------------------------------------------------------
if ($sale_notify_affiliate == 1) {
$id = $aff_id;
$email = 'top';
$payout = $payment;
include("$path/templates/email/affiliate.new_commission.php"); }

// INSERT TIER COMMISSION IF REQUIRED
// ----------------------------------------------------------------
if ($tier > 0) {
$acct = mysql_query("select * from idevaff_sales where record = $record");
$qry = mysql_fetch_array($acct);
$uid = $qry['record'];
$id = $qry['id'];
$date = $qry['date'];
$time = $qry['time'];
$payment = $qry['payment'];
$tier = $qry['tier'];
$tracking_code = $qry['tracking'];
$sales_code = $qry['code'];
$recstatus = $qry['recurring'];
$op1 = $qry['op1'];
$op2 = $qry['op2'];
$op3 = $qry['op3'];
$profile = $qry['profile'];
$type = $qry['type'];
$ip = $qry['ip'];
$amount = $qry['amount'];
$sub_id = $qry['sub_id'];
$tid1 = $qry['tid1'];
$tid2 = $qry['tid2'];
$tid3 = $qry['tid3'];
$tid4 = $qry['tid4'];
$target_url = $qry['target_url'];
$referring_url = $qry['referring_url'];

$tpay=mysql_query("select tier_payout, tpaystyle, tier_payout_flat from idevaff_config");
$tierpayout=mysql_fetch_array($tpay);
$tstyle = $tierpayout['tpaystyle'];
if ($tstyle == 1) {
$tpayout = $tierpayout['tier_payout'];
$tpayout = $payment * $tpayout;
} else {
$tpayout = $tierpayout['tier_payout_flat']; }
$commission_rate = $tpayout;
mysql_query("insert into idevaff_sales (id, date, time, payment, top_tier_tag, approved, ip, code, tracking, tier_id, rec_id, op1, op2, op3, amount, type, profile, sub_id, tid1, tid2, tid3, tid4, target_url, referring_url) values ($tier, '$date', '$time', '$commission_rate', '1', '1', '$ip', '$sales_code', '$tracking_code', '$id', '$record', '$op1', '$op2', '$op3', '$amount', '$type', '$profile', '$sub_id', '$tid1', '$tid2', '$tid3', '$tid4', '$target_url', '$referring_url')");
if ($sale_notify_affiliate == 1) {
$id = $tier;
$email = 'tier';
$payout = $commission_rate;
include("$path/templates/email/affiliate.new_commission.php"); }
}

// PROCESS PERFORMANCE REWARDS: IF ENABLED
// ----------------------------------------------------------------
if ($rewards == 1) {
$afftype = $type;															
if (($rew_app == 1) && ($afftype == 1)) { $process = 1; }
if (($rew_app == 1) && ($afftype == 2)) { $process = 1; }
if (($rew_app == 2) && ($afftype == 3)) { $process = 1; }
if ($rew_app == 3) { $process = 1; }
if ($process == 1) {
$update_account_process = $aff_id;
include("$path/includes/process_rewards.php");
} }

} else {

// COMMISSION NOT FOUND
// ----------------------------------------------------------------
$email_notice = "
The API file (approve_commission.php) tried to approve a commission and couldn't.

Reason:
- No commission was found with the provided order number.

Order Number Received: " . $order_number;

} } else {

// ORDER NUMBER NOT RECEIVED
// ----------------------------------------------------------------
$email_notice = "
The API file (approve_commission.php) tried to remove a commission and couldn't.

Reason:
- No order number was received.

Order Number Received: " . $order_number;

}

// EMAIL NOTIFICATION TO ADMIN
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

$mail->Subject = "iDevAffiliate API - Commission Approval Notification";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "$email_notice";

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

$mail->Subject = "iDevAffiliate API - Commission Approval Failure";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "Invalid or missing secret key.  No commission was removed.\n\nKey Used: ". $secret;

$mail->Send();
$mail->ClearAddresses();

}

?>
