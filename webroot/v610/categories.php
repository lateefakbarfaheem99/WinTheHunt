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
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');

$parent_id = intval($_REQUEST['parent_id']);
$is_category = $db->count_rows('categories', "WHERE category_id='" . $parent_id . "'");
$parent_id = ($is_category) ? $parent_id : 0;
$_REQUEST['parent_id'] = $parent_id;

$user_id = intval($_REQUEST['user_id']);

$protected_page = protected_page(0, $parent_id);

if ($protected_page['private_category'] && !category_logged_in($parent_id))
{
	header_redirect('protected_page.php?redirect_url=categories&category_id=' . $parent_id);
}
else 
{
	include_once ('global_header.php');
	
	$template->set('parent_id', $parent_id);
		
	define('IS_CATEGORIES', 1);
					
	$main_category_id = $db->main_category($parent_id);
	$category_details = $db->get_sql_row("SELECT image_path, minimum_age FROM " . DB_PREFIX . "categories 
		WHERE category_id='" . $main_category_id . "'");

	$category_logo = $category_details['image_path'];	
	$category_logo = (!empty($category_logo)) ? '<img src="' . $category_logo . '" border="0">' : '';
	$template->set('category_logo', $category_logo);
	
	$categories_header_menu = category_navigator($parent_id, true, true, 'categories.php');
	$template->set('categories_header_menu', $categories_header_menu);
	
	if ($_REQUEST['option'] == 'agree_adult')
	{
		$session->set('adult_category', 1);	
	}
	
	if ($category_details['minimum_age'] > 0 && !$session->value('adult_category'))
	{
		$template->set('minimum_age', $category_details['minimum_age']);
		$template_output .= $template->process('adult_category_warning.tpl.php');
	}
	else 
	{		
		$src_details = array_merge($_GET, $_POST);
		$src_details = $db->rem_special_chars_array($src_details);
		
		/**
		 * featured items, recently listed and ending soon code
		 */
		if ($layout['catfeat_nb'])
		{
			(array) $item_details = null;

			$where_query = " WHERE a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0
				AND a.list_in!='store' AND a.catfeat='1'";
			$where_query = browse_filter_query($src_details, $where_query);					
			
			$template->set('featured_columns', min((floor($db->count_rows('auctions a', $select_condition)/$layout['catfeat_nb']) + 1), ceil($layout['catfeat_max']/$layout['catfeat_nb'])));
		
			$item_details = $db->random_rows('auctions a', 'a.auction_id, a.name, a.start_price, a.max_bid, a.currency, a.end_time', $where_query, $layout['catfeat_max']);
			$template->set('item_details', $item_details);
		}
		
		/**
		 * shop in stores code snippet
		 */
		
		if ($parent_id)
		{
			$where_query = " WHERE a.active=1 AND a.approved=1 
				AND a.closed=0 AND a.deleted=0 AND	a.list_in!='auction' 
				AND a.owner_id=us.user_id AND us.active='1' AND us.shop_active='1' AND us.shop_name!=''";
			$where_query = browse_filter_query($src_details, $where_query);					
			
			$sql_select_stores = $db->query("SELECT us.user_id, us.shop_name FROM 
				" . DB_PREFIX . "users us, " . DB_PREFIX . "auctions a 
				" . $where_query . " 
				GROUP BY us.user_id");
			
			$is_shop_stores = $db->num_rows($sql_select_stores);
			$template->set('is_shop_stores', $is_shop_stores);
			
			if ($is_shop_stores)
			{
				(string) $shop_stores_content = null;
				while ($store_details = $db->fetch_array($sql_select_stores))
				{
					$background = ($counter++%2) ? 'c1' : 'c2';
				
					$shop_stores_content .= '<tr> '.
						'	<td width="100%" class="contentfont">&nbsp;&raquo;&nbsp;<a href="shop.php?user_id=' . $store_details['user_id'] . '&parent_id=' . $parent_id . '">' . $store_details['shop_name'] . '</a></td> '.
						'</tr> ';					
				}
				
				$template->set('shop_stores_content', $shop_stores_content);
			}
		}
		$categories_header .= $template->process('categories_header.tpl.php');
		$categories_footer = $template->process('categories_footer.tpl.php');
				
		/**
		 * below we have the variables that need to be declared in each separate browse page
		 */
		$page_url = 'categories';
		
		$where_query = " WHERE a.active=1 AND a.approved=1 AND a.deleted=0 AND a.creation_in_progress=0";
		
		$order_field = (in_array($_REQUEST['order_field'], $auction_ordering)) ? $_REQUEST['order_field'] : 'a.end_time'; 
		$order_type = (in_array($_REQUEST['order_type'], $order_types)) ? $_REQUEST['order_type'] : 'ASC';
		
		$template->set('categories_header', $categories_header);
		$template->set('categories_footer', $categories_footer);
		
		include_once('includes/page_browse_auctions.php');
	}
	
	include_once ('global_footer.php');
	
	echo $template_output;
}
?>