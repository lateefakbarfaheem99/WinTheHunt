<?
#################################################################
## PHP Pro Bid v6.10															##
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

<div id="domMessage" style="display:none;"> 
    <p style="padding: 10px; font-size: 16px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold;"><?=MSG_OPERATION_IN_PROGRESS;?></p> 
</div>
<? if (isset($_POST['form_closed_proceed'])) { ?>
<script type="text/javascript">
   $(document).ready(function() {
      $.blockUI({ message: $('#domMessage') });

      setTimeout($.unblockUI, 500);
   });
</script>
<? } ?>

<? echo (!empty($msg_auction_relist)) ? $msg_auction_relist : '<br>';?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<form action="" method="post" name="closed_auctions">
	<input type="hidden" name="do" value="closed_proceed">
	<tr>
      <td colspan="6" class="c7"><b><?=MSG_MM_CLOSED_AUCTIONS;?></b> (<?=$nb_items;?> <?=MSG_ITEMS;?>)</td>
		<td colspan="2" align="center" nowrap class="c7 contentfont"><b><?=GMSG_SHOW;?></b>: <?=$filter_items_content;?></td>
   </tr>
   <tr class="membmenu">
      <td><?=MSG_AUCTION_ID;?><br><?=$page_order_auction_id;?></td>
      <td><?=MSG_ITEM_TITLE;?><br><?=$page_order_itemname;?></td>
      <td align="center"><?=GMSG_START_TIME;?><br><?=$page_order_start_time;?></td>
      <td align="center"><?=GMSG_END_TIME;?><br><?=$page_order_end_time;?></td>
      <td align="center"><?=MSG_NR_BIDS;?><br><?=$page_order_nb_bids;?></td>
      <td align="center"><?=MSG_MAX_BID;?><br><?=$page_order_max_bid;?></td>
      <td align="center" class="contentfont"><?=MSG_RELIST;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.closed_auctions['relist[]'], <?=$nb_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.closed_auctions['relist[]'], <?=$nb_items;?>, false);"><?=GMSG_NONE;?></a> ]</td>
      <td align="center" class="contentfont"><?=GMSG_DELETE;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.closed_auctions['delete[]'], <?=$nb_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.closed_auctions['delete[]'], <?=$nb_items;?>, false);"><?=GMSG_NONE;?></a> ]</td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
   </tr>
   <?=$closed_auctions_content;?>
   <? if ($nb_items>0) { ?>
   <tr class="membmenu">
      <td colspan="8" align="center" class="contentfont"><input type="submit" name="form_closed_proceed" value="<?=GMSG_PROCEED;?>" <?=$disabled_button;?> onclick="return confirm('<?=MSG_PROCEED_CONFIRM;?>');" /></td>
   </tr>

   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
	</form>
</table>

