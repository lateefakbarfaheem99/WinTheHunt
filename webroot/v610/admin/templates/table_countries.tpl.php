<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/tables.gif" align="absmiddle">
   <?=$header_section;?>
</div>
<?=$linkable_tables_box;?>
<?=$msg_changes_saved;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="3" class="fside">
   <form action="table_countries.php" method="post">
      <input type="hidden" name="parent_id" value="<?=$parent_id;?>">
      <tr class="c3">
         <td style="padding: 3px;"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b><?=$subpage_title;?></b></td>
      </tr>
		<? if (!$parent_id) { ?>
      <tr>
         <td><?=AMSG_COUNTRY_ISO_CODES_NOTE;?></td>
      </tr>
      <? } ?>
      <tr>
         <td><img src="images/info.gif" align="absmiddle" vspace="5" hspace="5"><?=AMSG_STATES_NOTE;?></td>
      </tr>
      <?=$state_header_message;?>
      <tr valign="top">
         <td align="center">
         	<table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
               <tr class="c4">
                  <td width="20">&nbsp;</td>
                  <td><?=AMSG_COUNTRY_NAME;?></td>
                  <td width="80" align="center"><?=AMSG_ISO_CODE;?></td>
                  <td width="80" align="center"><?=GMSG_ORDER;?></td>
                  <td width="80" align="center"><?=AMSG_DELETE;?></td>
               </tr>
               <?=$countries_page_content;?>
            </table></td>
      </tr>
      <tr class="c2">
         <td style="padding: 3px;" class="border"><b><?=($parent_id) ? ADD_STATE : AMSG_ADD_COUNTRY;?></b>
            <input name="new_name" type="text" id="new_name" size="60"></td>
      </tr>
      <tr>
         <td align="center" style="padding: 3px;"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>"></td>
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
