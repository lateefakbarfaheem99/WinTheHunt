<?
## File Version -> v6.04
## Email File -> notify bidder when he is outbid
## called only from the bid.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $db->query("SELECT a.auction_id, a.name AS item_name,  
	u.name AS buyer_name, u.username, u.email, u.mail_outbid FROM " . DB_PREFIX . "bids b
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=b.bidder_id
	WHERE b.auction_id='" . $mail_input_id . "' AND b.bidder_id!='" . $mail_bidder_id . "' AND 
	b.bid_out=1 AND b.email_sent=0 GROUP BY bidder_id");

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($bid_details = $db->fetch_array($sql_select_auctions))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
You have been outbid on an auction you have placed a bid on, %2$s.
	
To view the details of the auction, please click on the URL below:
	
%3$s
	
To view the bid history for the auction, please click on the following link:
	
%4$s
	
Best regards,
The %5$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
You have been outbid on an auction you have placed a bid on, %2$s. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page. <br>
<br>
To view the bid history for the auction, please [ <a href="%4$s">click here</a> ]. <br>
<br>
Best regards, <br>
The %5$s staff';
	
	
	$bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $bid_details['auction_id']));
	$auction_link = process_link('auction_details', array('name' => $bid_details['item_name'], 'auction_id' => $bid_details['auction_id']));
	
	$text_message = sprintf($text_message, $bid_details['buyer_name'], $bid_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);
	$html_message = sprintf($html_message, $bid_details['buyer_name'], $bid_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);

	send_mail($bid_details['email'], 'Auction ID: ' . $bid_details['auction_id'] . ' - Outbid Notice', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>