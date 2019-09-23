<?
## Email File -> notify seller if an wanted ad has closed
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed, 
	r.name AS item_name, r.reverse_id FROM " . DB_PREFIX . "reverse_auctions r
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=r.owner_id
	WHERE r.reverse_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

Your reverse auction, %2$s, has closed.

To view the details of the reverse auction, please click on the URL below:

%3$s

Best regards,
The %4$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Your reverse auction, %2$s, has closed. <br>
[ <a href="%3$s">Click here</a> ] to view the reverse auction details page. <br>
<br>
Best regards, <br>
The %4$s staff';


$auction_link = process_link('reverse_details', array('reverse_id' => $row_details['reverse_id']));

$text_message = sprintf($text_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);

send_mail($row_details['email'], 'Reverse Auction ID: ' . $row_details['reverse_id'] . ' - Closed', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>