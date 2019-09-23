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
         <?=MSG_MM_REFUND_REQUESTS;?>
         </b></td>
   </tr>
   <tr>
      <td class="membmenu" align="center"><?=MSG_ITEM_ID;?></td>
      <td class="membmenu"><?=MSG_INVOICE_NAME;?></td>
      <td class="membmenu" align="center"><?=GMSG_AMOUNT;?></td>
      <td class="membmenu" align="center"><?=GMSG_REQUEST_DATE;?></td>
      <td class="membmenu" align="center"><?=GMSG_REFUND_STATUS;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
   </tr>
   <?=$refunds_table_content;?>
   <? if ($nb_invoices>0) { ?>
   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
   <? } ?>
</table>
