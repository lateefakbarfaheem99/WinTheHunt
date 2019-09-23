<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<div class="mainhead"><img src="images/stores.gif" align="absmiddle"> <?=$header_section;?></div>
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
      <td colspan="5" class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b><?=strtoupper(AMSG_STORES_MANAGEMENT);?></b></td>
   </tr>
   <tr>
      <td colspan="5">
      	<table border="0" cellpadding="3" cellspacing="3" class="border" align="center">
            <form action="stores_management.php" method="post">
               <tr class="c4">
                  <td colspan="3"><b><?=GMSG_USER_SEARCH;?></b></td>
               </tr>
               <tr class="c2">
                  <td><?=AMSG_USERNAME;?>
                     :</td>
                  <td><input name="keywords_name" type="text" id="keywords_name" value="<?=$keywords_name;?>" /></td>
                  <td><input name="form_user_search" type="submit" id="form_user_search" value="<?=GMSG_SEARCH;?>" /></td>
               </tr>
            </form>
         </table></td>
   </tr>
   <tr>
      <td colspan="5" align="center"><?=$query_results_message;?></td>
   </tr>
   <tr>
      <td colspan="5" align="center"><b><?=AMSG_FILTER_USERS;?></b>: <?=$filter_users_content;?></td>
   </tr>
   <tr class="c4">
      <td width="130"><?=AMSG_USERNAME;?>
         &nbsp;
         <?=$page_order_username;?></td>
      <td><?=AMSG_STORE_DETAILS;?></td>
      <td width="200" align="center"><?=AMSG_OPTIONS;?></td>
   </tr>
   <?=$stores_details_content;?>
   <tr>
      <td colspan="5" align="center"><?=$pagination;?></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>