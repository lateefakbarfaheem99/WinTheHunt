<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('EDIT_AUCTION') ) { die("Access Denied"); }

(string) $edit_auction_content = null;

## BEGIN pages upload
## 1.- details section
$template->set('setup_voucher_box', voucher_form('setup', $item_details['voucher_value'], false));

$template->set('main_category_display', category_navigator($item_details['category_id'], false));
$template->set('addl_category_display', category_navigator($item_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT));

if (IN_ADMIN != 1)
{ 
   $second_cat_fee = $setup_fee->display_fee('second_cat_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
   $template->set('second_cat_fee_expl_message', $second_cat_fee['display_short']);
}

if (!empty($item_details['voucher_value']))
{
	$voucher_details = $item->check_voucher($item_details['voucher_value'], 'setup');

	$template->set('check_voucher_message', $voucher_details['display']);
}

$edit_auction_content .= $template->process('sell_item_details.tpl.php');

## 2.- settings section
$selected_currency = ($item_details['currency']) ? $item_details['currency'] : $setts['currency'];
$template->set('currency_drop_down', $item->currency_drop_down('currency', $selected_currency, 'ad_create_form'));

$tax = new tax();

$can_add_tax = $tax->can_add_tax($item_details['owner_id'], $setts['enable_tax']);
$template->set('can_add_tax', $can_add_tax['can_add_tax']);

$template->set('duration_drop_down', $item->durations_drop_down('duration', $item_details['duration'], null, $session->value('user_id'), $item_details['category_id']));

if (IN_ADMIN != 1)
{   
   $buyout_fee = $setup_fee->display_fee('buyout_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('buyout_fee_expl_message', $buyout_fee['display_short']);

	$makeoffer_fee = $setup_fee->display_fee('makeoffer_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('makeoffer_fee_expl_message', $makeoffer_fee['display_short']);

	$rp_fee = $setup_fee->display_fee('rp_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('rp_fee_expl_message', $rp_fee['display_short']);

	$hpfeat_fee = $setup_fee->display_fee('hpfeat_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('hpfeat_fee_expl_message', $hpfeat_fee['display_short']);

	$catfeat_fee = $setup_fee->display_fee('catfeat_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('catfeat_fee_expl_message', $catfeat_fee['display_short']);

	$hl_fee = $setup_fee->display_fee('hlitem_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('hl_fee_expl_message', $hl_fee['display_short']);

	$bold_fee = $setup_fee->display_fee('bolditem_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('bold_fee_expl_message', $bold_fee['display_short']);

	$item_swap_fee = $setup_fee->display_fee('swap_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('item_swap_fee_expl_message', $item_swap_fee['display_short'] . (($item_swap_fee['amount'] > 0) ? ' ' . MSG_SWAP_FEE_APPLIED_EXPL : ''));
	
	$custom_start_fee = $setup_fee->display_fee('custom_start_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$template->set('custom_start_fee_expl_message', $custom_start_fee['display_short']);

	$picture_fee = $setup_fee->display_fee('picture_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$picture_fee_expl_message = $picture_fee['display_short'];
	$template->set('picture_fee_expl_message', $picture_fee_expl_message);

	$video_fee = $setup_fee->display_fee('video_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$video_fee_expl_message = $video_fee['display_short'];
	$template->set('video_fee_expl_message', $video_fee_expl_message);
	
	$dd_fee = $setup_fee->display_fee('dd_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);
	$dd_fee_expl_message = $dd_fee['display_short'];
	$template->set('dd_fee_expl_message', $dd_fee['display_short']);
}

$start_date_box = date_form_field($item_details['start_time'], $start_time_id, 'ad_create_form');
$template->set('start_date_box', $start_date_box);

$end_date_box = date_form_field($item_details['end_time'], $end_time_id, 'ad_create_form');
$template->set('end_date_box', $end_date_box);

$custom_fld->new_table = false;
$custom_fld->field_colspan = 2;
$custom_sections_table = $custom_fld->display_sections($item_details, $page_handle, false, 0, $item_details['category_id']);

$template->set('custom_sections_table', $custom_sections_table);

/* start digital media code */
$dd_upload_manager = $item->upload_manager($item_details, 3, 'ad_create_form', true, false, true, $dd_fee_expl_message);
$template->set('dd_upload_manager', $dd_upload_manager);
/* end digital media code */

$item->show_free_images = true;

$image_upload_manager = $item->upload_manager($item_details, 1, 'ad_create_form', true, false, true, $picture_fee_expl_message);
$template->set('image_upload_manager', $image_upload_manager);

$video_upload_manager = $item->upload_manager($item_details, 2, 'ad_create_form', true, false, true, $video_fee_expl_message);
$template->set('video_upload_manager', $video_upload_manager);

$template->set('country_dropdown', $tax->countries_dropdown('country', $item_details['country'], 'ad_create_form', 'setup'));
$template->set('state_box', $tax->states_box('state', $item_details['state'], $item_details['country']));

$edit_auction_content .= $template->process('sell_item_settings.tpl.php');

## 3.- shipping section
$template->set('shipping_methods_drop_down', $item->shipping_methods_drop_down('type_service', $item_details['type_service']));

$direct_payments = $item->select_direct_payment($item_details['direct_payment'], $item_details['owner_id']);

$direct_payment_table = $template->generate_table($direct_payments, 4, 1, 1, '75%');
$template->set('direct_payment_table', $direct_payment_table);

$offline_payments = $item->select_offline_payment($item_details['payment_methods']);

$offline_payment_table = $template->generate_table($offline_payments, 4, 1, 1, '75%');
$template->set('offline_payment_table', $offline_payment_table);

$edit_auction_content .= $template->process('sell_item_shipping.tpl.php');

$template->set('edit_auction_content', $edit_auction_content);
## END pages upload
?>
