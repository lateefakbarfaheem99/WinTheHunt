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
function submit_form(form_name, file_type) {
	form_name.box_submit.value = "1";
	form_name.file_upload_type.value = file_type;
//	form_name.onsubmit();
	form_name.submit();
}

function delete_media(form_name, file_type, file_id) {
	form_name.box_submit.value = "1";
	form_name.file_upload_type.value = file_type;
	form_name.file_upload_id.value = file_id;
//	form_name.onsubmit();
	form_name.submit();
}

myPopup = '';

function openPopup(url) {
	myPopup = window.open(url,'popupWindow','width=750,height=480,scrollbars=yes,status=yes ');
	if (!myPopup.opener)
       	myPopup.opener = self;
}
</SCRIPT>
<?=$sell_item_header;?>
<br>
<?=$display_formcheck_errors;?>

<form action="<?=$post_url;?>" method="post" enctype="multipart/form-data" name="ad_create_form">
   <input type="hidden" name="do" value="<?=$do;?>" >
   <input type="hidden" name="box_submit" value="0" >
   <input type="hidden" name="file_upload_type" value="" >
   <input type="hidden" name="file_upload_id" value="" >
   <input type="hidden" name="wanted_ad_id" value="<?=$item_details['wanted_ad_id'];?>" >
	<input type="hidden" name="category_id" id="category_id" value="<?=$item_details['category_id'];?>">
	<input type="hidden" name="addl_category_id" id="addl_category_id" value="<?=$item_details['addl_category_id'];?>">
	<input type="hidden" name="old_category_id" value="<?=$old_category_id;?>">
	<input type="hidden" name="old_addl_category_id" value="<?=$old_addl_category_id;?>">
	<input type="hidden" name="start_time" value="<?=$item_details['start_time'];?>">
	<?=$media_upload_fields;?>
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	   <tr class="c4">
	      <td colspan="3"><?=MSG_MAIN_CATEGORY;?></td>
	   </tr>
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	      <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"></td>
	      <td class="contentfont" colspan="2"><span id="main_category_display"><?=$main_category_display;?></span>
	      	[ <a href="javascript:;"  onClick="select_category(document.getElementById('category_id').value, 'main_category_field', 'main_', false, true, 'wanted');"><?=GMSG_SELECT;?></a> ]</td>
	   </tr>
	   <tr class="c2" id="main_category_box">
	   	<td></td>
	   	<td id="main_category_field" colspan="2"></td>   	
	   </tr>	   
	   <tr class="reguser">
	      <td></td>
	      <td colspan="2"><?=MSG_CATEGORY_CHANGE_NOTE;?></td>
	   </tr>
	   <tr class="c4">
	      <td colspan="3"><?=MSG_ADDL_CATEGORY;?></td>
	   </tr>
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	      <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"></td>
	      <td class="contentfont" colspan="2"><span id="addl_category_display"><?=$addl_category_display;?></span>
	      	[ <a href="javascript:;"  onClick="select_category(document.getElementById('addl_category_id').value, 'addl_category_field', 'addl_', false, true, 'wanted');"><?=GMSG_SELECT;?></a> ]</td>
	   </tr>
	   <tr class="c2" id="addl_category_box">
	   	<td></td>
	   	<td id="addl_category_field" colspan="2"></td>   	
	   </tr>
	   <tr class="c4">
	      <td colspan="3"><?=MSG_ITEM_DETAILS;?></td>
	   </tr>
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	      <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_ITEM_TITLE;?></td>
	      <td colspan="2"><input name="name" type="text" id="name" value="<?=$item_details['name'];?>" size="60" maxlength="255" /></td>
	   </tr>
	   <tr class="reguser">
	      <td>&nbsp;</td>
	      <td colspan="2"><?=MSG_ITEM_TITLE_EXPL;?></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_ITEM_DESCRIPTION;?></td>
	      <td colspan="2"><textarea id="description_main" name="description_main" class="tinymce"><?=$item_details['description'];?></textarea></td>
	   </tr>
	   <tr class="reguser">
	      <td></td>
	      <td colspan="2"><?=MSG_ITEM_DESC_EXPL;?></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"><?=GMSG_DURATION;?></td>
	      <td colspan="2"><?=$duration_drop_down;?></td>
	   </tr>
	   <tr class="reguser">
	      <td></td>
	      <td colspan="2"><?=MSG_DURATION_EXPL;?></td>
	   </tr>
	   <?=$custom_sections_table;?>

		<? echo ($setts['max_images'] > 0) ? $image_upload_manager : ''; ?>
	   <tr class="c4">
	      <td colspan="3"><?=MSG_LOCATION;?></td>
	   </tr>
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
	      <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_COUNTRY;?> </td>
	      <td colspan="2"><?=$country_dropdown;?></td>
	   </tr>
	   <tr class="c2">
	      <td width="150" align="right"><?=MSG_STATE;?> </td>
	      <td colspan="2"><?=$state_box;?></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_ZIP_CODE;?> </td>
	      <td colspan="2"><input type="text" name="zip_code" value="<?=$item_details['zip_code'];?>" size="25" /></td>
	   </tr>
	</table>
	<br />
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td width="150" class="contentfont"><input name="form_edit_proceed" type="submit" id="form_edit_proceed" value="<?=GMSG_PROCEED;?>" />
         </td>
         <td class="contentfont"><?=$setup_fee_expl_message;?></td>
      </tr>
   </table>
</form>