<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_user.php');
include_once ('includes/functions_login.php');

if ($session->value('membersarea')=='Active')
{
	header_redirect('index.php');
}
else
{
	require ('global_header.php');

	$template->set('header_message', header5(MSG_RETRIEVE_YOUR_PASSWORD));

	$post_details = $db->rem_special_chars_array($_POST);
	if ($_REQUEST['operation'] == 'retrieve_password')
	{
		$is_user = $db->count_rows('users', "WHERE username='" . $post_details['username'] . "' AND email='" . $post_details['email'] . "'");
		
		if (!$is_user)
		{
			$template->set('retrieve_password_msg', '<div align="center" class="errormessage">' . MSG_RETRIEVE_USER_ERROR . '</div>');
		}
		else 
		{
			$user = new user();
			$user->setts = &$setts;
			
			$new_password = substr(md5(rand(0, 100000)), 0, 8);
			$salt = $user->create_salt();
			$password_hashed = password_hash($new_password, $salt);
			
			$db->query("UPDATE " . DB_PREFIX . "users SET password='" . $password_hashed . "', salt='" . $salt . "' WHERE 
				username='" . $post_details['username'] . "'");
			
			$template->set('submitted', 1);
			$template->set('retrieve_password_msg', '<div align="center" class="errormessage">' . MSG_NEW_PASSWORD_EMAILED . '</div>');
			
			$mail_input_id = $post_details['username'];
			include('language/' . $setts['site_lang'] . '/mails/retrieve_password.php');
		}
	}
	else if ($_REQUEST['operation'] == 'retrieve_username')
	{
		$is_user = $db->count_rows('users', "WHERE email='" . $post_details['email_address'] . "'");

		if (!$is_user)
		{
			$template->set('retrieve_username_msg', '<div class="errormessage">' . MSG_RETRIEVE_USER_ERROR . '</div>');
		}
		else 
		{
			$template->set('submitted', 1);
			$template->set('retrieve_username_msg', '<div class="errormessage">' . MSG_USERNAME_EMAILED . '</div>');
			
			$mail_input_id = $post_details['email_address'];
			include('language/' . $setts['site_lang'] . '/mails/retrieve_username.php');
		}
	}
	$template->set('post_details', $post_details);

	$template_output .= $template->process('retrieve_password.tpl.php');
	
	include_once ('global_footer.php');

	echo $template_output;
}
?>