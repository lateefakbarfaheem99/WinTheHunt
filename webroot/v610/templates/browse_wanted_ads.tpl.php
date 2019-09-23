<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$header_wanted_ads;?>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <form action="wanted_ads.php" method="get">
      <input type="hidden" name="option" value="search">
      <tr>
         <td class="c3"><?=MSG_SEARCH_WANTED_ADS;?></td>
      </tr>
      <tr>
         <td class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1 contentfont">
         <td><INPUT size="40" name="keywords_search" value="<?=$keywords_search;?>">
            &nbsp;
            <input name="form_search_proceed" type="submit" value="<?=GMSG_SEARCH;?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ <b><a href="members_area.php?page=wanted_ads&section=new">
            <?=MSG_SUBMIT_WANTED_AD;?>
            </a></b> ] </td>
      </tr>
   </form>
</table>
<br>
<?=headercat($categories_header_menu);?>
<div id="exp11021709934728">
   <? if ($is_subcategories) { ?>
   <table width="100%" border="0" cellpadding="6" cellspacing="0" class="contentfont">
      <tr>
         <?=$subcategories_content;?>
      </tr>
   </table>
   <? } ?>
</div>
<noscript>
JS not supported
</noscript>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr class="membmenu" valign="top">
      <td align="center"><?=MSG_PICTURE;?></td>
      <td><?=MSG_ITEM_TITLE;?>
         <br>
         <?=$page_order_itemname;?></td>
      <td align="center"><?=MSG_NR_OFFERS;?>
         <br>
         <?=$page_order_nb_bids;?></td>
      <td align="center"><?=MSG_ENDS;?>
         <br>
         <?=$page_order_end_time;?></td>
   </tr>
   <tr class="<? echo (IS_SHOP == 1) ? 'c5_shop' : 'c5';?>">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
   </tr>
   <?=$browse_wanted_ads_content;?>
   <? if ($nb_items>0) { ?>
   <tr>
      <td colspan="6" align="center"><?=$pagination;?></td>
   </tr>
   <? } ?>
</table>
