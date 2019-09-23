<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td width="100%">
<? if ($layout['hpfeat_nb']) { ?>
<?=$featured_auctions_header;?>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
   <?
	$counter = 0;
	for ($i=0; $i<$featured_columns; $i++) { ?>
   <tr>
      <?
      for ($j=0; $j<$layout['hpfeat_nb']; $j++) {
			$width = 100/$layout['hpfeat_nb'] . '%'; ?>
      <td width="<?=$width;?>" align="center" valign="top" class="border">
      	<?
      	if (!empty($item_details[$counter]['name'])) {
      		$main_image = $feat_db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
      			auction_id='" . $item_details[$counter]['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

      		$auction_link = process_link('auction_details', array('name' => $item_details[$counter]['name'], 'auction_id' => $item_details[$counter]['auction_id']));?>
         <table width="100%" border="0" cellspacing="1" cellpadding="5" style="background-image:url(themes/<?=$setts['default_theme'];?>/img/fbg.gif); background-repeat:repeat-x;">
            <tr height="<?=$layout['hpfeat_width']+12;?>">
               <td align="center" style="border: 1px solid #ffffff;"><a href="<?=$auction_link;?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['hpfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" alt="<?=$item_details[$counter]['name'];?>"></a></td>
            </tr>
           <tr>
               <td class="c1feat"><img src="themes/<?=$setts['default_theme'];?>/img/menuico.gif" width="11" height="11" align="absmiddle"> <a href="<?=$auction_link;?>"><?=title_resize($item_details[$counter]['name']);?></a></td>
            </tr>
            <tr class="c2">
            <td style="border-top: 1px dotted #dddddd;">
               	<b><?=MSG_START_BID;?>:</b> <? echo $feat_fees->display_amount($item_details[$counter]['start_price'], $item_details[$counter]['currency']);?> <br>
               <b><?=MSG_CURRENT_BID;?>:</b> <? echo $feat_fees->display_amount($item_details[$counter]['max_bid'], $item_details[$counter]['currency']);?> <br>
               <b><?=MSG_ENDS;?>:</b> <? echo show_date($item_details[$counter]['end_time']); ?>
               </td>
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
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
   <tr class="c4" height="15">
      <td></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b><?=GMSG_START_TIME;?></b></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b><?=MSG_START_BID;?></b></td>
      <td class="smallfont" width="100%">&nbsp;<b><?=MSG_ITEM_TITLE;?><b></td>
      <td class="smallfont" nowrap>&nbsp;</td>
   </tr>
   <?
	while ($item_details = mysql_fetch_array($sql_select_recent_items))
	{
		$background = ($counter++%2) ? '' : '';
		$background .= ($item_details['bold']) ? ' bold_item' : '';
		$background .= ($item_details['hl']) ? ' hl_item' : ''; ?>

	<tr height="15" class="<?=$background;?>">
		<td width="11" id="bot"><img src="themes/<?=$setts['default_theme'];?>/img/recent.gif" width="13" height="12" hspace="3"></td>
		<td class="smallfont" id="bot" nowrap="nowrap">&nbsp;<b><?=show_date($item_details['start_time']);?></b></td>
		<td class="smallfont" id="bot" nowrap="nowrap">&nbsp;<?=$fees->display_amount($item_details['start_price'], $item_details['currency']);?></td> 
		<td id="bot" width="100%" class="smallfont">&nbsp;<a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><?=title_resize($item_details['name']);?></a></td> 
		<td nowrap id="bot"><?=item_pics($item_details);?>&nbsp;</td>
	</tr> 
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="10"></div>
<? } ?>
<? if ($layout['nb_popular_auct'] && $is_popular_items) { ?>
<?=$popular_auctions_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
   <tr class="c4" height="15">
      <td></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b><?=MSG_MAX_BID;?></b></td>
      <td class="smallfont" width="100%">&nbsp;<b><?=MSG_ITEM_TITLE;?><b></td>
      <td class="smallfont" nowrap>&nbsp;</td>
   </tr>
   <? 
	while ($item_details = mysql_fetch_array($sql_select_popular_items))
	{
		$background = ($counter++%2) ? '' : '';
		$background .= ($item_details['bold']) ? ' bold_item' : '';
		$background .= ($item_details['hl']) ? ' hl_item' : ''; ?>
		
	<tr height="15" class="<?=$background;?>">
		<td width="11" id="bot"><img src="themes/<?=$setts['default_theme'];?>/img/popular.gif" width="13" height="12" hspace="3"></td> 
		<td class="smallfont" nowrap="nowrap" id="bot">&nbsp;<?=$fees->display_amount($item_details['max_bid'], $item_details['currency']);?></td> 
		<td width="100%" class="smallfont" id="bot">&nbsp;<a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><?=title_resize($item_details['name']);?></a></td> 
		<td nowrap id="bot"><?=item_pics($item_details);?>&nbsp;</td> 
	</tr> 
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="10"></div>
<? } ?>
<? if ($layout['nb_ending_auct']) { ?>
<?=$ending_auctions_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
   <tr class="c4" height="15">
      <td></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b><?=MSG_TIME_LEFT;?></b></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b><?=MSG_CURRENTLY;?><b></td>
      <td class="smallfont" width="100%">&nbsp;<b><?=MSG_ITEM_TITLE;?><b></td>
      <td class="smallfont" nowrap>&nbsp;</td>
   </tr>
   <?
	while ($item_details = mysql_fetch_array($sql_select_ending_items))
	{
		$item_details['max_bid'] = ($item_details['max_bid'] > 0) ? $item_details['max_bid'] : $item_details['start_price'];
		
		$background = ($counter++%2) ? '' : '';
		$background .= ($item_details['bold']) ? ' bold_item' : '';
		$background .= ($item_details['hl']) ? ' hl_item' : ''; ?>

	<tr height="15" class="<?=$background;?>"> 
		<td width="11" id="bot"><img src="themes/<?=$setts['default_theme'];?>/img/soon.gif" width="13" height="12" hspace="3"></td> 
      <td class="smallfont" nowrap="nowrap" id="bot">&nbsp;<?=time_left($item_details['end_time']);?></td> 
      <td class="smallfont" nowrap="nowrap" id="bot">&nbsp;<?=$fees->display_amount($item_details['max_bid'], $item_details['currency']);?></td> 
      <td  class="smallfont" width="100%" id="bot">&nbsp;<a href="<?=process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));?>"><?=title_resize($item_details['name']);?></a></td> 
		<td nowrap id="bot"><?=item_pics($item_details);?>&nbsp;</td> 
   </tr> 
	<? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="10"></div>
<? } ?>
<? if ($layout['nb_want_ads']) { ?>
<?=$recent_wa_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
   <tr class="c4" height="15">
      <td></td>
      <td class="smallfont" nowrap="nowrap">&nbsp;<b><?=GMSG_START_TIME;?></b></td>
      <td class="smallfont" width="100%">&nbsp;<b><?=MSG_ITEM_TITLE;?><b></td>
   </tr>
   <?
	while ($item_details = mysql_fetch_array($sql_select_recent_wa))
	{
		$background = ($counter++%2) ? '' : ''; ?>

	<tr height="15" class="<?=$background;?>">
		<td width="11" id="bot"><img src="themes/<?=$setts['default_theme'];?>/img/wanted.gif" width="13" height="12" hspace="3"></td> 
		<td class="smallfont" nowrap="nowrap" id="bot">&nbsp;<b><?=show_date($item_details['start_time']);?></b></td> 
		<td class="smallfont" width="100%" id="bot">&nbsp;<a href="<?=process_link('wanted_details', array('name' => $item_details['name'], 'wanted_ad_id' => $item_details['wanted_ad_id']));?>"><?=title_resize($item_details['name']);?></a></td> 
	</tr> 
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="10"></div>
<? } ?>

</td>
<td width="10"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="10" height="1"></td>
<td>

<? if ($member_active != 'Active') { ?>
<div><a href="<?=process_link('register');?>"><img src="themes/<?=$setts['default_theme'];?>/img/register.gif" width="180" height="122" border="0"></a></div>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<? } ?>

<? if ($is_news && $layout['d_news_box']) { ?>
<?=$news_box_header;?>
<?=$news_box_content;?>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<? } ?>

<? if ($setts['enable_header_counter']) { ?>

<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr height='7'><td background='themes/<?=$setts['default_theme'];?>/img/headerbg_g.gif'><img src='themes/<?=$setts['default_theme'];?>/img/pixel.gif' width='1' height='7'></td></tr>
	        <tr height='23'>
	        <td width='100%' class='cathead'><b><?=MSG_SITE_STATUS;?></b></td>
	        </tr>
	        </table>
<table width="100%" height="81" border="0" cellpadding="0" cellspacing="2" background="themes/<?=$setts['default_theme'];?>/img/userbg.gif">
	<tr class='c1'>
   	<td width='20%' align='center'><b><?=$nb_site_users;?></b></td>
		<td width='80%'>&nbsp;<font style='font-size: 10px;'><?=MSG_REGISTERED_USERS;?></font></td>
	</tr>
	<tr class='c2'>
		<td width='20%' align='center'><b><?=$nb_live_auctions;?></b></td>
		<td width='80%'>&nbsp;<font style='font-size: 10px;'><?=MSG_LIVE_AUCTIONS;?></font></td>
	</tr>
	<? if ($setts['enable_wanted_ads']) { ?>
	<tr class='c1'>
		<td width='20%' align='center'><b><?=$nb_live_wanted_ads;?></b></td>
		<td width='80%'>&nbsp;<font style='font-size: 10px;'><?=MSG_LIVE_WANT_ADS;?></font></td>
	</tr>
	<? } ?>
	<? if ($setts['enable_stores']) { ?>
	<tr class='c2'>
		<td width='20%' align='center'><b><?=$nb_live_stores;?></b></td>
		<td width='80%'>&nbsp;<font style='font-size: 10px;'><?=MSG_ACTIVE_STORES;?></font></td>
	</tr>
	<? } ?>
	<tr class='c1'>
		<td width='20%' align='center'><b><?=$nb_online_users;?></b></td>
		<td width='80%'>&nbsp;<font style='font-size: 10px;'><?=MSG_ONLINE_USERS;?></font></td>
	</tr>
</table>
<div><img src='themes/<?=$setts['default_theme'];?>/img/pixel.gif' width='1' height='5'></div>
<? } ?>

<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="171" height="1"></div>
<?=$banner_position[3];?>
<?=$banner_position[4];?>
</td>
</tr>
</table>
