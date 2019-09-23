<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<br>
<? echo ($block_add_user_content) ? $block_add_user_content . '<br>' : ''; ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<tr>
      <td colspan="5" class="c7"><b><?=MSG_MM_BLOCK_USERS;?></b>
      </td>
   </tr>
   <tr>
      <td class="membmenu"><?=MSG_USERNAME;?></td>
      <td class="membmenu"><?=MSG_BLOCK_REASON;?></td>
      <td class="membmenu" align="center"><?=MSG_SHOW_REASON;?></td>
      <td class="membmenu" align="center"><?=MSG_BLOCK;?></td>
      <td class="membmenu" align="center" class="contentfont"><?=GMSG_OPTIONS;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="135" height="1"></td>
   </tr>
   <?=$blocked_users_content;?>
   <? if ($nb_items>0) { ?>
   <tr>
      <td colspan="5" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
   <tr class="c4">
      <td colspan="5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr class="contentfont">
      <td colspan="5">[ <a href="members_area.php?page=selling&section=block_users&do=add_user"><?=MSG_ADD_USER;?></a> ]</td>
   </tr>
</table>

