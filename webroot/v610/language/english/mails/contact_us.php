<?
## File Version -> v6.06
## Email File -> send contact form to site admin
## called only from the content_pages.php page!
## added reply-to path in v6.06

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$send = true; // always sent;

## text message - editable
$text_message = 'A new message has been sent from the contact us form.

User Details:

	- name: %1$s
	- email: %2$s
	- username (optional): %3$s
	
Question / Query:

%4$s';

## html message - editable
$html_message = 'A new message has been sent from the contact us form.<br>
<br>
User Details: <br>
<ul>
	<li>Name: <b>%1$s</b></li>
	<li>Email: <b>%2$s</b></li>
	<li>Username (optional): <b>%3$s</b></li>
</ul>
Question / Query:<br>
<br>
%4$s';


$text_message = sprintf($text_message, $user_details['name'], $user_details['email'], $user_details['username'], $user_details['question_content']);
$html_message = sprintf($html_message, $user_details['name'], $user_details['email'], $user_details['username'], $user_details['question_content']);

$email_subject = ($topic_id) ? 'Ref. Message #' . $topic_id . '; Username: ' . $user_details['username'] : $setts['sitename'] . ' - New Contact Message';

send_mail($setts['admin_email'], $email_subject, $text_message, 
	$setts['admin_email'], $html_message, null, $send, $user_details['email']);
?>