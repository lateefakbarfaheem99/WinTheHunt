<?PHP
#############################################################
## iDevAffiliate Version 6
## Copyright - iDevDirect.com L.L.C.
## Website: http://www.idevdirect.com/
## Support: http://www.idevsupport.com/
## Email:   support@idevdirect.com
#############################################################

// ------------------------------------------------------------------------------
// We've designed this API file as simple as possible.  We didn't use any 
// complex queries and everything should be fairly self explanatory.
// ------------------------------------------------------------------------------

// CONNECT TO THE DATABASE & MAKE SITE CONFIG SETTINGS AVAILABLE
// ------------------------------------------------------------------------------
include_once("../../API/config.php");
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
// - These variables are already sanitized.
// - These variables are already validated through global $$, _GET, or _POST.
// ------------------------------------------------------------------------------

$username = check_type('username');
$password = check_type('password');
$email = check_type('email');
$approved = check_type('approved');
$payout_type = check_type('payout_type');
$payout_level = check_type('payout_level');
$use_paypal = check_type('use_paypal');
$paypal_account = check_type('paypal_account');
$first_name = check_type('first_name');
$last_name = check_type('last_name');
$company = check_type('company');
$payable = check_type('payable');
$tax_id = check_type('tax_id');
$website = check_type('website');
$address_1 = check_type('address_1');
$address_2 = check_type('address_2');
$city = check_type('city');
$state = check_type('state');
$zip = check_type('zip');
$country = check_type('country');
$phone = check_type('phone');
$fax = check_type('fax');
$tier = check_type('tier');

// OVERRIDE APPROVED VARIABLE WITH SETTINGS FROM ADMIN CENTER
// Uncomment to disable this override.
// ----------------------------------------------------------------
if (!$account_approval) { $approved = 1; } else { $approved = 0; }

// SET PAYOUT TYPE TO FIRST AVAILABLE IF NONE WAS PRESENT
// ----------------------------------------------------------------
if ($ap_1) { $payout_type = 1;
} elseif ($ap_2) { $payout_type = 2;
} elseif ($ap_3) { $payout_type = 3; }

// SET PAYOUT LEVEL TO 1 IF NONE WAS PRESENT
// ----------------------------------------------------------------
if (!$payout_level) { $payout_level = 1; }

// CHECK FOR REQUIRED INFORMATION
// ----------------------------------------------------------------
include_once("new_affiliate_validation.php");

if (!$error) {

// CREATE THE ACCOUNT
// ----------------------------------------------------------------

mysql_query("insert into idevaff_affiliates (

		username, 
		password, 
		approved, 
		payable, 
		tax_id_ssn, 
		company, 
		f_name, 
		l_name, 
		email, 
		address_1, 
		address_2, 
		city, 
		state, 
		zip, 
		country, 
		phone, 
		fax, 
		url, 
		pp, 
		paypal, 
		tier, 
		type, 
		level

) VALUES (

		'$username', 
		'$password', 
		'$approved', 
		'$payable', 
		'$tax_id', 
		'$company', 
		'$first_name', 
		'$last_name', 
		'$email', 
		'$address_1', 
		'$address_2', 
		'$city', 
		'$state', 
		'$zip', 
		'$country', 
		'$phone', 
		'$fax', 
		'$website', 
		'$use_paypal', 
		'$paypal_account', 
		'$tier', 
		'$payout_type', 
		'$payout_level'

)");

// ENCRYPT PASSWORD & SSN/TAX ID IN DATABASE
// ----------------------------------------------------------------
include_once("../../includes/enc_insert.php");

// EMAIL ADMIN - NEW ACCOUNT: IF ENABLED
// ----------------------------------------------------------------
if ($mailadmin == 1) { include($path.'/templates/email/admin.new_account.php'); }

// EMAIL AFFILIATE - WELCOME NOTICE: IF ENABLED
// ----------------------------------------------------------------
if ($we == 1) { include($path.'/templates/email/affiliate.welcome.php'); }

// WRITE SIGNUP BONUS IF ENABLED
// ----------------------------------------------------------------
if ($initialbalance > 0) {
$newid = mysql_query("select id from idevaff_affiliates where username = '$username'");
$getid = mysql_fetch_array($newid);
$insertid = $getid['id'];
mysql_query("insert into idevaff_sales (id, date, time, payment, bonus, approved, ip, code) values ('$insertid', '$cdate', '$ctime', '$initialbalance', '1', '1', '$ip_addr', '$sale_time')");
}


} else {

// EMAIL FAILED VALIDATION TO ADMIN
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

$mail->Subject = "iDevAffiliate API - New Account Failure";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "Account creation failed.  Reason:

$error";

$mail->Send();
$mail->ClearAddresses();

}

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

$mail->Subject = "iDevAffiliate API - New Account Failure";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "Invalid or missing secret key.  No account was created.\n\nKey Used: ". $secret;

$mail->Send();
$mail->ClearAddresses();
}

?>
