<?
## File Version -> v6.05
## Email File -> notify seller if multiple items closed but there was no sale
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed 
	FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

Several auctions that you have listed have closed without a winner.
This is either because there were no bids, or if your auctions had a reserve price, the reserve was not met.

To view the details of the auctions that have closed, please click on the URL below:

%2$s

Best regards,
The %3$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Several auctions that you have listed have closed without a winner. <br>
This is either because there were no bids, or if your auctions had a reserve price, the reserve was not met. <br>
<br>
[ <a href="%2$s">Click here</a> ] to view the details of the auctions that have closed. <br>
<br>
Best regards, <br>
The %3$s staff';


$items_closed_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'closed'), true);

$text_message = sprintf($text_message, $row_details['name'], $items_closed_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $items_closed_link, $setts['sitename']);

send_mail($row_details['email'], 'Multiple Auctions Closed', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>