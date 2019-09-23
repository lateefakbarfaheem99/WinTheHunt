<?
## Email File -> retrieve username
## called only from the retrieve_password.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.username, u.email FROM " . DB_PREFIX . "users u WHERE u.email='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Dear subscriber,

Your username to %1$s is: %2$s

Best regards,
The %1$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Your username to %1$s is: <b>%2$s</b> <br>
<br>
Best regards, <br>
The %1$s staff';


$text_message = sprintf($text_message, $setts['sitename'], $row_details['username']);
$html_message = sprintf($html_message, $setts['sitename'], $row_details['username']);

send_mail($row_details['email'], $setts['sitename'] . ' - Username Recovery', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>