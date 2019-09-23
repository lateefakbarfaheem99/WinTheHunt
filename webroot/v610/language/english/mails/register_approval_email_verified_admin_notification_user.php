<?
## Email File -> registration approval - admin notification step 2
## called only from the account_activate.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.user_id, u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE 
	u.user_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'A user who has recently created an account on the site has verified his email address.

User details:

	- username: %1$s
	- user id: %2$s

Please access the Admin Area -> Users Management page, in order to review the account.';

## html message - editable
$html_message = 'A user who has recently created an account on the site has verified his email address. <br>
<br>
User Details:<br>
<ul>
	<li>Username: <b>%1$s</b></li>
	<li>User ID: <b>%2$s</b></li>
</ul>
Please access the <b>Admin Area</b> -> <b>Users Management</b> page, in order to review the account.';


$text_message = sprintf($text_message, $row_details['username'], $row_details['user_id']);
$html_message = sprintf($html_message, $row_details['username'], $row_details['user_id']);

send_mail($setts['admin_email'], $setts['sitename'] . ' - Registration Approval - Email Verified', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>