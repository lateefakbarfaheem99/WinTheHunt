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
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_custom_field_admin.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$custom_fld = new custom_field_admin();

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (isset($_POST['form_save_settings']))
	{

		$template->set('msg_changes_saved', $msg_changes_saved);

		foreach ($_POST['type_id'] as $key => $value)
		{
			$sql_update_default_types = $db->query("UPDATE " . DB_PREFIX . "custom_fields_types SET
				maxfields=" . $_POST['maxfields'][$key] . " WHERE type_id=" . $value);
		}
	}

	if ($_REQUEST['do'] == 'add_field_type')
	{
		if ($_REQUEST['operation'] == 'submit')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$box_insert_id = $custom_fld->create_special_field($_POST['box_name'], $_POST['box_type'], $_POST['table_name_raw'], $_POST['box_value_code']);
		}
		else
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_ADD_FIELD_TYPE);
			$template->set('disabled_button', 'disabled');

			$table_name_raw = ($_REQUEST['table_name_raw']) ? $_REQUEST['table_name_raw'] : DB_PREFIX . $linkable_tables[0];

			$linkable_tables_list_menu	= $custom_fld->linkable_tables_list_menu($linkable_tables, $table_name_raw);
			$template->set('linkable_tables_list_menu', $linkable_tables_list_menu);

			(array) $table_fields = NULL;
			$table_fields = $db->table_fields($table_name_raw);

			$linked_table_fields = implode(' | ',$table_fields);

			$template->set('linked_table_fields', $linked_table_fields);

			$type_id = (!$_REQUEST['box_type']) ? 0 : $_REQUEST['box_type'];

			$box_types_list_menu = $custom_fld->box_types_list_menu($type_id, TRUE);
			$template->set('box_types_list_menu', $box_types_list_menu);

			$management_box = $template->process('custom_fields_types_add_field_type.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'edit_field_type')
	{
		if ($_REQUEST['operation'] == 'submit')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$box_insert_id = $custom_fld->edit_special_field($_POST['type_id'], $_POST['box_name'], $_POST['box_type'], $_POST['table_name_raw'], $_POST['box_value_code']);
		}
		else
		{
			$row_box = $db->get_sql_row("SELECT type_id, box_name, box_type, table_name_raw, box_value_code FROM
				" . DB_PREFIX . "custom_fields_special WHERE type_id=" . $_REQUEST['type_id']);

			$template->set('box_details', $row_box);
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_EDIT_FIELD_TYPE);
			$template->set('disabled_button', 'disabled');

			$table_name_raw = ($_REQUEST['table_name_raw']) ? $_REQUEST['table_name_raw'] : $row_box['table_name_raw'];

			$linkable_tables_list_menu	= $custom_fld->linkable_tables_list_menu($linkable_tables, $table_name_raw);
			$template->set('linkable_tables_list_menu', $linkable_tables_list_menu);

			(array) $table_fields = NULL;
			$table_fields = $db->table_fields($table_name_raw);

			$linked_table_fields = implode(' | ',$table_fields);

			$template->set('linked_table_fields', $linked_table_fields);

			$type_id = (!$_REQUEST['box_type']) ? 'D_' . $row_box['box_type'] : $_REQUEST['box_type'];

			$box_types_list_menu = $custom_fld->box_types_list_menu($type_id, TRUE);
			$template->set('box_types_list_menu', $box_types_list_menu);

			$management_box = $template->process('custom_fields_types_add_field_type.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'delete_field_type')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);
		$custom_fld->delete_special_field(intval($_GET['type_id']));
	}

	(string) $default_box_types_content = NULL;

	$template->set('management_box', $management_box);

	$sql_select_default_types = $db->query("SELECT type_id, box_type, maxfields FROM
		" . DB_PREFIX . "custom_fields_types");

	(string) $maxfields_readonly = NULL;
	(string) $maxfields_readonly_msg = NULL;

	while ($default_types_details = $db->fetch_array($sql_select_default_types))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';


		if (!in_array($default_types_details['box_type'], array('list', 'checkbox', 'radio')))
		{
			$maxfields_readonly = 'readonly';
			$maxfields_readonly_msg = AMSG_READONLY_FIELD;
		}
		else
		{
			$maxfields_readonly = NULL;
			$maxfields_readonly_msg = NULL;
		}

		$default_box_types_content .= '<input type="hidden" name="type_id[]" value="' . $default_types_details['type_id'] . '"> '.
			'<tr class="' . $background . '"> '.
      	'	<td>' . $default_types_details['box_type'] . '</td> '.
			'	<td><input name="maxfields[]" type="text" value="' . $default_types_details['maxfields'] . '" size="12" ' . $maxfields_readonly . '></td> '.
			'	<td>' . $maxfields_readonly_msg . '</td> '.
			'</tr> ';
	}

	$template->set('default_box_types_content', $default_box_types_content);

	$sql_select_special_types = $db->query("SELECT s.type_id, s.box_name, s.table_name_raw,
		s.box_value_code, t.box_type FROM
		" . DB_PREFIX . "custom_fields_special s, " . DB_PREFIX . "custom_fields_types t WHERE
		s.box_type=t.type_id");

	while ($special_types_details = $db->fetch_array($sql_select_special_types))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$special_box_types_content .= '<input type="hidden" name="type_id[]" value="' . $default_types_details['type_id'] . '"> '.
			'<tr class="' . $background . '"> '.
      	'	<td>' . $special_types_details['box_name'] . '</td> '.
      	'	<td>' . $special_types_details['table_name_raw'] . '</td> '.
      	'	<td>' . $special_types_details['box_type'] . '</td> '.
      	'	<td>' . $special_types_details['box_value_code'] . '</td> '.
      	'	<td align="center"> '.
			'		[ <a href="custom_fields_types.php?do=edit_field_type&type_id=' . $special_types_details['type_id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
			'		[ <a href="custom_fields_types.php?do=delete_field_type&type_id=' . $special_types_details['type_id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
			'</tr> ';
	}

	$template->set('special_box_types_content', $special_box_types_content);

	$template->set('header_section', AMSG_CUSTOM_FIELDS_SETUP);
	$template->set('subpage_title', AMSG_SETUP_FIELD_TYPES);

	$template_output .= $template->process('custom_fields_types.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>