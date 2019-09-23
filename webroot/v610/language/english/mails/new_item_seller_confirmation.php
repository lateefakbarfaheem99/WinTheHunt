<?
## File Version -> v6.07
## Email File -> confirm posting to the seller
## called only from the sell_item.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT a.*, u.name AS user_name, u.email, u.mail_confirm_to_seller FROM " . DB_PREFIX . "auctions a
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id WHERE a.auction_id='" . $mail_input_id . "'");

$send = ($row_details['mail_confirm_to_seller']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

You have posted the following auction on %2$s:

	- auction name: %3$s
	- auction type: %4$s
	- quantity offered: %5$s

	- category: %6$s
	- additional category: %7$s

	- start price: %8$s
	- buy out price: %9$s
	- reserve price: %10$s

	- closing date: %11$s
	
	- auction setup fees: %14$s

To view the auction details page, please click on the link below:

%12$s

Thank you for your submission.

Best regards,
The %13$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
You have posted the following auction on <b>%2$s</b>: <br>
<ul>
	<li>auction name: <b>%3$s</b> </li>
	<li>auction type: <b>%4$s</b> </li>
	<li>quantity offered: <b>%5$s</b> </li>
</ul>
<ul>
	<li>category: <b>%6$s</b> </li>
	<li>additional category: <b>%7$s</b> </li>
</ul>
<ul>
	<li>start price: <b>%8$s</b> </li>
	<li>buy out price: <b>%9$s</b> </li>
	<li>reserve price: <b>%10$s</b> </li>
</ul>
<ul>
	<li>closing date: <b>%11$s</b> </li>
</ul>
<ul>
	<li>auction setup fees: <b>%14$s</b> </li>
</ul>
[ <a href="%12$s">Click here</a> ] to view the auction details page. <br>
<br>
Thank you for your submission. <br>
<br>
Best regards, <br>
The %13$s staff';


$main_category = category_navigator($row_details['category_id'], false, true, null, null, GMSG_NONE_CAT);
$addl_category = category_navigator($row_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT);

$fees->display_free = false;
$start_price = $fees->display_amount($row_details['start_price'], $row_details['currency']);
$buyout_price = $fees->display_amount($row_details['buyout_price'], $row_details['currency']);
$reserve_price = $fees->display_amount($row_details['reserve_price'], $row_details['currency']);

$closing_date = show_date($row_details['end_time']);

$auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));

$fees->display_free = true;
$fees_mail = $fees->display_amount($fees_mail);

$text_message = sprintf($text_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], 
	$row_details['quantity'], $main_category, $addl_category, $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, 
	$setts['sitename'], $fees_mail);
	
$html_message = sprintf($html_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], 
	$row_details['quantity'], $main_category, $addl_category, $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, 
	$setts['sitename'], $fees_mail);
	
send_mail($row_details['email'], 'Auction Setup Confirmation', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>