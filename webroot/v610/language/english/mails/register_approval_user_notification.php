<?
## File Version -> v6.07
## Email File -> registration approval - user notification
## called only from the register.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.user_id, u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE 
	u.user_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Dear %1$s,

Your account on %2$s has been successfully created. 

Your login details are:

	- username: %3$s
	- password: -hidden-

In order to verify your email address, please click on the activation link below:

%4$s

Your account will be manually activated by the site admin.
You will be notified by email once your account will become active.
	
Best regards,
The %2$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Your account on <b>%2$s</b> has been successfully created. <br>
<br>
Your login details are:<br>
<ul>
	<li>Username: <b>%3$s</b></li>
	<li>Password: -hidden-</li>
</ul>
Please [ <a href="%4$s">click here</a> ] in order to verify your email address. <br>
<br>
Your account will be manually activated by the site admin.<br>
You will be notified by email once your account will become active.<br>
<br>
Best regards, <br>
The %2$s staff';

$activation_link = SITE_PATH . 'account_activate.php?user_id=' . $row_details['user_id'] . '&username=' . $row_details['username'];

$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $row_details['username'], $activation_link);
$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $row_details['username'], $activation_link);

send_mail($row_details['email'], $setts['sitename'] . ' - Confirm Registration', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>