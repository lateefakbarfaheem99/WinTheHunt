<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);
define ('IN_AJAX', 1);

include_once('../includes/global.php');

$tax = new tax();
$tax->setts = &$setts;

$user_id = session::value('user_id');

if ($user_id > 0)
{
	$db->query("UPDATE `" . DB_PREFIX . $db->rem_special_chars($_REQUEST['table']) . "` 
		SET `" . $db->rem_special_chars($_REQUEST['field_changed']) . "`='" . $db->rem_special_chars($_REQUEST['changed_value']) . "' 
		WHERE `" . $db->rem_special_chars($_REQUEST['field_id']) . "`='" . $db->rem_special_chars($_REQUEST['value_id']) . "' 
		AND `" . $db->rem_special_chars($_REQUEST['field_owner']) . "`='" . session::value('user_id') . "'");
	
	echo $db->rem_special_chars($_REQUEST['changed_value']);
}
?>
