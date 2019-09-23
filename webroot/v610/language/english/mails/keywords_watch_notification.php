<?
## File Version -> v6.05
## Email File -> notify user on keywords watch
## called only from the insert() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$keyword_search_string = $item_details['name'] . ' ' . $item_details['description'];

$sql_select_auctions = $this->query("SELECT kw.keyword, a.auction_id, a.name AS item_name,  
	u.name AS user_name, u.username, u.email FROM " . DB_PREFIX . "keywords_watch kw
	INNER JOIN " . DB_PREFIX . "auctions a ON a.auction_id='" . $mail_input_id . "'
	INNER JOIN " . DB_PREFIX . "users u ON u.user_id=kw.user_id WHERE 
	MATCH (kw.keyword) AGAINST ('" . $keyword_search_string . "')");


$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($watch_details = $this->fetch_array($sql_select_auctions))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
A new auction which matches one of your keywords from your keywords watch list has been placed.

Auction Title: %2$s.
	
To view the details of the auction, please click on the URL below:
	
%3$s
	
Best regards,
The %4$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
A new auction which matches one of your keywords from your keywords watch list has been placed.<br>
<br>
Auction Title: <b>%2$s</b><br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page. <br>
<br>
Best regards, <br>
The %4$s staff';
	
	
	$auction_link = process_link('auction_details', array('name' => $watch_details['item_name'], 'auction_id' => $watch_details['auction_id']));
	
	$text_message = sprintf($text_message, $watch_details['user_name'], $watch_details['item_name'], $auction_link, $this->setts['sitename']);
	$html_message = sprintf($html_message, $watch_details['user_name'], $watch_details['item_name'], $auction_link, $this->setts['sitename']);
	
	if (!empty($watch_details['email']))
	{
		send_mail($watch_details['email'], 'Keywords Watch - Keyword: ' . $watch_details['keyword'], $text_message, 	
			$this->setts['admin_email'], $html_message, null, $send);
	}
}
?>