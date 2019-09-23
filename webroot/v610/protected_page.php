<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

(string) $page_handle = 'login';

include_once ('includes/global.php');

$user_id = intval($_REQUEST['user_id']);
$auction_id = intval($_REQUEST['auction_id']);
$category_id = intval($_REQUEST['category_id']);

require ('global_header.php');

$template->set('header_registration_message', header5(MSG_PROTECTED_PAGE_LOGIN));

if ($_REQUEST['operation'] == 'submit')
{
	$signup_fee = new fees();
	$signup_fee->setts = &$setts;

	$login_output = login_protected_page($user_id, $category_id, $_REQUEST['password']);

	if ($login_output)
	{
		header_redirect($_REQUEST['redirect_url'] . '.php?auction_id=' . $auction_id . '&user_id=' . $user_id . '&parent_id=' . $category_id);
	}
	else
	{
		$invalid_login_message = '<table width="400" border="0" cellpadding="4" cellspacing="0" align="center" class="errormessage"> '.
		'	<tr><td align="center" class="alertfont"><b>' . MSG_INVALID_LOGIN . '</b></td></tr> '.
		'</table>';

		$template->set('invalid_login_message', $invalid_login_message);
	}
}

$template->set('redirect_url', $db->rem_special_chars($_REQUEST['redirect_url']));
$template->set('auction_id', $auction_id);
$template->set('user_id', $user_id);
$template->set('category_id', $category_id);

$template_output .= $template->process('protected_page.tpl.php');

include_once ('global_footer.php');

echo $template_output;
?>