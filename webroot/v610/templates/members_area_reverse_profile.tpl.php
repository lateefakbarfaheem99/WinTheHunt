<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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
</SCRIPT>
<br>
<form action="members_area.php" method="POST" enctype="multipart/form-data" name="form_provider_profile">
	<input type="hidden" name="page" value="reverse">
	<input type="hidden" name="section" value="my_profile">
	<input type="hidden" name="box_submit" value="0" >
	<input type="hidden" name="file_upload_type" value="" >
	<input type="hidden" name="file_upload_id" value="" >
   <input type="hidden" name="user_id" value="<?=$user_details['user_id'];?>" >
   <input type="hidden" name="profile_id" value="<?=$user_details['user_id'];?>" >
	<?=$media_upload_fields;?>
	
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<tr>
      <td colspan="3" class="c7"><b>
         <?=MSG_MM_PROFILE;?>
         </b></td>
   </tr>
	<tr>
      <td colspan="3"><?=MSG_PROVIDER_PROFILE_PAGE_EXPL;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td width="100%" colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <? if ($display_formcheck_errors) { ?>
   <tr>
      <td colspan="3"><?=$display_formcheck_errors;?></td>
   </tr>	
   <? } ?>
	<tr class="c1">
      <td align="right"><?=GMSG_DESCRIPTION;?></td>
      <td colspan="2"><textarea id="provider_profile" name="provider_profile" class="tinymce"><?=$db->add_special_chars($user_details['provider_profile']);?></textarea></td>
   </tr>
   <?=$custom_sections_table;?>

	<? if ($setts['max_portfolio_files'] > 0) { ?>
	<tr class="c4"> 
		<td colspan="3"><b><?=MSG_PORTFOLIO;?></b></td> 
	</tr> 
	<tr class="c5"> 
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td> 
		<td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td> 
	</tr> 
	<? echo $image_upload_manager; ?>
	<? } ?>
	<tr class="c5">
   	<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td width="100%" colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
	<tr>
      <td colspan="3"><input type="submit" name="form_profile_save" value="<?=GMSG_PROCEED;?>" /></td>
   </tr>
</table>
</form>
