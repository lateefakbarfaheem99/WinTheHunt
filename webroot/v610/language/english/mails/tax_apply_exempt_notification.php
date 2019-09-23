<?
## Email File -> apply for tax exempt notification
## called only from the $user->insert() and $user->update() functions!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $this->get_sql_row("SELECT u.* FROM " . DB_PREFIX . "users u 
	WHERE u.user_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'A new user has applied for Tax exempt.

User Details:

	- username: %1$s
	- user ID: %2$s
	
Tax Reg. Number: %3$s

To verify the validity of the Tax reg. number, click on the link below:

%4$s

NOTE: This link applies for the EU only.								

You can activate Tax exempt for this user from the admin area, users management page.';

## html message - editable
$html_message = 'A new user has applied for Tax exempt. <br>
<br>
User Details: <br>
<ul>
	<li>Username: <b>%1$s</b></li>
	<li>User ID: <b>%2$s</b></li>
</ul>
Tax Reg. Number: <b>%3$s</b> <br>
<br>
To verify the validity of the Tax reg. number, [ <a href="%4$s">click here</a> ]. <br>
<br>
<b>NOTE</b>: This link applies for the EU only.	<br>
<br>
You can activate Tax exempt for this user from the <b>Admin Area</b> - <b>Users Management</b> page.';


$vat_verify_link = 'http://europa.eu.int/comm/taxation_customs/vies/en/vieshome.htm';

$text_message = sprintf($text_message, $row_details['username'], $row_details['user_id'], $row_details['tax_reg_number'], $vat_verify_link);
$html_message = sprintf($html_message, $row_details['username'], $row_details['user_id'], $row_details['tax_reg_number'], $vat_verify_link);

send_mail($this->setts['admin_email'], 'New Tax Exempt Request', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>