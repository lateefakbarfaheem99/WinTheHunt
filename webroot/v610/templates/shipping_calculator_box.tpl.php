<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<form method="GET" action="javascript:shipping_calculator(1);" name="shipping_calculator_form" id="shipping_calculator_form">
  	<input type="hidden" name="sc_item_id" id="sc_item_id" value="<?=$auction_id;?>">
   <table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">
      <tr>
         <td class="c3" colspan="2"><?=MSG_SHIPPING_CALCULATOR;?></td>
      </tr>
	   <tr class="c5">
		   <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
		   <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	   </tr>
	   <tr class="c1">
		   <td><?=MSG_COUNTRY;?></td>
		   <td><?=$country_dropdown;?></td>
	   </tr>
	   <? if (!empty($state_dropdown)) { ?>
	   <tr class="c1">
		   <td><?=MSG_STATE;?></td>
		   <td><?=$state_dropdown;?></td>
	   </tr>
	   <? } ?>
	   <? if ($item_details['auction_type'] == 'dutch') { ?>
	   <tr class="c1">
		   <td><?=MSG_QUANTITY;?></td>
		   <td><input type="text" name="sc_quantity" id="sc_quantity" value="<?=$sc_quantity;?>" size="8"></td>
	   </tr>
	   <? } else { ?>
	   <input type="hidden" name="sc_quantity" id="sc_quantity" value="1" />
	   <? } ?>
	   <? if ($request_zip_code) { ?>
	   <tr class="c1">
		   <td><?=MSG_ZIP_CODE;?></td>
		   <td><input type="text" name="sc_zip_code" value="<?=$sc_zip_code;?>" size="20" id="sc_zip_code" onchange="javascript:shipping_calculator();"></td>
	   </tr>
	   <? if (!empty($carriers_dropdown)) { ?>
	   <tr class="c1">
		   <td><?=MSG_SHIPPING_METHOD;?></td>
		   <td><?=$carriers_dropdown;?></td>
	   </tr>
	   <? } ?>
	   <? } ?>
	   <? if ($sc_postage_value >= 0)	{ ?>
	   <tr class="c4">
		   <td colspan="2"></td>
	   </tr>
	   <tr class="c2">
		   <td><?=MSG_POSTAGE;?></td>
		   <td><?=$fees->display_amount($sc_postage_value, $item_details['currency'], true);?></td>
	   </tr>	
	   <? } ?>
	   <tr class="c4">
		   <td colspan="2"></td>
	   </tr>
	   <tr>
		   <td></td>
		   <td><input type="submit" name="form_calculate_postage" value="<?=MSG_CALCULATE_POSTAGE;?>" <?=$sc_disabled;?>></td>
	   </tr>	
   </table>
</form>	
