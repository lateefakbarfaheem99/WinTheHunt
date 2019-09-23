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

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	$session->set('category_language', 0);
	
	if ($session->value('reverse_categories') == 1)
	{
		$session->set('reverse_categories', 0);
		$table_name = 'reverse_categories';
		$cats_array_file = 'reverse_categories_array.php';
		$cats_lang_file = 'reverse_category.lang.php';
	}
	else 
	{
		$table_name = 'categories';
		$cats_array_file = 'categories_array.php';
		$cats_lang_file = 'category.lang.php';		
	}

	include_once ('header.php');
	$link = 'index.php';

	if (@!$open_file = fopen ('../language/' . $setts['site_lang'] . '/' . $cats_array_file, 'w'))
	{
		$template_output .= 'Sorry I cannot open the file language/' . $setts['site_lang'] . '/' . $cats_array_file . ', '.
			'please inform the administrator of this problem';
	}

	(array) $categories_array = null;

	$sql_select_categories = $db->query("SELECT category_id, name, parent_id " . (($tabe_name == 'categories') ? ', user_id' : '') . " FROM
		" . DB_PREFIX . $table_name . " ORDER BY order_id ASC, name ASC");

	while ($category_details = $db->fetch_array($sql_select_categories))
	{
		(int) $counter = 0;
		(array) $category_array_id = null;

		$root_id = $category_details['category_id'];

		while ($root_id > 0)
		{
			$row_subcategory = $db->get_sql_row("SELECT category_id, name, parent_id FROM
				" . DB_PREFIX . $table_name . " WHERE category_id= " . $root_id ." ORDER BY order_id ASC, name ASC");

			$category_array_id[] = $row_subcategory['category_id'];

			if(!$counter)
			{
				$category_name = $row_subcategory['name'];
			}
			else 	if($row_subcategory['parent_id'] != $croot)
			{
				$category_name = $row_subcategory['name'] . ' : ' . $category_name;
			}

			$counter++;
			$root_id = $row_subcategory['parent_id'];
		}

		$categories_array[$category_array_id[0]] = array( $db->rem_special_chars($category_name), intval($category_details['user_id'])) ;
	}

	asort($categories_array);

	(string) $category_file = NULL;

	$category_file = "<?\n";

	if (count($categories_array) > 0)
	{
		$category_file .= (($table_name == 'reverse_categories') ? '$reverse_categories_array' : '$categories_array' ) . 
			' = array (';

		while (list($category_id, $category_array_details) = each ($categories_array))
		{
			list($category_name, $user_id) = $category_array_details;
			$category_file .= '"' . $category_id . '" => array ("' . $db->rem_special_chars($category_name) . '", '.$user_id.'), ';
		}

		$category_file = substr($category_file,0,-2);

		$category_file .= "); ";
	}

	$category_file .= "\n ?>";

	fputs($open_file, $category_file);
	fclose($open_file);

	if (@!$open_file = fopen ('../language/' . $setts['site_lang'] . '/' . $cats_lang_file, 'w'))
	{
		$template_output .= '<br>Sorry I cannot open the file ' . $setts['site_lang'] . '/' . $cats_lang_file . ', '.
			'please inform the administrator of this problem';
	}

	(string) $category_lang = null;

	$category_lang .= "<?\n";

	$sql_select_categories = $db->query("SELECT category_id, name FROM " . DB_PREFIX . $table_name . " ORDER BY order_id ASC, name ASC");

	while ($cat_details = $db->fetch_array($sql_select_categories))
	{
		$category_lang .= ($table_name == 'reverse_categories') ? '$reverse_category_lang' : '$category_lang';
		$category_lang .= '[';
		$category_lang .= $cat_details['category_id'];
		$category_lang .= ']="';
		$category_lang .= $db->rem_special_chars($cat_details['name']);
		$category_lang .= '";';
		$category_lang .= "\n";
	}
	$category_lang .= "?>";

	fputs($open_file,$category_lang);
	fclose($open_file);

	$template_output .= '<table width="100%" border="0" cellspacing="3" cellpadding="3" class="border"> '.
		'<tr><td>The categories array file has been saved, redirecting, please wait...<br><br>Please click '.
		'<a href=' . $link . '>here</a><br>if the page does not refresh automatically.'.
		'<script>window.setTimeout(\'changeurl();\',2500); function changeurl(){window.location=\'' . $link . '\'}</script>'.
		'</td></tr></table>';

	include_once ('footer.php');

	echo $template_output;
}
?>
