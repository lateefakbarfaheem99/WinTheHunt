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
				$sql_update_word_filter = $db->query("UPDATE " . DB_PREFIX . "wordfilter SET
					word='" . $db->rem_special_chars($_POST['word'][$key]) . "' WHERE
					id=" . $value);
			}
		}

		if (!empty($_POST['new_word']))
		{
			$sql_insert_word = $db->query("INSERT INTO " . DB_PREFIX . "wordfilter (word) VALUES
				('" . $db->rem_special_chars($_POST['new_word']) . "')");
		}

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_words = $db->query("DELETE FROM " . DB_PREFIX . "wordfilter WHERE
				id IN (" . $delete_array . ")");
		}
	}

	(string) $word_filter_page_content = NULL;

	$sql_select_words = $db->query("SELECT id, word FROM
		" . DB_PREFIX . "wordfilter ORDER BY word ASC");

	while ($word_details = $db->fetch_array($sql_select_words))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$word_filter_page_content .= '<input type="hidden" name="id[]" value="' . $word_details['id'] . '"> '.
			'<tr class="' . $background . '"> '.
			'	<td></td> '.
      	'	<td><input name="word[]" type="text" value="' . $word_details['word'] . '" size="50"></td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $word_details['id'] . '"></td> '.
			'</tr> ';
	}

	$template->set('header_section', AMSG_TOOLS);
	$template->set('subpage_title', AMSG_WORD_FILTER);

	$template->set('word_filter_page_content', $word_filter_page_content);

	$template_output .= $template->process('word_filter.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>