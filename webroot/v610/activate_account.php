<?
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');

if (!$session->value('temp_user_id'))
{
	header_redirect('index.php');
}
else
{
	$user_row = $db->get_sql_row("SELECT active, approved FROM " . DB_PREFIX . "users WHERE
		user_id=" . $session->value('temp_user_id'));

	if ($user_row['active'] == 1 && $user_row['approved'] == 1 && $user_row['mail_activated'] == 1)
	{
		header_redirect('members_area.php');
	}
	else
	{
		include_once ('global_header.php');## PHP Pro Bid v6.00 check if there is a signup fee involved.
		$signup_fee = new fees();
		$signup_fee->setts = &$setts;

		$template->set('activate_account_header', header5(MSG_ACCOUNT_ACTIVATION));

		$signup_result = $signup_fee->signup($session->value('temp_user_id'));

		if ($signup_result['amount'])
		{
			$template->set('payment_table_display', $signup_result['display']);
		}
		else if ($setts['signup_settings'] == 1)
		{
			// email confirmation
			$activate_account_message = '<p align="center" class="contentfont">' . MSG_ACCOUNT_ACTIVATION_EMAIL_CONFIRM . '</p>';
			
			if ($_REQUEST['option'] == 'resend_email')
			{
				$mail_input_id = $session->value('temp_user_id');
				include('language/' . $setts['site_lang'] . '/mails/register_confirm_user_notification.php');					
				$activate_account_message .= '<p align="center" class="contentfont"><b>' . MSG_ACT_EMAIL_RESENT_SUCCESS . '</b></p>';	
			}
			else 
			{
				$activate_account_message .= '<p align="center" class="contentfont">[ <a href="activate_account.php?option=resend_email">' . MSG_RESEND_ACT_EMAIL . '</a> ]</p>';	
			}
		}
		else if ($setts['signup_settings'] == 2)
		{
			// admin approval
			$activate_account_message = '<p align="center" class="contentfont">' . MSG_ACCOUNT_ACTIVATION_ACC_APPROVAL . '</p>';

			if ($_REQUEST['option'] == 'resend_email')
			{
				$mail_input_id = $session->value('temp_user_id');
				include('language/' . $setts['site_lang'] . '/mails/register_approval_user_notification.php');	
				$activate_account_message .= '<p align="center" class="contentfont"><b>' . MSG_ACT_EMAIL_RESENT_SUCCESS . '</b></p>';	
			}
			else 
			{
				$activate_account_message .= '<p align="center" class="contentfont">[ <a href="activate_account.php?option=resend_email">' . MSG_RESEND_ACT_EMAIL . '</a> ]</p>';	
			}
		}

		$template->set('activate_account_message', $activate_account_message);

		$template_output .= $template->process('activate_account.tpl.php');

		include_once ('global_footer.php');

		echo $template_output;
	}
}
?>