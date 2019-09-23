<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<form action="" method="post" name="mailprefs_form">
   <input type="hidden" name="operation" value="submit">
   <input type="hidden" name="do" value="<?=$do;?>">
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="6" class="c7"><b>
            <?=MSG_MM_MAIL_PREFS;?>
            </b></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td colspan="2" width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_SENT_MSG_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="mail_messaging_sent" value="1" <? echo ($mail_prefs['mail_messaging_sent']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><?=MSG_SENT_MSG_NOTIF_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_RECEIVED_MSG_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="mail_messaging_received" value="1" <? echo ($mail_prefs['mail_messaging_received']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><?=MSG_RECEIVED_MSG_NOTIF_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ITEM_SOLD_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="mail_item_sold" value="1" <? echo ($mail_prefs['mail_item_sold']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><?=MSG_ITEM_SOLD_NOTIF_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ITEM_WON_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="mail_item_won" value="1" <? echo ($mail_prefs['mail_item_won']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><?=MSG_ITEM_WON_NOTIF_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_BID_PLACED_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="default_bid_placed_email" value="1" <? echo ($mail_prefs['default_bid_placed_email']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><?=MSG_BID_PLACED_NOTIF_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_OUTBID_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="mail_outbid" value="1" <? echo ($mail_prefs['mail_outbid']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><?=MSG_OUTBID_NOTIF_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_CONFIRM_TO_SELLER_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="mail_confirm_to_seller" value="1" <? echo ($mail_prefs['mail_confirm_to_seller']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><?=MSG_CONFIRM_TO_SELLER_NOTIF_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ITEM_CLOSED_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="mail_item_closed" value="1" <? echo ($mail_prefs['mail_item_closed']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><?=MSG_ITEM_CLOSED_NOTIF_EXPL;?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
         <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><input name="form_save_settings" type="submit" id="form_save_settings" value="<?=GMSG_PROCEED;?>" /></td>
      </tr>
   </table>
</form>
