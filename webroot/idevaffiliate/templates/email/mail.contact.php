<?PHP

// FILE INCLUDE VALIDATION
if (!$EmailAuth) { exit(); }
// -------------------------------------------------------------------------------------------------

$e = $email;
$u = $name;
$m = $message;

if ($transport == 1) {

$to = "$from_name <$alternate_email_address>";
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "From: $u <$e>\r\n";
$headers .= "Reply-To: $u <$e>\r\n";
$headers .= "Reply-Path: $u <$e>\r\n";

$sub= "Affiliate Contact";

$content = "$m";

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

$mail->Subject = "Affiliate Contact";
$mail->From = "$e";
$mail->FromName = "$u";
$mail->AddAddress("$alternate_email_address","$from_name");
$mail->Body = "$m";

$mail->Send();
$mail->ClearAddresses();
}

?>