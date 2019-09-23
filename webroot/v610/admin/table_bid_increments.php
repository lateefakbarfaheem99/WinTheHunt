<?
#################################################################
## PHP Pro Bid v6.01															##
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

		if (count($_POST['increment_id']))
		{
			foreach ($_POST['increment_id'] as $key => $value)
			{
				$sql_update_increments = $db->query("UPDATE " . DB_PREFIX . "bid_increments SET
					value_from='" . $_POST['value_from'][$key] . "', value_to='" . $_POST['value_to'][$key] . "', 
					increment='" . $_POST['increment'][$key] . "' WHERE id=" . $value);
			}
		}

		if ($_POST['new_value_from'] > 0 && $_POST['new_value_to'] > 0 && $_POST['new_increment'] > 0)
		{
			$sql_insert_durations = $db->query("INSERT INTO " . DB_PREFIX . "bid_increments (value_from, value_to, increment) VALUES
				('" . $_POST['new_value_from'] . "', '" . $_POST['new_value_to'] . "', '" . $_POST['new_increment'] . "')");
		}

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_increments = $db->query("DELETE FROM " . DB_PREFIX . "bid_increments WHERE
				id IN (" . $delete_array . ")");
		}
	}

	(string) $bid_increments_page_content = NULL;

	$sql_select_increments = $db->query("SELECT * FROM
		" . DB_PREFIX . "bid_increments ORDER BY value_from ASC");

	while ($increment_details = $db->fetch_array($sql_select_increments))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$bid_increments_page_content .= '<input type="hidden" name="increment_id[]" value="' . $increment_details['id'] . '"> '.
			'<tr class="' . $background . '"> '.
			'	<td></td> '.
      	'	<td><input name="value_from[]" type="text" value="' . $increment_details['value_from'] . '" size="12"></td> '.
      	'	<td><input name="value_to[]" type="text" value="' . $increment_details['value_to'] . '" size="12"></td> '.
      	'	<td><input name="increment[]" type="text" value="' . $increment_details['increment'] . '" size="12"></td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $increment_details['id'] . '"></td> '.
			'</tr> ';
	}

	$template->set('header_section', AMSG_TABLES_MANAGEMENT);
	$template->set('subpage_title', AMSG_EDIT_BID_INCREMENTS);

	$template->set('bid_increments_page_content', $bid_increments_page_content);

	$template_output .= $template->process('table_bid_increments.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>