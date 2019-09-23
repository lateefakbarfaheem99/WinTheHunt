<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<? echo (!empty($category_logo)) ? $category_logo : '<div align="center" style="margin: 5px;">' . $banner_position[6] . '</div>';?>

<? if ($layout['catfeat_nb'] && count($item_details) > 0) { ?>
<table width="100%" border="0" cellpadding="0" cellspacing="3">
   <?
	$counter = 0;
	for ($i=0; $i<$featured_columns; $i++) { ?>
   <tr>
      <?
      for ($j=0; $j<$layout['catfeat_nb']; $j++) {
			$width = 100/$layout['catfeat_nb'] . '%'; ?>
      <td width="<?=$width;?>" align="center" valign="top" class="catfeatmaincell"><?
      	if (!empty($item_details[$counter]['name'])) {
      		$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
      			auction_id='" . $item_details[$counter]['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

      		$auction_link = process_link('auction_details', array('name' => $item_details[$counter]['name'], 'auction_id' => $item_details[$counter]['auction_id']));?>
         <table width="100%" border="0" cellspacing="2" cellpadding="5" class="catfeattable">
            <tr class="smallfont" height="<?=$layout['catfeat_width']+10;?>">
               <td align="center" class="catfeatpic"><a href="<?=$auction_link;?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['catfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" alt="<?=$item_details[$counter]['name'];?>"></a></td>
            </tr>
            <tr>
               <td class="catfeatc3"><b><a href="<?=$auction_link;?>"><?=$item_details[$counter]['name'];?></a></b></td>
            </tr>
            <tr>
               <td class="catfeatc1"><b>
                  <?=MSG_START_BID;?>
                  :</b> <? echo $fees->display_amount($item_details[$counter]['start_price'], $item_details[$counter]['currency']);?> <br>
                  <b>
                  <?=MSG_CURRENT_BID;?>
                  :</b> <? echo $fees->display_amount($item_details[$counter]['max_bid'], $item_details[$counter]['currency']);?> <br>
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
