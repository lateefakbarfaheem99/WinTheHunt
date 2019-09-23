<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="JavaScript">
function submit_form(form_name) {
	form_name.operation.value = '';
	form_name.submit();
}
</script>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form action="custom_fields.php" method="post" name="form_custom_box">
      <input type="hidden" name="page" value="<?=$page_handle;?>" />
      <input type="hidden" name="do" value="<?=$do;?>" />
      <input type="hidden" name="box_id" value="<?=$box_details['box_id'];?>" />
      <input type="hidden" name="operation" value="submit" />
      <tr>
         <td colspan="2" align="center" class="c3"><b><?=$manage_box_title;?></b></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=AMSG_BOX_NAME;?></td>
         <td width="100%"><input type="text" name="box_name" value="<?=$box_details['box_name'];?>" size="50" /> <?=AMSG_OPTIONAL_FIELD;?></td>
      </tr>
      <tr class="c2">
         <td nowrap><?=AMSG_BOX_TYPE;?></td>
         <td width="100%"><?=$box_types_list_menu;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=AMSG_BOX_VALUE;?></td>
         <td width="100%"><?=$box_type_listing;?></td>
      </tr>
      <tr class="c2">
         <td nowrap><?=AMSG_FIELD_NAME;?></td>
         <td width="100%"><?=$fields_list_menu;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=AMSG_MANDATORY;?></td>
         <td width="100%"><input name="mandatory" type="radio" value="1" <?=(($box_details['mandatory']) ? 'checked' : '');?> />  <?=GMSG_YES;?>
				<input name="mandatory" type="radio" value="0" <?=(($box_details['mandatory']) ? '' : 'checked');?> />  <?=GMSG_NO;?></td>
      </tr>
      <? if ($page_handle == 'auction') { //custom field search can only be enabled for custom auction fields ?> 
      <tr class="c2">
         <td nowrap><?=AMSG_SEARCHABLE;?></td>
         <td width="100%"><input name="box_searchable" type="radio" value="1" <?=(($box_details['box_searchable']) ? 'checked' : '');?> />  <?=GMSG_YES;?>
				<input name="box_searchable" type="radio" value="0" <?=(($box_details['box_searchable']) ? '' : 'checked');?> />  <?=GMSG_NO;?></td>
      </tr>
      <? } ?>
      <tr class="c1">
         <td nowrap><?=AMSG_FORMCHECK_FUNCTIONS;?></td>
         <td width="100%"><?=$display_formcheck_functions;?></td>
      </tr>
      <tr>
         <td colspan="2"><?=AMSG_BOX_VALUES_EXPLANATION;?></td>
      </tr>
      <tr>
         <td colspan="2" align="center"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>">
         </td>
      </tr>
   </form>
</table>
