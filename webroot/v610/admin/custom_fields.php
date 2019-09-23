<?
#################################################################
## PHP Pro Bid v6.06															##
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

	(string) $page_handle = null;
	(string) $management_box = null;

	$fv = new formchecker;

	$page_handle = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : '';

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (!in_array($page_handle, $custom_fields_pages))
	{
		$template_output .= '<p align="center" class="contentfont">' . AMSG_CUSTOM_PAGE_SEL_ERROR . '</p>';
	}
	else
	{

		$template->set('page_handle', $page_handle);

		$form_submitted = FALSE;## PHP Pro Bid v6.00 begin insert/update/delete operations
		if ($_REQUEST['do'] == 'add_section')
		{## PHP Pro Bid v6.00 begin form check
			if ($_REQUEST['operation'] == 'submit')
			{
				$fv->field_empty($_POST['section_name'], GMSG_FRMCHK_SECTION_NAME_EMPTY);

				if ($fv->is_error())
				{
					$template->set('display_formcheck_errors', $fv->display_errors());
				}
				else
				{
					$form_submitted = TRUE;

					$template->set('msg_changes_saved', $msg_changes_saved);

					$section_insert_id = $custom_fld->create_section($_POST['section_name'], $page_handle);
				}
			}

			if (!$form_submitted)
			{
				$template->set('section_id', $_REQUEST['section_id']);
				$template->set('do', $_REQUEST['do']);
				$template->set('manage_section_title', AMSG_ADD_SECTION);
				$template->set('disabled_button', 'disabled');

				$management_box = $template->process('custom_fields_manage_section.tpl.php');
			}
		}
		else if ($_REQUEST['do'] == 'edit_section')
		{
			if ($_REQUEST['operation'] == 'submit')
			{
				$fv->field_empty($_POST['section_name'], GMSG_FRMCHK_SECTION_NAME_EMPTY);

				if ($fv->is_error())
				{
					$template->set('display_formcheck_errors', $fv->display_errors());
				}
				else
				{
					$form_submitted = TRUE;

					$template->set('msg_changes_saved', $msg_changes_saved);

					$section_insert_id = $custom_fld->edit_section($_POST['section_id'], $_POST['section_name']);
				}
			}

			if (!$form_submitted)
			{
				$row_section = $db->get_sql_row("SELECT section_name FROM " . DB_PREFIX . "custom_fields_sections WHERE
					section_id=" . $_REQUEST['section_id']);

				$template->set('section_details', $row_section);

				$template->set('section_id', $_REQUEST['section_id']);
				$template->set('do', $_REQUEST['do']);
				$template->set('manage_section_title', AMSG_EDIT_SECTION);
				$template->set('disabled_button', 'disabled');

				$management_box = $template->process('custom_fields_manage_section.tpl.php');
			}
		}
		else if ($_REQUEST['do'] == 'delete_section')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);
			$custom_fld->delete_section(intval($_GET['section_id']));
		}
		else if ($_REQUEST['do'] == 'add_field')
		{
			if ($_REQUEST['operation'] == 'submit')
			{
				$fv->field_empty($_POST['field_name'], GMSG_FRMCHK_FIELD_NAME_EMPTY);

				if ($fv->is_error())
				{
					$template->set('display_formcheck_errors', $fv->display_errors());
				}
				else
				{
					$form_submitted = TRUE;

					$template->set('msg_changes_saved', $msg_changes_saved);

					$field_insert_id = $custom_fld->create_field($_POST['field_name'], $_POST['field_description'], $page_handle, $_POST['section_id'], $_POST['category_id']);
				}
			}

			if (!$form_submitted)
			{
				$template->set('field_id', $_REQUEST['field_id']);
				$template->set('do', $_REQUEST['do']);
				$template->set('manage_field_title', AMSG_ADD_FIELD);
				$template->set('disabled_button', 'disabled');

				$sections_list_menu = $custom_fld->sections_list_menu($_REQUEST['section_id'], $page_handle);
				$template->set('sections_list_menu', $sections_list_menu);

				$management_box = $template->process('custom_fields_manage_field.tpl.php');
			}
		}
		else if ($_REQUEST['do'] == 'edit_field')
		{
			if ($_REQUEST['operation'] == 'submit')
			{
				$fv->field_empty($_POST['field_name'], GMSG_FRMCHK_FIELD_NAME_EMPTY);

				if ($fv->is_error())
				{
					$template->set('display_formcheck_errors', $fv->display_errors());
				}
				else
				{
					$form_submitted = TRUE;

					$template->set('msg_changes_saved', $msg_changes_saved);

					$field_insert_id = $custom_fld->edit_field($_POST['field_id'], $_POST['field_name'], $_POST['field_description'], $_POST['section_id'], $_POST['category_id']);
				}
			}

			if (!$form_submitted)
			{
				$row_field = $db->get_sql_row("SELECT field_id, field_name, field_description, category_id FROM " . DB_PREFIX . "custom_fields WHERE
					field_id=" . $_REQUEST['field_id']);

				$template->set('field_details', $row_field);

				$template->set('field_id', $_REQUEST['field_id']);
				$template->set('do', $_REQUEST['do']);
				$template->set('manage_field_title', AMSG_EDIT_FIELD);
				$template->set('disabled_button', 'disabled');

				$sections_list_menu = $custom_fld->sections_list_menu($_REQUEST['section_id'], $page_handle);
				$template->set('sections_list_menu', $sections_list_menu);

				$management_box = $template->process('custom_fields_manage_field.tpl.php');
			}
		}
		else if ($_REQUEST['do'] == 'delete_field')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);
			$custom_fld->delete_field(intval($_GET['field_id']));
		}
		else if ($_REQUEST['do'] == 'add_box')
		{
			if ($_REQUEST['operation'] == 'submit')
			{
				$template->set('msg_changes_saved', $msg_changes_saved);

				$box_insert_id = $custom_fld->create_box($_POST['box_name'], $_POST['box_type'], $_POST['box_value'], $_POST['field_id'], $_POST['formchecker_functions'], $_POST['mandatory'], 0, $_POST['box_searchable']);
			}
			else
			{
				$template->set('field_id', $_REQUEST['field_id']);
				$template->set('do', $_REQUEST['do']);
				$template->set('manage_box_title', AMSG_ADD_BOX);
				$template->set('disabled_button', 'disabled');

				$fields_list_menu = $custom_fld->fields_list_menu($_REQUEST['field_id'], $page_handle);
				$template->set('fields_list_menu', $fields_list_menu);

				$type_id = (!$_REQUEST['box_type']) ? 0 : $_REQUEST['box_type'];

				$box_types_list_menu = $custom_fld->box_types_list_menu($type_id);
				$template->set('box_types_list_menu', $box_types_list_menu);

				$display_formcheck_functions = $custom_fld->formcheck_functions_display();
				$template->set('display_formcheck_functions', $display_formcheck_functions);

				$box_type_listing = $custom_fld->admin_box_type_display($type_id);
				$template->set('box_type_listing', $box_type_listing);

				$management_box = $template->process('custom_fields_manage_box.tpl.php');
			}
		}
		else if ($_REQUEST['do'] == 'edit_box')
		{
			if ($_REQUEST['operation'] == 'submit')
			{
				$template->set('msg_changes_saved', $msg_changes_saved);

				$box_insert_id = $custom_fld->edit_box($_POST['box_id'], $_POST['box_name'], $_POST['box_type'], $_POST['box_value'], $_POST['field_id'], $_POST['formchecker_functions'], $_POST['mandatory'], 0, $_POST['box_searchable']);
			}
			else
			{
				$row_box = $db->get_sql_row("SELECT box_id, box_name, box_value, box_order, box_type,
					mandatory, box_type_special, formchecker_functions, box_searchable FROM
					" . DB_PREFIX . "custom_fields_boxes WHERE box_id=" . $_REQUEST['box_id']);

				$template->set('box_details', $row_box);
				$template->set('field_id', $_REQUEST['field_id']);
				$template->set('do', $_REQUEST['do']);
				$template->set('manage_box_title', AMSG_EDIT_BOX);
				$template->set('disabled_button', 'disabled');

				$fields_list_menu = $custom_fld->fields_list_menu($_REQUEST['field_id'], $page_handle);
				$template->set('fields_list_menu', $fields_list_menu);

				$box_type_value = ($row_box['box_type']) ? 'D_' . $row_box['box_type'] : 'S_' . $row_box['box_type_special'];

				$type_id = (!$_REQUEST['box_type']) ? $box_type_value : $_REQUEST['box_type'];

				$box_types_list_menu = $custom_fld->box_types_list_menu($type_id);
				$template->set('box_types_list_menu', $box_types_list_menu);

				$display_formcheck_functions = $custom_fld->formcheck_functions_display($row_box['formchecker_functions']);
				$template->set('display_formcheck_functions', $display_formcheck_functions);

				$box_type_listing = $custom_fld->admin_box_type_display($type_id, $row_box['box_value']);
				$template->set('box_type_listing', $box_type_listing);

				$management_box = $template->process('custom_fields_manage_box.tpl.php');
			}

		}
		else if ($_REQUEST['do'] == 'delete_box')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);
			$custom_fld->delete_box(intval($_GET['box_id']));
		}
		else if ($_REQUEST['do'] == 'save_settings_main')
		{
			if (count($_REQUEST['section_id']))
			{
				foreach ($_REQUEST['section_id'] as $key => $value)
				{
					$db->query("UPDATE " . DB_PREFIX . "custom_fields_sections SET
						order_id=" . $_REQUEST['section_order_id'][$key] . " WHERE section_id= " . $value);
				}
			}

			foreach ($_REQUEST['field_id'] as $key => $value)
			{
				$field_active = ($_REQUEST['field_active'][$value]) ? 1 : 0;

				$db->query("UPDATE " . DB_PREFIX . "custom_fields SET
					field_order=" . $_REQUEST['field_order_id'][$key] . ",
					active='" . $field_active . "' WHERE field_id= " . $value);
			}
		}## PHP Pro Bid v6.00 end insert/update/delete operations

		switch ($page_handle)
		{
			case 'register':
				$template->set('header_section', AMSG_USERS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_REG_FIELDS);
				break;
			case 'reputation':
				$template->set('header_section', AMSG_USERS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_REP_FIELDS_MANAGEMENT);
				break;
			case 'reputation_sale':
				$template->set('header_section', AMSG_USERS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_SALE);
				break;
			case 'reputation_purchase':
				$template->set('header_section', AMSG_USERS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_PURCHASE);
				break;
			case 'auction':
				$template->set('header_section', AMSG_AUCTIONS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_AUCT_FIELDS_MANAGEMENT);
				break;
			case 'wanted_ad':
				$template->set('header_section', AMSG_AUCTIONS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_WANTED_ADS_MANAGEMENT);
				break;
			case 'reverse':
				$template->set('header_section', AMSG_REVERSE_AUCTIONS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_REVERSE_AUCT_FIELDS_MANAGEMENT);
				break;
			case 'provider_profile':
				$template->set('header_section', AMSG_REVERSE_AUCTIONS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_PROVIDER_PROFILE_FIELDS_MANAGEMENT);
				break;
			case 'reputation_poster':
				$template->set('header_section', AMSG_REVERSE_AUCTIONS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_POSTER);
				break;
			case 'reputation_provider':
				$template->set('header_section', AMSG_USERS_MANAGEMENT);
				$template->set('subpage_title', AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_PROVIDER);
				break;
		}
		
		## now we get all sections, starting with section 0, and add them into the template
		$sql_select_sections = $db->query("SELECT section_id, section_name, order_id FROM
			" . DB_PREFIX . "custom_fields_sections WHERE
			page_handle='" . $page_handle . "' ORDER BY order_id ASC");

		$page_content = $custom_fld->admin_display_section($page_handle);## PHP Pro Bid v6.00 the no section tab## PHP Pro Bid v6.00 now create the fields with no section (here all fields and all boxes in those fields with section_id=0 will be created
		$page_content .= $custom_fld->admin_display_fields(0, $page_handle);

		while ($section_details = $db->fetch_array($sql_select_sections))
		{
			$page_content .= $custom_fld->admin_display_section($page_handle, $section_details['section_name'], $section_details['section_id'], $section_details['order_id']);

			$page_content .= $custom_fld->admin_display_fields($section_details['section_id'], $page_handle);
		}

		$template->set('management_box', $management_box);
		$template->set('custom_fields_page_content', $page_content);

		$template_output .= $template->process('custom_fields.tpl.php');
	}

	include_once ('footer.php');

	echo $template_output;
}
?>