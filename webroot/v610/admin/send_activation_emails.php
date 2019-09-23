<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_fees.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');## PHP Pro Bid v6.00 add signup fee procedure here.
	$signup_fee = new fees();
	$signup_fee->setts = &$setts;
	$signup_fee->set_fees(0);
	
	$can_send = false;## PHP Pro Bid v6.00 can send activation emails
	if ($setts['signup_settings'] == 1 && $signup_fee->fee['signup_fee'] <= 0)
	{
		$can_send = true;
	}

	
	if ($can_send)
	{
		if (isset($_POST['form_proceed']))
		{
			$sql_select_users = $db->query("SELECT u.user_id, u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE 
				u.mail_activated=0");
			
			while ($row_details = $db->fetch_array($sql_select_users)) 
			{
				$mail_input_id = 0;
				include('../language/' . $setts['site_lang'] . '/mails/register_confirm_user_notification.php');	
			}
			
			$can_send = false;
			$send_emails_msg = AMSG_ACT_EMAILS_SENT_MSG;
		}
		else 
		{
			$send_emails_msg = AMSG_ACT_EMAILS_MSG;
		}
	}
	else
	{
		$send_emails_msg = AMSG_ACT_EMAILS_IMPOSSIBLE_MSG;
	}

	$template->set('can_send', $can_send);
	$template->set('send_emails_msg', $send_emails_msg);

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_REG_ACTIVATION_EMAILS);

	$template_output .= $template->process('send_activation_emails.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>