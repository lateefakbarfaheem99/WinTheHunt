<?
## File Version -> v6.05
## Email File -> notify seller on a new swap offer placed 
## called only from the $item->place_offer() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$offer_details = $this->get_sql_row("SELECT s.*, u.name, u.username, u.email, a.name AS item_name, a.currency FROM " . DB_PREFIX . "swaps s 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=s.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=s.auction_id
	WHERE s.swap_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Dear %1$s,

A new swap offer has been made on your auction, %2$s.

Offer Details:

	- quantity requested: %3$s
	
	- item offered in exchange: %4$s
	
To view all the offers that are currently active for this auction, please click the link below:

%5$s

Best regards,
The %6$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
A new swap offer has been made on your auction, %2$s. <br>
<br>
Offer Details: <br>
<ul>
	<li>Quantity Requested: <b>%3$s</b> </li>
	<li>Item Offered in Exchange: %4$s </li>
</ul>
<br>
[ <a href="%5$s">Click here</a> ] to view all the offers that are currently active for this auction. <br>
<br>
Best regards, <br>
The %6$s staff';


$offer_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'view_offers', 'auction_id' => $offer_details['auction_id']), true);

$text_message = sprintf($text_message, $offer_details['name'], $offer_details['item_name'], $offer_details['quantity'], $offer_details['description'], $offer_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $offer_details['name'], $offer_details['item_name'], $offer_details['quantity'], $offer_details['description'], $offer_link, $this->setts['sitename']);

send_mail($offer_details['email'], 'Auction ID: ' . $offer_details['auction_id'] . ' - New Swap Offer Placed', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>