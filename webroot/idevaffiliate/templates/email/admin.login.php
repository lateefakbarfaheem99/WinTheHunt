<?PHP

// FILE INCLUDE VALIDATION
if (!$EmailAuth) { exit(); }
// -------------------------------------------------------------------------------------------------

if (isset($_SESSION['new_password_request'])) {

$password = $_SESSION['new_password_request'];

$sub = "iDevAffiliate Admin Center Login";
$con = "Below are your admin center login details.  Your password has been reset.
Please change it again by logging into your account and click on \"Manage Admins\".";
$con2 = "If you did not request this login information, please consider password protecting the /admin/ folder of your iDevAffiliate installation.
You can do this with .htaccess or in your web hosting control panel.  Consult your web hosting provider for further details.";

if ($transport == 1) {

$to = "iDevAffiliate Mailbox <$email>";
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "From: iDevAffiliate Mailbox <$email>\r\n";
$headers .= "Reply-To: iDevAffiliate Mailbox <$email>\r\n";
$headers .= "Reply-Path: iDevAffiliate Mailbox <$email>\r\n";

$content = "$con

--------
Username: $username
Password: " . $_SESSION['new_password_request'] . "
--------

Login Here:
$base_url/admin/setup.php

$con2

--------
Message Auto-Sent By iDevAffiliate $version";

mail($to,$sub,$content,$headers);

} else {

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

$mail->Subject = "$sub";
$mail->From = "$email";
$mail->FromName = "iDevAffiliate Mailbox";
$mail->AddAddress("$email","iDevAffiliate Mailbox");
$mail->Body = "$con

--------
Username: $username
Password: " . $_SESSION['new_password_request'] . "
--------

Login Here:
$base_url/admin/setup.php

$con2

--------
Message Auto-Sent By iDevAffiliate $version";

$mail->Send();
$mail->ClearAddresses();
}

unset($_SESSION['new_password_request']);

} else { echo "Exiting..."; }


?>