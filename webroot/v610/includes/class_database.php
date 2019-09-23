<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class db_main
{
	var $setts = array();
	var $layout = array();
	var $nb_queries = 0;
	var $die = true;
	var $query_error = null;
	var $db_prefix = DB_PREFIX; ## for PPB & PPA Integration

	var $display_errors = true; ## by default the sql errors are not displayed; change to true to be displayed (for debugging purposes only)

	var $categories_table = 'categories';
	
	function connect($host, $username, $password)
	{
		$result = @mysql_connect($host, $username, $password);
		
		if (!$result)
		{
			$error = $this->display_error(MSG_ERROR_MYSQL_CONNECT, $this->sql_error());

			if ($this->die)
			{
				die ($error);
			}
			else 
			{
				return false;
			}
		}
		else 
		{
			return true;
		}
		
	}

	function select_db($database)
	{
		$result = @mysql_select_db($database);
			
		if (!$result)
		{
			$error = $this->display_error(MSG_ERROR_MYSQL_SELECT_DB, $this->sql_error($result));

			if ($this->die)
			{
				die ($error);
			}
			else 
			{
				return false;
			}
		}
		else 
		{
			return true;
		}
	}

	function sql_error()
	{
		return @mysql_error();
	}

	function display_error ($error_message, $sql_error = '', $sql_query = '')
	{
		$display_output = '<p style="font-family: arial; font-size: 12px;"><strong>'.MSG_MYSQL_ERROR_OCCURRED.'</strong>'.
			'<ul>'.
			'<li style="font-family: arial; font-size: 12px;">'.$error_message.'</li>'.
			((!empty($sql_error) && $this->display_errors) ? '<li style="font-family: arial; font-size: 12px;"><strong>'.MSG_SQL_ERROR.':</strong> '.$sql_error.'</li>' : '').
			((!empty($sql_query) && $this->display_errors) ? '<li style="font-family: arial; font-size: 12px;"><strong>'.MSG_SQL_QUERY.':</strong> '.$sql_query.'</li>' : '').
			'</ul></p>';
		
		return $display_output;
	}

	function query ($query, $debug_output = false, $die = true)
	{
		if ($debug_output)
		{
			(string) $explain_output = null;
			
			$explain_result = @mysql_query("EXPLAIN " . $query);
			
			$explain_output = '<table width="100%" cellpadding="3" cellspacing="2" class="contentfont border"> '.
				'	<tr class="c4"> '.
				'		<td colspan="10">SQL COMMAND</td> '.
				'	</tr> '.
				'	<tr> '.
				'		<td colspan="10">EXPLAIN ' . $query . '</td> '.
				'	</tr> '.
				'	<tr class="c4"> '.
				'		<td>id</td> '.
				'		<td>select_type</td> '.
				'		<td>table</td> '.
				'		<td>type</td> '.
				'		<td>possible_keys</td> '.
				'		<td>key</td> '.
				'		<td>key_len</td> '.
				'		<td>ref</td> '.
				'		<td>rows</td> '.
				'		<td>Extra</td> '.
				'	</tr>';
				'	<tr class="c4"> '.
				'		<td colspan="10"></td> '.
				'	</tr> ';

			if ($explain_result)  
			{
				while ($explain = $this->fetch_array($explain_result))
				{
					$explain_output .= '<tr class="c1"> '.
						'	<td>' . $explain['id'] . '</td> '.
						'	<td>' . $explain['select_type'] . '</td> '.
						'	<td>' . $explain['table'] . '</td> '.
						'	<td>' . $explain['type'] . '</td> '.
						'	<td>' . implode(', ', explode(',', $explain['possible_keys'])) . '</td> '.
						'	<td>' . $explain['key'] . '</td> '.
						'	<td>' . $explain['key_len'] . '</td> '.
						'	<td>' . $explain['ref'] . '</td> '.
						'	<td>' . $explain['rows'] . '</td> '.
						'	<td>' . $explain['Extra'] . '</td> '.
						'</tr>';				
				}
			}
			$explain_output .= '</table>';
			
			echo $explain_output;			
		}

		//echo $query . '<br>'; ## used if we want to display all queries made on a page

		$result = @mysql_query($query);
		
		if (!$result)
		{
			$mysql_error = $this->display_error(MSG_ERROR_MYSQL_QUERY, $this->sql_error($result), $query);
			if ($die)
			{
				die ($mysql_error);
			}
			else 
			{
				$this->query_error = $mysql_error;
				
				return null;
			}
		}
		else 
		{
			return $result;
		}
	}

	function query_silent ($query)
	{
		$result = @mysql_query($query);

		if (!$result) 
		{
			return false;
		}
		else 
		{
			return $result;
		}
	}
	
	function insert_id ()
	{
		return @mysql_insert_id();
	}

	function sql_result ($query_result, $row_id, $field_name)
	{
		$result = @mysql_result($query_result, $row_id, $field_name);

		if ($this->sql_error($result))
		{
			die ($this->display_error(MSG_ERROR_MYSQL_RESULT, $this->sql_error($result)));
		}

		return $result;
	}

	function num_rows ($query_result)
	{
		$result = @mysql_num_rows($query_result);

		if ($this->sql_error($result))
		{
			die ($this->display_error(MSG_ERROR_MYSQL_NUM_ROWS, $this->sql_error($result)));
		}

		return $result;
	}

	function fetch_array ($query_result)
	{
		$result = @mysql_fetch_array($query_result);

		if ($this->sql_error($result))
		{
			die ($this->display_error(MSG_ERROR_MYSQL_FETCH_ARRAY, $this->sql_error($result)));
		}

		return $result;
	}
}

