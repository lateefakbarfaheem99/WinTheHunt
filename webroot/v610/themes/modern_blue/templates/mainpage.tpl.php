<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

?>
<? if ($layout['hpfeat_nb']) { ?>
<?=$featured_auctions_header;?>

<table width="100%" border="0" cellpadding="3" cellspacing="3" >
   <?
	$counter = 0;
	for ($i=0; $i<$featured_columns; $i++) { ?>
   <tr>
      <?
      for ($j=0; $j<$layout['hpfeat_nb']; $j++) {
			$width = 100/$layout['hpfeat_nb'] . '%'; ?>
      <td width="<?=$width;?>" align="center" valign="top" class="border"><?
      	if (!empty($item_details[$counter]['name'])) {
      		$main_image = $feat_db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
      			auction_id='" . $item_details[$counter]['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

      		$auction_link = process_link('auction_details', array('name' => $item_details[$counter]['name'], 'auction_id' => $item_details[$counter]['auction_id']));?>
         <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
               <td class="feat1" nowrap align="right"><?=MSG_START_BID;?>
                  :</td>
               <td width="100%" class="feat2" nowrap><? echo $feat_fees->display_amount($item_details[$counter]['start_price'], $item_details[$counter]['currency']);?> </td>
            </tr>
            <tr height="<?=$layout['hpfeat_width']+12;?>">
               <td align="center" class="gradient"><a href="<?=$auction_link;?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['hpfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" alt="<?=$item_details[$counter]['name'];?>"></a></td>
               <td valign="top" class="smallfont"><?=MSG_CURRENT_BID;?>
                  :<? echo $feat_fees->display_amount($item_details[$counter]['max_bid'], $item_details[$counter]['currency']);?><br>
                  <b>
                  <?=MSG_ENDS;?>
                  :</b> <? echo show_date($item_details[$counter]['end_time']); ?><br>
                  <a href="<?=$auction_link;?>"><b>
                  <?=MSG_BID_NOW;?>
                  </b><img src="themes/<?=$setts['default_theme'];?>/img/bidnow.gif" border="0" align="absmiddle" hspace="5"></a> </td>
            </tr>
            <tr>
               <td colspan="2" class="feat3"><a href="<?=$auction_link;?>">&raquo;
                  <?=title_resize($item_details[$counter]['name']);?>
                  </a></td>
            </tr>
         </table>
         <? $counter++;
      	} ?></td>
      <? } ?>
   </tr>
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<? } ?>
<? if ($layout['r_hpfeat_nb'] && $setts['enable_reverse_auctions']) { ?>
<?=$featured_reverse_auctions_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" >
   <?
	$counter = 0;
	for ($i=0; $i<$featured_ra_columns; $i++) { ?>
   <tr>
      <?
      for ($j=0; $j<$layout['r_hpfeat_nb']; $j++) {
			$width = 100/$layout['r_hpfeat_nb'] . '%'; ?>
      <td width="<?=$width;?>" align="center" valign="top">
      	<?
      	if (!empty($ra_details[$counter]['name'])) {
      		$auction_link = process_link('reverse_details', array('name' => $ra_details[$counter]['name'], 'reverse_id' => $ra_details[$counter]['reverse_id']));?>
         <table width="100%" border="0" cellspacing="1" cellpadding="3">
           <tr>
               <td class="c3">&nbsp;&raquo;&nbsp;<a href="<?=$auction_link;?>"><?=title_resize($ra_details[$counter]['name']);?></a></td>
            </tr>
            <tr>
               <td class="c1 smallfont">
               	
               	<?=MSG_BUDGET;?>: <? echo $feat_fees->budget_output($ra_details[$counter]['budget_id'], null, $ra_details[$counter]['currency']);?> 
               	<br>
               	<?=MSG_NR_BIDS;?>: <? echo $ra_details[$counter]['nb_bids'];?>
               	<br>
               	<?=MSG_ENDS;?>: <? echo show_date($ra_details[$counter]['end_time']); ?>
               	</td>
            </tr>
         </table>
         <? $counter++;
      	} ?></td>
      <? } ?>
   </tr>
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<? } ?>
<? if ($layout['nb_recent_auct']) { ?>
<?=$recent_auctions_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
   <tr class="c4" height="15">
      <td></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b>
         <?=GMSG_START_TIME;?>
         </b></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b>
         <?=MSG_START_BID;?>
         </b></td>
      <td class="smallfont" width="100%">&nbsp;<b>
         <?=MSG_ITEM_TITLE;?>
         <b></td>
      <td class="smallfont" nowrap>&nbsp;</td>
   </tr>
   <?
	while ($item_details = mysql_fetch_array($sql_select_recent_items))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';
		$background .= ($item_details['bold']) ? ' bold_item' : '';
		$background .= ($item_details['hl']) ? ' hl_item' : ''; ?>
   <tr height="15" class="<?=$background;?>">
      <td width="11"><img src="themes/<?=$setts['default_theme'];?>/img/arr_it.gif" width="11" height="11" hspace="4"></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b>
         <?=show_date($item_details['start_time']);?>
         </b></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;
         <?=$fees->display_amount($item_details['start_price'], $item_details['currency']);?></td>
      <td class="smallfont" width="100%">&nbsp;<a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>">
         <?=title_resize($item_details['name']);?>
         </a></td>
      <td nowrap><?=item_pics($item_details);?></td>
   </tr>
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<? } ?>
<? if ($layout['nb_popular_auct'] && $is_popular_items) { ?>
<?=$popular_auctions_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
   <tr class="c4" height="15">
      <td></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b>
         <?=MSG_MAX_BID;?>
         </b></td>
      <td class="smallfont" width="100%">&nbsp;<b>
         <?=MSG_ITEM_TITLE;?>
         <b></td>
      <td class="smallfont" nowrap>&nbsp;</td>
   </tr>
   <? 
	while ($item_details = mysql_fetch_array($sql_select_popular_items))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';
		$background .= ($item_details['bold']) ? ' bold_item' : '';
		$background .= ($item_details['hl']) ? ' hl_item' : ''; ?>
   <tr height="15" class="<?=$background;?>">
      <td width="11"><img src="themes/<?=$setts['default_theme'];?>/img/arr_it.gif" width="11" height="11" hspace="4"></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;
         <?=$fees->display_amount($item_details['max_bid'], $item_details['currency']);?></td>
      <td class="smallfont" width="100%">&nbsp;<a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>">
         <?=title_resize($item_details['name']);?>
         </a></td>
      <td nowrap><?=item_pics($item_details);?></td>
   </tr>
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<? } ?>
<? if ($layout['nb_ending_auct']) { ?>
<?=$ending_auctions_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
   <tr class="c4" height="15">
      <td></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b>
         <?=MSG_TIME_LEFT;?>
         </b></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b>
         <?=MSG_CURRENTLY;?>
         <b></td>
      <td class="smallfont" width="100%">&nbsp;<b>
         <?=MSG_ITEM_TITLE;?>
         <b></td>
      <td class="smallfont" nowrap>&nbsp;</td>
   </tr>
   <?
	while ($item_details = mysql_fetch_array($sql_select_ending_items))
	{
		$item_details['max_bid'] = ($item_details['max_bid'] > 0) ? $item_details['max_bid'] : $item_details['start_price'];
		
		$background = ($counter++%2) ? 'c1' : 'c2';
		$background .= ($item_details['bold']) ? ' bold_item' : '';
		$background .= ($item_details['hl']) ? ' hl_item' : ''; ?>
   <tr height="15" class="<?=$background;?>">
      <td width="11"><img src="themes/<?=$setts['default_theme'];?>/img/arr_it.gif" width="11" height="11" hspace="4"></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;
         <?=time_left($item_details['end_time']);?></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;
         <?=$fees->display_amount($item_details['max_bid'], $item_details['currency']);?></td>
      <td class="smallfont" width="100%">&nbsp;<a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>">
         <?=title_resize($item_details['name']);?>
         </a></td>
      <td nowrap><?=item_pics($item_details);?></td>
   </tr>
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<? } ?>
<? if ($layout['nb_want_ads']) { ?>
<?=$recent_wa_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
   <tr class="c4" height="15">
      <td></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b>
         <?=GMSG_START_TIME;?>
         </b></td>
      <td class="smallfont" width="100%">&nbsp;<b>
         <?=MSG_ITEM_TITLE;?>
         <b></td>
   </tr>
   <?
	while ($item_details = mysql_fetch_array($sql_select_recent_wa))
	{
		$background = ($counter++%2) ? 'c1' : 'c2'; ?>
   <tr height="15" class="<?=$background;?>">
      <td width="11"><img src="themes/<?=$setts['default_theme'];?>/img/arr_it.gif" width="11" height="11" hspace="4"></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b>
         <?=show_date($item_details['start_time']);?>
         </b></td>
      <td class="smallfont" width="100%">&nbsp;<a href="<?=process_link('wanted_details', array('name' => $item_details['name'], 'wanted_ad_id' => $item_details['wanted_ad_id']));?>">
         <?=title_resize($item_details['name']);?>
         </a></td>
   </tr>
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<? } ?>
</td>
<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="5" height="1"></td>
<td width="178"><? if ($member_active != 'Active') { ?>
   <div><a href="<?=process_link('register');?>"><img src="themes/<?=$setts['default_theme'];?>/img/tips.gif" width="178" height="107" border="0"></a></div>
   <? } ?>
   <? if ($setts['enable_header_counter']) { ?>
   <table width='100%' border='0' cellpadding='2' cellspacing='1' bgcolor='#0A57AD' style='color: #1863BD; font-weight: bold;'>
      <tr bgcolor='#C7E3FF'>
         <td width='20%' align='center'><b>
            <?=$nb_site_users;?>
            </b></td>
         <td width='80%'>&nbsp;<font style='font-size: 10px;'>
            <?=MSG_REGISTERED_USERS;?>
            </font></td>
      </tr>
      <tr bgcolor='#C7E3FF'>
         <td width='20%' align='center'><b>
            <?=$nb_live_auctions;?>
            </b></td>
         <td width='80%'>&nbsp;<font style='font-size: 10px;'>
            <?=MSG_LIVE_AUCTIONS;?>
            </font></td>
      </tr>
      <? if ($setts['enable_wanted_ads']) { ?>
      <tr bgcolor='#C7E3FF'>
         <td width='20%' align='center'><b>
            <?=$nb_live_wanted_ads;?>
            </b></td>
         <td width='80%'>&nbsp;<font style='font-size: 10px;'>
            <?=MSG_LIVE_WANT_ADS;?>
            </font></td>
      </tr>
      <? } ?>
      <? if ($setts['enable_stores']) { ?>
      <tr bgcolor='#C7E3FF'>
         <td width='20%' align='center'><b>
            <?=$nb_live_stores;?>
            </b></td>
         <td width='80%'>&nbsp;<font style='font-size: 10px;'>
            <?=MSG_ACTIVE_STORES;?>
            </font></td>
      </tr>
      <? } ?>
      <tr bgcolor='#C7E3FF'>
         <td width='20%' align='center'><b>
            <?=$nb_online_users;?>
            </b></td>
         <td width='80%'>&nbsp;<font style='font-size: 10px;'>
            <?=MSG_ONLINE_USERS;?>
            </font></td>
      </tr>
   </table>
   <div><img src='themes/<?=$setts['default_theme'];?>/img/pixel.gif' width='1' height='5'></div>
   <? } ?>
   <? if ($is_news && $layout['d_news_box']) { ?>
   <?=$news_box_header;?>
   <?=$news_box_content;?>
   <? } ?>
   <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="178" height="1"></div>
   <?=$banner_position[3];?>
	<?=$banner_position[4];?>