<?
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$auction_print_header;?>
<SCRIPT LANGUAGE="JavaScript"><!--
myPopup = '';

function openPopup(url) {
	myPopup = window.open(url,'popupWindow','width=640,height=150,status=yes');
   if (!myPopup.opener) myPopup.opener = self;
}
//-->
</SCRIPT>
<SCRIPT LANGUAGE = "JavaScript">
	function converter_open(url) {
		output = window.open(url,"popDialog","height=220,width=700,toolbar=no,resizable=yes,scrollbars=yes,left=10,top=10");
	}	
</SCRIPT>
<? if ($ad_display == 'live') { ?>
<form name="hidden_form" action="auction_details.php" method="get">
   <input type="hidden" name="option" />
   <input type="hidden" name="auction_id" />
   <input type="hidden" name="message_content" />
   <input type="hidden" name="question_id" />
</form>
<? } ?>

<? if ($print_button == 'show') { ?>
<table align="center" border="0" cellpadding="3" cellspacing="3" class="errormessage">
   <tr>
      <td class="contentfont"><a href="#" onclick="javascript:window.print(this);"><?=GMSG_PRINT_THIS_PAGE;?></a></td>
   </tr>
</table>
<? } ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<? if ($ad_display == 'live') { ?>
		<td class="contentfont" nowrap style="padding-right: 10px;"><img src="themes/<?=$setts['default_theme'];?>/img/system/home.gif" align="absmiddle" border="0" hspace="5">
			<a href="<?=process_link('index');?>"><?=MSG_BACK_TO_HP;?></a></td>
		<? if (!empty($search_url)) { ?>
		<td class="contentfont" nowrap style="padding-right: 10px;">| <a href="<?=$search_url;?>"><?=MSG_BACK_TO_SEARCH_PAGE;?></a></td>
		<? } ?>
		<? } ?>
		<td width="100%">
			<table width="100%" border="0" cellpadding="3" cellspacing="3" class="errormessage">
			   <tr>
			      <td width="150" align="right"><b><?=MSG_MAIN_CATEGORY;?>:</b></td>
			      <td class="contentfont"><?=$main_category_display;?></td>
			   </tr>
			   <? if ($item_details['addl_category_id']) { ?>
			   <tr>
			      <td width="150" align="right"><b><?=MSG_ADDL_CATEGORY;?>:</b></td>
			      <td class="contentfont"><?=$addl_category_display;?></td>
			   </tr>
			   <? } ?>
			</table>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0"  style="border-top: 2px solid #003C85;">
   <tr height="22">
      <td bgcolor="#1A8CE4" class="itemid" style="border-top: 1px solid #ffffff;">&nbsp;&nbsp;<?=$item_details['name'];?></td>
      <td bgcolor="#1A8CE4" align="right" class="itemidend" style="border-top: 1px solid #ffffff;"><?=MSG_AUCTION_ID;?>: <b><?=$item_details['auction_id'];?></b>&nbsp;&nbsp;</td>
   </tr>
</table>
          	

