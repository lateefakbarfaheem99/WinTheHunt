<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/fields.gif" align="absmiddle">
   <?=$header_section;?>
</div>
<?=$msg_changes_saved;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<?=$management_box;?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr>
      <td class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
         <?=strtoupper($subpage_title);?>
         </b></td>
   </tr>
   <form action="custom_fields_types.php" method="post">
      <tr>
         <td><table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
               <tr>
                  <td colspan="3" class="c7"><img src="images/a.gif" align="absmiddle" hspace="4" vspace="2"> <b>
                     <?=AMSG_DEFAULT_BOX_TYPES;?>
                     </b></td>
               </tr>
               <tr class="c4">
                  <td width="150"><?=AMSG_BOX_TYPE;?></td>
                  <td width="200"><?=AMSG_MAXFIELDS;?></td>
                  <td><?=AMSG_NOTES;?></td>
               </tr>
               <?=$default_box_types_content;?>
            </table>
            <br />
            <table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
               <tr>
                  <td colspan="5" class="c7"><img src="images/a.gif" align="absmiddle" hspace="4" vspace="2"> <b>
                     <?=AMSG_SPECIAL_BOX_TYPES;?>
                     </b></td>
               </tr>
               <tr>
                  <td width="150" class="c4"><?=AMSG_BOX_HANDLE;?></td>
                  <td width="200" class="c4"><?=AMSG_LINKED_TABLE;?></td>
                  <td width="100" class="c4"><?=AMSG_BOX_TYPE;?></td>
                  <td class="c4"><?=AMSG_BOX_VALUE_CODE;?></td>
                  <td width="150" align="center" class="c4"><?=AMSG_OPTIONS;?></td>
               </tr>
               <?=$special_box_types_content;?>
               <tr>
                  <td colspan="5">[ <a href="custom_fields_types.php?do=add_field_type"><?=AMSG_ADD_FIELD_TYPE;?></a> ]</td>
               </tr>
               <tr>
                  <td colspan="5" align="center"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>" <?=$disabled_button;?>></td>
               </tr>
            </table></td>
      </tr>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
