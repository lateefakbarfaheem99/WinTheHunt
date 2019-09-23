<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_item.php');
include_once ('includes/functions_item.php');

$template->set('header_browse_auctions', (IS_CATEGORIES == 1) ? headercat($categories_header_menu) : $header_browse_auctions); 


$src_details = array_merge($_GET, $_POST);
$src_details = $db->rem_special_chars_array($src_details);
$src_details['keywords_search'] = (!empty($src_details['basic_search'])) ? $src_details['basic_search'] : $src_details['keywords_search'];

$src_details['limit'] = set_browse_limit($src_details['limit']);
$src_details['item_type'] = set_item_type($src_details['item_type']);

$template->set('src_details', $src_details);


$main_category_id = $db->main_category($src_details['parent_id']);
$category_details = $db->get_sql_row("SELECT image_path, minimum_age FROM " . DB_PREFIX . "categories 
	WHERE category_id='" . $main_category_id . "'");

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
   $search_saved = false;

   $saved_searches_content = null;
   if ($session->value('user_id'))
   {
      $saved_searches_content = saved_searches_content($src_details, $session->value('user_id'));
   }
   $template->set('saved_searches_content', $saved_searches_content);

   if (empty($order_field) || $order_field == 'a.end_time')
   {
      $order_field = 'a.list_in ASC, a.end_time ' . $order_type; 
      $order_type = null;
   }

   if (!empty($src_details['order_fld']))
   {
      switch ($src_details['order_fld'])
      {
         case 'order_recently_listed':
            if ($src_details['order_field'] == 'a.end_time' || empty($src_details['order_field']))
            {
               $order_field = 'a.start_time';
               $order_type = 'DESC';
            }
            break;
         default:
            if ($src_details['order_field'] == 'a.start_time' || empty($src_details['order_field']))
            {
               $order_field = 'a.end_time ASC';
               $order_type = '';
            }
            break;
      }	
   }

   $where_query = browse_filter_query($src_details, $where_query, $page_url);

   $address_filter_link = set_filter_link($src_details, array('start' => '', 'limit' => '', 'order_field' => ''), 'address');

   $template->set('page_order_itemname', page_order($page_url . '.php', 'a.name', $start, $src_details['limit'], $address_filter_link, MSG_ITEM_TITLE));
   $template->set('page_order_start_price', page_order($page_url . '.php', 'a.start_price', $start, $src_details['limit'], $address_filter_link, MSG_START_BID));
   $template->set('page_order_max_bid', page_order($page_url . '.php', 'a.max_bid', $start, $src_details['limit'], $address_filter_link, MSG_MAX_BID));
   $template->set('page_order_nb_bids', page_order($page_url . '.php', 'a.nb_bids', $start, $src_details['limit'], $address_filter_link, MSG_NR_BIDS));
   $template->set('page_order_end_time', page_order($page_url . '.php', 'a.end_time', $start, $src_details['limit'], $address_filter_link, MSG_ENDS));
   $template->set('page_order_start_time', page_order($page_url . '.php', 'a.start_time', $start, $src_details['limit'], $address_filter_link, MSG_LISTED_FOR));
   $template->set('page_order_current_price', page_order($page_url . '.php', 'current_price', $start, $src_details['limit'], $address_filter_link, MSG_CURRENT_PRICE));

   $template->set('form_action', $page_url . '.php');

   $hidden_sort = set_filter_link($src_details, array('order_fld' => ''), 'input');
   $template->set('hidden_sort', $hidden_sort);

   $subcategories_content = set_srcbox_categories($src_details);
   $template->set('subcategories_content', $subcategories_content);

   /* search box options */
   $custom_fld = new custom_field();

   $custom_fld->new_table = false;
   $custom_fld->box_search = 1;
   $custom_fld->src_box_display = true;
   $custom_fld->save_vars($src_details);
   $custom_sections_table = $custom_fld->display_sections($src_details, 'auction', false, 1, intval($src_details['parent_id']));
   $template->set('custom_sections_table', $custom_sections_table);

   $category_reset_link = ($src_details['parent_id']) ? '[ <a href="' . $page_url . '.php?parent_id=0' . set_filter_link($src_details, array('parent_id' => '', 'start' => ''), 'address') . '">' . MSG_RESET . '</a> ]' : '';
   $template->set('category_reset_link', $category_reset_link);

   $tax = new tax();		
   $template->set('country_dropdown', $tax->countries_dropdown('country', $src_details['country'], null, '', true, null, 0, 'src_input'));

   $hidden_src_array = array(
      'option' => $src_details['option'],
      'item_type' => $src_details['item_type'], 
      'order_fld' => $src_details['order_fld'], 
      //'start' => $src_details['start'], 
      'limit' => $src_details['limit'], 
      'user_id' => $src_details['user_id'], 
      'owner_id' => $src_details['owner_id'],
      'order_field' => $src_details['order_field'],
      'parent_id' => $src_details['parent_id']
   );

   $hidden_src = set_filter_link($src_details, $hidden_src_array, 'input', 'set');
   $template->set('hidden_src', $hidden_src);

   $search_browse_box = $template->process('search_browse_box.tpl.php');
   $template->set('search_browse_box', $search_browse_box);

   $nb_items = $db->get_sql_number("SELECT a.auction_id FROM " . DB_PREFIX . "auctions a " . $where_query . " GROUP BY a.auction_id");
   $template->set('nb_items', $nb_items);

   $template->set('redirect', $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);

   $item_types_tab_filter = set_filter_link($src_details, array('item_type' => '', 'start' => ''), 'address');
   $template->set('item_types_tab', browse_items_tab($src_details['item_type'], $page_url . '.php', $item_types_tab_filter));

   if ($nb_items)
   {
      $item = new item();
      $item->setts = &$setts;

      if (empty($force_index))
      {
         $force_index = item::force_index($order_field);
      }

      $order_field = ($order_field == 'current_price') ? 'IF(a.max_bid > a.start_price, a.max_bid, IF(a.auction_type=\'first_bidder\', a.fb_current_bid, a.start_price))' : $order_field;	

      $sql_select_auctions = $db->query("SELECT a.auction_id, a.name, a.start_price, a.max_bid, a.nb_bids, a.currency, 
         a.end_time, a.closed, a.bold, a.hl, a.buyout_price, a.is_offer, a.reserve_price, a.owner_id, a.postage_amount, 
         a.fb_current_bid, a.auction_type, a.start_time, a.is_relisted_item, a.enable_swap FROM 
         " . DB_PREFIX . "auctions a " . $force_index . " 
         " . $where_query . " 
         GROUP BY a.auction_id
         ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $src_details['limit']); 

      (string) $browse_auctions_content = null; //g
      while ($item_details = $db->fetch_array($sql_select_auctions))
      {
         if (IS_SHOP == 1)
         {
            $background = ($counter++%2) ? 'c2_shop' : 'c3_shop';
         }
         else 
         {
            $background = ($counter++%2) ? 'c1' : 'c2';
         }

         $background .= ($item_details['bold']) ? ' bold_item' : '';
         $background .= ($item_details['hl']) ? ' hl_item' : '';

         if ($page_url == 'auction_search')
         {
            $auction_link = 'auction_details.php?auction_search=1&auction_id=' . $item_details['auction_id'] . set_filter_link($src_details, array(), 'address');
         }
         else 
         {
            $auction_link = process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));
         }

         $media_url = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE auction_id=" . $item_details['auction_id'] . " AND 
            media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC", 'media_url');
         $auction_image = (!empty($media_url)) ? $media_url : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif';

         $current_price = ($item_details['auction_type'] == 'first_bidder') ? $item_details['fb_current_bid'] : max($item_details['start_price'], $item_details['max_bid']);

         $browse_auctions_content .= '<tr class="contentfont ' . $background . '"> '.
            '	<td align="center"><input type="checkbox" name="auction_id[]" value="' . $item_details['auction_id'] . '"></td> '.
            '	<td align="center"><a href="' . $auction_link . '"><img src="thumbnail.php?pic=' . $auction_image . '&w=' . $setts['browse_thumb_size'] . '&sq=Y&b=Y" border="0" width="' . $setts['browse_thumb_size'] . '" alt="' . $item_details['name'] . '"></a></td> '.
            '	<td><a href="' . $auction_link . '">' . $item_details['name'] . '</a> ' . 
            $item->relisted_tick($item_details['is_relisted_item']) . 
            item_pics($item_details) . '</td> '.
            '	<td align="center">' . $item_details['nb_bids'] . '</td> '.
            '	<td align="center">' . $fees->display_amount($current_price, $item_details['currency']) . '</td> '.
            (($src_details['order_fld'] == 'order_recently_listed') ? 
            '	<td align="center">' . time_left(CURRENT_TIME, $item_details['start_time'], true) . '</td> ' : 
            '	<td align="center">' . time_left($item_details['end_time'], CURRENT_TIME, true) . '</td> ').
            '</tr> ';
      }

      $pagination = paginate($start, $src_details['limit'], $nb_items, $page_url . '.php', set_filter_link($src_details, array('start' => ''), 'address')); 
      $template->set('pagination', $pagination); 

      $template->set('query_results_message', display_pagination_results($start, $src_details['limit'], $nb_items));
      $template->set('items_per_page', show_limit($src_details['limit'], $page_url . '.php', set_filter_link($src_details, array('limit' => '', 'start' => ''), 'address')));   
   }

   $template->set('browse_auctions_content', $browse_auctions_content);

   $template_output .= $template->process('browse_auctions.tpl.php');
}

?>