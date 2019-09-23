<?
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

define('GMSG_MAIL_FROM_ADMIN', $setts['email_admin_title']);
define('ADDL_PIN_CODE', 'ENTER_CODE');

define ('GUNPAL_HASH', 'GP_HASH_MODIFIABLE');

function header_redirect ($redirect_url, $force_redirect = false)
{
	global $setts;
	
	if (!$force_redirect)
	{
		$redirect_url = ((stristr($redirect_url, 'http://') || stristr($redirect_url, 'https://') || stristr($redirect_url, 'ftp://')) && 
			!stristr($redirect_url, $setts['site_path_ssl']) && !stristr($redirect_url, $setts['site_path'])) ? 'index.php' : $redirect_url;
	}
	
	echo "<script>window.location.replace('" . $redirect_url . "');</script>";
}

function check_pin ($pin_generated, $pin_submitted)
{
	return (substr(md5($pin_generated . ADDL_PIN_CODE),15,8) == $pin_submitted) ? TRUE : FALSE;
}

function generate_pin ($pin_submitted)
{
	return substr(md5($pin_submitted . ADDL_PIN_CODE),15,8);
}

function show_pin_image ($full_pin, $generated_pin, $image_url = '')
{
  	## create an image not a text for the pin
	$font  = 6;
	$width  = ImageFontWidth($font) * strlen($generated_pin);
	$height = ImageFontHeight($font);

	$im = @imagecreate ($width,$height);
	$background_color = imagecolorallocate ($im, 219, 239, 249); //cell background
	$text_color = imagecolorallocate ($im, 0, 0,0);//text color
	imagestring ($im, $font, 0, 0,  $generated_pin, $text_color);
	touch($image_url . 'uplimg/site_pin_' . $full_pin . '.jpg');
	imagejpeg($im, $image_url . 'uplimg/site_pin_' . $full_pin . '.jpg');

	$image_output = '<img src="' . $image_url . 'uplimg/site_pin_' . $full_pin . '.jpg">';

	imagedestroy($im);

	return $image_output;
}

function unlink_pin()
{
	global $session;

	$path = (IN_ADMIN == 1) ? '../' : '';

	if ($session->is_set('pin_value'))
	{
		@unlink($path.'uplimg/site_pin_'.$session->value('pin_value').'.jpg');
		$session->unregister('pin_value');
	}

	if ($session->is_set('admin_pin_value'))
	{
		@unlink($path.'uplimg/site_pin_'.$session->value('admin_pin_value').'.jpg');
		$session->unregister('admin_pin_value');
	}
}

function normalize($string) {
   global $db;
   
    $ext = array(192, 193, 194, 195, 196, 197, 224, 225, 226, 227, 228, 229, 199, 231, 200, 201, 202, 203, 232, 
        233, 234, 235, 204, 205, 206, 207, 236, 237, 238, 239, 210, 211, 212, 213, 214, 216, 242, 243, 244, 245, 
        246, 248, 209, 241, 217, 218, 219, 220, 249, 250, 251, 252, 221, 255, 253);

    $norm = array(65, 65, 65, 65, 65, 65, 97, 97, 97, 97, 97, 97, 67, 99, 69, 69, 69, 69, 101, 101, 101, 101, 73, 
        73, 73, 73, 105, 105, 105, 105, 79, 79, 79, 79, 79, 79, 111, 111, 111, 111, 111, 111, 78, 110, 85, 85, 
        85, 85, 117, 117, 117, 117, 89, 121, 121);

    $string = $db->add_special_chars($string);
    $string = utf8ToUnicode($string);
    // Using array insersect is slower
    if (is_array($string))
    {
       foreach ($ext as $k => $e) {
           if ($pos = array_search($e, $string)) {
               $string[$pos] = $norm[$k];
           }
       }
       $string = unicodeToUtf8($string);
    }
    return $string;
}



function post_slug($str)
{
   return strtolower(preg_replace(array('/[^a-zA-Z0-9_ -]/', '/[ -]+/', '/^-|-$/'),
      array('', '-', ''), $str));
} 

function sanitize_var($value)
{
	if (!is_numeric($value))
	{
		$value = post_slug($value);

		$value = str_replace('amp','and',$value);
		$value = str_replace('quot','',$value);
		$value = str_replace('039','',$value);
		$value = str_replace(' ','-',$value);
	}

	return $value;
}

function process_link($base_url, $var_array = NULL, $overwrite_amp = false)
{
	global $setts;
	
	$ssl_url_simple = array('login', 'register');
	$ssl_url_enhanced = array('login', 'register', 'members_area', 'fee_payment');
	
	$amp = ($overwrite_amp) ? '_AND_' : '&amp;';
	
	$ssl_url_array = ($setts['enable_enhanced_ssl']) ? $ssl_url_enhanced : $ssl_url_simple;

	(string) $output = NULL;

	$path = ($setts['is_ssl']==1 && (in_array($base_url, $ssl_url_array))) ? $setts['site_path_ssl'] : $setts['site_path'];

	if ($setts['is_mod_rewrite'] && $var_array)
	{
		if ($var_array)
		{
			while(list($key, $value) = each($var_array))
			{
				$sanitized_value = sanitize_var($value);
				$output .= $sanitized_value.','.$key.',';
			}
		}
		$output .= $base_url;
	}
	else
	{
		$output = $base_url.'.php';
		if ($var_array)
		{
			$output .= '?';
			while(list($key, $value) = each($var_array))
			{
				$sanitized_value = sanitize_var($value);
				$output .= $key . '=' . $sanitized_value . $amp;
			}
			$output = substr($output,0,((-1) * strlen($amp)));
		}
	}

	return $path . $output;
}