<? if ($ad_display == 'live') { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="subitem">
   <tr class="contentfont" align="center">
      <td>
			<table width=100%>
				<tr>
					<? if ($session->value('user_id')) { ?>
					<td><img src="themes/<?=$setts['default_theme'];?>/img/system/status1.gif" vspace="5" align="absmiddle"></td>
					<td nowrap><?=MSG_WELCOME;?>, <br><b><?=$session->value('username');?></b></td>
					<td align="center" width="100%">
					<? if ($item_details['owner_id'] == $session->value('user_id')) { ?>
						[ <a href="<?=process_link('sell_item', array('option' => 'sell_similar', 'auction_id' => $item_details['auction_id']));?>"><?=MSG_SELL_SIMILAR;?></a> ]<br>
						<? if (!$item->under_time($item_details))	{ ?>
						<? if ($item_details['nb_bids']==0 && $item_details['active']==1)	{ ?>
						[ <a href="edit_item.php?auction_id=<?=$item_details['auction_id'];?>&edit_option=new"><?=MSG_EDIT_AUCTION;?></a> ]<br>
						[ <a href="members_area.php?do=delete_auction&auction_id=<?=$item_details['auction_id'];?>&page=selling&section=open" onclick="return confirm('<?=MSG_DELETE_CONFIRM;?>');"><?=MSG_DELETE;?></a> ]<br>
						<? } else if ($item_details['nb_bids']>0 && $item_details['active']==1) { ?>
						[ <a href="edit_description.php?auction_id=<?=$item_details['auction_id'];?>"><?=MSG_EDIT_DESCRIPTION;?></a> ]<br>
						<? } ?>
						<? } ?>
						<? if ($item->can_close_manually($item_details, $session->value('user_id'))) { ?>
						[ <a href="members_area.php?do=close_auction&auction_id=<?=$item_details['auction_id'];?>&page=selling&section=open" onclick="return confirm('<?=MSG_CLOSE_AUCTION_CONFIRM;?>');"><?=MSG_CLOSE_AUCTION;?></a> ]<br>
						<? } ?>                  
                  <? if ($item_details['closed'] == 1) { ?>
                  [ <a href="members_area.php?do=relist&auction_id=<?=$item_details['auction_id'];?>&page=selling&section=closed" onclick="return confirm('<?=MSG_RELIST_AUCTION_CONFIRM;?>');"><?=MSG_RELIST_AUCTION;?></a> ]<br>
                  <? } ?> 						               
					<? } else if ($session->value('user_id')) { ?>
						<a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'abuse_report', 'auction_id' => $item_details['auction_id']));?>"><?=MSG_REPORT_AUCTION;?></a>
					<? } ?>
					</td>
				  	<? } else { ?>
					<td><img src="themes/<?=$setts['default_theme'];?>/img/system/status.gif" vspace="5" align="absmiddle"></td>
					<td width="100%"><?=MSG_STATUS_BIDDER_SELLER_A;?><br>
						<a href="<?=process_link('login');?>"><?=MSG_STATUS_BIDDER_SELLER_B;?></a> <?=MSG_STATUS_BIDDER_SELLER_C;?></td>
					<? } ?>
				</tr>
			</table>
		</td>
      <td align="center" class="leftborder" nowrap width="22%">
      	<a href="javascript:popUp('<?=process_link('auction_print', array('auction_id' => $item_details['auction_id']));?>');"><img src="themes/<?=$setts['default_theme'];?>/img/system/print.gif" align="absmiddle" border="0" hspace="5">
         <?=MSG_PRINT_VIEW;?></a></td>
      <td align="center" class="leftborder" nowrap width="22%">
      	<a href="<?=process_link('auction_details', array('auction_id' => $item_details['auction_id'], 'option' => 'item_watch'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/watch.gif" align="absmiddle" border="0" hspace="5">
         <?=MSG_WATCH_ITEM;?></a></td>
      <td align="center" class="leftborder" nowrap width="22%">
      	<a href="<?=process_link('auction_details', array('auction_id' => $item_details['auction_id'], 'option' => 'auction_friend'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/tofriend.gif" align="absmiddle" border="0" hspace="5">
         <?=MSG_SEND_TO_FRIEND;?></a> &nbsp; &nbsp;</td>
   </tr>
   <? if (!empty($direct_payment_box)) { ?>
   <tr height="21">
      <td colspan="5" class="c4"><strong><?=MSG_DIRECT_PAYMENT;?></strong></td>
   </tr>
   <? foreach ($direct_payment_box as $dp_box) { ?>
   <tr>
      <td colspan="5" class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr>
      <td colspan="5" class="border"><?=$dp_box;?></td>
   </tr>
   <? } ?>
   <? } ?>
