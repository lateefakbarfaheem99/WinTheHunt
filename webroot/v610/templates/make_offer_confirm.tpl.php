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
   <form action="make_offer.php" method="post">
      <input type="hidden" name="action" value="<?=$action;?>">
      <input type="hidden" name="auction_id" value="<?=$item_details['auction_id'];?>">
      <tr>
         <td class="contentfont"><table width="100%" border="0" cellpadding="3" cellspacing="2">
               <tr class="c4">
                  <td align="right"><strong>
                     <?=MSG_ITEM_TITLE;?>
                     </strong></td>
                  <td><strong>
                     <?=$item_details['name'];?>
                     </strong></td>
               </tr>
               <tr class="c4">
                  <td></td>
                  <td></td>
               </tr>
               <? if ($setts['makeoffer_private'] && $user_details['show_makeoffer_ranges']) { ?>
               <tr class="c1">
                  <td width="150" align="right"><strong>
                     <?=MSG_OFFER_RANGE;?></strong></td>
                  <td><?=$item->offer_range($item_details);?></td>
               </tr>
               <? } ?>
               <tr class="c1">
                  <td width="150" align="right"><strong>
                     <?=MSG_OFFER_AMOUNT;?></strong></td>
                  <td><?=currency_symbol($item_details['currency']);?>
                     <input name="amount" type="text" id="amount" value="<?=$amount;?>" size="15" onkeypress="return noenter()"></td>
               </tr>
               <? if ($item_details['auction_type']=='dutch') { ?>
               <tr class="c1">
                  <td align="right"><strong>
                     <?=GMSG_QUANTITY;?>
                     </strong></td>
                  <td valign="top"><input name="quantity" type="text" id="quantity" value="<?=$quantity;?>" size="8"></td>
               </tr>
               <? } ?>
               <tr class="c4">
                  <td></td>
                  <td></td>
               </tr>
               <? if ($item_details['auction_type']=='dutch') { ?>
               <tr class="c1">
                  <td align="right"><strong>
                     <?=MSG_AVAILABLE_QUANTITY;?>
                     </strong></td>
                  <td valign="top"><?=$item_details['quantity'];?></td>
               </tr>
               <? } ?>
               <tr class="c1">
                  <td align="right"><strong>
                     <?=MSG_CURRENT_BID;?>
                     </strong></td>
                  <td><? echo $fees->display_amount($item_details['max_bid'], $item_details['currency']);?></td>
               </tr>
               <tr class="c1">
                  <td align="right"><strong>
                     <?=MSG_NR_BIDS;?>
                     </strong></td>
                  <td><?=$item_details['nb_bids'];?></td>
               </tr>
               <tr class="c4">
                  <td></td>
                  <td></td>
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
               <? } ?>
               <?=$shipping_locations_warning;?>
               <tr class="c4">
                  <td></td>
                  <td></td>
               </tr>
				   <? if ($item_details['direct_payment']) { ?>
				   <tr class="c1">
                  <td width="150" align="right"><b><?=MSG_DIRECT_PAYMENT;?></b></td>
				      <td><?=$direct_payment_methods_display;?></td>
				   </tr>
               <tr class="c4">
                  <td></td>
                  <td></td>
               </tr>
				   <? } ?>
				   <? if ($item_details['payment_methods']) { ?>
				   <tr class="c1">
                  <td width="150" align="right"><b><?=MSG_OFFLINE_PAYMENT;?></b></td>
				      <td><?=$offline_payment_methods_display;?></td>
				   </tr>
               <tr class="c4">
                  <td></td>
                  <td></td>
               </tr>
				   <? } ?>
               <? if ($item_details['apply_tax'] && $auction_tax['apply']) { ?>
               <tr class="c1">
                  <td align="right" valign="top"><b>
                     <?=$auction_tax['tax_name']?></b></td>
                  <td><?=$auction_tax['display_buyer_purchase'];?></td>
               </tr>
               <tr class="c4">
                  <td></td>
                  <td></td>
               </tr>
               <? } ?>
					<tr>
						<td width="150"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
						<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
					</tr>
            </table>
            <table width="100%" border="0" cellpadding="4" cellspacing="2" class="errormessage">
               <tr>
                  <td width="150" align="center"><input name="form_buyout_proceed" type="submit" id="form_buyout_proceed" value="<?=GMSG_PROCEED;?>">
                  </td>
                  <td><?=MSG_BUYOUT_PROCEED_EXPL?></td>
               </tr>
            </table>
   		</td>
   	</tr>
   </form>
</table>
