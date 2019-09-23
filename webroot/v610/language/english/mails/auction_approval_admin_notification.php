<?
## Email File -> auction approval admin notification
## called only from $item->auction_approval()!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$send = true; // always sent;

## text message - editable
$text_message = 'An auction that requires admin approval has been posted/edited.

Please check the Admin Area -> Auctions Management -> Auctions Awaiting Approval page for more details.';

## html message - editable
$html_message = 'An auction that requires admin approval has been posted/edited. <br>
<br>
Please check the <b>Admin Area</b> -> <b>Auctions Management</b> -> <b>Auctions Awaiting Approval</b> page for more details.';

send_mail($this->setts['admin_email'], 'Auction Approval Request', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>