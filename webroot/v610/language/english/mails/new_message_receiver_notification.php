<?
## File Version -> v6.05
## Email File -> notify user when a message is received
## called only from the messaging() class!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

## will be called only from the messaging() class!
$msg_details = $this->get_sql_row("SELECT u.name, u.email, u.mail_messaging_received FROM " . DB_PREFIX . "messaging m
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=m.receiver_id WHERE 
	m.message_id='" . $mail_input_id . "'");

$send = ($msg_details['mail_messaging_received']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

There is a new message in your message board.

To view your received messages board click on the link below:

%2$s

Best regards,
The %3$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
There is a new message in your message board. <br>
<br>
<a href="%2$s">Click here</a> to view your received messages board. <br>
<br>
Best regards, <br>
The %3$s staff';

$msg_board_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'messaging', 'section' => 'received'), true);

$text_message = sprintf($text_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);

send_mail($msg_details['email'], 'Message Received - ' . $setts['sitename'], $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>