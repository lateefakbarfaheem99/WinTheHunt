<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="menu_shop">
   <tr align="center">
      <td class="bordermenu_shop"><a href="shop.php?user_id=<?=$user_id;?>">
         <?=MSG_STORE_HOME;?>
         </a></td>
      <td class="bordermenu_shop"><a href="shop.php?user_id=<?=$user_id;?>&page=shop_about">
         <?=MSG_STORE_ABOUT_PAGE;?>
         </a></td>
      <td class="bordermenu_shop"><a href="shop.php?user_id=<?=$user_id;?>&page=shop_specials">
         <?=MSG_STORE_SPECIALS?>
         </a></td>
      <td class="bordermenu_shop"><a href="shop.php?user_id=<?=$user_id;?>&page=shop_shipping_info">
         <?=MSG_STORE_SHIPPING_INFO;?>
         </a></td>
      <td class="bordermenu_shop"><a href="shop.php?user_id=<?=$user_id;?>&page=shop_company_policies">
         <?=MSG_STORE_COMPANY_POILICIES;?>
         </a></td>
      <td class="bordermenu_shop"><a href="other_items.php?owner_id=<?=$user_id;?>">
         <?=MSG_VIEW_AUCTIONS;?>
         </a></td>
      <td class="bordermenu_shop"><a href="user_reputation.php?user_id=<?=$user_id;?>">
         <?=MSG_VIEW_REPUTATION?>
         </a></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="search_shop" align="center"> 
	<form action="shop.php" method="get"> 
	<input type="hidden" name="user_id" value="<?=$user_id;?>">
	<tr> 
		<td nowrap align="center"><?=MSG_SEARCH_IN_SHOP;?> &nbsp; <INPUT size="25" name="keywords_search" value="<?=$keywords_search;?>"> &nbsp;  
			<input name="form_search_proceed" type="submit" value="<?=GMSG_SEARCH;?>"></td> 
	</tr> 
	</form> 
</table>
<br>
<? if ($user_details['shop_nb_feat_items'] && empty($page)) { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="feat_borders">
   <?
	$counter = 0;
	for ($i=0; $i<$featured_columns; $i++) { ?>
	<tr>
		<?
		$nb_hpfeat_row = ($user_details['shop_nb_feat_items_row'] > 0) ? $user_details['shop_nb_feat_items_row'] : $user_details['shop_nb_feat_items'];
		$width = 100/$nb_hpfeat_row . '%';	
		for ($j=0; $j<$nb_hpfeat_row; $j++) { 
			if (!empty($feat_item_details[$counter]['name'])) {
	      	$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
	      		auction_id='" . $feat_item_details[$counter]['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');
	
	      	$auction_link = process_link('auction_details', array('name' => $feat_item_details[$counter]['name'], 'auction_id' => $feat_item_details[$counter]['auction_id']));?>
		<td width="<?=$width;?>" align="center" valign="top"  class="c2_shop border_shop"> 
			<table width="100%" border="0" cellspacing="2" cellpadding="2" class="feat_borders"> 
				<tr><td colspan="2" class="c1_shop"><a href="<?=$auction_link;?>"><?=$feat_item_details[$counter]['name'];?></a></td></tr> 
				<tr class="smallfont_shop"> 
					<td align="center"><a href="<?=$auction_link;?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['hpfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" alt="<?=$feat_item_details[$counter]['name'];?>"></a></td> 
					<td valign="top" align="center" class="smallfont"><a href="<?=$auction_link;?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_bidding.gif" border="0" align="absmiddle" hspace="5"><br> 
						<b><?=MSG_BID_NOW;?></b></a> </td> 
				</tr> 
            <tr>
               <td class="c2_shop" nowrap align="right"><b><?=MSG_START_BID;?>
                  :</b></td>
               <td class="c2_shop" nowrap><? echo $fees->display_amount($feat_item_details[$counter]['start_price'], $feat_item_details[$counter]['currency']);?> </td>
            </tr>
            <tr>
               <td class="c3_shop" align="right"><b><?=MSG_CURRENT_BID;?>
                  :</b></td>
               <td class="c3_shop"><b><? echo $fees->display_amount($feat_item_details[$counter]['max_bid'], $feat_item_details[$counter]['currency']);?></b></td>
            </tr>
            <tr>
               <td colspan="2" class="c2_shop smallfont" align="center"><b>
                  <?=MSG_ENDS;?>
                  :</b> <? echo show_date($feat_item_details[$counter]['end_time']); ?> </td>
            </tr>
			</table> 
		</td> 
		<? } else { ?> 
		<td width="<?=$width;?>"></td>
		<? } ?>
		<? $counter++;
      } ?>
   </tr>
	<? } ?>
</table>
<br> 		
<? } ?>
<? if (!$parent_id && empty($page)) { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"> 
	<tr> 
		<td width="48%" valign="top"> 
			<? if ($user_details['shop_nb_ending_items'] && !$parent_id) { ?>
			<table width="100%" border="0" cellpadding="3" cellspacing="1" class="feat_borders"> 
			 	<tr height="17"> 
					<td width="100%" class="c1_shop" colspan="5">&nbsp;&raquo;&nbsp;<?=MSG_ENDING_SOON_AUCTIONS;?></td> 
				</tr> 
				<tr height="15" class="c4_shop"> 
					<td></td> 
					<td class="smallfont_shop" width="100%">&nbsp;<b><?=MSG_ITEM_TITLE;?></b></td> 
					<td class="smallfont_shop" nowrap>&nbsp;</td> 
				</tr> 
				<?=$shop_ending_auctions_content;?>
			</table> 
			<? } ?>
		</td> 
		<td width="4%" valign="top"> </td> 
		<td width="48%" valign="top"> 
			<? if ($user_details['shop_nb_recent_items'] && !$parent_id) { ?>
			<table width="100%" border="0" cellpadding="3" cellspacing="1" class="feat_borders"> 
			 	<tr height="17"> 
					<td width="100%" class="c1_shop" colspan="3">&nbsp;&raquo;&nbsp;<?=MSG_RECENTLY_LISTED_AUCTIONS;?></td> 
				</tr> 
				<tr height="15" class="c4_shop"> 
					<td></td> 
					<td class="smallfont_shop" nowrap="nowrap">&nbsp;<b><?=MSG_ITEM_TITLE;?></b></td> 
					<td class="smallfont_shop" nowrap>&nbsp;</td> 
				</tr> 
				<?=$shop_recent_auctions_content;?>   
			</table> 
			<? } ?>
		</td> 
	</tr> 
</table> 
<br>
<? } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="feat_borders">
	<tr>
		<td valign="top">
		