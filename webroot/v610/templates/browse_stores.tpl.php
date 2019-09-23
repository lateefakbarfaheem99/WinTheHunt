<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$header_stores_page;?>
<?=$store_search_box;?>
<br>
<? if ($nb_featured_stores) { ?>
<?=headercat(MSG_FEATURED_STORES);?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <?=$featured_stores_table;?>
</table>
<br>
<? } ?>
<?=headercat(MSG_ALL_STORES);?>
<table width="100%" border="0" cellpadding="0" cellspacing="6" class="border">
   <?=$store_browse_table;?>
   <? if ($nb_stores>0) { ?>
   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
</table>

