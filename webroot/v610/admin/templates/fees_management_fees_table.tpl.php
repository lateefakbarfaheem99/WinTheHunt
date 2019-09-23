<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

global $setts;
?>

<table width="75%" border="0" cellpadding="3" cellspacing="3" align="center" class="border">
   <? if (!$category_id) { ?>
   <tr class="c3">
      <td colspan="2"><?=GMSG_GENERAL;?></td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=signup_fee"><?=GMSG_USER_SIGNUP_FEE;?></a></td>
      <td>&nbsp;</td>
   </tr>
   <? } ?>
   <? if (!$category_id || $fee_type != 'reverse') { ?>
   <tr class="c3">
      <td colspan="2"><?=AMSG_AUCTION_FEES;?> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=setup&tiers=1"><?=GMSG_SETUP_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=endauction&tiers=1"><?=GMSG_ENDAUCTION_FEE;?></a> </td>
   </tr>
   <tr class="c2">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=hpfeat_fee"><?=GMSG_HPFEAT_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=catfeat_fee"><?=GMSG_CATFEAT_FEE;?></a> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=hlitem_fee"><?=GMSG_HL_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=bolditem_fee"><?=GMSG_BOLD_FEE;?></a> </td>
   </tr>
   <tr class="c2">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=picture_fee"><?=GMSG_IMG_UPL_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=video_fee"><?=GMSG_MEDIA_UPL_FEE;?></a> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=second_cat_fee"><?=GMSG_ADDLCAT_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=custom_start_fee"><?=GMSG_CUSTOM_START_FEE;?></a> </td>
   </tr>
   <tr class="c2">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=buyout_fee"><?=GMSG_BUYOUT_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=rp_fee"><?=GMSG_RP_FEE;?></a> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=makeoffer_fee"><?=GMSG_MAKEOFFER_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=swap_fee"><?=GMSG_SWAP_FEE;?></a></td>
   </tr>
   <tr class="c2">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=relist_fee_reduction"><?=GMSG_REL_FEES_RED_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=dd_fee"><?=GMSG_DD_FEE;?></a> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=durations_fee"><?=GMSG_DURATIONS_FEE;?></a> </td>
      <td></td>
   </tr>
   <tr class="c3">
      <td colspan="2"><?=AMSG_WANTED_AD_FEES;?></td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?category_id=<?=$category_id;?>&fee_column=wanted_ad_fee"><?=GMSG_WA_SETUP_FEE;?></a> </td>
      <td></td>
   </tr>
   <? } ?>
   <? if ($setts['enable_reverse_auctions'] && (!$category_id || $fee_type == 'reverse')) { ?>
   <tr class="c3">
      <td colspan="2"><?=AMSG_REVERSE_AUCTION_FEES;?> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=setup"><?=GMSG_SETUP_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=reverse_endauction&tiers=1"><?=GMSG_ENDAUCTION_FEE;?></a> </td>
   </tr>
   <tr class="c2">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=hpfeat_fee"><?=GMSG_HPFEAT_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=catfeat_fee"><?=GMSG_CATFEAT_FEE;?></a> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=hlitem_fee"><?=GMSG_HL_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=bolditem_fee"><?=GMSG_BOLD_FEE;?></a> </td>
   </tr>
   <tr class="c2">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=picture_fee"><?=GMSG_IMG_UPL_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=video_fee"><?=GMSG_MEDIA_UPL_FEE;?></a> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=second_cat_fee"><?=GMSG_ADDLCAT_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=custom_start_fee"><?=GMSG_CUSTOM_START_FEE;?></a> </td>
   </tr>
   <tr class="c2">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=relist_fee_reduction"><?=GMSG_REL_FEES_RED_FEE;?></a> </td>
      <td><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=dd_fee"><?=GMSG_DD_FEE;?></a> </td>
   </tr>
   <tr class="c1">
      <td width="50%"><img src="images/a.gif" align="absmiddle" /> <a href="fees_management.php?fee_type=reverse&category_id=<?=$category_id;?>&fee_column=bid_fee"><?=GMSG_REVERSE_BID_FEE;?></a> </td>
      <td></td>
   </tr>
   <? } ?>
</table>
<br>