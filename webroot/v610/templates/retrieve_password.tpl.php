<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<?=$header_message;?>
<br>
<table width="80%" border="0" cellpadding="5" cellspacing="5" align="center" class="contentfont">
   <tr valign="top">
      <td width="50%" align="center" class="border c2"><?=$retrieve_password_msg;?>
      	<? if (!$submitted) { ?>
      	<br><b><?=MSG_REMEMBER_USERNAME_FORGOT_PASS;?></b>      	
         <form action="retrieve_password.php" method="post">
	         <input type="hidden" name="operation" value="retrieve_password">
         	<table width="100%" border="0" cellpadding="2" cellspacing="2" align="center">
               <tr>
                  <td align="right"><?=MSG_ENTER_YOUR_EMAIL?></td>
                  <td><input name="email" type="text" id="email" size="20" value="<?=$post_details['email'];?>"></td>
               </tr>
               <tr>
                  <td align="right"><?=MSG_ENTER_YOUR_USERNAME?></td>
                  <td><input name="username" type="text" id="username" size="20" value="<?=$post_details['username'];?>"></td>
               </tr>
               <tr>
                  <td colspan="2" align="center"><input name="form_retrieve_password_proceed" type="submit" id="form_retrieve_password_proceed" value="<?=MSG_RETRIEVE_YOUR_PASSWORD;?>"></td>
               </tr>
            </table>
         </form>
         <? } ?>
      </td>
      <td width="50%" align="center" class="border c2"><?=$retrieve_username_msg;?>
      	<? if (!$submitted) { ?>
      	<br><b><?=MSG_REMEMBER_PASS_FORGOT_USERNAME;?></b>      	
         <form action="retrieve_password.php" method="post">
	         <input type="hidden" name="operation" value="retrieve_username">
         	<table width="100%" border="0" cellpadding="2" cellspacing="2" align="center">
               <tr>
                  <td align="right"><?=MSG_ENTER_YOUR_EMAIL?></td>
                  <td><input name="email_address" type="text" id="email_address" size="20" value="<?=$post_details['email_address'];?>"></td>
               </tr>
               <tr>
                  <td colspan="2" align="center"><input name="form_retrieve_username_proceed" type="submit" id="form_retrieve_username_proceed" value="<?=MSG_RETRIEVE_YOUR_USERNAME;?>"></td>
               </tr>
            </table>
         </form>
         <? } ?>
      </td>
   </tr>
</table>
