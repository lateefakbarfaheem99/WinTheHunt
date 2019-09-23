<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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
			<a href="<?=process_link('reverse_auctions');?>"><?=MSG_BACK_TO_HP;?></a></td>
		<? if (!empty($search_url)) { ?>
		<td class="contentfont" nowrap style="padding-right: 10px;">| <a href="<?=$search_url;?>"><?=MSG_BACK_TO_SEARCH_PAGE;?></a></td>
		<? } ?>
		<? } ?>
		<td width="100%">
			<table width="100%" border="0" cellpadding="3" cellspacing="2" class="errormessage">
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
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
   <tr>
      <td width='41' rowspan='3' valign='top' bgcolor='#FFFFFF'><img src='themes/<?=$setts['default_theme'];?>/img/featured.gif' width='41' height='30'></td>
      <td height='20' bgcolor='#FFFFFF'><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr height="22">
               <td class="itemid">&nbsp;&nbsp;
                  <?=$item_details['name'];?></td>
               <td align="right" class="itemidend"><?=MSG_AUCTION_ID;?>
                  : <b>
                  <?=$item_details['reverse_id'];?>
                  </b>&nbsp;&nbsp;</td>
            </tr>
         </table></td>
   </tr>
   <tr>
      <td bgcolor='#0082D6'><img src='themes/<?=$setts['default_theme'];?>/img/pixel.gif' width='3' height='3'></td>
   </tr>
   <tr>
      <td><img src='themes/<?=$setts['default_theme'];?>/img/pixel.gif' width='1' height='10'></td>
   </tr>
