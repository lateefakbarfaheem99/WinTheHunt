<?
## File Version -> v6.05
## Email File -> notify seller on a successful sale
## called only from the $item->assign_winner() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sale_details = $this->get_sql_row("SELECT w.*, u.name, u.username, u.email, u.mail_item_sold, 
	a.name AS item_name, a.currency FROM " . DB_PREFIX . "winners w 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
	WHERE w.winner_id='" . $mail_input_id . "'");

$send = ($sale_details['mail_item_sold']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

Your auction, %2$s, has been successfully sold.

Sale Details:

	- price: %3$s
	- quantity sold: %4$s
	- auction url: %7$s
	
For more details about the sale, please access the "Sold Items" page, by clicking on the link below:  

%5$s

After you have accessed the page above, click on the "Message Board" link next to each item sold.
This message board is your direct communication board with your buyer. Please use this board to answer 
any questions the buyer may have regarding payment and delivery.

Important: To help resolve any possible disputes ensure you use the board for all queries and updates.

Best regards,
The %6$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Your auction, %2$s, has been successfully sold. <br>
<br>
Sale Details: <br>
<ul>
	<li>Price: <b>%3$s</b> </li>
	<li>Quantity Sold: <b>%4$s</b> </li>
	<li>Auction URL: [ <a href="%7$s">Click to View</a> ] </li>
</ul>
For more details about the sale, please access the [ <a href="%5$s">Sold Items</a> ] page. <br>
<br>
After you have accessed the page above, click on the "Message Board" link next to each item sold. <br>
This message board is your direct communication board with your buyer. Please use this board to answer 
any questions the buyer may have regarding payment and delivery. <br>
<br>
Important: To help resolve any possible disputes ensure you use the board for all queries and updates. <br>
<br>
Best regards, <br>
The %6$s staff';


$items_sold_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'sold'), true);
$auction_link = process_link('auction_details', array('name' => $sale_details['item_name'], 'auction_id' => $sale_details['auction_id']));

$this->fees = new fees();
$this->fees->setts = $this->setts;
$sale_price = $this->fees->display_amount($sale_details['bid_amount'], $sale_details['currency']);

$text_message = sprintf($text_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_sold_link, $this->setts['sitename'], $auction_link);
$html_message = sprintf($html_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_sold_link, $this->setts['sitename'], $auction_link);

send_mail($sale_details['email'], 'Auction ID: ' . $sale_details['auction_id'] . ' - Successful Sale', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>