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
include_once ('../includes/class_messaging.php');


if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$user_id = intval($_REQUEST['user_id']);
	$template->set('user_id', $user_id);
	
	$user_details = $db->get_sql_row("SELECT user_id, username, email FROM " . DB_PREFIX . "users WHERE user_id='" . $user_id . "'");
	$template->set('user_details', $user_details);
	
	if (isset($_POST['form_send_email']))
	{
		$email_details = $db->rem_special_chars_array($_POST);
      
		if ($email_details['msg_method'] == 0)
		{
			send_mail($user_details['email'], $email_details['subject'], $email_details['email_content'],  
				$setts['admin_email'], $db->add_special_chars($email_details['email_content']), null, true);
		}	
		else 
		{
			$msg = new messaging();
			$msg->setts = &$setts;
			
			$msg->new_topic(0, 0, $user_details['user_id'], 0, $email_details['subject'], $email_details['email_content'], 0, 0, 1);			
		}
		$template->set('msg_changes_saved','<p align="center">' . AMSG_MSG_SENT_SUCCESS . '</p>');
	}
	$template->set('send_emails_msg', $send_emails_msg);

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_EMAIL_USER);

	$template_output .= $template->process('email_user.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>