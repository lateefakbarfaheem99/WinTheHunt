<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<br>
<form action="" method="post" name="prefilled_fields_form">
   <input type="hidden" name="operation" value="submit">
   <input type="hidden" name="do" value="<?=$do;?>">
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="6" class="c7"><b><?=MSG_MM_PREFILLED_FIELDS;?></b></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ITEM_TITLE;?></td>
         <td colspan="2"><input name="default_name" type="text" id="default_name" value="<?=$prefilled_fields['default_name'];?>" size="60" maxlength="255" /></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ITEM_DESCRIPTION;?></td>
         <td colspan="2"><textarea id="description_main" name="description_main" style="width: 400px; height: 200px; overflow: hidden;"><?=$prefilled_fields['default_description'];?></textarea>
            <?=$item_description_editor;?>
         </td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_CURRENCY;?></td>
         <td colspan="2"><?=$currency_drop_down;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=GMSG_DURATION;?></td>
         <td colspan="2"><?=$duration_drop_down;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_PRIVATE_AUCTION;?></td>
         <td colspan="2"><input type="checkbox" name="default_hidden_bidding" value="1" <? echo ($prefilled_fields['default_hidden_bidding']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <? if ($setts['enable_swaps']) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ACCEPT_SWAP;?></td>
         <td colspan="2"><input type="checkbox" name="default_enable_swap" value="1" <? echo ($prefilled_fields['default_enable_swap']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <? } ?>
      
		<? if ($setts['enable_auto_relist']) { ?>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_ENABLE_AUTO_RELIST;?> </td>
	      <td colspan="2"><input type="checkbox" name="default_auto_relist" value="1" <? echo ($prefilled_fields['default_auto_relist']==1) ? 'checked' : ''; ?>/></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_AUTO_RELIST_SOLD;?> </td>
	      <td colspan="2"><input type="checkbox" name="default_auto_relist_bids" value="1" <? echo ($prefilled_fields['default_auto_relist_bids']==1) ? 'checked' : ''; ?>/></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_NB_AUTO_RELISTS;?> </td>
	      <td colspan="2"><input type="text" name="default_auto_relist_nb" value="<?=$prefilled_fields['default_auto_relist_nb'];?>" size="8" maxlength="2" /></td>
	   </tr>
	   <? } ?>
      
      <tr class="c1">
         <td width="150" align="right"><?=MSG_SHIPPING_CONDITIONS;?></td>
         <td nowrap><input type="radio" name="default_shipping_method" value="1" <? echo ($prefilled_fields['default_shipping_method']==1) ? 'checked' : ''; ?>  /></td>
         <td width="100%"><?=MSG_BUYER_PAYS_SHIPPING;?></td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td class="c2" nowrap><input type="radio" name="default_shipping_method" value="2" <? echo ($prefilled_fields['default_shipping_method']==2) ? 'checked' : ''; ?> /></td>
         <td class="c2"><?=MSG_SELLER_PAYS_SHIPPING;?></td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td class="c1" nowrap><input type="checkbox" name="default_shipping_int" value="1" <? echo ($prefilled_fields['default_shipping_int']==1) ? 'checked' : ''; ?> /></td>
         <td class="c1"><?=MSG_SELLER_SHIPS_INT;?></td>
      </tr>
      <? if ($setts['enable_shipping_costs']) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_POSTAGE;?></td>
         <td nowrap colspan="2"><input type="text" name="default_postage_amount" value="<?=$prefilled_fields['default_postage_amount'];?>" size="8"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_INSURANCE;?></td>
         <td nowrap colspan="2"><input type="text" name="default_insurance_amount" value="<?=$prefilled_fields['default_insurance_amount'];?>" size="8"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_SHIPPING_DETAILS;?></td>
         <td nowrap colspan="2"><textarea name="default_shipping_details" style="width: 350px; height: 100px;"><?=$prefilled_fields['default_shipping_details'];?></textarea></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_SHIP_METHOD;?></td>
         <td nowrap colspan="2"><?=$shipping_methods_drop_down;?></td>
      </tr>
      <? } ?>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_DIRECT_PAYMENT_METHODS;?></td>
	      <td nowrap colspan="2"><?=$direct_payment_table;?></td>
	   </tr>
	   <tr class="c1">
	      <td width="150" align="right"><?=MSG_OFFLINE_PAYMENT;?></td>
	      <td nowrap colspan="2"><?=$offline_payment_table;?></td>
	   </tr>
      <tr>
         <td colspan="6" class="c4"><?=MSG_GLOBAL_SETTINGS;?>
         </td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ACCEPT_PUBLIC_Q;?></td>
         <td colspan="2"><input type="checkbox" name="default_public_questions" value="1" <? echo ($prefilled_fields['default_public_questions']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <? if (!$setts['enable_store_only_mode']) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_NEW_BID_EMAIL_NOTIF;?></td>
         <td colspan="2"><input type="checkbox" name="default_bid_placed_email" value="1" <? echo ($prefilled_fields['default_bid_placed_email']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <? } ?>
      <? if ($setts['enable_private_reputation']) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_PRIVATE_REPUTATION;?></td>
         <td colspan="2"><input type="checkbox" name="enable_private_reputation" value="1" <? echo ($prefilled_fields['enable_private_reputation']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_PRIVATE_REPUTATION_EXPL;?></td>
      </tr>
      <? } ?>
      <? if ($setts['enable_force_payment'] && $layout['enable_buyout'] && $setts['buyout_process'] == 1) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_BUYOUT_FORCE_PAYMENT;?></td>
         <td colspan="2"><input type="checkbox" name="enable_force_payment" value="1" <? echo ($prefilled_fields['enable_force_payment']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_BUYOUT_FORCE_PAYMENT_EXPL;?></td>
      </tr>
      <? } ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ENABLE_ITEM_COUNTER;?></td>
         <td colspan="2"><input type="checkbox" name="enable_item_counter" value="1" <? echo ($prefilled_fields['enable_item_counter']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_ENABLE_ITEM_COUNTER_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_SHOW_WATCHED_LIST;?></td>
         <td colspan="2"><input type="checkbox" name="show_watch_list" value="1" <? echo ($prefilled_fields['show_watch_list']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_SHOW_WATCHED_LIST_EXPL;?></td>
      </tr>
      <? if ($setts['limit_nb_bids']) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_LIMIT_BIDS;?></td>
         <td colspan="2"><input name="limit_bids" type="text" id="limit_bids" value="<?=$prefilled_fields['limit_bids'];?>" size="6" maxlength="3" /></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_LIMIT_BIDS_EXPL;?></td>
      </tr>
      <? } ?>
      <? if ($layout['enable_buyout'] && $setts['makeoffer_process']) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_SHOW_MAKEOFFER_RANGES;?></td>
         <td colspan="2"><input type="checkbox" name="show_makeoffer_ranges" value="1" <? echo ($prefilled_fields['show_makeoffer_ranges']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_SHOW_MAKEOFFER_RANGES_EXPL;?></td>
      </tr>
      <? if ($setts['limit_nb_bids']) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_LIMIT_OFFERS;?></td>
         <td colspan="2"><input name="limit_offers" type="text" id="limit_offers" value="<?=$prefilled_fields['limit_offers'];?>" size="6" maxlength="3" /></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_LIMIT_OFFERS_EXPL;?></td>
      </tr>
      <? } ?>
      <? } ?>
      <? if ($seller_country_iso == 'US') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_OVERRIDE_TAX_RATE;?></td>
         <td colspan="2"><input name="seller_tax_amount" type="text" id="seller_tax_amount" value="<?=$prefilled_fields['seller_tax_amount'];?>" size="6" /> %</td>
      </tr>
      <tr>
      	<td></td>
      	<td colspan="2" class="c2"><?=MSG_DEFAULT_TAX_FOR_YOUR_LOCATION;?>: <b><?=$current_seller_tax['display_short'];?></b></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_OVERRIDE_TAX_RATE_EXPL;?></td>
      </tr>      
      <? } ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_VACATION_MODE;?></td>
         <td colspan="2"><input type="checkbox" name="is_vacation" value="1" <? echo ($prefilled_fields['is_vacation']==1) ? 'checked' : ''; ?>/></td>
      </tr>
      <tr>
         <td width="150" align="right"></td>
         <td colspan="2"><?=MSG_VACATION_MODE_EXPL;?></td>
      </tr>
      
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
         <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="2"><input name="form_save_settings" type="submit" id="form_save_settings" value="<?=GMSG_PROCEED;?>" /></td>
      </tr>
   </table>
</form>
