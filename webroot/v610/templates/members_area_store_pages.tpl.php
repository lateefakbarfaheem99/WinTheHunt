<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<br>
<form name="form_store_setup" action="members_area.php?page=store&section=store_pages" method="POST">
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td class="c7" colspan="2"><b>
            <?=MSG_MM_STORE_PAGES;?>
            </b></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      </tr>
      <? if ($display_formcheck_errors) { ?>
      <tr>
         <td colspan="2"><?=$display_formcheck_errors;?></td>
      </tr>
      <? } ?>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_NB_FEAT_ITEMS_ROW;?></td>
         <td><input type="text" name="shop_nb_feat_items_row" size="8" value="<?=$user_details['shop_nb_feat_items_row'];?>"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_NB_FEAT_ITEMS;?></td>
         <td><input type="text" name="shop_nb_feat_items" size="8" value="<?=$user_details['shop_nb_feat_items'];?>"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_NB_ENDING_ITEMS;?></td>
         <td><input type="text" name="shop_nb_ending_items" size="8" value="<?=$user_details['shop_nb_ending_items'];?>"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_NB_RECENT_ITEMS;?></td>
         <td><input type="text" name="shop_nb_recent_items" size="8" value="<?=$user_details['shop_nb_recent_items'];?>"></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_ABOUT_PAGE;?></td>
         <td><textarea id="shop_about" name="shop_about" class="tinymce"><?=$db->add_special_chars($user_details['shop_about']);?></textarea></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_SPECIALS;?></td>
         <td><textarea id="shop_specials" name="shop_specials" class="tinymce"><?=$db->add_special_chars($user_details['shop_specials']);?></textarea></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_SHIPPING_INFO;?></td>
         <td><textarea id="shop_shipping_info" name="shop_shipping_info" class="tinymce"><?=$db->add_special_chars($user_details['shop_shipping_info']);?></textarea></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_COMPANY_POILICIES;?></td>
         <td><textarea id="shop_company_policies" name="shop_company_policies" class="tinymce"><?=$db->add_special_chars($user_details['shop_company_policies']);?></textarea></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr>
         <td></td>
         <td><input type="submit" name="form_shop_save" value="<?=GMSG_PROCEED;?>" /></td>
      </tr>
   </table>
</form>
