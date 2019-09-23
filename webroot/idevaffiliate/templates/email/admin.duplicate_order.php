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

$sub= "iDevAffiliate Duplicate Commission Error";

$content = "iDevAffiliate tried to write a new commission to the system and couldn't.  This is because a commission already exists in the database with this order number.

Duplicate Order Number: $idev_ordernum

---
To change these settings and allow duplicate order numbers into the system, login to your admin center and navigate to the following area.

General Settings > Fraud Control - Pick a setting other than \"Order Number\".";

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

$mail->Subject = "iDevAffiliate Duplicate Commission Error";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "iDevAffiliate tried to write a new commission to the system and couldn't.  This is because a commission already exists in the database with this order number.

Duplicate Order Number: $idev_ordernum

---
To change these settings and allow duplicate order numbers into the system, login to your admin center and navigate to the following area.

General Settings > Fraud Control - Pick a setting other than \"Order Number\".";

$mail->Send();
$mail->ClearAddresses();
}

?>