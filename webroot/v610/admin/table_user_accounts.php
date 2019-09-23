<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_formchecker.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (isset($_POST['form_save_settings']))
	{

		$template->set('msg_changes_saved', $msg_changes_saved);

		foreach ($_POST['account_id'] as $value)
		{
			$active = ($_POST['active'][$value]) ? 1 : 0;

			$sql_update_active_accs = $db->query("UPDATE " . DB_PREFIX . "user_accounts SET
				active=" . $active . " WHERE account_id=" . $value);
		}
	}

	$form_submitted = false;

	$fv = new formchecker();

	if ($_REQUEST['do'] == 'add_account')
	{
		if ($_REQUEST['operation'] == 'submit')
		{
			$fv->field_empty($_POST['name'], GMSG_FRMCHK_NAME_FIELD_EMPTY);
			$fv->field_empty($_POST['price'], GMSG_FRMCHK_PRICE_FIELD_EMPTY);
			$fv->field_amount($_POST['price'], GMSG_FRMCHK_PRICE_FIELD_POSITIVE_VALUE);

			if ($fv->is_error())
			{
				$template->set('display_formcheck_errors', $fv->display_errors());
				$template->set('account_details', $_POST);
			}
			else
			{
				$form_submitted = TRUE;

				$template->set('msg_changes_saved', $msg_changes_saved);

				$sql_insert_user_account = $db->query("INSERT INTO " . DB_PREFIX . "user_accounts
					(name, description, fees_custom, fees_reduction,
					pa_upl_pic, pa_send_msg,
					sa_enabled, sa_upl_pic, sa_html, sa_free_ads,
					ta_enabled, ta_upl_pic, ta_html, ta_free_ads,
					wa_enabled, wa_upl_pic, wa_html, wa_free_ads,
					recurring_days, price) VALUES
					('" . $db->rem_special_chars($_POST['name']) . "', '" . $db->rem_special_chars($_POST['description']) . "',
					" . $_POST['fees_custom'] . ", '" . $_POST['fees_reduction'] . "',
					" . $_POST['pa_upl_pic'] . ", " . $_POST['pa_send_msg'] . ",
					" . $_POST['sa_enabled'] . ", " . $_POST['sa_upl_pic'] . ", " . $_POST['sa_html'] . ", '" . $_POST['sa_free_ads'] . "',
					" . $_POST['ta_enabled'] . ", " . $_POST['ta_upl_pic'] . ", " . $_POST['ta_html'] . ", '" . $_POST['ta_free_ads'] . "',
					" . $_POST['wa_enabled'] . ", " . $_POST['wa_upl_pic'] . ", " . $_POST['wa_html'] . ", '" . $_POST['wa_free_ads'] . "',
					'" . $_POST['recurring_days'] . "', '" . $_POST['price'] . "')");
			}

		}

		if (!$form_submitted)
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_ADD_USER_ACCOUNT);
			$template->set('disabled_button', 'disabled');

			foreach ($enable_array as $value)
			{
				$ad_type_status = ad_type_status($value);
				$template->set($value . '_status_message', $ad_type_status['display_output']);
			}

			$management_box = $template->process('table_user_accounts_add_account.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'edit_account')
	{
		$row_account = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "user_accounts WHERE account_id=" . $_REQUEST['account_id']);

		$template->set('account_details', $row_account);

		if ($_REQUEST['operation'] == 'submit')
		{
			$fv->field_empty($_POST['name'], GMSG_FRMCHK_NAME_FIELD_EMPTY);
			$fv->field_empty($_POST['price'], GMSG_FRMCHK_PRICE_FIELD_EMPTY);
			$fv->field_amount($_POST['price'], GMSG_FRMCHK_PRICE_FIELD_POSITIVE_VALUE);

			if ($fv->is_error())
			{
				$template->set('display_formcheck_errors', $fv->display_errors());
				$template->set('account_details', $_POST);
			}
			else
			{
				$form_submitted = TRUE;

				$template->set('msg_changes_saved', $msg_changes_saved);

				$sql_update_user_account = $db->query("UPDATE " . DB_PREFIX . "user_accounts SET
					name = '" . $db->rem_special_chars($_POST['name']) . "',
					description = '" . $db->rem_special_chars($_POST['description']) . "',
					fees_custom = " . $_POST['fees_custom'] . ", fees_reduction = '" . $_POST['fees_reduction'] . "',
					pa_upl_pic = " . $_POST['pa_upl_pic'] . ", pa_send_msg = " . $_POST['pa_send_msg'] . ",
					sa_enabled = " . $_POST['sa_enabled'] . ", sa_upl_pic = " . $_POST['sa_upl_pic'] . ",
					sa_html = " . $_POST['sa_html'] . ", sa_free_ads = '" . $_POST['sa_free_ads'] . "',
					ta_enabled = " . $_POST['ta_enabled'] . ", ta_upl_pic = " . $_POST['ta_upl_pic'] . ",
					ta_html = " . $_POST['ta_html'] . ", ta_free_ads = '" . $_POST['ta_free_ads'] . "',
					wa_enabled = " . $_POST['wa_enabled'] . ", wa_upl_pic = " . $_POST['wa_upl_pic'] . ",
					wa_html = " . $_POST['wa_html'] . ", wa_free_ads = '" . $_POST['wa_free_ads'] . "',
					recurring_days = '" . $_POST['recurring_days'] . "', price = '" . $_POST['price'] . "' WHERE
					account_id=" . $_POST['account_id']);

			}
		}

		if (!$form_submitted)
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_EDIT_USER_ACCOUNT);
			$template->set('disabled_button', 'disabled');

			foreach ($enable_array as $value)
			{
				$ad_type_status = ad_type_status($value);
				$template->set($value . '_status_message', $ad_type_status['display_output']);
			}

			$management_box = $template->process('table_user_accounts_add_account.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'delete_account')
	{## PHP Pro Bid v6.00 reset all users that had the account we wish to delete
		$sql_reset_users = $db->query("UPDATE " . DB_PREFIX . "users SET account_id=0 WHERE account_id=" . $_REQUEST['account_id']);

		$sql_delete_user_account = $db->query("DELETE a, f FROM " . DB_PREFIX . "user_accounts a LEFT JOIN
			" . DB_PREFIX . "fees f ON a.account_id = f.account_id WHERE
			a.account_id=" . $_REQUEST['account_id']);
	}

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_USER_ACCOUNTS_SETUP);

	(string) $user_accounts_content = NULL;

	$template->set('management_box', $management_box);

	$sql_select_user_accounts = $db->query("SELECT * FROM
		" . DB_PREFIX . "user_accounts ORDER BY active DESC, price ASC");

	while ($user_account = $db->fetch_array($sql_select_user_accounts))
	{
		$background = ($user_account['active']) ? (($counter++%2) ? 'c1' : 'c2') : 'grey';

		$user_accounts_content .= '<input type="hidden" name="account_id[]" value="' . $user_account['account_id'] . '"> '.
		'<tr class="' . $background . '"> '.
		'	<td>' . $user_account['name'] . '</td> '.
		'	<td>' . user_account_details($user_account['account_id']) . '</td> '.
		'	<td align="center">' . $fees->display_amount($user_account['price']) . '</td> '.
		'	<td align="center">' . display_recurring($user_account['recurring_days']) . '</td> '.
		'	<td align="center"><input type="checkbox" name="active[' . $user_account['account_id'] . ']" value="1" ' . (($user_account['active']) ? 'checked' : ''). ' /></td> '.
		'	<td align="center"> '.
		'		[ <a href="table_user_accounts.php?do=edit_account&account_id=' . $user_account['account_id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
		'		[ <a href="table_user_accounts.php?do=delete_account&account_id=' . $user_account['account_id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
		'</tr> ';
	}

	$template->set('user_accounts_content', $user_accounts_content);

	$template_output .= $template->process('table_user_accounts.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>