<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('FRMCHK_ITEM') ) { die("Access Denied"); }

$fv = new formchecker;

$fv->check_box($frmchk_details['category_desc'], GMSG_DESCRIPTION, array('field_empty', 'field_html'));

?>
