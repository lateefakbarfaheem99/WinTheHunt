<?
#################################################################
## PHP Pro Bid v6.06															##
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
	<form action="members_area.php" method="post" name="reputation_sent">
	<input type="hidden" name="page" value="reputation">
	<input type="hidden" name="section" value="post">
	<tr>
      <td colspan="5" class="c7"><b><?=MSG_MM_LEAVE_COMMENTS;?></b> (<?=$nb_items;?> <?=MSG_ITEMS;?>)
      </td>
   </tr>
   <tr>
      <td class="membmenu" align="center"><?=MSG_USERNAME;?></td>
      <td class="membmenu" align="center"><?=MSG_AUCTION_ID;?></td>
      <td class="membmenu"><?=MSG_ITEM_TITLE;?></td>
      <td class="membmenu" align="center" class="contentfont"><?=MSG_TYPE;?></td>
      <td class="membmenu" align="center"><?=GMSG_SELECT;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.reputation_sent['reputation_id[]'], <?=$nb_auction_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.reputation_sent['reputation_id[]'], <?=$nb_auction_items;?>, false);"><?=GMSG_NONE;?></a> ]</td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="130" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
   </tr>
   <?=$reputation_sent_content;?>
   <? if ($nb_auction_items>0) { ?>
   <tr class="membmenu">
      <td colspan="8" align="center" class="contentfont"><input type="submit" name="form_reputation_post" value="<?=GMSG_PROCEED;?>" <?=$disabled_button;?> /></td>
   </tr>
   <tr>
      <td colspan="5" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
	</form>
</table>

