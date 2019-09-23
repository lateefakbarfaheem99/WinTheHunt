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

<form name="hidden_form" action="auction_details.php" method="get" style="margin:0px;">
   <input type="hidden" name="option" />
   <input type="hidden" name="auction_id" />
   <input type="hidden" name="message_content" />
   <input type="hidden" name="question_id" />
</form>
<? } ?>
<? if ($print_button == 'show') { ?>
<table align="center" border="0" cellpadding="3" cellspacing="1" class="errormessage">
   <tr>
      <td class="contentfont"><a href="#" onclick="javascript:window.print(this);"><?=GMSG_PRINT_THIS_PAGE;?></a></td>
   </tr>
</table>
<? } ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr valign="top">
      <td width="60%"><div class="itemid"><?=$item_details['name'];?></div>
         <div class="itemidend">
            <?=MSG_AUCTION_ID;?>: <b><?=$item_details['reverse_id'];?></b>
            <? if ($ad_display == 'live') { ?>
            &nbsp;&nbsp;|&nbsp;&nbsp;<b><?=MSG_STATUS;?></b>: <?=item::item_status($item_details['closed']); ?>
            <? } ?>
            <? if ($ad_display == 'live') { ?>
            &nbsp;&nbsp;|&nbsp;&nbsp;<?=MSG_ITEM_VIEWED;?>
            <span class="redfont"><?=($item_details['nb_clicks']+1); ?> <?=GMSG_TIMES;?></span>
            <? } ?>
         </div>
         <div><img src='themes/<?=$setts['default_theme'];?>"/img/pixel.gif' width='1' height='3'></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <? if ($ad_display == 'live') { ?>
               <td class="contentfont" nowrap style="padding-right: 10px;"><img src="themes/<?=$setts['default_theme'];?>/img/arrow.gif" align="absmiddle" border="0" hspace="5"> 
						<a href="<?=process_link('reverse_auctions');?>"><?=MSG_BACK_TO_HP;?></a></td>
               <? if (!empty($search_url)) { ?>
               <td class="contentfont" nowrap style="padding-right: 10px;">| <a href="<?=$search_url;?>"><?=MSG_BACK_TO_SEARCH_PAGE;?></a></td>
               <? } ?>
               <? } ?>
               <td width="100%"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                     <tr>
                        <td nowrap><b><?=MSG_MAIN_CATEGORY;?>:</b></td>
                        <td class="contentfont" width="100%"><?=$main_category_display;?></td>
                     </tr>
                     <? if ($item_details['addl_category_id']) { ?>
                     <tr>
                        <td nowrap><b><?=MSG_ADDL_CATEGORY;?>:</b></td>
                        <td class="contentfont"><?=$addl_category_display;?></td>
                     </tr>
                     <? } ?>
                  </table></td>
            </tr>
         </table></td>
      <td class="contentfont">
      	<div class="errormessage">
            <? if ($ad_display == 'live') { ?>
            <table width="100%" border="0" cellpadding="3" cellspacing="1">
               <tr valign="top">
                  <? if ($session->value('user_id')) { ?>
                  <td nowrap width="100%" class="contentfont">
                  	<div style="padding-bottom: 3px;">
                  		<b><?=MSG_WELCOME;?>, <?=$session->value('username');?></b>
                  	</div>
                     <? if ($item_details['owner_id'] == $session->value('user_id')) { ?>
						      <? if ($item_details['active']==1)	{ ?>
						      <a href="reverse_manage.php?do=edit&reverse_id=<?=$item_details['reverse_id'];?>&edit_option=new"><?=MSG_EDIT_AUCTION;?></a>
						      &nbsp;|&nbsp; <a href="members_area.php?do=delete_reverse&reverse_id=<?=$item_details['reverse_id'];?>&page=reverse&section=open" onclick="return confirm('<?=MSG_DELETE_CONFIRM;?>');"><?=MSG_DELETE;?></a>
					         <? } ?>
                     <? } ?>
                  </td>
                  <? } else { ?>
                  <td class="contentfont" ><?=MSG_STATUS_BIDDER_SELLER_REVERSE_A;?>
                     <a href="<?=process_link('login');?>">
                     <?=MSG_STATUS_BIDDER_SELLER_B;?>
                     </a>
                     <?=MSG_STATUS_BIDDER_SELLER_C;?></td>
                  <? } ?>
               </tr>
            </table>
            <? } ?>
            <a href="javascript:popUp('<?=process_link('reverse_print', array('reverse_id' => $item_details['reverse_id']));?>');"><img src="themes/<?=$setts['default_theme'];?>/img/system/print.gif" align="absmiddle" border="0" hspace="3"><?=MSG_PRINT_VIEW;?></a> 
			</div>
		</td>
   </tr>