function category_navigator ($parent_id, $show_links = true, $show_category = true, $page_link = null, $additional_vars = null, $none_msg = null, $reverse_categories = false)
{
	global $reverse_categoy_lang, $category_lang, $db;

	(string) $display_output = NULL;
	(int) $counter = 0;

	$none_msg = ($none_msg) ? $none_msg : GMSG_ALL_CATEGORIES;
	
	$page_link = ($page_link) ? $page_link : $_SERVER['PHP_SELF'];
	if($parent_id > 0)
	{
		$root_id = $parent_id;
		while ($root_id > 0)
		{
			$row_category = $db->get_sql_row("SELECT category_id, name, parent_id FROM 
				" . DB_PREFIX . (($reverse_categories) ? 'reverse_categories' : 'categories') . " WHERE 
				category_id=" . $root_id . " LIMIT 0,1");

			if($counter == 0)
			{
				$display_output = ($reverse_categories) ? $reverse_category_lang[$row_category['category_id']] : $category_lang[$row_category['category_id']];
				$display_output = (!empty($display_output)) ? $display_output : $row_category['name'];
			}
			else if($parent_id != $root_id)
			{
				$category_name = ($reverse_categories) ? $reverse_category_lang[$row_category['category_id']] : $category_lang[$row_category['category_id']];
				$category_name = (!empty($category_name)) ? $category_name : $row_category['name'];
				
				$display_output = (($show_links) ? '<a href="' . $page_link . '?parent_id=' . $row_category['category_id'] . '&name=' . sanitize_var($category_name) . ((!empty($additional_vars)) ? ('&' . $additional_vars) : '') . '">' : '') . $category_name . (($show_links) ? '</a>' : '') . ' > ' . $display_output;
			}
			$counter++;
			$root_id = $row_category['parent_id'];
		}
		$display_output = (($show_links && $show_category) ? '<a href="' . $page_link . '?' . $additional_vars . '"><b> ' . GMSG_CATEGORY . ':</b></a> ' : '') . $display_output;
	}

	$display_output = (empty($display_output)) ? $none_msg : $display_output;

	return $display_output;
}

function http_post($server, $port, $url, $vars)
{
	// get urlencoded vesion of $vars array
	(string) $urlencoded = null;

	foreach ($vars as $index => $value)
	{
		$urlencoded .= urlencode($index ) . '=' . urlencode($value) . '&';
	}

	$urlencoded = substr($urlencoded,0,-1);

	$headers = "POST " . $url . " HTTP/1.0\r\n" .
		"Content-Type: application/x-www-form-urlencoded\r\n" .
		"Content-Length: " . strlen($urlencoded) . "\r\n\r\n";

	$fp = fsockopen($server, $port, $errno, $errstr, 10);
	if ($log)
	{
		if (!$fp) fputs($fh,"ERROR: fsockopen failed.\r\nError no: " . $errno . " - " . $errstr . "\n");
		else fputs($fh,"Fsockopen success.\n");
	}

	fputs($fp, $headers);
	fputs($fp, $urlencoded);

	$ret = "";
	while (!feof($fp)) $ret .= fgets($fp, 1024);

	fclose($fp);
	return $ret;
}

function paginate($start,$limit,$total,$file_path,$other_params)
{
	(string) $display_output = null;

	$all_pages = ceil($total / $limit);

	$current_page = floor($start / $limit) + 1;

	if ($all_pages > 10)
	{
		$max_pages = ($all_pages > 9) ? 9 : $all_pages;

		if ($all_pages > 9)
		{
			if ($current_page >= 1 && $current_page <= $all_pages)
			{
				$display_output .= ($current_page > 4) ? ' ... ' : ' ';

				$min_pages = ($current_page > 4) ? $current_page : 5;
				$max_pages = ($current_page < $all_pages - 4) ? $current_page : $all_pages - 4;

				for($i=$min_pages - 4; $i<$max_pages + 5; $i++)
				{
					$display_output .= display_link($file_path . '?start=' . (($i - 1) * $limit) . $other_params, $i, (($i == $current_page) ? false : true));
				}
				$display_output .= ($current_page < $all_pages - 4) ? ' ... ' : ' ';
			}
			else
			{
				$display_output .= ' ... ';
			}
		}
	}
	else
	{
		for($i=1; $i<$all_pages + 1; $i++)
		{
			$display_output .= display_link($file_path . '?start=' . (($i - 1) * $limit) . $other_params, $i, (($i == $current_page) ? false : true));
		}
	}

	if ($current_page > 1)
	{
		$display_output = '[<a href="' . $file_path . '?start=0' . $other_params . '">&lt;&lt;</a>] '.
			'[<a href="' . $file_path . '?start=' . (($current_page - 2) * $limit) . $other_params . '">&lt;</a>] ' . $display_output;
	}

	if ($current_page < $all_pages)
	{
		$display_output .= ' [<a href="' . $file_path . '?start=' . ($current_page * $limit) . $other_params . '">&gt;</a>] '.
			'[<a href="' . $file_path . '?start=' . (($all_pages - 1) * $limit) . $other_params . '">&gt;&gt;</a>]';
	}

	return $display_output;
}

function page_order($file_path, $order_field, $start, $limit, $other_params, $field_name = null)
{
	(string) $display_output = null;

	$file_extension = (IN_ADMIN == 1) ? '../' : '';
	$alt = false;
	
	if ($alt)
	{
		$alt_ascending = 'alt="' . $field_name . ' ' . GMSG_ASCENDING . '"';
		$alt_descending = 'alt="' . $field_name . ' ' . GMSG_DESCENDING . '"';
	}
	else 
	{
		$alt_ascending = null;
		$alt_descending = null;
	}
	
	$display_output = '<a href="' . $file_path . '?start=' . $start . '&limit=' . $limit . $other_params . '
		&order_field=' . $order_field . '&order_type=ASC">'.
		'<img src="' . $file_extension . 'images/s_asc.png" align="absmiddle" border="0" ' . $alt_ascending . '></a>'.
		'<a href="' . $file_path . '?start=' . $start . '&limit=' . $limit . $other_params . '
		&order_field=' . $order_field . '&order_type=DESC">'.
		'<img src="' . $file_extension . 'images/s_desc.png" align="absmiddle" border="0" ' . $alt_descending . '></a>';

	return $display_output;
}

function field_display($field_value, $output_false = '-', $output_true = null)
{
	(string) $display_output = null;

	$display_output = ($field_value) ? (($output_true) ? $output_true : $field_value) : $output_false;

	return $display_output;
}

function display_pagination_results ($start, $limit, $total)
{
	(string) $display_output = null;

	$end = ($start + $limit > $total) ? $total : ($start + $limit);

	if ($total)
	{
		$start++;
	}

	$display_output = GMSG_DISPLAYING_RESULTS . ' <b>' . $start . ' - ' . $end . '</b> ' . GMSG_FROM_LOW. ' <b>' . $total . '</b>';

	return $display_output;
}

function display_link ($link_url, $link_message, $active = true)
{
	(string) $display_output = null;

	$display_output = ($active) ? '<a href="' . $link_url . '">' : '[ ';
	$display_output .= $link_message;
	$display_output .= ($active) ? '</a> ' : ' ] ';

	return $display_output;
}

function remove_spaces($input_variable)
{
	$output_variable = str_replace(' ', '', $input_variable);

	return $output_variable;
}

/**
 * PHP Pro Bid functions start here!
 */

function list_skins($location = 'site', $drop_down = false, $selected_skin = null, $display_none = false, $dd_multiple = false)
{
	(array) $output = null;
	(string) $display_output = null;

	$relative_path = ($location == 'site') ? '' : '../';

	$handle = opendir($relative_path . 'themes');

	while ($file = readdir($handle))
	{
		if (!stristr($file, '.'))
		{
			$output[] = $file;
		}
	}

	closedir($handle);

	/**
	 * this is an enhancement of the function, to create a drop down menu to select the skin
	 * in the admin area
	 */

	if ($drop_down)
	{
		$display_output = '<select name="default_theme' . (($dd_multiple) ? '[]' : '') . '"> ';

		if ($display_none)
		{
			$display_output .= '<option value="" selected>' . GMSG_DEFAULT . '</option> ';			
		}

		foreach ($output as $value)
		{
			$display_output .= '<option value="' . $value . '" ' . (($value == $selected_skin) ? 'selected' : '') . '>' . $value . '</option> ';
		}

		$display_output .= '</select>';
	}
	return ($drop_down) ? $display_output : $output;
}

function list_languages($location = 'site', $drop_down = false, $selected_language = null, $show_flags = false)
{
	global $db, $setts;
	(array) $output = null;
	(array) $language_flags = null;
	(string) $display_output = null;


	$relative_path = ($location == 'site') ? '' : '../';

	$handle = opendir($relative_path . 'language');

	while ($file = readdir($handle))
	{
		if (!stristr($file, '.'))
		{
			$output[] = $file;
		}
	}

	closedir($handle);

	/**
	 * this is an enhancement of the function, to create a drop down menu to select the language
	 * in the admin area
	 */

	if ($drop_down)
	{
		$display_output = '<select name="language"> ';

		foreach ($output as $value)
		{
			$display_output .= '<option value="' . $value . '" ' . (($value == $selected_language) ? 'selected' : '') . '>' . $value . '</option> ';
		}

		$display_output .= '</select>';
	}
	else if ($show_flags)
	{
		if ($setts['user_lang'])
		{
			foreach ($output as $value)
			{
				$language_flags[] = '<a href="' . process_link('index', array('change_language' => $value)) . '"><img src="themes/' . $setts['default_theme'] . '/img/' . $value . '.gif" border="0" alt="' . $value . '" align="middle"></a>';
			}

			$display_output = $db->implode_array($language_flags, ' &nbsp; ');
		}
	}
	return ($drop_down || $show_flags) ? $display_output : $output;
}

function timezones_drop_down($selected_value = null)
{
	global $db, $setts;

	(string) $display_output = null;

	$selected_value = (!empty($selected_value)) ? $selected_value : 0;

	$display_output = '<select name="time_zone"> ';

	$sql_select_timezones = $db->query("SELECT value, caption FROM
		" . DB_PREFIX . "timesettings");

	while ($time_zone = $db->fetch_array($sql_select_timezones))
	{
		$display_output .= '<option value="' . $time_zone['value'] . '" ' . (($time_zone['value'] == $selected_value) ? 'selected' : '') . '>' . $time_zone['caption'] . '</option> ';
	}

	$display_output .= '</select>';

	return $display_output;
}

## this function will be used to save email and language files in admin
function save_file($file_name, $file_content)
{
	global $db;

	(string) $display_output = null;

	$file_content = $db->add_special_chars($file_content);

	if (is_writable($file_name))
	{
		$fp = fopen($file_name, 'w');

		if (!$fp)
		{
			$display_output = GMSG_CANNOT_OPEN_FILE . ' [ ' . $file_name . ' ]';
		}
		else if (!fwrite($fp, $file_content))
		{
			$display_output = GMSG_FILE_NOT_EDITABLE . ' [ ' . $file_name . ' ]';
		}
		else
		{
			$display_output = GMSG_FILE_UPDATED . ' [ ' . $file_name . ' ]';
		}

		fclose($fp);
	}
	else
	{
		$display_output = GMSG_FILE_NOT_WRITABLE . ' [ ' . $file_name . ' ]';
	}

	return $display_output;
}


function categories_list ($selected_category_id, $category_id = 0, $custom_fees = true, $show_reverse = false, $show_list = true)
{
	global $db;

	(string) $display_output = null;

	$addl_query = ($custom_fees) ? " AND custom_fees=1" : '';

	$sql_select_categories = $db->query("SELECT category_id, name FROM " . DB_PREFIX . "categories WHERE
		parent_id=0 AND user_id=0" . $addl_query);

	$nb_categories = $db->num_rows($sql_select_categories);

	$display_output = '<select name="category_id"> '.
		'<option value="0" selected>' . (($custom_fees) ? GMSG_DEFAULT : GMSG_ALL_CATEGORIES) . '</option> ';

	$display_output .= ($nb_categories) ? '<option value="0">' . GMSG_LIST_SEPARATOR . '</option>' : '';

	$cnt = 0;
	while ($category_details = $db->fetch_array($sql_select_categories))
	{
		$display_output .= '<option value="' . $category_details['category_id'] . '" ' . (($category_details['category_id'] == $selected_category_id) ? 'selected' : '') . '>' . $category_details['name'] . '</option>';
		$cnt ++;
	}

	if ($show_reverse)
	{
		$sql_select_categories = $db->query("SELECT category_id, name FROM " . DB_PREFIX . "reverse_categories WHERE
			parent_id=0" . $addl_query);
	
		$nb_categories = $db->num_rows($sql_select_categories);
	
		$display_output .= ($nb_categories) ? '<option value="0">' . GMSG_LIST_SEPARATOR . '</option>' : '';
			
		while ($category_details = $db->fetch_array($sql_select_categories))
		{
			$display_output .= '<option value="reverse|' . $category_details['category_id'] . '" ' . (($category_details['category_id'] == (-1) * $selected_category_id) ? 'selected' : '') . '>' . $category_details['name'] . '</option>';
			$cnt ++;
		}
		
	}
	
	$display_output .= '</select>';

	return ($show_list) ? $display_output : $cnt;
}

function voucher_form ($voucher_type, $voucher_value = null, $new_table = true)
{
	global $db;
	(string) $display_output = null;

	$is_voucher = $db->count_rows('vouchers', "WHERE voucher_type='" . $voucher_type . "' AND
		(exp_date=0 OR exp_date>" . CURRENT_TIME . ") AND (uses_left>0 OR nb_uses=0)");

	if ($is_voucher)
	{
		$display_output = ($new_table) ? '<br><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">' : '';
		$display_output .=	'	<tr> '.
         '		<td colspan="2" class="c3">' . GMSG_VOUCHER_SETTINGS . '</td> '.
      	'	</tr> '.
      	'	<tr class="c5"> '.
         '		<td><img src="themes/' . $db->setts['default_theme'] . '/img/pixel.gif" width="1" height="1" /></td> '.
         '		<td><img src="themes/' . $db->setts['default_theme'] . '/img/pixel.gif" width="1" height="1" /></td> '.
      	'	</tr> '.
      	'	<tr class="c1"> '.
         '		<td width="150" align="right" class="contentfont">' . GMSG_VOUCHER_CODE . '</td> '.
         '		<td><input name="voucher_value" type="text" class="contentfont" id="voucher_value" value="' . $voucher_value . '" size="40" /></td> '.
      	'	</tr> '.
      	'	<tr class="reguser"> '.
         '		<td align="right" class="contentfont">&nbsp;</td> '.
         '		<td>' . GMSG_VOUCHER_CODE_EXPL . '</td> '.
      	'	</tr> ';
   	$display_output .= ($new_table) ? '</table>' : '';
	}

	return $display_output;
}

function terms_box ($terms_type, $selected_value)
{
	global $db;
	(string) $display_output = null;

	if ($terms_type == 'registration')
	{
		$new_table = true;
		$colspan = 2;
		$terms = array('enabled' => $db->layout['enable_reg_terms'], 'content' => $db->layout['reg_terms_content']);
		$agreement_msg = '<input type="checkbox" name="agree_terms" value="1" ' . (($selected_value) ? 'checked' : '') . '>' . GMSG_CLICK_TO_AGREE_TO_TERMS;
	}
	else if ($terms_type == 'auction_setup')
	{
		$new_table = false;
		$colspan = 3;
		$terms = array('enabled' => $db->layout['enable_auct_terms'], 'content' => $db->layout['auct_terms_content']);
		$agreement_msg = GMSG_AUCT_TERMS_AGREEMENT_EXPL;
	}

	if ($terms['enabled'])
	{
		if ($new_table)
		{
			$display_output = '<br><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border"> ';
		}

      $display_output .= '	<tr> '.
         '		<td colspan="' . $colspan . '" class="c3">' . GMSG_TERMS_AND_CONDITIONS . '</td> '.
      	'	</tr> '.
      	'	<tr class="c5"> '.
         '		<td><img src="themes/' . $db->setts['default_theme'] . '/img/pixel.gif" width="1" height="1" /></td> '.
         '		<td colspan="' . ($colspan-1) . '"><img src="themes/' . $db->setts['default_theme'] . '/img/pixel.gif" width="1" height="1" /></td> '.
      	'	</tr> '.
      	'	<tr class="c1"> '.
         '		<td width="150" align="right" class="contentfont"></td> '.
         '		<td colspan="' . ($colspan-1) . '"><textarea name="terms_content" cols="50" rows="8" readonly class="smallfont" style="width: 100%; height: 200px;" />' . str_ireplace('<br>', "\n", $terms['content']) . '</textarea></td> '.
      	'	</tr> '.
      	'	<tr class="reguser"> '.
         '		<td align="right" class="contentfont">&nbsp;</td> '.
         '		<td colspan="' . ($colspan-1) . '">' . $agreement_msg . '</td> '.
      	'	</tr> ';
      if ($new_table)
      {
      	$display_output .='</table>';
      }
	}

	return $display_output;
}

function title_resize($text, $max_length = 15, $fulltext = false)
{
	global $db;
	(string) $display_output = null;

	$text = $db->add_special_chars($text);
	
	if ($fulltext)
	{
		$output = (strlen($text) > $max_length) ? substr($text, 0, $max_length - 3) . '... '  : $text;
	}
	else 
	{
		$text_words = explode(' ', $text);
	
		$nb_words = count($text_words);
	
		for ($i=0; $i<$nb_words; $i++)
		{
			$display_output[] = (strlen($text_words[$i]) > $max_length) ? substr($text_words[$i], 0, $max_length-3) . '... ' : $text_words[$i];
		}
		
		$output = $db->implode_array($display_output, ' ', true, '');
	}

	return $output;
}

function online_users($in_admin = false)
{
	$data_file = (($in_admin) ? '../' : '') . 'online_users.txt';

	$session_time = 60; //time in **minutes** to consider someone online before removing them

	if(!file_exists($data_file))
	{
		$fp = fopen($data_file, 'w+');
		fclose($fp);
	}

	$ip = $_SERVER['REMOTE_ADDR'];
	$users = array();
	$online_users = array();

	//get users part
	$fp = fopen($data_file, 'r');
	flock($fp, LOCK_SH);

	while(!feof($fp))
	{
		$users[] = rtrim(fgets($fp, 32));
	}

	flock($fp, LOCK_UN);
	fclose($fp);


	//cleanup part
	$x = 0;
	$already_in = false;

	foreach($users as $key => $data)
	{
		list( , $last_visit) = explode('|', $data);

		if(CURRENT_TIME - $last_visit >= $session_time * 60)
		{
			$users[$x] = '';
		}
		else
		{
			if(strpos($data, $ip) !== false)
			{
				$already_in = true;
				$users[$x] = $ip . '|' . time(); //update record
			}
		}
		$x++;
	}

	if($already_in == false)
	{
		$users[] = $ip . '|' . time();
	}

	//write file
	$fp = fopen($data_file, 'w+');
	flock($fp, LOCK_EX);

	$nb_users = 0;
	foreach($users as $user)
	{
		if(!empty($user))
		{
			fwrite($fp, $user . "\r\n");
			$nb_users++;
		}
	}
	flock($fp, LOCK_UN);
	fclose($fp);

	if ($in_admin)
	{
		$nb_users--;
		$nb_users = ($nb_users < 0) ? 0 : $nb_users;
	}
	
	return $nb_users;
}

function verified_bidder($user_id)
{
	global $db, $setts;
	
	$output = true;
	if ($setts['enable_bidder_verification'] && $setts['bidder_verification_mandatory'] && $user_id)
	{
		$verified_bidder = $db->get_sql_field("SELECT bidder_verified FROM " . DB_PREFIX . "users 
			WHERE user_id='" . $user_id . "'", 'bidder_verified');
		
		$output = ($verified_bidder) ? true : false;
	}
	
	return $output;
}
function blocked_user ($user_id, $owner_id, $block_type = 'bid')
{
	global $db;

	$addl_query = null;
	switch ($block_type)
	{
		case 'message':
			$addl_query = ' AND block_message=1';
			break;
		case 'reputation':
			$addl_query = ' AND block_reputation=1';
			break;
		default:
			$addl_query = ' AND block_bid=1';
			break;
			
	}
	$is_blocked = $db->count_rows('blocked_users', "WHERE
		user_id='" . intval($user_id) . "' AND owner_id='" . intval($owner_id) . "' " . $addl_query);

	$is_blocked = (verified_bidder($user_id)) ? $is_blocked : true;
	
	$output = ($is_blocked) ? true : false;

	return $output;
}

function block_reason ($user_id, $owner_id, $block_type = 'bid')
{
	global $db;

	$block_msg = null;
	switch ($block_type)
	{
		case 'message':
			$block_msg = MSG_BLOCKED_USER_MESSAGE_MSG;
			break;
		case 'reputation':
			$block_msg = MSG_BLOCKED_USER_REPUTATION_MSG;
			break;
		default:
			$block_msg = MSG_BLOCKED_USER_MSG;
			break;
			
	}
	
	if (!verified_bidder($user_id))
	{
		$block_message .= '<p class="errormessage contentfont">' . MSG_YOU_MUST_BE_A_VERIFIED_BIDDER_TO_BID . '</p>';
	}
	else 
	{
	   $block_details = $db->get_sql_row("SELECT b.*, u.username FROM " . DB_PREFIX . "blocked_users b
		   LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=b.user_id WHERE
		   b.user_id='" . $user_id . "' AND b.owner_id='" . $owner_id . "'");
   
	   $block_message = '<p class="errormessage">' . $block_msg .
		   (($block_details['show_reason']) ? '<br><b>' . MSG_REASON .'</b>: ' . $block_details['block_reason'] : '') . '</p>';
	}

	return $block_message;
}

function block_type ($block_details)
{
	if ($block_details['block_bid'])
	{
		$output[] = MSG_BIDDING;
	}
	if ($block_details['block_message'])
	{
		$output[] = MSG_MESSAGING;
	}
	if ($block_details['block_reputation'])
	{
		$output[] = MSG_REPUTATION;
	}
	
	return $output;
}

function check_banned ($banned_address, $address_type)
{
	global $db;
	$output = array('result' => false, 'display' => null);

	$is_banned = $db->count_rows('banned', "WHERE banned_address='" . $banned_address . "' AND address_type='" . $address_type . "'");

	if ($is_banned)
	{
		$output['result'] = true;

		$output['display'] = '<p class="errormessage" align="center">' . MSG_BANNED_EXPL_A . ' <b>'.
			(($address_type == 1) ? MSG_IP_ADDRESS : MSG_EMAIL_ADDRESS) . '</b> ' . MSG_BANNED_EXPL_B . '</p>';
	}

	return $output;
}

function meta_tags ($base_url, $parent_id, $auction_id, $wanted_ad_id, $shop_id)
{
	global $db, $category_lang, $setts, $reverse_category_lang;
	(array) $output = null;
	(array) $subcats_array = null;

	if (stristr($base_url, 'auction_details.php'))
	{
		$item_details = $db->get_sql_row("SELECT auction_id, name, end_time, category_id FROM " . DB_PREFIX . "auctions WHERE
			auction_id='" . $auction_id . "'");

		$parent_id = $item_details['category_id'];
	}
	else if (stristr($base_url, 'wanted_details.php'))
	{
		$item_details = $db->get_sql_row("SELECT wanted_ad_id, name, end_time, category_id FROM " . DB_PREFIX . "wanted_ads WHERE
			wanted_ad_id='" . $wanted_ad_id . "'");

		$parent_id = $item_details['category_id'];
	}

	if($parent_id > 0)
	{
		$root_id = $parent_id;
		while ($root_id > 0)
		{
			$row_category = $db->get_sql_row("SELECT category_id, parent_id 
				FROM " . DB_PREFIX . ((stristr($base_url, 'reverse_auctions.php')) ? 'reverse_categories' : 'categories') . " 
				WHERE category_id=" . $root_id . " LIMIT 0,1");
			
			if (stristr($base_url, 'reverse_auctions.php'))
			{
				$subcats_array[] = $reverse_category_lang[$row_category['category_id']];
			}
			else 
			{
				$subcats_array[] = $category_lang[$row_category['category_id']];
			}

			$root_id = $row_category['parent_id'];
		}

		$subcats_array = array_reverse($subcats_array);
	}

	/* now generate the title and meta tags */
	if (stristr($base_url, 'auction_details.php'))
	{
		$output['title'] = $db->add_special_chars($item_details['name']) . ' (' . MSG_AUCTION_ID . ': ' . $item_details['auction_id'] . ', ' .
			GMSG_END_TIME . ': ' . show_date($item_details['end_time']) . ') - ' . $setts['sitename'];

		$output['meta_tags'] = '<meta name="description" content="' . MSG_MTT_FIND . ' ' . $db->add_special_chars($item_details['name']) . ' ' .
			MSG_MTT_IN_THE . ' ' . $db->add_special_chars($db->implode_array($subcats_array, ' - ')) . ' ' . MSG_MTT_CATEGORY_ON . ' ' . $setts['sitename'] . '"> '.
			'<meta name="keywords" content="' . $db->add_special_chars($item_details['name']) . ', ' . $db->add_special_chars($db->implode_array($subcats_array, ', ')) . ', ' .
			$setts['sitename'] . '"> ';
	}
	else if (stristr($base_url, 'wanted_details.php'))
	{
		$output['title'] = $db->add_special_chars($item_details['name']) . ' (' . MSG_WANTED_AD_ID . ': ' . $item_details['wanted_ad_id'] . ', ' .
			GMSG_END_TIME . ': ' . show_date($item_details['end_time']) . ') - ' . $setts['sitename'];

		$output['meta_tags'] = '<meta name="description" content="' . MSG_MTT_FIND . ' ' . $db->add_special_chars($item_details['name']) . ' ' .
			MSG_MTT_IN_THE . ' ' . $db->add_special_chars($db->implode_array($subcats_array, ' - ')) . ' ' . MSG_MTT_CATEGORY_ON . ' ' . $setts['sitename'] . '"> '.
			'<meta name="keywords" content="' . $db->add_special_chars($item_details['name']) . ', ' . $db->add_special_chars($db->implode_array($subcats_array, ', ')) . ', ' .
			$setts['sitename'] . '"> ';
	}
	else if (stristr($base_url, 'categories.php'))
	{
		$output['title'] = ((is_array($subcats_array)) ? $db->add_special_chars($db->implode_array($subcats_array, ' - ')) . ' - ' : '') . $setts['sitename'];

		$main_category_id = $db->main_category($parent_id);
		$category_details = $db->get_sql_row("SELECT meta_description, meta_keywords FROM " . DB_PREFIX . "categories WHERE
			category_id='" . $main_category_id . "'");

		if (!empty($category_details['meta_description']) && !empty($category_details['meta_keywords']))
		{
			$output['meta_tags'] = '<meta name="description" content="' . $db->add_special_chars($category_details['meta_description']) . '"> '.
				'<meta name="keywords" content="' . $db->add_special_chars($category_details['meta_keywords']) . '"> ';
		}
		else
		{
			$output['meta_tags'] = $db->add_special_chars($setts['metatags']);
		}
	}
	else if (stristr($base_url, 'reverse_auctions.php'))
	{
		$output['title'] = ((is_array($subcats_array)) ? $db->add_special_chars($db->implode_array($subcats_array, ' - ')) . ' - ' : '') . GMSG_REVERSE_AUCTIONS .  ' - ' . $setts['sitename'];

		$main_category_id = $db->main_category($parent_id);
		$category_details = $db->get_sql_row("SELECT meta_description, meta_keywords FROM " . DB_PREFIX . "reverse_categories WHERE
			category_id='" . $main_category_id . "'");

		if (!empty($category_details['meta_description']) && !empty($category_details['meta_keywords']))
		{
			$output['meta_tags'] = '<meta name="description" content="' . $db->add_special_chars($category_details['meta_description']) . '"> '.
				'<meta name="keywords" content="' . $db->add_special_chars($category_details['meta_keywords']) . '"> ';
		}
		else
		{
			$output['meta_tags'] = $db->add_special_chars($setts['metatags']);
		}
	}
	else
	{
		if (stristr($base_url, 'shop.php'))
		{
			$user_details = $db->get_sql_row("SELECT shop_name, shop_metatags FROM " . DB_PREFIX . "users WHERE 
				user_id='" . intval($shop_id) . "'");
			$output['title'] = $user_details['shop_name'] . ' - ' . $setts['sitename'];			
			
			if (!empty($user_details['shop_metatags']))
			{
				$output['meta_tags'] = '<meta name="description" content="' . $db->add_special_chars($user_details['shop_metatags']) . '"> ';				
			}
		}
		else 
		{
			$output['title'] = $setts['sitename'];		
		}

		if (empty($output['meta_tags']))
		{
			$output['meta_tags'] = $db->add_special_chars($setts['metatags']);
		}
	}

	return $output;
}

function remove_cache_img()
{
	global $fileExtension;
	
	$cache_directory = $fileExtension . 'cache/';
	$time_limit = 60*60*24; ## one day
	
	$cache_dir = opendir($cache_directory);
	
	while ($file = readdir($cache_dir)) 
	{
		if($file != '..' && $file !='.' && $file !='' && $file !='index.htm') 
		{
			$filestats = array();
			$filestats = stat($cache_directory . $file);
			
			if (($filestats[10] + $time_limit) < CURRENT_TIME)
			{
				@unlink($cache_directory . $file);
			}
		}
	}
	
	closedir($cache_dir);
	clearstatcache(); 	
}

function user_pics ($user_id, $reputation_only = false, $reverse = false)
{
	global $db, $setts, $fileExtension;	
	(string) $display_output = null;

	$user_details = $db->get_sql_row("SELECT enable_aboutme_page, shop_active, seller_verified, enable_profile_page, bidder_verified FROM " . DB_PREFIX . "users WHERE user_id='" . $user_id . "'");

	$positive_reputation = $db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND 
		reputation_rate IN (4,5) AND submitted=1 " . (($reverse) ? 'AND reverse_id>0' : ''));
	$negative_reputation = $db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND 
		reputation_rate IN (1,2) AND submitted=1 " . (($reverse) ? 'AND reverse_id>0' : ''));
	
	$reputation_rating = $positive_reputation - $negative_reputation;	
	$link_url = ($reverse) ? 'reverse_profile.php' : 'user_reputation.php';
	$reputation_rating_link = '<span class="contentfont"><a href="' . $fileExtension . $link_url . '?user_id=' . $user_id . '">' . $reputation_rating . '</a></span>';
	
	if ($reputation_rating < 1)
	{
		$display_output = ' (' . $reputation_rating_link . ') ';
	}
	else if ($reputation_rating >= 1 && $reputation_rating < 10) 
	{
		$display_output = ' (' . $reputation_rating_link . ') <img align=absmiddle src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/yellow_star.gif" border="0">';
	}
	else if ($reputation_rating >= 10 && $reputation_rating < 50) 
	{
		$display_output = ' (' . $reputation_rating_link . ') <img align=absmiddle src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/green_star.gif" border="0">';
	}
	else if ($reputation_rating >= 50 && $reputation_rating < 100) 
	{
		$display_output = ' (' . $reputation_rating_link . ') <img align=absmiddle src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/blue_star.gif" border="0">';
	}
	else if ($reputation_rating >= 100 && $reputation_rating < 200) 
	{
		$display_output = ' (' . $reputation_rating_link . ') <img align=absmiddle src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/red_star.gif" border="0">';
	}
	else if ($reputation_rating >= 200) 
	{
		$display_output = ' (' . $reputation_rating_link . ') <img align=absmiddle src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/gold_star.gif" border="0">';
	}

	if (!$reputation_only && !$reverse)
	{
		if ($user_details['bidder_verified'])
		{
			$display_output .= ' <img align=absmiddle src="' . $fileExtension . 'images/verified_bidder.gif" border="0" alt="' . GMSG_VERIFIED_BIDDER . '">';		
		}
		
		if ($user_details['seller_verified'])
		{
			$display_output .= ' <img align=absmiddle src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/verified.gif" border="0" alt="' . GMSG_VERIFIED_SELLER . '">';		
		}
		
		if ($user_details['enable_aboutme_page'])
		{
			$display_output .= ' <a href="' . $fileExtension . 'about_me.php?user_id=' . $user_id . '"><img src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/about_me.gif" border="0" align="absmiddle"></a>';
		}
		
		if ($user_details['shop_active'])
		{
			$display_output .= ' <a href="' . $fileExtension . 'shop.php?user_id=' . $user_id . '"><img src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/25store.gif" border="0" align=absmiddle></a>';
		}
		
		if ($user_details['enable_profile_page'] && $setts['enable_profile_page'])
		{
			$display_output .= ' <a href="' . $fileExtension . 'profile.php?user_id=' . $user_id . '"><img src="' . $fileExtension . 'themes/' . $setts['default_theme'] . '/img/system/profile.gif" border="0" align=absmiddle alt="' . MSG_VIEW_MEMBER_PROFILE . '"></a>';
		}
	}
	
	return $display_output;
}

/**
 * below are all the category counters related functions 
 */
function auction_counter ($category_id, $operation = 'add', $auction_id = 0)
{
	global $db;

	$can_add = ($category_id) ? true : false;
	
	if ($auction_id)
	{
		$list_in = $db->get_sql_field("SELECT list_in FROM " . DB_PREFIX . "auctions WHERE auction_id='" . $auction_id . "'", 'list_in');
		$can_add = ($list_in == 'store') ? false : $can_add;
	}
	
	if ($can_add)
	{
		$root_id = $category_id;
		
		while ($root_id > 0) 
		{
			$db->query("UPDATE " . DB_PREFIX . "categories SET 
				items_counter=items_counter" . (($operation == 'add') ? '+' : '-') . "1 WHERE category_id='" . $root_id . "'");
			
			$root_id = $db->get_sql_field("SELECT parent_id FROM " . DB_PREFIX . "categories WHERE category_id=" . $root_id, 'parent_id');
		}		
	}
}

function wanted_counter ($category_id, $operation = 'add')
{
	global $db;
	
	$can_add = ($category_id) ? true : false;
	
	if ($can_add)
	{
		$root_id = $category_id;
		
		while ($root_id > 0) 
		{
			$db->query("UPDATE " . DB_PREFIX . "categories SET 
				wanted_counter=wanted_counter" . (($operation == 'add') ? '+' : '-') . "1 WHERE category_id='" . $root_id . "'");
			
			$root_id = $db->get_sql_field("SELECT parent_id FROM " . DB_PREFIX . "categories WHERE category_id=" . $root_id, 'parent_id');
		}		
	}
}

function reverse_counter ($category_id, $operation = 'add')
{
	global $db;

	$can_add = ($category_id) ? true : false;
	
	if ($can_add)
	{
		$root_id = $category_id;
		
		while ($root_id > 0) 
		{
			$db->query("UPDATE " . DB_PREFIX . "reverse_categories SET 
				items_counter=items_counter" . (($operation == 'add') ? '+' : '-') . "1 WHERE category_id='" . $root_id . "'");
			
			$root_id = $db->get_sql_field("SELECT parent_id FROM " . DB_PREFIX . "reverse_categories WHERE category_id=" . $root_id, 'parent_id');
		}		
	}
}

function user_counter ($user_id, $operation = 'add')
{
	global $db;
	
	$cnt_active = ($operation == 'add') ? 0 : 1;
	
	$sql_select_auctions = $db->query("SELECT auction_id, category_id, addl_category_id FROM " . DB_PREFIX . "auctions WHERE 
		owner_id='" . $user_id . "' AND active=" . $cnt_active . " AND approved=1 AND closed=0 AND deleted!=1 AND list_in!='store'");
	
	while ($item_details = $db->fetch_array($sql_select_auctions)) 
	{
		auction_counter($item_details['category_id'], $operation, $item_details['auction_id']);
		auction_counter($item_details['addl_category_id'], $operation, $item_details['auction_id']);	
	}

	$sql_select_wa = $db->query("SELECT category_id, addl_category_id FROM " . DB_PREFIX . "wanted_ads WHERE 
		owner_id='" . $user_id . "' AND active=" . $cnt_active . " AND closed=0 AND deleted!=1");
	
	while ($item_details = $db->fetch_array($sql_select_wa)) 
	{
		wanted_counter($item_details['category_id'], $operation);
		wanted_counter($item_details['addl_category_id'], $operation);	
	}
	
	$sql_select_reverse = $db->query("SELECT category_id, addl_category_id FROM " . DB_PREFIX . "reverse_auctions WHERE 
		owner_id='" . $user_id . "' AND active=" . $cnt_active . " AND closed=0 AND deleted!=1");
	
	while ($item_details = $db->fetch_array($sql_select_reverse)) 
	{
		reverse_counter($item_details['category_id'], $operation);
		reverse_counter($item_details['addl_category_id'], $operation);	
	}	
}

function user_account_management($user_id, $active)
{
	global $db;
	
	$operation = ($active == 1) ? 'add' : 'remove';
	
	## if the activation is done through the admin, the payment_status flag will always be set to confirmed so the account_payment 
	## issue doesnt come into play anymore
	$db->query("UPDATE " . DB_PREFIX . "users SET active=" . $active . ", payment_status='confirmed', exceeded_balance_email=0 WHERE user_id='" . $user_id . "'");
	
	user_counter($user_id, $operation);	
	$db->query("UPDATE " . DB_PREFIX . "auctions SET active=" . $active . " WHERE owner_id='" . $user_id . "'");
	$db->query("UPDATE " . DB_PREFIX . "wanted_ads SET active=" . $active . " WHERE owner_id='" . $user_id . "'");
}

function send_mail($to, $subject, $text_message, $from_email, $html_message = null, $from_name = null, $send = true, $reply_to = null) 
{
	global $setts, $current_version;

	if ($send)
	{
		## set date
		$tz = date('Z');
		$tzs = ($tz < 0) ? '-' : '+';
	   $tz = abs($tz);
		$tz = ($tz / 3600) * 100 + ($tz % 3600) / 60;
		$mail_date = sprintf('%s %s%04d', date('D, j M Y H:i:s'), $tzs, $tz);
		
		$uniq_id = md5(uniqid(time()));
	
		## create the message body
		$html_message = ($html_message) ? $html_message : $text_message;
		
		$html_msg = "<!--\n" . $text_message . "\n-->\n".
			"<html><body><img src=\"" . SITE_PATH . "images/probidlogo.gif\"><p>" . EMAIL_FONT . $html_message . "</body></html>";
	
		$from_name = (!empty($from_name)) ? $from_name : GMSG_MAIL_FROM_ADMIN;
		switch ($setts['mailer'])
		{
			case 'sendmail': ## send through the UNIX Sendmail function
				## create header
				$header = "Date: " . $mail_date . "\n".
					"Return-Path: " . $from_email . "\n".
					"To: " . $to . "\n".
					"From: " . $from_name . " <" . $from_email . ">\n".
					(($setts['enable_bcc']) ? "Bcc: " . $setts['admin_email'] . "\n" : "").
					"Reply-to: " . ((!empty($reply_to)) ? $reply_to : $from_email) . "\n".
					"Subject: " . $subject . "\n".
					sprintf("Message-ID: <%s@%s>%s", $uniq_id, $_SERVER['SERVER_NAME'], "\n").
					"X-Priority: 3\n".
					"X-Mailer: PHP Pro Bid/Sendmail [version " . $current_version . "]\n".
					"MIME-Version: 1.0\n".
					"Content-Transfer-Encoding: 7bit\n".
					sprintf("Content-Type: %s; charset=\"%s\"","text/html","iso-8859-1").
					"\n\n";
		
				if ($from_email)
				{
					$output = sprintf("%s -oi -f %s -t", $setts['sendmail_path'], $from_email);
				}
				else
				{
					$output = sprintf("%s -oi -t", $setts['sendmail_path']);
				}
		
				if(!@$mail = popen($output, "w")) 
				{
					echo GMSG_COULDNT_EXECUTE . ': ' . $setts['sendmail_path'];
				}
				
				fputs($mail, $header);
				fputs($mail, $html_msg);
		        
				$result = pclose($mail) >> 8 & 0xFF;
				
				if($result != 0) 
				{
					echo GMSG_COULDNT_EXECUTE . ': ' . $setts['sendmail_path'];
				}
				break;
				
			case 'mail':
				## send through the PHP mail() function
				## create header
				$boundary[1] = "b1_" . $uniq_id;
				$boundary[2] = "b2_" . $uniq_id;
			
				$header = "Date: ".$mail_date."\n".
					"Return-Path: " . $from_email . "\n".
					"From: " . $from_name . " <" . $from_email . ">\n".
					(($setts['enable_bcc']) ? "Bcc: " . $setts['admin_email'] . "\n" : "").
					"Reply-to: " . ((!empty($reply_to)) ? $reply_to : $from_email) . "\n".
					sprintf("Message-ID: <%s@%s>%s", $uniq_id, $_SERVER['SERVER_NAME'], "\n").
					"X-Priority: 3\n".
					"X-Mailer: PHP Pro Bid/Sendmail [version " . $current_version . "]\n".
					"MIME-Version: 1.0\n".
					"Content-Transfer-Encoding: 7bit\n".
					sprintf("Content-Type: %s; charset=\"%s\"","text/html","iso-8859-1").
		
				$params = sprintf("-oi -f %s", $from_email);
				
				if (strlen(ini_get('safe_mode'))<1) 
				{
					$old_from = ini_get('sendmail_from');
					ini_set("sendmail_from", $from_email);
					$result = @mail($to, $subject, $html_msg, $header, $params);
				} 
				else 
				{
					$result = @mail($to, $subject, $html_msg, $header);
				}
				
				if (isset($old_from)) 
				{
					ini_set("sendmail_from",$old_from);
				}
				
				if (!$result) 
				{
					echo GMSG_MAIL_SENDING_FAILED;
				}
								
				break;
			case 'smtp':
				## send through the smtp method
				smtp_mailer($from_email, $from_name, $to, $subject, $html_msg, $reply_to);
				break;
		}
	}
}

function suspend_debit_users()
{
	global $db, $fees, $setts, $session, $parent_dir;
	(array) $addl_query = null;
	$remove_session = false;
	
	$addl_query[] = "(balance>max_credit OR (suspension_date>0 AND suspension_date<'" . CURRENT_TIME . "' AND balance>0))";

	if ($setts['account_mode_personal'] == 1)
	{
		$addl_query[] = "payment_mode=2"; // personal mode, only suspend users that have account mode enabled
	}

	if (!$setts['suspend_over_bal_users'])
	{
		$addl_query[] = "exceeded_balance_email=0";
	}

	$query = $db->implode_array($addl_query, ' AND ');

	if ($setts['account_mode'] == 2 || $setts['account_mode_personal'] == 1)
	{
		$sql_select_users = $db->query("SELECT user_id FROM " . DB_PREFIX . "users WHERE
			active=1 AND " . $query);

		while ($user_details = $db->fetch_array($sql_select_users))
		{
			$mail_input_id = $user_details['user_id'];

			if ($setts['suspend_over_bal_users'])
			{
				user_account_management($user_details['user_id'], 0);

				include ($parent_dir . 'language/' . $setts['site_lang'] . '/mails/exceeded_balance_user_notification.php');
				if ($session->value('user_id') == $user_details['user_id'])
				{
					$remove_session = true;
				}
			}
			else
			{
				$db->query("UPDATE " . DB_PREFIX . "users SET exceeded_balance_email=1, suspension_date=0 WHERE user_id='" . $user_details['user_id'] . "'");
				include ($parent_dir . 'language/' . $setts['site_lang'] . '/mails/exceeded_balance_user_notification_no_suspension.php');
			}
		}
	}

	return $remove_session;
}

function last_char($value, $char = ',')
{
	$value = trim($value);
	$last_char = substr($value, -1);
			
	$value = ($last_char == $char) ? substr($value, 0, -1) : $value;

	return $value;
}

function paypal_countries_list()
{
	$output = array(
		'UNITED KINGDOM' => 'GB', 
		'UNITED STATES' => 'US', 
		'CANADA' => 'CA', 
		'AUSTRALIA' => 'AU', 
		'AFGHANISTAN' => 'AF',
		'ALAND ISLANDS' => 'AX', 
		'ALBANIA' => 'AL', 
		'ALGERIA' => 'DZ', 
		'AMERICAN SAMOA' => 'AS', 
		'ANDORRA' => 'AD', 
		'ANGOLA' => 'AO', 
		'ANGUILLA' => 'AI', 
		'ANTARCTICA' => 'AQ', 
		'ANTIGUA AND BARBUDA' => 'AG', 
		'ARGENTINA' => 'AR', 
		'ARMENIA' => 'AM', 
		'ARUBA' => 'AW', 
		'AUSTRIA' => 'AT', 
		'AZERBAIJAN' => 'AZ', 
		'BAHAMAS' => 'BS', 
		'BAHRAIN' => 'BH', 
		'BANGLADESH' => 'BD', 
		'BARBADOS' => 'BB', 
		'BELARUS' => 'BY', 
		'BELGIUM' => 'BE', 
		'BELIZE' => 'BZ', 
		'BENIN' => 'BJ', 
		'BERMUDA' => 'BM', 
		'BHUTAN' => 'BT', 
		'BOLIVIA' => 'BO', 
		'BOSNIA AND HERZEGOVINA' => 'BA', 
		'BOTSWANA' => 'BW', 
		'BOUVET ISLAND' => 'BV', 
		'BRAZIL' => 'BR', 
		'BRITISH INDIAN OCEAN TERRITORY' => 'IO', 
		'BRUNEI DARUSSALAM' => 'BN', 
		'BULGARIA' => 'BG', 
		'BURKINA FASO' => 'BF', 
		'BURUNDI' => 'BI', 
		'CAMBODIA' => 'KH', 
		'CAMEROON' => 'CM', 
		'CAPE VERDE' => 'CV', 
		'CAYMAN ISLANDS' => 'KY', 
		'CENTRAL AFRICAN REPUBLIC' => 'CF', 
		'CHAD' => 'TD', 
		'CHILE' => 'CL', 
		'CHINA' => 'CN', 
		'CHRISTMAS ISLAND' => 'CX', 
		'COCOS (KEELING) ISLANDS' => 'CC', 
		'COLOMBIA' => 'CO', 
		'COMOROS' => 'KM', 
		'CONGO' => 'CG', 
		'CONGO, THE DEMOCRATIC REPUBLIC OF THE' => 'CD', 
		'COOK ISLANDS' => 'CK', 
		'COSTA RICA' => 'CR', 
		'CÔTE D\'IVOIRE' => 'CI', 
		'CROATIA' => 'HR', 
		'CUBA' => 'CU', 
		'CYPRUS' => 'CY', 
		'CZECH REPUBLIC' => 'CZ', 
		'DENMARK' => 'DK', 
		'DJIBOUTI' => 'DJ', 
		'DOMINICA' => 'DM', 
		'DOMINICAN REPUBLIC' => 'DO', 
		'ECUADOR' => 'EC', 
		'EGYPT' => 'EG', 
		'EL SALVADOR' => 'SV', 
		'EQUATORIAL GUINEA' => 'GQ', 
		'ERITREA' => 'ER', 
		'ESTONIA' => 'EE', 
		'ETHIOPIA' => 'ET', 
		'FALKLAND ISLANDS (MALVINAS)' => 'FK', 
		'FAROE ISLANDS' => 'FO', 
		'FIJI' => 'FJ', 
		'FINLAND' => 'FI', 
		'FRANCE' => 'FR', 
		'FRENCH GUIANA' => 'GF', 
		'FRENCH POLYNESIA' => 'PF', 
		'FRENCH SOUTHERN TERRITORIES' => 'TF', 
		'GABON' => 'GA', 
		'GAMBIA' => 'GM', 
		'GEORGIA' => 'GE', 
		'GERMANY' => 'DE', 
		'GHANA' => 'GH', 
		'GIBRALTAR' => 'GI', 
		'GREECE' => 'GR', 
		'GREENLAND' => 'GL', 
		'GRENADA' => 'GD', 
		'GUADELOUPE' => 'GP', 
		'GUAM' => 'GU', 
		'GUATEMALA' => 'GT', 
		'GUERNSEY' => 'GG', 
		'GUINEA' => 'GN', 
		'GUINEA-BISSAU' => 'GW', 
		'GUYANA' => 'GY', 
		'HAITI' => 'HT', 
		'HEARD ISLAND AND MCDONALD ISLANDS' => 'HM', 
		'HOLY SEE (VATICAN CITY STATE)' => 'VA', 
		'HONDURAS' => 'HN', 
		'HONG KONG' => 'HK', 
		'HUNGARY' => 'HU', 
		'ICELAND' => 'IS', 
		'INDIA' => 'IN', 
		'INDONESIA' => 'ID', 
		'IRAN, ISLAMIC REPUBLIC OF' => 'IR', 
		'IRAQ' => 'IQ', 
		'IRELAND' => 'IE', 
		'ISLE OF MAN' => 'IM', 
		'ISRAEL' => 'IL', 
		'ITALY' => 'IT', 
		'JAMAICA' => 'JM', 
		'JAPAN' => 'JP', 
		'JERSEY' => 'JE', 
		'JORDAN' => 'JO', 
		'KAZAKHSTAN' => 'KZ', 
		'KENYA' => 'KE', 
		'KIRIBATI' => 'KI', 
		'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF' => 'KP', 
		'KOREA, REPUBLIC OF' => 'KR', 
		'KUWAIT' => 'KW', 
		'KYRGYZSTAN' => 'KG', 
		'LAO PEOPLE\'S DEMOCRATIC REPUBLIC' => 'LA', 
		'LATVIA' => 'LV', 
		'LEBANON' => 'LB', 
		'LESOTHO' => 'LS', 
		'LIBERIA' => 'LR', 
		'LIBYAN ARAB JAMAHIRIYA' => 'LY', 
		'LIECHTENSTEIN' => 'LI', 
		'LITHUANIA' => 'LT', 
		'LUXEMBOURG' => 'LU', 
		'MACAO' => 'MO', 
		'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF' => 'MK', 
		'MADAGASCAR' => 'MG', 
		'MALAWI' => 'MW', 
		'MALAYSIA' => 'MY', 
		'MALDIVES' => 'MV', 
		'MALI' => 'ML', 
		'MALTA' => 'MT', 
		'MARSHALL ISLANDS' => 'MH', 
		'MARTINIQUE' => 'MQ', 
		'MAURITANIA' => 'MR', 
		'MAURITIUS' => 'MU', 
		'MAYOTTE' => 'YT', 
		'MEXICO' => 'MX', 
		'MICRONESIA, FEDERATED STATES OF' => 'FM', 
		'MOLDOVA, REPUBLIC OF' => 'MD', 
		'MONACO' => 'MC', 
		'MONGOLIA' => 'MN', 
		'MONTENEGRO' => 'ME', 
		'MONTSERRAT' => 'MS', 
		'MOROCCO' => 'MA', 
		'MOZAMBIQUE' => 'MZ', 
		'MYANMAR' => 'MM', 
		'NAMIBIA' => 'NA', 
		'NAURU' => 'NR', 
		'NEPAL' => 'NP', 
		'NETHERLANDS' => 'NL', 
		'NETHERLANDS ANTILLES' => 'AN', 
		'NEW CALEDONIA' => 'NC', 
		'NEW ZEALAND' => 'NZ', 
		'NICARAGUA' => 'NI', 
		'NIGER' => 'NE', 
		'NIGERIA' => 'NG', 
		'NIUE' => 'NU', 
		'NORFOLK ISLAND' => 'NF', 
		'NORTHERN MARIANA ISLANDS' => 'MP', 
		'NORWAY' => 'NO', 
		'OMAN' => 'OM', 
		'PAKISTAN' => 'PK', 
		'PALAU' => 'PW', 
		'PALESTINIAN TERRITORY, OCCUPIED' => 'PS', 
		'PANAMA' => 'PA', 
		'PAPUA NEW GUINEA' => 'PG', 
		'PARAGUAY' => 'PY', 
		'PERU' => 'PE', 
		'PHILIPPINES' => 'PH', 
		'PITCAIRN' => 'PN', 
		'POLAND' => 'PL', 
		'PORTUGAL' => 'PT', 
		'PUERTO RICO' => 'PR', 
		'QATAR' => 'QA', 
		'RÉUNION' => 'RE', 
		'ROMANIA' => 'RO', 
		'RUSSIAN FEDERATION' => 'RU', 
		'RWANDA' => 'RW', 
		'SAINT BARTHÉLEMY' => 'BL', 
		'SAINT HELENA' => 'SH', 
		'SAINT KITTS AND NEVIS' => 'KN', 
		'SAINT LUCIA' => 'LC', 
		'SAINT MARTIN' => 'MF', 
		'SAINT PIERRE AND MIQUELON' => 'PM', 
		'SAINT VINCENT AND THE GRENADINES' => 'VC', 
		'SAMOA' => 'WS', 
		'SAN MARINO' => 'SM', 
		'SAO TOME AND PRINCIPE' => 'ST', 
		'SAUDI ARABIA' => 'SA', 
		'SENEGAL' => 'SN', 
		'SERBIA' => 'RS', 
		'SEYCHELLES' => 'SC', 
		'SIERRA LEONE' => 'SL', 
		'SINGAPORE' => 'SG', 
		'SLOVAKIA' => 'SK', 
		'SLOVENIA' => 'SI', 
		'SOLOMON ISLANDS' => 'SB', 
		'SOMALIA' => 'SO', 
		'SOUTH AFRICA' => 'ZA', 
		'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS' => 'GS', 
		'SPAIN' => 'ES', 
		'SRI LANKA' => 'LK', 
		'SUDAN' => 'SD', 
		'SURINAME' => 'SR', 
		'SVALBARD AND JAN MAYEN' => 'SJ', 
		'SWAZILAND' => 'SZ', 
		'SWEDEN' => 'SE', 
		'SWITZERLAND' => 'CH', 
		'SYRIAN ARAB REPUBLIC' => 'SY', 
		'TAIWAN, PROVINCE OF CHINA' => 'TW', 
		'TAJIKISTAN' => 'TJ', 
		'TANZANIA, UNITED REPUBLIC OF' => 'TZ', 
		'THAILAND' => 'TH', 
		'TIMOR-LESTE' => 'TL', 
		'TOGO' => 'TG', 
		'TOKELAU' => 'TK', 
		'TONGA' => 'TO', 
		'TRINIDAD AND TOBAGO' => 'TT', 
		'TUNISIA' => 'TN', 
		'TURKEY' => 'TR', 
		'TURKMENISTAN' => 'TM', 
		'TURKS AND CAICOS ISLANDS' => 'TC', 
		'TUVALU' => 'TV', 
		'UGANDA' => 'UG', 
		'UKRAINE' => 'UA', 
		'UNITED ARAB EMIRATES' => 'AE', 
		'UNITED STATES MINOR OUTLYING ISLANDS' => 'UM', 
		'URUGUAY' => 'UY', 
		'UZBEKISTAN' => 'UZ', 
		'VANUATU' => 'VU', 
		'VENEZUELA' => 'VE', 
		'VIET NAM' => 'VN', 
		'VIRGIN ISLANDS, BRITISH' => 'VG', 
		'VIRGIN ISLANDS, U.S.' => 'VI', 
		'WALLIS AND FUTUNA' => 'WF', 
		'WESTERN SAHARA' => 'EH', 
		'YEMEN' => 'YE', 
		'ZAMBIA' => 'ZM', 
		'ZIMBABWE' => 'ZW'
	);
	
	return $output;
}

function paypal_countries_drop_down($selected_country, $form_name = 'manage_account_form')
{
	(string) $display_output = null;
	
	$countries_array = paypal_countries_list();
	
	$display_output = '<select name="paypal_country" onchange="submit_form(' . $form_name . ')"> ';
	
	$selected_country = strtoupper($selected_country);
	
	foreach ($countries_array as $key => $value)
	{
		$display_output .= '<option value="' . $value . '" ' . (($value == $selected_country) ? 'selected' : '') . '>' . $key . '</option> ';
	}
	$display_output .= '</select>';
	
	return $display_output;
}

function optimize_search_string($keywords)
{
	global $setts;
	
	if ($setts['fulltext_search_method'] == 1)
	{
		$output = str_replace(' ', '* +', $keywords) . '*';
	}
	else 
	{
		$output = str_replace(' ', ' +', $keywords);		
	}
	
	return $output;
}

function get_server_load() 
{
	$output = GMSG_NA;
	$os = strtolower(PHP_OS);
	
	if(strpos($os, "win") === false) 
	{
		if(@file_exists("/proc/loadavg")) {
			$load = @file_get_contents("/proc/loadavg");
			$load = @explode(' ', $load);
			
			$output = $load[0];
		}
		else if(@function_exists("shell_exec")) 
		{
			$load = @explode(' ', `uptime`);
			$output = $load[count($load)-1];
		}
	}	
	
	return ($output > 0) ? $output : GMSG_NA;
}

function dd_expires($start_time)
{
	global $setts;
	
	$output = array('display' => GMSG_NA, 'result' => 1);
	
	if ($setts['dd_expiration'])
	{
		$expiration = $setts['dd_expiration'] * 24 * 60 * 60;
		$end_date = $start_time + $expiration;
		
		$output['display'] = time_left($end_date);
		$output['result'] = $end_date - CURRENT_TIME;
	}
	
	return $output;
}

/* currently it will only support one media file attached to an auction */
function download_redirect($winner_id, $buyer_id)
{
	global $db, $setts;
	$output = array('url' => null, 'redirect' => false, 'display' => null);
	
	$winner_id = intval($winner_id);
	$buyer_id = intval($buyer_id);
	
	$media_details = $db->get_sql_row("SELECT am.*, w.is_dd, w.dd_active, w.dd_active_date FROM 
		" . DB_PREFIX . "auction_media am, " . DB_PREFIX . "winners w WHERE 
		am.auction_id=w.auction_id AND w.winner_id=" . $winner_id . " AND w.buyer_id=" . $buyer_id . " AND am.media_type=3");
	
	if ($media_details['is_dd'])
	{
		if ($media_details['dd_active'])
		{
			$expiration = (($setts['dd_expiration'] * 24 * 60 * 60) + $media_details['dd_active_date']) - CURRENT_TIME;
			
			if ($expiration > 0 || !$setts['dd_expiration'])
			{
				$db->query("UPDATE " . DB_PREFIX . "winners SET dd_nb_downloads=dd_nb_downloads+1 WHERE winner_id=" . $winner_id);
				
				$output['redirect'] = true;
				$output['display'] = MSG_DD_DOWNLOAD_SUCCESS;			
			}
			else 
			{
				$output['display'] = MSG_DD_DOWNLOAD_LINK_EXPIRED;
			}
		}
		else 
		{
			$output['display'] = MSG_DD_DOWNLOAD_LINK_INACTIVE;			
		}
	}
	else 
	{
		$output['display'] = MSG_DD_NO_DD_OR_NO_AUCT_WINNER;					
	}
	
	if ($output['redirect'])
	{
		if (stristr($media_details['media_url'], 'http://') || stristr($media_details['media_url'], 'https://'))
		{ /* means we have an external link */
			$output['url'] = $media_details['media_url'];
		}
		else 
		{ /* the file is on site */
			//$output['url'] = $setts['dd_folder'] . $media_details['media_url'];
			$output['url'] = $media_details['media_url'];
		}
	}
	
	return $output;
}

function activate_dd($winner_id, $seller_id, $value)
{
	global $db, $setts;
	
	$winner_id = intval($winner_id);
	$seller_id = intval($seller_id);
	
	$db->query("UPDATE " . DB_PREFIX . "winners SET 
		dd_active=IF(is_dd=1, " . $value . ", 0), 
		dd_active_date=IF(" . $value . "=1 AND is_dd=1, " . CURRENT_TIME . ", 0) WHERE 
		winner_id=" . $winner_id . " AND seller_id=" . $seller_id);	
}

/**
 * this function will create the secred digital media folder. 
 * It will however not remove the old folder (at this time).
 */
function secret_folder($folder_name, $in_admin = true)
{
	global $db, $setts;
		
	$folder = (($in_admin) ? '../' : '') . $folder_name;
	$result = @mkdir($folder, 0777);
	
	if ($result)
	{
		/* now create an index.htm page */
		$fp = @fopen($folder . '/index.htm', 'w');
		$content = ' '; 
		@fputs($fp,$content); 
		@fclose($fp); 
	}	
	
	return $result;
}

function numeric_format ($input)
{
	global $setts;

	if (substr_count($input, '.') <= 1 && substr_count($input, ',') == 0)
	{
		$output = $input;		
	}
	else 
	{
		if ($setts['amount_format'] == 1)
		{
			$output = str_replace(',', '', $input);
		}
		else if ($setts['amount_format'] == 2)
		{
			if (substr_count($input, ',') > 0)
			{
				$output = str_replace(',', '.', $input);
			}
			else 
			{
				$output = str_replace('.', '', $input);
			}
			
			$temp = explode('.', $output);
			$cnt_temp = count($temp);
			if ($cnt_temp > 1)
			{
				$output = null;
				for ($i=0; $i<($cnt_temp-1); $i++)
				{
					$output .= $temp[$i];
				}
				$output .= '.' . $temp[$cnt_temp-1];
			}
		}
	}
		    		
	return $output;
}

/**
 * this function will take two input variables, one array and the other string, and format it in an array string delimited by a selected delimiter
 * all values in the new array string will be integers
 *
 * @param array $array_input
 * @param string $string_input
 * @return string
 */
function format_response_integer($array_input, $string_input, $glue_input = ',', $glue_output = ',')
{
	global $db;
	
	$string_array = null;
	if (is_array($array_input))
	{
		$string_array = $db->implode_array($array_input, $glue_input);
	}
	else if (!empty($string_input))
	{
		$string_array = $string_input;
	}

	$tmp_array = null;
	if (!empty($string_array))
	{
		$explode_string = @explode($glue_input, $string_array);

		foreach ($explode_string as $value)
		{
			$tmp_array[] = intval($value);
		}
	}

	$output = $db->implode_array($tmp_array, $glue_output);
	
	return $output;
}

/**
 * this function will return 1 if force payment is enabled on an auction, and 0 otherwise
 *
 * @param int $user_id
 * @param array $item_details - we need "buyout_price" and "direct_payment" from this array 
 */
function force_payment_enabled($user_id, $item_details)
{
	global $db, $setts, $layout;
	
	$user_details = $db->get_sql_row("SELECT enable_force_payment FROM " . DB_PREFIX . "users WHERE 
		user_id='" . intval($user_id) . "'");
	
	$result = false;
	
	// && $item_details['list_in'] != 'store'
	 
	if (
			$setts['enable_force_payment'] && $layout['enable_buyout'] && $setts['buyout_process'] == 1 && 
			$user_details['enable_force_payment'] && $item_details['buyout_price'] > 0 && 
			!empty($item_details['direct_payment'])
	)
	{
		$result = true;
	}
	
	return $result;
}

function revert_sale($winner_details)
{
	global $db, $fees;
	
	// first we add quantity back for dutch auctions, remove reputation, remove end of auction fee, then remove the winner row
	if ($winner_details['quantity_requested'] == $winner_details['quantity_offered'])
	{
		$quantity_query = ($winner_details['auction_type'] == 'standard') ? '1' : 'quantity+' . $winner_details['quantity_offered'];
		
		$db->query("UPDATE " . DB_PREFIX . "auctions SET quantity=" . $quantity_query . " WHERE auction_id='" . $winner_details['auction_id'] . "'");		
	}
	
	$db->query("DELETE FROM " . DB_PREFIX . "reputation WHERE winner_id='" . $winner_details['winner_id'] . "'");
	$db->query("DELETE FROM " . DB_PREFIX . "invoices WHERE invoice_id='" . $winner_details['sale_fee_invoice_id'] . "'");
	
	if ($winner_details['sale_fee_payer_id'])
	{
		$payment_mode = $fees->user_payment_mode($winner_details['sale_fee_payer_id']);
		
		if ($payment_mode == 2)
		{
			$db->query("UPDATE " . DB_PREFIX . "users SET balance=balance-" . $winner_details['sale_fee_amount'] . " WHERE user_id='" . $winner_details['sale_fee_payer_id'] . "'");
		}
	}

	$one_day = CURRENT_TIME + 24 * 60 * 60;
	$end_time = ($winner_details['closed']) ? max(array($one_day, $winner_details['end_time_cron'])) : $winner_details['end_time'];
	
	$db->query("UPDATE " . DB_PREFIX . "auctions SET deleted=0, closed=0, end_time='" . $end_time . "' WHERE auction_id='" . $winner_details['auction_id'] . "'");
	
	$db->query("DELETE FROM " . DB_PREFIX . "winners WHERE winner_id='" . $winner_details['winner_id'] . "'");	
}

/**
 * NTS -> number to string (99999999999 => above)
 * STN -> string to number (above => 99999999999)
 */
function convert_amount ($input_array, $direction = 'NTS')
{
	(array) $output = null;

	foreach ($input_array as $key => $value)
	{
		if (!is_array($value)) 
		{
			if ($direction == 'NTS')
			{
				$output[$key] = ($value >= 99999999999 && doubleval($value)) ? 'above' : $value;
			}
			else if ($direction == 'STN')
			{
				$output[$key] = (stristr($value, 'above')) ? 99999999999 : $value;
			}
		}
		else 
		{
			$output[$key] = convert_amount($value, $direction);
		}
	}

	return $output;
}

/**
 * this function will calculate the postage based on the array of winner_id values and the postage type the seller has selected.
 * if the invoice has been created and is weight or amount based, the postage amount will only be taken from one of the rows resulted 
 * because the total amount will be saved in each row
 *
 * if the invoice is already created, take the invoice values of the postage and insurance
 * 
 * @param array $winner_ids
 * @param int $seller_id
 * @param int $auction_id 	-- optional, used only for the shipping calculator feature
 * @param int $buyer_id 	-- optional, used only for the shipping calculator feature
 * 
 * @return array $totals
 */
function calculate_postage($winner_ids, $seller_id, $auction_id = null, $buyer_id = null, $buyer_country = null, $buyer_state = null, $sc_quantity = 0, $sc_carrier = null, $buyer_zip_code = null)
{
	global $db, $setts;
	$totals = array('postage' => null, 'insurance' => null, 'invoice' => null, 'weight' => null, 
		'total_postage' => null, 'valid_location' => false, 'nb_items' => null, 'currency' => null, 'error' => null, 'can_calculate' => true);

	$winner_ids = (is_array($winner_ids)) ? $db->implode_array($winner_ids) : intval($winner_ids);

	$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id='" . $seller_id . "'");

	if ($auction_id)
	{
		$sql_select_winners = $db->query("SELECT a.postage_amount AS item_postage,
			a.insurance_amount AS item_insurance, a.item_weight, a.currency, a.country, a.state, a.zip_code, a.shipping_method   
			FROM " . DB_PREFIX . "auctions a WHERE a.auction_id='" . intval($auction_id) . "'");		
	}
	else 
	{
		$sql_select_winners = $db->query("SELECT w.*, a.postage_amount AS item_postage,
			a.insurance_amount AS item_insurance, a.item_weight, a.currency, a.country, a.state, a.zip_code, a.shipping_method   
			FROM " . DB_PREFIX . "winners w 
			LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id 
			WHERE w.winner_id IN (" . $winner_ids . ")");
	}
	
	$invoice_sent = false;
	$can_calculate = true;
	while ($winner_details = $db->fetch_array($sql_select_winners))
	{
		$user_details['country'] = $winner_details['country'];
		$user_details['state'] = $winner_details['state'];
		$user_details['zip_code'] = $winner_details['zip_code'];
		
		$winner_details['quantity_offered'] = ($sc_quantity) ? $sc_quantity : $winner_details['quantity_offered'];
		$buyer_id = (!$buyer_id) ? $winner_details['buyer_id'] : $buyer_id;
		$totals['currency'] = $winner_details['currency'];
		
		if (!empty($winner_details['shipping_method']) && !$sc_carrier)
		{
			$sc_carrier = $winner_details['shipping_method']; //override the carrier with the one saved in the winner/sc row
		}

		if ($winner_details['shipping_method'] != 2)
		{
			if ($winner_details['invoice_sent'])
			{
				$invoice_sent = true;
				if ($user_details['pc_postage_type'] == 'item')
				{
					$totals['postage'] += ($winner_details['postage_included']) ? ($winner_details['postage_amount'] * $winner_details['quantity_offered']) : 0;
				}
				else
				{
					$totals['postage'] = $winner_details['postage_amount'];
				}
	
				$totals['insurance'] += ($winner_details['insurance_included']) ? ($winner_details['insurance_amount'] * $winner_details['quantity_offered']) : 0;
	
			}
			else
			{
				$totals['postage'] += $winner_details['item_postage'] * $winner_details['quantity_offered'];
				$totals['insurance'] += $winner_details['item_insurance'] * $winner_details['quantity_offered'];
			}

			$totals['weight'] += $winner_details['item_weight'] * $winner_details['quantity_offered'];
			$totals['nb_items'] += $winner_details['quantity_offered'];
			$totals['invoice'] += $winner_details['bid_amount'] * $winner_details['quantity_offered'];		
		}
	}

	if ($buyer_id) /* only if there is a sale we get these variables from the db, for the shipping calculator, these values are passed */
	{
		$buyer_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id='" . $buyer_id . "'");
		$buyer_country = $buyer_details['country'];
		$buyer_state = $buyer_details['state'];
		$buyer_zip_code = $buyer_details['zip_code'];
	}

	if ($user_details['pc_shipping_locations'] == 'global')
	{
		$totals['valid_location'] = true;
	}
	else 
	{
		$addl_costs = user_location($seller_id, $buyer_country, $buyer_state);
				
		$totals['valid_location'] = $addl_costs['valid'];
	}
	
	if ($invoice_sent)
	{
		$totals['total_postage'] = $totals['postage'] + $totals['insurance'];
	}
	else
	{
		if ($user_details['pc_free_postage'] && $user_details['pc_free_postage_amount'] <= $totals['invoice'])
		{
			$totals['postage'] = 0;
			$totals['total_postage'] = $totals['insurance'];
		}
		else
		{
			switch ($user_details['pc_postage_type'])
			{
				case 'item':
					/* do nothing */
					$postage_amount = $totals['postage'];
					break;
				case 'weight':
					if ($user_details['pc_postage_calc_type'] == 'carriers')
					{
						if (!empty($sc_carrier))
						{
							$carriers = new shipping_methods();
							$carriers->setts = &$setts;	
							
							list($carrier_name, $carrier_method) = @explode('|', $sc_carrier);
							
							$seller_iso_country = iso_country($user_details['country']);
							$buyer_iso_country = iso_country($buyer_country);

							switch ($carrier_name) 
							{
								case 'FedEx':
									$carriers_result = $carriers->fedex_service($totals['weight'], $user_details['zip_code'], $seller_iso_country, $buyer_zip_code, $buyer_iso_country, $carrier_method);
									break;
								case 'USPS':
									$carriers_result = $carriers->usps_service($totals['weight'], $user_details['zip_code'], $buyer_zip_code, $buyer_iso_country, $carrier_method);
									break;
								case 'UPS':
									$carriers_result = $carriers->ups_service($totals['weight'], $user_details['zip_code'], $seller_iso_country, $buyer_zip_code, $buyer_iso_country, $carrier_method);
									break;
							}
							
							$postage_amount = $carriers_result[0]['price'];
							if ($carriers_result[0]['currency'] != $totals['currency'])
							{
								$currency_from_value = $db->get_sql_field("SELECT convert_rate FROM " . DB_PREFIX . "currencies WHERE 
									symbol='" . $carriers_result[0]['currency'] . "'", 'convert_rate');
								
								$currency_to_value = $db->get_sql_field("SELECT convert_rate FROM " . DB_PREFIX . "currencies WHERE 
									symbol='" . $totals['currency'] . "'", 'convert_rate');
							
								if ($currency_from_value > 0)
								{
									$postage_amount = $postage_amount * $currency_to_value / $currency_from_value;	
								}
							}
						}
						else 
						{
							$can_calculate = false;
						}
						
					}
					else 
					{
					   $postage_amount = $db->get_sql_field("SELECT postage_amount FROM " . DB_PREFIX . "postage_calc_tiers WHERE
						   tier_type='weight' AND tier_from<='" . $totals['weight'] . "' AND tier_to>'" . $totals['weight'] . "' 
						   AND user_id=" . (($user_details['pc_postage_calc_type'] == 'default') ? '0' : $user_details['user_id']), 'postage_amount');					
					}
					break;
				case 'amount':
					$postage_amount = $db->get_sql_field("SELECT postage_amount FROM " . DB_PREFIX . "postage_calc_tiers WHERE
						tier_type='amount' AND tier_from<='" . $totals['invoice'] . "' AND tier_to>'" . $totals['invoice'] . "' 
						AND user_id=" . (($user_details['pc_postage_calc_type'] == 'default') ? '0' : $user_details['user_id']), 'postage_amount');
					break;
				case 'flat':
					$nb_items = $totals['nb_items'] - 1;
					
					$postage_amount = $user_details['pc_flat_first'] + ($nb_items * $user_details['pc_flat_additional']);
					break;
			}
			
			$totals['can_calculate'] = $can_calculate;
			if ($can_calculate)
			{
			   $totals['postage'] = ($totals['nb_items']) ? $postage_amount : 0;
			   
			   if ($totals['valid_location'])
			   {
				   $totals['postage'] = $totals['postage'] + (($addl_costs['amount_type'] == 'flat') ? $addl_costs['amount'] : ($totals['postage'] * $addl_costs['amount'] / 100));
			   }
			   $totals['total_postage'] = $totals['postage'] + $totals['insurance'];
		   }		
			else 
			{
				$totals['error'] = MSG_PLEASE_SELECT_SHIPPING_METHOD;
				$totals['postage'] = null;
			}
		}		
	}

	return $totals;
}

function shipping_locations($user_id)
{
	global $db;

	$pc_shipping_locations = $db->get_sql_field("SELECT pc_shipping_locations FROM " . DB_PREFIX . "users WHERE 
		user_id='" . $user_id . "'", 'pc_shipping_locations');
		
	$all_locations = null;
	if ($pc_shipping_locations == 'local')
	{
		$sql_select_locations = $db->query("SELECT * FROM " . DB_PREFIX . "shipping_locations WHERE 
			user_id='" . $user_id . "'");
			
		while($loc_details = $db->fetch_array($sql_select_locations))
		{
			$all_locations[] = $loc_details['locations_id'];
		}
		
		if (is_array($all_locations))
		{
			$all_locations = $db->implode_array($all_locations);
		}	
	}
	
	$all_locations = (empty($all_locations)) ? 0 : $all_locations;
	
	return $all_locations;
}

function user_location($seller_id, $buyer_country, $buyer_state)
{
	global $db;	
	$result = array('valid' => false, 'amount' => null, 'amount_type' => 'flat');
	
	$location_details = $db->get_sql_row("SELECT id, amount, amount_type FROM " . DB_PREFIX . "shipping_locations WHERE
		(
			LOCATE('," . intval($buyer_country) . ",', CONCAT(',',locations_id,','))>0 OR
			LOCATE('," . intval($buyer_state) . ",', CONCAT(',',locations_id,','))>0
		) AND user_id='" . $seller_id . "'");

	if (intval($location_details['id']) > 0)
	{
		$result = $location_details;
		$result['valid'] = true;
	}
	
	return $result;
}

function print_array($input)
{
	echo '<pre>';
	print_r($input);
	echo '</pre>';
}

function categories_list_subcats ($selected_category_id)
{
	global $db, $categories_array;

	(string) $display_output = null;

	reset($categories_array);

	$display_output = '<select name="category_id" id="category_id"> '.
		'<option value="0" selected>' . GMSG_ALL_CATEGORIES . '</option> '.
		'<option value="0">' . GMSG_LIST_SEPARATOR . '</option>';

	foreach ($categories_array as $key => $value)
	{
		list($category_name, $user_id) = $value;

		if ($user_id == 0)
		{
			$display_output .= '<option value="' . $key . '" ' . (($selected_category_id == $key)? 'selected' : '') . '>' . $category_name . '</option>';
		}
	}
	$display_output .= '</select>';

	return $display_output;
}

function get_parent_cats($category_id)
{
	global $db;
	$parent_cats = array($category_id);
	
	if ($category_id > 0)
	{
		$parent_category = $category_id;
		while ($parent_category > 0)
		{
			$result = $parent_category;
			$parent_category = $db->get_sql_field("SELECT parent_id FROM " . DB_PREFIX . "categories WHERE
					category_id='" . $parent_category . "'", 'parent_id');
			
			$parent_cats[] = $parent_category;
		}
	}

	return $parent_cats;
}

if (!stristr($_SERVER['PHP_SELF'], 'members_area.php'))
{
	$session->unregister('accept_offer_id');
}

function category_box ($category_id, $parent_id, $target_box_id, $prefix, $reverse_categories, $select_id, $user_id = 0, $listing_type = 'auction', $list_in = null)
{
	global $db, $category_lang, $reverse_category_lang;
	$categories_table = ($reverse_categories) ? 'reverse_categories' : 'categories';
	
	$select_which = ($reverse_categories) ? '' : (($listing_type == 'auction') ? ' AND (enable_auctions=1 OR parent_id>0) ' : ' AND (enable_wanted=1 OR parent_id>0) ');
	
	$output = '<div class="category_box"><select size="8" style="width: 225px;" onchange="select_category(this.value, \'' . $target_box_id . '\', \'' . $prefix . '\', ' . $reverse_categories . ', false, \'' . $listing_type . '\', \'' . $list_in . '\');">';

	if ($parent_id == 0 && $prefix == 'addl_')
	{
		$output .= '<option value="-1">' . GMSG_NONE_CAT . '</option>';		
	}
	
	$select_list_in = null;
	
	if ($parent_id == 0 && $listing_type == 'auction' && in_array($list_in, array('store', 'both')))
	{
		$shop_categories = $db->get_sql_field("SELECT shop_categories FROM " . DB_PREFIX . "users 
			WHERE user_id='" . $user_id . "'", 'shop_categories');

		if (!empty($shop_categories))
		{
			$shop_categories = last_char($shop_categories);
			$select_list_in = ' AND category_id IN (' . $shop_categories . ')';
		}
	}
	
	// show all categories from the same level
	$sql_select_cats = $db->query("SELECT category_id, is_subcat FROM " . DB_PREFIX . $categories_table . "
		WHERE parent_id='" . $parent_id . "' 
		" . (($reverse_categories) ? '' : " AND user_id IN (0, " . intval($user_id) . ") ") . "
		" . $select_which . " " . $select_list_in . " ORDER BY order_id ASC, name ASC");

	while ($cat_details = $db->fetch_array($sql_select_cats))
	{
		$category_name = (($reverse_categories) ? $reverse_category_lang[$cat_details['category_id']] : $category_lang[$cat_details['category_id']]) . ' ' . $cat_details['is_subcat'];
		$selected = ($category_id == $cat_details['category_id']) ? 'selected' : '';

		$output .= '<option value="' . $cat_details['category_id'] . '" ' . $selected . '>' . $category_name . '</option>';
	}

	$output .= '</select></div>';

	return $output;
}

function generate_category_boxes($category_id, $target_box_id, $prefix = 'main_', $reverse_categories = 0, $click_select = false, $user_id = 0, $listing_type = 'auction', $list_in = null)
{
	global $db, $category_lang;

	$output = null;
	$counter = 0;	
	$categories_table = ($reverse_categories) ? 'reverse_categories' : 'categories';
		
	$category_tree = array();
	
	if($category_id > 0)
	{
		$root_id = $category_id;
		
		while ($root_id > 0)
		{
			$row_category = $db->get_sql_row("SELECT c.category_id, c.name, c.parent_id, 
				(SELECT count(*) FROM " . DB_PREFIX . $categories_table . " ch WHERE ch.parent_id=c.category_id) AS children
				FROM " . DB_PREFIX . $categories_table . " c
				WHERE c.category_id=" . $root_id . " 
				" . (($reverse_categories) ? '' : " AND c.user_id IN (0, " . intval($user_id) . ") ") . " LIMIT 0,1");

			$category_tree[] = array(
				'category_id' => $row_category['category_id'], 
				'name' => $row_category['name'],
				'parent_id' => $row_category['parent_id'], 
				'has_children' => $row_category['children']
			);
			
			$root_id = $row_category['parent_id'];
		}
		
		$category_tree = array_reverse($category_tree);

		foreach ($category_tree as $category)
		{
			$output .= category_box($category['category_id'], $category['parent_id'], $target_box_id, $prefix, $reverse_categories, $select_id, $user_id, $listing_type, $list_in);			
		}
		
		$last_category = end($category_tree);
		
		if ($last_category['has_children'])
		{
			$output .= category_box(0, $last_category['category_id'], $target_box_id, $prefix, $reverse_categories, $select_id, $user_id, $listing_type, $list_in);
		}		
		else if (!$click_select)
		{
			//$output .= '<div><input class="cat_select_proceed" type="button" value="' . GMSG_PROCEED . '" 
			//	onclick="change_category(' . $last_category['category_id'] . ', \'' . $prefix . '\', ' . $reverse_categories . ');"></div>';
			$output = 'change_category(' . $last_category['category_id'] . ', \'' . $prefix . '\', ' . $reverse_categories . ');';
		}
	}
	else if ($category_id == -1)
	{
		$output = 'change_category(0, \'' . $prefix . '\', ' . $reverse_categories . ');';		
	}
	else 
	{
		$output = category_box(0, 0, $target_box_id, $prefix, $reverse_categories, $select_id, $user_id, $listing_type, $list_in);
	}
	
	return $output;
}

function get_main_image($input_array)
{
	$result = null;
	if (is_array($input_array))
	{
		foreach ($input_array as $value)
		{
			if (!empty($value))
			{
				$result = (!$result) ? $value : $result;
			}
		}
	}
	
	return $result;
}

function protected_page($user_id, $category_id)
{
	global $db;
	$output = array(
		'store_password' => null, 'store_id' => null, 'private_store' => false, 
		'category_password' => null, 'category_id' => null, 'private_category' => false 		
	);
	
	$user_id = intval($user_id);
	$category_id = intval($category_id);
	
	if ($user_id)
	{
		$store_password = $db->get_sql_field("SELECT store_password FROM " . DB_PREFIX . "users 
			WHERE user_id='" . $user_id . "'", 'store_password');

		if (!empty($store_password))
		{
			$output['store_password'] = $store_password;
			$output['store_id'] = $user_id; 
			$output['private_store'] = true;
		}
	}
	
	if ($category_id)
	{
		$category_id = $db->main_category($category_id);
		$category_password = $db->get_sql_field("SELECT cat_password FROM " . DB_PREFIX . "categories 
			WHERE category_id='" . $category_id . "'", 'cat_password');

		if (!empty($category_password))
		{
			$output['category_password'] = $category_password;
			$output['category_id'] = $category_id; 
			$output['private_category'] = true;
		}
	}
	
	return $output;
}

function login_protected_page($user_id, $category_id, $password)
{
	global $db, $session;
	$output = true;
	$login_store = array();
	$login_category = array();
	
	$protected_page = protected_page($user_id, $category_id);
	
	if ($protected_page['private_store'])
	{
		if ($protected_page['store_password'] == $password)
		{
			if (is_array($session->value('login_store')))
			{
				foreach ($session->value('login_store') as $value)
				{
					$login_store[] = $value;
				}
			}
			$login_store[] = $user_id;
			
			$session->set('login_store', $login_store);
		}
		else 
		{
			$output = false;
		}
	} 
	
	if ($protected_page['private_category'])
	{
		if ($protected_page['category_password'] == $password)
		{
			if (is_array($session->value('login_category')))
			{
				foreach ($session->value('login_category') as $value)
				{
					$login_category[] = $value;
				}
			}
			$login_category[] = $category_id;
			
			$session->set('login_category', $login_category);
		}
		else 
		{
			$output = false;
		}
	}
	
	return $output;
}

function store_logged_in($store_id)
{
	global $session;
	
	return (in_array($store_id, (array)$session->value('login_store'))) ? true : false;	
}

function category_logged_in($category_id)
{
	global $session, $db;
	
	$category_id = $db->main_category($category_id);
	return (in_array($category_id, (array)$session->value('login_category'))) ? true : false;	
}

function payment_gateways_array($user_details)
{
	return array(
		'pg_paypal' => array(
			'id' => 'pg_paypal',
			'pg_paypal_email' => array(
				'name' => GMSG_PAYPAL_EMAIL, 
				'value' => $user_details['pg_paypal_email'], 
				'type' => 'text'
			)
		),
		
		'pg_worldpay' => array(
			'id' => 'pg_worldpay',
			'pg_worldpay_id' => array(
				'name' => GMSG_WORLDPAY_ID,
				'value' => $user_details['pg_worldpay_id'],
				'type' => 'text'
			)
		),
		
		'pg_checkout' => array(
			'id' => 'pg_checkout',
			'pg_checkout_id' => array(
				'name' => GMSG_CHECKOUT_ID,
				'value' => $user_details['pg_checkout_id'],
				'type' => 'text'
			)
		),
		
		'pg_nochex' => array(
			'id' => 'pg_nochex',
			'pg_nochex_email' => array(
				'name' => GMSG_NOCHEX_EMAIL,
				'value' => $user_details['pg_nochex_email'],
				'type' => 'text'
			)
		),
		
		'pg_ikobo' => array(
			'id' => 'pg_ikobo',
			'pg_ikobo_username' => array(
				'name' => GMSG_IKOBO_USERNAME,
				'value' => $user_details['pg_ikobo_username'],
				'type' => 'text'
			),
			'pg_ikobo_password' => array(
				'name' => GMSG_IKOBO_PASSWORD,
				'value' => $user_details['pg_ikobo_password'],
				'type' => 'password'
			)
		),

		'pg_protx' => array(
			'id' => 'pg_protx',
			'pg_protx_username' => array(
				'name' => GMSG_PROTX_USERNAME,
				'value' => $user_details['pg_protx_username'],
				'type' => 'text'
			),
			'pg_protx_password' => array(
				'name' => GMSG_PROTX_PASSWORD,
				'value' => $user_details['pg_protx_password'],
				'type' => 'password'
			)
		),
		
		'pg_authnet' => array(
			'id' => 'pg_authnet',
			'pg_authnet_username' => array(
				'name' => GMSG_AUTHNET_USERNAME,
				'value' => $user_details['pg_authnet_username'],
				'type' => 'text'
			),
			'pg_authnet_password' => array(
				'name' => GMSG_AUTHNET_PASSWORD,
				'value' => $user_details['pg_authnet_password'],
				'type' => 'password'
			)
		),
		
		'pg_mb' => array(
			'id' => 'pg_mb',
			'pg_mb_email' => array(
				'name' => GMSG_MB_EMAIL,
				'value' => $user_details['pg_mb_email'],
				'type' => 'text'
			)
		),

		'pg_paymate' => array(
			'id' => 'pg_paymate',
			'pg_paymate_merchant_id' => array(
				'name' => GMSG_PAYMATE_MERCHANT_ID,
				'value' => $user_details['pg_paymate_merchant_id'],
				'type' => 'text'
			)
		),
		
		'pg_gc' => array(
			'id' => 'pg_gc',
			'pg_gc_merchant_id' => array(
				'name' => GMSG_GC_MERCHANT_ID,
				'value' => $user_details['pg_gc_merchant_id'],
				'type' => 'text'
			),
			'pg_gc_merchant_key' => array(
				'name' => GMSG_GC_MERCHANT_KEY,
				'value' => $user_details['pg_gc_merchant_key'],
				'type' => 'text'
			)
		),

		'pg_amazon' => array(
			'id' => 'pg_amazon',
			'pg_amazon_access_key' => array(
				'name' => GMSG_AMAZON_ACCESS_KEY,
				'value' => $user_details['pg_amazon_access_key'],
				'type' => 'text'
			),
			'pg_amazon_secret_key' => array(
				'name' => GMSG_AMAZON_SECRET_KEY,
				'value' => $user_details['pg_amazon_secret_key'],
				'type' => 'text'
			)
		),
		
		'pg_alertpay' => array(
			'id' => 'pg_alertpay',
			'pg_alertpay_id' => array(
				'name' => GMSG_ALERTPAY_ID,
				'value' => $user_details['pg_alertpay_id'],
				'type' => 'text'
			),
			'pg_alertpay_securitycode' => array(
				'name' => GMSG_ALERTPAY_SECURITY_CODE,
				'value' => $user_details['pg_alertpay_securitycode'],
				'type' => 'text'
			)
		), 
		
		'pg_gunpal' => array(
			'id' => 'pg_gunpal',
			'pg_gunpal_id' => array(
				'name' => GMSG_GUNPAL_ID, 
				'value' => $user_details['pg_gunpal_id'], 
				'type' => 'text'
			)
		),
		
	);	
}

function js_base64_decode($text)
{
	global $db;	
	
	$text = str_replace(' ', '+', $text);
	$text = base64_decode($text);
	$text = $db->rem_special_chars($text);
	
	return $text;
}

function duration_fees_list($selected)
{
	global $db, $setts;
	$selected = unserialize($selected);
	
	$sql_select_durations = $db->query("SELECT * FROM " . DB_PREFIX . "auction_durations 
		ORDER BY order_id ASC, days ASC");
	
	$duration_rows = null;
	while($duration_details = $db->fetch_array($sql_select_durations))
	{
		$duration_rows[] = '<span style="width: 75px;">' . $duration_details['description'] . '</span> -> ' . $setts['currency'] . ' ' . 
			'<input type="text" name="' . $duration_details['id'] . '" value="' . $selected[$duration_details['id']] . '" size="6" /> ';
	}

	return $db->implode_array($duration_rows, '<br>');
}

function serialize_duration_fees($values_array)
{
	global $db;
	
	$sql_select_durations = $db->query("SELECT * FROM " . DB_PREFIX . "auction_durations 
		ORDER BY id ASC");
	
	$duration_fees = array();
	while($duration_details = $db->fetch_array($sql_select_durations))
	{
		$duration_fees[$duration_details['id']] = $values_array[$duration_details['id']];
	}
	
	return serialize($duration_fees);
}

function get_country_iso($country_id)
{
	global $db;
	
	$result = $db->get_sql_field("SELECT country_iso_code FROM " . DB_PREFIX . "countries WHERE 
		id='" . $country_id . "'", 'country_iso_code');
	
	return strtoupper($result);
}

function currency_symbol($currency = null)
{
	global $db, $setts;
	
	$currency = (!empty($currency)) ? $currency : $setts['currency'];
	
	$currency_symbol = $db->get_sql_field("SELECT currency_symbol FROM " . DB_PREFIX . "currencies WHERE symbol='" . $currency . "'", 'currency_symbol');
			
	$currency = (!empty($currency_symbol)) ? $db->add_special_chars($currency_symbol) : $currency;
		
	return $currency;
}

if (!stristr($_SERVER['PHP_SELF'], 'members_area.php'))
{
	$session->unregister('accept_offer_id');
}

function show_state($state_name, $iso = false)
{
	global $db;
	
	if (intval($state_name) > 0)
	{
		$name = ($iso) ? 'country_iso_code' : 'name';
		$result = $db->get_sql_field("SELECT {$name} AS result FROM " . DB_PREFIX . "countries WHERE id='" . intval($state_name) . "'", 'result');
		
		$result = ($iso) ? strtoupper($result) : $result;
		
		return $result;
	}
	
	return $state_name;
}

function allow_store_upgrade($user_id)
{
	global $db, $setts;
	
	if (!$setts['enable_store_upgrade'])
	{
		return false;
	}

	$user_id = intval($user_id);
	$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id='{$user_id}'");
		
	$next_payment_days = $user_details['shop_next_payment'] / (24 * 60 * 60);
	$can_upgrade = (
			$user_details['shop_active'] &&
			(
				!$user_details['shop_next_payment'] || !$setts['store_upgrade_days'] || 
				$next_payment_days >=$setts['store_upgrade_days']
			)
		) ? true : false;
		
	return $can_upgrade;
}

function set_suspension_date($new_balance, $old_balance, $suspension_date, $max_credit)
{
	if ($new_balance > $max_credit && $old_balance < $max_credit)
	{
		$suspension_date = CURRENT_TIME;
	}
	else if ($new_balance <= $max_credit && $old_balance > $max_credit)
	{
		$suspension_date = 0;
	}
	
	echo show_date($suspension_date, true);
	return $suspension_date;
}

function filter_unused( $all, $used, $prefix_all = null, $prefix_used = null)
{
	$unused = array();

	// prefixes are not needed for sorting
	sort( $all );
	sort( $used );

	$a = 0;
	$u = 0;

	$maxa = sizeof($all)-1;
	$maxu = sizeof($used)-1;

	while( true )
	{
		if( $a > $maxa )
		{
			// done; rest of $used isn't in $all
			break;
		}
		if( $u > $maxu )
		{
			// rest of $all is unused
			for( ; $a <= $maxa; $a++ )
			{
				$unused[] = $all[$a];
			}
			break;
		}

		if( $prefix_all.$all[$a] > $prefix_used.$used[$u] )
		{
			// $used[$u] isn't in $all?
			$u++;
			continue;
		}

		if( $prefix_all.$all[$a] == $prefix_used.$used[$u] )
		{
			// $all[$a] is used
			$a++;
			$u++;
			continue;
		}

		$unused[] = $all[$a];

		$a++;
	}

	return $unused;
}

function word_filter($content_array)
{
   global $db;
   
   (array) $output = null;
   $sql_select_words = $db->query("SELECT word FROM " . DB_PREFIX . "wordfilter");

   $output = $content_array;
   while ($word_details = $db->fetch_array($sql_select_words))
   {
      foreach ($output as $key => $value)
      {
         $output[$key] = str_ireplace($word_details['word'], GMSG_WORD_FILTER_REPLACEMENT, $value);
      }
   }
   
   return $output;
}
	
?>