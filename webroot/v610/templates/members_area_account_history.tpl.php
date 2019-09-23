<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<SCRIPT LANGUAGE="JavaScript" SRC="includes/calendar.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">document.write(getCalendarStyles());</SCRIPT>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="6" class="c7"><b>
         <?=MSG_MM_ACCOUNT_HISTORY;?>
         </b></td>
   </tr>
   <tr class="c5">
      <td width="20%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="30%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="20%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="30%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr class="c1">
      <td align="right"><b>
         <?=GMSG_STATUS;?>
         </b></td>
      <td><?=$display_account_status;?></td>
      <td align="right"><b>
         <?=GMSG_REG_DATE;?>
         </b></td>
      <td><?=show_date($user_details['reg_date'], false);?></td>
   </tr>
   <tr class="c1">
      <td align="right"><b>
         <?=GMSG_PAYMENT_MODE;?>
         </b></td>
      <td><?=$display_payment_mode;?></td>
      <? if ($user_payment_mode == 2) { ?>
      <td align="right"><b>
         <?=GMSG_BALANCE;?>
         </b></td>
      <td class="contentfont"><?=$display_balance_details;?></td>
      <? } ?>
   </tr>
   <? if ($user_payment_mode == 2) { ?>
   <tr>
      <td></td>
      <td></td>
      <td align="right" class="c1"><b>
         <?=GMSG_MAX_DEBIT;?>
         </b></td>
      <td class="c1"><?=$fees->display_amount($user_details['max_credit'], $setts['currency'], true);?></td>
   </tr>
   <? } ?>
</table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <form action="members_area.php?page=account&section=history" method="POST" name="account_history_form">
      <tr class="c1">
         <td align="center"><b>
            <?=MSG_SELECT_PERIOD;?>
            :</b>
            <?=$start_date_box;?>
            -
            <?=$end_date_box;?>
            <input type="submit" name="form_display_history" value="<?=GMSG_PROCEED;?>"></td>
      </tr>
   </form>
</table>
<? if ($show_history_table) { ?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="membmenu" align="center"><?=MSG_ITEM_ID;?></td>
      <td class="membmenu"><?=MSG_INVOICE_NAME;?></td>
      <td class="membmenu" align="center"><?=MSG_INVOICE_TYPE;?></td>
      <td class="membmenu" align="center"><?=GMSG_DATE;?></td>
      <td class="membmenu" align="center"><?=GMSG_AMOUNT;?></td>
      <!--<td align="center"><?=GMSG_BALANCE;?></td>-->
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
      <!--<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="125" height="1"></td>-->
   </tr>
   <?=$history_table_content;?>
   <? if ($nb_invoices>0) { ?>
   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
   <? } ?>
</table>
<? } ?>
