<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('FRMCHK_USER') ) { die("Access Denied"); }

$fv = new formchecker;

if ($frmchk_details['tax_account_type'] == 1)
{
	$fv->check_box($frmchk_details['tax_company_name'], MSG_COMPANY_NAME, array('field_empty', 'field_html'));
}
$fv->check_box($frmchk_details['first_name'], MSG_FIRST_NAME, array('field_empty', 'field_html'));
$fv->check_box($frmchk_details['last_name'], MSG_LAST_NAME, array('field_empty', 'field_html'));
$fv->check_box($frmchk_details['address'], MSG_ADDRESS, array('field_empty', 'field_html'));
$fv->check_box($frmchk_details['city'], MSG_CITY, array('field_empty', 'field_html'));
$fv->check_box($frmchk_details['country'], MSG_COUNTRY, array('field_empty'));
$fv->check_box($frmchk_details['state'], MSG_STATE, array('field_empty', 'field_html'));
$fv->check_box($frmchk_details['zip_code'], MSG_ZIP_CODE, array('field_empty', 'field_html'));

$fv->check_box($frmchk_details['phone'], MSG_PHONE, array('field_empty', 'field_html', 'is_phone'));

if (!$frmchk_user_edit && IN_ADMIN != 1)
{
	$frmchk_birthdate = ($setts['birthdate_type'] == 1) ? mktime(0, 0, 0, 1, 1, intval($frmchk_details['birthdate_year'])) : mktime(0, 0, 0, intval($frmchk_details['dob_month']), intval($frmchk_details['dob_day']), intval($frmchk_details['dob_year']));
	$frmchk_birthdate = time_difference(CURRENT_TIME, $frmchk_birthdate) / 31536000; // date in years

	if ($setts['birthdate_type'] == 1)
	{
		$fv->check_box($frmchk_details['birthdate_year'], MSG_DATE_OF_BIRTH, 'field_empty');
	}
	else
	{
		$fv->check_box($frmchk_details['dob_month'], MSG_BIRTH_MONTH, array('field_empty'));
		$fv->check_box($frmchk_details['dob_day'], MSG_DAY_OF_BIRTH, array('field_empty'));
		$fv->check_box($frmchk_details['dob_year'], MSG_YEAR_OF_BIRTH, array('field_empty'));

	}
	$fv->field_greater($frmchk_birthdate, $setts['min_reg_age'], GMSG_MIN_REG_AGE_A . $setts['min_reg_age'] . GMSG_MIN_REG_AGE_B);
}

## check for blocked domains
$email_split = explode('@', $frmchk_details['email']);
$email_domain = $email_split[1];

$is_blocked_domain = $db->count_rows('blocked_domains', "WHERE domain='" . $email_domain . "'");

if ($is_blocked_domain)
{
	$fv->error_list[] = array('value' => $email_domain, 'msg' => MSG_FRMCHK_EMAIL_DOMAIN_BLOCKED . ' (<b>' . $email_domain . '</b>)');
}

if (!$frmchk_user_edit)
{
	$fv->field_duplicate_fulltext('users', 'email', $frmchk_details['email'], MSG_FRMCHK_DUPLICATE_EMAIL);
}
else
{
	$fv->field_duplicate_fulltext('users', 'email', $frmchk_details['email'], MSG_FRMCHK_DUPLICATE_EMAIL, 'user_id', $frmchk_details['user_id']);
}

$fv->check_box($frmchk_details['email'], MSG_EMAIL_ADDRESS, array('is_email_address', 'pass_confirm'), $_POST['email_check'], MSG_RETYPE_EMAIL);

## first the standard boxes error checking
if (!$frmchk_user_edit)
{
	$fv->field_duplicate_fulltext('users', 'username', $frmchk_details['username'], MSG_FRMCHK_DUPLICATE_USERNAME);
	$fv->check_box($frmchk_details['username'], MSG_CREATE_USERNAME, array('field_empty', 'field_alpha', 'field_html'));
}

if (!$frmchk_user_edit || !empty($frmchk_details['password']))
{
	$fv->check_box($frmchk_details['password'], MSG_CREATE_PASS, array('within_length', 'pass_confirm'), $_POST['password2'], MSG_VERIFY_PASS);
}

## now check the custom boxes
$fv->check_custom_fields($frmchk_details);

if (!$frmchk_user_edit && IN_ADMIN != 1)
{
	$fv->check_box($frmchk_details['pin_value'], MSG_CONF_PIN, array('field_equal'), $frmchk_details['generated_pin'], MSG_REG_PIN);
	if ($layout['enable_reg_terms'])
	{
		$fv->field_checked($frmchk_details['agree_terms'], GMSG_AGREE_TO_REG_TERMS);
	}
}

?>
