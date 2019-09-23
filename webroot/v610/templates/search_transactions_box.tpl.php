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
      <td class="c7" colspan="2"><b>
         <? echo ($src_box_type) ? MSG_AUCTION_SEARCH : MSG_SEARCH_TRANSACTIONS; ?>
         </b></td>
   </tr>
   <form action="members_area.php" method="post" name="search_transactions_form">   	
      <input type="hidden" name="do" value="search_transaction">
      <input type="hidden" name="page" value="<?=$page;?>">
      <input type="hidden" name="section" value="<?=$section;?>">      
      <input type="hidden" name="show" value="<?=$show;?>">
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
	      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	   </tr>
      <tr class="c1">
         <td align="right"><?=MSG_AUCTION_ID;?></td>
         <td><input type="text" name="src_auction_id" value="<?=$src_auction_id;?>" size="15"> (<?=MSG_EXACT_MATCHES_ONLY;?>)</td>
      </tr>
      <? if ($src_box_type) { ?>
      <tr class="c1">
         <td align="right"><?=MSG_ITEM_TITLE;?></td>
         <td><input type="text" name="src_item_title" value="<?=$src_item_title;?>" size="40"></td>
      </tr>
      <? } else { ?>
      <tr class="c1">
         <td align="right"><?=MSG_USERNAME;?></td>
         <td><input type="text" name="src_username" value="<?=$src_username;?>" size="15"> (<?=MSG_EXACT_MATCHES_ONLY;?>)</td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_SELECT_PERIOD;?></td>
         <td><?=$start_date_box;?> - <?=$end_date_box;?></td>
      </tr>
      <? } ?>
      <tr>
         <td colspan="2" class="c4"></td>
      </tr>
      <tr>
         <td colspan="2" class="contentfont"><input type="submit" value="<?=GMSG_PROCEED;?>" name="form_search_transactions"></td>
      </tr>
   </form>
</table>