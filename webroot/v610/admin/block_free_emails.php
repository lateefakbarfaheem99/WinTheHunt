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

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (isset($_POST['form_save_settings']))
	{

		$template->set('msg_changes_saved', $msg_changes_saved);

		if (count($_POST['id']))
		{
			foreach ($_POST['id'] as $key => $value)
			{
				$db->query("UPDATE " . DB_PREFIX . "blocked_domains SET
					domain='" . $db->rem_special_chars($_POST['domain'][$key]) . "' WHERE
					id=" . $value);
			}
		}

		if (!empty($_POST['new_domain']))
		{
			$db->query("INSERT INTO " . DB_PREFIX . "blocked_domains (domain) VALUES
				('" . $db->rem_special_chars($_POST['new_domain']) . "')");
		}

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_words = $db->query("DELETE FROM " . DB_PREFIX . "blocked_domains WHERE
				id IN (" . $delete_array . ")");
		}
	}

	(string) $blocked_domains_page_content = NULL;

	$sql_select_domains = $db->query("SELECT id, domain FROM
		" . DB_PREFIX . "blocked_domains ORDER BY domain ASC");

	while ($blocked_domains = $db->fetch_array($sql_select_domains))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$blocked_domains_page_content .= '<input type="hidden" name="id[]" value="' . $blocked_domains['id'] . '"> '.
			'<tr class="' . $background . '"> '.
			'	<td></td> '.
      	'	<td><input name="domain[]" type="text" value="' . $blocked_domains['domain'] . '" size="50"></td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $blocked_domains['id'] . '"></td> '.
			'</tr> ';
	}

	$template->set('header_section', AMSG_TOOLS);
	$template->set('subpage_title', AMSG_BLOCK_FREE_EMAILS);

	$template->set('blocked_domains_page_content', $blocked_domains_page_content);

	$template_output .= $template->process('block_free_emails.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>