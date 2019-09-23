<?
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

define ('MAX_SAVED_SEARCHES', 10);

function get_item_types()
{
   global $setts, $layout;
   $output = array();

   $output[] = array(
      'value' => 'all',
      'name' => MSG_ALL_ITEMS,
      'query' => "(a.list_in='auction' OR u.shop_active='1')"
   );
   $output[] = array(
      'value' => 'auctions',
      'name' => MSG_AUCTIONS_ONLY,
      'query' => "(a.list_in='auction' OR u.shop_active='1') AND a.buyout_price!=a.start_price"
   );

   if ($setts['enable_stores'])
   {
      $output[] = array(
         'value' => 'stores',
         'name' => MSG_STORE_ITEMS,
         'query' => "a.list_in!='auction' AND u.shop_active='1'"
      );
   }

   if ($layout['enable_buyout'] && $setts['buyout_process'])
   {
      $output[] = array(
         'value' => 'buy_out',
         'name' => MSG_BUY_OUT_ITEMS,
         'query' => "(a.list_in='auction' OR u.shop_active='1') AND a.buyout_price>0"
      );
   }

   $output[] = array(
      'value' => 'relisted',
      'name' => MSG_RELISTED_ITEMS,
      'query' => "(a.list_in='auction' OR u.shop_active='1') AND a.is_relisted_item=1"
   );
   
   return $output;
}

