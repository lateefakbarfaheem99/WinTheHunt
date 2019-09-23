<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript">
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=2,location=0,statusbar=1,menubar=0,resizable=0,width=750,height=525,left = 100,top = 134');");
}
</script>


<div class="mainhead"><img src="images/user.gif" align="absmiddle"> <?=$header_section;?></div>
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
   <tr>
      <td colspan="2"><?=$management_box;?></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr>
      <td colspan="5" align="center" style="padding: 10px;"><table border="0" cellpadding="3" cellspacing="3" class="border" align="center">
            <form action="list_site_users.php" method="post">
               <tr class="c3">
                  <td colspan="3"><?=GMSG_USER_SEARCH;?></td>
               </tr>
               <tr class="c2">
                  <td><?=AMSG_USERNAME;?>
                     :</td>
                  <td colspan="2"><input name="keywords_name" type="text" id="keywords_name" value="<?=$keywords_name;?>" /></td>
               </tr>
               <tr class="c1">
                  <td><?=AMSG_EMAIL_ADDR;?>
                     :</td>
                  <td><input name="keywords_email" type="text" id="keywords_email" value="<?=$keywords_email;?>" /></td>
                  <td><input name="form_user_search" type="submit" id="form_user_search" value="<?=GMSG_SEARCH;?>" /></td>
               </tr>
            </form>
         </table></td>
   </tr>
   <tr>
      <td colspan="5" align="center"><?=$query_results_message;?></td>
   </tr>
   <tr>
      <td colspan="5" align="center"><?=AMSG_FILTER_USERS;?>
         :
         <?=$filter_users_content;?></td>
   </tr>
   <tr>
      <td colspan="5">[ <a href="list_site_users.php?do=add_user">
         <?=AMSG_ADD_SITE_USER;?>
         </a> ]</td>
   </tr>
   <? if ($show == 'accounting_overdue_v2') { ?>
   <tr>
      <td colspan="5" align="center">[ <a href="list_site_users.php?do=payment_reminder_v2&show=accounting_overdue_v2">
         <?=AMSG_PAYMENT_REMINDER_ALL;?>
         </a> ]</td>
   </tr>
   <? } ?>
   <tr class="c4">
      <td width="130"><?=AMSG_USERNAME;?>
         &nbsp;
         <?=$page_order_username;?></td>
      <td width="240"><?=AMSG_USER_DETAILS;?>
         &nbsp;
         <?=$page_order_reg_date;?></td>
      <td align="center"><?=AMSG_ACCOUNT_DETAILS;?></td>
      <? if ($setts['enable_tax']) { ?>
      <td width="210" align="center"><?=GMSG_TAX_SETTINGS;?></td>
      <? } ?>
      <td width="110" align="center"><?=AMSG_OPTIONS;?></td>
   </tr>
   <?=$site_users_content;?>
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