</table>
<? if ($ad_display == 'live') { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="subitem">
   <tr class="contentfont" align="center">
      <td>
			<table width=100%>
				<tr>
					<? if ($session->value('user_id')) { ?>
					<td><img src="themes/<?=$setts['default_theme'];?>/img/system/status1.gif" vspace="5" align="absmiddle"></td>
					<td nowrap><?=MSG_WELCOME;?>, <br><b><?=$session->value('username');?></b></td>
					<td align="center" width="100%">
					<? if ($item_details['owner_id'] == $session->value('user_id')) { ?>
						<? if ($item_details['active']==1)	{ ?>
						[ <a href="reverse_manage.php?do=edit&reverse_id=<?=$item_details['reverse_id'];?>&edit_option=new"><?=MSG_EDIT_AUCTION;?></a> ]<br>
						[ <a href="members_area.php?do=delete_reverse&reverse_id=<?=$item_details['reverse_id'];?>&page=reverse&section=open" onclick="return confirm('<?=MSG_DELETE_CONFIRM;?>');"><?=MSG_DELETE;?></a> ]<br>
						<? } ?>
					<? } ?>
					</td>
				  	<? } else { ?>
					<td><img src="themes/<?=$setts['default_theme'];?>/img/system/status.gif" vspace="5" align="absmiddle"></td>
					<td width="100%"><?=MSG_STATUS_BIDDER_SELLER_REVERSE_A;?><br>
						<a href="<?=process_link('login');?>"><?=MSG_STATUS_BIDDER_SELLER_B;?></a> <?=MSG_STATUS_BIDDER_SELLER_C;?></td>
					<? } ?>
				</tr>
			</table>
		</td>
      <td align="center" class="leftborder" nowrap width="22%">
      	<a href="javascript:popUp('<?=process_link('reverse_print', array('reverse_id' => $item_details['reverse_id']));?>');"><img src="themes/<?=$setts['default_theme'];?>/img/system/print.gif" align="absmiddle" border="0" hspace="5">
         <?=MSG_PRINT_VIEW;?></a></td>
      <td align="center" class="leftborder" nowrap width="44%"></td>
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
<?=$msg_changes_saved;?>
<?=$block_reason_msg;?>
<table width="100%" border="0" cellpadding="0" cellspacing="2">
   <tr valign="top">
      <td width="20%" align="center">
      	<table width="100%" border="0" cellspacing="2" cellpadding="3">
            <? if (!empty($item_details['ad_image'][0])) { ?>
      		<tr>
               <td align="center"><img src="<?=SITE_PATH;?>thumbnail.php?pic=<?=$item_details['ad_image'][0];?>&w=150&sq=Y&b=Y" border="0" alt="<?=$item_details['name'];?>"></td>
            </tr>
            <? } ?>
          </table></td>
      <td width="50%"><!-- Start Table for item details -->
         <table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
               <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c1">
               <td><strong><?=MSG_BUDGET;?></strong></td>
               <td><strong><?=$fees->budget_output($item_details['budget_id'], null, $item_details['currency']); ?></strong></td>
            </tr>
            <? if ($your_bid>0) { ?>
            <tr>
               <td><strong><?=MSG_YOUR_BID;?></strong></td>
               <td class="greenfont"><strong><?=$fees->display_amount($your_bid, $item_details['currency']); ?></strong></td>
            </tr>
            <? } ?>
            <? if ($ad_display == 'live') { ?>
            <tr class="c1">
               <td><b><?=MSG_NR_BIDS;?></b></td>
               <td class="contentfont"><?=$item_details['nb_bids'];?></td>
            </tr>
            <? } ?>
            <? if ($ad_display == 'live' && $item_details['start_time'] <= CURRENT_TIME) { // dont show if the auction is not started ?>
            <tr class="c1">
               <td><b><?=MSG_TIME_LEFT;?></b></td>
               <td><?=time_left($item_details['end_time']); ?></td>
            </tr>
            <? } ?>
            <tr class="c1">
               <td><b><?=GMSG_START_TIME;?></b></td>
               <td><? echo ($ad_display == 'live' || $item_details['start_time_type'] == 'custom') ? show_date($item_details['start_time']) : GMSG_NOW; ?></td>
            </tr>
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
            <? if ($ad_display == 'live' && !empty($winners_content)) { ?>
            <tr class="c1">
               <td><b><?=MSG_WINNER_S; ?></b></td>
               <td><?=$winners_content;?></td>
            </tr>
				<? } ?>
            <?=$winners_message_board;?>
         </table>
      </td>
      <td width="30%">
      	<table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
               <td class="c3"><?=MSG_PROJECT_POSTER_INFORMATION;?> </td>
            </tr>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr>
               <td><b><?=$user_details['username'];?></b> <?=user_pics($user_details['user_id'], true, true);?></td>
            </tr>
            <tr class="c1">
               <td><?=MSG_REGISTERED_SINCE;?> <b><?=show_date($user_details['reg_date'], false);?></b><br>
               	<? echo GMSG_IN . ' <b>' . $seller_country . '</b>'; ?></td>
            </tr>
            <tr class="c5">
               <td></td>
            </tr>
         </table>
		</td>
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
      <td colspan="2"><?=database::add_special_chars($item_details['description']);?></td>
   </tr>
   <?=$custom_sections_table;?>
   <? if (item::count_contents($item_details['ad_image'])) { ?>
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
               <td width="100%" class="picselectmain" align="center"><img name="main_ad_image" src="<?=SITE_PATH;?>thumbnail.php?pic=<?=$item_details['ad_image'][0];?>&w=300&sq=Y&b=Y" border="0" alt="<?=$item_details['name'];?>"></td>
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
      <td class="c4" colspan="2"><strong><?=MSG_ADDITIONAL_FILES;?></strong> </td>
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
   <? if ($ad_display == 'live') { ?>
   <tr>
      <td align="center" colspan="2"><table cellpadding="3" cellspacing="1" border="0" class="counter">
            <tr>
               <td nowrap><?=MSG_ITEM_VIEWED;?> <?=($item_details['nb_clicks']+1); ?> <?=GMSG_TIMES;?></td>
            </tr>
         </table></td>
   </tr>
   <? } ?>
</table>
<br>
<? if ($ad_display == 'live') { ?>
<? if ($item_details['nb_bids']) { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c3" colspan="5"><?=MSG_BIDS_PLACED;?></td>
   </tr>
   <tr>
   	<td colspan="3" align="right"><?=MSG_FILTER_BIDS;?>: </td>
   	<td colspan="2" class="contentfont"><?=$filter_bids_content;?></td>
   </tr>
   <tr>
      <td class="c5" colspan="5"></td>
   </tr>
   <tr>
      <td><?=MSG_BIDDER_USERNAME;?></td>
      <td align="center"><?=MSG_LOCATION;?></td>
      <td align="center"><?=MSG_BID_AMOUNT;?></td>
      <td align="center"><?=MSG_BIDDER_DETAILS;?><br>
      	<span class="smallfont">
      		<?=MSG_REPUTATION;?><br>
      		<?=MSG_REVIEWS;?></span></td>
      <td align="center"><?=GMSG_STATUS;?></td>
   </tr>
	<tr class="c5">
		<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="135" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="130" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="130" height="1"></td>
	</tr>
	<?=$bids_placed_table;?>
</table>
<br>
<? } ?>

<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
      <td align='center' class='topitempage alertfont'><?=MSG_THE_POSTER;?>, <b><?=$user_details['username'];?></b>, <?=MSG_ASSUMES_RESP_EXPL;?> </td>
   </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<? if ($item_can_bid['result']) { ?>
	<form action="reverse_bid.php" method="post">
     	<input type="hidden" name="reverse_id" value="<?=$item_details['reverse_id'];?>">
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
      <td align="right"><?=MSG_POST_BID;?></td>
      <td><strong><?=$item_details['currency'];?></strong>
			<input name="max_bid" type="text" id="max_bid" size="7" /></td>
   </tr>
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
