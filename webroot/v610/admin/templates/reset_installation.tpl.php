<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/general.gif" align="absmiddle">
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
   <tr class="c3">
      <td colspan="2"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
         <?=strtoupper($subpage_title);?>
         </b></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form name="form_reset_installation" method="post" action="reset_installation.php">
      <tr>
         <td width="150" align="right"></td>
         <td><?=AMSG_RESET_INSTALLATION_EXPL;?></td>
      </tr>
      <tr class="c4">
         <td></td>
         <td></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=AMSG_ENTER_ADMIN_USERNAME;?></td>
         <td><input name="admin_username" type="text" id="admin_username" value="<?=$post_details['admin_username'];?>" size="40"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=AMSG_ENTER_ADMIN_PASSWORD;?></td>
         <td><input name="admin_password" type="password" id="admin_password" value="<?=$post_details['admin_password'];?>" size="40"></td>
      </tr>
      <tr align="center">
         <td colspan="2" valign="top"><input type="submit" name="form_save_settings" value="<?=GMSG_PROCEED;?>" onclick="return confirm('<?=AMSG_RESET_INSTALLATION_CONFIRM;?>');"></td>
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
