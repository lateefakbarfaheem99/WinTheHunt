<?
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<script language="javascript">
	/*
	var dont_show_warning = false;
	
	function dontShowWarning() {
		dont_show_warning = true
	}
	
	//submit.onclick = dontShowWarning;
	
	function closeEditorWarning() {
		// Bail if one of the submits was clicked
		if (dont_show_warning)
		return;
	
		return 'It looks like you have been editing something -- if you leave before submitting your changes will be lost.';
	}
	
	window.onbeforeunload = closeEditorWarning;
	*/
	
	function submit_form(form_name, file_type) {
		form_name.box_submit.value = "1";
		form_name.file_upload_type.value = file_type;
		//dontShowWarning();
		form_name.submit();
	}
</script>

<?=$sell_item_header;?>
<?=$sell_item_header_menu;?>
<br>
<?=$check_voucher_message;?>
<?=$display_formcheck_errors;?>

<? if ($current_step!='finish') { ?>
<form action="sell_item.php" method="post" enctype="multipart/form-data" name="ad_create_form">
   <input type="hidden" name="current_step" value="<?=$current_step;?>" >
   <input type="hidden" name="item_id" value="<?=$item_details['item_id'];?>" >
   <input type="hidden" name="box_submit" value="0" >
   <input type="hidden" name="file_upload_type" value="" >
   <input type="hidden" name="file_upload_id" value="" >
   <input type="hidden" name="ad_type" value="<?=$item_details['ad_type'];?>" >
   <input type="hidden" name="list_in" id="list_in" value="<?=$item_details['list_in'];?>" >
   <input type="hidden" name="category_id" id="category_id" value="<?=$item_details['category_id'];?>">
   <input type="hidden" name="addl_category_id" id="addl_category_id" value="<?=$item_details['addl_category_id'];?>">
   <input type="hidden" name="listing_type" value="<?=$item_details['listing_type'];?>" >
   <input type="hidden" name="auction_type" value="<?=$item_details['auction_type'];?>" >
   <input type="hidden" name="voucher_value" value="<?=$item_details['voucher_value'];?>" >
   <input type="hidden" name="quantity" value="<?=$item_details['quantity'];?>" >
   <input type="hidden" name="name" value="<?=$item_details['name'];?>" >
   <input type="hidden" name="description" value="<?=$item_details['description'];?>" >
   <input type="hidden" name="start_time" value="<?=$item_details['start_time'];?>" >
   <input type="hidden" name="end_time" value="<?=$item_details['end_time'];?>" >
   <input type="hidden" name="currency" value="<?=$item_details['currency'];?>" >   
   <input type="hidden" name="start_price" value="<? echo ($item_details['listing_type'] == 'buy_out') ? $item_details['buyout_price'] : $item_details['start_price'];?>" >
   <input type="hidden" name="buyout_price" value="<?=$item_details['buyout_price'];?>" >
   <input type="hidden" name="reserve_price" value="<?=$item_details['reserve_price'];?>" >
   <input type="hidden" name="bid_increment_amount" value="<?=$item_details['bid_increment_amount'];?>" >
   <input type="hidden" name="offer_min" value="<?=$item_details['offer_min'];?>" >
   <input type="hidden" name="offer_max" value="<?=$item_details['offer_max'];?>" >
   
   <input type="hidden" name="fb_decrement_amount" value="<?=$item_details['fb_decrement_amount'];?>" >
   <input type="hidden" name="fb_decrement_interval" value="<?=$item_details['fb_decrement_interval'];?>" >
   
	<? if ($current_step != 'settings') { ?>
   <input type="hidden" name="apply_tax" value="<?=$item_details['apply_tax'];?>" >
   <input type="hidden" name="is_bid_increment" value="<?=$item_details['is_bid_increment'];?>" >
   <input type="hidden" name="is_reserve" value="<?=$item_details['is_reserve'];?>" >
   <input type="hidden" name="is_buy_out" value="<? echo ($item_details['listing_type'] == 'buy_out') ? 1 : $item_details['is_buy_out'];?>" >
   <input type="hidden" name="is_offer" value="<?=$item_details['is_offer'];?>" >
   <input type="hidden" name="hpfeat" value="<?=$item_details['hpfeat'];?>" >
   <input type="hidden" name="catfeat" value="<?=$item_details['catfeat'];?>" >
   <input type="hidden" name="bold" value="<?=$item_details['bold'];?>" >
   <input type="hidden" name="hl" value="<?=$item_details['hl'];?>" >
   <input type="hidden" name="hidden_bidding" value="<?=$item_details['hidden_bidding'];?>" >
   <input type="hidden" name="enable_swap" value="<?=$item_details['enable_swap'];?>" >
   <input type="hidden" name="is_auto_relist" value="<?=$item_details['is_auto_relist'];?>" >
   <input type="hidden" name="auto_relist_bids" value="<?=$item_details['auto_relist_bids'];?>" >
   <input type="hidden" name="disable_sniping" value="<?=$item_details['disable_sniping'];?>" >
   <?=$hidden_custom_fields;?>
   <? } ?>
   <input type="hidden" name="country" value="<?=$item_details['country'];?>" >
   <input type="hidden" name="state" value="<?=$item_details['state'];?>" >
   <input type="hidden" name="zip_code" value="<?=$item_details['zip_code'];?>" >

   <?=$media_upload_fields;?>

   <? if ($current_step != 'shipping') { ?>
   <input type="hidden" name="shipping_int" value="<?=$item_details['shipping_int'];?>" >
   <input type="hidden" name="direct_payment" value="<?=$item_details['direct_payment'];?>" >
   <input type="hidden" name="payment_methods" value="<?=$item_details['payment_methods'];?>" >
   <? } ?>
   <input type="hidden" name="shipping_method" value="<?=$item_details['shipping_method'];?>" >
   <input type="hidden" name="postage_amount" value="<?=$item_details['postage_amount'];?>" >
   <input type="hidden" name="insurance_amount" value="<?=$item_details['insurance_amount'];?>" >
   <input type="hidden" name="shipping_details" value="<?=$item_details['shipping_details'];?>" >
   <input type="hidden" name="type_service" value="<?=$item_details['type_service'];?>" >
   <input type="hidden" name="item_weight" value="<?=$item_details['item_weight'];?>" >

   <input type="hidden" name="start_time_type" value="<?=$item_details['start_time_type'];?>" >
   <input type="hidden" name="end_time_type" value="<?=$item_details['end_time_type'];?>" >
   <input type="hidden" name="duration" value="<?=$item_details['duration'];?>" >
   <input type="hidden" name="poster_email" value="<?=$item_details['poster_email'];?>" >
   <input type="hidden" name="poster_name" value="<?=$item_details['poster_name'];?>" >
   <input type="hidden" name="poster_address" value="<?=$item_details['poster_address'];?>" >
   <input type="hidden" name="poster_phone" value="<?=$item_details['poster_phone'];?>" >
   <input type="hidden" name="auto_relist_nb" value="<?=$item_details['auto_relist_nb'];?>" >
<? } ?>
	<?=$sell_item_page_content;?>
<? if ($current_step!='finish') { ?>
</form>
<? } ?>