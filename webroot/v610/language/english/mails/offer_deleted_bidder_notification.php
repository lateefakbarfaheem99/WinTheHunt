<?
## Email File -> notify bidder if his offer is deleted (works with all 3 offer types)
## called only from the $item->delete_offer() function!
## File Version -> 6.10

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$bidder_row = ($offer_table == 'bids') ? 'bidder_id' : 'buyer_id';

$row_details = $this->get_sql_row("SELECT a.*, u.name AS user_name, u.email FROM 
	" . DB_PREFIX . $offer_table . " o
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=o.auction_id 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=o." . $bidder_row . " WHERE
	o." . $offer_id_name . "='" . $offer_id . "' AND a.owner_id='" . $user_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Dear %1$s,

The %2$s offer has that you have made on %3$s has been declined by the seller.

Declination reason:

%6$s

To view the details of the auction, please click on the URL below:
	
%4$s

Best regards,
The %5$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
The %2$s offer has that you have made on %3$s has been declined by the seller. <br>
<br>
<b>Declination reason</b>: <br>
%6$s <br>
<br>
[ <a href="%4$s">Click here</a> ] to view the auction details page. <br>
<br>
Best regards, <br>
The %5$s staff';


$offer_type = ($offer_table == 'bids') ? 'reserve' : 'fixed price';
$offer_type = ($offer_table == 'swaps') ? 'swap' : $offer_type;

$auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));
$decline_reason = field_display($decline_reason, GMSG_NA, nl2br($decline_reason));

$text_message = sprintf($text_message, $row_details['user_name'], $offer_type, $row_details['name'], $auction_link, $this->setts['sitename'], $decline_reason);
$html_message = sprintf($html_message, $row_details['user_name'], $offer_type, $row_details['name'], $auction_link, $this->setts['sitename'], $decline_reason);

send_mail($row_details['email'], 'Auction ID: ' . $offer_details['auction_id'] . ' - Offer Rejected', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>