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
      <td colspan="2"><?=MSG_ITEM_DETAILS;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <? if ($auction_edit == 1 || $edit_type == 'bulk_lister') { ?>
   <input type="hidden" name="listing_type" value="<?=$item_details['listing_type'];?>" />
   <? } else if ($item_details['list_in'] == 'store' && $setts['store_listing_type'] == 1) { ?>
   <input type="hidden" name="listing_type" value="buy_out" />
   <? } else { ?>
   <tr class="c1">
      <td width="150" align="right"><?=MSG_CHOOSE_LISTING_TYPE;?></td>
      <td><select name="listing_type" onChange = "submit_form(ad_create_form, '');">
	  			<option value="full" selected><?=MSG_FULL_LISTING;?></option>
	  			<option value="quick" <? echo ($item_details['listing_type']=='quick') ? 'selected' : ''; ?>><?=MSG_QUICK_LISTING;?></option>
	  			<? if ($setts['buyout_process'] == 1) { ?>
	  			<option value="buy_out" <? echo ($item_details['listing_type']=='buy_out') ? 'selected' : ''; ?>><?=MSG_BUY_OUT_ITEM;?></option>
	  			<? } ?>
	  			<? if ($setts['enable_fb_auctions'] && $item_details['list_in'] == 'auction') { ?>
	  			<option value="first_bidder" <? echo ($item_details['listing_type']=='first_bidder') ? 'selected' : ''; ?>><?=GMSG_FIRST_BIDDER;?></option>
	  			<? } ?>	  			
	  		</select></td>
   </tr>
   <tr class="reguser">
      <td>&nbsp;</td>
      <td>
      	<? echo ($setts['buyout_process'] == 1) ? MSG_CHOOSE_LISTING_TYPE_BUYOUT_EXPL : MSG_CHOOSE_LISTING_TYPE_EXPL;?>
			<? if ($setts['enable_fb_auctions'] && $item_details['list_in'] == 'auction') { ?>
  			<br><?=MSG_AUCTION_TYPE_FB_EXPL;?>
  			<? } ?>      	
      </td>
   </tr>
   <? } ?>
   <tr class="c1">
      <td width="150" align="right"><?=MSG_ITEM_TITLE;?></td>
      <td><input name="name" type="text" id="name" value="<?=$item_details['name'];?>" size="60" maxlength="255" /></td>
   </tr>
   <tr class="reguser">
      <td>&nbsp;</td>
      <td><?=MSG_ITEM_TITLE_EXPL;?></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><?=MSG_ITEM_DESCRIPTION;?></td>
      <td><textarea id="description_main" name="description_main" class="tinymce"><?=$item_details['description'];?></textarea></td>
   </tr>
   <tr class="reguser">
      <td></td>
      <td><?=MSG_ITEM_DESC_EXPL;?></td>
   </tr>
   <tr class="c4">
      <td colspan="2"><?=MSG_MAIN_CATEGORY;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"></td>
      <td class="contentfont"><span id="main_category_display"><?=$main_category_display;?></span>
      	[ <a href="javascript:;"  onClick="select_category(document.getElementById('category_id').value, 'main_category_field', 'main_', false, true, 'auction', document.getElementById('list_in').value);"><?=GMSG_SELECT;?></a> ]</td>
   </tr>
   <tr class="c2" id="main_category_box">
   	<td></td>
   	<td id="main_category_field"></td>   	
   </tr>
   <? if ($auction_edit == 1) { ?>
   <tr class="reguser">
      <td></td>
      <td><?=MSG_CATEGORY_CHANGE_NOTE;?></td>
   </tr>
   <? } ?>
   <? if ($setts['enable_addl_category']) { ?>
   <tr class="c4">
      <td colspan="2"><?=MSG_ADDL_CATEGORY;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><b><?=$second_cat_fee_expl_message;?></b></td>
      <td class="contentfont"><span id="addl_category_display"><?=$addl_category_display;?></span>
      	[ <a href="javascript:;"  onClick="select_category(document.getElementById('addl_category_id').value, 'addl_category_field', 'addl_', false, true, 'auction', document.getElementById('list_in').value);"><?=GMSG_SELECT;?></a> ]</td>
   </tr>
   <tr class="c2" id="addl_category_box">
   	<td></td>
   	<td id="addl_category_field"></td>   	
   </tr>
   <? } ?>
   <? if ($edit_type != 'bulk_lister') { ?>   
	<?=$setup_voucher_box;?>
	<? } ?>
	<? if ($auction_edit != 1) { ?>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr>
      <td></td>
      <td><?=nav_btns_position(false, false, $first_step);?></td>
   </tr>
   <? } ?>
</table>
<br>
