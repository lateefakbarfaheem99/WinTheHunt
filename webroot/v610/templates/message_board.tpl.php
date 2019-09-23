<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript">
	function enableBtn(theform) {
		if (theform.message.value!='') theform.add_message.disabled = false;
		else theform.add_message.disabled = true;
	}
</script>
<?=$members_area_header;?>
<? echo ($msg_changes_saved) ? $msg_changes_saved : '<br>';?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="2"><?=$message_title;?></td>
   </tr>
   <? if ($reverse_bid) { ?>
   <tr height="21">
      <td colspan="2" class="c4"><?=MSG_BID_DETAILS;?></td>
   </tr>
   <tr class="c1">
   	<td align="right"><?=MSG_BID_AMOUNT;?></td>	
   	<td><?=$bid_amount;?></td>
   </tr>
   <tr>
   	<td colspan="2"><?=$db->add_special_chars($bid_details['bid_description']);?></td>
   </tr>
	<tr class="c2">
		<td colspan="2" class="smallfont"><? echo MSG_DELIVERY_WITHIN . ' ' . field_display($bid_details['delivery_days'], GMSG_NA, $bid_details['delivery_days'] . ' ' . GMSG_DAYS) . '; ' . MSG_BID_DATE . ': ' . show_date($bid_details['bid_date']);?></td>
	</tr>
   <tr>
      <td colspan="2" class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <? } ?>
   <? if (!empty($direct_payment_box)) { ?>
   <tr height="21">
      <td colspan="2" class="c4"><strong><?=MSG_DIRECT_PAYMENT;?></strong></td>
   </tr>
   <tr>
      <td colspan="2" class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr>
      <td colspan="2" class="border"><?=$direct_payment_box;?></td>
   </tr>
   <? } ?>
   <? if (!empty($swap_description)) { ?>
   <tr height="21">
      <td colspan="2" class="c4"><strong><?=MSG_SWAP_DETAILS;?></strong></td>
   </tr>
   <tr>
      <td colspan="2" class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr>
      <td colspan="2" class="c1"><?=$swap_description;?></td>
   </tr>
   <? } ?>
   <?=$contact_details;?>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
   </tr>
   <?=$message_board_content;?>
   <tr class="c4">
      <td colspan="2"></td>
   </tr>
   <? if ($admin_message) { ?>
	<tr class="c2">
		<td></td>
		<td class="contentfont"><a href="content_pages.php?page=contact_us&topic_id=<?=$topic_id;?>"><?=MSG_RESPOND_BY_EMAIL;?></a></td>
	</tr>   
   <? } else if ($session->value('adminarea') != 'Active' && !$blocked_user) { ?>
   <tr class="c4">
      <td colspan="2"><b><?=MSG_ADD_MESSAGE;?></b></td>
   </tr>
   <form action="" method="post" name="message_board_form">
   	<input type="hidden" name="topic_id" value="<?=$topic_id;?>">
   	<input type="hidden" name="winner_id" value="<?=$winner_id;?>">
   	<input type="hidden" name="bid_id" value="<?=$bid_id;?>">
      <tr class="c2">
         <td colspan="2"><textarea id="message" style="width:100%" name="message" rows="5" onkeyup="enableBtn(message_board_form);"></textarea></td>
      </tr>
      <tr class="c1">
         <td colspan="2" align="center"><input type="submit" value="<?=MSG_ADD_MESSAGE;?>" name="add_message" id="add_message" disabled></td>
      </tr>
   </form>
   <? } else if ($blocked_user) { ?>
   <tr>
      <td align="center" colspan="2"><?=$block_reason_msg;?></td>
   </tr>   
   <? } else { ?>
   <tr>
      <td align="center" colspan="2"><?=MSG_MSGBOARD_LOGGED_AS_ADMIN;?></td>
   </tr>
   <? } ?>   
</table>

