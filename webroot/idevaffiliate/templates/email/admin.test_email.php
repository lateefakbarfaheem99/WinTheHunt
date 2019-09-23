<?PHP

// FILE INCLUDE VALIDATION
if (!$EmailAuth) { exit(); }
// -------------------------------------------------------------------------------------------------

if ((isset($transport)) && ($transport == 1)) {

$to = "iDevAffiliate Admin<$address>";
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "From: $from_name <$address>\r\n";
$headers .= "Reply-To: $from_name <$address>\r\n";
$headers .= "Reply-Path: $from_name <$address>\r\n";

$sub= "iDevAffiliate Test Email";

$content = "Dear Admin,

If you're reading this email, your email settings are correct.

$signature";

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

$mail->Subject = "iDevAffiliate Test Email";
$mail->From = "$address";
$mail->FromName = "$from_name";
$mail->AddAddress("$address","iDevAffiliate Admin");
$mail->Body = "Dear Admin,

If you're reading this email, your email settings are correct.

$signature";

$mail->Send();
$mail->ClearAddresses();
}

?>