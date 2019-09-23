<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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
$template->set('auction_print_header', $auction_print_header);

$auction_print_footer = $template->process('empty_footer.tpl.php');
$template->set('auction_print_footer', $auction_print_footer);

(array) $user_details = null;

$start_time_id = 1;
$end_time_id = 2;

$item = new item();
$item->setts = &$setts;
$item->layout = &$layout;

$db->categories_table = 'reverse_categories';

$reputation = new reputation();
$reputation->setts = &$setts;

$page_handle = 'reverse';

$addl_query = ($session->value('adminarea')!="Active") ? " AND active=1" : '';

$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "reverse_auctions WHERE
	reverse_id='" . intval($_REQUEST['reverse_id']) . "'");


if ($item->count_contents($item_details))
{
	$user_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);

	$custom_fld = new custom_field();

	$custom_fld->save_edit_vars($item_details['reverse_id'], $page_handle);

	$media_details = $item->get_media_values(intval($_REQUEST['reverse_id']), false, true);
	$item_details['ad_image'] = $media_details['ad_image'];
	$item_details['ad_video'] = $media_details['ad_video'];

	$template->set('item_details', $item_details);

	$template->set('user_details', $user_details);

	$template->set('session', $session);
	$template->set('item', $item);

	$template->set('item_can_bid', $item->reverse_can_bid($session->value('user_id'), $item_details));

	$template->set('main_category_display', category_navigator($item_details['category_id'], true, false, 'reverse_auctions.php', null, null, true));
	$template->set('addl_category_display', category_navigator($item_details['addl_category_id'], true, false, 'reverse_auctions.php', null, null, true));

	$template->set('direct_payment_box', $item->direct_payment_box($item_details, $session->value('user_id')));
	$template->set('ad_display', 'preview'); /* if ad_display = preview, then some table fields will be disabled */
	$template->set('print_button', 'show'); 

	$template->set('your_bid', $item->your_bid($item_details['auction_id'], $session->value('user_id'), true));

	$tax = new tax();
	$seller_country = $tax->display_countries($user_details['country']);
	$template->set('seller_country', $seller_country);

	$winners_message_board = $item->reverse_pmb_link($item_details, $session->value('user_id'));
	$template->set('winners_message_board', $winners_message_board);

	$custom_fld->new_table = ($setts['default_theme'] == 'ultra') ? true : false;
	$custom_fld->field_colspan = 1;
	$custom_sections_table = $custom_fld->display_sections($item_details, $page_handle, true, $item_details['reverse_id'], $db->main_category($item_details['category_id']));
	$template->set('custom_sections_table', $custom_sections_table);

	$ad_image_thumbnails = $item->item_media_thumbnails($item_details, 1, false);
	$template->set('ad_image_thumbnails', $ad_image_thumbnails);

	$ad_video_thumbnails = $item->item_media_thumbnails($item_details, 2);
	$template->set('ad_video_thumbnails', $ad_video_thumbnails);

	$video_play_file = (!empty($_REQUEST['video_name'])) ? $_REQUEST['video_name'] : $item_details['ad_video'][0];
	$ad_video_main_box = $item->video_box($video_play_file);
	$template->set('ad_video_main_box', $ad_video_main_box);

	$template->change_path('themes/' . $setts['default_theme'] . '/templates/');
	$template_output .= $template->process('reverse_details.tpl.php');
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