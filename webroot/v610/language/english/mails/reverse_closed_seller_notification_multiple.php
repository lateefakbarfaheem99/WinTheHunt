<?
## File Version -> v6.06
## Email File -> notify seller if multiple reverse auctions have closed
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed 
	FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

Several reverse auctions that you have listed have closed.

To view the details of the reverse auctions that have closed, please click on the URL below:

%2$s

Best regards,
The %3$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Several reverse auctions that you have listed have closed. <br>
<br>
[ <a href="%2$s">Click here</a> ] to view the details of the reverse auctions that have closed. <br>
<br>
Best regards, <br>
The %3$s staff';


$items_closed_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'reverse', 'section' => 'closed'), true);

$text_message = sprintf($text_message, $row_details['name'], $items_closed_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $items_closed_link, $setts['sitename']);

send_mail($row_details['email'], 'Multiple Reverse Auctions Closed', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>