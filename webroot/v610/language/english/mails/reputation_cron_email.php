<?
## File Version -> v6.10
## Email File -> send users periodic notifications that they have pending reputation comments
## called only from the reputation_cron.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_users = $db->query("SELECT u.name, u.username, u.email, 
	count(r.reputation_id) AS nb_reputation
	FROM " . DB_PREFIX . "users u 
	LEFT JOIN " . DB_PREFIX . "reputation r ON r.from_id=u.user_id AND r.submitted=0
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=r.auction_id
	LEFT JOIN " . DB_PREFIX . "reverse_auctions rp ON rp.reverse_id=r.reverse_id
	WHERE u.active=1 AND u.approved=1 AND r.reputation_id IS NOT NULL AND 
	(a.auction_id IS NOT NULL OR rp.reverse_id IS NOT NULL)
	GROUP BY u.user_id");

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($row_details = $db->fetch_array($sql_select_users))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
You have not yet placed reputation comments on %2$s auctions you have taken part in on our site, %4$s. 

Please click on the link below to access the "Leave Comments" page:
	
%3$s
	
Please note that you will have to login first.
	
Best regards,
The %4$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s,<br>
<br>
You have not yet placed reputation comments on <b>%2$s</b> auctions you have taken part in on our site, <b>%4$s</b>. <br>
<br>
Please [ <a href="%3$s">click here</a> ] to access the "Leave Comments" page. <br>
<br>
Please note that you will have to login first. <br>
<br>
Best regards, <br>
The %4$s staff';
	
	
	$reputation_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'reputation', 'section' => 'sent'), true);
	
	$text_message = sprintf($text_message, $row_details['name'], $row_details['nb_reputation'], $reputation_link, $setts['sitename']);
	$html_message = sprintf($html_message, $row_details['name'], $row_details['nb_reputation'], $reputation_link, $setts['sitename']);
	
	send_mail($row_details['email'], $setts['sitename'] . ' - Pending Reputation Comments', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>