<?
#################################################################
## PHP Pro Bid v6.04															##
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
   <tr>
      <td colspan="8" class="c7"><b><?=MSG_MM_WATCHED_ITEMS;?></b> (<?=$nb_items;?> <?=MSG_ITEMS;?>)
      </td>
   </tr>
	<form action="" method="post" name="watched_items">
   <tr>
      <td class="membmenu"><?=MSG_AUCTION_ID;?><br><?=$page_order_auction_id;?></td>
      <td class="membmenu"><?=MSG_ITEM_TITLE;?><br><?=$page_order_itemname;?></td>
      <td class="membmenu" align="center"><?=MSG_TIME_LEFT;?><br><?=$page_order_end_time;?></td>
      <td class="membmenu contentfont" align="center" nowrap><?=GMSG_DELETE;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.watched_items['delete[]'], <?=$nb_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.watched_items['delete[]'], <?=$nb_items;?>, false);"><?=GMSG_NONE;?></a> ]</td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
   </tr>
   <?=$watched_items_content;?>
   <? if ($nb_items>0) { ?>
   <tr class="membmenu">
      <td colspan="8" align="center" class="contentfont"><input type="submit" name="form_watched_proceed" value="<?=GMSG_PROCEED;?>" /></td>
   </tr>
   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
	</form>	
</table>

