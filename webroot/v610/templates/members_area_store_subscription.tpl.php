<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<SCRIPT LANGUAGE="JavaScript"> 
	function previewPic(sel) { 
		document.preview_pic.src = "store_templates/images/" + sel.options[sel.selectedIndex].value + ".jpg?<?=rand(2,9999); ?>"; 
	} 
</SCRIPT>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="4" class="c7"><b>
         <?=MSG_MM_STORE;?>
         -
         <?=MSG_MM_MAIN_SETTINGS;?>
         </b></td>
   </tr>
   <tr class="c5">
      <td colspan="4"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr>
      <td colspan="4" class="membmenu"><b><?=MSG_STORE_STATUS;?></b>:
         <?=$shop_status['display'];?></td>
   </tr>
   <tr class="c1">
      <td align="right"><b><?=MSG_ACCOUNT_TYPE;?></b></td>
      <td class="contentfont"><b><?=$shop_status['account_type'];?></b> 
      	<? echo ($user_details['shop_account_id']>0) ? '[ <a href="fee_payment.php?do=store_subscription_payment">' . MSG_RENEW_SUBSCRIPTION . '</a> ]' : ''; ?> </td>
      <td align="right"><b><?=MSG_LAST_SUBSCR_PAYMENT;?></b></td>
      <td><?=show_date($user_details['shop_last_payment']); ?></td>
   </tr>
   <tr>
      <td>&nbsp;</td>
      <td><?=$shop_status['shop_description'];?></td>
      <td align="right" class="c1"><b><?=MSG_NEXT_SUBSCR_PAYMENT;?></b></td>
      <td class="c1"><?=show_date($user_details['shop_next_payment']); ?></td>
   </tr>
   <tr class="c5">
      <td width="20%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="30%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="20%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="30%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <? if ($shop_status['enabled'] && $shop_status['account_id']) { ?>
   <tr class="c1">
      <td align="right"><?=MSG_TOTAL_ITEMS;?></td>
      <td class="contentfont"><b><?=$shop_status['total_items'];?></b></td>
      <td align="right"><?=MSG_REMAINING_ITEMS;?></td>
      <td><b><?=$shop_status['remaining_items'];?></b></td>
   </tr>
	<tr class="c2"> 
		<td align="right"><b><?=MSG_YOUR_STORE_URL;?></b></td>
   	<td class="contentfont" colspan="3"> 
      	<a href="shop.php?user_id=<?=($user_details['user_id']);?>"><font color="#0000ff"><?=SITE_PATH;?>shop.php?user_id=<?=($user_details['user_id']);?></font></a> 
		</td> 
   </tr> 
   <? } ?>
</table>
<br>
<form action="members_area.php" method="POST" enctype="multipart/form-data" name="form_store_setup">
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   	<input type="hidden" name="page" value="store" />
   	<input type="hidden" name="section" value="subscription" />
		<input type="hidden" name="box_submit" value="0" >
		<input type="hidden" name="file_upload_type" value="" >
		<input type="hidden" name="file_upload_id" value="" >
		<input type="hidden" name="shop_template_id" value="<?=$user_details['shop_template_id'];?>" >
		<?=$media_upload_fields;?>
	   <tr>
	      <td colspan="2" class="c7"><b><?=MSG_SUBSCRIPTION_SETTINGS;?></b></td>
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
	   <? if ($user_details['shop_active'] && !$user_details['shop_account_id']) { ?>
	   <tr>
	      <td colspan="2"><?=MSG_STORE_DEFAULT_ACC_EXPL;?></td>
	   </tr>	
	   <tr class="c4">
	      <td colspan="2"></td>
	   </tr>	
	   <? } ?>
      <tr class="c1">
         <td align="right"><b><?=MSG_ENABLE_STORE;?></b></td>
         <td><input name="shop_active" type="checkbox" id="shop_active" value="1" <? echo ($user_details['shop_active']) ? 'checked' : ''; ?>></td>
      </tr>
      
      <? if ($shop_status['enabled'] && $shop_status['account_id']) { ?>         
		<?=$list_store_subscriptions;?>      
      <? } ?>
      
		<? if (allow_store_upgrade(session::value('user_id'))) { ?>
	   <tr>
	   	<td></td>
	      <td><?=MSG_ALLOW_STORE_SUBSCRIPTION_EXPL;?></td>
	   </tr>	
		<? } ?>
	   <tr>
	      <td colspan="2" class="c7"><b><?=MSG_STORE_SETTINGS;?></b></td>
	   </tr>	
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
	      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
	   </tr>
	   <tr class="c1">
         <td align="right"><?=MSG_STORE_NAME;?></td>
         <td><input type="text" name="shop_name" size="40" value="<?=$user_details['shop_name'];?>"></td>
      </tr>		
      <tr class="c1">
         <td align="right"><?=MSG_STORE_DESCRIPTION;?></td>
         <td><textarea id="shop_mainpage" name="shop_mainpage" class="tinymce"><?=$user_details['shop_mainpage'];?></textarea></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_PASSWORD;?></td>
         <td><input type="text" name="store_password" size="40" value="<?=$user_details['store_password'];?>"></td>
      </tr>		
      <tr>
         <td></td>
         <td><?=MSG_STORE_PASSWORD_EXPL;?></td>
      </tr>      
      <tr class="c1">
         <td align="right"><?=MSG_STORE_META_DESC;?></td>
         <td><textarea id="shop_metatags" name="shop_metatags" style="width: 400px; height: 100px;"><?=$user_details['shop_metatags'];?></textarea></td>
      </tr>
      <tr>
         <td></td>
         <td><?=MSG_STORE_META_DESC_EXPL;?></td>
      </tr>
	   <tr>
	      <td class="c7" colspan="2"><b><?=MSG_STORE_LOGO;?></b></td>
	   </tr>	
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
	      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
	   </tr>
      <tr class="c1">
         <td align="right"><?=MSG_CHOOSE_STORE_LOGO;?></td>
         <td><?=$image_upload_manager;?></td>
      </tr>
	   <tr>
	      <td class="c7" colspan="2"><b><?=MSG_STORE_DESIGNS;?></b></td>
	   </tr>	
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
	      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
	   </tr>
      <tr class="c1">
         <td align="right"><?=MSG_SELECT_DESIGN;?></td>
         <td><?=$store_templates_drop_down;?></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
		<tr class="c4">
			<td colspan="2"></td>
		</tr>    
      <tr>
         <td colspan="2"><input type="submit" name="form_shop_save" value="<?=GMSG_PROCEED;?>" onclick="return confirm('<?=MSG_CHANGE_STORE_SUBSCR_CONFIRM;?>');" /></td>
      </tr>
	</table>
</form>
