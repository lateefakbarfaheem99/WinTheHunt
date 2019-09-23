<?
#################################################################
## PHP Pro Bid v6.06															##
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
      <td colspan="6" class="c7"><b><?=MSG_MM_REVERSE_AUCTIONS . ' - ' . MSG_MM_AWARDED;?></b> (<?=$nb_items;?> <?=MSG_ITEMS;?>)</td>
   </tr>
   <tr valign="top">
      <td class="membmenu"><table border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
               <td><?=MSG_AUCTION_ID;?>
                  <br>
                  <?=$page_order_auction_id;?></td>
               <td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
               <td><?=MSG_ITEM_TITLE;?>
                  <br>
                  <?=$page_order_itemname;?></td>
            </tr>
         </table></td>
      <td class="membmenu" align="center"><?=MSG_WINNING_BID;?>
         <br>
         <?=$page_order_bid_amount;?></td>
      <td class="membmenu" align="center"><?=MSG_CONTACT_INFO;?></td>
      <td class="membmenu" align="center"><table border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
               <td><?=MSG_PURCHASE_DATE;?>
                  <br>
                  <?=$page_order_purchase_date;?></td>
               <td> / </td>
               <td><?=MSG_STATUS;?></td>
            </tr>
         </table></td>
      <td class="membmenu" align="center"><?=GMSG_OPTIONS;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="17%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="17%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="17%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="15%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <?=$reverse_awarded_content;?>
   <? if ($nb_items>0) { ?>
   <tr>
      <td colspan="6" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
   <? } ?>
</table>
