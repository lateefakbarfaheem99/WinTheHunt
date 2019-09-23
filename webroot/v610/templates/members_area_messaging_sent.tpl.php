<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="Javascript">
<!--
function checkAll(field, array_len, check) {
	if (array_len == 1) {
		field.checked = check;
	} else {
		for (i = 0; i < array_len; i++)
			field[i].checked = check ;
	}
}
-->
</script>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<form action="" method="post" name="messages">
	<input type="hidden" name="do" value="delete_message">
	<input type="hidden" name="type" value="sender_deleted">
   <tr>
      <td colspan="8" class="c7"><b><?=MSG_MM_SENT_MESSAGES;?></b> (<?=$nb_messages;?> <?=MSG_MESSAGES;?>)
      </td>
   </tr>
   <tr>
      <td class="membmenu" nowrap><?=MSG_TO;?> <?=$page_order_receiver_username;?></td>
      <td class="membmenu"><?=MSG_SUBJECT;?></td>
      <td class="membmenu" align="center" nowrap><?=GMSG_DATE;?> <?=$page_order_reg_date;?></td>
      <td class="membmenu contentfont" align="center" nowrap><input type="submit" name="form_delete_messages" value="<?=GMSG_DELETE;?>" <? echo ($nb_messages) ? '' : 'disabled';?> />
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.messages['delete[]'], <?=$nb_messages;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.messages['delete[]'], <?=$nb_messages;?>, false);"><?=GMSG_NONE;?></a> ]</td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <?=$sent_messages_content;?>
   <? if ($nb_messages>0) { ?>
   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
	</form>
</table>