function browse_filter_query($src_details, $where_query)
{
	global $db, $setts, $categories_array;
   $item_types = get_item_types();

   $where_query = str_replace('AND a.closed=0', '', $where_query);
	$where_query = " LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id " . $where_query;
   
   $operand = (!empty($where_query)) ? ' AND ' : ' WHERE ';
   
	if (!empty($src_details['src_auction_id']))
	{
		$auction_id = intval($src_details['src_auction_id']);
		$query[] = "a.auction_id=" . $auction_id;		
	}
	if (!empty($src_details['keywords_search']))
	{
		//$keywords_search = optimize_search_string($src_details['keywords_search']);
		$keywords_search = $db->rem_special_chars($src_details['keywords_search']);
		$keywords_search = preg_replace("/[^a-zA-Z0-9 ]/", "", $keywords_search);
		
		if ($src_details['search_description'] == 1)
		{
			$query[] = "((a.name REGEXP '( )*(" . str_replace(' ', ')*( )*(', $keywords_search) . ")( )*') 
				OR (a.description REGEXP '( )*(" . str_replace(' ', ')*( )*(', $keywords_search) . ")( )*'))";		
		}
		else 
		{
			$query[] = "(a.name REGEXP '( )*(" . str_replace(' ', ')*( )*(', $keywords_search) . ")( )*')";					
		}
	}
	if (!empty($src_details['min_price']))
	{
		$min_price = doubleval($src_details['min_price']);
		$query[] = "a.start_price>='" . $min_price . "'";
	}
	if (!empty($src_details['max_price']))
	{
		$max_price = doubleval($src_details['max_price']);
		$query[] = "a.start_price<='" . $max_price . "'";
	}
	if ($src_details['buyout_price'] == 1)
	{
		$query[] = "a.buyout_price>0";
	}
	if ($src_details['reserve_price'] == 1)
	{
		$query[] = "a.reserve_price>0";
	}
	if ($_REQUEST['photos_only'] == 1)
	{
		$query[] = "IF ((SELECT count(*) AS nb_rows FROM " . DB_PREFIX . "auction_media am WHERE am.auction_id=a.auction_id AND
			am.media_type=1 AND am.upload_in_progress=0)>0, 1, 0)=1";
	}
	if ($_REQUEST['quantity_standard'] == 1)
	{
		$query[] = "a.quantity=1";
	}
	if ($_REQUEST['quantity'] == 1)
	{
		$query[] = "a.quantity>1";
	}
	if ($_REQUEST['direct_payment_only'] == 1)
	{
		$query[] = "a.direct_payment!=''";
	}
	if ($_REQUEST['regular_payment_only'] == 1)
	{
		$query[] = "a.payment_methods!=''";
	}
	if ($src_details['enable_swap'] == 1)
	{
		$query[] = "a.enable_swap=1";
	}
	if (!empty($src_details['list_in']))
	{
		$list_in = $db->rem_special_chars($src_details['list_in']);
		if ($list_in == 'store')
		{
			$query[] = "a.list_in'" . $list_in . "' AND u.shop_active=1";
		}
		else 
		{
			$query[] = "a.list_in='" . $list_in . "'";
		}
	}
	if (!empty($src_details['country']))
	{
		$query[] = "a.country='" . intval($src_details['country']) . "'";
	}
	if (!empty($src_details['zip_code']))
	{
		$zip_code = $db->rem_special_chars($src_details['zip_code']);
		$query[] = "MATCH (a.zip_code) AGAINST ('" . $zip_code . "*' IN BOOLEAN MODE)";
	}
	
	switch ($src_details['results_view'])
	{
		case 'all':
			break;
		case 'closed':
			$query[] = "a.closed=1";
			break;
		default:
			$query[] = "a.closed=0";
			break;
	}

	$parent_id = $src_details['parent_id'];
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
				$src_cats[] = intval($cat_array_id);
			}
		}
	
		$all_subcategories = $db->implode_array($src_cats, ', ', false);
	
		if ($setts['enable_addl_category'])
		{
			$query[] = "(a.category_id IN (" . $all_subcategories . ") OR a.addl_category_id IN (" . $all_subcategories . "))";
		}
		else
		{
			$query[] = "(a.category_id IN (" . $all_subcategories . "))";
		}
	}
	
	$sql_select_custom_boxes = $db->query("SELECT b.*, t.box_type AS box_type_name FROM " . DB_PREFIX . "custom_fields_boxes b, 
	" . DB_PREFIX . "custom_fields f, " . DB_PREFIX . "custom_fields_types t WHERE 
		f.active=1 AND f.page_handle='auction' AND f.field_id=b.field_id AND b.box_searchable=1 AND b.box_type=t.type_id");
	
	$is_searchable_boxes = $db->num_rows($sql_select_custom_boxes);
	if ($is_searchable_boxes)
	{
		(string) $custom_addl_vars = null;
		while ($custom_box = $db->fetch_array($sql_select_custom_boxes))
		{			
			if (!empty($src_details['custom_box_' . $custom_box['box_id']]))
			{
				$search_box = true;
				$box_id = $custom_box['box_id'];
				
				$where_query = " LEFT JOIN " . DB_PREFIX . "custom_fields_data cfd_" . $box_id . " 
					ON cfd_" . $box_id . ".owner_id=a.auction_id AND cfd_" . $box_id . ".page_handle='auction' " . $where_query;
				
				$custom_box_value = $db->rem_special_chars($src_details['custom_box_' . $custom_box['box_id']]);
				$custom_addl_vars .= '&custom_box_' . $custom_box['box_id'] . '=' . $custom_box_value;
								
				if (in_array($custom_box['box_type_name'], array('list', 'radio')))
				{
					$query[] = "cfd_" . $box_id . ".box_value = '" . $custom_box_value . "'";					
				}
				else if (in_array($custom_box['box_type_name'], array('checkbox')))
				{
					(array) $checkbox_query = null;
					if (is_array($src_details['custom_box_' . $custom_box['box_id']]))
					{
						foreach ($src_details['custom_box_' . $custom_box['box_id']] as $value)
						{
							if (!empty($value))
							{
								$checkbox_query[] = "(cfd_" . $box_id . ".box_value LIKE '%" . $value . "%')";
							}						
						}
					}
					
					if (count($checkbox_query) > 0) 
					{
						$query[] = "(" . $db->implode_array($checkbox_query, ' OR ') . ")";						
					}
					else 
					{
						$search_box = false;
					}
				}
				else 
				{
					$query[] = "(cfd_" . $box_id . ".box_value LIKE '%" . $custom_box_value . "%')";
				}

				if ($search_box)
				{
					$query[] = "cfd_" . $box_id . ".box_id='" . $box_id . "'";
				}
			}
		}
	}   
   
	if (!empty($src_details['item_type']))
	{
	   foreach ($item_types as $item_type)
	   {
	      if ($item_type['value'] == $src_details['item_type'] && $item_type['query'] != null)
	      {
	         $query[] = $item_type['query'];
	      }
	   }
	}

	if (count($query) > 0)
	{
		$where_query .= $operand . $db->implode_array($query, ' AND ');
	}
	
   return $where_query;
}


