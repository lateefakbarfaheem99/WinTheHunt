<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<tr>
      <td colspan="6" class="c7"><b><?=MSG_MM_MY_REPUTATION;?></b> (<?=$nb_items;?> <?=strtolower(MSG_COMMENTS);?>)
      </td>
   </tr>
   <tr>
      <td class="membmenu" align="center"><?=MSG_FROM;?></td>
      <td class="membmenu" align="center"><?=MSG_RATE;?></td>
      <td class="membmenu" align="center"><?=GMSG_DATE;?></td>
      <td class="membmenu"><?=MSG_REVIEW;?></td>
      <td class="membmenu" align="center"><?=MSG_DETAILS;?></td>
      <td class="membmenu" align="center" class="contentfont"><?=MSG_TYPE;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="130" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="140" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
   </tr>
   <?=$reputation_received_content;?>
   <? if ($nb_items>0) { ?>
   <tr>
      <td colspan="6" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
</table>

