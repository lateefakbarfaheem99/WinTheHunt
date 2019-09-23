<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class custom_field extends formchecker
{
	var $vars = array();
	var $show_only = false;
	var $data_owner_id = 0;
	var $new_table = true;
	var $field_colspan = 1;
	var $box_search = 0;
	var $src_box_display = false;

	function save_vars($input)
	{
		foreach ($input as $key => $value)
		{
			if (is_array($value))
			{
				$value = $this->implode_array($value, '|'); /* in case of checkbox fields which accept multiple selections */
			}
			$this->vars[$key] = $value;
		}
	}

	function save_edit_vars($owner_id, $page_handle)
	{
		$sql_query_result = $this->query("SELECT box_id, box_value FROM " . DB_PREFIX . "custom_fields_data WHERE
			owner_id=" . $owner_id . " AND page_handle='" . $page_handle . "'");

		while ($query_details = $this->fetch_array($sql_query_result))
		{
			$this->vars['custom_box_' . $query_details['box_id']] = $query_details['box_value'];
		}
	}

	function insert_data ($box_id, $owner_id, $box_value, $page_handle)
	{
		$insert_data = $this->query("INSERT INTO " . DB_PREFIX . "custom_fields_data
			(box_id, owner_id, box_value, page_handle) VALUES
			(" . $box_id . ", " . $owner_id . ", '" . $this->rem_special_chars($box_value) . "' , '" . $page_handle . "')");

		return $this->insert_id();
	}

	function update_data ($box_id, $owner_id, $box_value, $page_handle)
	{
		/* if row doesnt exist then use the >>insert_data<< function */
		$is_row = $this->count_rows('custom_fields_data', "WHERE box_id=" . $box_id . " AND
		owner_id=" . $owner_id . " AND page_handle='" . $page_handle . "'");

		if ($is_row)
		{
			$update_data = $this->query("UPDATE " . DB_PREFIX . "custom_fields_data SET
				box_value='" . $this->rem_special_chars($box_value) . "' WHERE
				box_id=" . $box_id . " AND owner_id=" . $owner_id . " AND page_handle='" . $page_handle . "'");
		}
		else
		{
			$this->insert_data($box_id, $owner_id, $box_value, $page_handle);
		}
	}

	function delete_data ($owner_id, $page_handle)
	{
		$delete_data = $this->query("DELETE FROM " . DB_PREFIX . "custom_fields_data WHERE
		owner_id=" . $owner_id . " AND page_handle='" . $page_handle . "'");
	}

	## this function displays a box when it requires input
	function display_box($box_id, $box_name, $box_type, $box_value, $selected_value = NULL)
	{
		(string) $display_output = NULL;

		if (!empty($this->vars['custom_box_' . $box_id]))
		{
			$selected_value = $this->vars['custom_box_' . $box_id];
		}
		else if (!empty($selected_value))
		{
			$selected_value = $selected_value;
		}
		
		$selected_value = $this->rem_special_chars($selected_value);

		$display_output = $box_name.' ';
		switch ($box_type)
		{
			case 'text':
				$display_output .= '<input type="text" name="custom_box_' . $box_id . '" value="' . ((!empty($selected_value)) ? $selected_value : $box_value) . '" ' . (($this->src_box_display) ? 'class="src_input"' : '') . ' /> ';
				break;
			case 'textarea':
				$display_output .= '<textarea name="custom_box_' . $box_id . '" style="width: 350px; height=180px;">' . ((!empty($selected_value)) ? $selected_value : $box_value) . '</textarea> ';
				break;
			case 'password':
				$display_output .= '<input type="password" name="custom_box_' . $box_id . '" value="' . $selected_value . '" /> ';
				break;
			case 'list':
				$display_output .= '<select name="custom_box_' . $box_id . '">';

				$box_array = explode('[]', $box_value);

				if ($this->box_search)
				{
					$display_output .= '<option value="" selected>- ' . GMSG_ALL . ' -</option>';					
				}
				
				foreach ($box_array as $value)
				{
					$display_output .= '<option value="' . $value . '" ' . (($value == $selected_value) ? 'selected' : '') . '>' . $value . '</option>';
				}

				$display_output .= '</select>';
				break;
			case 'checkbox':
				$box_array = explode('[]', $box_value);
				$selected_value = explode('|', $selected_value);

				$display_output .= '<input type="hidden" name="custom_box_' . $box_id . '[]" value=""> ';
				foreach ($box_array as $value)
				{
					$display_output .= '<input type="checkbox" name="custom_box_' . $box_id . '[]" value="' . $value . '" ' . ((in_array($value, $selected_value)) ? 'checked' : '') . ' />' . $value . ' ';
				}

				break;
			case 'radio':
				$box_array = explode('[]', $box_value);

				$display_output .= '<input type="hidden" name="custom_box_' . $box_id . '" value=""> ';
				foreach ($box_array as $value)
				{
					$display_output .= '<input type="radio" name="custom_box_' . $box_id . '" value="' . $value . '" ' . (($value == $selected_value) ? 'checked' : '') . ' />' . $value . ' ';
				}
				break;
		}

		return $display_output;
	}

	function process_table_code($table_row, &$table_fields, $table_code)
	{
		(string) $display_output = NULL;

		$display_output = $table_code;

		foreach ($table_fields as $value)
		{
			$formatted_field = '{' . $value . '}';

			$display_output = str_replace($formatted_field, $table_row[$value], $display_output);

		}

		return $display_output;
	}

	## this function displays a special box when it requires input
	function display_special_box($box_id, $box_name, $special_box_type, $selected_value = NULL)
	{
		(string) $display_output = NULL;

		if (!empty($this->vars['custom_box_' . $box_id]))
		{
			$selected_value = $this->vars['custom_box_' . $box_id];
		}

		$type_details = $this->get_sql_row("SELECT t.box_type, s.table_name_raw, s.box_value_code FROM
			" . DB_PREFIX . "custom_fields_types t, " . DB_PREFIX . "custom_fields_special s WHERE
			t.type_id=s.box_type AND s.type_id=" . $special_box_type);

		$display_output = $box_name . ' ';

		$sql_select_table = $this->query("SELECT * FROM " . $type_details['table_name_raw']);

		$table_fields = $this->table_fields($type_details['table_name_raw']);

		switch ($type_details['box_type'])
		{
			case 'list':
				$display_output .= '<select name="custom_box_' . $box_id . '">';

				while ($table_details = $this->fetch_array($sql_select_table))
				{
					$msg = $this->process_table_code($table_details, $table_fields, $type_details['box_value_code']);

					$display_output .= '<option value="' . $table_details['id'] . '" ' . (($table_details['id'] == $selected_value) ? 'selected' : '') . '>' . $msg . '</option> ';
				}

				$display_output .= '</select>';
				break;
			case 'checkbox':
				while ($table_details = $this->fetch_array($sql_select_table))
				{
					$msg = $this->process_table_code($table_details, $table_fields, $type_details['box_value_code']);

					$display_array[] = '<input type="checkbox" name="custom_box_' . $box_id . '[]" value="' . $table_details['id'] . '" ' . ((@in_array($table_details['id'], $selected_value)) ? 'checked' : '') . ' />' . $msg . ' ';
				}

				$display_output = implode('<br>', $display_array);
				break;
			case 'radio':
				while ($table_details = $this->fetch_array($sql_select_table))
				{
					$msg = $this->process_table_code($table_details, $table_fields, $type_details['box_value_code']);

					$display_array[] = '<input type="radio" name="custom_box_' . $box_id . '" value="' . $table_details['id'] . '" ' . (($table_details['id'] == $selected_value) ? 'checked' : '') . ' />' . $msg . ' ';
				}

				$display_output = implode('<br>', $display_array);
				break;
		}

		return $display_output;
	}

	## front end related custom sections functions - create all custom sections that belong to a page
	function display_section($page_handle, $section_name = '', $section_id = 0, $order_id = 0, $category_id = 0)
	{
		(string) $display_output = NULL;

		$fields_details = $this->display_fields($section_id, $page_handle, $category_id);
		
		if (!empty($fields_details))
		{
			if ($this->new_table)
			{
				$display_output = '<br><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border"> ';
			}

			if (!$this->src_box_display)
			{
		   	if (!empty($section_name))
		   	{
		   		$colspan = ($this->field_colspan == 1) ? 2 : $this->field_colspan + 1;
	
		   		$display_output .= '<tr> '.
		         	'	<td colspan="' . $colspan . '" class="c3">' . $section_name . '</td> '.
		      		'</tr>';
		   	}
	
		   	$display_output .= '<tr class="c5"> '.
		         '	<td><img src="themes/' . DEFAULT_THEME . '/img/pixel.gif" width="150" height="1"></td> '.
		         '	<td colspan="' . $this->field_colspan . '" width="100%"><img src="themes/' . DEFAULT_THEME . '/img/pixel.gif" width="1" height="1"></td> '.
		      	'</tr> ';
			}

			$display_output .= $fields_details;

			if ($this->new_table)
			{
				$display_output .= '</table> ';
			}
		}

		return $display_output;

	}

	## front end related custom fields functions - create all custom fields that belong to a section
	function display_fields($section_id, $page_handle, $category_id = 0)
	{
		(string) $display_output = NULL;

		$category_id = intval($category_id);
		$category_id = get_parent_cats($category_id);
		$category_id = $this->implode_array($category_id);
		
		## only display a field if the category corresponds
		if ($this->box_search)
		{
			$addl_query = ($category_id) ? " AND category_id IN (0, " . $category_id . ")" : " AND category_id=0";
		}
		else 
		{
			$addl_query = ($category_id) ? " AND category_id IN (0, " . $category_id . ")" : '';			
		}

		$sql_select_fields = $this->query("SELECT field_id, field_name, field_order, active, category_id, field_description FROM
			" . DB_PREFIX . "custom_fields WHERE
			section_id=" . $section_id . " AND page_handle='" . $page_handle . "' AND active='1' " . $addl_query . " ORDER BY field_order ASC");

		while ($field_details = $this->fetch_array($sql_select_fields))
		{
			$background = ($counter++%2) ? 'c1' : 'c2';

			$box_details = $this->display_boxes($field_details['field_id'], $page_handle);
			
			if (!$this->src_box_display)
			{
				if (!empty($box_details))
				{
					$display_output .= '<tr class="' . $background . '"> ' .
						'	<td width="150" align="right"> ' . $field_details['field_name'] . '</td>' .
						'	<td colspan="' . $this->field_colspan . '">' . $box_details . '</td>' .
						'</tr>';
		
					if (!empty($field_details['field_description']) && !$this->show_only && !$this->box_search)
					{
						$display_output .= '<tr class="reguser"> '.
		         		'	<td>&nbsp;</td> '.
		         		'	<td colspan="' . $this->field_colspan . '"> ' . $field_details['field_description'] . ' </td> '.
		      			'</tr>';
					}
				}
			}
			else 
			{
				if (!empty($box_details))
				{
					$display_output .= '<tr class="c1 srcbox_title"> '.
						'	<td>' . $field_details['field_name']  . '</td>'.
						'</tr>'.
						'<tr>'.
						'	<td>' . $box_details . '</td>'.
						'</tr>';
				}
			}
		}

		return $display_output;

	}

	function show_box ($box_name, $box_id, $owner_id, $page_handle)
	{
		(string) $display_output = NULL;

		$box_data = $this->get_sql_field("SELECT box_value FROM " . DB_PREFIX . "custom_fields_data WHERE
			box_id=" . $box_id . " AND owner_id='" . $owner_id . "' AND page_handle='" . $page_handle . "'", 'box_value');

		$box_array = explode('|', $box_data);
		
		if (is_array($box_array))
		{
			$box_array = array_diff($box_array, array('0', ''));
			$box_data = $this->implode_array($box_array, ', ');
		}
		
		$display_output = (($box_name) ? '<b>' . $box_name . '</b>: ' : '') . field_display(str_replace('|', ', ', $box_data)) . ' &nbsp; ';

		return $display_output;
	}

	function show_special_box ($box_name, $box_id, $special_box_id, $owner_id, $page_handle)
	{
		(string) $display_output = NULL;


		$box_data = $this->get_sql_row("SELECT box_value FROM " . DB_PREFIX . "custom_fields_data WHERE
			box_id=" . $box_id . " AND owner_id='" . $owner_id . "' AND page_handle='" . $page_handle . "'");

		$special_box_details = $this->get_sql_row("SELECT table_name_raw, box_value_code FROM
			" . DB_PREFIX . "custom_fields_special WHERE type_id=" . $special_box_id);

		$table_fields = $this->table_fields($special_box_details['table_name_raw']);

		$box_value = str_replace('|', ', ', $box_data['box_value']);

		$sql_select_values = $this->query("SELECT * FROM " . $special_box_details['table_name_raw'] . " WHERE
			id IN (" . $box_value . ")");

		while ($values_details = $this->fetch_array($sql_select_values))
		{
			$values_array[] = $this->process_table_code($values_details, $table_fields, $special_box_details['box_value_code']);
		}

		$formatted_output = $this->implode_array($values_array);

		$display_output = (($box_name) ? '<b>' . $box_name . '</b>: ' : '') . field_display($formatted_output) . ' &nbsp; ';


		//$display_output = 'UNCOMPLETED';

		return $display_output;
	}


	function display_boxes ($field_id, $page_handle)
	{
		(string) $display_output = NULL;

		## get all boxes corresponding to the field id requested. (default types)
		$sql_select_boxes = $this->query("SELECT b.box_id, b.box_name, b.box_value, b.box_order, t.box_type, b.mandatory FROM
			" . DB_PREFIX . "custom_fields_boxes b, " . DB_PREFIX . "custom_fields_types t WHERE
			b.field_id=" . $field_id . " AND b.box_type=t.type_id " . (($this->box_search) ? 'AND b.box_searchable=1' : '') . " ORDER BY b.box_order ASC");

		$is_boxes = $this->num_rows($sql_select_boxes);
		
		while ($box_details = $this->fetch_array($sql_select_boxes))
		{
			if ($this->show_only)
			{
				$display_output .= $this->show_box($box_details['box_name'], $box_details['box_id'], $this->data_owner_id, $page_handle);
			}
			else
			{
				$display_output .= $this->display_box($box_details['box_id'], $box_details['box_name'], $box_details['box_type'], $box_details['box_value']);
				$display_output .= ($this->src_box_display) ? '<br>' : '';
			}
		}

		## get all boxes corresponding to the field id requested. (special types)
		$sql_select_special_boxes = $this->query("SELECT b.box_id, b.box_name, b.box_value, b.box_order, b.box_type_special, b.mandatory FROM
			" . DB_PREFIX . "custom_fields_boxes b, " . DB_PREFIX . "custom_fields_special s WHERE
			b.field_id=" . $field_id . " AND b.box_type_special=s.type_id ORDER BY b.box_order ASC");

		while ($special_box_details = $this->fetch_array($sql_select_special_boxes))
		{
			if ($this->show_only)
			{
				$display_output .= $this->show_special_box($special_box_details['box_name'], $special_box_details['box_id'], $special_box_details['box_type_special'], $this->data_owner_id, $page_handle);
			}
			else
			{
				$display_output .= $this->display_special_box($special_box_details['box_id'], $special_box_details['box_name'], $special_box_details['box_type_special'], $special_box_details['box_value']);
				$display_output .= ($this->src_box_display) ? '<br>' : '';
			}
		}

		return $display_output;
	}

	function insert_page_data ($user_id, $page_handle, $value_array)
	{
		foreach ($value_array as $key => $value)
		{
			if (stristr($key, 'custom_box_'))
			{
				$custom_box_id = intval(str_replace('custom_box_', '', $key));
				$custom_box_id = intval(str_replace('[]', '', $custom_box_id));

				if (is_array($value))
				{
					$value = implode('|', $value);
				}

				$this->insert_data($custom_box_id, $user_id, $value, $page_handle);

			}

			$custom_box_ids = @implode(',', $custom_box_array);
		}
	}

	/* TO DO: if a single checkbox, it always selects it */
	function update_page_data ($user_id, $page_handle, $value_array)
	{
		foreach ($value_array as $key => $value)
		{
			if (stristr($key, 'custom_box_'))
			{
				$custom_box_id = intval(str_replace('custom_box_', '', $key));
				$custom_box_id = intval(str_replace('[]', '', $custom_box_id));

				if (is_array($value))
				{
					$value = implode('|', $value);
				}

				$this->update_data($custom_box_id, $user_id, $value, $page_handle);

			}

			$custom_box_ids = @implode(',', $custom_box_array);
		}
	}

	function display_sections($user_details, $page_handle, $show_only = false, $owner_id = 0, $category_id = 0)
	{
		(string) $display_output = null;

		$this->show_only = $show_only;
		$this->data_owner_id = $owner_id;

		$sql_select_sections = $this->query("SELECT section_id, section_name, order_id FROM
			" . DB_PREFIX . "custom_fields_sections WHERE
			page_handle='" . $page_handle . "' ORDER BY order_id ASC");

		## now create the fields with no section (here all fields and all boxes in those fields with section_id=0 will be created
		$is_fields_no_section = $this->count_rows('custom_fields', "WHERE
			section_id=0 AND active=1 AND page_handle='" . $page_handle . "'");
		
		if ($is_fields_no_section)
		{
			$display_output = $this->display_section($page_handle, '', 0, 0, $category_id);
		}

		while ($section_details = $this->fetch_array($sql_select_sections))
		{
			$display_output .= $this->display_section($page_handle, $section_details['section_name'], $section_details['section_id'], $section_details['order_id'], $category_id);
		}

		return $display_output;
	}

	function output_hidden_form_fields()
	{
		(string) $display_output = null;

		foreach ($this->vars as $key => $value)
		{
			if (stristr($key, 'custom_box_'))
			{
				$display_output .= '<input type="hidden" name="' . $key . '" value="' . $this->rem_special_chars($value) . '" /> ';
			}
		}

		return $display_output;
	}
	
	function is_fields ($page_handle)
	{
		
		$is_fields = $this->count_rows('custom_fields', "WHERE page_handle='" . $page_handle . "' AND active=1");
		
		return ($is_fields > 0) ? true : false;		
	}
}

?>