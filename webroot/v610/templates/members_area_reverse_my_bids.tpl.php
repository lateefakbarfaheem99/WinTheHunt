<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="8" class="c7"><? echo '<b>' . MSG_MM_MY_BIDS . '</b> (' . $nb_bids . ' ' . MSG_BIDS . ')';?></td>
   </tr>
   <tr>
      <td class="membmenu"><?=MSG_AUCTION_ID;?>
         <br>
         <?=$page_order_auction_id;?></td>
      <td class="membmenu"><?=MSG_ITEM_TITLE;?>
         <br>
         <?=$page_order_itemname;?></td>
      <td class="membmenu" align="center"><?=MSG_BID_AMOUNT;?>
         <br>
         <?=$page_order_bid_amount;?></td>
      <td class="membmenu" align="center"><?=GMSG_DATE;?>
         <br>
         <?=$page_order_bid_date;?></td>
      <td class="membmenu" align="center"><?=GMSG_STATUS;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
   </tr>
   <?=$current_bids_content;?>
   <? if ($nb_bids>0) { ?>
   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
</table>
