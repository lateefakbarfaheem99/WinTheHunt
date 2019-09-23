<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class custom_field_admin extends custom_field
{

	function create_section($section_name, $page_handle)
	{
		$this->query("INSERT INTO " . DB_PREFIX . "custom_fields_sections
			(section_name, page_handle) VALUES
			('" . $this->rem_special_chars($section_name) . "', '" . $page_handle . "')");

		return $this->insert_id();
	}

	function edit_section($section_id, $section_name)
	{
		$this->query("UPDATE " . DB_PREFIX . "custom_fields_sections SET
			section_name='" . $this->rem_special_chars($section_name) . "' WHERE section_id=" . $section_id);
	}

	function delete_section($section_id)
	{
		$this->query("UPDATE " . DB_PREFIX . "custom_fields SET
			section_id=0 WHERE section_id=" . $section_id);
		$this->query("DELETE FROM " . DB_PREFIX . "custom_fields_sections WHERE section_id=" .$section_id);
	}

	function create_field($field_name, $field_description, $page_handle, $section_id = 0, $category_id = 0, $field_order = 0, $active = 1)
	{
		$create_field = $this->query("INSERT INTO " . DB_PREFIX . "custom_fields
			(field_name, field_order, active, page_handle, section_id, category_id, field_description) VALUES
			('" . $this->rem_special_chars($field_name) . "', " . $field_order . ", '" . $active . "', '" . $page_handle . "',
			" . $section_id . ", '" . $category_id . "', '" . $this->rem_special_chars($field_description) . "')");

		return $this->insert_id();
	}

	function edit_field($field_id, $field_name, $field_description, $section_id = 0, $category_id = 0)
	{
		$edit_field = $this->query("UPDATE " . DB_PREFIX . "custom_fields SET
			field_name='" . $this->rem_special_chars($field_name) . "', section_id=" . $section_id . ", category_id='" . $category_id . "',
			field_description='" . $this->rem_special_chars($field_description) . "' WHERE field_id=" . $field_id);
	}

	function delete_field($field_id)
	{

		$delete_field = $this->query("DELETE f, b, d FROM " . DB_PREFIX . "custom_fields AS f LEFT JOIN
			" . DB_PREFIX . "custom_fields_boxes AS b ON b.field_id=f.field_id LEFT JOIN
			" . DB_PREFIX . "custom_fields_data AS d ON d.box_id=b.box_id WHERE f.field_id=" .$field_id);

	}

	function create_box ($box_name, $box_type_raw, $box_value_raw, $field_id, $formchecker_array, $mandatory = 0, $box_order = 0, $box_searchable = 0)
	{
		list($type_handle, $type_value) = explode('_', $box_type_raw);


		(int) $box_type = 0;
		(int) $box_type_special = 0;

		$formchecker_functions = (!empty($formchecker_array)) ? @implode('|', $formchecker_array) : '';

		if ($type_handle == 'D')
		{
			$box_type = $type_value;
		}
		else if ($type_handle == 'S')
		{
			$box_type_special = $type_value;
		}

		if (isset($box_value_raw))
		{
			(int) $cnt = 0;

			$count_box_value_raw = count($box_value_raw);

			for($i=0; $i<$count_box_value_raw; $i++)
			{
				if (!empty($box_value_raw[$i]))
				{
					$box_value_array[$cnt++] = @str_replace('[]', '', $box_value_raw[$i]);
				}
			}

			$box_value = @implode('[]', $box_value_array);
		}
		else
		{
			$box_value = @str_replace('[]', '', $box_value_raw);
		}

		$create_box = $this->query("INSERT INTO " . DB_PREFIX . "custom_fields_boxes
			(field_id, box_name, box_value, box_order, box_type, mandatory, box_type_special, formchecker_functions, box_searchable) VALUES
			(" . $field_id . ", '" . $this->rem_special_chars($box_name) . "', '" . $this->rem_special_chars($box_value) . "',
			" . $box_order . ", '" . $box_type . "', '" . $mandatory . "', '" . $box_type_special . "',
			'" . $formchecker_functions . "', '" . $box_searchable . "')");

		return $this->insert_id();
	}

	function edit_box ($box_id, $box_name, $box_type_raw, $box_value_raw, $field_id, $formchecker_array, $mandatory = 0, $box_order = 0, $box_searchable = 0)
	{
		list($type_handle, $type_value) = explode('_', $box_type_raw);

		(int) $box_type = 0;
		(int) $box_type_special = 0;

		$formchecker_functions = (!empty($formchecker_array)) ? @implode('|', $formchecker_array) : '';

		if ($type_handle == 'D')
		{
			$box_type = $type_value;
		}
		else if ($type_handle == 'S')
		{
			$box_type_special = $type_value;
		}

		if (is_array($box_value_raw))
		{
			(int) $cnt = 0;

			$count_box_value_raw = count($box_value_raw);

			for($i=0; $i<$count_box_value_raw; $i++)
			{
				if (!empty($box_value_raw[$i]))
				{
					$box_value_array[$cnt++] = @str_replace('[]', '', $box_value_raw[$i]);
				}
			}

			$box_value = @implode('[]', $box_value_array);
		}
		else
		{
			$box_value = @str_replace('[]', '', $box_value_raw);
		}

		$edit_box = $this->query("UPDATE " . DB_PREFIX . "custom_fields_boxes SET
			field_id=" . $field_id . ", box_name='" . $this->rem_special_chars($box_name) . "',
			box_value='" . $this->rem_special_chars($box_value) . "', box_order=" . $box_order . ",
			box_type='" . $box_type . "', mandatory='" . $mandatory . "',
			box_type_special='" . $box_type_special . "',
			formchecker_functions='" . $formchecker_functions . "', 
			box_searchable='" . $box_searchable . "' WHERE box_id=" . $box_id);

	}

	function delete_box($box_id)
	{

		$delete_field = $this->query("DELETE b, d FROM " . DB_PREFIX . "custom_fields_boxes AS b LEFT JOIN
			" . DB_PREFIX . "custom_fields_data AS d ON d.box_id=b.box_id WHERE b.box_id=" .$box_id);

	}


	## admin related custom fields functions - for custom field management purposes only
	function admin_display_section($page_handle, $section_name = AMSG_NO_SECTION, $section_id = 0, $order_id = 0)
	{
		(string) $display_output = NULL;

		$display_output = '<tr><td class="c4"> '.
			'<table cellpadding="0" cellspacing="2" border="0" class="contentfont"> '.
			'<tr><td width="100%" class="c4"><strong>' . $section_name . '</strong></td> ';

		if ($section_id)
		{
			$display_output .= '<td nowrap class="c4"><strong>' . AMSG_ORDER_ID . '</strong>: '.
				'<input type="hidden" name="section_id[]" value="' . $section_id . '" size="6">'.
				'<input type="text" name="section_order_id[]" value="' . $order_id . '" size="6"></td>'.
				'<td nowrap class="c4">&nbsp;&nbsp;[ <a href="custom_fields.php?page=' . $page_handle . '&do=edit_section&section_id=' . $section_id . '"'.
				'>' . AMSG_EDIT . '</a> ]</td> '.
				'<td nowrap class="c4"> [ <a href="custom_fields.php?page=' . $page_handle . '&do=delete_section&section_id=' . $section_id . '"'.
				' onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> ';
		}
		else
		{
			$display_output .= '<td nowrap class="c4">[ <a href="custom_fields.php?page=' . $page_handle . '&do=add_section">' . AMSG_ADD_SECTION . '</a> ]</td> ';
		}

		$display_output .= '</tr></table></td></tr><tr><td class="c9"><img src="admin/images/pixel.gif" width="1" height="1"></td></tr>';

		return $display_output;

	}

	## admin related custom fields functions - create all custom fields that belong to a section
	function admin_display_fields($section_id, $page_handle)
	{
		(string) $display_output = NULL;

		## the add field message first
		$display_output = '<tr><td> '.
			'[ <b><a href="custom_fields.php?page=' . $page_handle . '&do=add_field&section_id=' . $section_id . '">' . AMSG_ADD_FIELD . '</a></b> ] '.
			'</td></tr> ';

		## get all fields corresponding to the section id requested.
		$sql_select_fields = $this->query("SELECT field_id, field_name, field_order, active, category_id, field_description FROM
			" . DB_PREFIX . "custom_fields WHERE
			section_id=" . $section_id . " AND page_handle='" . $page_handle . "' ORDER BY active DESC, field_order ASC");

		while ($field_details = $this->fetch_array($sql_select_fields))
		{
			$background = ($field_details['active']) ? (($counter++%2) ? 'c1' : 'c2') : 'grey';

			$display_output .= '<tr><td class="border"> '.
				'<table cellpadding="0" cellspacing="2" border="0" class="contentfont c3" width="100%">'.
				'<tr><td class="c3" width="100%">&nbsp;<b>' . $field_details['field_name'] . '</b> ( ' . $field_details['field_description'] . ' ) </td>'.
				'<td class="c3" align="right"><strong>' . AMSG_ACTIVE . '</strong>:</td>'.
				'<td class="c3"><input type="checkbox" name="field_active[' . $field_details['field_id'] . ']" value="1" ' . (($field_details['active']) ? 'checked' : ''). ' /></td>'.
				
				'<td class="c3" nowrap><strong>' . AMSG_ORDER_ID . '</strong>:</td> '.
				'<td><input type="hidden" name="field_id[]" value="' . $field_details['field_id'] . '" size="6">'.
				'<input type="text" name="field_order_id[]" value="' . $field_details['field_order'] . '" size="6"></td>'.
				
				'<td align="center" nowrap>[ <a href="custom_fields.php?page=' . $page_handle . '&do=edit_field&section_id=' . $section_id .
				'&field_id=' . $field_details['field_id'] . '">' . AMSG_EDIT . '</a> ]</td> '.
				'<td align="center" nowrap>[ <a href="custom_fields.php?page=' . $page_handle . '&do=delete_field&field_id=' . $field_details['field_id'] .
				'"'.
				' onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]&nbsp;</td></tr></table> '.
				'<div style="padding: 5px;">[ <b><a href="custom_fields.php?page=' . $page_handle . '&do=add_box&field_id=' . $field_details['field_id'] . '">' . AMSG_ADD_BOX . '</a></b> ]</div>'.
				
				'<table cellpadding="2" cellspacing="2" border="0" class="contentfont border" width="100%"> '.
				'<tr>'.
				'<td>' . $this->admin_display_boxes($field_details['field_id'], $page_handle) . '</td>';

			$display_output .= '</tr></table></td></tr> ';
		}

		return $display_output;

	}

	function admin_display_boxes ($field_id, $page_handle)
	{
		(string) $display_output = NULL;

		$display_output = '<table cellpadding="3" cellspacing="2" border="0" class="contentfont border">';

		## get all boxes corresponding to the field id requested. (default types)
		$sql_select_boxes = $this->query("SELECT b.box_id, b.box_name, b.box_value, b.box_order, t.box_type, b.mandatory, b.box_searchable FROM
			" . DB_PREFIX . "custom_fields_boxes b, " . DB_PREFIX . "custom_fields_types t WHERE
			b.field_id=" . $field_id . " AND b.box_type=t.type_id ORDER BY b.box_order ASC");

		while ($box_details = $this->fetch_array($sql_select_boxes))
		{
			$display_box = $this->display_box($box_details['box_id'], $box_details['box_name'], $box_details['box_type'], $box_details['box_value']);

			$display_output .= '<tr valign="top" class="c2"><td>' . $display_box . (($box_details['box_searchable']) ? '<b>*</b>' : '') . 
				'</td><td nowrap>[ <a href="custom_fields.php?page=' . $page_handle . '&do=edit_box&field_id=' . $field_id .
				'&box_id=' . $box_details['box_id'] . '">' . AMSG_EDIT . '</a> ] [ <a href="custom_fields.php?page=' . $page_handle . '&do=delete_box&box_id=' . $box_details['box_id'] . '"'.
				' onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td></tr>';
		}

		## get all boxes corresponding to the field id requested. (special types)
		$sql_select_special_boxes = $this->query("SELECT b.box_id, b.box_name, b.box_value, b.box_order, b.box_type_special, b.mandatory FROM
			" . DB_PREFIX . "custom_fields_boxes b, " . DB_PREFIX . "custom_fields_special s WHERE
			b.field_id=" . $field_id . " AND b.box_type_special=s.type_id ORDER BY b.box_order ASC");

		while ($special_box_details = $this->fetch_array($sql_select_special_boxes))
		{
			$display_box = $this->display_special_box($special_box_details['box_id'], $special_box_details['box_name'], $special_box_details['box_type_special'], $special_box_details['box_value']);

			$display_output .= '<tr class="c2" valign="top"><td>' . $display_box .
				'</td><td nowrap>[ <a href="custom_fields.php?page=' . $page_handle . '&do=edit_box&field_id=' . $field_id .
				'&box_id=' . $special_box_details['box_id'] . '">' . AMSG_EDIT . '</a> ] [ <a href="custom_fields.php?page=' . $page_handle . '&do=delete_box&box_id=' . $special_box_details['box_id'] . '"'.
				' onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td></tr>';
		}

		$display_output .='</table>';

		return $display_output;
	}

	function sections_list_menu ($selected_section_id, $page_handle)
	{
		(string) $display_output = NULL;

		$display_output = '<select name="section_id"> '.
			'<option value="0" selected>' . AMSG_NO_SECTION . '</option> ';

		$sql_select_sections = $this->query("SELECT section_id, section_name FROM
			" . DB_PREFIX . "custom_fields_sections WHERE
			page_handle='" . $page_handle . "' ORDER BY order_id ASC");

		while ($section_details = $this->fetch_array($sql_select_sections))
		{
			$display_output .= '<option value="' . $section_details['section_id']. '" ' . (($selected_section_id == $section_details['section_id']) ? 'selected' : '') . '>' . $section_details['section_name'] . '</option>';
		}

		$display_output .= '</select> ';

		return $display_output;
	}

	function fields_list_menu ($selected_field_id, $page_handle)
	{
		(string) $display_output = NULL;

		$display_output = '<select name="field_id"> ';

		$sql_select_fields = $this->query("SELECT field_id, field_name FROM
			" . DB_PREFIX . "custom_fields WHERE
			page_handle='" . $page_handle . "' ORDER BY section_id ASC, field_order ASC");

		while ($field_details = $this->fetch_array($sql_select_fields))
		{
			$display_output .= '<option value="' . $field_details['field_id']. '" ' . (($selected_field_id == $field_details['field_id']) ? 'selected' : '') . '>' . $field_details['field_name'] . '</option>';
		}

		$display_output .= '</select> ';

		return $display_output;
	}

	function box_types_list_menu ($selected_type_id = 0, $special_field = FALSE)
	{
		(string) $display_output = NULL;

		$display_output = '<select name="box_type" onChange="submit_form(form_custom_box);"> '.

		$additional_query = ($special_field) ? 'WHERE maxfields>1' : '';

		$sql_select_box_types = $this->query("SELECT type_id, box_type, maxfields FROM
			" . DB_PREFIX . "custom_fields_types " . $additional_query);

		while ($box_type_details = $this->fetch_array($sql_select_box_types))
		{
			$display_output .= '<option value="D_' . $box_type_details['type_id']. '" ' . (($selected_type_id && $selected_type_id == 'D_' . $box_type_details['type_id']) ? 'selected' : '') . '>' . $box_type_details['box_type'] . '</option>';
		}

		if (!$special_field)
		{
			## now also select any special box types
			$sql_select_special_types = $this->query("SELECT type_id, box_name FROM
				" . DB_PREFIX . "custom_fields_special");

			while ($special_type_details = $this->fetch_array($sql_select_special_types))
			{
				$display_output .= '<option value="S_' . $special_type_details['type_id']. '" ' . (($selected_type_id && $selected_type_id == 'S_' . $special_type_details['type_id']) ? 'selected' : '') . '>' . $special_type_details['box_name'] . '</option>';
			}
		}

		$display_output .= '</select> ';

		return $display_output;
	}

	function admin_box_type_display($type_id_raw, $box_value=NULL)
	{
		(string) $display_output = NULL;

		list($type_handle, $type_id) = explode('_', $type_id_raw);

		$type_id = (!$type_id) ? 0 : $type_id;

		if ($type_handle == 'S')
		{
			$display_output = $this->display_special_box($box_id, $box_name, $type_id, $box_value);
		}
		else
		{
			$box_details = $this->get_sql_row("SELECT box_type, maxfields FROM
				" . DB_PREFIX . "custom_fields_types WHERE type_id=" . $type_id);

			$box_fields = explode('[]', $box_value);

			if (in_array($box_details['box_type'], array('list', 'checkbox', 'radio')))
			{
				for ($i=0; $i<$box_details['maxfields']; $i++)
				{
					$display_output .= '<input type="text" name="box_value[]" size="25" value="' . $box_fields[$i] . '" /><br />';

				}
			}
			else
			{
				$display_output = '<input type="text" name="box_value" size="40" value="' . $box_value . '" />';
			}
		}

		return $display_output;
	}

	function linkable_tables_list_menu ($linkable_tables, $selected_table_name = NULL)
	{
		(string) $display_output = NULL;

		$display_output = '<select name="table_name_raw" onChange="submit_form(form_custom_box);"> ';

		foreach ($linkable_tables as $value)
		{
			$table_name = DB_PREFIX . $value;
			$display_output .= '<option value="' . $table_name. '" ' . (($selected_table_name == $table_name) ? 'selected' : '') . '>' . $table_name . '</option>';
		}

		$display_output .= '</select> ';

		return $display_output;
	}

	function create_special_field ($box_name, $box_type_raw, $table_name_raw, $box_value_code)
	{
		list($type_handle, $box_type) = explode('_', $box_type_raw);

		$create_box = $this->query("INSERT INTO " . DB_PREFIX . "custom_fields_special
			(box_name, box_type, table_name_raw, box_value_code) VALUES
			('" . $this->rem_special_chars($box_name) . "', '" . $box_type . "',
			'" . $table_name_raw . "', '" . $box_value_code . "')");

		return $this->insert_id();
	}

	function edit_special_field ($type_id, $box_name, $box_type_raw, $table_name_raw, $box_value_code)
	{
		list($type_handle, $box_type) = explode('_', $box_type_raw);

		$create_box = $this->query("UPDATE " . DB_PREFIX . "custom_fields_special SET
			box_name='" . $this->rem_special_chars($box_name) . "', box_type='" . $box_type . "',
			table_name_raw='" . $table_name_raw . "', box_value_code='" . $box_value_code . "' WHERE type_id=" . $type_id);
	}

	function delete_special_field($type_id)
	{

		$delete_special_field_related = $this->query("DELETE s, b, d FROM " . DB_PREFIX . "custom_fields_special AS s LEFT JOIN
			" . DB_PREFIX . "custom_fields_boxes AS b ON b.box_type_special=s.type_id LEFT JOIN
			" . DB_PREFIX . "custom_fields_data AS d ON d.box_id=b.box_id WHERE s.type_id=" .$type_id);


	}

	function formcheck_functions_display($selected_values = NULL)
	{
		(string) $display_output = NULL;

		$selected = explode('|', $selected_values);

		foreach ($this->methods as $value)
		{
			$display_output .= '<input type="checkbox" name="formchecker_functions[]" value="' . $value . '" ' . ((in_array($value, $selected)) ? 'checked' : '') . '>' . $value. ' ';
		}

		return $display_output;
	}

}

?>