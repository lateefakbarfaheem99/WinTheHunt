<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$site_fees_header_message; ?>

<br>
<? if ($show_categories_box) { ?>
<table border="0" cellspacing="2" cellpadding="3" align="center" class="border">
   <form action="site_fees.php" method="post">
      <tr class="c2">
         <td><?=MSG_CHOOSE_CATEGORY;?>
            : </td>
         <td><?=$fees_categories_box;?></td>
         <td><input type="submit" name="form_choose_category" value="<?=GMSG_SELECT;?>"></td>
      </tr>
   </form>
</table>
<br>
<? } ?>
<? if ($fee_type != 'reverse') { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2">
	<tr>
		<td colspan="2" class="c3"><?=MSG_AUCTION_FEES;?></td>	
	</tr>
   <? if ($is_setup_fee) { ?>
   <tr>
      <td colspan="2" class="c4"><strong>
         <?=MSG_LISTING_FEES;?>
         </strong></td>
   </tr>
	<?=$listing_fees_table;?>
   <tr>
   	<td colspan="2" class="c3"></td>
   </tr>
   <? } ?>
   <? if ($is_sale_fee) { ?>
   <tr>
      <td class="c4" colspan="2"><strong>
         <?=GMSG_ENDAUCTION_FEE;?>
         - <? echo (stristr($fee_row['endauction_fee_applies'], 's')) ? MSG_PAID_BY_SELLER : MSG_PAID_BY_BUYER; ?></strong> </td>
   </tr>
	<?=$sale_fees_table;?>
   <tr>
   	<td colspan="2" class="c3"></td>
   </tr>
   <? } ?>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="2">
   <? if ($fee_row['second_cat_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_ADDLCAT_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['second_cat_fee']); ?></td>
   </tr>
   <? } ?>
   <? if (!empty($durations_output)) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_DURATIONS_FEE;?>
         </strong></td>
      <td><?=$durations_output; ?></td>
   </tr>
	<? } ?>
   <? if ($fee_row['picture_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_IMG_UPL_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['picture_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['hlitem_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_HL_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['hlitem_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['bolditem_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_BOLD_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['bolditem_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['catfeat_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_CATFEAT_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['catfeat_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['hpfeat_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_HPFEAT_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['hpfeat_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['rp_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_RP_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['rp_fee']); ?></td>
   </tr>
   <? } ?>
   <? if (($fee_row['swap_fee']>0 || $setts['display_free_fees']) && $setts['enable_swaps']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_SWAP_FEE;?>
         </strong></td>
      <td><? echo ($fee_row['swap_fee_calc_type'] == 'flat') ? $fees->display_amount($fee_row['swap_fee']) : $fee_row['swap_fee'] . '% ' . MSG_OF_START_PRICE; ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['buyout_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_BUYOUT_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['buyout_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['makeoffer_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_MAKEOFFER_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['makeoffer_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['custom_start_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_CUSTOM_START_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['custom_start_fee']); ?></td>
   </tr>
   <? } ?>
   <? if (($fee_row['video_fee']>0 || $setts['display_free_fees']) && $setts['max_media']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_MEDIA_UPL_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['video_fee']); ?></td>
   </tr>
   <? } ?>
   <? if (($fee_row['dd_fee']>0 || $setts['display_free_fees']) && $setts['dd_enabled'])  { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_DD_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['dd_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['relist_fee_reduction']>0) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_REL_FEES_RED_FEE;?>
         </strong></td>
      <td><? echo $fee_row['relist_fee_reduction'] . '%'; ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['verification_fee']>0 && $setts['enable_seller_verification']) { ?>
   <tr class="c5">
      <td colspan="2"></td>
   </tr>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_SELLER_VERIFICATION_FEE;?>
         </strong></td>
      <td><? echo $fees->display_amount($fee_row['verification_fee']) . ', ' . (($fee_row['verification_recurring']) ? MSG_RECURRING_EVERY . ' ' . $fee_row['verification_recurring'] . ' ' . GMSG_DAYS : MSG_FLAT_FEE); ?></td>
   </tr>
   <? } ?>
   <? if ($fee_row['bidder_verification_fee']>0) { ?>
   <tr class="c5">
      <td colspan="2"></td>
   </tr>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_BIDDER_VERIFICATION_FEE;?>
         </strong></td>
      <td><? echo $fees->display_amount($fee_row['bidder_verification_fee']) . ', ' . (($fee_row['bidder_verification_recurring']) ? MSG_RECURRING_EVERY . ' ' . $fee_row['bidder_verification_recurring'] . ' ' . GMSG_DAYS : MSG_FLAT_FEE); ?></td>
   </tr>
   <? } ?>
   <? if (($fee_row['wanted_ad_fee']>0 || $setts['display_free_fees']) && $setts['enable_wanted_ads']) { ?>
   <tr class="c5">
      <td colspan="2"></td>
   </tr>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_WA_SETUP_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($fee_row['wanted_ad_fee']); ?></td>
   </tr>
   <? } ?>
</table>
<br>
<? } ?>

<? if (is_array($reverse_fees) && $setts['enable_reverse_auctions']) { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2">
	<tr>
		<td colspan="2" class="c3"><?=MSG_REVERSE_AUCTION_FEES;?></td>	
	</tr>
   <? if ($reverse_fees['setup'] > 0) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_AUCTION_SETUP_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['setup']); ?></td>
   </tr>
   <tr>
   	<td colspan="2" class="c3"></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['bid_fee'] > 0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_REVERSE_BID_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['bid_fee']); ?></td>
   </tr>
   <tr>
   	<td colspan="2" class="c3"></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['second_cat_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_ADDLCAT_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['second_cat_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['picture_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_IMG_UPL_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['picture_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['hlitem_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_HL_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['hlitem_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['bolditem_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_BOLD_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['bolditem_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['catfeat_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_CATFEAT_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['catfeat_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['hpfeat_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_HPFEAT_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['hpfeat_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['custom_start_fee']>0 || $setts['display_free_fees']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_CUSTOM_START_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['custom_start_fee']); ?></td>
   </tr>
   <? } ?>
   <? if (($reverse_fees['video_fee']>0 || $setts['display_free_fees']) && $setts['max_media']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_MEDIA_UPL_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['video_fee']); ?></td>
   </tr>
   <? } ?>
   <? if (($reverse_fees['dd_fee']>0 || $setts['display_free_fees']) && $setts['dd_enabled']) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_DD_FEE;?>
         </strong></td>
      <td><?=$fees->display_amount($reverse_fees['dd_fee']); ?></td>
   </tr>
   <? } ?>
   <? if ($reverse_fees['relist_fee_reduction']>0) { ?>
   <tr class="c2">
      <td align="right" width="50%"><strong>
         <?=GMSG_REL_FEES_RED_FEE;?>
         </strong></td>
      <td><? echo $reverse_fees['relist_fee_reduction'] . '%'; ?></td>
   </tr>
   <? } ?>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="2">   
<? if ($is_reverse_sale_fee) { ?>
   <tr>
   	<td colspan="2" class="c3"></td>
   </tr>
   <tr>
      <td class="c4" colspan="2"><strong>
         <?=GMSG_ENDAUCTION_FEE;?>
         - <? echo (stristr($reverse_fees['endauction_fee_applies'], 's')) ? MSG_PAID_BY_SELLER : MSG_PAID_BY_BUYER; ?></strong> </td>
   </tr>
	<?=$reverse_sale_fees_table;?>
   <tr>
   	<td colspan="2" class="c3"></td>
   </tr>
   <? } ?>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="2">
</table>
<br>
<? } ?>

<? if ($is_stores && !$category_id) { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2">
   <tr>
      <td class="c3" colspan="2"><strong><?=MSG_STORE_ACCOUNT_TYPES;?></strong></td>
   </tr>
		<?=$store_subscriptions_table;?>
   </tr>
</table>
<br>
<? } ?>

<? if ($setts['enable_tax'] && $tax_amount > 0) { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2">
   <tr>
      <td align="center"><?=$tax_message;?></td>
   </tr>
</table>
<? } ?>
