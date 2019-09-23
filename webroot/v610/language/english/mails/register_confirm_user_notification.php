<?
## File Version -> v6.04
## Email File -> registration confirmation message
## called only from the register.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

if ($mail_input_id)
{
	$row_details = $db->get_sql_row("SELECT u.user_id, u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE 
		u.user_id='" . $mail_input_id . "'");
}
## otherwise row_details is provided from the file calling this email

$send = true; // always sent;

## text message - editable
$text_message = 'Dear %1$s,

Your account on %2$s has been successfully created.

Your login details are:

	- username: %3$s
	- password: -hidden-

In order to activate your account, please click on the activation link below:

%4$s
	
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
Please [ <a href="%4$s">click here</a> ] in order to activate your account. <br>
<br>
Best regards, <br>
The %2$s staff';


$activation_link = SITE_PATH . 'account_activate.php?user_id=' . $row_details['user_id'] . '&username=' . $row_details['username'];

$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $row_details['username'], $activation_link);
$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $row_details['username'], $activation_link);

send_mail($row_details['email'], $setts['sitename'] . ' - Confirm Registration', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>