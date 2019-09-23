<?
## File Version -> v6.05
## Email File -> notify buyer on a successful purchase
## called only from the $item->assign_winner() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sale_details = $this->get_sql_row("SELECT w.*, u.name, u.username, u.email, u.mail_item_won, 
	a.name AS item_name, a.currency FROM " . DB_PREFIX . "winners w 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.buyer_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
	WHERE w.winner_id='" . $mail_input_id . "'");

$send = ($sale_details['mail_item_won']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

You have successfully purchased %2$s.

Purchase Details:

	- price: %3$s
	- quantity purchased: %4$s
	- auction url: %7$s
	
For more details about the purchase, please access the "Won Items" page, by clicking on the link below:  

%5$s

After you have accessed the page above, click on the "Message Board" link next to each item won.
This message board is your direct communication board with the seller. Please use this board to ask 
any post sale questions you might have.

Important: To help resolve any possible disputes ensure you use the board for all queries and updates.

Best regards,
The %6$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
You have successfully purchased %2$s. <br>
<br>
Purchase Details: <br>
<ul>
	<li>Price: <b>%3$s</b> </li>
	<li>Quantity Purchased: <b>%4$s</b> </li>
	<li>Auction URL: [ <a href="%7$s">Click to View</a> ] </li>
</ul>
For more details about the purchase, please access the [ <a href="%5$s">Won Items</a> ] page. <br>
<br>
After you have accessed the page above, click on the "Message Board" link next to each item won. <br>
This message board is your direct communication board with the seller. Please use this board to ask 
any post sale questions you might have. <br>
<br>
Important: To help resolve any possible disputes ensure you use the board for all queries and updates. <br>
<br>
Best regards, <br>
The %6$s staff';


$items_won_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'), true);
$auction_link = process_link('auction_details', array('name' => $sale_details['item_name'], 'auction_id' => $sale_details['auction_id']));

$this->fees = new fees();
$this->fees->setts = $this->setts;
$sale_price = $this->fees->display_amount($sale_details['bid_amount'], $sale_details['currency']);

$text_message = sprintf($text_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_won_link, $this->setts['sitename'], $auction_link);
$html_message = sprintf($html_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_won_link, $this->setts['sitename'], $auction_link);

send_mail($sale_details['email'], 'Auction ID: ' . $sale_details['auction_id'] . ' - Successful Purchase', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>