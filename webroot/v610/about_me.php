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
include_once ('includes/class_item.php');
include_once ('includes/class_shop.php');

include_once ('global_header.php');

(string) $message_content = null;

$user_details = $db->get_sql_row("SELECT username, enable_aboutme_page, aboutme_page_content, shop_account_id, shop_active FROM
	" . DB_PREFIX . "users WHERE user_id='" . intval($_REQUEST['user_id']) . "'");

$item = new item();
$item->setts = &$setts;
$item->layout = &$layout;

$shop = new shop();

$shop_status = $shop->shop_status($user_details);

if ($item->count_contents($user_details))
{
	if ($user_details['enable_aboutme_page'])
	{
		$message_header = MSG_MM_ABOUT_ME . ' - ' . $user_details['username'];
		$message_content = '<table width="100%" border="0" cellpadding="3" cellspacing="2"> '.
  			'	<tr class="contentfont"> '.
     		'		<td>' . $db->add_special_chars($user_details['aboutme_page_content']) . '</td> '.
   		'	</tr> '.
			'</table>';
	}
	else if ($shop_status['enabled'])
	{
		header_redirect('shop.php?user_id=' . $_REQUEST['user_id']);
	}
	else
	{
		$message_header = MSG_MM_ABOUT_ME . ' - ' . $user_details['username'];
		$message_content = '<p align="center">' . MSG_ABOUT_ME_PAGE_DISABLED . '</p>';
	}
}
else
{
	$message_header = MSG_ERROR;
	$message_content = '<p align="center">' . MSG_USER_DOESNT_EXIST . '</p>';
}

$template->set('message_header', header5($message_header));
$template->set('message_content', $message_content);

$template_output .= $template->process('single_message.tpl.php');

include_once ('global_footer.php');

echo $template_output;

?>