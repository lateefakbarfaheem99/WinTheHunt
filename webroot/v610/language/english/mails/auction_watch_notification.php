<?
## File Version -> v6.05
## Email File -> notify user when a bid is placed on an auction on his watch list
## called only from the bid.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }
 
$sql_select_auctions = $db->query("SELECT a.auction_id, a.name AS item_name,  
	u.name AS buyer_name, u.username, u.email FROM " . DB_PREFIX . "auction_watch aw
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=aw.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=aw.user_id
	WHERE aw.auction_id='" . $mail_input_id . "'");

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($watch_details = $db->fetch_array($sql_select_auctions))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
A new bid has been placed on an auction from your watch list, %2$s.
	
To view the details of the auction, please click on the URL below:
	
%3$s
	
To view the bid history for the auction, please click on the following link:
	
%4$s
	
Best regards,
The %5$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
A new bid has been placed on an auction from your watch list, %2$s. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page. <br>
<br>
To view the bid history for the auction, please [ <a href="%4$s">click here</a> ]. <br>
<br>
Best regards, <br>
The %5$s staff';
	
	
	$bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $watch_details['auction_id']));
	$auction_link = process_link('auction_details', array('name' => $watch_details['item_name'], 'auction_id' => $watch_details['auction_id']));
	
	$text_message = sprintf($text_message, $watch_details['buyer_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);
	$html_message = sprintf($html_message, $watch_details['buyer_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);
	
	send_mail($watch_details['email'], 'Auction ID: ' . $watch_details['auction_id'] . ' - Item Watch', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>