<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<? if (!empty($fees_calculator_result)) { ?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <?=$fees_calculator_result;?>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td colspan="2" width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
</table>
<? } ?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <form action="" method="post" name="fees_calculator_form">
      <tr>
         <td colspan="6" class="c7"><b><?=MSG_MM_FEES_CALCULATOR;?></b></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_AUCTION_STARTS_AT;?></td>
         <td colspan="2"><input name="start_price" type="text" id="start_price" value="<?=$item_details['start_price'];?>" size="8" />
            <?=$currency_drop_down;?></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_MAIN_CATEGORY;?></td>
         <td class="contentfont"><?=$categories_list_menu;?></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_ADDL_CATEGORY;?>
         </td>
         <td class="contentfont"><input name="addl_category_id" type="checkbox" value="1" <? echo ($item_details['addl_category_id'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_BUYOUT_PRICE;?>
         </td>
         <td class="contentfont"><input name="buyout_price" type="checkbox" value="1" <? echo ($item_details['buyout_price'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_RES_PRICE;?>
         </td>
         <td class="contentfont"><input name="reserve_price" type="checkbox" value="1" <? echo ($item_details['reserve_price'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_ADDL_IMAGES;?>
         </td>
         <td class="contentfont"><input name="is_image" type="checkbox" value="1" <? echo ($item_details['is_image'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_UPLOAD_MEDIA;?>
         </td>
         <td class="contentfont"><input name="is_video" type="checkbox" value="1" <? echo ($item_details['is_video'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_DIGITAL_GOODS;?>
         </td>
         <td class="contentfont"><input name="is_dd" type="checkbox" value="1" <? echo ($item_details['is_dd'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_HP_FEATURED;?>
         </td>
         <td class="contentfont"><input name="hpfeat" type="checkbox" value="1" <? echo ($item_details['hpfeat'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_CAT_FEATURED;?>
         </td>
         <td class="contentfont"><input name="catfeat" type="checkbox" value="1" <? echo ($item_details['catfeat'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_HL_AD;?>
         </td>
         <td class="contentfont"><input name="hl" type="checkbox" value="1" <? echo ($item_details['hl'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=MSG_BOLD_AD;?>
         </td>
         <td class="contentfont"><input name="bold" type="checkbox" value="1" <? echo ($item_details['bold'] == 1) ? 'checked' : '';?> /></td>
      </tr>
      <tr valign="top" class="c2">
         <td nowrap align="right"><?=GMSG_START_TIME;?>
         </td>
         <td class="contentfont"><input name="start_time_type" type="radio" value="now" checked />
            <?=GMSG_NOW;?>
            <input name="start_time_type" type="radio" value="custom" <? echo ($item_details['start_time_type'] == 'custom') ? 'checked' : '';?> />
            <?=GMSG_CUSTOM;?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
         <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><input name="form_save_settings" type="submit" id="form_save_settings" value="<?=GMSG_PROCEED;?>" /></td>
      </tr>
   </form>
</table>
