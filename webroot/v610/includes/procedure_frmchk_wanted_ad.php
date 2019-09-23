<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
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

## now check the custom boxes
$fv->check_custom_fields($frmchk_details);

$fv->check_box($frmchk_details['zip_code'], MSG_ZIP_CODE, array('field_empty', 'field_html'));
?>
