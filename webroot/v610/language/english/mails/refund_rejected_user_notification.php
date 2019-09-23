<?
## File Version -> v6.07
## Email File -> notify user when a refund has been accepted
## called only from the $item->process_refund_request() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$send = true;

## text message - editable
$text_message = 'Dear %1$s,

The end of auction fee refund request for:

	- Auction ID: %2$s
	- Invoice ID: %3$s 
	- Amount: %4$s
	
has been rejected by the administrator.

Best regards,
The %5$s staff';

## html message - editable
$html_message = 'Dear %1$s,<br>
<br>
The end of auction fee refund request for:<br>
<ul>
	<li>Auction ID: <b>%2$s</b></li>
	<li>Invoice ID: <b>%3$s</b></li>
	<li>Amount: <b>%4$s</b></li>
</ul>	
has been rejected by the administrator.<br>
<br>
Best regards,<br>
The %5$s staff';

$amount = $this->fees->display_amount($invoice_details['amount']);

$text_message = sprintf($text_message, $user_details['name'], $invoice_details['item_id'], $invoice_details['invoice_id'], $amount, $this->setts['sitename']);
$html_message = sprintf($html_message, $user_details['name'], $invoice_details['item_id'], $invoice_details['invoice_id'], $amount, $this->setts['sitename']);

send_mail($user_details['email'], 'Refund Request Rejected - ' . $setts['sitename'], $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>