<?
## File Version -> v6.06
## Email File -> notify user when a message is sent
## called only from the messaging() class!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

## will be called only from the messaging() class!
$msg_details = $this->get_sql_row("SELECT u.name, u.email, u.mail_messaging_sent FROM " . DB_PREFIX . "messaging m
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=m.sender_id WHERE 
	m.message_id='" . $mail_input_id . "'");

$send = ($msg_details['mail_messaging_sent']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

You have posted a new message using the site`s message board.

To view the messages you have sent click on the link below:

%2$s

Best regards,
The %3$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
You have posted a new message using the site`s message board. <br>
<br>
<a href="%2$s">Click here</a> to view your the messages you have sent. <br>
<br>
Best regards, <br>
The %3$s staff';

$msg_board_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'messaging', 'section' => 'sent'), true);

$text_message = sprintf($text_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);

send_mail($msg_details['email'], 'Message Sent - ' . $this->setts['sitename'], $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>