<?
## File Version -> v6.04
## Email File -> notify remaining bidders that a user has retracted his bids on an auction
## called only from the item->retract_bid() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_bids = $this->query("SELECT b.auction_id, a.name, u.name AS user_name, u.email FROM " . DB_PREFIX . "bids b 
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=b.bidder_id WHERE 
	b.auction_id='" . $auction_id . "' AND b.bid_invalid=0 GROUP BY b.bidder_id");

$send = true;

while ($bid_details = $this->fetch_array($sql_select_bids))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
	A user has retracted all his bids on an auction you have also placed bids, %2$s.
	
	To view the auction details page, please click on the link below:
	
	%3$s
	
	To view the bids history page, please click on the link below:
	
	%4$s
		
	Best regards,
	The %5$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
	<br>
	A user has retracted all his bids on an auction you have also placed bids, %2$s. <br>
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
}
?>