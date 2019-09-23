<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');

if ($setts['enable_wanted_ads'])
{
	include_once ('global_header.php');
	
	(array) $query = null;
	$parent_id = intval($_REQUEST['parent_id']);
	$template->set('parent_id', $parent_id);
	
	$keywords_search = $db->rem_special_chars($_REQUEST['keywords_search']);
	$template->set('keywords_search', $keywords_search);
		
	$template->set('header_wanted_ads', header5(GMSG_WANTED_ADS));
	
	//$template->set('db', $db);
	//$template->set('fees', $fees);
	$template->set('session', $session);
	
	(string) $subcategories_content = null;
	
	$categories_header_menu = category_navigator($parent_id, true, true, 'wanted_ads.php');
	$template->set('categories_header_menu', $categories_header_menu . '&nbsp;[<a title="show/hide" class="hidelayer" id="exp11021709934728_link" href="javascript: void(0);" onclick="toggle(this, \'exp11021709934728\');">&#8211;</a>]');
	
	$is_subcategories = $db->count_rows('categories', "WHERE parent_id='" . $parent_id . "'");
	$template->set('is_subcategories', $is_subcategories);
				
	$sql_select_categories = $db->query("SELECT category_id, wanted_counter FROM " . DB_PREFIX . "categories WHERE 
		parent_id='" . $parent_id . "' AND user_id=0 AND enable_wanted=1 ORDER BY order_id ASC, name ASC");
	
	(array) $wanted_cats = null;
	while ($cat_details = $db->fetch_array($sql_select_categories)) 				  
	{
		$wanted_cats[] =$cat_details; 
	}
	
	$columns = 3; //columns 
	$all = count($wanted_cats); 
	
	for ($i=0; $i<$all; $i++) 
	{ 
		if (($i % $columns)==0 and $i!=0)
		{
			$subcategories_content .= '</tr><tr>'; 
		}
	
		$subcategories_content .= '<td class="c1"><img src="themes/' . $setts['default_theme'] . '/img/arrow.gif"></td>'.
			'<td class="c2" width="33%"><a href="' . process_link('wanted_ads', array('category' => $category_lang[$wanted_cats[$i]['category_id']], 'parent_id' => $wanted_cats[$i]['category_id'])) . '">' . $category_lang[$wanted_cats[$i]['category_id']] . '</a> '.
			(($setts['enable_cat_counters']) ? (($wanted_cats[$i]['wanted_counter']) ? '(<strong>' . $wanted_cats[$i]['wanted_counter'] . '</strong>)' : '(' . $wanted_cats[$i]['wanted_counter'] . ')') : '') . '</td>'; 
	}
	
	$template->set('subcategories_content', $subcategories_content);
	
	if ($parent_id)
	{
		(array) $src_cats = null;
		(string) $category_name = null;
		reset($categories_array);
		
		foreach ($categories_array as $key => $value)
		{
			if ($parent_id == $key)
			{
		
				list($category_name, $tmp_user_id) = $value;
			}
		}
		
		reset($categories_array);
		
		while (list($cat_array_id, $cat_array_details) = each($categories_array))
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
	
	$addl_where_query = $db->implode_array($query, ' AND ');
	$addl_where_query = (!empty($addl_where_query)) ? ' AND ' . $addl_where_query : '';
	
	$page_url = 'wanted_ads';
	
	$where_query = "WHERE a.active=1 AND a.closed=0 AND a.deleted=0" . $addl_where_query;
	
	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.end_time';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'ASC';
	
	$additional_vars = '&parent_id=' . $parent_id . '&keywords_search=' . $keywords_search;
	
	$limit = 20; 
	
	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type; 
	$limit_link = '&start=' . $start . '&limit=' . $limit; 
	
	$template->set('page_order_itemname', page_order($page_url . '.php', 'a.name', $start, $limit, $additional_vars, MSG_ITEM_TITLE));
	$template->set('page_order_nb_bids', page_order($page_url . '.php', 'a.nb_bids', $start, $limit, $additional_vars, MSG_NR_OFFERS));
	$template->set('page_order_end_time', page_order($page_url . '.php', 'a.end_time', $start, $limit, $additional_vars, MSG_ENDS));
	
	$nb_items = $db->count_rows('wanted_ads a', $where_query);
	$template->set('nb_items', $nb_items);
	
	if ($nb_items)
	{
		$pagination = paginate($start, $limit, $nb_items, $page_url . '.php', $additional_vars . $order_link); //g
		$template->set('pagination', $pagination); 
		
		$sql_select_wanted_ads = $db->query("SELECT a.wanted_ad_id, a.name, a.nb_bids, 
			a.end_time, a.closed, am.media_url FROM " . DB_PREFIX . "wanted_ads a 
			LEFT JOIN " . DB_PREFIX . "auction_media am ON a.wanted_ad_id=am.wanted_ad_id AND am.media_type=1 AND am.upload_in_progress=0 
			" . $where_query . "
			GROUP BY a.wanted_ad_id ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit); //g
		
		(string) $browse_wanted_ads_content = null; 
		while ($item_details = $db->fetch_array($sql_select_wanted_ads))
		{
			$background = ($counter++%2) ? 'c1' : 'c2';
			
			$wanted_ad_link = process_link('wanted_details', array('name' => $item_details['name'], 'wanted_ad_id' => $item_details['wanted_ad_id']));
			$wanted_ad_image = (!empty($item_details['media_url'])) ? $item_details['media_url'] : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif';
			
			$browse_wanted_ads_content .= '<tr class="contentfont ' . $background . '"> '.
		    	'	<td align="center"><a href="' . $wanted_ad_link . '"><img src="thumbnail.php?pic=' . $wanted_ad_image . '&w=50&sq=Y&b=Y" border="0" alt="' . $item_details['name'] . '"></a></td> '.
		    	'	<td><a href="' . $wanted_ad_link . '">' . $item_details['name'] . '</a></td> '.
		    	'	<td align="center">' . $item_details['nb_bids'] . '</td> '.
		    	'	<td align="center">' . time_left($item_details['end_time']) . '</td> '.
		  		'</tr> ';
		}
	}
	else 
	{
		$browse_wanted_ads_content = '<tr><td colspan="6" align="center">' . GMSG_NO_ITEMS_MSG . '</td></tr>';
	}
	$template->set('browse_wanted_ads_content', $browse_wanted_ads_content);
	
	$template_output .= $template->process('browse_wanted_ads.tpl.php');
	
	include_once ('global_footer.php');
	
	echo $template_output;
}
else 
{
	header_redirect('index.php');
}
?>