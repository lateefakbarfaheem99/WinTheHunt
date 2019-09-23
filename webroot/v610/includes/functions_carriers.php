<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

function select_carriers($country_id, $seller_details)
{
	global $db;
	
	$output = array();

	$seller_country_iso = $db->get_sql_field("SELECT country_iso_code FROM " . DB_PREFIX . "countries WHERE 
		id='" . $seller_details['country'] . "'", 'country_iso_code');
		
	$sql_select_carriers = $db->query("SELECT * FROM " . DB_PREFIX . "shipping_carriers WHERE 
		carrier_id IN (" . $seller_details['shipping_carriers'] . ") AND enabled=1");

	while ($carrier_details = $db->fetch_array($sql_select_carriers))
	{
		if ($carrier_details['name'] != 'USPS' || $seller_country_iso == 'us')
		{
			$output[] = $carrier_details['name'];
		}
	}

	return $output;
}

function is_shipping_carriers()
{
	global $db;
	
	return ($db->count_rows('shipping_carriers', "WHERE enabled=1")) ? true : false;
}

function carriers_enabled($user_details)
{
	return ($user_details['pc_postage_type'] == 'weight' && $user_details['pc_postage_calc_type'] == 'carriers' && !empty($user_details['shipping_carriers'])) ? true : false;
}

function iso_country($country_id)
{
	global $db;
	
	return $db->get_sql_field("SELECT country_iso_code FROM " . DB_PREFIX . "countries WHERE 
		id='" . $country_id . "'", 'country_iso_code');
}

function carriers_dropdown($box_name, $carriers_array, $selected_value, $item_currency, $form_refresh = null)
{
	global $fees, $db;
	
	(string) $display_output = null;

	if ($form_refresh)
	{
		//$form_refresh = ($form_refresh == 'shipping_calculator_form') ? 'onChange = "javascript:shipping_calculator();"' : 'onChange = "submit_form(' . $form_refresh . ', \'\')"';
		$form_refresh = ($form_refresh == 'shipping_calculator_form') ? '' : 'onblur = "submit_form(' . $form_refresh . ', \'\')"';
	}

	if (count($carriers_array))
	{
		$display_output = '<select name="' . $box_name . '" id="' . $box_name . '" ' . $form_refresh . '> ';
		//$display_output .= '<option value="" selected>' . MSG_SELECT_METHOD . '</option> ';	
		
		foreach ($carriers_array as $value)
		{		
			if ($value['currency'] != $item_currency)
			{
				$currency_from_value = $db->get_sql_field("SELECT convert_rate FROM " . DB_PREFIX . "currencies WHERE 
					symbol='" . $value['currency'] . "'", 'convert_rate');
				$currency_to_value = $db->get_sql_field("SELECT convert_rate FROM " . DB_PREFIX . "currencies WHERE 
					symbol='" . $item_currency . "'", 'convert_rate');
			
				$value['price'] = $value['price'] * $currency_to_value / $currency_from_value;	
				$value['currency'] = $item_currency;			
			}
			
			$description = $value['carrier'] . ', ' . $value['service_name'] . ' - ' . $fees->display_amount($value['price'], $value['currency']);
			$display_output .= '<option value="' . $value['carrier'] . '|' . $value['service_name'] . '" ' . (($selected_value == $value['carrier'] . '|' . $value['service_name']) ? 'selected' : ''). '>' . $description . '</option>';
		}

		$display_output .= '</select>';
	}
	else 
	{
		$display_output = MSG_NO_SHIPPING_METHODS_AVAILABLE;
	}
	
	return $display_output;
}

function carrier_methods($item_currency, $total_weight, $seller_details, $buyer_country_id, $buyer_zip_code, $sc_carrier, $form_name = null)
{
	global $db, $setts;
	
	$output = array('carriers_dropdown' => null, 'submit_disabled' => 'disabled', 'selected_carrier' => null);
	
	$shipping_carriers = select_carriers($buyer_country_id, $seller_details);
	
	if (count($shipping_carriers))
	{
		$shipping_methods = array();

		$carriers = new shipping_methods();
		$carriers->setts = &$setts;

		$seller_iso_country = iso_country($seller_details['country']);
		$buyer_iso_country = iso_country($buyer_country_id);

		$fedex_result = array();
		$usps_result = array();
		$ups_result = array();

		foreach ($shipping_carriers as $carrier)
		{
			switch ($carrier)
			{
				case 'FedEx':
					$fedex_result = $carriers->fedex_service($total_weight, $seller_details['zip_code'], $seller_iso_country, $buyer_zip_code, $buyer_iso_country);
					break;
				case 'USPS':
					$usps_result = $carriers->usps_service($total_weight, $seller_details['zip_code'], $buyer_zip_code, $buyer_iso_country);
					break;
				case 'UPS':
					$ups_result = $carriers->ups_service($total_weight, $seller_details['zip_code'], $seller_iso_country, $buyer_zip_code, $buyer_iso_country);
					break;
			}
		}

		$carriers_array = array_merge((array)$fedex_result, (array)$usps_result, (array)$ups_result);
		$output['carriers_dropdown'] = carriers_dropdown('sc_carrier', $carriers_array, $sc_carrier, $item_currency, $form_name);

		if (count($carriers_array))
		{
			$output['submit_disabled'] = '';
			
			if (!$sc_carrier) // select a default method
			{
				$output['selected_carrier'] = $carriers_array[0]['carrier'] . '|' . $carriers_array[0]['service_name'];
			}
			else 
			{
				$output['selected_carrier'] = $sc_carrier;
			}
		}
	}
	else
	{
		$output['carriers_dropdown'] = MSG_NO_SHIPPING_METHODS_AVAILABLE;
	}
	
	return $output;
}
?>