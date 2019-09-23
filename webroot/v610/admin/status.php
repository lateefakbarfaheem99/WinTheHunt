<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$site_status['total_auctions'] = $db->count_rows('auctions', "WHERE creation_in_progress=0 AND is_draft=0");
$site_status['open_auctions'] = $db->count_rows('auctions', "WHERE active=1 AND approved=1 AND closed=0 AND deleted=0 AND creation_in_progress=0 AND is_draft=0");
$site_status['closed_auctions'] = $db->count_rows('auctions', "WHERE active=1 AND approved=1 AND closed=1 AND deleted=0 AND creation_in_progress=0 AND is_draft=0");
$site_status['suspended_auctions'] = $db->count_rows('auctions', "WHERE active=0 AND approved=1 AND deleted=0 AND creation_in_progress=0 AND is_draft=0");
$site_status['unapproved_auctions'] = $db->count_rows('auctions', "WHERE approved=0 AND deleted=0 AND creation_in_progress=0 AND is_draft=0");
$site_status['deleted_auctions'] = $db->count_rows('auctions', "WHERE deleted=1 AND creation_in_progress=0 AND is_draft=0");

$site_status['total_users'] = $db->count_rows('users');
$site_status['active_users'] = $db->count_rows('users', "WHERE active=1");
$site_status['suspended_users'] = $db->count_rows('users', "WHERE active=0");

$site_status['awaiting_approval'] = $db->count_rows('auctions', "WHERE creation_in_progress=0 AND is_draft=0 AND approved=0");
$site_status['abuse_reports'] = $db->count_rows('abuses');
$site_status['suggested_categories'] = $db->count_rows('suggested_categories');

$template->set('admin_lang_drop_down', list_languages('admin', true, $setts['admin_lang']));

$site_status['server_load'] = get_server_load();

$template->set('site_status', $site_status);

$template->set('gd_info', @gd_info());
$tax_info = new tax();
$convert_tax = $tax_info->convert_tax();
$template->set('convert_tax', $convert_tax);

$status_template_output = $template->process('status.tpl.php');
?>