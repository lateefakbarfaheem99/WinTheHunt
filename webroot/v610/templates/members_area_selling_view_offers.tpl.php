<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<script language="javascript">
	function decline_popup_open(offer_type, offer_id)
	{
		self.scrollTo(0,0);
		document.getElementById("centered_div").style.display = 'block';
		document.getElementById('offer_type').value = offer_type;
		document.getElementById('offer_id').value = offer_id;
		return false;
	}
	
	function decline_form_cancel()
	{
		document.getElementById("centered_div").style.display = 'none';	
	}
	
	function decline_form_proceed()
	{
		form_name.submit();
		return true;
	}
</script>

<style type="text/css"> 
#centered_div {
	position:absolute;
	top: 50%;
	left: 50%;
	width:450px;
	height:250px;
	margin-top: -125px; 
	margin-left: -225px; 
	border: 2px solid #ccc;
	background-color: #FFFFFF;
	padding: 10px;
	display: none;
}
div > div#centered_div { position: fixed; }
</style> 

<!--[if gte IE 5.5]>
<![if lt IE 7]>
<style type="text/css">
	div#centered_div {
		left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
		top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
	}
</style>
<![endif]>
<![endif]-->

<div id="centered_div">
	<form name="decline_offer" method="GET">
		<input type="hidden" name="page" value="selling" />		
		<input type="hidden" name="section" value="view_offers" />		
		<input type="hidden" name="do" value="delete_offer" />		
		<input type="hidden" name="auction_id" value="<?=$auction_id;?>" />		
		<input type="hidden" name="offer_type" id="offer_type" value="" />		
		<input type="hidden" name="offer_id" id="offer_id" value="" />		
		
		<div><b><?=MSG_ENTER_DECLINE_REASON;?></b>:</div>
			<div align="center"><textarea style="width: 100%; height: 180;" name="decline_reason" id="decline_reason"></textarea>
		</div>
		<p align="center"><input type="submit" name="form_decline_proceed" value="<?=GMSG_PROCEED;?>" onclick="decline_form_proceed();"> 
			<input type="button" name="form_decline_cancel" value="<?=GMSG_CANCEL;?>" onclick="decline_form_cancel();"></p>
	</form>
