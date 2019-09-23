<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<div id="exp1102170142">
<table width="100%" height="81" border="0" cellpadding="0" cellspacing="2" background="themes/<?=$setts['default_theme'];?>/img/userbg.gif">
   <form action="login.php" method="post" name="loginbox">
      <input type="hidden" name="operation" value="submit">
      <input type="hidden" name="redirect" value="<?=$redirect;?>">
      <tr>
      	  <tr> 
            <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="3"></td>
          </tr>
         <td align="right"><?=MSG_USERNAME;?></td>
         <td nowrap class="user"><input name="username" type="text" size="10" style="width:95px;">
         </td>
      </tr>
      <tr>
         <td align="right" nowrap><?=MSG_PASSWORD;?></td>
         <td nowrap class="user"><input name="password" type="password" size="10" style="width:95px;"></td>
      </tr>
      <tr >
         <td colspan="2" align="center"><input name="form_loginbox_proceed" id="form_loginbox_proceed" type="submit" value="<?=MSG_LOGIN_SMALL;?>"></td>
      </tr>
   </form>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="3"></div>
<div align="center" class="contentfont">
<a href="retrieve_password.php">
         <?=MSG_LOST_PASSWORD;?>
         </a> 
</div>
</div>