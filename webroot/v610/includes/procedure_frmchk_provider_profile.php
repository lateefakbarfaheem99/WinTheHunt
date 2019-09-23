<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('FRMCHK_ITEM') ) { die("Access Denied"); }

$fv = new formchecker;

$fv->check_box($frmchk_details['provider_profile'], MSG_ITEM_DESCRIPTION, array('field_empty', 'field_js', 'field_iframes', 'invalid_html'));

## now check the custom boxes
$fv->check_custom_fields($frmchk_details);
?>