function browse_items_tab($selected, $file_path, $other_params, $parent_id = 0)
{
   $item_types = get_item_types();
   
   $output = '<div id="browse_tab"><ul> ';

   foreach ($item_types as $item_type)
   {
      $output .= '<li ' . (($item_type['value'] == $selected) ? 'class="selected"' : '') . '>'.
         '<a href="' . $file_path . '?item_type=' . $item_type['value'] . $other_params . '">' . $item_type['name'] . '</a>'.
         '</li>';
   }
   
   
   if ($parent_id)
   {
   	$output .= '<li><a href="wanted_ads.php?parent_id=' . $parent_id . '">' . MSG_SHOW_WANTED_ADS . '</a></li>';
   }

   $output .= '</ul></div>';

   return $output;
}

function set_browse_limit($limit)
{
	global $limits;
	
	return (in_array($limit, $limits)) ? $limit : $limits[0];
}

function set_item_type($item_type)
{
	global $item_types;	

	return (in_array($item_type, $item_types)) ? $item_type : $item_types[0];
}

function set_filter_link($src_details, $filter_values, $return_type = null, $direction = 'unset')
{
	$output = null;
	$default_filter = array('form_save_search' => '', 'form_delete_search' => '', 'search_id' => '');
	$filter_values = array_merge($default_filter, $filter_values);
	
	if ($direction == 'unset')
	{
		unset($src_details['rewrite_params']);
	}
	else 
	{
		$src_details = array();
	}
	
	if (is_array($filter_values))
	{
		foreach ($filter_values as $key => $value)
		{
			if ($direction == 'unset')
			{			
				if (empty($value))
				{
					unset($src_details[$key]);
				}
				else 
				{
					$src_details[$key] = $value;
				}
			}
			else 
			{
				$src_details[$key] = $value;
			}
		}
	}

	switch ($return_type)
	{
		case 'input':
			foreach ($src_details as $key => $value)			
			{
				if (!empty($key) && !empty($value))
				{
					$output .= '<input type="hidden" name="' . $key . '" value="' . $value . '"> ';
				}		
			}
			break;
		case 'address':
			foreach ($src_details as $key => $value)			
			{
				if (!empty($key) && !empty($value))
				{
					$output .= '&' . $key . '=' . $value;
				}		
			}
			break;
		
		default:
			$output = $src_details;
			break;
	}
	return $output;
}