</div>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="2" class="c7"><?=MSG_VIEW_OFFERS_FOR;?>
         <?=MSG_AUCTION_ID;?>
         : <b>
         <?=$item_details['auction_id'];?>
         </b> - <b>
         <?=$item_details['name'];?>
         </b></td>
   </tr>
   <tr>
      <td colspan="2" class="c4"<img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
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
   <tr class="c1">
      <td width="150" align="right"><?=MSG_POSTAGE;?></td>
      <td><?=$fees->display_amount($item_details['postage_amount'], $item_details['currency']); ?></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><?=MSG_INSURANCE;?></td>
      <td><?=$fees->display_amount($item_details['insurance_amount'], $item_details['currency']); ?></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><?=MSG_SHIP_METHOD;?></td>
      <td><?=$item_details['type_service'];?></td>
   </tr>
   <tr class="c4">
      <td></td>
      <td></td>
   </tr>
   <? if ($item_details['direct_payment']) { ?>
   <tr class="c1">
      <td width="150" align="right"><b>
         <?=MSG_DIRECT_PAYMENT;?>
         </b></td>
      <td><?=$direct_payment_methods_display;?></td>
   </tr>
   <tr class="c4">
      <td></td>
      <td></td>
   </tr>
   <? } ?>
   <? if ($item_details['payment_methods']) { ?>
   <tr class="c1">
      <td width="150" align="right"><b>
         <?=MSG_OFFLINE_PAYMENT;?>
         </b></td>
      <td><?=$offline_payment_methods_display;?></td>
   </tr>
   <tr class="c4">
      <td></td>
      <td></td>
   </tr>
   <? } ?>
   <tr class="c5">
      <td width="150"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <? if ($winning_bids_content) { ?>
   <tr class="c4">
      <td colspan="2"><?=MSG_WINNER_S;?></td>
   </tr>
   <tr>
      <td colspan="2" class="border">
      	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="contentfont">
      		<tr class="membmenu">
      			<td><b><?=MSG_USERNAME;?></b></td>
      			<td width="80" align="center"><b><?=GMSG_QUANTITY;?></b></td>
      			<td width="100" align="center"><b><?=MSG_BID_AMOUNT;?></b></td>
      			<td width="150" align="center"><b><?=MSG_PURCHASE_DATE;?></b></td>
      			<td width="80" align="center"><b><?=MSG_STATUS;?></b></td>
      		</tr>
			   <?=$winning_bids_content;?>
      	</table>
      </td>
   </tr>
   <? } ?>      
   <? if ($make_offer_content) { ?>
   <tr class="c4">
      <td colspan="2"><?=MSG_AUCTION_OFFERS;?></td>
   </tr>
   <tr>
      <td colspan="2" class="border">
      	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="contentfont">
      		<tr class="membmenu">
      			<td><b><?=MSG_USERNAME;?></b></td>
      			<td width="80" align="center"><b><?=GMSG_QUANTITY;?></b></td>
      			<td width="100" align="center"><b><?=GMSG_AMOUNT;?></b></td>
      			<td width="120" align="center"><b><?=MSG_STATUS;?></b></td>
      			<td width="180" align="center"><b><?=GMSG_OPTIONS;?></b></td>
      		</tr>
			   <?=$make_offer_content;?>
      	</table>
      </td>
   </tr>
   <? } ?>
   <? if ($reserve_offer_content) { ?>
   <tr class="c4">
      <td colspan="2"><?=MSG_RESERVE_OFFERS;?></td>
   </tr>
   <tr>
      <td colspan="2" class="border">
      	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="contentfont">
      		<tr class="membmenu">
      			<td><b><?=MSG_USERNAME;?></b></td>
      			<td width="80" align="center"><b><?=GMSG_QUANTITY;?></b></td>
      			<td width="100" align="center"><b><?=MSG_BID_AMOUNT;?></b></td>
      			<td width="120" align="center"><b><?=MSG_STATUS;?></b></td>
      			<td width="180" align="center"><b><?=GMSG_OPTIONS;?></b></td>
      		</tr>
			   <?=$reserve_offer_content;?>
      	</table>
      </td>
   </tr>
   <? } ?>
   <? if ($second_chance_content) { ?>
   <tr class="c4">
      <td colspan="2"><?=MSG_SECOND_CHANCE_PURCHASING;?></td>
   </tr>
   <tr>
      <td colspan="2" class="border">
      	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="contentfont">
      		<tr class="membmenu">
      			<td><b><?=MSG_USERNAME;?></b></td>
      			<td width="80" align="center"><b><?=GMSG_QUANTITY;?></b></td>
      			<td width="100" align="center"><b><?=MSG_BID_AMOUNT;?></b></td>
      			<td width="180" align="center"><b><?=GMSG_OPTIONS;?></b></td>
      		</tr>
			   <?=$second_chance_content;?>
      	</table>
      </td>
   </tr>
   <? } ?>
   <? if ($swap_offer_content) { ?>
   <tr class="c4">
      <td colspan="2"><?=MSG_SWAP_OFFERS;?></td>
   </tr>
   <tr>
      <td colspan="2" class="border">
      	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="contentfont">
      		<tr class="membmenu">
      			<td width="150"><b><?=MSG_USERNAME;?></b></td>
      			<td width="80" align="center"><b><?=GMSG_QUANTITY;?></b></td>
      			<td align="center"><b><?=GMSG_DESCRIPTION;?></b></td>
      			<td width="120" align="center"><b><?=MSG_STATUS;?></b></td>
      			<td width="180" align="center"><b><?=GMSG_OPTIONS;?></b></td>
      		</tr>
			   <?=$swap_offer_content;?>
      	</table>
      </td>
   </tr>
   <? } ?>
</table>
