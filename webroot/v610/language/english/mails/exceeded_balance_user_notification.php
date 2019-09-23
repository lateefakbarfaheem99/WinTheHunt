<?
## Email File -> notify user that his account has been suspended because the debit limit was exceeded.
## called only from the suspend_debit_users() function

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name AS buyer_name, u.username, u.email, u.balance FROM " . DB_PREFIX . "users u WHERE
	u.user_id=" . $mail_input_id);

$send = true; ## always send

## text message - editable
$text_message = 'Dear %1$s,
	
Your account on %2$s has been suspended because you have exceeded the maximum debit limit allowed.

Your balance is: %3$s

In order to reactivate your account, you will need to clear your account balance. 
Please click on the link below to access to the payment page:
	
%4$s
	
Please note that you will have to login first.
	
Best regards,
The %2$s staff';

## html message - editable
$html_message = 'Dear %1$s,<br>
<br>
Your account on %2$s has been suspended because you have exceeded the maximum debit limit allowed.<br>
<br>
Your balance is: <b>%3$s</b> <br>
<br>
In order to reactivate your account, you will need to clear your account balance. <br>
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

send_mail($row_details['email'], $setts['sitename'] . ' - Account Suspended', $text_message,
	$setts['admin_email'], $html_message, null, $send);
?>