<?
## Email File -> notify seller if an item closed but there was no sale
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed, 
	a.name AS item_name, a.currency, a.auction_id FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.auction_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

Your auction, %2$s, has closed without a winner.
This is either because there were no bids, or if you had a reserve price, the reserve was not met.

To view the details of the auction, please click on the URL below:

%3$s

Best regards,
The %4$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Your auction, %2$s, has closed without a winner. <br>
This is either because there were no bids, or if you had a reserve price, the reserve was not met. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction. <br>
<br>
Best regards, <br>
The %4$s staff';


$auction_link = process_link('auction_details', array('name' => $row_details['item_name'], 'auction_id' => $row_details['auction_id']));

$text_message = sprintf($text_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);

send_mail($row_details['email'], 'Auction ID: ' . $row_details['auction_id'] . ' - Auction Closed', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>