function set_srcbox_categories($src_details)
{
	global $db, $category_lang;
	$user_query = (IS_SHOP && $src_details['user_id'] > 0) ? " AND (user_id=0 OR user_id='" . intval($src_details['user_id']) . "')" : " AND user_id=0";
	
	$categories_query = null;
	if (IS_SHOP)
	{
		$shop_categories = $db->get_sql_field("SELECT shop_categories FROM " . DB_PREFIX . "users 
			WHERE user_id='" . intval($src_details['user_id']) . "'", 'shop_categories');
		if (!empty($shop_categories) && !$src_details['parent_id']) 
		{
			$shop_categories = last_char($shop_categories);

			$categories_query = " AND category_id IN (" . $shop_categories . ")";
		}
	}

	$sql_select_categories = $db->query("SELECT category_id FROM " . DB_PREFIX . "categories 
		WHERE parent_id='" . intval($src_details['parent_id']) . "' 
      AND hidden='0' 
		" . (($src_details['parent_id'] == 0) ? "AND (enable_auctions=1 
         " . (($src_details['user_id']) ? " OR user_id='" . intval($src_details['user_id']) . "'" : ''). ") " : '') . " 
		" . $user_query . "		
		" . $categories_query . "		
		ORDER BY order_id ASC, name ASC");
		
	$output = null;

	if ($src_details['parent_id'])
	{
		$output .= '<tr class="c2">'.
			'	<td><b>' . MSG_SELECTED . '</b>: ' . category_navigator(intval($src_details['parent_id']), false, true, null, null, GMSG_NONE_CAT) . '</td>'.
			'</tr>';	
	}

	$additional_vars = set_filter_link($src_details, array('parent_id' => '', 'start' => ''), 'address');
	while ($cat_details = $db->fetch_array($sql_select_categories)) 
	{
		$subcat_link = basename($_SERVER['PHP_SELF']) . '?parent_id=' . $cat_details['category_id'] . $additional_vars;
		
		$output .= '<tr> '.
		'	<td class="contentfont">&nbsp;&raquo; <a href="' . $subcat_link . '">' . $category_lang[$cat_details['category_id']] . '</a></td> '.
		'</tr> ';
	}
	
	return $output;
}

function saved_searches_content($src_details, $user_id)
{
	global $db;
	$output = null;
	$selected = null;
	$search_id = null;

	$search_query = set_filter_link($src_details, array(), 'address');
	$search_query = basename($_SERVER['PHP_SELF']) . '?' . substr($search_query, 1);

	$show_dd = true;
	if ($src_details['form_delete_search'])
	{
		$db->query("DELETE FROM " . DB_PREFIX . "saved_searches 
			WHERE user_id='" . $user_id . "' AND id='" . $src_details['search_id'] . "'");
	}
	else if ($src_details['form_save_search'])
	{
		$is_search = $db->count_rows('saved_searches', "WHERE search_url='" . $db->rem_special_chars($search_query) . "' AND user_id='" . $user_id . "'");
		
		if (!$is_search)
		{
			$reg_date = CURRENT_TIME;
			$db->query("INSERT INTO " . DB_PREFIX . "saved_searches 
				(search_url, user_id, reg_date) VALUES 
				('" . $db->rem_special_chars($search_query) . "', '" . $user_id . "', '" . $reg_date . "')");	
			
			$id = $db->insert_id();
			$src_name = GMSG_SEARCH . ' ' . $id . ' - ' . show_date($reg_date);
			
			$db->query("UPDATE " . DB_PREFIX . "saved_searches SET name='" . $src_name . "' WHERE id='" . $id . "'");	
			
			$output = '<input type="text" name="name" size="50" value="' . $src_name . '" id="save_search_name" /> ' .
				'<input type="button" value="' . MSG_SAVE . '" ' .
				'	onclick="save_field(\'save_search_name\', \'save_search\', \'' . $src_name . '\', \'saved_searches\', \'id\', \'' . $id . '\', \'name\', \'user_id\');" />';
			$show_dd = false;
		}		
	}	
	
	if ($show_dd)
	{
		// now we create the drop-down with saved searches
		$sql_select_searches = $db->query("SELECT id, search_url, reg_date, name FROM " . DB_PREFIX . "saved_searches 
			WHERE user_id='" . $user_id . "' ORDER BY reg_date DESC");
		
		$src_drop_down = array();
		
		while ($saved_src = $db->fetch_array($sql_select_searches))
		{
			$src_drop_down[] = array(
				'id' => $saved_src['id'], 
				'caption' => ((empty($saved_src['name'])) ? GMSG_SEARCH . ' #' . $saved_src['id'] . ' - ' . show_date($saved_src['reg_date']) : $saved_src['name']), 
				'search_url' => $db->add_special_chars($saved_src['search_url'])
			);
		}
		
		$nb_searches = count($src_drop_down);
		
		$caption = null;
		$id = 0;
		if ($nb_searches)
		{
			$output .= '<select name="saved_search" id="saved_search_id" onchange="page_redirect(\'saved_search_id\');">'.
				'<option value="">' . MSG_SELECT_SAVED_SEARCH . '</option>';
				
			foreach ($src_drop_down as $option)
			{
				$selected = ($option['search_url'] == $search_query) ? 'selected' : '';
				$search_id = ($option['search_url'] == $search_query) ? $option['id'] : $search_id;
				$output .= '<option value="' . $option['search_url'] . '" ' . $selected . '>' . $option['caption'] . '</option>';
				
				if ($selected)
				{
					$caption = $option['caption'];
				}
			}
			$output .= '</select>';
		}

		if ($search_id)
		{
			$output = '<input type="hidden" name="search_id" value="' . $search_id . '" /> '.
				'<input type="submit" name="form_delete_search" value="' . MSG_DELETE_SEARCH . '" /> '.
				'<input type="button" name="form_edit_search" value="' . MSG_EDIT_NAME . '" '. 
				' onclick="edit_field(\'save_search\', \'' . $caption . '\', \'saved_searches\', \'id\', ' . $search_id . ', \'name\', \'user_id\');"/> ' . $output;
		}
		else 
		{
			$disabled = ($nb_searches >= MAX_SAVED_SEARCHES) ? 'disabled' : '';
			$output = '<input type="submit" name="form_save_search" value="' . MSG_SAVE_SEARCH . '" ' . $disabled . ' /> ' . $output;		
		}
	}
	
	return $output;
}
	

?>