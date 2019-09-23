<?
## File Version -> v6.10b
## Email File -> notify store owners that their subscription is about to expire.
## Called only from the main_cron.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$shop_expiration_date = intval($shop_expiration_date);
$shop_exp_date_days = intval($shop_exp_date_days);

$sql_select_users = $db->query("SELECT user_id, name, username, email FROM " . DB_PREFIX . "users u 
	WHERE shop_active=1 AND shop_account_id>0 AND 
	shop_next_payment>0 AND shop_next_payment<" . $shop_expiration_date . " AND store_expiration_email=0");

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($row_details = $db->fetch_array($sql_select_users))
{
	## text message - editable
	$text_message = 'Dear %1$s,
	
Your store subscription on %2$s will expire in %3$s days. 

Please click on the link below to renew your subscription:

%4$s

Please note that you will have to login first.

%5$s

Best regards,
The %2$s staff';
	
	## html message - editable
	$html_message = 'Dear %1$s,<br>
<br>
Your store subscription on <b>%2$s</b> will expire in %3$s days.<br>
<br>
Please [ <a href="%4$s">click here</a> ] to renew your subscription. <br>
<br>
Please note that you will have to login first. <br>
<br>
%5$s<br>
<br>
Best regards, <br>
The %2$s staff';
	
	$payment_link = SITE_PATH . 'login.php?redirect=' . process_link('fee_payment', array('do' => 'store_subscription_payment'));
	
	$user_payment_mode = $fees->user_payment_mode($row_details['user_id']);
	$account_mode_note = ($user_payment_mode == 2) ? 'Note: Your account will be billed automatically when the store subscription will expire.' : '';
	
	$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $shop_exp_date_days, $payment_link, $account_mode_note);
	$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $shop_exp_date_days, $payment_link, $account_mode_note);
	
	send_mail($row_details['email'], $setts['sitename'] . ' Store Expiration Notification', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
		
	$db->query("UPDATE " . DB_PREFIX . "users SET store_expiration_email=1 WHERE user_id='" . $row_details['user_id'] . "'");
}
?>