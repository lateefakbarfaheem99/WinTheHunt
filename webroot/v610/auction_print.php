<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_user.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_item.php');
include_once ('includes/functions_item.php');
include_once ('includes/class_messaging.php');
include_once ('includes/class_reputation.php');

include ('themes/'.$setts['default_theme'].'/title.php');

$auction_print_header = $template->process('empty_header.tpl.php');
$auction_print_header .= $template->process('global_header.tpl.php');
$template->set('auction_print_header', $auction_print_header);

$auction_print_footer = $template->process('empty_footer.tpl.php');
$template->set('auction_print_footer', $auction_print_footer);

(array) $user_details = null;

$start_time_id = 1;
$end_time_id = 2;

$item = new item();
$item->setts = &$setts;
$item->layout = &$layout;

$reputation = new reputation();
$reputation->setts = &$setts;

$page_handle = 'auction';

$addl_query = ($session->value('adminarea')!="Active") ? " AND active=1 AND approved=1" : '';

$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE
	auction_id='" . $_REQUEST['auction_id'] . "'" . $addl_query);

if ($item->count_contents($item_details))
{## PHP Pro Bid v6.00 add click
	$sql_add_click = $db->query("UPDATE " . DB_PREFIX . "auctions SET nb_clicks=nb_clicks+1 WHERE auction_id=" . $item_details['auction_id']);

	$user_details = $db->get_sql_row("SELECT user_id, username, shop_account_id, shop_categories,
		shop_active, preferred_seller, reg_date, country, state, zip_code, balance,
		default_name, default_description, default_duration, default_hidden_bidding,
		default_enable_swap, default_shipping_method, default_shipping_int, default_postage_amount,
		default_insurance_amount, default_type_service, default_shipping_details, default_payment_methods,
		default_public_questions FROM
		" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);

	$custom_fld = new custom_field();

	$item_details['quantity'] = $item->set_quantity($item_details['quantity']);

	$custom_fld->save_edit_vars($item_details['owner_id'], $page_handle);

	$media_details = $item->get_media_values(intval($_REQUEST['auction_id']));
	$item_details['ad_image'] = $media_details['ad_image'];
	$item_details['ad_video'] = $media_details['ad_video'];
	$item_details['ad_dd'] = $media_details['ad_dd'];

	$template->set('item_details', $item_details);

	$template->set('buyout_only', $item->buyout_only($item_details));

	$template->set('user_details', $user_details);

	//$template->set('fees', $fees);
	$template->set('session', $session);
	$template->set('item', $item);

	$template->set('item_can_bid', $item->can_bid($session->value('user_id'), $item_details));

	$template->set('main_category_display', category_navigator($item_details['category_id'], false, false));
	$template->set('addl_category_display', category_navigator($item_details['addl_category_id'], false, false));

	$template->set('direct_payment_box', $item->direct_payment_box($item_details, $session->value('user_id')));
	$template->set('ad_display', 'preview'); /* if ad_display = preview, then some table fields will be disabled */
	$template->set('print_button', 'show'); 

	$template->set('show_buyout', show_buyout($item_details));

	$template->set('your_bid', $item->your_bid($item_details['auction_id'], $session->value('user_id')));

	$tax = new tax();
	$seller_country = $tax->display_countries($user_details['country']);
	$template->set('seller_country', $seller_country);

	$template->set('auction_location', $item->item_location($item_details));
	$template->set('auction_country', $tax->display_countries($item_details['country']));

	$swap_offer_link = ($item_details['enable_swap'] && $session->value('user_id') != $item_details['owner_id']) ? '[ <a href="#">' . MSG_MAKE_SWAP_OFFER . '</a> ]' : '';
	$template->set('swap_offer_link', $swap_offer_link);

	$template->set('high_bidders_content', $item->show_high_bid($item_details));

	$winners_message_board = $item->winners_message_board_link($item_details, $session->value('user_id'));
	$template->set('winners_message_board', $winners_message_board);

	$reputation_table_small = $reputation->rep_table_small($item_details['owner_id'], $item_details['auction_id']);
	$template->set('reputation_table_small', $reputation_table_small);

	$auction_tax = $tax->auction_tax($user_details['user_id'], $setts['enable_tax'], $session->value('user_id'));
	$template->set('auction_tax', $auction_tax);

	$custom_fld->new_table = ($setts['default_theme'] == 'ultra') ? true : false;
	$custom_fld->field_colspan = 1;
	$custom_sections_table = $custom_fld->display_sections($item_details, $page_handle, true, $item_details['auction_id'], $item_details['category_id']);
	$template->set('custom_sections_table', $custom_sections_table);

	$ad_image_thumbnails = $item->item_media_thumbnails($item_details, 1, false, false, $setts['thumb_display_type']);
	$template->set('ad_image_thumbnails', $ad_image_thumbnails);

	$ad_video_thumbnails = $item->item_media_thumbnails($item_details, 2);
	$template->set('ad_video_thumbnails', $ad_video_thumbnails);

	$video_play_file = (!empty($_REQUEST['video_name'])) ? $_REQUEST['video_name'] : $item_details['ad_video'][0];
	$ad_video_main_box = $item->video_box($video_play_file);
	$template->set('ad_video_main_box', $ad_video_main_box);

	if (!empty($item_details['direct_payment']))
	{
		$dp_methods = $item->select_direct_payment($item_details['direct_payment'], $user_details['user_id'], true);

		$direct_payment_methods_display = $template->generate_table($dp_methods, 2, 3, 3, null, '', '');
		$template->set('direct_payment_methods_display', $direct_payment_methods_display);
	}

	if (!empty($item_details['payment_methods']))
	{
		$offline_payments = $item->select_offline_payment($item_details['payment_methods'], true);

		$offline_payment_methods_display = $template->generate_table($offline_payments, 4, 3, 3, null, '', '');
		$template->set('offline_payment_methods_display', $offline_payment_methods_display);
	}

	$template->change_path('themes/' . $setts['default_theme'] . '/templates/');
	$template_output .= $template->process('auction_details.tpl.php');
	$template->change_path('templates/');
}
else
{
	$template->set('message_header', header5(MSG_AUCTION_DETAILS_ERROR_TITLE));
	$template->set('message_content', '<p align="center">' . MSG_AUCTION_DETAILS_ERROR_CONTENT . '</p>');

	$template_output .= $template->process('single_message.tpl.php');
}

echo $template_output;
?>