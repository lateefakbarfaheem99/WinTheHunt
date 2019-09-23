<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$search_transactions_box;?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="10" class="c7"><? echo ($page == 'summary') ? '<b>' . MSG_LAST_FIVE_LISTED_ITEMS . '</b>' : ((($section == 'bids_offers') ? (($page == 'bidding') ? '<b>' . MSG_MM_ITEMS_WITH_OFFERS . '</b>' : '<b>' . MSG_MM_ITEMS_WITH_BIDS . '</b>') : '<b>' . MSG_MM_OPEN_AUCTIONS . '</b>') . ' (' . $nb_items . ' ' . MSG_ITEMS . ')');?></td>
   </tr>
   <tr>
      <td class="membmenu" align="center"><?=MSG_PICTURE;?></td>
      <td class="membmenu"><?=MSG_AUCTION_ID;?><br><?=$page_order_auction_id;?></td>
      <td class="membmenu"><?=MSG_ITEM_TITLE;?><br><?=$page_order_itemname;?></td>
      <td class="membmenu" align="center"><?=GMSG_START_TIME;?><br><?=$page_order_start_time;?></td>
      <td class="membmenu" align="center"><?=GMSG_END_TIME;?><br><?=$page_order_end_time;?></td>
      <td class="membmenu" align="center"><?=MSG_NR_BIDS;?><br><?=$page_order_nb_bids;?></td>
      <? if ($page == 'selling' || $page == 'summary') { ?>
      <td class="membmenu" align="center"><?=MSG_AUTO_RELIST;?></td>
      <? } ?>
      <td class="membmenu" align="center"><?=MSG_START_BID;?><br><?=$page_order_start_bid;?></td>
      <td class="membmenu" align="center"><?=MSG_MAX_BID;?><br><?=$page_order_max_bid;?></td>
      <td class="membmenu" align="center"><?=GMSG_OPTIONS;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
      <? if ($page == 'selling' || $page == 'summary') { ?>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
      <? } ?>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="90" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="90" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="125" height="1"></td>
   </tr>
   <?=$open_auctions_content;?>
   <? if ($nb_items>0) { ?>
   <tr>
      <td colspan="10" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
</table>