class database extends db_main
{

	function get_sql_field ($query, $field, $null_message = NULL)
	{
		(string) $field_value = NULL;

		$query_result = $this->query($query);

		if ($this->num_rows($query_result))
		{
			$field_value = $this->sql_result($query_result, 0, $field);
		}
		else
		{
			$field_value = $null_message;
		}

		return $field_value;
	}

	function get_sql_number ($query) /* obsolete function */
	{
		$result = $this->query($query);
		$nb_rows = $this->num_rows($result);

		return $nb_rows;
	}

	/**
	 * New function to count the number of rows in a table
	 * very fast but it will need a different set of params
	 * Preferrably get_sql_number wont be used anymore at all.
	 *
	 * To make it more flexible, the WHERE clause will need to be added when
	 * constructing the condition.
	 */
	function count_rows($table_name, $condition = null, $debug = false)
	{
		$query_result = $this->query("SELECT count(*) AS count_rows FROM " . $this->db_prefix . $table_name . " " . $condition, $debug);
		$count_rows = $this->sql_result($query_result, 0, 'count_rows');

		return $count_rows;
	}

	function get_sql_row ($query, $debug = false)
	{
		(array) $row_result = NULL;

		$query_result = $this->query($query, $debug);

		if ($this->num_rows($query_result))
		{
			$row_result = $this->fetch_array($query_result);
		}

		return $row_result;
	}

	function table_fields ($table_name)
	{
		(array) $result = NULL;

		$query_result = $this->query("SHOW COLUMNS FROM " . $table_name);
		while ($row = mysql_fetch_array($query_result)) $result[]=$row[0];

		return $result;
	}

	function implode_array ($values_array = null, $glue = ',', $array_check = true, $default_result = '0')
	{
		(string) $result = $default_result;
		(array) $formatted_array = null;
		
		if ($array_check)
		{
			if (is_array($values_array))
			{
				foreach ($values_array as $value)
				{
					$formatted_array[] = (empty($value)) ? $default_result : $value;
				}				
			}			
		   else 
		   {
		   	$formatted_array[] = $default_result;
		   }
		}
		else 
		{
			$formatted_array = $values_array;
		}
			
		$result = @implode($glue, $formatted_array);

		return $result;
	}

	function rem_special_chars($string)
	{
		$string = @stripslashes($string);
		
		$string = str_ireplace("'","&#039;",$string);
		$string = str_ireplace('"','&quot;',$string);

		return trim($string);
	}

	function rem_special_chars_array ($input_array)
	{
		(array) $output = null;

		if (is_array($input_array))
		{
			foreach ($input_array as $key => $value)
			{
				if (!is_array($value)) $output[$key] = $this->rem_special_chars($value);
				else $output[$key] = $value;
			}
		}

		return $output;
	}