</table>
<br>
<? } ?>
<?=$auction_friend_form;?>
<?=$msg_changes_saved;?>
<?=$block_reason_msg;?>
<table width="100%" border="0" cellpadding="0" cellspacing="3">
   <tr valign="top">
      <td width="20%" align="center">
      	<table width="100%" border="0" cellspacing="3" cellpadding="3">
            <? if (!empty($item_details['ad_image'][0])) { ?>
      		<tr>
               <td align="center">
						<? $ad_image = (!empty($item_details['ad_image'][0])) ? $item_details['ad_image'][0] : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif'; ?>		
						<div class="wraptocenter" id="ad_image"><span></span>
							<img <? echo ($setts['thumb_display_type'] == 'h') ? 'name="main_ad_image"' : ''; ?> src="thumbnail.php?pic=<?=$ad_image;?>&w=250&sq=Y" border="0" alt="<?=$item_details['name'];?>">
						</div> 						
						<? if (item::count_contents($item_details['ad_image']) && $setts['thumb_display_type'] == 'h') { ?>
						<div style="padding-top: 10px; width: 250px;"><?=$ad_image_thumbnails;?></div>
						<? } ?>	
               </td>
            </tr>
            <!-- 
				<tr>
               <td align="center"><img src="<?=SITE_PATH;?>thumbnail.php?pic=<?=$item_details['ad_image'][0];?>&w=150&sq=Y&b=Y" border="0" alt="<?=$item_details['name'];?>"></td>
            </tr>
            -->
            <? } ?>
           	<? if ($show_buyout) { ?>
            <tr>
               <td align="center"><?
               	if ($ad_display == 'preview' || $session->value('user_id') == $item_details['owner_id'] || $blocked_user)
               	{
               		echo '<img src="themes/' . $setts['default_theme'] . '/img/system/buyitnow25.gif" border="0">';
               	}
               	else
               	{
               		echo '<a href="buy_out.php?auction_id=' . $item_details['auction_id'] . '"><img src="themes/' . $setts['default_theme'] . '/img/system/buyitnow25.gif" border="0"></a>';
               	}
						echo '<br>for <strong>' . $fees->display_amount($item_details['buyout_price'], $item_details['currency']) . '</strong>'.
							'<br><span class="contentfont">[ <a href="javascript:void(0);" onClick="converter_open(\'currency_converter.php?currency=' . $item_details['currency'] . '&amount=' . $item_details['buyout_price'] . '\');">' . MSG_CONVERT . '</a> ]</span>';
               ?></td>
            </tr>
            <? } ?>
            <? if ($item_can_bid['show_box']) { ?>
            <tr>
               <td align="center">
               	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="border">
							<? if ($item_can_bid['result']) { ?>
							<form action="bid.php" method="post">
		               	<input type="hidden" name="auction_id" value="<?=$item_details['auction_id'];?>">
	                     <input type="hidden" name="action" value="bid_confirm">
							<? } ?>
							<? if ($item_details['auction_type'] == 'first_bidder') { ?>
		               <tr>
	                  	<td rowspan="2" class="c2"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_bidding.gif" align="absmiddle" border="0" hspace="1" vspace="1"></td>
	                  </tr>
							<? } else { ?>
	               	<? if ($item_details['auction_type']=='dutch') { ?>
		               <tr>
		                  <td rowspan="3" valign="top" class="c2"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_bidding.gif" align="absmiddle" border="0" hspace="1" vspace="1"></td>
		                  <td class="c2"><?=GMSG_QUANTITY;?> :
		                     <input name="quantity" type="text" id="quantity" value="1" size="3"></td>
		               </tr>
		               <? } ?>
	               	<tr>
	                  	<? if ($item_details['auction_type']!='dutch') { ?>
	                  	<td rowspan="2" class="c2"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_bidding.gif" align="absmiddle" border="0" hspace="1" vspace="1"></td>
	                  	<? } ?>
	                  	<td width="100%"  class="c1"><strong><?=currency_symbol($item_details['currency']);?></strong>
	                     	<input name="max_bid" type="text" id="max_bid" size="7" />
								</td>
	               	</tr>
	               	<? } ?>	               	
	               	<tr class="c2">
	                  	<td width="100%"><input name="form_place_bid" type="submit" id="form_place_bid" value="<?=MSG_PLACE_BID;?>" <? echo (!$item_can_bid['result'] || $blocked_user) ? 'disabled' : ''; ?>></td>
	               	</tr>
							<? if ($item_can_bid['result']) { ?>
		            	</form>
							<? } ?>
		         	</table>
					</td>
            </tr>
            <? } ?>
				<? if (!empty($item_can_bid['display'])) { ?>
            <tr>
               <td align="center">
               	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="errormessage">
	               	<tr align="center">
	                  	<td width="100%"><?=$item_can_bid['display'];?></td>
	               	</tr>
	               </table>
					</td>
            </tr>
				<? } ?>
          </table></td>
      <td width="50%"><!-- Start Table for item details -->
         <table width="100%" border="0" cellspacing="3" cellpadding="3">
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
               <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <? if ($ad_display == 'live' && !$buyout_only) { ?>
            <tr class="c1">
               <td><strong><?=MSG_CURRENT_BID;?></strong></td>
               <td class="greenfont"><strong><?=$fees->display_amount((($item_details['auction_type'] == 'first_bidder') ? $item_details['fb_current_bid'] : $item_details['max_bid']), $item_details['currency']); ?></strong></td>
            </tr>
            <? } ?>
            <? if (!$buyout_only) { ?>
            <tr class="c1">
               <td><strong><?=MSG_START_BID;?></strong></td>
               <td class="redfont"><strong><?=$fees->display_amount($item_details['start_price'], $item_details['currency']); ?></strong>
               	<? if ($ad_display == 'live') { ?>
               	<span class="contentfont">[ <a href="javascript:void(0);" onClick="converter_open('currency_converter.php?currency=<?=$item_details['currency'];?>&amount=<?=$item_details['start_price'];?>');"><?=MSG_CONVERT;?></a> ]</span>
               	<? } ?></td>
            </tr>
            <? if ($your_bid>0) { ?>
            <tr>
               <td><strong><?=MSG_YOUR_BID;?></strong></td>
               <td class="greenfont"><strong><?=$fees->display_amount($your_bid, $item_details['currency']); ?></strong></td>
            </tr>
            <? } ?>
            <? } ?>
            <? if ($item_details['auction_type'] == 'first_bidder' || ($ad_display == 'preview' && $item_details['is_reserve'] && !$buyout_only)) { ?>
            <tr class="c1">
               <td><strong><?=MSG_RES_PRICE;?></strong></td>
               <td><strong><?=$fees->display_amount($item_details['reserve_price'], $item_details['currency']); ?></strong></td>
            </tr>
            <? } ?>
            <? if ($item_details['quantity']) { ?>
            <tr class="c1">
               <td><b><?=GMSG_QUANTITY;?></b></td>
               <td><?=$item_details['quantity'];?></td>
            </tr>
            <? } ?>
            <? if ($ad_display == 'live' && !$buyout_only && $item_details['auction_type'] != 'first_bidder') { ?>
            <tr class="c1">
               <td><b><?=MSG_NR_BIDS;?></b></td>
               <td class="contentfont"><?=$item_details['nb_bids'];?>
               	<? if ($item_details['nb_bids']) { ?>
               	[ <a href="<?=process_link('bid_history', array('auction_id' => $item_details['auction_id']));?>"><?=MSG_VIEW_HISTORY;?></a> ]
               	<? } ?></td>
            </tr>
            <? } ?>
            <tr class="c1">
               <td><b><?=MSG_LOCATION;?></b></td>
               <td><?=$auction_location;?></td>
            </tr>
            <tr class="c1">
               <td><b><?=MSG_COUNTRY;?></b></td>
               <td><?=$auction_country;?></td>
            </tr>
            <? if ($ad_display == 'live' && $item_details['start_time'] <= CURRENT_TIME && $item_details['auction_type'] != 'first_bidder' && $item_details['list_in'] != 'store') { // dont show if the auction is not started ?>
            <tr class="c1">
               <td><b><?=MSG_TIME_LEFT;?></b></td>
               <td><div id="time_left"><?=time_left($item_details['end_time'], CURRENT_TIME, false, true); ?></div></td>
            </tr>
            <? } ?>
            <tr class="c1">
               <td><b><?=GMSG_START_TIME;?></b></td>
               <td><? echo ($ad_display == 'live' || $item_details['start_time_type'] == 'custom') ? show_date($item_details['start_time']) : GMSG_NOW; ?></td>
            </tr>
            <? if ($item_details['auction_type'] == 'first_bidder') { ?>
            <tr class="c5">
               <td colspan="2"></td>
            </tr>
            <tr class="c1">
               <td><b><?=MSG_FB_DECREMENT;?></b></td>
               <td><?
               	$fb_decrement = $item->convert_fb_decrement($item_details, 'NTS');
               	
               	echo $fees->display_amount($item_details['fb_decrement_amount'], $item_details['currency']) . ' ' . $fb_decrement['display']; ?></td>
            </tr>
            <? if ($ad_display == 'live' && $item_details['closed'] == 0) { ?>
            <tr class="c1">
               <td><b><?=MSG_NEXT_DECREMENT;?></b></td>
               <td><?=show_date($item_details['fb_next_decrement']); ?></td>
            </tr>
            <? } ?>
            <tr class="c5">
               <td colspan="2"></td>
            </tr>
            <? } else { ?>
            <? if ($ad_display == 'live' || $item_details['end_time_type'] == 'custom') { ?>
            <tr class="c1">
               <td><b><?=GMSG_END_TIME;?></b></td>
               <td><?=show_date($item_details['end_time']); ?></td>
            </tr>
            <? } else { ?>
            <tr class="c1">
               <td><b><?=GMSG_DURATION;?></b></td>
               <td><? echo $item_details['duration'] . ' ' . GMSG_DAYS; ?></td>
            </tr>
				<? } ?>
				<? } ?>
            <? if ($ad_display == 'live') { ?>
            <tr class="c1">
               <td><b><?=MSG_STATUS;?></b></td>
               <td><?=item::item_status($item_details['closed']); ?></td>
            </tr>
            <? } ?>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <? if ($item_details['is_offer'] && $setts['makeoffer_process'] == 1) { ?>
            <tr class="c1">
               <td><b><?=GMSG_MAKE_OFFER;?></b></td>
               <td class="c1"><?
               	if ($ad_display == 'preview' || $session->value('user_id') == $item_details['owner_id'] || $blocked_user)
               	{
               		echo '<img src="themes/' . $setts['default_theme'] . '/img/system/makeoffer25.gif" border="0">';
               	}
               	else
               	{
               		echo '<a href="make_offer.php?auction_id=' . $item_details['auction_id'] . '"><img src="themes/' . $setts['default_theme'] . '/img/system/makeoffer25.gif" border="0"></a>';
               	}
               ?></td>
            </tr>
            <? if ($ad_display != 'live' || ($setts['makeoffer_private'] && $user_details['show_makeoffer_ranges'])) { ?>
            <tr>
               <td></td>
               <td><?=MSG_OFFER_RANGE;?>: <?=$item->offer_range($item_details);?></td>
            </tr>
            <? } ?>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <? } ?>
				<? if ($ad_display == 'live' && $item_details['reserve_price']>0 && $item_details['auction_type'] != 'first_bidder') { ?>
            <tr>
               <td colspan="2"><b><? echo ($item_details['reserve_price']>$item_details['max_bid']) ? '<span class="redfont">' . MSG_RESERVE_NOT_MET . '</span>' : '<span class="greenfont">' . MSG_RESERVE_MET . '</span>'; ?></b></td>
            </tr>
            <tr class="c5">
               <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
				<? } ?>
				<? if ($item_details['enable_swap'] && !$item_details['closed']) { ?>
            <tr>
               <td colspan="2" class="contentfont"><?=MSG_SWAP_OFFERS_ACCEPTED;?> <? echo ($ad_display == 'live' && !$blocked_user) ? $swap_offer_link : '';?></td>
            </tr>
            <tr class="c5">
               <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
				<? } ?>
            <? if ($ad_display == 'live' && !$buyout_only && !$item_details['closed'] && $item_details['auction_type'] != 'first_bidder') { ?>
            <tr class="c1">
               <td><b><?=MSG_HIGH_BID; ?></b></td>
               <td><?=$high_bidders_content;?></td>
            </tr>
				<? } ?>
            <? if ($ad_display == 'live' && !empty($winners_content)) { ?>
            <tr class="c1">
               <td><b><?=MSG_WINNER_S; ?></b></td>
               <td><?=$winners_content;?></td>
            </tr>
				<? } ?>
           	<? if ($item_details['apply_tax']) { ?>
            <tr>
               <td colspan="2"><?=$auction_tax['display'];?></td>
            </tr>
            <tr class="c5">
               <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <? if ($auction_tax['display_buyer']) { ?>
            <tr>
               <td colspan="2"><?=$auction_tax['display_buyer'];?></td>
            </tr>
            <tr class="c5">
               <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <? } ?>
            <? } ?>
            <?=$winners_message_board;?>
            <? if (!empty($item_watch_text)) { ?>
            <tr class="c5">
               <td colspan="2"></td>
            </tr>
            <tr>
               <td colspan="2" class="c2"><?=$item_watch_text;?></td>
            </tr>
            <? } ?>
         </table>
      </td>
      <td width="30%">
      	<table width="100%" border="0" cellspacing="3" cellpadding="3">
            <tr>
               <td class="c3"><?=MSG_SELLER_INFORMATION;?> </td>
            </tr>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr>
               <td><b><?=$user_details['username'];?></b> <?=user_pics($user_details['user_id']);?></td>
            </tr>
            <tr class="c1">
               <td><?=MSG_REGISTERED_SINCE;?> <b><?=show_date($user_details['reg_date'], false);?></b><br>
               	<? echo GMSG_IN . ' <b>' . $seller_country . '</b>'; ?></td>
            </tr>
            <? if ($ad_display == 'live') { ?>
            <tr class="c1">
               <td class="contentfont"><a href="<?=process_link('other_items', array('owner_id' => $item_details['owner_id']));?>"><?=MSG_OTHER_ITEMS_FROM_SELLER;?></a></td>
            </tr>
            <? if ($user_details['shop_active']) { ?>
            <tr class="c1">
               <td class="contentfont"><a href="<?=process_link('shop', array('user_id' => $item_details['owner_id']));?>"><?=MSG_VIEW_STORE;?></a></td>
            </tr>
            <? } ?>
            <? } ?>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
         </table>
         <?=$reputation_table_small;?>
		</td>
   </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="3" cellpadding="3" class="border">
   <tr>
      <td class="c3" colspan="2"><?=GMSG_DESCRIPTION;?></td>
   </tr>
	<tr class="c5">
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
		<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <tr>
      <td colspan="2"><?=database::add_special_chars($item_details['description']);?></td>
   </tr>
   <?=$custom_sections_table;?>
   <? if (item::count_contents($item_details['ad_image']) && $setts['thumb_display_type'] == 'v') { ?>
   <tr>
      <td class="c3" colspan="2"><?=MSG_AUCTION_IMAGES;?></td>
   </tr>
	<tr class="c5">
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <tr>
      <td class="border" colspan="2"><table width="100%" cellpadding="3" cellspacing="0" border="0">
            <tr align="center">
               <td valign="top" class="picselect"><table cellpadding="3" cellspacing="1" border="0">
                     <tr align="center">
                        <td><b><?=MSG_SELECT_PICTURE;?></b></td>
                     </tr>
                     <tr align="center">
                        <td><?=$ad_image_thumbnails;?></td>
                     </tr>
                  </table></td>
               <td width="100%" class="picselectmain" align="center"><img name="main_ad_image" src="<?=SITE_PATH;?>thumbnail.php?pic=<?=$item_details['ad_image'][0];?>&w=500&sq=Y&b=Y" border="0" alt="<?=$item_details['name'];?>"></td>
            </tr>
         </table></td>
   </tr>
   <? } ?>
   <? if (item::count_contents($item_details['ad_video'])) { ?>
   <tr>
      <td class="c3" colspan="2"><?=MSG_AUCTION_MEDIA;?></td>
   </tr>
	<tr class="c5">
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <tr>
      <td class="border" colspan="2"><table width="100%" cellpadding="3" cellspacing="0" border="0">
            <tr align="center">
               <td valign="top" class="picselect"><table cellpadding="3" cellspacing="1" border="0">
                     <tr align="center">
                        <td><b> <?=MSG_SELECT_VIDEO;?> </b></td>
                     </tr>
                     <tr align="center">
                        <td><?=$ad_video_thumbnails; ?></td>
                     </tr>
                  </table></td>
               <td width="100%" class="picselectmain"align="center"><?=$ad_video_main_box; ?></td>
            </tr>
         </table></td>
   </tr>
   <? } ?>
   <? if (item::count_contents($item_details['ad_dd'])) { ?>
   <tr>
      <td class="c4" colspan="2"><strong><?=MSG_DIGITAL_MEDIA;?></strong> </td>
   </tr>
	<tr class="c5">
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <tr>
      <td class="border" colspan="2"><table width="100%" cellpadding="3" cellspacing="0" border="0">
            <tr align="center">
               <td width="100%" align="center"><?=$ad_dd_thumbnails;?></td>
            </tr>
         </table></td>
   </tr>
   <? } ?>
   <? if ($ad_display == 'live' && $user_details['enable_item_counter']) { ?>
   <tr>
      <td align="center" colspan="2"><table cellpadding="3" cellspacing="1" border="0" class="counter">
            <tr>
               <td nowrap><?=MSG_ITEM_VIEWED;?> <?=($item_details['nb_clicks']+1); ?> <?=GMSG_TIMES;?></td>
            </tr>
         </table></td>
   </tr>
   <? if ($setts['enable_asq']) { ?>
   <tr>
      <td class="c3" colspan="2"><?=MSG_ASK_SELLER_QUESTION;?></td>
   </tr>
	<tr class="c5">
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
	<?=$public_questions_content;?>
	<? if ($session->value('adminarea') == 'Active') { ?>
   <tr>
      <td align="center" colspan="2"><?=MSG_QUESTIONS_LOGGED_AS_ADMIN;?></td>
   </tr>
	<? } else if (!$session->value('user_id')) { ?>
   <tr>
      <td align="center" colspan="2"><?=MSG_LOGIN_TO_ASK_QUESTIONS;?></td>
   </tr>
	<? } else if ($session->value('membersarea') != 'Active') { ?>
   <tr>
      <td align="center" colspan="2"><?=MSG_ACC_SUSPENDED_ASK_QUESTION;?></td>
   </tr>
	<? } else if ($session->value('user_id') == $item_details['owner_id']) { ?>
   <tr>
      <td align="center" colspan="2"><?=MSG_CANT_POST_QUESTION_OWNER;?></td>
   </tr>
	<? } else { ?>
	<tr>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <form action="auction_details.php" method="POST">
   	<input type="hidden" name="auction_id" value="<?=$item_details['auction_id'];?>">
   	<input type="hidden" name="option" value="post_question">
   <tr class="c1">
   	<td><table width="100%">
   			<tr>
   				<td><img src="themes/<?=$setts['default_theme'];?>/img/system/i_faq.gif" align="absmiddle"/></td>
   				<td width="100%" align="right"><strong><?=MSG_POST_QUESTION;?></strong></td>
   			</tr>
   		</table></td>
   	<td><table>
   			<tr>
   				<td><textarea name="message_content" cols="40" rows="3" class="contentfont"></textarea></td>
   				<td><div style="padding: 2px;">
                     <select name="message_handle">
                     	<? if ($user_details['default_public_questions']) { ?>
                        <option value="1" selected><?=MSG_POST_QUESTION_PUBLICLY;?></option>
                        <? } ?>
                        <option value="2"><?=MSG_POST_QUESTION_PRIVATELY;?></option>
                     </select>
                  </div>
                  <div style="padding: 2px;">
                     <input name="form_post_question" type="submit" id="form_post_question" value="<?=GMSG_SUBMIT;?>" />
                  </div></td>
   			</tr>
   		</table></td>
   </tr>
   </form>
   <? } ?>
   <? } ?>
   <? } ?>
   <? if ($item_details['direct_payment']) { ?>
   <tr>
      <td class="c3" colspan="2"><?=MSG_DIRECT_PAYMENT;?></td>
   </tr>
	<tr class="c5">
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <tr>
      <td colspan="2" align="center"><?=$direct_payment_methods_display;?></td>
   </tr>
   <? } ?>
   <? if ($item_details['payment_methods']) { ?>
   <tr>
      <td class="c3" colspan="2"><?=MSG_OFFLINE_PAYMENT;?></td>
   </tr>
	<tr class="c5">
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <tr>
      <td colspan="2" align="center"><?=$offline_payment_methods_display;?></td>
   </tr>
   <? } ?>
