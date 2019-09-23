<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table border="0" cellspacing="2" cellpadding="3" class="border">
   <tr>
      <td colspan="6" class="sellingtitle"><b><?=MSG_SELLING_TOTALS;?></b></td>
   </tr>
   <tr class="c1">
      <td><?=MSG_MM_SOLD_ITEMS;?>: <b><?=$nb_sold_items;?></b></td>
      <td><?=MSG_MM_OPEN;?>: <b><?=$nb_open_items;?></b></td>
      <td><?=MSG_MM_ITEMS_WITH_BIDS;?>: <b><?=$nb_items_bids;?></b></td>
      <td><?=MSG_MM_SCHEDULED;?>: <b><?=$nb_scheduled_items;?></b></td>
      <td><?=MSG_MM_CLOSED;?>: <b><?=$nb_closed_items;?></b></td>
      <td><?=MSG_MM_DRAFTS;?>: <b><?=$nb_drafts;?></b></td>
	</tr>
</table>
