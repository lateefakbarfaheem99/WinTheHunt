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
include_once ('includes/class_item.php');
include_once ('includes/class_reputation.php');

if ($setts['enable_stores'])
{
	include_once ('global_header.php');
	
	$reputation = new reputation();
	$reputation->setts = &$setts;
	
	$header_stores_page = header5(MSG_STORES_DIRECTORY);
	$template->set('header_stores_page', $header_stores_page);## PHP Pro Bid v6.00 store search procedure
	(string) $addl_store_query = null;
	
	$option = 'store_search';
	$template->set('option', $option);

	if (!empty($_REQUEST['shop_name']))
	{
		$item_details['shop_name'] = $db->rem_special_chars($_REQUEST['shop_name']);
		$template->set('item_details', $item_details);
		
		$addl_store_query = "AND MATCH (shop_name) AGAINST ('" . $item_details['shop_name'] . "*' IN BOOLEAN MODE)";
		/**
		 * or the old and SLOW search using LIKE - disabled by default, just added the line in case 
		 * anyone might want to use this instead
		 */## PHP Pro Bid v6.00 $addl_store_query = "(shop_name LIKE '%" . $item_details['shop_name'] . "%')";
	}
		
	$template->set('search_options_title', MSG_STORE_SEARCH);
	$store_search_box = $template->process('search.tpl.php');
	$template->set('store_search_box', $store_search_box);
	
	$nb_stores = $db->count_rows('users', "WHERE active=1 AND shop_active=1 " . $addl_store_query);
	$template->set('nb_stores', $nb_stores);
	
	## now renew all store counters
	
	$sql_update_store_counters = $db->query_silent("UPDATE " . DB_PREFIX . "users SET shop_nb_items=(SELECT count(*) FROM " . DB_PREFIX . "auctions WHERE 
		active=1 AND closed=0 AND deleted=0 AND approved=1 AND list_in!='auction' AND creation_in_progress=0 AND owner_id=user_id) WHERE active=1 AND shop_active=1");
	
	if (!$sql_update_store_counters)
	{
		$db->query("UPDATE " . DB_PREFIX . "users SET shop_nb_items=0");
		
		$sql_select_store_items = $db->query("SELECT count(a.auction_id) AS nb_auctions, u.user_id FROM 
			" . DB_PREFIX . "auctions a, " . DB_PREFIX . "users u WHERE 
			u.active=1 AND u.shop_active=1 AND u.user_id=a.owner_id AND 
			a.active=1 AND a.closed=0 AND a.deleted=0 AND a.approved=1 AND a.list_in!='auction' AND a.creation_in_progress=0 GROUP BY u.user_id");
		
		while ($counter_details = $db->fetch_array($sql_select_store_items))
		{			
			$db->query("UPDATE " . DB_PREFIX . "users SET shop_nb_items='" . $counter_details['nb_auctions'] . "' WHERE 
				user_id='" . $counter_details['user_id'] . "'");
		}
	}
	
	## featured stores (show)		
	
	$select_condition = "LEFT JOIN " . DB_PREFIX . "fees_tiers s ON u.shop_account_id=s.tier_id 
		WHERE	u.active=1 AND u.shop_active=1 AND s.store_featured=1" . (($setts['hide_empty_stores']) ? " AND u.shop_nb_items>0" : ''); 

	$nb_featured_stores = $db->count_rows('users u', $select_condition);
	$template->set('nb_featured_stores', $nb_featured_stores);
	
	$feat_stores_details = $db->random_rows('users u', 'u.user_id, u.shop_name, u.shop_logo_path, u.shop_mainpage, u.username, u.shop_nb_items', $select_condition, 5);
	
	$max_featured_stores = min($nb_featured_stores, 5);
	
	(string) $featured_stores_table = null;
	for ($i=0; $i<$max_featured_stores; $i++)
	{
		$store_link = process_link('shop', array('name' => $feat_stores_details[$i]['shop_name'], 'user_id' => $feat_stores_details[$i]['user_id']));
		$store_logo = (!empty($feat_stores_details[$i]['shop_logo_path'])) ? $feat_stores_details[$i]['shop_logo_path'] : 'images/noimg.gif';

   	$featured_stores_table .= '<tr> '.
      	'	<td class="c1"><a href="' . $store_link . '"><img src="thumbnail.php?pic=' . $store_logo . '&w=80&sq=Y&b=Y" border="0" alt="' . $feat_stores_details[$i]['shop_name'] . '"></a></td> '.
      	'	<td valign="top" width="100%" class="c2"><table width="100%" border="0" cellspacing="0" cellpadding="3"> '.
         '		<tr> '.
			'			<td class="contentfont" width="100%"><a href="' . $store_link . '">' . $feat_stores_details[$i]['shop_name'] . '</a></td> '.
			'			<td nowrap>' . $feat_stores_details[$i]['shop_nb_items'] . ' ' . MSG_ITEMS . '</td> '.
         '		</tr> '.
         '		<tr class="c4"> '.
			'			<td colspan="2"></td> '.
			'		</tr> '.
         '		<tr> '.
			'			<td colspan="2">' . substr(strip_tags($db->add_special_chars($feat_stores_details[$i]['shop_mainpage']), '<br>'),0,300) . '...</td> '.
			'		</tr> '.
      	'	</table></td> '.
   		'</tr> ';
	}
	
	$template->set('featured_stores_table', $featured_stores_table);## PHP Pro Bid v6.00 all stores (show
	$order_field = 'shop_nb_items';
	$order_type = 'DESC';
	$limit = 20;
	
	$additional_vars = '&shop_name=' . $_REQUEST['shop_name'];
	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	
	$pagination = paginate($start, $limit, $nb_stores, 'stores.php', $additional_vars . $order_link);
	$template->set('pagination', $pagination);
	
	$sql_select_stores = $db->query("SELECT user_id, shop_name, shop_logo_path, shop_mainpage, username, shop_nb_items FROM " . DB_PREFIX . "users WHERE
		active=1 AND shop_active=1 " . $addl_store_query . 
		(($setts['hide_empty_stores']) ? " AND shop_nb_items>0" : '') . "
		ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);
	
	(string) $store_browse_table = null;
	while ($store_details = $db->fetch_array($sql_select_stores))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';
		
		$reputation_output = $reputation->calc_reputation($store_details['user_id']);
		
		$store_link = process_link('shop', array('name' => $store_details['shop_name'], 'user_id' => $store_details['user_id']));
		$store_logo = (!empty($store_details['shop_logo_path'])) ? $store_details['shop_logo_path'] : 'images/noimg.gif';
		
		$store_browse_table .= '<tr valign="top" class="contentfont"> '.
			'	<td align="center" width="120"><a href="' . $store_link . '"><img src="thumbnail.php?pic=' . $store_logo . '&w=80&sq=Y" border="0" alt="' . $store_details['shop_name'] . '"></a></td> '.
			'	<td><b><a href="' . $store_link . '">' . $store_details['shop_name'] . '</a></b><br>' . substr(strip_tags($db->add_special_chars($store_details['shop_mainpage']), '<br>'),0,110) . '...<br> '.
			'		<b>'. MSG_OWNER .'</b>: <a href="' . $store_link . '">' . $store_details['username'] . '</a><br> '.
			'		<b>'. MSG_ITEMS_LISTED .'</b>: ' . $store_details['shop_nb_items'] . '<br>'.
			'		<b>' . MSG_REPUTATION_RATING . '</b>: ' . $reputation_output['percentage'] . '</td> '.
			'</tr> '.
			'<tr> '.
			'	<td colspan="2" class="c4"><img src="themes/' . $setts['default_theme'] . '/img/pixel.gif" width="1" height="1"></td> '.
			'</tr> ';
	}
	
	$template->set('store_browse_table', $store_browse_table);
	
	$template_output .= $template->process('browse_stores.tpl.php');
	
	include_once ('global_footer.php');
	
	echo $template_output;
}
else 
{
	header_redirect('index.php');
}
?>