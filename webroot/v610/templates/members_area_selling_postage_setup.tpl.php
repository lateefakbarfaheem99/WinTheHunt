<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2008 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<SCRIPT LANGUAGE="JavaScript">
function submit_form(form_name) {
	form_name.submit();
}

function openPopup(url) {
	myPopup = window.open(url,'popupWindow','width=750,height=480,scrollbars=yes,status=yes ');
	if (!myPopup.opener)
       	myPopup.opener = self;
}
</script>
<script language="javascript" src="includes/main_functions.js" type="text/javascript"></script>

<br>
<form name="form_selling_postage_setup" action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="box_submit" value="1">
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	   <tr>
	      <td colspan="3" class="c7"><b><?=MSG_MM_POSTAGE_CALC_SETUP;?></b></td>
	   </tr>	
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
	      <td colspan="2" width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
	   </tr>
	   <? if ($display_formcheck_errors) { ?>
	   <tr>
	      <td colspan="2"><?=$display_formcheck_errors;?></td>
	   </tr>	
	   <? } ?>
	   <tr class="c1">
         <td align="right"><?=MSG_SELLING_FREE_POSTAGE;?></td>
         <td><input type="checkbox" name="pc_free_postage" value="1" <? echo ($postage_details['pc_free_postage']) ? 'checked' : '';?>></td>
         <td width="100%"></td>
      </tr>		
	   <tr>
         <td align="right"></td>
         <td class="c1" colspan="2"><?=MSG_IF_INVOICE_AMOUNT_OVER;?> <?=$setts['currency'];?> <input type="text" name="pc_free_postage_amount" value="<?=$postage_details['pc_free_postage_amount'];?>" size="8"></td>
      </tr>		
	   <tr class="reguser">
         <td></td>
         <td colspan="2"><?=MSG_SELLING_FREE_POSTAGE_EXPL;?></td>
      </tr>		
      <tr class="c4">
         <td colspan="3"></td>
      </tr>
	   <tr class="c1">
         <td align="right"><?=MSG_SELLING_POSTAGE_TYPE;?></td>
         <td><input type="radio" name="pc_postage_type" value="item" checked onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%"><?=MSG_POSTAGE_TYPE_NORMAL;?></td>
      </tr>		
	   <tr class="reguser">
         <td></td>
         <td colspan="2"><?=MSG_POSTAGE_TYPE_NORMAL_EXPL;?></td>
      </tr>		
	   <tr>
         <td></td>
         <td class="c1"><input type="radio" name="pc_postage_type" value="weight" <? echo ($postage_details['pc_postage_type'] == 'weight') ? 'checked' : ''; ?> onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%" class="c1"><?=MSG_POSTAGE_TYPE_WEIGHT;?></td>
      </tr>		
      <? if ($postage_details['pc_postage_type'] == 'weight') { ?>
	   <tr>
         <td></td>
         <td class="c1" colspan="2"><?=MSG_WEIGHT_UNIT;?>: 
         	<? if ($postage_details['pc_postage_calc_type'] == 'carriers') { ?>
         	<b><?=MSG_POUNDS;?></b>
         	<? } else { ?>
         	<input type="text" name="pc_weight_unit" value="<?=$postage_details['pc_weight_unit'];?>" size="8">
         	<? } ?>
         </td>
      </tr>		
      <? } ?>
	   <tr class="reguser">
         <td></td>
         <td colspan="2">
         	<?=MSG_POSTAGE_TYPE_WEIGHT_EXPL;?>
         	<? echo ($is_shipping_carriers) ? '<br>' . MSG_POSTAGE_TYPE_SHIPPING_CARRIERS_EXPL : ''; ?>
         	</td>
      </tr>		
	   <tr>
         <td></td>
         <td class="c1"><input type="radio" name="pc_postage_type" value="amount" <? echo ($postage_details['pc_postage_type'] == 'amount') ? 'checked' : ''; ?> onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%" class="c1"><?=MSG_POSTAGE_TYPE_AMOUNT;?></td>
      </tr>		
	   <tr class="reguser">
         <td></td>
         <td colspan="2"><?=MSG_POSTAGE_TYPE_AMOUNT_EXPL;?></td>
      </tr>		
	   <tr>
         <td></td>
         <td class="c1"><input type="radio" name="pc_postage_type" value="flat" <? echo ($postage_details['pc_postage_type'] == 'flat') ? 'checked' : ''; ?> onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%" class="c1"><?=MSG_POSTAGE_TYPE_FLAT;?></td>
      </tr>		
      <? if ($postage_details['pc_postage_type'] == 'flat') { ?>
	   <tr>
         <td></td>
         <td class="c1" colspan="2">
         	<table cellpadding="0" cellspacing="0" border="0">
         		<tr>
         			<td width="250"><?=MSG_POSTAGE_FLAT_FIRST_ITEM;?>:</td>
         			<td>[ <?=MSG_ITEM_CURRENCY;?> ] <input type="text" name="pc_flat_first" value="<?=$postage_details['pc_flat_first'];?>" size="8"></td>
         		</tr>
         	</table></td>
      </tr>		
	   <tr>
         <td></td>
         <td class="c1" colspan="2">
         	<table cellpadding="0" cellspacing="0" border="0">
         		<tr>
         			<td width="250"><?=MSG_POSTAGE_FLAT_ADDL_ITEMS;?>:</td>
         			<td>[ <?=MSG_ITEM_CURRENCY;?> ] <input type="text" name="pc_flat_additional" value="<?=$postage_details['pc_flat_additional'];?>" size="8"></td>
         		</tr>
         	</table></td>
      </tr>		
      <? } ?>
	   <tr class="reguser">
         <td></td>
         <td colspan="2"><?=MSG_POSTAGE_TYPE_FLAT_EXPL;?></td>
      </tr>		
      <? if (!in_array($postage_details['pc_postage_type'], array('item', 'flat'))) { ?>
      <!-- weight based postage additional settings -->
      <tr class="c4">
         <td colspan="3"></td>
      </tr>
	   <tr class="c1">
         <td align="right"><?=MSG_CALCULATION_METHOD;?></td>
         <td><input type="radio" name="pc_postage_calc_type" value="default" checked onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%"><?=MSG_DEFAULT_TIERS_TABLE;?></td>
      </tr>		
	   <tr>
         <td></td>
         <td class="c1"><input type="radio" name="pc_postage_calc_type" value="custom" <? echo ($postage_details['pc_postage_calc_type'] == 'custom') ? 'checked' : ''; ?> onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%" class="c1"><?=MSG_CUSTOM_TIERS_TABLE;?></td>
      </tr>		
      <? if ($postage_details['pc_postage_type'] == 'weight' && $is_shipping_carriers) { ?>
	   <tr>
         <td></td>
         <td class="c1"><input type="radio" name="pc_postage_calc_type" value="carriers" <? echo ($postage_details['pc_postage_calc_type'] == 'carriers') ? 'checked' : ''; ?> onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%" class="c1"><?=MSG_SHIPPING_CARRIERS;?></td>
      </tr>		
      <? } ?>
      <? if ($postage_details['pc_postage_calc_type'] == 'carriers') { ?>
	   <tr>
         <td></td>
         <td colspan="2"><?=MSG_CHOOSE_CARRIERS;?></td>
      </tr>		
      <?=$shipping_carriers_select;?>
      <? } else { ?>
	   <tr>
         <td></td>
         <td class="c4" colspan="2" align="center"><b><?=MSG_ACTIVE_TIERS_TABLE;?></b> [ <?=MSG_ITEM_CURRENCY;?> ]</td>
      </tr>		
	   <tr>
         <td></td>
         <td colspan="2" align="center"><?=$postage_tiers_table;?></td>
      </tr>		
      <? } ?>
	   <tr>
         <td></td>
         <td colspan="2"></td>
      </tr>		
      <? } ?>
      <tr class="c4">
         <td colspan="3"></td>
      </tr>
	   <tr class="c1">
         <td align="right"><?=MSG_SHIPPING_LOCATIONS;?></td>
         <td><input type="radio" name="pc_shipping_locations" value="global" checked onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%"><?=MSG_GLOBAL;?></td>
      </tr>		
	   <tr class="reguser">
         <td></td>
         <td colspan="2"><?=MSG_SHIPPING_GLOBAL_EXPL;?></td>
      </tr>		
	   <tr>
         <td></td>
         <td class="c1"><input type="radio" name="pc_shipping_locations" value="local" <? echo ($postage_details['pc_shipping_locations'] == 'local') ? 'checked' : ''; ?> onclick="submit_form(form_selling_postage_setup);"></td>
         <td width="100%" class="c1"><?=MSG_LOCAL;?></td>
      </tr>		
	   <tr class="reguser">
         <td></td>
         <td colspan="2"><?=MSG_SHIPPING_LOCAL_EXPL;?></td>
      </tr>		
      <? if ($postage_details['pc_shipping_locations'] == 'local') { ?>
      <? if ($option == 'add' || $option == 'edit') { ?>
      <tr>
      	<td></td>
      	<td colspan="2"><?=$shipping_locations_select;?></td>
      </tr>
      <? } ?>
	   <tr>
         <td></td>
         <td class="border" colspan="2">
         	<table width="100%" border="0" cellpadding="3" cellspacing="1">
         		<tr class="c4">
         			<td><?=MSG_LOCATIONS;?></td>
         			<td align="center"><?=MSG_ADDITIONAL_COST;?></td>
         			<!--<td align="center"><?=GMSG_DEFAULT;?></td>-->
         			<td align="center"><?=GMSG_OPTIONS;?></td>
         		</tr>
					<tr class="c5">
				      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
				      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
				      <!--<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>-->
				      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="75" height="1"></td>
				   </tr>
          		<?=$shipping_locations_table;?>
			      <tr class="c4">
			         <td colspan="4"></td>
			      </tr>      
         		<tr>
			         <td colspan="4" class="contentfont">[ <a href="members_area.php?page=selling&section=postage_setup&option=add"><?=MSG_ADD_LOCATION;?></a> ]</td>
         		</tr>
         	</table>
         </td>
      </tr>		      
      <? } ?>
      <tr class="c4">
         <td colspan="3"></td>
      </tr>      
      <tr>
         <td colspan="3"><input type="submit" name="form_postage_save" value="<?=GMSG_PROCEED;?>" /></td>
      </tr>
	</table>
</form>
