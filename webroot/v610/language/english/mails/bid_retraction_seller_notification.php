<?
## File Version -> v6.06
## Email File -> notify seller that a bidder has retracted his bids on an auction
## called only from the item->retract_bid() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$bid_details = $this->get_sql_row("SELECT a.auction_id, a.name, u.name AS user_name, u.email FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id WHERE 
	a.auction_id='" . $auction_id . "'");

$send = true;

## text message - editable
$text_message = 'Dear %1$s,
	
A user has retracted all his bids on one of your auctions, %2$s.
	
To view the auction details page, please click on the link below:
	
%3$s
	
To view the bids history page, please click on the link below:
	
%4$s
		
Best regards,
The %5$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
A user has retracted all his bids on one of your auctions, %2$s. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page. <br>
[ <a href="%4$s">Click here</a> ] to view the bids history page for the auction. <br>
<br>
Best regards, <br>
The %5$s staff';


$auction_link = process_link('auction_details', array('auction_id' => $bid_details['auction_id']));
$bids_link = process_link('bid_history', array('auction_id' => $bid_details['auction_id']));

$text_message = sprintf($text_message, $bid_details['user_name'], $bid_details['name'], $auction_link, $bids_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $bid_details['user_name'], $bid_details['name'], $auction_link, $bids_link, $this->setts['sitename']);

send_mail($bid_details['email'], 'Auction ID: ' . $bid_details['auction_id'] . ' - Bid(s) Retracted', $text_message,
	$this->setts['admin_email'], $html_message, null, $send);
?>