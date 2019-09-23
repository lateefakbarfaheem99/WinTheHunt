<?
## File Version -> v6.05
## Email File -> notify seller on a new offer placed 
## called only from the $item->place_offer() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$offer_details = $this->get_sql_row("SELECT o.*, u.name, u.username, u.email, a.name AS item_name, a.currency FROM " . DB_PREFIX . "auction_offers o 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=o.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=o.auction_id
	WHERE o.offer_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Dear %1$s,

A new offer has been made on your auction, %2$s.

Offer Details:

	- price: %3$s
	- quantity requested: %4$s
	
To view all the offers that are currently active for this auction, please click the link below:

%5$s

Best regards,
The %6$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
A new offer has been made on your auction, %2$s. <br>
<br>
Offer Details: <br>
<ul>
	<li>Price: <b>%3$s</b> </li>
	<li>Quantity Requested: <b>%4$s</b> </li>
</ul>
<br>
[ <a href="%5$s">Click here</a> ] to view all the offers that are currently active for this auction. <br>
<br>
Best regards, <br>
The %6$s staff';


$offer_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'view_offers', 'auction_id' => $offer_details['auction_id']), true);

$this->fees = new fees();
$this->fees->setts = $this->setts;
$offer_price = $this->fees->display_amount($offer_details['amount'], $offer_details['currency']);

$text_message = sprintf($text_message, $offer_details['name'], $offer_details['item_name'], $offer_price, $offer_details['quantity'], $offer_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $offer_details['name'], $offer_details['item_name'], $offer_price, $offer_details['quantity'], $offer_link, $this->setts['sitename']);

send_mail($offer_details['email'], 'Auction ID: ' . $offer_details['auction_id'] . ' - New Offer Placed', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>