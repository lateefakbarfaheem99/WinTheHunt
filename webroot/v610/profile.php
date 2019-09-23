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

require ('global_header.php');

$user_id = intval($_REQUEST['user_id']);

$user_details = $db->get_sql_row("SELECT * FROM
	" . DB_PREFIX . "users WHERE user_id=" . $user_id . " AND enable_profile_page=1");

if (item::count_contents($user_details) && $setts['enable_profile_page'])
{
	$template->set('user_id', $user_id);
	$template->set('auction_id', $_REQUEST['auction_id']);
	
	$user_details['profile_www'] = ((!empty($user_details['profile_www']) && !stristr($user_details['profile_www'], 'http://') && !stristr($user_details['profile_www'], 'https://')) ? 'http://' : '') . $user_details['profile_www'];
	$template->set('user_details', $user_details);

	$tax = new tax();
	$seller_country = $tax->display_countries($user_details['country']);
	$template->set('seller_country', $seller_country);

	$bidding_times = $db->count_rows('bids', "WHERE bidder_id='" . $user_id . "'");
	$template->set('bidding_times', $bidding_times);
	
	$bidding_auctions = $db->count_rows('bids', "WHERE bidder_id='" . $user_id . "' GROUP BY auction_id");
	$template->set('bidding_auctions', $bidding_auctions);
	
	$nb_open_items = $db->count_rows('auctions', "WHERE owner_id='" . $user_id . "' AND
		closed=0 AND deleted=0 AND creation_in_progress=0 AND is_draft=0");
	$template->set('nb_open_items', $nb_open_items);

	$nb_sold_items = $db->count_rows('winners', "WHERE seller_id='" . $user_id . "' AND
		s_deleted=0");
	$template->set('nb_sold_items', $nb_sold_items);
		
	$template_output .= $template->process('profile.tpl.php');
}
else
{
	$template->set('message_header', header5(MSG_VIEW_MEMBER_PROFILE));
	$template->set('message_content', '<p align="center">' . MSG_USER_DOESNT_EXIST_PROFILE_DISABLED . '</p>');

	$template_output .= $template->process('single_message.tpl.php');
}

include_once ('global_footer.php');

echo $template_output;

?>