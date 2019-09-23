<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<?=$header_registration_message;?>
<br>
<?=$invalid_login_message;?>
<table width="80%" border="0" cellpadding="5" cellspacing="5" align="center" class="contentfont">
   <tr valign="top">
	   <td>
	      <p align="center"><b><?=MSG_PROTECTED_PAGE_LOGIN_TITLE;?></b></p>
			<form action="protected_page.php" method="post">
		      <input type="hidden" name="operation" value="submit">
		      <input type="hidden" name="redirect_url" value="<?=$redirect_url;?>">
		      <input type="hidden" name="auction_id" value="<?=$auction_id;?>">
		      <input type="hidden" name="user_id" value="<?=$user_id;?>">
		      <input type="hidden" name="category_id" value="<?=$category_id;?>">
	      	<table border="0" cellpadding="2" cellspacing="2" align="center" class="border">
	      		<tr class="c1">
	            	<td><?=MSG_PASSWORD?></td>
	               <td><input name="password" type="password" id="password"></td>
	            	<td><input name="form_login_proceed" type="submit" id="form_login_proceed" value="<?=MSG_LOGIN;?>"></td>
				</table>
			</form>
		</td>
   </tr>
</table>  