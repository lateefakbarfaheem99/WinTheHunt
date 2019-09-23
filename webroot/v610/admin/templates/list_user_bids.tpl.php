<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/user.gif" align="absmiddle">
   <?=$header_section;?>
</div>
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
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr>
      <td colspan="8" class="c3" align="center"><b>
         <?=AMSG_VIEW_BIDS_PLACED_BY;?>
         [
         <?=$username;?>
         ] </b></td>
   </tr>
   <tr>
      <td colspan="8" align="center"><?=$query_results_message;?></td>
   </tr>
   <tr class="c4">
      <td width="70"><?=MSG_AUCTION_ID;?>
         <br>
         <?=$page_order_auction_id;?></td>
      <td><?=MSG_ITEM_TITLE;?></td>
      <td width="100" align="center"><?=MSG_BID_AMOUNT;?>
         <br>
         <?=$page_order_bid_amount;?></td>
      <td align="center" width="150"><?=GMSG_DATE?>
         <br>
         <?=$page_order_bid_date;?></td>
      <td align="center" width="60"><?=GMSG_QUANTITY;?></td>
      <td align="center" width="60"><?=AMSG_BID_STATUS;?></td>
      <td align="center" width="60"><?=AMSG_AUCTION_STATUS;?></td>
      <td align="center" width="200"><?=MSG_REMOVE_BIDS;?></td>
   </tr>
   <?=$bid_history_content;?>
   <tr>
      <td colspan="8" align="center"><?=$pagination;?></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
