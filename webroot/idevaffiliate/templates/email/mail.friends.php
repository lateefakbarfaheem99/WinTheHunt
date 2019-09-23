<?PHP

// FILE INCLUDE VALIDATION
if (!$EmailAuth) { exit(); }
// -------------------------------------------------------------------------------------------------

$get_int = mysql_query("select id from idevaff_email_interval where aff = '$linkid'");
$get_int = mysql_num_rows($get_int);
if ($get_int) {
$time_now = time();
mysql_query("update idevaff_email_interval set wait = '$time_now' where aff = '$linkid'");
} else {
mysql_query("insert into idevaff_email_interval (aff, wait) VALUES ('$linkid', '$time_now')"); }

$m = stripslashes($_POST['body']);
$sub = stripslashes($_POST['subject']);
$f = stripslashes($_POST['footer']);

if ($link_style == 1) {
$email_friends_url = "$base_url/$filename.php?id=$linkid";
} elseif ($link_style == 2) {
$email_friends_url = "{$siteurl}{$linkid}" . ".html"; }

$smarty->assign('email_friends_url', $email_friends_url);

$email_data=mysql_query("select email, f_name, l_name from idevaff_affiliates where id = '$linkid'");
$email_place=mysql_fetch_array($email_data);
$affemail=$email_place['email'];
$f_name=$email_place['f_name'];
$l_name=$email_place['l_name'];

if ($transport == 1) {

$to = "$u <$e>";
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "From: $f_name $l_name <$affemail>\r\n";
$headers .= "Reply-To: $f_name $l_name <$affemail>\r\n";
$headers .= "Reply-Path: $f_name $l_name <$affemail>\r\n";
$content = "$m

$email_friends_url

$f";

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
$mail->From = "$affemail";
$mail->FromName = "$f_name $l_name";
$mail->AddAddress("$e","$u");
$mail->Body = "$m

$email_friends_url

$f";

$mail->Send();
$mail->ClearAddresses();
}

mysql_query("update idevaff_email_interval set stamp = '$time_now' where aff = '$linkid'");

?>