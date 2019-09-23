<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/tools.gif" align="absmiddle">
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
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form action="block_free_emails.php" method="post">
      <tr>
         <td class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
            <?=strtoupper($subpage_title);?>
            </b></td>
      </tr>
      <tr valign="top">
         <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="1">
               <tr class="c4">
                  <td width="20">&nbsp;</td>
                  <td><b>
                     <?=AMSG_DOMAIN;?>
                     </b></td>
                  <td width="80" align="center"><b>
                     <?=AMSG_DELETE;?>
                     </b></td>
               </tr>
               <?=$blocked_domains_page_content;?>
            </table></td>
      </tr>
      <tr>
         <td class="c4"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2">
            <?=AMSG_ADD_DOMAIN;?></td>
      </tr>
      <tr>
         <td><table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
               <tr class="c2">
                  <td width="20">&nbsp;</td>
                  <td><input type="text" name="new_domain" size="50" /></td>
                  <td width="80" align="center">&nbsp;</td>
               </tr>
            </table></td>
      </tr>
      <tr>
         <td align="center"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>"></td>
      </tr>
   </form>
</table>
