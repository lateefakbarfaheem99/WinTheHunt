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

	$form_submitted = false;

	if ($_REQUEST['do'] == 'add_user')
	{
		if ($_REQUEST['operation'] == 'submit')
		{
			$fv = new formchecker();

			$fv->check_box($_POST['username'], AMSG_USERNAME, array('field_empty'));
			$fv->check_box($_POST['password'], AMSG_PASSWORD, array('field_empty', 'pass_confirm'), $_POST['password2'], AMSG_REPEAT_PASSWORD);

			if ($fv->is_error())
			{
				$template->set('display_formcheck_errors', $fv->display_errors());
			}
			else
			{
				$form_submitted = true;

				$template->set('msg_changes_saved', $msg_changes_saved);

				$sql_insert_user = $db->query("INSERT INTO " . DB_PREFIX . "admins
					(username, password, date_created, level) VALUES
					('" . $db->rem_special_chars($_POST['username']) . "', '" . md5($_POST['password']) . "',
					'" . CURRENT_TIME . "', '" . $_POST['level'] . "')");
			}
		}

		if (!$form_submitted)
		{
			$template->set('user_details', $_POST);
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_ADD_ADMIN_USER);

			$management_box = $template->process('list_admin_users_add_admin_user.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'edit_user')
	{
		$row_user = $db->get_sql_row("SELECT id, username, password, date_created, date_lastlogin, level FROM
			" . DB_PREFIX . "admins WHERE id=" . $_REQUEST['id']);

		if ($_REQUEST['operation'] == 'submit')
		{
			$fv = new formchecker();

			$current_password = md5($_POST['current_password']);

			$fv->check_box($_POST['username'], AMSG_USERNAME, array('field_empty'));

			if ($_POST['password'])
			{
				$fv->pass_confirm($current_password, $row_user['password'], AMSG_FRMCHK_CURRENT_PASSWORD_MISMATCH);
				$fv->check_box($_POST['password'], AMSG_PASSWORD, array('pass_confirm'), $_POST['password2'], AMSG_REPEAT_PASSWORD);
			}

			if ($fv->is_error())
			{
				$template->set('display_formcheck_errors', $fv->display_errors());
			}
			else
			{
				$form_submitted = true;

				$template->set('msg_changes_saved', $msg_changes_saved);

				$query_update_user = "UPDATE " . DB_PREFIX . "admins SET
					username='" . $db->rem_special_chars($_POST['username']) . "', level='" . $_POST['level'] . "' ";

				if ($_POST['password'])
				{
					$query_update_user .= ", password='" . md5($_POST['password']) . "' ";
				}
				$query_update_user .= "WHERE id=" . $_POST['id'];

				$sql_update_user = $db->query($query_update_user);
			}
		}

		if (!$form_submitted)
		{
			$template->set('user_details', $row_user);
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_EDIT_ADMIN_USER);

			$management_box = $template->process('list_admin_users_add_admin_user.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'delete_user')
	{
		$nb_admin_users = $db->count_rows('admins'); // if like this it will count all rows in a table (or more tables)

		if ($nb_admin_users > 1)
		{
			$template->set('msg_changes_saved', $msg_changes_saved);
			$sql_delete_user = $db->query("DELETE FROM " . DB_PREFIX . "admins WHERE id=" . intval($_GET['id']));
		}
		else
		{
			$msg_delete_error = '<p align="center" class="contentfont">' . AMSG_ADMIN_USER_DELETE_ERROR . '</p>';
			$template->set('msg_changes_saved', $msg_delete_error);
		}
	}

	$template->set('management_box', $management_box);

	$sql_select_users = $db->query("SELECT id, username, date_created, date_lastlogin, level FROM
		" . DB_PREFIX ."admins");

	while ($user_details = $db->fetch_array($sql_select_users))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$admin_users_content .= '<tr class="' . $background . '"> '.
      	'	<td>' . $user_details['username'] . '</td> '.
      	'	<td align="center">' . show_date($user_details['date_created']) . '</td> '.
      	'	<td align="center">' . show_date($user_details['date_lastlogin']) . '</td> '.
      	'	<td align="center">' . $user_details['level'] . '</td> '.
      	'	<td align="center"> '.
			'		[ <a href="list_admin_users.php?do=edit_user&id=' . $user_details['id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
			'		[ <a href="list_admin_users.php?do=delete_user&id=' . $user_details['id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
			'</tr> ';
	}

	$template->set('admin_users_content', $admin_users_content);


	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_ADMIN_USERS);

	$template_output .= $template->process('list_admin_users.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>