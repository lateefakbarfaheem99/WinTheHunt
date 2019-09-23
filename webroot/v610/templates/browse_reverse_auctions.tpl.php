<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$header_reverse_auctions;?>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <form action="reverse_auctions.php" method="get">
      <input type="hidden" name="option" value="search">
      <tr>
         <td class="c3"><?=MSG_SEARCH_REVERSE_AUCTIONS;?></td>
      </tr>
      <tr>
         <td class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1 contentfont">
         <td><INPUT size="40" name="keywords_search" value="<?=$keywords_search;?>">
            &nbsp;
            <input name="form_search_proceed" type="submit" value="<?=GMSG_SEARCH;?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ <b><a href="members_area.php?page=reverse&section=new_auction">
            <?=MSG_MM_CREATE_REVERSE_AUCTION;?>
            </a></b> ] </td>
      </tr>
   </form>
</table>
<br>
<?=headercat($categories_header_menu);?>
<?=$category_logo;?>
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

<? if ($layout['r_catfeat_nb']) { ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
   <?
	$counter = 0;
	for ($i=0; $i<$featured_columns; $i++) { ?>
   <tr>
      <?
      for ($j=0; $j<$layout['r_catfeat_nb']; $j++) {
			$width = 100/$layout['r_catfeat_nb'] . '%'; ?>
      <td width="<?=$width;?>" align="center" valign="top" class="catfeatmaincell"><?
      	if (!empty($item_details[$counter]['name'])) {
      		$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
      			reverse_id='" . $item_details[$counter]['reverse_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

      		$auction_link = process_link('reverse_details', array('name' => $item_details[$counter]['name'], 'reverse_id' => $item_details[$counter]['reverse_id']));?>
         <table width="100%" border="0" cellspacing="2" cellpadding="5" class="catfeattable">
         	<!--
            <tr class="smallfont" height="<?=$layout['catfeat_width']+10;?>">
               <td align="center" class="catfeatpic"><a href="<?=$auction_link;?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['catfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" alt="<?=$item_details[$counter]['name'];?>"></a></td>
            </tr>
            -->
            <tr>
               <td class="catfeatc3"><b><a href="<?=$auction_link;?>"><?=$item_details[$counter]['name'];?></a></b></td>
            </tr>
            <tr>
               <td class="catfeatc1"><b>
                  <?=MSG_BUDGET;?>
                  :</b> <? echo $fees->budget_output($item_details[$counter]['budget_id'], null, $item_details[$counter]['currency']);?> <br>
                  <b>
                  <?=MSG_NR_BIDS;?>
                  :</b> <? echo $item_details[$counter]['nb_bids'];?> <br>
                  <b>
                  <?=MSG_ENDS;?>
                  :</b> <? echo show_date($item_details[$counter]['end_time']); ?> </td>
            </tr>
         </table>
         <? $counter++;
      	} ?></td>
      <? } ?>
   </tr>
   <? } ?>
</table>
<? } ?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr class="membmenu" valign="top">
   	<!--
      <td align="center"><?=MSG_PICTURE;?></td>
      -->
      <td><?=MSG_ITEM_TITLE;?>
         <br>
         <?=$page_order_itemname;?></td>
      <td align="center"><?=MSG_NR_BIDS;?>
         <br>
         <?=$page_order_nb_bids;?></td>
      <td align="center"><?=MSG_ENDS;?>
         <br>
         <?=$page_order_end_time;?></td>
   </tr>
   <tr class="<? echo (IS_SHOP == 1) ? 'c5_shop' : 'c5';?>">
   	<!--
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      -->
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
   </tr>
   <?=$browse_reverse_content;?>
   <? if ($nb_items>0) { ?>
   <tr>
      <td colspan="6" align="center"><?=$pagination;?></td>
   </tr>
   <? } ?>
</table>
