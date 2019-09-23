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

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $page_handle = null;
	(string) $management_box = NULL;

	//$template->set('db', $db);

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$address_type = ($_REQUEST['address_type']) ? $_REQUEST['address_type'] : 0;
	$template->set('address_type', $address_type);

	$post_details = $db->rem_special_chars_array($_POST);

	if ($_REQUEST['do'] == 'add_ban')
	{
		if (isset($_POST['form_save_settings']))
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$db->query("INSERT INTO " . DB_PREFIX . "banned
				(banned_address, address_type) VALUES
				('" . $post_details['banned_address'] . "', '" . $post_details['address_type'] . "')");
		}
		else
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_ADD_BANNED);

			$management_box = $template->process('ban_users_add_ban.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'edit_ban')
	{
		if (isset($_POST['form_save_settings']))
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$db->query("UPDATE " . DB_PREFIX . "banned SET
				banned_address='" . $post_details['banned_address'] . "' WHERE
				banned_id='" . $post_details['banned_id'] . "'");
		}
		else
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_EDIT_BANNED);
			$template->set('banned_id', $_REQUEST['banned_id']);
			$template->set('ban_details', $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "banned WHERE banned_id=" . intval($_REQUEST['banned_id'])));

			$management_box = $template->process('ban_users_add_ban.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'delete_ban')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		$db->query("DELETE FROM " . DB_PREFIX . "banned WHERE banned_id=" . intval($_REQUEST['banned_id']));
	}

	$template->set('management_box', $management_box);

	$sql_select_bans = $db->query("SELECT * FROM " . DB_PREFIX . "banned");

	while ($ban_details = $db->fetch_array($sql_select_bans))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$bans_management_content .= '<tr class="' . $background . '"> '.
		'	<td>' . $ban_details['banned_address'] . '</td> '.
		'	<td align="center">' . (($ban_details['address_type'] == 1) ? AMSG_IP_BAN : AMSG_EMAIL_BAN) . '</td> '.
		'	<td align="center"> '.
		'		[ <a href="ban_users.php?do=edit_ban&banned_id=' . $ban_details['banned_id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
		'		[ <a href="ban_users.php?do=delete_ban&banned_id=' . $ban_details['banned_id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
		'</tr> ';

	}

	$template->set('bans_management_content', $bans_management_content);

	$template->set('header_section', AMSG_SITE_CONTENT);
	$template->set('subpage_title', AMSG_BAN_USERS);

	$template_output .= $template->process('ban_users.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>