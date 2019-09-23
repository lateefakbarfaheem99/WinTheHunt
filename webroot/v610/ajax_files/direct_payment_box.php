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

$user_id = intval($_REQUEST['user_id']);
$user_details = array();

$gateway_settings = payment_gateways_array($user_details);

if ($session->value('adminarea') == 'Active' || $user_id == session::value('user_id'))
{
	$dp_array =	$gateway_settings[$_REQUEST['id']];
	
	$result = array();
	foreach ($dp_array as $key => $value)
	{
		if ($key != 'id' && !empty($key))
		{
			$db->query_silent("UPDATE " . DB_PREFIX . "users 
				SET " . $key . "='" . $db->rem_special_chars($_REQUEST[$key]) . "' WHERE user_id='" . $user_id . "'");
			$result[] = $key . ';' . $db->rem_special_chars($_REQUEST[$key]);
		}
	}
}

?>
