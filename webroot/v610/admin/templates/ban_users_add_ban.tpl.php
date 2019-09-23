<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript" src="../includes/main_functions.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript">

function submit_form(form_name, file_type) {
	form_name.box_submit.value = "1";
	form_name.file_upload_type.value = file_type;

	SelectOption(form_name.categories_id)

	form_name.submit();
}

function submit_form_b(form_name) {

	form_name.submit();
}
</SCRIPT>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form action="ban_users.php" method="post" name="form_content_bans">
      <input type="hidden" name="do" value="<?=$do;?>" />
      <input type="hidden" name="banned_id" value="<?=$banned_id;?>" >
      <tr>
         <td colspan="2" align="center" class="c4"><?=$manage_box_title;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_ADDRESS_TYPE;?></td>
         <td><? if ($address_type) {
         		echo ($address_type == 1) ? AMSG_IP_BAN : AMSG_EMAIL_BAN; ?>
            <input type="hidden" name="address_type" value="<?=$address_type;?>">
            <? } else { ?>
            <select name="address_type" onchange="submit_form_b(form_content_bans);">
               <option value="0" selected>
               <?=AMSG_SELECT_ADDRESS_TYPE;?>
               </option>
               <option value="1" <? echo ($address_type == 1) ? 'selected' : ''; ?>>
               <?=AMSG_IP_BAN;?>
               </option>
               <option value="2" <? echo ($address_type == 2) ? 'selected' : ''; ?>>
               <?=AMSG_EMAIL_BAN;?>
               </option>
            </select>
            <? } ?></td>
      </tr>
      <tr class="c3">
         <td></td>
         <td></td>
      </tr>
      <? if ($address_type) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_BANNED_ADDRESS;?></td>
         <td><input type="text" name="banned_address" value="<?=$ban_details['banned_address'];?>" size="50"></td>
      </tr>
      <tr>
         <td align="right" class="explain"><img src="images/info.gif"></td>
         <td class="explain"><? echo ($address_type == 1) ? AMSG_BANNED_ADDRESS_EXPL_IP : AMSG_BANNED_ADDRESS_EXPL_EMAIL;?></td>
      </tr>
      <tr>
         <td colspan="2" align="center" class="c3"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>">
         </td>
      </tr>
      <? } ?>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
<br />
