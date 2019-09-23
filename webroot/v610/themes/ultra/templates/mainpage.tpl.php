<?
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<? if ($layout['hpfeat_nb']) { ?>
<?=$featured_auctions_header;?>

<table width="100%" border="0" cellpadding="0" cellspacing="3" >
   <?
	$counter = 0;
	for ($i=0; $i<$featured_columns; $i++) { ?>
   <tr>
      <?
      for ($j=0; $j<$layout['hpfeat_nb']; $j++) {
			$width = 100/$layout['hpfeat_nb'] . '%'; ?>
      <td width="<?=$width;?>" align="center" valign="top"><?
      	if (!empty($item_details[$counter]['name'])) {
      		$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
      			auction_id='" . $item_details[$counter]['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

      		$auction_link = process_link('auction_details', array('name' => $item_details[$counter]['name'], 'auction_id' => $item_details[$counter]['auction_id']));?>
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td width="4"><img src="themes/<?=$setts['default_theme'];?>/img/f1.gif" width="4" height="4"></td>
               <td width="100%" background="themes/<?=$setts['default_theme'];?>/img/fb1.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="themes/<?=$setts['default_theme'];?>/img/f2.gif" width="4" height="4"></td>
            </tr>
            <tr>
               <td width="4" background="themes/<?=$setts['default_theme'];?>/img/fb4.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td width="100%" bgcolor="#f9fafb"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                     <tr height="<?=$layout['hpfeat_width']+12;?>">
                        <td align="center"><a href="<?=$auction_link;?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['hpfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" alt="<?=$item_details[$counter]['name'];?>"></a></td>
                     </tr>
                     <tr>
                        <td class="c1feat">&raquo; <a href="<?=$auction_link;?>"><?=title_resize($item_details[$counter]['name']);?></a></td>
                     </tr>
                     <tr>
                        <td>
                        	<? if ($item_details[$counter]['start_price'] != $item_details[$counter]['buyout_price']) { ?>
                        	<b><?=MSG_START_BID;?>:</b> <? echo $feat_fees->display_amount($item_details[$counter]['start_price'], $item_details[$counter]['currency']);?> <br>
                           <b><?=MSG_CURRENT_BID;?>:</b> <? echo $feat_fees->display_amount($item_details[$counter]['max_bid'], $item_details[$counter]['currency']);?> <br>
                           <? } else { ?>
                        	<b><?=MSG_PRICE;?>:</b> <? echo $feat_fees->display_amount($item_details[$counter]['buyout_price'], $item_details[$counter]['currency']);?> <br>
                        	<? } ?>
                           <b><?=MSG_ENDS;?>:</b> <? echo show_date($item_details[$counter]['end_time']); ?>                            
								</td>
                     </tr>
                  </table></td>
               <td width="4" background="themes/<?=$setts['default_theme'];?>/img/fb2.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr>
               <td width="4"><img src="themes/<?=$setts['default_theme'];?>/img/f4.gif" width="4" height="4"></td>
               <td width="100%" background="themes/<?=$setts['default_theme'];?>/img/fb3.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="themes/<?=$setts['default_theme'];?>/img/f3.gif" width="4" height="4"></td>
            </tr>
         </table>
         <? $counter++;
      	} ?></td>
      <? } ?>
   </tr>
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="10"></div>
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
      <td width="<?=$width;?>" align="center" valign="top"><?
      	if (!empty($ra_details[$counter]['name'])) {
      		$auction_link = process_link('reverse_details', array('name' => $ra_details[$counter]['name'], 'reverse_id' => $ra_details[$counter]['reverse_id']));?>
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td width="4"><img src="themes/<?=$setts['default_theme'];?>/img/f1.gif" width="4" height="4"></td>
               <td width="100%" background="themes/<?=$setts['default_theme'];?>/img/fb1.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="themes/<?=$setts['default_theme'];?>/img/f2.gif" width="4" height="4"></td>
            </tr>
            <tr>
               <td width="4" background="themes/<?=$setts['default_theme'];?>/img/fb4.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td width="100%" bgcolor="#f9fafb"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                     <tr>
                        <td class="c1feat">&raquo; <a href="<?=$auction_link;?>"><?=title_resize($ra_details[$counter]['name']);?></a></td>
                     </tr>
                     <tr>
                        <td><b><?=MSG_BUDGET;?>:</b> <? echo $feat_fees->budget_output($ra_details[$counter]['budget_id'], null, $ra_details[$counter]['currency']);?>  <br>
                           <b><?=MSG_NR_BIDS;?>:</b> <? echo $ra_details[$counter]['nb_bids'];?> <br>
                           <b><?=MSG_ENDS;?>:</b> <? echo show_date($ra_details[$counter]['end_time']); ?> </td>
                     </tr>
                  </table></td>
               <td width="4" background="themes/<?=$setts['default_theme'];?>/img/fb2.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr>
               <td width="4"><img src="themes/<?=$setts['default_theme'];?>/img/f4.gif" width="4" height="4"></td>
               <td width="100%" background="themes/<?=$setts['default_theme'];?>/img/fb3.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="themes/<?=$setts['default_theme'];?>/img/f3.gif" width="4" height="4"></td>
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
<div id="TabbedPanels1" class="TabbedPanels">
   <ul class="TabbedPanelsTabGroup">
      <? if ($layout['nb_recent_auct']) { ?>
      <li class="TabbedPanelsTab" tabindex="0"><a href="javascript:void(0);"><div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="9" border="0"></div><?=MSG_RECENTLY_LISTED_AUCTIONS;?></a></li>
      <? } ?>
		<? if ($layout['nb_ending_auct']) { ?>
      <li class="TabbedPanelsTab" tabindex="0"><a href="javascript:void(0);"><div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="9" border="0"></div><?=MSG_ENDING_SOON_AUCTIONS;?></a></li>
      <? } ?>
		<? if ($layout['nb_popular_auct'] && $is_popular_items) { ?>
      <li class="TabbedPanelsTab" tabindex="0"><a href="javascript:void(0);"><div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="9" border="0"></div><?=MSG_MM_POPULAR;?></a></li>
      <? } ?>
		<? if ($setts['enable_wanted_ads'] && $layout['nb_want_ads']) { ?>
      <li class="TabbedPanelsTab" tabindex="0"><a href="javascript:void(0);"><div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="9" border="0"></div><?=MSG_MM_WANTED_ADS;?></a></li>
      <? } ?>
      <? if ($setts['enable_reverse_auctions'] && $layout['r_recent_nb']) { ?> 
		<li class="TabbedPanelsTab" tabindex="0"><a href="javascript:void(0);"><div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="9" border="0"></div><?=MSG_MM_REVERSE_AUCTIONS;?></a></li>
		<? } ?>
   </ul>
   <div class="TabbedPanelsContentGroup" >
		<? if ($layout['nb_recent_auct']) { ?>
      <div class="TabbedPanelsContent">
         <br>
         <table width="100%" border="0" cellspacing="1" cellpadding="3">
			<? 
			$columns = 3;
			$nb_recent = $db->num_rows($sql_select_recent_items);
			for($i = 0; $i < $nb_recent; $i++)
			{
				$item_details = mysql_fetch_array($sql_select_recent_items);
				$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE auction_id='" . $item_details['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');
				$background = ($item_details['bold']) ? ' bold_item' : '';
				$background .= ($item_details['hl']) ? ' hl_item1' : '';

				if($i % $columns == 0) { ?>
            <tr height="15" valign="top">
				<? } ?>
               <td width="33%"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="border <?	if(CURRENT_TIME - $item_details['start_time'] <= 86400) { echo "today"; } ?>">
                     <tr height="215">
                        <td align="center" class="<?=$background;?>"><a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['hpfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" width="100" alt="<?=title_resize($item_details['name']);?>"></a> <br>
                           <div class="c1feat"><a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><?=title_resize($item_details['name']);?></a></div>
                           <br>
                           <?=GMSG_START_TIME;?>: <?=show_date($item_details['start_time']);?>
                           <br>
                           <?=MSG_START_BID;?>: <?=$fees->display_amount($item_details['start_price'], $item_details['currency']);?>
									<br>
                           <br>
                           <?=item_pics1($item_details);?>
                        </td>
                     </tr>
                  </table></td>
				<? if(($i % $columns) == ($columns - 1) || ($i + 1) == $nb_recent) { ?>
            </tr>
            <? } ?>
            <? } ?>
         </table>
         <div align="right" style="padding: 5px;" class="contentfont"><a href="<?=process_link('auctions_show', array('option' => 'recent'));?>"><?=MSG_VIEW_ALL;?></a></div>
      </div>
		<? } ?>
		<? if ($layout['nb_ending_auct']) { ?>
      <div class="TabbedPanelsContent">
         <br>
         <table width="100%" border="0" cellspacing="1" cellpadding="3">
			<? 
		   $columns = 3;
		   $nb_ending = $db->num_rows($sql_select_ending_items);
		   
			for($i = 0; $i < $nb_ending; $i++) 
			{
				$item_details = mysql_fetch_array($sql_select_ending_items);
				$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE auction_id='" . $item_details['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

				$item_details['max_bid'] = ($item_details['max_bid'] > 0) ? $item_details['max_bid'] : $item_details['start_price'];
		
				$background = ($item_details['bold']) ? ' bold_item' : '';
				$background .= ($item_details['hl']) ? ' hl_item1' : '';
				
				if($i % $columns == 0) { ?>
            <tr height="15" valign="top">
            <? } ?>
               <td width="33%"><table width="100%" border="0" cellpadding="3" cellspacing="1" class='border 
						<?	if((($item_details['end_time'] - CURRENT_TIME) <= 86400) && $item_details['auction_type'] != 'first_bidder') /* 1day = 86400 sec */ { echo "day"; }?> 
						<?	if((($item_details['end_time'] - CURRENT_TIME) <= 3600) && $item_details['auction_type'] != 'first_bidder') /* 1hour = 3600 sec */ { echo "hour"; }?>'>
                     <tr height="215">
                        <td align="center" class="<?=$background;?>"><a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=100&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" width="100" alt="<?=title_resize($item_details['name']);?>"></a> <br>
                           <div class="c1feat"><a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><?=title_resize($item_details['name']);?></a></div>
                           <br>
                           <?=MSG_TIME_LEFT;?>: <?=time_left($item_details['end_time']);?>
                           <br>
                           <?=MSG_CURRENTLY;?>: <?=$fees->display_amount($item_details['max_bid'], $item_details['currency']);?>
                           <br>
                           <br>
                           <?=item_pics1($item_details);?>
                        </td>
                     </tr>
                  </table></td>
            <? if(($i % $columns) == ($columns - 1) || ($i + 1) == $nb_ending) { ?>
            </tr>
            <? } ?>
            <? } ?>
         </table>
         <div align="right" style="padding: 5px;" class="contentfont"><a href="<?=process_link('auctions_show', array('option' => 'ending'));?>"><?=MSG_VIEW_ALL;?></a></div>
      </div>
		<? } ?>
		<? if ($layout['nb_popular_auct'] && $is_popular_items) { ?>
      <div class="TabbedPanelsContent">
         <br>
         <table width="100%" border="0" cellspacing="1" cellpadding="3">
			<? 
		   $columns = 3;
		   $nb_popular = $db->num_rows($sql_select_popular_items);
		   
			for($i = 0; $i < $nb_popular; $i++) 
			{
				$item_details = mysql_fetch_array($sql_select_popular_items);
				$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE auction_id='" . $item_details['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');
				$background = ($item_details['bold']) ? ' bold_item' : '';
				$background .= ($item_details['hl']) ? ' hl_item1' : '';
				
				if($i % $columns == 0) { ?>
            <tr height="15" valign="top">
            <? } ?>
               <td width="33%"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
                     <tr height="215">
                        <td align="center" class="<?=$background;?>"><a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=100&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" width="100" alt="<?=title_resize($item_details['name']);?>"></a> <br>
                           <div class="c1feat"><a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><?=title_resize($item_details['name']);?></a></div>
                           <br>
                           <?=MSG_MAX_BID;?>: <?=$fees->display_amount($item_details['max_bid'], $item_details['currency']);?>
                           <br>
                           <br>
                           <?=item_pics1($item_details);?>
                        </td>
                     </tr>
                  </table></td>
				<? if(($i % $columns) == ($columns - 1) || ($i + 1) == $nb_popular) { ?>
            </tr>
            <? } ?>
            <? } ?>
         </table>
         <div align="right" style="padding: 5px;" class="contentfont"><a href="<?=process_link('auctions_show', array('option' => 'popular'));?>"><?=MSG_VIEW_ALL;?></a></div>
      </div>
		<? } ?>
		<? if ($setts['enable_wanted_ads'] && $layout['nb_want_ads']) { ?>
      <div class="TabbedPanelsContent"> <br>
         <table width="100%" border="0" cellspacing="1" cellpadding="3">
			<? 
		   $columns = 3;
		   $nb_wanted = $db->num_rows($sql_select_recent_wa);
		   
			for($i = 0; $i < $nb_wanted; $i++) 
			{
				$item_details = mysql_fetch_array($sql_select_recent_wa);
				$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE wanted_ad_id='" . $item_details['wanted_ad_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');
				
				if($i % $columns == 0) { ?>
            <tr height="15" valign="top">
				<? } ?>
               <td width="33%"><table width="100%" border="0" cellpadding="3" cellspacing="1"  class="border">
                     <tr height="215">
                        <td align="center"><a href="<?=process_link('wanted_details', array('name' => $item_details['name'], 'wanted_ad_id' => $item_details['wanted_ad_id']));?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=100&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" width="100" alt="<?=title_resize($item_details['name']);?>"></a> <br>
                           <div class="c1feat"><a href="<?=process_link('wanted_details', array('name' => $item_details['name'], 'wanted_ad_id' => $item_details['wanted_ad_id']));?>">
                              <?=title_resize($item_details['name']);?>
                              </a></div>
                           <br>
                           <?=GMSG_START_TIME;?>: <?=show_date($item_details['start_time']);?>
                           <br>
                        </td>
                     </tr>
                  </table></td>
				<? if(($i % $columns) == ($columns - 1) || ($i + 1) == $nb_wanted) { ?>
            </tr>
            <? } ?>
            <? } ?>
         </table>
         <div align="right" style="padding: 5px;" class="contentfont"><a href="<?=process_link('wanted_ads');?>"><?=MSG_VIEW_ALL;?></a></div>
      </div>
		<? } ?>
      <? if ($setts['enable_reverse_auctions'] && $layout['r_recent_nb']) { ?> 
      <div class="TabbedPanelsContent"> <br>
         <table width="100%" border="0" cellspacing="1" cellpadding="3">
			<? 
		   $columns = 3;
		   $nb_reverse = $db->num_rows($sql_select_recent_reverse);
		   
			for($i = 0; $i < $nb_reverse; $i++) 
			{
				$item_details = mysql_fetch_array($sql_select_recent_reverse);
				
				if($i % $columns == 0) { ?>
            <tr height="15" valign="top">
				<? } ?>
               <td width="33%"><table width="100%" border="0" cellpadding="3" cellspacing="1"  class="border">
                     <tr height="215">
                        <td align="center">
                           <div class="c1feat"><a href="<?=process_link('reverse_details', array('name' => $item_details['name'], 'reverse_id' => $item_details['reverse_id']));?>">
                              <?=title_resize($item_details['name']);?>
                              </a></div>
                           <br>
                           <?=GMSG_START_TIME;?>: <?=show_date($item_details['start_time']);?><br>
                           <?=MSG_BUDGET;?>: <? echo $feat_fees->budget_output($item_details['budget_id'], null, $item_details['currency']);?>  <br>
                           <?=MSG_NR_BIDS;?>: <? echo $item_details['nb_bids'];?> <br>
                        </td>
                     </tr>
                  </table></td>
				<? if(($i % $columns) == ($columns - 1) || ($i + 1) == $nb_reverse) { ?>
            </tr>
            <? } ?>
            <? } ?>
         </table>
         <div align="right" style="padding: 5px;" class="contentfont"><a href="<?=process_link('reverse_auctions');?>"><?=MSG_VIEW_ALL;?></a></div>
      </div>
		<? } ?>
   </div>
</div>
</td>
<td width="10"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="10" height="1"></td>
<td><? if ($is_news && $layout['d_news_box']) { ?>
   <?=$news_box_header;?>
   <?=$news_box_content;?>
   <div><img src='themes/<?=$setts['default_theme'];?>/img/pixel.gif' width='1' height='10'></div>
   <? } ?>
   <? if ($is_announcements && $member_active == 'Active') { ?>
   <?=$announcements_box_header;?>
   <div id="exp1102170555">
      <?=$announcements_box_content;?>
   </div>
   <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="10"></div>
   <? } ?>
   <noscript>
   <?=MSG_JS_NOT_SUPPORTED;?>
   </noscript>
   <? if ($setts['enable_header_counter']) { ?>
   <?=$header_site_status;?>
   <table width='100%' border='0' cellpadding='2' cellspacing='1' class='border'>
      <tr class='c1'>
         <td width='20%' align='center'><b>
            <?=$nb_site_users;?>
            </b></td>
         <td width='80%'>&nbsp;
            <?=MSG_REGISTERED_USERS;?></td>
      </tr>
      <tr class='c2'>
         <td width='20%' align='center'><b>
            <?=$nb_live_auctions;?>
            </b></td>
         <td width='80%'>&nbsp;
            <?=MSG_LIVE_AUCTIONS;?></td>
      </tr>
      <? if ($setts['enable_wanted_ads']) { ?>
      <tr class='c1'>
         <td width='20%' align='center'><b>
            <?=$nb_live_wanted_ads;?>
            </b></td>
         <td width='80%'>&nbsp;
            <?=MSG_LIVE_WANT_ADS;?></td>
      </tr>
      <? } ?>
      <? if ($setts['enable_stores']) { ?>
      <tr class='c2'>
         <td width='20%' align='center'><b>
            <?=$nb_live_stores;?>
            </b></td>
         <td width='80%'>&nbsp;
            <?=MSG_ACTIVE_STORES;?></td>
      </tr>
      <? } ?>
      <tr class='c1'>
         <td width='20%' align='center'><b>
            <?=$nb_online_users;?>
            </b></td>
         <td width='80%'>&nbsp;
            <?=MSG_ONLINE_USERS;?></td>
      </tr>
   </table>
   <div><img src='themes/<?=$setts['default_theme'];?>/img/pixel.gif' width='1' height='10'></div>
   <? } ?>
   <?=$banner_position[3];?>
   <?=$banner_position[4];?>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="170" height="1"></div>
