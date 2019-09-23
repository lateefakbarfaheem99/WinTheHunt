<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$can_view = true;

if ($session->value('adminlevel') > 1)
{
	$can_view = ((stristr($_SERVER['PHP_SELF'], 'list_site_users.php')) || 
		stristr($_SERVER['PHP_SELF'], 'list_auctions.php') ||
		stristr($_SERVER['PHP_SELF'], "email_user.php") || 
		stristr($_SERVER['PHP_SELF'], "list_user_bids.php") ||
		stristr($_SERVER['PHP_SELF'], "accounting.php") ||
		stristr($_SERVER['PHP_SELF'], "index.php")) ? true : false;

}

if ($session->value('category_language')==1)
{
	$updated_categories_message = '<table width="100%" bgcolor="red"><tr> '.
		'<td align="center"><font size="+2" color="#ffffff">' . AMSG_CAT_CHANGE_EXPL_MSG . '</font></td></tr></table> ';
	$template->set('updated_categories_message', $updated_categories_message);
}

if (!$can_view && !$msg_shown)
{
	header_redirect('index.php?viewmsg=1');
}

if (stristr($_SERVER['PHP_SELF'], 'index.php'))
{
	include_once ('status.php');
	$template->set('admin_left_menu', $status_template_output);
}
else
{
	$leftmenu_template_output = $template->process('leftmenu.tpl.php');
	$template->set('admin_left_menu', $leftmenu_template_output);
}

$template->change_path('../templates/');
$template->set('global_header_content', $template->process('global_header.tpl.php'));
$template->change_path('templates/');

$template_output .= $template->process('header.tpl.php');
?>