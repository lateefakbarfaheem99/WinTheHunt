<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('FRMCHK_ITEM') ) { die("Access Denied"); }

$fv = new formchecker;

$fv->check_box($frmchk_details['category_id'], MSG_MAIN_CATEGORY, array('field_empty'));

if ($frmchk_details['category_id'] == $frmchk_details['addl_category_id'])
{
	$fv->error_list[] = array('value' => $frmchk_details['category_id'], 'msg' => MSG_FRMCHK_SAME_CATS);
}

$fv->check_box($frmchk_details['name'], MSG_ITEM_TITLE, array('field_empty', 'field_html'));
$fv->check_box($frmchk_details['description'], MSG_ITEM_DESCRIPTION, array('field_empty', 'field_js', 'field_iframes', 'invalid_html'));

if ($frmchk_details['start_time_type'] == 'custom')
{
	$fv->field_greater($frmchk_details['start_time'], CURRENT_TIME, MSG_FRMCHK_START_TIME_PAST);
}

if ($frmchk_details['end_time_type'] == 'custom')
{
	$fv->field_greater($frmchk_details['end_time'], CURRENT_TIME, MSG_FRMCHK_END_TIME_PAST);
	$fv->field_greater($frmchk_details['end_time'], $frmchk_details['start_time'], MSG_FRMCHK_START_SMALLER_END_TIME);
}

## now check the custom boxes
$fv->check_custom_fields($frmchk_details);
?>
