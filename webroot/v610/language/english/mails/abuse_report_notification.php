<?
## Email File -> abuse report admin notification

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$abuse_details = $db->get_sql_row("SELECT a.*, u.username FROM " . DB_PREFIX . "abuses a 
	LEFT JOIN " . DB_PREFIX . "users u ON a.user_id=u.user_id
	WHERE a.abuse_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'A new abuse report was posted by %1$s regarding %2$s.

Abuse report comments: %3$s 

Please check the Admin Area -> User Management -> View Abuse Reports page for more details.';

## html message - editable
$html_message = 'A new abuse report was posted by <b>%1$s</b> regarding <b>%2$s</b>. <br>
<br>
Abuse report comments: %3$s <br>
<br>
Please check the <b>Admin Area</b> -> <b>User Management</b> -> <b>View Abuse Reports</b> page for more details.';


$text_message = sprintf($text_message, $abuse_details['username'], $abuse_details['abuser_username'], $abuse_details['comment']);
$html_message = sprintf($html_message, $abuse_details['username'], $abuse_details['abuser_username'], $abuse_details['comment']);

send_mail($setts['admin_email'], 'Abuse Report Notification - #' . $abuse_details['abuse_id'], $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>