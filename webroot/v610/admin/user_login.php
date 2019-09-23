<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_fees.php');
include_once ('../includes/functions_login.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$post_details = $_POST;
	$template->set('post_details', $post_details);

	if (isset($_POST['form_save_settings']))
	{
		$signup_fee = new fees();
		$signup_fee->setts = &$setts;

		$login_output = login_spoofer($post_details['username'], $post_details['admin_username'], $post_details['admin_password']);

		if (!$login_output['admin_exists'])
		{
			$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_INVALID_ADMIN_LOGIN . '</p>';
		}
		else if (!$login_output['user_exists'])
		{
			$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_INVALID_USERNAME . '</p>';
		}
		else
		{
			$msg_changes_saved = '<table border="0" cellpadding="3" cellspacing="3" align="center" class="border"> '.
				'	<tr align="center" class="c1 contentfont"><td>' . AMSG_SPOOFER_LOGIN_SUCCESS_A . ' [ <b>' . $post_details['username'] . '</b> ]<br><br> '.
				'		<a href="../index.php" target="_blank">' . AMSG_CLICK_TO_PROCEED . '</a></td></tr></table><br>';

			$session->set('membersarea', $login_output['active']);
			$session->set('username', $login_output['username']);
			$session->set('user_id', $login_output['user_id']);
			$session->set('is_seller', $login_output['is_seller']);
		}

		$template->set('msg_changes_saved', $msg_changes_saved);

	}

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_LOGIN_AS_SITE_USER);

	$template_output .= $template->process('user_login.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>