<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table border="0" cellpadding="2" cellspacing="2" width="100%" class="c1">
   <form action="login.php" method="post" name="loginbox">
      <input type="hidden" name="operation" value="submit">
      <input type="hidden" name="redirect" value="<?=$redirect;?>">
      <tr class="c2">
         <td align="right" class="user"><?=MSG_USERNAME;?></td>
         <td nowrap class="user"><input name="username" type="text" size="10">
         </td>
      </tr>
      <tr class="c2">
         <td align="right" nowrap class="user"><?=MSG_PASSWORD;?></td>
         <td nowrap class="user"><input name="password" type="password" size="10"></td>
      </tr>
      <tr >
         <td colspan="2" align="center"><input name="form_loginbox_proceed" id="form_loginbox_proceed" type="submit" value="<?=MSG_LOGIN_SMALL;?>"></td>
      </tr>
   </form>
</table>
