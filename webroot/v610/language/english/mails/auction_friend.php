<?
## Email File -> email an auction to a friend
## called only from the $item->auction_friend() function!
## File Version -> v6.10

if ( !defined('INCLUDED') ) { die("Access Denied"); }

//$sender_details = $this->get_sql_row("SELECT u.name, u.email FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $user_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Dear %1$s,

Your friend, %2$s, has forwarded an auction, posted on %3$s for you to look at.

To view the details of the auction, please click on the URL below:

%4$s

Additional comments: %5%s
Best regards,
The %6$s staff';

## html message - editable
$html_message = 'Dear %1$s, <br>
<br>
Your friend, %2$s, has forwarded an auction, posted on %3$s for you to look at. <br>
<br>
[ <a href="%4$s">Click here</a> ] to view the auction. <br>
<br>
Additional comments: %5$s <br>
<br>
Best regards, <br>
The %6$s staff';


$auction_link = process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));

$text_message = sprintf($text_message, $friend_name, $sender_name, $this->setts['sitename'], $auction_link, $comments, $this->setts['sitename']);
$html_message = sprintf($html_message, $friend_name, $sender_name, $this->setts['sitename'], $auction_link, $comments, $this->setts['sitename']);

send_mail($friend_email, 'Check out this Auction', $text_message, 
	$this->setts['admin_email'], $html_message, $sender_name, $send);
?>