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
include_once("../../includes/validation_functions.php");

// QUERY THE DATABASE FOR SECRET KEY
// ------------------------------------------------------------------------------
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
$order_number = check_type('order_number');

// CHECK IF ORDER NUMBER EXISTS
// ----------------------------------------------------------------
if ($order_number) {

$check_order_number = mysql_query("select record from idevaff_sales where tracking = '$order_number'");
if (mysql_num_rows($check_order_number)) {

// REMOVE THE COMMISSIONS
// ----------------------------------------------------------------
mysql_query("delete from idevaff_sales where tracking = '$order_number'");

$email_notice = "
The API file (terminate_commission.php) successfully removed a commission.

Order Number: " . $order_number;

} else {

// COMMISSION NOT FOUND
// ----------------------------------------------------------------
$email_notice = "
The API file (terminate_commission.php) tried to remove a commission and couldn't.

Reason:
- No commission was found with the provided order number.

Order Number Received: " . $order_number;

} } else {

// ORDER NUMBER NOT RECEIVED
// ----------------------------------------------------------------
$email_notice = "
The API file (terminate_commission.php) tried to remove a commission and couldn't.

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

$mail->Subject = "iDevAffiliate API - Commission Removal Notification";
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

$mail->Subject = "iDevAffiliate API - Commission Removal Failure";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "Invalid or missing secret key.  No commission was removed.\n\nKey Used: ". $secret;

$mail->Send();
$mail->ClearAddresses();

}

?>
