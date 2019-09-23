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
	include_once ('header.php');

	$template->set('total_users', $db->count_rows('users'));
	$template->set('active_users', $db->count_rows('users', "WHERE active=1"));
	$template->set('suspended_users', $db->count_rows('users', "WHERE active=0"));
	$template->set('nl_users', $db->count_rows('users', "WHERE active=1 AND newsletter=1"));
	$template->set('store_users', $db->count_rows('users', "WHERE active=1 AND shop_active=1"));
	$template->set('nb_sellers', $db->count_rows('users', "WHERE active=1 AND is_seller=1"));
	$template->set('nb_verified_sellers', $db->count_rows('users', "WHERE active=1 AND seller_verified=1"));
	
	if (isset($_POST['form_send_email']))
	{
		$email_details = $db->rem_special_chars_array($_POST);

		switch ($email_details['newsletter_send'])
		{
			case '1':
				$query="SELECT name, email FROM " . DB_PREFIX . "users";
				break;
			case '2':
				$query="SELECT name, email FROM " . DB_PREFIX . "users WHERE active=1";
				break;
			case '3':
				$query="SELECT name, email FROM " . DB_PREFIX . "users WHERE active=0";
				break;
			case '4':
				$query="SELECT name, email FROM " . DB_PREFIX . "users WHERE active=1 AND newsletter=1";
				break;
			case '5':
				$query="SELECT name, email FROM " . DB_PREFIX . "users WHERE active=1 AND shop_active=1";
				break;
			case '6':
				$query="SELECT name, email FROM " . DB_PREFIX . "users WHERE active=1 AND is_seller=1";
				break;
			case '7':
				$query="SELECT name, email FROM " . DB_PREFIX . "users WHERE active=1 AND seller_verified=1";
				break;
		}

		if ($email_details['sending_method'] == 1) // direct send
		{
			$sql_select_users = $db->query($query);
			
			while ($user_details = $db->fetch_array($sql_select_users)) 
			{
				send_mail($user_details['email'], $db->add_special_chars($email_details['subject']), '',
					$setts['admin_email'], $db->add_special_chars($email_details['email_content']), null, true);				
			}			
		}
		else // send through cron
		{
			$sql_select_users = $db->query("INSERT INTO " . DB_PREFIX . "newsletter_recipients 
				(username, email) " . $query);
		
			$db->query("INSERT INTO " . DB_PREFIX . "newsletters 
				(newsletter_subject, newsletter_content) VALUES 
				('" . $email_details['subject'] . "', '" . $email_details['email_content'] . "')");
			
			$newsletter_id = $db->insert_id();
			
			$db->query("UPDATE " . DB_PREFIX . "newsletter_recipients SET newsletter_id='" . $newsletter_id . "' WHERE 
				newsletter_id=0");								
		}
		$template->set('msg_changes_saved','<p align="center">' . (($email_details['sending_method']) ? AMSG_NEWSLETTER_SEND_SUCCESS : AMSG_EMAILS_QUEUED_SUCCESS) . '</p>');
	}
	$template->set('send_emails_msg', $send_emails_msg);

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_EMAIL_USER);

	$template_output .= $template->process('email_user.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>