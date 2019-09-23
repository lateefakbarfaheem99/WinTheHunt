<?
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
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

(array) $auction_ids = null;


$nb_auctions = count($_REQUEST['auction_id']);

if (!$nb_auctions)
{
	header_redirect('index.php');
}
else 
{
	foreach ($_REQUEST['auction_id'] as $auction_id)
	{
		$auction_ids[] = intval($auction_id);
	}
	
	$item = new item();
	$item->setts = &$setts;
	
	include_once ('global_header.php');
	
	$template->set('nb_auctions', $nb_auctions);
	$template->set('redirect_url', $_REQUEST['redirect']);

	(string) $compared_items_content = null;
	
	$sql_select_auctions = $db->query("SELECT a.*, u.username FROM " . DB_PREFIX . "auctions a 
		LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id WHERE 
		auction_id IN (" . $db->implode_array($auction_ids) . ")");
	
	while ($item_details = $db->fetch_array($sql_select_auctions))
	{
		$width = 100/$nb_auctions . '%'; 
		
  		$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
  			auction_id='" . $item_details['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');
		
      $auction_link = process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));

      (string) $pm_methods = null;
  		if (!empty($item_details['direct_payment']))
		{
			$dp_methods = $item->select_direct_payment($item_details['direct_payment'], $user_details['user_id'], true, true);
			
			$pm_methods = $db->implode_array($dp_methods, ', ') . '<br>';
		}

		if (!empty($item_details['payment_methods']))
		{
			$offline_payments = $item->select_offline_payment($item_details['payment_methods'], true, true);

			$pm_methods .= $db->implode_array($offline_payments, ', ');
		}

      $compared_items_content .= '<td width="' . $width . '" align="center" valign="top" class="catfeatmaincell"> '.
         '<table width="100%" border="0" cellspacing="2" cellpadding="5" class="catfeattable"> '.
			'	<tr class="smallfont" height="110"> '.
			'		<td align="center" class="catfeatpic"><a href="' . $auction_link . '"><img src="' . (((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=100&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif')) . '" border="0" alt="' . $item_details['name'] . '"></a></td> '.
			'	</tr> '.
			'	<tr> '.
			'		<td class="catfeatc3"><b><a href="' . $auction_link . '">' . $item_details['name'] . '</a></b></td> '.
			'	</tr> '.
			'	<tr> '.
			'		<td class="catfeatc1"><b>' . GMSG_SELLER . ':</b> ' . $item_details['username'] . ' ' . user_pics($item_details['owner_id']) . ' </td> '.
			'	</tr> '.
			'	<tr> '.
			'		<td class="catfeatc1"><b>' . GMSG_START_TIME . ':</b> ' . show_date($item_details['start_time']) . ' <br> '.
			'			<b>' . GMSG_END_TIME . ':</b> ' . show_date($item_details['end_time']) . ' </td> '.
			'	</tr> '.
			'	<tr> '.
			'		<td class="catfeatc1"><b>' . MSG_START_BID . ':</b> ' . $fees->display_amount($item_details['start_price'], $item_details['currency']) . ' <br> '.
			'			<b>' . MSG_CURRENT_BID . ':</b> ' . $fees->display_amount($item_details['max_bid'], $item_details['currency']) . ' <br> '.
			'			<b>' . MSG_NR_BIDS . ':</b> ' . $item_details['nb_bids'] . '</td> '.
			'	</tr> '.
			'	<tr> '.
			'		<td class="catfeatc1"><b>' . GMSG_BUYOUT . ':</b> ' . (($item_details['buyout_price']<=0) ? GMSG_NO : GMSG_YES . ', <b>' . GMSG_PRICE . ': ' . $fees->display_amount($item_details['buyout_price'], $item_details['currency']) . '</b>') . ' </td> '.
			'	</tr> '.
			'	<tr> '.
			'		<td class="catfeatc1"><b>' . MSG_PAYMENT_METHODS . ':</b> <br>' . $pm_methods . ' </td> '.
			'	</tr> '.
			'	<tr> '.
			'		<td class="catfeatc1" align="center"><input type="checkbox" name="auction_id[]" value="' . $item_details['auction_id'] . '" checked></td> '.
			'	</tr> '.
			'</table></td> ';
	}

	$template->set('compared_items_content', $compared_items_content);
	$template_output .= $template->process('compare_items.tpl.php');
	
	include_once ('global_footer.php');
	
	echo $template_output;	
}


?>