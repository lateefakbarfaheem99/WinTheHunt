<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('FRMCHK_ITEM') ) { die("Access Denied"); }

$fv = new formchecker;

$is_user = $db->count_rows('users', "WHERE username='" . $post_details['abuser_username'] . "'");
if (!$is_user)
{
	$fv->error_list[] = array('value' => null, 'msg' => MSG_ERROR_USER_DOESNT_EXIST);
}
$fv->check_box($frmchk_details['comment'], MSG_COMMENTS, array('field_empty', 'field_html'));

?>
