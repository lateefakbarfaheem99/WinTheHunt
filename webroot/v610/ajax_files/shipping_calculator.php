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

$sc_item_id = intval($_REQUEST['sc_item_id']);

$template->set('auction_id', $sc_item_id);

$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE
	auction_id='" . $sc_item_id . "'");
$template->set('item_details', $item_details);

$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE 
	user_id='" . $item_details['owner_id'] . "'");
$user_details['country'] = $item_details['country'];
$user_details['zip_code'] = $item_details['zip_code'];

$sc_disabled = 'disabled';	

$sc_quantity = intval($_REQUEST['sc_quantity']);	
$sc_quantity = ($sc_quantity > $item_details['quantity']) ? $item_details['quantity'] : (($sc_quantity < 1) ? 1 : $sc_quantity);
$template->set('sc_quantity', $sc_quantity);

$tax->selected_cid = shipping_locations($item_details['owner_id']);

$sc_country = intval($_REQUEST['sc_country']);
$sc_state = intval($_REQUEST['sc_state']);

$sc_zip_code = $db->rem_special_chars($_REQUEST['sc_zip_code']);
$template->set('sc_zip_code', $sc_zip_code);

$sc_carrier = $db->rem_special_chars($_REQUEST['sc_carrier']);

$template->set('country_dropdown', $tax->countries_dropdown('sc_country', $sc_country, 'shipping_calculator_form', 'shipping_calculator', true, MSG_SELECT_COUNTRY, $item_details['owner_id'], 0));

$states_check = false;
if ($tax->is_states($sc_country))
{
	$template->set('state_dropdown', $tax->states_box('sc_state',$sc_state, $sc_country, 'shipping_calculator_form'));

	if ($sc_state)
	{
		$states_check = true;
		$sc_disabled = '';
	}
}
else if ($sc_country)
{
	$sc_disabled = '';
	$states_check = true;
}

if (carriers_enabled($user_details) && $states_check)
{
	$sc_disabled = 'disabled';

	$template->set('request_zip_code', true);
	
	if (!empty($sc_zip_code))
	{		
		$total_weight = $item_details['item_weight'] * $sc_quantity;
		$carriers_result = carrier_methods($item_details['currency'], $total_weight, $user_details, $sc_country, $sc_zip_code, $sc_carrier, 'shipping_calculator_form');
		$sc_disabled = $carriers_result['submit_disabled'];		
		
		$template->set('carriers_dropdown', $carriers_result['carriers_dropdown']);		
	}
}

$sc_postage_value = -1;
if (isset($_REQUEST['form_calculate_postage']))
{
	$sc_quantity = intval($_REQUEST['sc_quantity']);
	$sc_quantity = ($sc_quantity > 0) ? $sc_quantity : 1;

	$calc_postage = calculate_postage(null, $item_details['owner_id'], $item_details['auction_id'], null, $sc_country, $sc_state, $sc_quantity, $sc_carrier, $sc_zip_code);
	$sc_postage_value = doubleval($calc_postage['postage']);
}
$template->set('sc_postage_value', $sc_postage_value);

$template->set('sc_disabled', $sc_disabled);

$template->change_path('../templates/');
$shipping_calculator_box = $template->process('shipping_calculator_box.tpl.php');

echo $shipping_calculator_box;
?>
