<?
#################################################################
## PHP Pro Bid v6.03															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$bid_history_header;?>
<?=$msg_changes_saved;?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="6" class="c3"><b><? echo MSG_BID_HISTORY_FOR . ' ' . $item_details['name'];?></b> </td>
   </tr>
   <tr class="c5">
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="125" height="1"></td>
      <? if ($session->value('adminarea')=='Active') { ?>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="125" height="1"></td>
      <? } ?>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <? if ($item_details['quantity']>1) { ?>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="180" height="1"></td>
      <? } ?>
      <? if ($item_details['owner_id']==$session->value('user_id') && $setts['enable_bid_retraction']) { ?>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="200" height="1"></td>
      <? } ?>
   </tr>
   <tr class="c4">
      <td><?=MSG_USERNAME;?></td>
      <td width="125" align="center"><?=MSG_BID_AMOUNT;?></td>
      <? if ($session->value('adminarea')=='Active') { ?>
      <td width="125" align="center"><?=MSG_PROXY_BID;?></td>
      <? } ?>
      <td align="center" width="150"><?=GMSG_DATE?></td>
      <? if ($item_details['quantity']>1) { ?>
      <td align="center" width="180"><?=MSG_QUANTITY_REQUESTED_AWARDED;?></td>
      <? } ?>
      <? if ($item_details['owner_id']==$session->value('user_id') && $setts['enable_bid_retraction']) { ?>
      <td align="center" width="200"><?=MSG_REMOVE_BIDS;?></td>
      <? } ?>
   </tr>

   <?=$bid_history_content;?>
</table>
<p align="center" class="contentfont"><a href="<?=process_link('auction_details', array('auction_id' => $item_details['auction_id']));?>">
   <?=MSG_RETURN_TO_AUCTION_DETAILS_PAGE;?></a></p>
