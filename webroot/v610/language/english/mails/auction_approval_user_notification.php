<?
## File Version -> v6.02
## Email File -> notify user when his auction is approved by the admin
## called only from admin/list_auctions.php

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT a.*, u.name AS user_name, u.username, u.email FROM " . DB_PREFIX . "auctions a
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.auction_id='" . $mail_input_id . "'");

$send = true; ## always sent

## text message - editable
$text_message = 'Dear %1$s,

Your auction, %2$s, has been successfully approved.

To view the details of the auction, please click on the URL below:
	
%3$s

Best regards,
The %4$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Your auction, %2$s, has been successfully approved. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page.  <br>
<br>
Best regards, <br>
The %4$s staff';


$auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));

$text_message = sprintf($text_message, $row_details['user_name'], $row_details['name'], $auction_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['user_name'], $row_details['name'], $auction_link, $setts['sitename']);

send_mail($row_details['email'], 'Auction ID: ' . $row_details['auction_id'] . ' - Approval Successful', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>