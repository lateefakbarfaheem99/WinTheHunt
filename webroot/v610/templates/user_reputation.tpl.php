<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$user_reputation_header;?>
<br>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
   <tr>
      <td valign="top">

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="border">
            <tr height="30">
               <td colspan="2" class="c1"><?=MSG_REPUTATION_FOR;?> <b><?=$user_details['username'];?></b> <?=user_pics($user_details['user_id']);?></td>
            </tr>
            <tr>
               <td colspan="2"><?=MSG_REGISTERED_SINCE;?> <b><?=show_date($user_details['reg_date'], false);?></b><br>
                  <? echo GMSG_IN . ' <b>' . $seller_country . '</b>'; ?></td>
            </tr>
            <tr class="c4">
               <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c2">
               <td><strong><?=MSG_NB_COMMENTS;?></strong></td>
               <td nowrap><?=$total_comments;?></td>
            </tr>
            <tr class="c1">
               <td width="100%"><strong><?=MSG_REPUTATION_RATING;?></strong></td>
               <td nowrap><?=$reputation_rating;?></td>
            </tr>
         </table>
         <table width="100%" border="0" cellspacing="2" cellpadding="2" class="contentfont">
            <tr>
               <td width="50%"><a href="<?=process_link('other_items', array('owner_id' => $user_id));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_bidding.gif" border="0" align="absmiddle" hspace="3"><strong><?=MSG_VIEW_MY_AUCTIONS;?></strong></a></td>
					<td>
						<? if ($user_details['shop_active']) { ?>
							<a href="<?=process_link('shop', array('user_id' => $user_id));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_store.gif" border="0" align="absmiddle" hspace="3"><b><?=MSG_VIEW_MY_STORE;?></b></a>
                  <? } ?></td>

            </tr>
         </table>
         <? if ($auction_id) { ?>
				<div align="center" class="contentfont">
					[ <a href="<?=process_link('auction_details', array('auction_id' => $auction_id));?>"><?=MSG_RETURN_TO_AUCTION_DETAILS_PAGE;?></a> ]
				</div>
         <? } ?>
      </td>
		<td width="60%" valign="top">
			<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
            <tr>
               <td colspan="6" class="c3"><?=MSG_RECENT_REPUTATION;?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td align="center" class="positive"><img src="themes/<?=$setts['default_theme'];?>/img/system/5stars.gif" hspace="3"></td>
               <td align="center" class="positive"><img src="themes/<?=$setts['default_theme'];?>/img/system/4stars.gif" hspace="3"></td>
               <td align="center" class="neutral"><img src="themes/<?=$setts['default_theme'];?>/img/system/3stars.gif" hspace="3"></td>
               <td align="center" class="negative"><img src="themes/<?=$setts['default_theme'];?>/img/system/2stars.gif" hspace="3"></td>
               <td align="center" class="negative"><img src="themes/<?=$setts['default_theme'];?>/img/system/1stars.gif" hspace="3"></td>
            </tr>
            <tr class="c4">
               <td colspan="6"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c2">
               <td width="25%"><?=MSG_LAST_MONTH;?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=5");?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=4");?></td>
               <td align="center" width="15%" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=3");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=2");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=1");?></td>
            </tr>
            <tr class="c1">
               <td><?=MSG_LAST_SIX_MONTHS;?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=5");?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=4");?></td>
               <td align="center" width="15%" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=3");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=2");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=1");?></td>
            </tr>
            <tr class="c2">
               <td><?=MSG_LAST_TWELVE_MONTHS;?></td>
               <td align="center" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=5");?></td>
               <td align="center" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=4");?></td>
               <td align="center" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=3");?></td>
               <td align="center" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=2");?></td>
               <td align="center" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=1");?></td>
            </tr>
            <tr class="c4">
               <td colspan="6"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c1">
               <td><?=MSG_RATING_AS_SELLER;?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=5");?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=4");?></td>
               <td align="center" width="15%" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=3");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=2");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=1");?></td>
            </tr>
            <tr class="c2">
               <td><?=MSG_RATING_AS_BUYER;?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=5");?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=4");?></td>
               <td align="center" width="15%" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=3");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=2");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=1");?></td>
            </tr>
         </table>

		</td>
   </tr>
</table>
<br>

<? if ($show_reputation_details) { ?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border contentfont">
   <tr align="center" height="21">
      <td width="25%" class="<? echo ($rep_view == 'all') ? 'c3' : 'c1';?>">
      	<a href="<?=process_link('user_reputation', array('view' => 'all', 'user_id' => $user_id, 'auction_id' => $auction_id));?>"><?=MSG_ALL_RATINGS;?></a></td>
      <td width="25%" class="<? echo ($rep_view == 'from_buyers') ? 'c3' : 'c1';?>">
      	<a href="<?=process_link('user_reputation', array('view' => 'from_buyers', 'user_id' => $user_id, 'auction_id' => $auction_id));?>"><?=MSG_FROM_BUYERS;?></a></td>
      <td width="25%" class="<? echo ($rep_view == 'from_sellers') ? 'c3' : 'c1';?>">
      	<a href="<?=process_link('user_reputation', array('view' => 'from_sellers', 'user_id' => $user_id, 'auction_id' => $auction_id));?>"><?=MSG_FROM_SELLERS;?></a></td>
      <td class="<? echo ($rep_view == 'left') ? 'c3' : 'c1';?>">
      	<a href="<?=process_link('user_reputation', array('view' => 'left', 'user_id' => $user_id, 'auction_id' => $auction_id));?>"><?=MSG_LEFT_FOR_OTHERS;?></a></td>
   </tr>
   <tr>
      <td colspan="4" class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <?=$rep_details_content;?>
   <tr>
      <td colspan="7" class="contentfont" align="center"><?=$pagination;?></td>
   </tr>
</table>
<? } ?>