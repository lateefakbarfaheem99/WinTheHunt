<?
## File Version -> v6.02
## Email File -> notify seller when a bid is placed
## called only from the bid.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$bid_details = $db->get_sql_row("SELECT a.*, u.name AS seller_name, u.username, u.email, u.default_bid_placed_email 
	FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.auction_id='" . $mail_input_id . "'");

$send = ($bid_details['default_bid_placed_email']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

A new bid has been placed on one of your auctions, %2$s.

To view the auction details page, please click on the link below:

%3$s
	
Best regards,
The %4$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
A new bid has been placed on one of your auctions, %2$s. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page. <br>
<br>
Best regards, <br>
The %4$s staff';


$auction_link = process_link('auction_details', array('name' => $bid_details['name'], 'auction_id' => $bid_details['auction_id']));

$text_message = sprintf($text_message, $bid_details['seller_name'], $bid_details['name'], $auction_link, $setts['sitename']);
$html_message = sprintf($html_message, $bid_details['seller_name'], $bid_details['name'], $auction_link, $setts['sitename']);

send_mail($bid_details['email'], 'Auction ID: ' . $bid_details['auction_id'] . ' - New Bid Placed', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>