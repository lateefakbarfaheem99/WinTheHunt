<?
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<?=header2(MSG_VIEW_MEMBER_PROFILE);?>
<br>
<div class="title"> <img src="themes/<?=$setts['default_theme'];?>/img/system/profile.gif" align="absmiddle">
   <?=MSG_VIEW_PROFILE_FOR;?>: <b>
   <?=$user_details['username'];?>
   </b>
   <?=user_pics($user_details['user_id']);?>
</div>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="contentfont">
   <tr valign="top">
      <td width="50%"><table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
            <tr>
               <td class="c3" colspan="2"><?=MSG_INFORMATION;?>:</td>
            </tr>
            <tr>
               <td class="c5" colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c1">
               <td width="30%" align="right"><b><?=MSG_REGISTERED_SINCE;?></b></td>
               <td width="70%"><b><?=show_date($user_details['reg_date'], false);?></b> <? echo GMSG_IN . ' <b>' . $seller_country . '</b>'; ?></td>
            </tr>
            <tr class="c1">
               <td align="right"><b><?=MSG_PREFERRED_SELLER;?></b></td>
               <td><?=field_display($user_details['preferred_seller'], GMSG_NO, GMSG_YES);?></td>
            </tr>
            <tr class="c2">
               <td align="right"><b><?=MSG_REPUTATION;?></b></td>
               <td><?=user_pics($user_details['user_id'], true);?></td>
            </tr>
         </table>
         <br>
         <table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
            <tr>
               <td class="c3" colspan="2"><?=MSG_ACTIVITY_INFO;?>:</td>
            </tr>
            <td class="c5" colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            <tr class="c1">
               <td width="30%" align="right"><b><?=MSG_BIDDING;?></b></td>
               <td width="70%"><b><?=$bidding_times;?></b> <?=MSG_TIMES_IN;?> <b><?=$bidding_auctions;?></b> <?=MSG_AUCTIONS;?></td>
            </tr>
            <tr class="c2">
               <td align="right"><b><?=MSG_SELLING;?></b></td>
               <td><b><?=$nb_open_items;?></b> <?=MSG_LIVE_AUCTIONS;?>, <b><?=$nb_sold_items;?></b> <?=MSG_ITEMS_SOLD;?></td>
            </tr>
            <tr class="c1">
               <td align="right"><b>Auctions</b></td>
               <td><a href="other_items.php?owner_id=<?=$user_id;?>"><?=MSG_FIND_ALL_AUCTIONS_FROM;?> <b><?=$user_details['username'];?></b></a></td>
         </table>
         </td>
      <td width="1%">&nbsp;</td>
      <td width="50%"><table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
            <tr>
               <td class="c3" colspan="2"><?=MSG_CONTACT_INFO;?>:</td>
            </tr>
            <tr class="c2">
               <td width="30%" align="right"><b><?=MSG_COUNTRY;?></b></td>
               <td width="70%"><?=$seller_country;?></td>
            </tr>
            <!--
            <tr class="c2">
               <td align="right"><b>Phone</b></td>
               <td>000 000000000</td>
            </tr>
            -->
            <? if ($user_details['profile_www']) { ?>
            <tr class="c1">
               <td align="right"><b><?=MSG_WEBSITE_URL;?></b></td>
               <td><a href="<?=$user_details['profile_www'];?>" target="_blank"><?=$user_details['profile_www'];?></a></td>
            </tr>
            <? } ?>
            <? if ($user_details['profile_msn']) { ?>
            <tr class="c2">
               <td align="right"><img src="themes/<?=$setts['default_theme'];?>/img/system/msn.gif"></td>
               <td><b>MSN:</b> <?=$user_details['profile_msn'];?></td>
            </tr>
            <? } ?>
            <? if ($user_details['profile_icq']) { ?>
            <tr class="c1">
               <td align="right"><img src="themes/<?=$setts['default_theme'];?>/img/system/icq.gif"></td>
               <td><b>ICQ:</b> <?=$user_details['profile_icq'];?></td>
            </tr>
            <? } ?>
            <? if ($user_details['profile_aim']) { ?>
            <tr class="c2">
               <td align="right"><img src="themes/<?=$setts['default_theme'];?>/img/system/aim.gif"></td>
               <td><b>AIM:</b> <?=$user_details['profile_aim'];?></td>
            </tr>
            <? } ?>
            <? if ($user_details['profile_yim']) { ?>
            <tr class="c1">
               <td align="right"><img src="themes/<?=$setts['default_theme'];?>/img/system/yahoo.gif"></td>
               <td><b>YIM:</b> <?=$user_details['profile_yim'];?></td>
            </tr>
            <? } ?>
            <!--
            <tr class="c1">
               <td align="right"><b>Private Message:</b></td>
               <td><a href="#">Send a private message to <b>phpprobid</b></a></td>
            </tr>
            -->
         </table></td>
   </tr>
</table>
