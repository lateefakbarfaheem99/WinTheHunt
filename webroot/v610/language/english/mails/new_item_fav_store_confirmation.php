<?
## File Version -> v6.02
## Email File -> confirm posting to the seller
## called only from the sell_item.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_fav_stores = $db->query("SELECT a.*, u.name AS user_name, u.email FROM " . DB_PREFIX . "favourite_stores fs,
	" . DB_PREFIX . "auctions a, " . DB_PREFIX . "users u WHERE 
	a.auction_id='" . $mail_input_id . "' AND a.owner_id=fs.store_id AND u.user_id=fs.user_id" );

$send = true; // always sent

while ($row_details = $db->fetch_array($sql_select_fav_stores))
{
	## text message - editable
	$text_message = 'Dear %1$s,

A new auction has been posted on one of your favorite stores:

	- auction name: %3$s
	- auction type: %4$s
	- quantity offered: %5$s

	- start price: %6$s
	- buy out price: %7$s
	- reserve price: %8$s

	- closing date: %9$s

To view the auction details page, please click on the link below:

%10$s

Best regards,
The %11$s staff';

	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
A new auction has been posted on one of your favorite stores: <br>
<ul>
	<li>auction name: <b>%3$s</b> </li>
	<li>auction type: <b>%4$s</b> </li>
	<li>quantity offered: <b>%5$s</b> </li>
</ul>
<ul>
	<li>start price: <b>%6$s</b> </li>
	<li>buy out price: <b>%7$s</b> </li>
	<li>reserve price: <b>%8$s</b> </li>
</ul>
<ul>
	<li>closing date: <b>%9$s</b> </li>
</ul>
[ <a href="%10$s">Click here</a> ] to view the auction details page. <br>
<br>
Best regards, <br>
The %11$s staff';

   
   $fees->display_free = false;

	$start_price = $fees->display_amount($row_details['start_price'], $row_details['currency']);
	$buyout_price = $fees->display_amount($row_details['buyout_price'], $row_details['currency']);
	$reserve_price = $fees->display_amount($row_details['reserve_price'], $row_details['currency']);
   $fees->display_free = true;

	$closing_date = show_date($row_details['end_time']);

	$auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));


	$text_message = sprintf($text_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], 
		$row_details['quantity'], $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, 
		$setts['sitename']);
	
	$html_message = sprintf($html_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], 
		$row_details['quantity'], $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, 
		$setts['sitename']);
	
	send_mail($row_details['email'], 'Favorite Store - New Auction Posted', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>