</table>
<br>

<?=$msg_changes_saved;?>
<?=$block_reason_msg;?>
<div id="TabbedPanels1" class="TabbedPanels">
   <ul class="TabbedPanelsTabGroup">
      <li class="TabbedPanelsTab" tabindex="0">
      	<a href="javascript:void(0);"><div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="9" border="0"></div><?=MSG_ITEM_DETAILS;?></a>
      </li>
   </ul>
   <div class="TabbedPanelsContentGroup" >
      <div class="TabbedPanelsContent">
         <table width="100%" border="0" cellspacing="10" cellpadding="0">
            <tr>
               <td>
               	<? if (!empty($direct_payment_box)) { ?>
						<table width="100%" border="0" cellspacing="1" cellpadding="3">
                     <tr>
                        <td class="title"><?=MSG_DIRECT_PAYMENT;?></td>
                     </tr>
						   <? foreach ($direct_payment_box as $dp_box) { ?>
						   <tr>
						      <td><?=$dp_box;?></td>
						   </tr>
						   <? } ?>
                  </table>  
                  <br>
                  <? } ?>     
               	<table width="100%" border="0" cellspacing="1" cellpadding="3">
                     <tr valign="top">
                        <? if (!empty($item_details['ad_image'][0])) { ?>
                        <td width="20%" align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                              <tr>
                                 <td align="center"><img src="<?=SITE_PATH;?>thumbnail.php?pic=<?=$item_details['ad_image'][0];?>&w=250&sq=N&b=N" border="0" alt="<?=$item_details['name'];?>"></td>
                              </tr>
                           </table></td>
                        <? } ?>
                        <td width="55%"><!-- Start Table for item details -->
                           <table width="100%" border="0" cellspacing="1" cellpadding="2">
                              <tr>
                                 <td nowrap><b><?=MSG_BUDGET;?></b>:</td>
                                 <td width="100%"><?=$fees->budget_output($item_details['budget_id'], null, $item_details['currency']); ?></td>
                              </tr>
                              <? if ($your_bid>0) { ?>
                              <tr>
                                 <td nowrap><b><?=MSG_YOUR_BID;?></b>:</td>
                                 <td class="greenfont" width="100%"><b><?=$fees->display_amount($your_bid, $item_details['currency']); ?></b></td>
                              </tr>
                              <? } ?>
                              <? if ($ad_display == 'live') { ?>
                              <tr>
                                 <td nowrap><b><?=MSG_NR_BIDS;?></b>:</td>
                                 <td  width="100%" class="contentfont"><?=$item_details['nb_bids'];?></td>
                              </tr>
                              <? } ?>
                           </table>
                           <? if ($item_can_bid['result']) { ?>
                           <br>
                           <table width="100%" border="0" cellpadding="1" cellspacing="8" class="border c1">
                              <form action="reverse_bid.php" method="post">
                                 <input type="hidden" name="reverse_id" value="<?=$item_details['reverse_id'];?>">
                                 <input type="hidden" name="action" value="bid_confirm">
                                 <tr>
                                    <td>
                                    	<? if ($item_can_bid['show_box']) { ?>                                       
                                       <?=MSG_POST_BID;?>
                                       <b>
                                       <?=$item_details['currency'];?>
                                       </b>
                                       <input name="max_bid" type="text" id="max_bid" size="7" />                                       
                                    <td><input class="placebid" name="form_place_bid" type="submit" id="form_place_bid" value="<?=MSG_PLACE_BID;?>" <? echo (!$item_can_bid['result'] || $blocked_user) ? 'disabled' : ''; ?>>
                                       <? } ?>
                                    </td>
                                 </tr>
                              </form>
                           </table>
                           <br>
                           <? } ?>
                           <? if (!empty($item_can_bid['display'])) { ?>
                           <div class="errormessage">
                              <?=$item_can_bid['display'];?>
                           </div>
                           <br>
                           <? } ?>
                           <table width="100%" border="0" cellspacing="1" cellpadding="2">
                              <? if ($ad_display == 'live' && $item_details['start_time'] <= CURRENT_TIME) { // dont show if the auction is not started ?>
                              <tr>
                                 <td nowrap><b><?=MSG_TIME_LEFT;?></b>:</td>
                                 <td><?=time_left($item_details['end_time']); ?></td>
                              </tr>
                              <? } ?>
                              <tr>
                                 <td nowrap><b><?=GMSG_START_TIME;?></b>:</td>
                                 <td><? echo ($ad_display == 'live' || $item_details['start_time_type'] == 'custom') ? show_date($item_details['start_time']) : GMSG_NOW; ?></td>
                              </tr>
                              <? if ($ad_display == 'live' || $item_details['end_time_type'] == 'custom') { ?>
                              <tr>
                                 <td nowrap><b><?=GMSG_END_TIME;?></b>:</td>
                                 <td><?=show_date($item_details['end_time']); ?></td>
                              </tr>
                              <? } else { ?>
                              <tr>
                                 <td><b><?=GMSG_DURATION;?></b>:</td>
                                 <td><? echo $item_details['duration'] . ' ' . GMSG_DAYS; ?></td>
                              </tr>
                              <? } ?>
                              <tr>
                                 <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
                                 <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
                              </tr>
                              <? if ($ad_display == 'live' && !empty($winners_content)) { ?>
                              <tr>
                                 <td><b><?=MSG_WINNER_S; ?></b></td>
                                 <td><?=$winners_content;?></td>
                              </tr>
                              <? } ?>
                              <?=$winners_message_board;?>
                           </table></td>
                        <td width="25%"><table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
                              <tr>
                                 <td class="c4"><b><?=MSG_PROJECT_POSTER_INFORMATION;?></b></td>
                              </tr>
                              <tr>
                                 <td><b><?=$user_details['username'];?></b> <?=user_pics($user_details['user_id'], true, true);?></td>
                              </tr>
                              <tr>
                                 <td><?=MSG_REGISTERED_SINCE;?> <b><?=show_date($user_details['reg_date'], false);?></b><br>
                                    <? echo GMSG_IN . ' <b>' . $seller_country . '</b>'; ?></td>
                              </tr>
                           </table></td>
                     </tr>
                  </table>
                  <br>
                  <table width="100%" border="0" cellspacing="1" cellpadding="3">
                     <tr>
                        <td colspan="2" class="title"><?=GMSG_DESCRIPTION;?></td>
                     </tr>
                     <tr>
                        <td colspan="2"><?=database::add_special_chars($item_details['description']);?></td>
                     </tr>
                  </table>
                  <?=$custom_sections_table;?>
                  <? if (item::count_contents($item_details['ad_image'])) { ?>
                  <table width="100%" border="0" cellspacing="1" cellpadding="3">
                     <tr>
                        <td class="title" colspan="2"><?=MSG_AUCTION_IMAGES;?></td>
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
                                 <td width="100%" class="picselectmain" align="center"><img name="main_ad_image" src="<?=SITE_PATH;?>thumbnail.php?pic=<?=$item_details['ad_image'][0];?>&w=500&sq=N&b=N" border="0" alt="<?=$item_details['name'];?>"></td>
                              </tr>
                           </table></td>
                     </tr>
                  </table>
                  <? } ?>
                  <? if (item::count_contents($item_details['ad_video'])) { ?>
                  <table width="100%" border="0" cellspacing="1" cellpadding="3">
                     <tr>
                        <td class="title" colspan="2"><?=MSG_AUCTION_MEDIA;?></td>
                     </tr>
                     <tr>
                        <td class="border" colspan="2"><table width="100%" cellpadding="3" cellspacing="0" border="0">
                              <tr align="center">
                                 <td valign="top" class="picselect"><table cellpadding="3" cellspacing="1" border="0">
                                       <tr align="center">
                                          <td><b><?=MSG_SELECT_VIDEO;?></b></td>
                                       </tr>
                                       <tr align="center">
                                          <td><?=$ad_video_thumbnails; ?></td>
                                       </tr>
                                    </table></td>
                                 <td width="100%" class="picselectmain"align="center"><?=$ad_video_main_box; ?></td>
                              </tr>
                           </table></td>
                     </tr>
                  </table>
                  <? } ?>
                  <? if (item::count_contents($item_details['ad_dd'])) { ?>
                  <table width="100%" border="0" cellspacing="1" cellpadding="3">
                     <tr>
                        <td class="title" colspan="2"><?=MSG_ADDITIONAL_FILES;?></td>
                     </tr>
                     <tr>
                        <td class="border" colspan="2"><table width="100%" cellpadding="3" cellspacing="0" border="0">
                              <tr align="center">
                                 <td valign="top"><?=$ad_dd_thumbnails; ?></td>
                              </tr>
                           </table></td>
                     </tr>
                  </table>
                  <? } ?>
			         <? if ($item_details['nb_bids']) { ?>
			         <br>
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
               </td>
            </tr>
         </table>
      </div>
      <!-- EOF Bids Placed Content -->
   </div>
</div>
<?=$auction_print_footer;?>
