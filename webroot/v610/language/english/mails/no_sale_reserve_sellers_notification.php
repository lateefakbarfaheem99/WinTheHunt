<?
## File Version -> v6.06
## Email File -> notify the seller when the auction was not sold due to the reserve price not being met
## called only from item::assign_winner()

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $this->query("SELECT a.auction_id, a.owner_id, a.name AS item_name,  
	u.name AS seller_name, u.username, u.email, u.mail_item_sold FROM " . DB_PREFIX . "bids b
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE b.auction_id='" . $mail_input_id . "' AND b.bid_out=0 AND b.bid_invalid=0 GROUP BY b.auction_id");


## send to the seller only
while ($row_details = $this->fetch_array($sql_select_auctions))
{
	$send = ($row_details['mail_item_sold']) ? true : false;
	## text message - editable
	$text_message = 'Dear %1$s,
	
The auction %2$s, which you have listed, has been closed.
No winner was assigned because the reserve price for the auction has not been met.
	
To view the details of the auction, please click on the URL below:
	
%3$s
	
To view the bid history for the auction, please click on the following link:
	
%4$s
	
Best regards,
The %5$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
The auction %2$s, which, has been closed. <br>
No winner was assigned because the reserve price for the auction has not been met. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page. <br>
<br>
To view the bid history for the auction, please [ <a href="%4$s">click here</a> ]. <br>
<br>
Best regards, <br>
The %5$s staff';
	
	
	$bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $row_details['auction_id']), true);
	$auction_link = process_link('auction_details', array('name' => $row_details['item_name'], 'auction_id' => $row_details['auction_id']));
	
	$text_message = sprintf($text_message, $row_details['seller_name'], $row_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);
	$html_message = sprintf($html_message, $row_details['seller_name'], $row_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);
	
	send_mail($row_details['email'], 'Auction ID: ' . $row_details['auction_id'] . ' - Auction Closed', $text_message, 
		$this->setts['admin_email'], $html_message, null, $send);
}
?>