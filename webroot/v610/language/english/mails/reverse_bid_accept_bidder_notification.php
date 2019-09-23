<?

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$item_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "reverse_auctions WHERE reverse_id='" . $reverse_id . "'");
$user_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id='" . $bidder_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Dear %1$s,

The bid you have placed on %2$s has been accepted.

To view the details of the auction, please click on the URL below:
	
%3$s

Best regards,
The %4$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
The bid you have placed on <b>%2$s</b> has been accepted.. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page. <br>
<br>
Best regards, <br>
The %4$s staff';


$auction_link = process_link('reverse_details', array('name' => $item_details['name'], 'reverse_id' => $item_details['reverse_id']));

$text_message = sprintf($text_message, $user_details['name'], $item_details['name'], $auction_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $user_details['name'], $item_details['name'], $auction_link, $this->setts['sitename']);

send_mail($user_details['email'], 'Reverse Auction ID: ' . $bid_details['reverse_id'] . ' - Bid Accepted', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>