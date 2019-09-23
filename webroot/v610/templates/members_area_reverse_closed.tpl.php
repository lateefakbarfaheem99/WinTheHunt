<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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
<? echo (!empty($msg_auction_relist)) ? $msg_auction_relist : '<br>';?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<form action="" method="post" name="closed_reverse_auctions">
	<input type="hidden" name="do" value="closed_reverse_proceed">
	<tr>
      <td colspan="8" class="c7"><b><?=MSG_MM_CLOSED_AUCTIONS;?></b> (<?=$nb_items;?> <?=MSG_ITEMS;?>)
      </td>
   </tr>
   <tr valign="top">
      <td class="membmenu"><?=MSG_AUCTION_ID;?><br><?=$page_order_reverse_id;?></td>
      <td class="membmenu"><?=MSG_ITEM_TITLE;?><br><?=$page_order_itemname;?></td>
      <td class="membmenu" align="center"><?=GMSG_START_TIME;?><br><?=$page_order_start_time;?></td>
      <td class="membmenu" align="center"><?=GMSG_END_TIME;?><br><?=$page_order_end_time;?></td>
      <td class="membmenu" align="center"><?=MSG_NR_BIDS;?><br><?=$page_order_nb_bids;?></td>
      <td class="membmenu" align="center" class="contentfont"><?=MSG_RELIST;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.closed_reverse_auctions['relist[]'], <?=$nb_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.closed_reverse_auctions['relist[]'], <?=$nb_items;?>, false);"><?=GMSG_NONE;?></a> ]</td>
      <td class="membmenu" align="center" class="contentfont"><?=GMSG_DELETE;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.closed_reverse_auctions['delete[]'], <?=$nb_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.closed_reverse_auctions['delete[]'], <?=$nb_items;?>, false);"><?=GMSG_NONE;?></a> ]</td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
   </tr>
   <?=$closed_reverse_content;?>
   <? if ($nb_items>0) { ?>
   <tr class="membmenu">
      <td colspan="8" align="center"><input type="submit" name="form_closed_proceed" value="<?=GMSG_PROCEED;?>" <?=$disabled_button;?> /></td>
   </tr>
   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
	</form>
</table>

