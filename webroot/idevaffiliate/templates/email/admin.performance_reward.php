<?PHP

// FILE INCLUDE VALIDATION
if (!$EmailAuth) { exit(); }
// -------------------------------------------------------------------------------------------------

// ------------------------------------------------
$adata=mysql_query("select id, username, password, f_name, l_name, email from idevaff_affiliates where id = '$update_account_process'");
$indv_data=mysql_fetch_array($adata);
$id=$indv_data['id'];
$name=$indv_data['username'];
$pass=$indv_data['password'];
$fname=$indv_data['f_name'];
$lname=$indv_data['l_name'];
$e=$indv_data['email'];
// ------------------------------------------------
$edata=mysql_query("select admin_rew_subject, admin_rew_body from idevaff_email");
$indv_data=mysql_fetch_array($edata);
$sub=$indv_data['admin_rew_subject'];
$sub=preg_replace("/Sitename/",$sitename,$sub);
$con=$indv_data['admin_rew_body'];
$con=preg_replace("/Sitename/",$sitename,$con);
// ------------------------------------------------
$con = preg_replace("/_id_/", "$id", $con);
$con = preg_replace("/_username_/", "$name", $con);
$con = preg_replace("/_password_/", "$pass", $con);
$con = preg_replace("/_firstname_/", "$fname", $con);
$con = preg_replace("/_lastname_/", "$lname", $con);
$con = preg_replace("/_email_/", "$e", $con);
$con = preg_replace("/_webhome_/", "$siteurl", $con);
$con = preg_replace("/_affhome_/", "$base_url/index.php", $con);
$con = preg_replace("/_loginpage_/", "$base_url/login.php", $con);

if ($link_style == 1) {
$con = preg_replace("/_afflink_/", "$base_url/$filename.php?id=$id", $con);
} elseif ($link_style == 2) {
$con = preg_replace("/_afflink_/", "$siteurl{$id}.html", $con); }

if ($transport == 1) {

$to = "iDevAffiliate Mailbox <$address>";
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "From: iDevAffiliate Mailbox <$address>\r\n";
$headers .= "Reply-To: iDevAffiliate Mailbox <$address>\r\n";
$headers .= "Reply-Path: iDevAffiliate Mailbox <$address>\r\n";

$content = "$con

Username: $eusername

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

Username: $eusername

--------
Message Auto-Sent By iDevAffiliate $version";

$mail->Send();
$mail->ClearAddresses();
}

?>