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
      <td colspan="8" class="c7"><b><?=MSG_MM_KEYWORDS_WATCH;?></b> (<?=$nb_items;?> <?=MSG_KEYWORDS;?>)
      </td>
   </tr>
   <tr>
      <td colspan="8" class="contentfont">[ <a href="members_area.php?page=bidding&section=keywords_watch&option=add_keyword"><?=MSG_ADD_KEYWORD;?></a> ]
      </td>
   </tr>
	<form action="" method="post" name="keywords_watch">
   <? if ($option == 'add_keyword') { ?>
   <tr class="c1">
      <td align="right"><?=MSG_KEYWORD;?></td>
      <td colspan="2"><input type="text" name="keyword" value="" size="50"></td>
   </tr>
   <tr class="membmenu">
      <td align="right"></td>
      <td colspan="2"><input type="submit" name="form_keywords_watch_add_keyword" value="<?=MSG_ADD_KEYWORD;?>" /></td>
   </tr>
   <? } ?>
   <tr>
      <td class="membmenu" colspan="2"><?=MSG_KEYWORD;?><br><?=$page_order_keyword;?></td>
      <td class="membmenu contentfont" align="center"><?=GMSG_DELETE;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.keywords_watch['delete[]'], <?=$nb_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.keywords_watch['delete[]'], <?=$nb_items;?>, false);"><?=GMSG_NONE;?></a> ]</td>
   </tr>
   <tr class="c5">
      <td width="150"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
   </tr>
   <?=$keywords_watch_content;?>
   <? if ($nb_items>0) { ?>
   <tr class="membmenu">
      <td colspan="8" align="center" class="contentfont"><input type="submit" name="form_keywords_watch_proceed" value="<?=GMSG_PROCEED;?>" <? echo ($option == 'keyword') ? 'disabled' : '';?> /></td>
   </tr>
   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
	</form>	
</table>

