<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$profile_header;?>
<br>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
   <tr>
      <td valign="top">

			<table width="100%" border="0" cellpadding="2" cellspacing="2" class="border">
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
         <br>
			<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
			   <tr>
			      <td class="c3" colspan="2"><?=GMSG_DESCRIPTION;?></td>
			   </tr>
				<tr class="c5">
					<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
					<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
				</tr>
			   <tr>
			      <td colspan="2"><?=database::add_special_chars($user_details['provider_profile']);?></td>
			   </tr>   
				<?=$custom_sections_table;?>
			</table>
         
         <? if ($reverse_id) { ?>
         	<br>
				<div align="center" class="contentfont">
					[ <a href="<?=process_link('reverse_details', array('reverse_id' => $reverse_id));?>"><?=MSG_RETURN_TO_AUCTION_DETAILS_PAGE;?></a> ]
				</div>
         <? } ?>
      </td>
		<td width="40%" valign="top">
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
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=5 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=4 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=3 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=2 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $one_month) . " AND reputation_rate=1 AND reverse_id>0");?></td>
            </tr>
            <tr class="c1">
               <td><?=MSG_LAST_SIX_MONTHS;?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=5 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=4 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=3 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=2 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $six_months) . " AND reputation_rate=1 AND reverse_id>0");?></td>
            </tr>
            <tr class="c2">
               <td><?=MSG_LAST_TWELVE_MONTHS;?></td>
               <td align="center" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=5 AND reverse_id>0");?></td>
               <td align="center" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=4 AND reverse_id>0");?></td>
               <td align="center" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=3 AND reverse_id>0");?></td>
               <td align="center" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=2 AND reverse_id>0");?></td>
               <td align="center" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reg_date>" . (CURRENT_TIME - $twelve_months) . " AND reputation_rate=1 AND reverse_id>0");?></td>
            </tr>
            <tr class="c4">
               <td colspan="6"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c1">
               <td><?=MSG_RATING_AS_PURCHASER;?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=5 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=4 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=3 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=2 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='sale' AND reputation_rate=1 AND reverse_id>0");?></td>
            </tr>
            <tr class="c2">
               <td><?=MSG_RATING_AS_PROVIDER;?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=5 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="positive"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=4 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="neutral"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=3 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=2 AND reverse_id>0");?></td>
               <td align="center" width="15%" class="negative"><?=$db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_type='purchase' AND reputation_rate=1 AND reverse_id>0");?></td>
            </tr>
         </table>

		</td>
   </tr>
</table>
<br>
<? //if (item::count_contents($user_details['ad_image'])) { ?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
   <tr>
      <td class="c3" colspan="2"><?=MSG_PORTFOLIO;?></td>
   </tr>
	<tr class="c5">
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <tr>
      <td class="border" colspan="2"><?=$portfolio_thumbnails;?></td>
   </tr>
</table>
<br>
<? //} ?>
<? if ($show_reputation_details) { ?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border contentfont">
   <tr align="center" height="21">
      <td width="25%" class="<? echo ($rep_view == 'all') ? 'c3' : 'c1';?>">
      	<a href="<?=process_link('reverse_profile', array('view' => 'all', 'user_id' => $user_id, 'reverse_id' => $reverse_id));?>"><?=MSG_ALL_RATINGS;?></a></td>
      <td width="25%" class="<? echo ($rep_view == 'from_providers') ? 'c3' : 'c1';?>">
      	<a href="<?=process_link('reverse_profile', array('view' => 'from_providers', 'user_id' => $user_id, 'reverse_id' => $reverse_id));?>"><?=MSG_FROM_PROVIDERS;?></a></td>
      <td width="25%" class="<? echo ($rep_view == 'from_purchasers') ? 'c3' : 'c1';?>">
      	<a href="<?=process_link('reverse_profile', array('view' => 'from_purchasers', 'user_id' => $user_id, 'reverse_id' => $reverse_id));?>"><?=MSG_FROM_PURCHASERS;?></a></td>
      <td class="<? echo ($rep_view == 'left') ? 'c3' : 'c1';?>">
      	<a href="<?=process_link('reverse_profile', array('view' => 'left', 'user_id' => $user_id, 'reverse_id' => $reverse_id));?>"><?=MSG_LEFT_FOR_OTHERS;?></a></td>
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