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

		if (count($_POST['shipping_id']))
		{
			foreach ($_POST['shipping_id'] as $key => $value)
			{
				$sql_update_shipping_options = $db->query("UPDATE " . DB_PREFIX . "shipping_options SET
					name='" . $db->rem_special_chars($_POST['name'][$key]) . "' WHERE
					id=" . $value);
			}
		}

		if (!empty($_POST['new_name']))
		{
			$sql_insert_shipping_options = $db->query("INSERT INTO " . DB_PREFIX . "shipping_options (name) VALUES
				('" . $db->rem_special_chars($_POST['new_name']) . "')");
		}

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_shipping_options = $db->query("DELETE FROM " . DB_PREFIX . "shipping_options WHERE
				id IN (" . $delete_array . ")");
		}
	}

	(string) $shipping_options_page_content = NULL;

	$sql_select_shipping_options = $db->query("SELECT id, name FROM
		" . DB_PREFIX . "shipping_options ORDER BY name ASC");

	while ($shipping_options_details = $db->fetch_array($sql_select_shipping_options))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$shipping_options_page_content .= '<input type="hidden" name="shipping_id[]" value="' . $shipping_options_details['id'] . '"> '.
			'<tr class="' . $background . '"> '.
			'	<td></td> '.
      	'	<td><input name="name[]" type="text" value="' . $shipping_options_details['name'] . '" size="50"></td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $shipping_options_details['id'] . '"></td> '.
			'</tr> ';
	}

	$template->set('header_section', AMSG_TABLES_MANAGEMENT);
	$template->set('subpage_title', AMSG_EDIT_SHIPPING_OPTIONS);

	$template->set('shipping_options_page_content', $shipping_options_page_content);

	$template_output .= $template->process('table_shipping_options.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>