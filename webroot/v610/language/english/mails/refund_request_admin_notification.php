<?
## Email File -> refund request admin notification
## called only from $item->process_refund_request()!
## File Version -> v6.07

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$send = true; // always sent;

## text message - editable
$text_message = 'A new end of auction fee refund request has been made.

Please check the Admin Area -> Fees Management -> Refund Requests page for more details.';

## html message - editable
$html_message = 'A new end of auction fee refund request has been made.<br>
<br>
Please check the <b>Admin Area</b> -> <b>Fees Management</b> -> <b>Refund Requests</b> page for more details.';

send_mail($this->setts['admin_email'], 'End Of Auction Fee Refund Request', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>