</table>
<br>
<? if ($ad_display == 'live') { ?>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
   	<td width="50%" style="padding-right: 10px;" valign="top">
<? } ?>
			<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
            <tr>
               <td class="c3" colspan="2"><?=MSG_SHIPPING;?></td>
            </tr>
	         <tr class="c5">
		         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	         </tr>
            <tr class="c1">
               <td width="150" align="right"><?=MSG_SHIPPING_CONDITIONS;?></td>
               <td><? echo ($item_details['shipping_method'] == 1) ? MSG_BUYER_PAYS_SHIPPING : MSG_SELLER_PAYS_SHIPPING; ?></td>
            </tr>
            <? if ($item_details['shipping_int'] == 1) { ?>
            <tr>
               <td>&nbsp;</td>
               <td><?=MSG_SELLER_SHIPS_INT;?></td>
            </tr>
            <? } ?>
            <? if ($setts['enable_shipping_costs']) { ?>
            <? if ($user_details['pc_postage_type'] == 'item') { ?>
            <tr class="c1">
               <td width="150" align="right"><?=MSG_POSTAGE;?></td>
               <td><?=$fees->display_amount($item_details['postage_amount'], $item_details['currency']); ?></td>
            </tr>
            <? } ?>
	         <? if ($user_details['pc_postage_type'] == 'weight' && $item_details['item_weight']) { ?>
            <tr class="c1">
               <td width="150" align="right"><?=MSG_WEIGHT;?></td>
               <td><?=$item_details['item_weight'];?> <?=$user_details['pc_weight_unit'];?></td>
            </tr>
	         <? } ?>	
            <tr class="c1">
               <td width="150" align="right"><?=MSG_INSURANCE;?></td>
               <td><?=$fees->display_amount($item_details['insurance_amount'], $item_details['currency']); ?></td>
            </tr>
            <tr class="c1">
               <td width="150" align="right"><?=MSG_SHIP_METHOD;?></td>
               <td><?=$item_details['type_service'];?></td>
            </tr>
            <? if ($item_details['shipping_details']) { ?>
            <tr class="c1">
               <td width="150" align="right"><?=MSG_SHIPPING_DETAILS;?></td>
               <td><?=$item_details['shipping_details'];?></td>
            </tr>
            <? } ?>
            <? } ?>
         </table>
