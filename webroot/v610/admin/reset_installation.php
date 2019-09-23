<?
#################################################################
## PHP Pro Bid v6.06															##
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

		$login_output = login_admin($post_details['admin_username'], $post_details['admin_password'], '', '', false);

		if ($login_output['active'] == 'Active' && $login_output['level'] == 1)
		{
			$tables_array = array(
				'abuses', 'admin_notes', 'auctions', 'auction_media', 'auction_offers', 'auction_rollbacks', 'auction_watch', 
				'banned', 'bids', 'bulktmp', 'favourite_stores', 'invoices', 'iphistory', 'keywords_watch', 
				'messaging', 'newsletters', 'newsletter_recipients', 'proxybid', 'reputation', 'reserve_offers', 
				'stores_accounting', 'suggested_categories', 'swaps', 'users', 'vouchers', 'wanted_ads', 
				'wanted_offers', 'winners'
			);				
			
			$tables = null;
			foreach ($tables_array as $value)
			{
				$db->query("TRUNCATE TABLE " . DB_PREFIX . $value);
			}			
			
			$msg_changes_saved = '<p align="center">' . AMSG_RESET_INSTALLATION_SUCCESS . '</p>';
		}
		else
		{
			$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_INVALID_ADMIN_LOGIN_RI . '</p>';
		}

		$template->set('msg_changes_saved', $msg_changes_saved);

	}

	$template->set('header_section', AMSG_SITE_SETUP);
	$template->set('subpage_title', AMSG_RESET_INSTALLATION);

	$template_output .= $template->process('reset_installation.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>