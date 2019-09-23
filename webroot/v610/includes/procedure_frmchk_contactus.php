<?
#################################################################
## PHP Pro Bid v6.05															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('FRMCHK_ITEM') ) { die("Access Denied"); }

$fv = new formchecker;

$fv->check_box($frmchk_details['email'], MSG_EMAIL_ADDRESS, array('field_empty', 'is_email_address'));
$fv->check_box($frmchk_details['pin_value'], MSG_CONF_PIN, array('field_equal'), $frmchk_details['generated_pin'], MSG_PIN_CODE);
$fv->check_box($frmchk_details['question_content'], MSG_QUESTION_QUERY, array('field_empty'));
?>
