<?
## File Version -> v6.10
## Email File -> notify users that one or more of their auctions has been closed by the admin
## called from admin/list_auctions.php

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $db->query("SELECT a.auction_id, a.owner_id, u.name AS buyer_name, u.username, u.email, u.balance 
	FROM " . DB_PREFIX . "auctions a
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id 	
 	WHERE a.auction_id IN (" . $mail_input_id . ") 
 	GROUP BY a.owner_id");

$send = true; ## always send

while ($row_details = $db->fetch_array($sql_select_auctions))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
One or more auctions that you have placed on %2$s have been closed by the administrator.

Reason: 
%3$s.

Please contact us if you have any queries regarding this action.
	
Best regards,
The %2$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
One or more auctions that you have placed on %2$s have been closed by the administrator. <br>
<br>
Reason: <br>
%3$s. <br>
<br>
Please contact us if you have any queries regarding this action. <br>
<br>
Best regards, <br>
The %2$s staff';
	
	$close_reason = (empty($close_reason)) ? GMSG_NA : $close_reason;
	
	$text_message = sprintf($text_message, $row_details['buyer_name'], $setts['sitename'], $close_reason);
	$html_message = sprintf($html_message, $row_details['buyer_name'], $setts['sitename'], $close_reason);
	
	send_mail($row_details['email'], $setts['sitename'] . ' - Auction(s) Closed by Admin', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>