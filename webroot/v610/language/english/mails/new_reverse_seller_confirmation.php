<?
## Email File -> confirm posting to the seller
## called only from the reverse_manage.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT a.*, u.name AS user_name, u.email, u.mail_confirm_to_seller FROM " . DB_PREFIX . "reverse_auctions a
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id WHERE a.reverse_id='" . $mail_input_id . "'");

$send = ($row_details['mail_confirm_to_seller']) ? true : false;

## text message - editable
$text_message = 'Dear %1$s,

You have posted the following reverse auction on %2$s:

	- auction name: %3$s

	- category: %4$s
	- additional category: %5$s

	- budget: %6$s

	- closing date: %7$s

To view the auction details page, please click on the link below:

%8$s

Thank you for your submission.

Best regards,
The %9$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
You have posted the following reverse auction on <b>%2$s</b>: <br>
<ul>
	<li>auction name: <b>%3$s</b> </li>
</ul>
<ul>
	<li>category: <b>%4$s</b> </li>
	<li>additional category: <b>%5$s</b> </li>
</ul>
<ul>
	<li>budget: <b>%6$s</b> </li>
</ul>
<ul>
	<li>closing date: <b>%7$s</b> </li>
</ul>
[ <a href="%8$s">Click here</a> ] to view the auction details page. <br>
<br>
Thank you for your submission. <br>
<br>
Best regards, <br>
The %9$s staff';


$main_category = category_navigator($row_details['category_id'], false, true, null, null, GMSG_NONE_CAT, true);
$addl_category = category_navigator($row_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT, true);

$budget = $fees->budget_output($row_details['budget_id'], null, $row_details['currency']);

$closing_date = show_date($row_details['end_time']);

$auction_link = process_link('reverse_details', array('name' => $row_details['name'], 'reverse_id' => $row_details['reverse_id']));


$text_message = sprintf($text_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], 
	$main_category, $addl_category, $budget, $closing_date, $auction_link, $setts['sitename']);
	
$html_message = sprintf($html_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], 
	$main_category, $addl_category, $budget, $closing_date, $auction_link, $setts['sitename']);
	
send_mail($row_details['email'], 'Reverse Auction Setup Confirmation', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>