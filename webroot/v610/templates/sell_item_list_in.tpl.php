<?
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr class="c4">
      <td colspan="3"><?=MSG_LIST_IN;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><input type="radio" name="list_in" value="auction" <? echo ($item_details['list_in'] == 'auction') ? 'checked' : ''; ?>></td>
      <td><b>
         <?=GMSG_SITE;?>
         </b></td>
   </tr>
   <tr class="reguser">
      <td></td>
      <td><?=MSG_LIST_IN_SITE_EXPL;?></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><input type="radio" name="list_in" value="store" <? echo ($item_details['list_in'] == 'store') ? 'checked' : ''; ?>></td>
      <td><b>
         <?=GMSG_SHOP;?>
         </b></td>
   </tr>
   <tr class="reguser">
      <td></td>
      <td><?=MSG_LIST_IN_SHOP_EXPL;?></td>
   </tr>
   <? if ($setts['store_listing_type'] == 0) { ?>
   <tr class="c1">
      <td width="150" align="right"><input type="radio" name="list_in" value="both" <? echo ($item_details['list_in'] == 'both') ? 'checked' : ''; ?>></td>
      <td><b>
         <?=GMSG_BOTH;?>
         </b></td>
   </tr>
   <tr class="reguser">
      <td></td>
      <td><?=MSG_LIST_IN_BOTH_EXPL;?></td>
   </tr>
   <? } ?>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr>
      <td></td>
      <td><?=nav_btns_position(false, false, true);?></td>
   </tr>
</table>
<br>
