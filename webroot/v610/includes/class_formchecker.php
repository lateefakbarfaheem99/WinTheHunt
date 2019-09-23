<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class formchecker extends database
{

	var $error_list;

	var $methods = array(
		'field_empty', 'field_checked', 'pass_confirm', 'field_string', 'field_image',
		'field_number', 'field_integer', 'field_float', 'field_alpha', 'invalid_html',
		'field_html', 'field_js', 'field_iframes', 'within_length', 'within_range', 'is_email_address',
		'field_amount', 'field_smaller', 'field_greater', 'field_equal'
	);

	function formchecker()
	{
		$this->reset_error_list();
	}

	function check_box($field_value, $field_value_display, $methods, $field_value_two = NULL, $field_value_display_two = NULL)
	{
		$methods_cnt = count($methods);
		
		if ($methods_cnt > 0 && is_array($methods))
		{
			foreach ($methods as $value)
			{
				switch ($value)
				{
					case 'field_empty':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_EMPTY;
						$this->field_empty($field_value, $msg);
						break;
					case 'field_checked':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_CHECKED;
						$this->field_checked($field_value, $msg);
						break;
					case 'pass_confirm':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_AND . ' "' . $field_value_display_two . '" ' . GMSG_MUST_MATCH;
						$this->pass_confirm($field_value, $field_value_two, $msg);
						break;
					case 'field_string':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_STRING;
						$this->field_string($field_value, $msg);
						break;
					case 'field_image':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_IMAGE;
						$this->field_image($field_value, $msg);
						break;
					case 'field_number':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_NUMBER;
						$this->field_number($field_value, $msg);
						break;
					case 'field_integer':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_INTEGER;
						$this->field_integer($field_value, $msg);
						break;
					case 'field_float':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_FLOAT;
						$this->field_float($field_value, $msg);
						break;
					case 'field_alpha':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_ALPHA;
						$this->field_alpha($field_value, $msg);
						break;
					case 'invalid_html':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_INVALID_HTML;
						$this->invalid_html($field_value, $msg);
						break;
					case 'field_html':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_HTML;
						$this->field_html($field_value, $msg);
						break;
					case 'field_js':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_JS;
						$this->field_js($field_value, $msg);
						break;
					case 'field_iframes':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_FIELD_IFRAMES;
						$this->field_iframes($field_value, $msg);
						break;
					case 'within_length':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_MIN_LENGTH_6_MAX_18;
						$this->within_length($field_value, $msg, 6, 18);
						break;
					case 'is_email_address':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_VALID_EMAIL;
						$this->is_email_address($field_value, $msg);
						break;
					case 'is_phone':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FRMCHK_VALID_PHONE;
						$this->is_phone($field_value, $msg);
						break;
					case 'field_amount':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_POSITIVE_VALUE;
						$this->field_amount($field_value, $msg);
						break;
					case 'field_smaller':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FIELD_MUST_BE_SMALLER_THAN . ' "' . $field_value_display_two . '" ';
						$this->field_smaller($field_value, $field_value_two, $msg);
						break;
					case 'field_greater':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_FIELD_MUST_BE_GREATER_THAN . ' "' . $field_value_display_two . '" ';
						$this->field_greater($field_value, $field_value_two, $msg);
						break;
					case 'field_equal':
						$msg = GMSG_THE . ' "' . $field_value_display . '" ' . GMSG_AND . ' "' . $field_value_display_two . '" ' . GMSG_FIELDS_MUST_MATCH;
						$this->field_equal($field_value, $field_value_two, $msg);
						break;

				}

			}
		}
	}

	function check_custom_fields($value_array)
	{
		foreach ($value_array as $key => $value)
		{
			if (stristr($key, 'custom_box_'))
			{
				$custom_box_id = intval(str_replace('custom_box_', '', $key));
				$custom_box_id = intval(str_replace('[]', '', $custom_box_id));

				$custom_box_array[] = $custom_box_id;
			}

			$custom_box_ids = @implode(',', $custom_box_array);
		}
		
		$main_category_id = $this->main_category($value_array['category_id']);
		$addl_category_id = $this->main_category($value_array['addl_category_id']);

		if (count($custom_box_ids))
		{
			## standard boxes - ISSUE WITH CHECKING CHECKBOX FIELDS
//			OR (t.box_type IN ('radio', 'checkbox') AND  f.category_id IN (0, " . $main_category_id . ", " . $addl_category_id . "))) AND
			$sql_select_custom_boxes = $this->query("
				SELECT
					b.box_id, f.field_name, b.box_name, b.mandatory, b.formchecker_functions, t.box_type
				FROM
					" . DB_PREFIX . "custom_fields f,
					" . DB_PREFIX . "custom_fields_boxes b,
					" . DB_PREFIX . "custom_fields_types t
				WHERE
					f.field_id = b.field_id AND (b.box_id IN (" . $custom_box_ids . ") 
					AND  f.category_id IN (0, " . $main_category_id . ", " . $addl_category_id . ")) AND
					b.box_type=t.type_id AND
					b.box_type!=0 AND b.box_type_special=0");

			while ($custom_box_details = $this->fetch_array($sql_select_custom_boxes))
			{
				$formchecker_functions = trim($custom_box_details['formchecker_functions']);
				(array) $check_methods = explode('|', $formchecker_functions);
				
				if (empty($formchecker_functions) && $custom_box_details['mandatory'])
				{
					$check_methods[] = 'field_empty';
				}

				if ($custom_box_details['box_type'] == 'checkbox')
				{
					if (!in_array('field_checked', $check_methods) && $custom_box_details['mandatory'])
					{
						$check_methods[] = 'field_checked';
					}
					$field_value = $this->implode_array($value_array['custom_box_' . $custom_box_details['box_id']], '', true, '');
				}
				else 
				{
					$field_value = $value_array['custom_box_' . $custom_box_details['box_id']];
				}

				$box_name_field = (!empty($custom_box_details['box_name'])) ? $custom_box_details['box_name'] : $custom_box_details['field_name'];
				$this->check_box($field_value, $box_name_field, $check_methods);
			}
			
			## special boxes - ROUNTINE NOT TESTED
			$sql_select_special_custom_boxes = $this->query("SELECT b.box_id, f.field_name, b.box_name, b.formchecker_functions, t.box_type FROM
				" . DB_PREFIX . "custom_fields f, " . DB_PREFIX . "custom_fields_boxes b,
				" . DB_PREFIX . "custom_fields_types t, " . DB_PREFIX . "custom_fields_special s WHERE
				f.field_id = b.field_id AND b.box_id IN (" . $custom_box_ids . ") AND b.box_type_special=s.type_id AND
				s.box_type=t.type_id AND b.box_type=0 AND b.box_type_special!=0");

			while ($special_box_details = $this->fetch_array($sql_select_special_custom_boxes))
			{
				(array) $check_methods = explode('|', $special_box_details['formchecker_functions']);

				$box_name_field = (!empty($special_box_details['box_name'])) ? $special_box_details['box_name'] : $special_box_details['field_name'];
				$this->check_box($value_array['custom_box_' . $custom_box_details['box_id']], $box_name_field, $check_methods);
			}

		}
	}

	function field_checked($value, $msg)
	{
		if (empty($value))
		{
			$this->error_list[] = array('value' => $value, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function field_empty($value, $msg)
	{
		if (trim($value) == "")
		{
			$this->error_list[] = array('value' => $value, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function pass_confirm($value1, $value2, $msg) {
		if(strcmp($value1,$value2)!=0)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	// check whether input is a string
	function field_string($value, $msg)
	{
		if(!is_string($value))
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	// check whether input is a valid gif or jpg file
	function field_image($value, $msg)
	{
		if(($value=="image/gif")||($value=="image/jpeg")||($value=="image/pjpeg"))
		{
			return true;
		}
		else
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
	}

	// check whether input is a number
	function field_number($value, $msg)
	{
		if(!is_numeric($value) && !empty($value))
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

		// check whether input is a number
	function field_amount($value, $msg)
	{
		if(!is_numeric($value)||$value<0)
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	// check whether input is an integer - not working function - so avoid using it.
	function field_integer($value, $msg)
	{
		$numeric_value = floatval($value);

		if(!is_numeric($value) || !is_int($numeric_value))
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	// check whether input is a float
	function field_float($value, $msg)
	{
		if(!is_float($value))
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	// check whether input is alphabetic
	function field_alpha($value, $msg)
	{
		$pattern = "/^[a-zA-Z0-9 ]+$/";
		if(preg_match($pattern, $value))
		{
			return true;
		}
		else
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
	}

	function invalid_html($value, $msg)
	{
		$pattern = "/(?i)<img.+\.php.+>/";
		if(preg_match($pattern, $value))
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function field_html($value, $msg)
	{
		$value = $this->add_special_chars($value);

		if(strlen($value) == strlen(strip_tags($value))){
			return true;
		}
		else
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
	}

	function field_js($value, $msg)
	{
		$value = $this->add_special_chars($value);

		if(!stristr($value, '<script'))
		{
			return true;
		}
		else
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
	}

	function field_iframes($value, $msg)
	{
		$value = $this->add_special_chars($value);

		if(!stristr($value, '<iframe'))
		{
			return true;
		}
		else
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
	}

	function within_length($value, $msg, $min, $max)
	{
		if((strlen($value)<$min)||(strlen($value)>$max))
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	// check whether input is within a valid numeric range
	function within_range($value, $msg, $min, $max)
	{
		if(!is_numeric($value) || $value < $min || $value > $max)
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	// check whether input is a valid email address
	function is_email_address($value, $msg)
	{
		$pattern = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";
		if(preg_match($pattern, $value))
		{
			return true;
		}
		else
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
	}

	// check whether input is a valid phone number (numbers and . , ( ) - allowed only)
	function is_phone($value, $msg)
	{
		$pattern = "/^[^a-zA-Z]/";
		if(preg_match($pattern, $value))
		{
			return true;
		}
		else
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
	}
	
	// fulltext search for duplicate fields - still need some kind of workaround because short email addresses dont work
	function field_duplicate_fulltext($table_name, $row_name, $value, $msg, $row_name_secondary = null, $value_secondary = null)
	{
		$sql_query = "SELECT count(*) AS is_duplicate FROM " . DB_PREFIX . $table_name ." WHERE
			" . $row_name . "='" . $value . "'";

		//MATCH (" . $row_name . ") AGAINST ('" . $value . "')";

		if ($row_name_secondary)
		{
			$sql_query .= " AND " . $row_name_secondary . "!=" . intval($value_secondary); /* only for INT type fields, they also need to be indexed -> used in case we want to edit a field */
		}

		$is_duplicate = $this->get_sql_field($sql_query, 'is_duplicate');

		if (!$is_duplicate)
		{
			return true;
		}
		else
		{
			$this->error_list[] = array("value" => $value, "msg" => $msg);
			return false;
		}
	}

	function field_smaller($value1, $value2, $msg) { 
		if($value1 >= $value2)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function field_greater($value1, $value2, $msg) {
		if($value1 <= $value2)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function field_equal($value1, $value2, $msg) {
		if($value1 != $value2)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function in_array($value, $array, $msg) {
		if (!in_array($value, $array))
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;			
		}
		else 
		{
			return true;
		}
	}
	
	function field_greater_empty($value1, $value2, $msg) {
		if($value1 <= $value2 && $value1 > 0)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function field_smaller_empty($value1, $value2, $msg) {
		if($value1 > $value2 && $value1 > 0)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function field_quantity($value, $auction_type, $msg) {
		if ($value > 1 && $auction_type != 'dutch')
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function field_greater_equal($value1, $value2, $msg) {
		if($value1 < $value2)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}

	function field_greater_equal_empty($value1, $value2, $msg) {
		if($value1 < $value2 && $value1 > 0)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function field_not_equal($value1, $value2, $msg) {
		if($value1 == $value2)
		{
			$this->error_list[] = array('value' => $pass, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function field_store_reserve($value, $msg)
	{
		if ($value > 0)
		{
			$this->error_list[] = array('value' => $value, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function field_store_buyout($value1, $value2, $msg)
	{
		if ($value1 != $value2)		
		{
			$this->error_list[] = array('value' => $value1, 'msg' => $msg);
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function is_error()
	{
		if (sizeof($this->error_list) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function reset_error_list()
	{
		$this->error_list = array();
	}

	function display_errors()
	{
		(string) $display_output = NULL;

		$display_output = '<blockquote> <p class="contentfont"> '.
			'<b>' . GMSG_FRMCHK_ERRORS . '</b> '.
			'<p class="contentfont">' . GMSG_RESUBMIT_FORM .
			'<ul class=smallfont>';

		foreach ($this->error_list as $error) {
			$display_output .= '<li>' . $error['msg'];
		}

		$display_output .= '</ul></p></p></blockquote>';

		$this->reset_error_list();

		return $display_output;
	}

	function compare_arrays($array1, $array2, $msg) {
		
		if (!is_array($array1))
		{
			$array1 = @explode(',', $array1);
		}

		$invalid = false;
		foreach ($array1 as $value)
		{
			if (!in_array($value, $array2))
			{
				$invalid = true;
			}
		}
		
		if ($invalid)
		{
			$this->error_list[] = array('value' => null, 'msg' => $msg);
			return false;			
		}
		else 
		{
			return true;
		}
	}

}

?>