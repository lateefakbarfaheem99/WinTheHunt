<?
#################################################################
## PHP Pro Bid v6.00															##
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

if ($session->value('membersarea')!='Active')
{
	if ($session->value('user_id')) /* user inactive - redirect to account management page */
	{
		header_redirect('members_area.php?page=account&section_management');
	}
	else
	{
		header_redirect('login.php');
	}
}
else
{
	require ('global_header.php');

	(array) $user_details = null;
	(string) $page_handle = 'auction';

	$start_time_id = 1;
	$end_time_id = 2;

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	$item->edit_auction = true;

	/**
	 * We create a temporary row in the items table for every ad that is made. If the ad is placed, this temporary row
	 * will become the final ad row.
	 */
	if ($session->value('user_id'))
	{
		$user_details = $db->get_sql_row("SELECT user_id, username, shop_account_id, shop_categories,
			shop_active, preferred_seller, reg_date, country, state, zip_code, balance,
			default_name, default_description, default_duration, default_hidden_bidding,
			default_enable_swap, default_shipping_method, default_shipping_int, default_postage_amount,
			default_insurance_amount, default_type_service, default_shipping_details, default_payment_methods FROM
			" . DB_PREFIX . "users WHERE user_id=" . $session->value('user_id'));
	}

	define('EDIT_AUCTION', 1);

	$item_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "auctions WHERE auction_id='" . $_REQUEST['auction_id'] . "' AND owner_id=" . $session->value('user_id'));

	$sell_item_header = '<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border"> ' .
		'<tr><td class="c3"><b>' . $item_details['name'] . ' - ' . MSG_EDIT_DESCRIPTION . '</b></td></tr></table>';

	if (isset($_REQUEST['form_edit_proceed']))
	{
		$form_submitted = true;

		$description_edit = $db->rem_special_chars($_POST['description_main']);

		$item->edit_description($item_details, $description_edit);

		$template->set('message_header', $sell_item_header);
		$template->set('message_content', '<p align="center">' . MSG_DESCR_SAVED_SUCCESS . '</p>');
		$template_output .= $template->process('single_message.tpl.php');
	}

	if (!$form_submitted)
	{
		$template->set('auction_edit', 1);
		$template->set('do', $_REQUEST['do']);
		$template->set('item_details', $item_details);
		$template->set('user_details', $user_details);

		$template->set('sell_item_header', $sell_item_header);

		$template->set('post_url', 'edit_description.php');

		$template_output .= $template->process('edit_description.tpl.php');
	}

	include_once ('global_footer.php');

	echo $template_output;
}
?>