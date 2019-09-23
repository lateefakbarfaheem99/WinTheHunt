<?
## File Version -> v6.04
## Email File -> invoice users periodically if site is in account mode and 
## called only from the invoice_cron.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_users = $db->query("SELECT u.user_id, u.name AS buyer_name, u.username, u.email, u.balance FROM " . DB_PREFIX . "users u WHERE 
	u.balance>" . $setts['min_invoice_value']);

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($row_details = $db->fetch_array($sql_select_users))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
This is an invoice for clearing your account balance with our site, 
%2$s.

Your balance is: %3$s

Please click on the link below to access to the payment page:
	
%4$s
	
%5$s

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
%5$s <br>
<br>
Please note that you will have to login first. <br>
<br>
Best regards, <br>
The %2$s staff';
	
	
	$payment_link = SITE_PATH . 'login.php?redirect=' . process_link('fee_payment', array('do' => 'clear_balance'));
	$balance_amount = $fees->display_amount($row_details['balance'], $setts['currency']);

	$suspension_date_notice = null;
	if ($setts['suspension_date_days'] > 0)
	{
		$suspension_date = CURRENT_TIME + $setts['suspension_date_days'] * 24 * 60 * 60;
		$suspension_date_notice = 'Important: Your account will be suspended in ' . $setts['suspension_date_days']  . ' days if the balance isn\'t cleared.';
		
		$db->query("UPDATE " . DB_PREFIX . "users SET suspension_date='" . $suspension_date . "' WHERE user_id='" . $row_details['user_id'] . "'");
	}
	
	$text_message = sprintf($text_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link, $suspension_date_notice);
	$html_message = sprintf($html_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link, $suspension_date_notice);
	
	send_mail($row_details['email'], $setts['sitename'] . ' Invoice', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>