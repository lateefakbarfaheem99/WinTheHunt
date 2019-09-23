<?
#################################################################
## PHP Pro Bid v6.02															##
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

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_cats = $db->query("DELETE FROM " . DB_PREFIX . "suggested_categories WHERE
				id IN (" . $delete_array . ")");
		}
	}

	(string) $suggested_categories_page_content = NULL;

	$sql_select_categories = $db->query("SELECT s.*, u.username FROM " . DB_PREFIX . "suggested_categories s
		LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=s.userid 
		ORDER BY regdate DESC");

	while ($cat_details = $db->fetch_array($sql_select_categories))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$suggested_categories_page_content .= '<tr class="' . $background . '"> '.
      	'	<td>' . $cat_details['username'] . '</td> '.
      	'	<td>' . $cat_details['content'] . '</td> '.
      	'	<td align="center">' . show_date($cat_details['regdate']) . '</td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $cat_details['id'] . '"></td> '.
			'</tr> ';
	}

	$template->set('header_section', AMSG_CATEGORIES);
	$template->set('subpage_title', AMSG_VIEW_SUGGESTED_CATEGORIES);

	$template->set('suggested_categories_page_content', $suggested_categories_page_content);

	$template_output .= $template->process('table_suggested_categories.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>