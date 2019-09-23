<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_user.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_item.php');

if ($setts['enable_reverse_auctions'])
{
	include_once ('global_header.php');
	
	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	$template->set('item', $item);
	
	(array) $query = null;
	$parent_id = intval($_REQUEST['parent_id']);
	$template->set('parent_id', $parent_id);
	
	$keywords_search = $db->rem_special_chars($_REQUEST['keywords_search']);
	$template->set('keywords_search', $keywords_search);
		
	$template->set('header_reverse_auctions', header5(GMSG_REVERSE_AUCTIONS));
	
	$template->set('session', $session);
	
	$db->categories_table = 'reverse_categories';
	$main_category_id = $db->main_category($parent_id);
	$category_details = $db->get_sql_row("SELECT image_path FROM " . DB_PREFIX . "reverse_categories WHERE 
		category_id='" . $main_category_id . "'");
	$category_logo = $category_details['image_path'];
	
	$category_logo = (!empty($category_logo)) ? '<img src="' . $category_logo . '" border="0">' : '';
	$template->set('category_logo', $category_logo);
	$db->categories_table = 'categories';
	
	(string) $subcategories_content = null;
	
	$categories_header_menu = category_navigator($parent_id, true, true, 'reverse_auctions.php', null, null, true);
	$template->set('categories_header_menu', $categories_header_menu . '&nbsp;[<a title="show/hide" class="hidelayer" id="exp11021709934728_link" href="javascript: void(0);" onclick="toggle(this, \'exp11021709934728\');">&#8211;</a>]');
	
	$is_subcategories = $db->count_rows('reverse_categories', "WHERE parent_id='" . $parent_id . "'");
	$template->set('is_subcategories', $is_subcategories);
				
	$sql_select_categories = $db->query("SELECT category_id, items_counter FROM " . DB_PREFIX . "reverse_categories WHERE 
		parent_id='" . $parent_id . "' ORDER BY order_id ASC, name ASC");
	
	(array) $reverse_cats = null;
	while ($cat_details = $db->fetch_array($sql_select_categories)) 				  
	{
		$reverse_cats[] =$cat_details; 
	}
	
	$columns = 3; //columns 
	$all = count($reverse_cats); 
	
	for ($i=0; $i<$all; $i++) 
	{ 
		if (($i % $columns)==0 and $i!=0)
		{
			$subcategories_content .= '</tr><tr>'; 
		}
	
		$subcategories_content .= '<td class="c1"><img src="themes/' . $setts['default_theme'] . '/img/arrow.gif"></td>'.
			'<td class="c2" width="33%"><a href="' . process_link('reverse_auctions', array('category' => $reverse_category_lang[$reverse_cats[$i]['category_id']], 'parent_id' => $reverse_cats[$i]['category_id'])) . '">' . $reverse_category_lang[$reverse_cats[$i]['category_id']] . '</a> '.
			(($setts['enable_cat_counters']) ? (($reverse_cats[$i]['items_counter']) ? '(<strong>' . $reverse_cats[$i]['items_counter'] . '</strong>)' : '(' . $reverse_cats[$i]['items_counter'] . ')') : '') . '</td>'; 
	}
	
	$template->set('subcategories_content', $subcategories_content);
	
	if ($parent_id)
	{
		(array) $src_cats = null;
		(string) $category_name = null;
		reset($reverse_categories_array);
		
		foreach ($reverse_categories_array as $key => $value)
		{
			if ($parent_id == $key)
			{
		
				list($category_name, $tmp_user_id) = $value;
			}
		}
		
		reset($reverse_categories_array);
		
		while (list($cat_array_id, $cat_array_details) = each($reverse_categories_array))
		{
			list($cat_array_name, $cat_user_id) = $cat_array_details;
		
			$categories_match = strpos($cat_array_name, $category_name);
			if (trim($categories_match) == "0")
			{
				$src_cats[] = $cat_array_id;
			}
		}
	
		$all_subcategories = $db->implode_array($src_cats);
		
		$query[] = "(a.category_id IN (" . $all_subcategories . ") OR a.addl_category_id IN (" . $all_subcategories . "))";	
	}
	
	if ($keywords_search)
	{
		$query[] = "MATCH (a.name, a.description) AGAINST ('" . $keywords_search . "*' IN BOOLEAN MODE)";	
	}
	
	/**
	 * featured items, recently listed and ending soon code
	 */
	if ($layout['r_catfeat_nb'])
	{
		(array) $item_details = null;
	
		$select_condition = "WHERE	a.active=1 AND a.closed=0 AND a.deleted=0
			AND a.catfeat='1'" . $addl_where_query; 
	
		$template->set('featured_columns', min((floor($db->count_rows('reverse_auctions a', $select_condition)/$layout['r_catfeat_nb']) + 1), ceil($layout['r_catfeat_max']/$layout['r_catfeat_nb'])));
	
		$item_details = $db->random_rows('reverse_auctions a', 'a.reverse_id, a.name, a.budget_id, a.nb_bids, a.end_time', $select_condition, $layout['r_catfeat_max']);
		$template->set('item_details', $item_details);
	}
		
	$addl_where_query = $db->implode_array($query, ' AND ');
	$addl_where_query = (!empty($addl_where_query)) ? ' AND ' . $addl_where_query : '';
	
	$page_url = 'reverse_auctions';
	
	$where_query = "WHERE a.active=1 AND a.closed=0 AND a.deleted=0 " . $addl_where_query;
	
	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.end_time';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'ASC';
	
	$additional_vars = '&parent_id=' . $parent_id . '&keywords_search=' . $keywords_search;
	
	$limit = 20; 
	
	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type; 
	$limit_link = '&start=' . $start . '&limit=' . $limit; 
	
	$template->set('page_order_itemname', page_order($page_url . '.php', 'a.name', $start, $limit, $additional_vars, MSG_ITEM_TITLE));
	$template->set('page_order_nb_bids', page_order($page_url . '.php', 'a.nb_bids', $start, $limit, $additional_vars, MSG_NR_BIDS));
	$template->set('page_order_end_time', page_order($page_url . '.php', 'a.end_time', $start, $limit, $additional_vars, MSG_ENDS));
	
	$nb_items = $db->count_rows('reverse_auctions a', $where_query);
	$template->set('nb_items', $nb_items);
	
	if ($nb_items)
	{
		$pagination = paginate($start, $limit, $nb_items, $page_url . '.php', $additional_vars . $order_link); //g
		$template->set('pagination', $pagination); 
		
		$sql_select_reverse = $db->query("SELECT a.reverse_id, a.name, a.nb_bids, 
			a.end_time, a.closed, am.media_url, a.hpfeat, a.catfeat, a.bold, a.hl FROM " . DB_PREFIX . "reverse_auctions a 
			LEFT JOIN " . DB_PREFIX . "auction_media am ON a.reverse_id=am.reverse_id AND am.media_type=1 AND am.upload_in_progress=0 
			" . $where_query . "
			GROUP BY a.reverse_id ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit); //g
		
		(string) $browse_reverse_content = null; 
		while ($item_details = $db->fetch_array($sql_select_reverse))
		{
			$background = ($counter++%2) ? 'c1' : 'c2';
			
			$background .= ($item_details['bold']) ? ' bold_item' : '';
			$background .= ($item_details['hl']) ? ' hl_item' : '';
			
			$ra_link = process_link('reverse_details', array('name' => $item_details['name'], 'reverse_id' => $item_details['reverse_id']));
			$ra_image = (!empty($item_details['media_url'])) ? $item_details['media_url'] : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif';
			
			$browse_reverse_content .= '<tr class="contentfont ' . $background . '"> '.
		    	//'	<td align="center"><a href="' . $ra_link . '"><img src="thumbnail.php?pic=' . $ra_image . '&w=50&sq=Y&b=Y" border="0" alt="' . $item_details['name'] . '"></a></td> '.
		    	'	<td height="30"><a href="' . $ra_link . '">' . $item_details['name'] . '</a></td> '.
		    	'	<td align="center">' . $item_details['nb_bids'] . '</td> '.
		    	'	<td align="center">' . time_left($item_details['end_time']) . '</td> '.
		  		'</tr> ';
		}
	}
	else 
	{
		$browse_reverse_content = '<tr><td colspan="6" align="center">' . GMSG_NO_ITEMS_MSG . '</td></tr>';
	}
	$template->set('browse_reverse_content', $browse_reverse_content);
	
	$template_output .= $template->process('browse_reverse_auctions.tpl.php');
	
	include_once ('global_footer.php');
	
	echo $template_output;
}
else 
{
	header_redirect('index.php');
}
?>