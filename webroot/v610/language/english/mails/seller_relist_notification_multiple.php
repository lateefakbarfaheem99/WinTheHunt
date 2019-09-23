<?
## File version -> v6.05
## Email File -> notify seller if multiple items have been relisted (manually or automatically)
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $db->query("SELECT u.name, u.username, u.email, u.mail_confirm_to_seller FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON a.owner_id=u.user_id WHERE 
	a.is_relisted_item=1 AND a.notif_item_relisted=0 GROUP BY a.owner_id");

while ($row_details = $db->fetch_array($sql_select_auctions))
{
	$send = ($row_details['mail_confirm_to_seller']) ? true : false;

	## text message - editable
	$text_message = 'Dear %1$s,

One or more auctions that you have listed on %2$s have been relisted.

To view the details of the auctions that have been relisted, please click on the URL below:

%3$s

Best regards,
The %2$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
One or more auctions that you have listed on %2$s have been relisted. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the details of the auctions that have been relisted. <br>
<br>
Best regards, <br>
The %2$s staff';


	$items_open_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'open'), true);
	
	$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $items_open_link);
	$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $items_open_link);
	
	send_mail($row_details['email'], 'Auction(s) Relisted', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>