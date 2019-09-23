<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

define ('IN_SITE', 1);
define ('IN_AJAX', 1);

include_once('../includes/global.php');

$tax = new tax();
$tax->setts = &$setts;

$user_id = intval($_REQUEST['user_id']);

if ($user_id > 0)
{
	$tax->selected_cid = shipping_locations($user_id);
}

echo $tax->states_box('state', '', intval($_REQUEST['country_id']), null, true);

?>
