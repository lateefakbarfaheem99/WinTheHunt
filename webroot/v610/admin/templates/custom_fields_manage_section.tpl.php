<? 
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); } 
?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form action="custom_fields.php" method="post">
      <input type="hidden" name="page" value="<?=$page_handle;?>" />
      <input type="hidden" name="do" value="<?=$do;?>"  />
      <input type="hidden" name="section_id" value="<?=$section_id;?>"  />
      <input type="hidden" name="operation" value="submit" />
      <tr>
         <td colspan="2" class="c4"><b><?=$manage_section_title;?></b></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=AMSG_SECTION_NAME;?></td>
         <td width="100%"><input type="text" name="section_name" value="<?=$section_details['section_name'];?>" size="50" /> <input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>"></td>
      </tr>
   </form>
</table>