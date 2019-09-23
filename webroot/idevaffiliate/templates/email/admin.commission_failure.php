<?PHP

// FILE INCLUDE VALIDATION
if (!$EmailAuth) { exit(); }
// -------------------------------------------------------------------------------------------------

$edata=mysql_query("select admin_fail_subject, admin_fail_body from idevaff_email");
$indv_data=mysql_fetch_array($edata);
$sub=$indv_data['admin_fail_subject'];
$sub=preg_replace("/Sitename/",$sitename,$sub);
$con=$indv_data['admin_fail_body'];
$con=preg_replace("/Sitename/",$sitename,$con);

if ($transport == 1) {

$to = "iDevAffiliate Mailbox <$address>";
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "From: iDevAffiliate Mailbox <$address>\r\n";
$headers .= "Reply-To: iDevAffiliate Mailbox <$address>\r\n";
$headers .= "Reply-Path: iDevAffiliate Mailbox <$address>\r\n";

$content = "$con

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
$mail->From = "$address";
$mail->FromName = "iDevAffiliate Mailbox";
$mail->AddAddress("$address","iDevAffiliate Mailbox");
$mail->Body = "$con

--------
Message Auto-Sent By iDevAffiliate $version";

$mail->Send();
$mail->ClearAddresses();
}

?>