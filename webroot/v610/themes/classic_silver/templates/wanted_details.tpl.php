<?
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
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

<form name="hidden_form" action="wanted_details.php" method="get">
   <input type="hidden" name="option" />
   <input type="hidden" name="wanted_ad_id" />
   <input type="hidden" name="message_content" />
   <input type="hidden" name="question_id" />
</form>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contentfont" nowrap style="padding-right: 10px;"><img src="themes/<?=$setts['default_theme'];?>/img/system/home.gif" align="absmiddle" border="0" hspace="5">
			<a href="<?=process_link('index');?>"><?=MSG_BACK_TO_HP;?></a></td>
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
               <td align="right" class="itemidend"><?=MSG_WANTED_AD_ID;?>
                  : <b>
                  <?=$item_details['wanted_ad_id'];?>
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
<br>
<?=$msg_changes_saved;?>
<?=$block_reason_msg;?>
<table width="100%" border="0" cellpadding="0" cellspacing="2">
   <tr valign="top">
      <td width="20%" align="center" class="border">
			<? if (!empty($item_details['ad_image'][0])) { ?>
      	<table width="100%" border="0" cellspacing="2" cellpadding="3">
      		<tr>
               <td align="center"><img src="<?=SITE_PATH;?>thumbnail.php?pic=<?=$item_details['ad_image'][0];?>&w=150&sq=Y&b=Y" border="0" alt="<?=$item_details['name'];?>"></td>
            </tr>
			</table>
		<? } ?>
		</td>
      <td width="50%"><!-- Start Table for item details -->
         <table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
               <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c1">
               <td><b><?=MSG_OFFERS;?></b></td>
               <td class="contentfont"><?=$item_details['nb_bids'];?></td>
            </tr>
            <tr class="c1">
               <td><b><?=MSG_LOCATION;?></b></td>
               <td><?=$auction_location;?></td>
            </tr>
            <tr class="c1">
               <td><b><?=MSG_COUNTRY;?></b></td>
               <td><?=$auction_country;?></td>
            </tr>
            <tr class="c1">
               <td><b><?=MSG_TIME_LEFT;?></b></td>
               <td><?=time_left($item_details['end_time']); ?></td>
            </tr>
            <tr class="c1">
               <td><b><?=GMSG_START_TIME;?></b></td>
               <td><?=show_date($item_details['start_time']); ?></td>
            </tr>
            <tr class="c1">
               <td><b><?=GMSG_END_TIME;?></b></td>
               <td><?=show_date($item_details['end_time']); ?></td>
            </tr>
            <tr class="c1">
               <td><b><?=MSG_STATUS;?></b></td>
               <td><?=item::item_status($item_details['closed']); ?></td>
            </tr>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
         </table>
      </td>
      <td width="30%"><table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
               <td class="c3"><?=MSG_POSTER_INFORMATION;?> </td>
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
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
         </table>
         <?=$reputation_table_small;?>
		</td>
   </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
   <tr>
      <td class="c3" colspan="2"><strong><?=GMSG_DESCRIPTION;?></strong></td>
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
      <td class="c3" colspan="2"><strong><?=MSG_WANTED_AD_IMAGES;?></strong> </td>
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
                        <td><b> <?=MSG_SELECT_PICTURE;?> </b></td>
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
      <td class="c3" colspan="2"><strong><?=MSG_WANTED_AD_MEDIA;?></strong> </td>
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
   <tr>
      <td align="center" colspan="2"><table cellpadding="3" cellspacing="1" border="0" class="counter">
            <tr>
               <td nowrap><?=MSG_ITEM_VIEWED;?> <?=($item_details['nb_clicks']+1); ?> <?=GMSG_TIMES;?></td>
            </tr>
         </table></td>
   </tr>
   <? if ($setts['enable_asq']) { ?>
   <tr>
      <td class="c4" colspan="2"><b><?=MSG_ASK_SELLER_QUESTION;?></b> </td>
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
	<? } else if ($session->value('user_id') == $item_details['owner_id']) { ?>
   <tr>
      <td align="center" colspan="2"><?=MSG_CANT_POST_QUESTION_OWNER;?></td>
   </tr>
	<? } else { ?>
	<tr>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	</tr>
   <form action="wanted_details.php" method="POST">
   	<input type="hidden" name="wanted_ad_id" value="<?=$item_details['wanted_ad_id'];?>">
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
                        <option value="4" selected><?=MSG_POST_QUESTION_PUBLICLY;?></option>
                        <? } ?>
                        <option value="5"><?=MSG_POST_QUESTION_PRIVATELY;?></option>
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
</table>
<br>
<? if ($is_wanted_offers) { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c3" colspan="6"><?=MSG_ACTIVE_OFFERS;?></td>
   </tr>
   <tr class="membmenu" valign="top">
      <td align="center"><?=MSG_PICTURE;?></td>
      <td><?=MSG_ITEM_TITLE;?></td>
      <td align="center"><?=MSG_START_BID;?></td>
      <td align="center"><?=MSG_MAX_BID;?></td>
      <td align="center"><?=MSG_NR_BIDS;?></td>
      <td align="center"><?=MSG_ENDS;?></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
   </tr>
   <?=$active_offers_content;?>
</table>
<br>
<? } ?>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
      <td align='center' class='topitempage alertfont'><?=MSG_THE_POSTER;?>, <b><?=$user_details['username'];?></b>, <?=MSG_ASSUMES_RESP_EXPL;?> </td>
   </tr>
</table>
<? if ($item_details['owner_id'] != $session->value('user_id') && !$blocked_user) { ?>
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c3" colspan="2"><?=MSG_ENTER_AN_OFFER;?></td>
   </tr>
	<? if ($session->value('user_id')) { ?>
	<form action="wanted_details.php" method="get">
     	<input type="hidden" name="wanted_ad_id" value="<?=$item_details['wanted_ad_id'];?>">
		<input type="hidden" name="action" value="submit_offer">
   <tr>
      <td class="c2" colspan="2"><b><?=$item_details['name'];?></b></td>
   </tr>
	<tr class="c5">
		<td width="150"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
		<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
	</tr>
   <tr class="c1">
      <td align="right"><?=MSG_CHOOSE_AN_ITEM;?></td>
      <td><?=$offer_drop_down;?></td>
   </tr>
	</form>
	<? } else if ($item_details['closed']) { ?>
	<tr class="c1">
		<td align="center" class="contentfont"><?=MSG_CANTOFFER_CLOSED;?></td>
	</tr>	
	<? } else { ?>
	<tr class="c1">
		<td align="center" class="contentfont" style="color: red; font-weight: bold;"><?=MSG_CANTOFFER_LOGIN;?>
			<div align="center" class="contentfont"><a href="login.php?redirect=wanted_details.php?wanted_ad_id=<?=$item_details['wanted_ad_id'];?>"><?=MSG_LOGIN_TO_MEMBERS_AREA;?></a></div>
		</td>
	</tr>
	<? } ?>
</table>
<? } ?>