<? if ($ad_display == 'live') { ?>
		</td>
		<td style="padding-left: 10px;" valign="top"><?=$shipping_calculator_box;?></td>
	</tr>
</table>
<? } ?>
<br>
<? if ($ad_display == 'live') { ?>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
      <td align='center' class='topitempage alertfont'><?=MSG_THE_POSTER;?>, <b><?=$user_details['username'];?></b>, <?=MSG_ASSUMES_RESP_EXPL;?> </td>
   </tr>
</table>
<br />
<? if ($setts['enable_other_items_adp'] && $item->count_contents($other_items)) { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
   <tr>
      <td class="c3" colspan="<?=$layout['hpfeat_nb'];?>"><?=MSG_OTHER_ITEMS_FROM_SELLER;?></td>
   </tr>
   <tr>
      <?
      for ($counter=0; $counter<$layout['hpfeat_nb']; $counter++) {
			$width = 100/$layout['hpfeat_nb'] . '%'; ?>
      <td width="<?=$width;?>" align="center" valign="top">
      	<?
      	if (!empty($other_items[$counter]['name'])) {
      		$main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
      			auction_id='" . $other_items[$counter]['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

      		$auction_link = process_link('auction_details', array('name' => $other_items[$counter]['name'], 'auction_id' => $other_items[$counter]['auction_id']));?>
         <table width="100%" border="0" cellspacing="3" cellpadding="3">
            <tr>
               <td colspan="2" align="center" class="gradient"><a href="<?=$auction_link;?>"><img src="<? echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['hpfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif');?>" border="0" alt="<?=$other_items[$counter]['name'];?>"></a></td>
            </tr>
            <tr class="c3">
               <td colspan="2"><a style="color: #ffffff; font-weight: bold;" href="<?=$auction_link;?>">&raquo; <?=title_resize($other_items[$counter]['name']);?></a></td>
            </tr>
            <tr class="c2">
               <td nowrap align="right"><b><?=MSG_START_BID;?></b>
                  :</td>
               <td nowrap><? echo $fees->display_amount($other_items[$counter]['start_price'], $other_items[$counter]['currency']);?> </td>
            </tr>
            <tr class="c2">
               <td align="right"><b><?=MSG_CURRENT_BID;?></b>
                  :</b></td>
               <td ><b><? echo $fees->display_amount($other_items[$counter]['max_bid'], $other_items[$counter]['currency']);?></td>
            </tr>
            <tr class="c1">
               <td colspan="2" align="center"><b>
                  <?=MSG_ENDS;?>
                  :</b> <? echo show_date($other_items[$counter]['end_time']); ?> </td>
            </tr>
         </table>
         <? } ?></td>
      <? } ?>
   </tr>
</table>
<br>
<? } ?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
	<? if ($item_can_bid['result']) { ?>
	<form action="bid.php" method="post">
     	<input type="hidden" name="auction_id" value="<?=$item_details['auction_id'];?>">
		<input type="hidden" name="action" value="bid_confirm">
	<? } ?>
   <tr>
      <td class="c3" colspan="2"><?=MSG_BID_ON_THIS_ITEM;?></td>
   </tr>
   <tr>
      <td class="c2" colspan="2"><b><?=$item_details['name'];?></b></td>
   </tr>
	<tr class="c5">
		<td width="150"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
		<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
	</tr>
	<? if ($item_can_bid['show_box']) { ?>
   <tr class="c1">
      <td align="right"><?=MSG_CURRENT_BID;?></td>
      <td class="redfont"><strong><?=$fees->display_amount((($item_details['auction_type'] == 'first_bidder') ? $item_details['fb_current_bid'] : $item_details['max_bid']), $item_details['currency']); ?></td>
   </tr>
   <? if ($item_details['auction_type'] != 'first_bidder') { ?>
	<? if ($item_details['auction_type']=='dutch') { ?>
	<tr class="c1">
		<td align="right"><?=GMSG_QUANTITY;?></td>
		<td><input name="quantity" type="text" id="quantity" value="1" size="8"></td>
	</tr>
	<? } ?>
   <tr class="c1">
      <td align="right"><?=MSG_YOUR_MAXIMUM_BID;?></td>
      <td><strong><?=currency_symbol($item_details['currency']);?></strong>
			<input name="max_bid" type="text" id="max_bid" size="7" /> &nbsp; <?=MSG_MINIMUM_BID;?>: <strong><? echo $fees->display_amount($item->min_bid_amount($item_details), $item_details['currency']);?></strong></td>
   </tr>
	<? } ?>
  	<tr class="c2">
      <td align="right"></td>
     	<td><input name="form_place_bid" type="submit" id="form_place_bid" value="<?=MSG_PLACE_BID;?>" <? echo (!$item_can_bid['result'] || $blocked_user) ? 'disabled' : ''; ?>></td>
	</tr>
	<? } ?>
	<? if ($item_can_bid['result']) { ?>
	</form>
	<? } ?>
</table>
<? if (!empty($item_can_bid['display'])) { ?>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="errormessage">
	<tr align="center">
		<td width="100%"><?=$item_can_bid['display'];?></td>
   </tr>
</table>
<? } ?>
<? } ?>
<?=$auction_print_footer;?>