	function add_special_chars($string, $no_quotes = FALSE)
	{
		$pattern = "/(?i)<img.+\.php/";

		$string = str_ireplace("&amp;","&",$string);

		if (!$no_quotes) $string = str_ireplace("&#039;","'",$string);

		$string = str_ireplace('&quot;','"',$string);
		$string = str_ireplace('&lt;','<',$string);
		$string = str_ireplace('&gt;','>',$string);
		$string = str_ireplace('&nbsp;',' ',$string);

		$string = (preg_match($pattern, $string)) ? strip_tags($string, '<br>') : $string;

		return $string;
	}

	// added the check_voucher function here so it can be used by all fees related classes
	function check_voucher($voucher_value, $voucher_type, $use_voucher = false, $user_id = null)
	{
		$output = array('valid' => false, 'voucher_type' =>null, 'display' => null, 'reduction' => 0, 'assigned_fees' => null);

		$sql_select_voucher = $this->query("SELECT * FROM " . $this->db_prefix . "vouchers WHERE
			voucher_code='" . $voucher_value . "' AND voucher_type='" . $voucher_type . "' AND
			(exp_date=0 OR exp_date>=" . CURRENT_TIME . ") AND (uses_left>0 OR nb_uses=0) 
			" . (($user_id) ? " AND user_id='" . $user_id . "' " : '') . "
			LIMIT 0,1");

		$is_voucher = $this->num_rows($sql_select_voucher);

		if ($is_voucher)
		{
			$voucher_details = $this->fetch_array($sql_select_voucher);

			$output['valid'] = true;
			$output['display'] = '<table cellpadding="3" width="100%" class="errormessage"><tr><td>' . GMSG_VOUCHER_VALID . '</td></tr></table>';
			$output['reduction'] = $voucher_details['voucher_reduction'];
			$output['assigned_fees'] = $voucher_details['assigned_fees'];
			$output['voucher_type'] = $voucher_details['voucher_type'];

			if ($voucher_details['nb_uses'] > 0 && $use_voucher)
			{
				$sql_update_uses_left = $this->query("UPDATE " . $this->db_prefix . "vouchers SET
					uses_left=uses_left-1 WHERE voucher_id=" . $voucher_details['voucher_id']);
			}
		}
		else
		{
			$output['display'] = '<table cellpadding="3" width="100%" class="errormessage"><tr><td class=redfont>' . GMSG_VOUCHER_INVALID . '</td></tr></table>';
		}

		return $output;
	}

	function main_category($category_id)
	{
		(int) $result = 0;

		if ($category_id > 0)
		{
			$main_category = $category_id;
			while ($main_category > 0)
			{
				$result = $main_category;
				$main_category = $this->get_sql_field("SELECT parent_id FROM " . $this->db_prefix . $this->categories_table . " WHERE
					category_id='" . $main_category . "'", 'parent_id');
			}
		}

		return $result;
	}

	function random_rows($table_name, $table_fields, $condition, $nb_rows, $debug = false)
	{
		(array) $random_numbers = null;
		(array) $primary_fields_array = null;
		(array) $result = null;
		(int) $counter = 0;

		$table_rows = $this->count_rows($table_name, $condition);
		//$table_rows = ($table_rows > 100) ? 100 :$table_rows;

		$total_rows = ($table_rows > $nb_rows) ? $nb_rows : $table_rows;

		while ($counter < $total_rows)
		{
			$number = rand(0, ($table_rows-1));

			if (!@in_array($number, $random_numbers))
			{
				$random_numbers[] = $number;
				$counter++;
			}
		}

		if (is_array($random_numbers))
		{
			foreach ($random_numbers as $value)
			{
				$result[] = $this->get_sql_row("SELECT " . $table_fields . " FROM
					" . $this->db_prefix . $table_name . " " . $condition . " LIMIT " . $value . ", 1", $debug);
			}
		}

		return $result;
	}
	
	function array_add_quotes($input_array)
	{
		$output_array = array();
		
		foreach ($input_array as $key => $value)
		{
			$output_array[$key] = "'" . $value . "'";
		}
		
		return $output_array;
	}
}
?>