<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/tax.gif" align="absmiddle">
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
   <form action="tax_settings.php" method="post">
      <tr>
         <td class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
            <?=strtoupper($subpage_title);?>
            </b></td>
      </tr>
      <tr>
         <td><img src="images/info.gif" align="absmiddle">
            <?=AMSG_TAX_SETTINGS_NOTE;?></td>
      </tr>
      <tr>
         <td><table width="100%" border="0" cellpadding="3" cellspacing="1">
               <tr class="c4">
                  <td width="100"><?=AMSG_TAX_NAME;?></td>
                  <td width="70"><?=AMSG_TAX_RATE;?></td>
                  <td width="225"><?=AMSG_APPLIED_BY;?></td>
                  <td><?=AMSG_APPLIES_TO;?></td>
                  <td width="70" align="center"><?=AMSG_SITE_TAX;?></td>
                  <td width="120" align="center"><?=AMSG_OPTIONS;?></td>
               </tr>
               <?=$tax_settings_content;?>
            </table></td>
      </tr>
      <tr>
         <td>[ <a href="tax_settings.php?do=add_tax"><?=AMSG_ADD_TAX;?></a> ]</td>
      </tr>
      <tr>
         <td align="center"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>" <?=$disabled_button;?>></td>
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
