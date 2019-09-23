<?
## File Version -> v6.05
## Email File -> notify buyer when the seller has posted bank details for an auction
## called only from the popup_bank_details.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $db->query("SELECT a.auction_id, a.name AS item_name, a.bank_details, 
	u.name AS buyer_name, u.username, u.email FROM " . DB_PREFIX . "winners w
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.buyer_id
	WHERE w.auction_id='" . $mail_input_id . "'");

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($bank_details = $db->fetch_array($sql_select_auctions))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
The seller of the auction %2$s, which you have won, has posted/changed his bank details.
	
The bank details are:
	
%3$s
	
For more details about the purchase, please access the "Won Items" page, by clicking on the link below:  
	
%4$s
	
After you have accessed the page above, click on the "View Bank Details" link next to the item won.
	
Best regards,
The %5$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
The seller of the auction <b>%2$s</b>, which you have won, has posted/changed his bank details. <br>
<br>
The bank details are: <br>
<ul>
	<li>%3$s </li>
</ul>
<br>
For more details about the purchase, please access the [ <a href="%4$s">Won Items</a> ] page. <br>
<br>
After you have accessed the page above, click on the "View Bank Details" link next to the item won. <br>
<br>
Best regards, <br>
The %5$s staff';
	
	
	$items_won_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'), true);
	//$auction_link = process_link('auction_details', array('name' => $bank_details['item_name'], 'auction_id' => $bank_details['auction_id']));
	
	$text_message = sprintf($text_message, $bank_details['buyer_name'], $bank_details['item_name'], $bank_details['bank_details'], $items_won_link, $setts['sitename']);
	$html_message = sprintf($html_message, $bank_details['buyer_name'], $bank_details['item_name'], $bank_details['bank_details'], $items_won_link, $setts['sitename']);
	
	send_mail($bank_details['email'], 'Auction ID: ' . $bank_details['auction_id'] . ' - Bank Details Posted', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>