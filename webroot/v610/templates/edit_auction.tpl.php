<?
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<SCRIPT LANGUAGE="JavaScript" SRC="<? echo (IN_ADMIN == 1) ? '../' : ''; ?>includes/calendar.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">document.write(getCalendarStyles());</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
function submit_form(form_name, file_type) {
	form_name.box_submit.value = "1";
	form_name.file_upload_type.value = file_type;
//	form_name.onsubmit();
	form_name.submit();
}

myPopup = '';

function openPopup(url) {
	myPopup = window.open(url,'popupWindow','width=750,height=480,scrollbars=yes,status=yes ');
	if (!myPopup.opener)
       	myPopup.opener = self;
}
</SCRIPT>
<?=$sell_item_header;?>
<br>
<?=$check_voucher_message;?>
<?=$display_formcheck_errors;?>

<form action="<?=$post_url;?>" method="post" enctype="multipart/form-data" name="ad_create_form">
   <input type="hidden" name="edit_type" value="<?=$edit_type;?>" >
   <input type="hidden" name="do" value="<?=$do;?>" >
   <input type="hidden" name="box_submit" value="0" >
   <input type="hidden" name="file_upload_type" value="" >
   <input type="hidden" name="file_upload_id" value="" >
   <input type="hidden" name="auction_id" value="<?=$item_details['auction_id'];?>" >
   <input type="hidden" name="owner_id" value="<?=$item_details['owner_id'];?>" >
	<input type="hidden" name="category_id" id="category_id" value="<?=$item_details['category_id'];?>">
	<input type="hidden" name="addl_category_id" id="addl_category_id" value="<?=$item_details['addl_category_id'];?>">
	<input type="hidden" name="old_category_id" value="<?=$old_category_id;?>">
	<input type="hidden" name="old_addl_category_id" value="<?=$old_addl_category_id;?>">
	<input type="hidden" name="draft" value="<?=$item_details['draft'];?>">
	<input type="hidden" name="list_in" id="list_in" value="<?=$item_details['list_in'];?>" />
	<? if ($item_details['listing_type'] == 'buy_out') { ?>
	<input type="hidden" name="start_price" value="<?=$item_details['start_price'];?>">
	<? } ?>
	<!--
	<input type="hidden" name="direct_payments" value="<?=$item_details['direct_payments'];?>">
	<input type="hidden" name="payment_methods" value="<?=$item_details['payment_methods'];?>">
	-->
	<?=$media_upload_fields;?>
   <? if (IN_ADMIN == 1) { ?>
   <input type="hidden" name="status" value="<?=$form_details['status'];?>">
   <input type="hidden" name="start" value="<?=$form_details['start'];?>">
	<input type="hidden" name="order_field" value="<?=$form_details['order_field'];?>">
	<input type="hidden" name="order_type" value="<?=$form_details['order_type'];?>">
	<input type="hidden" name="src_auction_id" value="<?=$form_details['src_auction_id']?>">
	<input type="hidden" name="keywords" value="<?=$form_details['keywords'];?>">
   <? } ?>
	<?
	if ($user_details['shop_active']) { ?>
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	   <tr class="c4">
	      <td colspan="3"><?=MSG_LIST_IN;?></td>
	   </tr>
	   <tr class="c5">
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
	      <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	   </tr>
	   <? if (!$setts['enable_store_only_mode']) { ?>
	   <tr class="c1">
	      <td width="150" align="right"></td>
	      <td><input type="radio" name="list_in" value="auction" <? echo ($item_details['list_in'] == 'auction') ? 'checked' : ''; ?> <? echo ($item_details['list_in'] == 'store') ? 'disabled' : ''; ?>></td>
			<td width="100%"><?=GMSG_SITE;?></td>
		</tr>
		<? } ?>
	   <tr>
	      <td width="150" align="right"></td>
	      <td class="c1"><input type="radio" name="list_in" value="store" <? echo ($item_details['list_in'] == 'store') ? 'checked' : (($shop_status['remaining_items'] <=0 && $item_details['list_in'] == 'auction') ? 'disabled' : ''); ?>></td>
			<td class="c1" width="100%"><?=GMSG_SHOP;?></td>
		</tr>
	   <? if ($setts['store_listing_type'] == 0) { ?>
	   <tr>
	      <td width="150" align="right"></td>
	      <td class="c1"><input type="radio" name="list_in" value="both" <? echo ($item_details['list_in'] == 'both') ? 'checked' : (($shop_status['remaining_items'] <=0 && $item_details['list_in'] == 'auction') ? 'disabled' : ''); ?> <? echo ($item_details['list_in'] == 'store') ? 'disabled' : ''; ?>></td>
			<td class="c1" width="100%"><?=GMSG_BOTH;?></td>
		</tr>
		<? } ?>
	</table>
	<br>
	<? } ?>
	<?=$edit_auction_content;?>
   <br />
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td width="150" class="contentfont"><input name="form_edit_proceed" type="submit" id="form_edit_proceed" value="<?=GMSG_PROCEED;?>" />
         </td>
         <td class="contentfont">&nbsp;</td>
      </tr>
   </table>
</form>