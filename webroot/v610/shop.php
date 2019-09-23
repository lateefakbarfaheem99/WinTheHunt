<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);
define ('MAX_STORE_ITEMS', 20);

include_once ('includes/global.php');
include_once ('includes/class_shop.php');
include_once ('includes/functions_item.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_item.php');
include_once ('includes/class_reputation.php');

$user_id = intval($_REQUEST['user_id']);

$protected_page = protected_page($user_id, 0);

if ($protected_page['private_store'] && !store_logged_in($user_id))
{
	header_redirect('protected_page.php?redirect_url=shop&user_id=' . $user_id);
}
else if ($setts['enable_stores'])
{
	include_once ('global_header.php');
	
	$parent_id = intval($_REQUEST['parent_id']);
	$keywords_search = $db->rem_special_chars($_REQUEST['keywords_search']);
	
	$is_store = false;
	
	if ($user_id)
	{
		$template->set('user_id', $user_id);
		$template->set('parent_id', $parent_id);
		$template->set('keywords_search', $keywords_search);
		
		$shop = new shop();
		$shop->setts = &$setts;
		$shop->user_id = $user_id;
		
		$reputation = new reputation();
		$reputation->setts = &$setts;
	
		$user_details = $db->get_sql_row("SELECT * FROM	" . DB_PREFIX . "users WHERE user_id=" . $user_id);
		
		$user_details['shop_nb_feat_items'] = ($user_details['shop_nb_feat_items'] > MAX_STORE_ITEMS) ? MAX_STORE_ITEMS : $user_details['shop_nb_feat_items'];
		$user_details['shop_nb_ending_items'] = ($user_details['shop_nb_ending_items'] > MAX_STORE_ITEMS) ? MAX_STORE_ITEMS : $user_details['shop_nb_ending_items'];
		$user_details['shop_nb_recent_items'] = ($user_details['shop_nb_recent_items'] > MAX_STORE_ITEMS) ? MAX_STORE_ITEMS : $user_details['shop_nb_recent_items'];
		
		$shop_status = $shop->shop_status($user_details);
		
		if ($shop_status['enabled'])
		{
			if ($session->value('user_id'))
			{
				$is_favorite_store = $db->count_rows('favourite_stores', "WHERE store_id='" . $user_details['user_id'] . "' AND user_id='" . $session->value('user_id') . "'");
			
				if ($_GET['option'] == 'favorites')
				{
					if (!$is_favorite_store)
					{
						$db->query("INSERT INTO " . DB_PREFIX . "favourite_stores 
							(store_id, user_id) VALUES 
							('" . $user_id . "', '" . $session->value('user_id') . "')");
						
						$is_favorite_store = 1;
					}
					else 
					{
						$db->query("DELETE FROM " . DB_PREFIX . "favourite_stores WHERE 
							store_id='" . $user_id . "' AND user_id='" . $session->value('user_id') . "'");
						
						$is_favorite_store = 0;
					}
				}

				$favorite_store = '[ <a href="shop.php?option=favorites&user_id=' . $user_id . '">' . ((!$is_favorite_store) ? MSG_ADD_TO_FAVORITES : MSG_REMOVE_FROM_FAVORITES) . '</a> ]';
			}
	
			(array) $query = null;
			define('IS_SHOP', 1);
			$shop_pages = array('shop_about', 'shop_specials', 'shop_shipping_info', 'shop_company_policies');
			
			$template->set('page', $_REQUEST['page']);
			
			$is_store = true;
	
			$reputation_output = $reputation->calc_reputation($user_details['user_id']);
			$shop_header_msg = GMSG_STORE . ' - ' . $user_details['shop_name'] . ' (' . MSG_REPUTATION_RATING . ': ' . $reputation_output['percentage'] . ') &nbsp; ' . $favorite_store;
			$template->set('shop_header_msg', $shop_header_msg);
			
			(string) $shop_header = null;
			(string) $shop_footer = null;
			
			$shop_header = '<link href="store_templates/store' . $user_details['shop_template_id'] . '/store_style.css" rel="stylesheet" type="text/css"> ';
			
			//$template->set('db', $db);
			//$template->set('fees', $fees);
			
			if (!empty($user_details['shop_logo_path']))
			{
				$user_details['shop_logo_path'] = 'thumbnail.php?pic=' . $user_details['shop_logo_path'] . '&w=750';
			}
			
			$template->set('user_details', $user_details);
	
			if (!in_array($_REQUEST['page'], $shop_pages))## PHP Pro Bid v6.00 header details (for the shop listings page)
			{
				(string) $shop_subcategories_content = null;
	
				$shop_categories_header = category_navigator($parent_id, true, true, 'shop.php', 'user_id=' . $user_id . '&keywords_search=' . $keywords_search);
				$template->set('shop_categories_header', $shop_categories_header);
	
				$is_subcategories = $db->count_rows('categories', "WHERE parent_id='" . $parent_id . "'");
				$template->set('is_subcategories', $is_subcategories);
				
				if (!empty($user_details['shop_categories']) && !$parent_id) 
				{
					$shop_categories = last_char($user_details['shop_categories']);
					
					$categories_query = " AND category_id IN (" . $shop_categories . ")";
				}
						  
				$sql_select_categories = $db->query("SELECT category_id FROM " . DB_PREFIX . "categories WHERE 
					parent_id='" . $parent_id . "' AND (user_id=0 OR user_id='" . $user_details['user_id'] . "') 
					" . $categories_query . " ORDER BY order_id ASC, name ASC");
	
				while ($cat_details = $db->fetch_array($sql_select_categories)) 
				{
					$background = ($counter++%2) ? 'c2_shop' : 'c3_shop';
	
					$shop_subcategories_content .= '<tr class="' . $background . '"> '.
						'	<td width="100%">&nbsp;&raquo;&nbsp;<a href="shop.php?parent_id=' . $cat_details['category_id'] . '&user_id=' . $user_id . '">' . $category_lang[$cat_details['category_id']] . '</a></td> '.
						'</tr> ';
				}
				
				$template->set('shop_subcategories_content', $shop_subcategories_content);
	
	
				/**
				 * featured items, recently listed and ending soon code
				 */
				if ($user_details['shop_nb_feat_items'])
				{
					(array) $feat_item_details = null;

					$select_condition = "WHERE	active=1 AND approved=1 AND closed=0 AND deleted=0 
						AND list_in!='auction' AND owner_id='" . $user_id . "' AND creation_in_progress=0"; 
				
					$items_row = intval($user_details['shop_nb_feat_items_row']);
					$items_row = ($items_row > 0) ? $items_row : 1;
					
					$template->set('featured_columns', min((floor($db->count_rows('auctions', $select_condition)/$items_row) + 1), ceil($user_details['shop_nb_feat_items']/$items_row)));					
					
					$feat_item_details = $db->random_rows('auctions', 'auction_id, name, start_price, max_bid, currency, end_time', $select_condition, $user_details['shop_nb_feat_items']);
					$template->set('feat_item_details', $feat_item_details);
				}
				
				if ($user_details['shop_nb_ending_items'] && !$parent_id)
				{				
					$sql_select_ending_items = $db->query("SELECT * FROM " . DB_PREFIX . "auctions 
						FORCE INDEX (auctions_end_time) WHERE 
						active=1 AND approved=1 AND closed=0 AND deleted=0 
						AND list_in!='auction' AND owner_id='" . $user_id . "' AND creation_in_progress=0 
						ORDER BY end_time ASC LIMIT " . $user_details['shop_nb_ending_items']);
					
					(string) $shop_ending_auctions_content = null;
					
					while ($item_details = $db->fetch_array($sql_select_ending_items)) 
					{ 
						$background = ($counter++%2) ? 'c2_shop' : 'c3_shop';
						
						$shop_ending_auctions_content .= '<tr height="15" class="'. $background .'"> '.
							'	<td width="11"><img src="themes/' . $setts['default_theme'] . '/img/arr_it.gif" width="11" height="11" hspace="4"></td> '.
							'	<td width="100%" class="contentfont_shop"><a href="' . process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id'])).'">' . title_resize($item_details['name']).'</a><br> '.
							'		<div class="smallfont_shop"><b>' . MSG_TIME_LEFT . '</b>: '. time_left($item_details['end_time']) . '</div> '.
							'		<div class="smallfont_shop"><b>' . MSG_CURRENTLY . '</b>: ' . $fees->display_amount((($item_details['max_bid']>0) ? $item_details['max_bid'] : $item_details['start_price']), $item_details['currency']) . '</div></td> '.
							'	<td nowrap>' . item_pics($item_details) . '</td> '.
							'</tr> ';
					}
					
					$template->set('shop_ending_auctions_content', $shop_ending_auctions_content);
				}
	
				if ($user_details['shop_nb_recent_items'] && !$parent_id)
				{
					$sql_select_recent_items = $db->query("SELECT * FROM " . DB_PREFIX . "auctions 
						FORCE INDEX (auctions_end_time) WHERE 						
						active=1 AND approved=1 AND closed=0 AND deleted=0 AND creation_in_progress=0  
						AND list_in!='auction' AND owner_id='" . $user_id . "' 
						ORDER BY start_time DESC LIMIT " . $user_details['shop_nb_recent_items']);
					
					(string) $shop_recent_auctions_content = null;
					
					while ($item_details = $db->fetch_array($sql_select_recent_items)) 
					{ 
						$background = ($counter++%2) ? 'c2_shop' : 'c3_shop';
						
						$shop_recent_auctions_content .= '<tr height="15" class="'. $background .'"> '.
							'	<td width="11"><img src="themes/' . $setts['default_theme'] . '/img/arr_it.gif" width="11" height="11" hspace="4"></td> '.
							'	<td width="100%" class="contentfont_shop"><a href="' . process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id'])).'">' . title_resize($item_details['name']).'</a><br> '.
							'		<div class="smallfont_shop"><b>' . MSG_TIME_LEFT . '</b>: '. time_left($item_details['end_time']) . '</div> '.
							'		<div class="smallfont_shop"><b>' . MSG_CURRENTLY . '</b>: ' . $fees->display_amount((($item_details['max_bid']>0) ? $item_details['max_bid'] : $item_details['start_price']), $item_details['currency']) . '</div></td> '.
							'	<td nowrap>' . item_pics($item_details) . '</td> '.
							'</tr> ';
					}
					
					$template->set('shop_recent_auctions_content', $shop_recent_auctions_content);
				}
			}
			
			$shop_footer = $template->process('shop_footer.tpl.php');
			
			$template->change_path('store_templates/store' . $user_details['shop_template_id'] . '/');
			$shop_header .= $template->process('header.php');
			$shop_footer .= $template->process('footer.php');
			
			$template->change_path('templates/');
			$shop_header .= $template->process('shop_header.tpl.php');
			
			if (in_array($_REQUEST['page'], $shop_pages))
			{
				$template->set('message_header', $header_browse_auctions);
				$template->set('message_content', $shop_header . '<p>' . $db->add_special_chars($user_details[$_REQUEST['page']]) . '</p>' . $shop_footer);
			
				$template_output .= $template->process('single_message.tpl.php');				
			}
			else 
			{
				/**
				 * below we have the variables that need to be declared in each separate browse page
				 */
				$page_url = 'shop';			
				
				$where_query = "WHERE a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0 AND a.list_in!='auction' AND 
					a.owner_id='" . $user_id . "' AND a.creation_in_progress=0 ";
				
				$order_field = (in_array($_REQUEST['order_field'], $auction_ordering)) ? $_REQUEST['order_field'] : 'a.end_time'; 
				$order_type = (in_array($_REQUEST['order_type'], $order_types)) ? $_REQUEST['order_type'] : 'ASC';
				
				$template->set('shop_header', $shop_header);
				$template->set('shop_footer', $shop_footer);
				
				include_once('includes/page_browse_auctions.php');
			}
		}
	}
	
	if (!$is_store)
	{
		$template->set('message_header', header5(MSG_STORE_ERROR_TITLE));
		$template->set('message_content', '<p align="center">' . MSG_STORE_ERROR_CONTENT . '</p>');
	
		$template_output .= $template->process('single_message.tpl.php');	
	}
	
	include_once ('global_footer.php');
	
	echo $template_output;
}
else 
{
	header_redirect('index.php');
}
?>