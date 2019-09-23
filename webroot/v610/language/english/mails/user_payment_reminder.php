<?
## File Version -> v6.02
## Email File -> invoice users periodically if site is in account mode and 
## called only from the invoice_cron.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name AS buyer_name, u.username, u.email, u.balance FROM " . DB_PREFIX . "users u WHERE 
	u.user_id='" . $mail_input_id . "'");

$send = true; ## always send

## text message - editable
$text_message = 'Dear %1$s,
	
This is an invoice for clearing your account balance with our site, 
%2$s.

Your balance is: %3$s

Please click on the link below to access to the payment page:
	
%4$s
	
Please note that you will have to login first.
	
Best regards,
The %2$s staff';
	
## html message - editable
$html_message = 'Dear %1$s,<br>
<br>
This is an invoice for clearing your account balance with our site, <br>
%2$s.<br>
<br>
Your balance is: <b>%3$s</b> <br>
<br>
Please [ <a href="%4$s">click here</a> ] to access the payment page. <br>
<br>
Please note that you will have to login first. <br>
<br>
Best regards, <br>
The %2$s staff';
	
	
$payment_link = SITE_PATH . 'login.php?redirect=' . process_link('fee_payment', array('do' => 'clear_balance'));
$balance_amount = $fees->display_amount($row_details['balance'], $setts['currency']);
	
$text_message = sprintf($text_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);
$html_message = sprintf($html_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);
	
send_mail($row_details['email'], $setts['sitename'] . ' Invoice', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>