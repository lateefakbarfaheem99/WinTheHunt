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

include_once ('includes/class_messaging.php');

$item_details = $db->get_sql_row("SELECT a.auction_id, a.owner_id, a.bank_details, u.default_bank_details 
	FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id 
	WHERE a.auction_id='" . intval($_REQUEST['auction_id']) . "'");

$is_winner = $db->count_rows('winners', "WHERE auction_id='" . $item_details['auction_id'] . "' AND buyer_id='" . $session->value('user_id') . "'");

if (($is_winner || ($item_details['owner_id'] == $session->value('user_id'))) && $item_details['auction_id'])
{
	if (isset($_POST['form_save_bank_details']) && $item_details['owner_id'] == $session->value('user_id'))
	{
		$db->query("UPDATE " . DB_PREFIX . "auctions SET bank_details='" . $db->rem_special_chars($_POST['message_content']) . "' WHERE
			owner_id='" . $session->value('user_id') . "' AND auction_id='" . $item_details['auction_id'] . "'");
	
		$template->set('msg_changes_saved', '<p align="center" class="style1">' . MSG_CHANGES_SAVED . '</p>');
		$item_details['bank_details'] = $_POST['message_content'];
		
		$mail_input_id = $item_details['auction_id'];
		include('language/' . $setts['site_lang'] . '/mails/bank_details_buyer_notification.php');
	}
	
	
	$template->set('can_edit', (($item_details['owner_id'] == $session->value('user_id') && $item_details['auction_id']) ? 1 : 0));
	$template->set('auction_id', $item_details['auction_id']);
	$template->set('message_title', ((empty($item_details['bank_details'])) ? MSG_SEND_BANK_DETAILS : MSG_VIEW_BANK_DETAILS));
	$template->set('message_content', ((empty($item_details['bank_details'])) ? $item_details['default_bank_details'] : $item_details['bank_details']));
	
	$template_output = $template->process('popup_bank_details.tpl.php');
}
else 
{
	$template_output = MSG_ERROR_BANK_POPUP;
}

echo $template_output;
?>