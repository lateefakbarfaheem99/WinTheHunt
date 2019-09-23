<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');
include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_user.php');

if ($session->value('adminarea')!='Active')
{## PHP Pro Bid v6.00 do nothing
}
else
{
	(string) $page_handle = 'register';
	
	$user = new user();
	$user->setts = &$setts;

	$row_user = $db->get_sql_row("SELECT u.user_id, u.username, u.email, u.active, u.approved, u.reg_date,
		u.payment_mode, u.tax_account_type, u.tax_reg_number, u.tax_apply_exempt, u.tax_exempted,
		u.name, u.address, u.city, u.zip_code, u.phone, u.birthdate, u.birthdate_year,
		u.tax_company_name, c.name AS country_name, s.name AS state_name, u.state FROM
		" . DB_PREFIX ."users u
		LEFT JOIN " . DB_PREFIX . "countries s ON u.state=s.id
		LEFT JOIN " . DB_PREFIX . "countries c ON u.country=c.id WHERE u.user_id=" . $_REQUEST['user_id']);

	$user_details_print_link = ' &nbsp; [ <a href="javascript:window.print();">' . AMSG_PRINT_THIS_PAGE . '</a> ] '.
		'[ <a href="javascript:window.close();">' . AMSG_CLOSE_WINDOW . '</a> ]';
	$template->set('user_details_print_link', $user_details_print_link);
		
	$user->save_edit_vars($_REQUEST['user_id'], $page_handle);

	$template->set('user_details', $row_user);
	$template->set('user_full_address', $user->full_address($row_user));
	$template->set('user_birthdate', $user->show_birthdate($row_user));

	$template->set('tax_account_type', field_display($row_user['tax_account_type'], GMSG_INDIVIDUAL, GMSG_BUSINESS));

	$custom_sections_table = $user->display_sections($row_user, $page_handle, true, $_REQUEST['user_id']);

	$template->set('custom_sections_table', $custom_sections_table);
	
	$template->set('print_view', 1);

	$template_output = $template->process('list_site_users_user_details.tpl.php');

	echo $template_output;
}
?>