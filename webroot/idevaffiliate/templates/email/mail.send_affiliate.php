<?PHP

// FILE INCLUDE VALIDATION
if (!$EmailAuth) { exit(); }
// -------------------------------------------------------------------------------------------------

if ($transport == 1) {

$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "From: $from_name <$address>\r\n";
$headers .= "Reply-To: $from_name <$address>\r\n";
$headers .= "Reply-Path: $from_name <$address>\r\n";

$sub = stripslashes($_POST['subject']);

$get_user=mysql_query("select id, username, password, email, f_name, l_name from idevaff_affiliates where id = '{$_POST['id']}'");
$get_details = mysql_fetch_array($get_user);

$swi = $get_details['id'];
$swu = $get_details['username'];
$swf = $get_details['f_name'];
$swl = $get_details['l_name'];
$swp = $get_details['password'];

$e = $get_details['email'];
$to = "$u <$e>";
$message = stripslashes($_POST['message']);
$message = preg_replace("/_id_/", "$swi", $message);
$message = preg_replace("/_username_/", "$swu", $message);
$message = preg_replace("/_password_/", "$swp", $message);
$message = preg_replace("/_firstname_/", "$swf", $message);
$message = preg_replace("/_lastname_/", "$swl", $message);
$message = preg_replace("/_email_/", "$e", $message);
$message = preg_replace("/_webhome_/", "$siteurl", $message);
$message = preg_replace("/_affhome_/", "$base_url/index.php", $message);
$message = preg_replace("/_loginpage_/", "$base_url/login.php", $message);
if ($link_style == 1) {
$message = preg_replace("/_afflink_/", "$base_url/$filename.php?id=$swi", $message);
} elseif ($link_style == 2) {
$message = preg_replace("/_afflink_/", "$siteurl{$swi}.html", $message); }

$content = "$message

$signature";

mail($to,$sub,$content,$headers);

} else {

$sub = stripslashes($_POST['subject']);

$get_user=mysql_query("select id, username, password, email, f_name, l_name from idevaff_affiliates where id = '{$_POST['id']}'");
$get_details = mysql_fetch_array($get_user);

$swi = $get_details['id'];
$swu = $get_details['username'];
$swf = $get_details['f_name'];
$swl = $get_details['l_name'];
$swp = $get_details['password'];

$e = $get_details['email'];
$to = "$swu <$e>";
$message = stripslashes($_POST['message']);
$message = preg_replace("/_id_/", "$swi", $message);
$message = preg_replace("/_username_/", "$swu", $message);
$message = preg_replace("/_password_/", "$swp", $message);
$message = preg_replace("/_firstname_/", "$swf", $message);
$message = preg_replace("/_lastname_/", "$swl", $message);
$message = preg_replace("/_email_/", "$e", $message);
$message = preg_replace("/_webhome_/", "$siteurl", $message);
$message = preg_replace("/_affhome_/", "$base_url/index.php", $message);
$message = preg_replace("/_loginpage_/", "$base_url/login.php", $message);
if ($link_style == 1) {
$message = preg_replace("/_afflink_/", "$base_url/$filename.php?id=$swi", $message);
} elseif ($link_style == 2) {
$message = preg_replace("/_afflink_/", "$siteurl{$swi}.html", $message); }

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
$mail->FromName = "$from_name";
$mail->AddAddress("$e","$swu");
$mail->Body = "$message

$signature";

$mail->Send();
$mail->ClearAddresses();
}

?>