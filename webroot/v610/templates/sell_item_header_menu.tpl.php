<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table width="100%" border="0" cellpadding="3" cellspacing="2" class="sellsteptab">
   <tr align="center">
      <td class="selldigit" width="<?=$header_menu_cell_width;?>">1</td>
      <td class="selldigit" width="<?=$header_menu_cell_width;?>">2</td>
      <td class="selldigit" width="<?=$header_menu_cell_width;?>">3</td>
      <td class="selldigit" width="<?=$header_menu_cell_width;?>">4</td>
      <td class="selldigit" width="<?=$header_menu_cell_width;?>">5</td>
		<!--      
      <? if ($ad_steps > 5) { ?>
      <td class="selldigit" width="<?=$header_menu_cell_width;?>">6</td>
      <? } ?>
      <? if ($ad_steps > 6) { ?>
      <td class="selldigit" width="<?=$header_menu_cell_width;?>">7</td>
      <? } ?>
		-->      
   </tr>
   <tr align="center">
		<!--   
      <td class="<? echo ($sale_step == 'main_category') ? 'sell1' : 'sell2'; ?>"><?=MSG_MAIN_CATEGORY;?></td>
      <? if ($setts['enable_addl_category']) { ?>
      <td class="<? echo ($sale_step == 'addl_category') ? 'sell1' : 'sell2'; ?>"><?=MSG_ADDL_CATEGORY;?></td>
      <? } ?>
      -->      
		<td class="<? echo ($sale_step == 'details') ? 'sell1' : 'sell2'; ?>"><?=MSG_ITEM_DETAILS;?></td>
      <td class="<? echo ($sale_step == 'settings') ? 'sell1' : 'sell2'; ?>"><?=MSG_ITEM_SETTINGS;?></td>
      <td class="<? echo ($sale_step == 'shipping') ? 'sell1' : 'sell2'; ?>"><?=MSG_SHIPPING_PAYMENT;?></td>
      <td class="<? echo ($sale_step == 'preview') ? 'sell1' : 'sell2'; ?>"><?=MSG_PREVIEW;?></td>
      <td class="<? echo ($sale_step == 'finish') ? 'sell1' : 'sell2'; ?>"><?=MSG_FINISH;?></td>
   </tr>
</table>