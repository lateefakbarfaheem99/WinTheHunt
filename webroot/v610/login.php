<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

(string) $page_handle = 'login';

include_once ('includes/global.php');
include_once ('includes/class_fees.php');
include_once ('includes/functions_login.php');

if ($session->value('membersarea')=='Active')
{
	if (!empty($_REQUEST['redirect']))
	{
		$redirect = @str_ireplace('_AND_', '&', $_REQUEST['redirect']);		
	}
	else 
	{
		$redirect = 'index.php';
	}
	header_redirect($redirect);
}
else if ($setts['is_ssl'] && $_SERVER['HTTPS'] != 'on' && $_REQUEST['operation'] != 'submit')
{
	header_redirect($setts['site_path_ssl'] . 'login.php?' . $_SERVER['QUERY_STRING']);
}
else
{
	require ('global_header.php');
	
	$banned_output = check_banned($_SERVER['REMOTE_ADDR'], 1);

	if ($banned_output['result'])
	{
		$template->set('message_header', header5(MSG_LOGIN_TO_MEMBERS_AREA));
		$template->set('message_content', $banned_output['display']);

		$template_output .= $template->process('single_message.tpl.php');
	}
	else
	{
		$template->set('header_registration_message', header5(MSG_LOGIN_TO_MEMBERS_AREA));

		if ($_REQUEST['operation'] == 'submit')
		{
			$signup_fee = new fees();
			$signup_fee->setts = &$setts;

			$header_redirect = (empty($_REQUEST['redirect'])) ? 'members_area.php' : $_REQUEST['redirect'];

			$login_output = login_user($_POST['username'], $_POST['password'], $header_redirect);

			$session->set('membersarea', $login_output['active']);
			$session->set('username', $login_output['username']);
			$session->set('user_id', $login_output['user_id']);
			$session->set('is_seller', $login_output['is_seller']);
			
			$remember_username = ($_REQUEST['remember_username'] == 1) ? 1 : 0;
			
			if ($remember_username)
			{
				$session->set_cookie('username_cookie', $login_output['username']);
			}
			
			$session->set('temp_user_id', $login_output['temp_user_id']); /* for use with activate_account.php only! */

			$redirect_url = ($login_output['redirect_url'] == 'sell_item') ? 'sell_item.php' : $login_output['redirect_url'];
			$redirect_url = (stristr($redirect_url, 'account_activate')) ? 'members_area.php' : $redirect_url;
			
			header_redirect($db->add_special_chars($redirect_url));
		}

		if ($_REQUEST['invalid_login'] == 1)
		{
			$invalid_login_message = '<table width="400" border="0" cellpadding="4" cellspacing="0" align="center" class="errormessage"> '.
			'	<tr><td align="center" class="alertfont"><b>' . MSG_INVALID_LOGIN . '</b></td></tr> '.
			'</table>';

			$template->set('invalid_login_message', $invalid_login_message);
		}

		$redirect = @str_ireplace('_AND_', '&', $_REQUEST['redirect']);		
		$template->set('redirect', $redirect);

		$template_output .= $template->process('login.tpl.php');
	}

	include_once ('global_footer.php');

	echo $template_output;
}
?>