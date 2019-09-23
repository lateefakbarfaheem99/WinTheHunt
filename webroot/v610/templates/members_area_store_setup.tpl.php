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
<SCRIPT LANGUAGE="JavaScript">
function submit_form(form_name, file_type) {
	form_name.box_submit.value = "1";
	form_name.file_upload_type.value = file_type;
//	form_name.onsubmit();
	form_name.submit();
}

</SCRIPT>
<br>
<form name="form_store_setup" action="members_area.php?page=store&section=setup" method="POST" enctype="multipart/form-data" name="form_store_setup">
	<input type="hidden" name="box_submit" value="0" >
	<input type="hidden" name="file_upload_type" value="" >
	<input type="hidden" name="file_upload_id" value="" >
	<input type="hidden" name="shop_template_id" value="<?=$user_details['shop_template_id'];?>" >
	<?=$media_upload_fields;?>
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	   <tr>
	      <td colspan="2" class="c7"><b><?=MSG_MM_MAIN_SETTINGS;?></b></td>
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
      <tr>
         <td colspan="2"><input type="submit" name="form_shop_save" value="<?=GMSG_PROCEED;?>" /></td>
      </tr>
	</table>
</form>
