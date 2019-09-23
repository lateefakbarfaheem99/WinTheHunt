<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (isset($_POST['form_save_settings']))
	{

		$template->set('msg_changes_saved', $msg_changes_saved);

		$sql_update_setts = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
			account_mode = " . $_POST['account_mode'] . ", init_credit=" . $_POST['init_credit'] . ",
			max_credit=" . $_POST['max_credit'] . ", account_mode_personal=" . $_POST['account_mode_personal'] . ",
			suspend_over_bal_users=" . $_POST['suspend_over_bal_users'] . ",
			min_invoice_value=" . $_POST['min_invoice_value'] . ", init_acc_type='" . $_POST['init_acc_type'] . "', 
			suspension_date_days='" . $_POST['suspension_date_days'] . "'");

		if ($_POST['reset_sitewide'] == 1) /* reset the max_credit value for all user accounts */
		{
			$sql_update_max_credit = $db->query("UPDATE " . DB_PREFIX ."users SET
				max_credit='" . $_POST['max_credit'] . "'");
		}
	}

	$template->set('header_section', AMSG_FEES);
	$template->set('subpage_title', AMSG_MAIN_SETTINGS);

	$row_settings = $db->get_sql_row("SELECT account_mode, account_mode_personal, init_acc_type, init_credit,
		max_credit, min_invoice_value, suspend_over_bal_users, suspension_date_days FROM " . DB_PREFIX . "gen_setts LIMIT 0,1");

	$template->set('row_settings', $row_settings);

	$template_output .= $template->process('fees_settings.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>