<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');

if ($session->value('membersarea') != 'Active')
{
	$template_output .= '<p align="center" class="contentfont">' . GMSG_ACCESS_DENIED . '</p>';
}
else
{
	$page_title = ($_GET['option'] == 'add') ? MSG_ADD_LOCATION : MSG_EDIT_LOCATION;
	$template->set('page_title', $page_title);

	$template->set('form_name', $_GET['form_name']);
	$template->set('option', $_GET['option']);
	$template->set('id', intval($_GET['id']));

	$db->query("UPDATE " . DB_PREFIX . "users SET pc_shipping_locations='local' WHERE user_id='" . $session->value('user_id') . "'");
	
	if ($_REQUEST['submit_form'])
	{
		$locations_id = $db->implode_array($_REQUEST['countries_id']);
		
		$pc_default = intval($_REQUEST['pc_default']);
				
		if ($pc_default)
		{
			$db->query("UPDATE " . DB_PREFIX . "shipping_locations SET pc_default=0 WHERE user_id='" . $session->value('user_id') . "'");			
		}
		
		switch ($_REQUEST['option'])
		{
			case 'add':
				$db->query("INSERT INTO " . DB_PREFIX . "shipping_locations 
					(locations_id, amount, amount_type, pc_default, user_id) VALUES 
					('" . $locations_id . "', '" . doubleval($_REQUEST['amount']) . "', 
					'" . $db->rem_special_chars($_REQUEST['amount_type']) . "', '" . $pc_default . "', 
					'" . $session->value('user_id') . "')");
				break;
			case 'edit':
				$db->query("UPDATE " . DB_PREFIX . "shipping_locations SET 
					locations_id='" . $locations_id . "', amount='" . doubleval($_REQUEST['amount']) . "', 
					amount_type='" . $db->rem_special_chars($_REQUEST['amount_type']) . "', 
					pc_default='" . $pc_default . "' WHERE 
					id='" . intval($_REQUEST['id']) . "' AND user_id='" . $session->value('user_id') . "'");
		}
	}
	else 
	{
		$location_details = null;
		if ($_GET['option'] == 'edit')
		{
			$location_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "shipping_locations WHERE 
				user_id='" . $session->value('user_id') . "' AND id='" . intval($_GET['id']) . "'");
		}
		$template->set('location_details', $location_details);
		
		$all_locations = shipping_locations($session->value('user_id'));
		
		$selected_countries = (!empty($location_details['locations_id'])) ? $location_details['locations_id'] : 0;
	
		$sql_select_all_countries = $db->query("SELECT c.id, c.name, s.id AS state_id, s.name AS state_name, s.parent_id FROM
			" . DB_PREFIX . "countries c LEFT JOIN " . DB_PREFIX . "countries s ON c.id=s.parent_id AND s.id NOT IN (".$all_locations.") WHERE
			(c.id NOT IN (".$all_locations.")) AND c.parent_id=0 ORDER BY c.country_order ASC, c.name ASC");
	
		$all_countries_table = '<select name="all_countries" size="15" multiple="multiple" id="all_countries" style="width: 100%;">';
	
		while ($all_countries_details = $db->fetch_array($sql_select_all_countries))
		{
			$country_id = ($all_countries_details['state_id']) ? $all_countries_details['state_id'] : $all_countries_details['id'];
			$country_name = $all_countries_details['name'] . (($all_countries_details['state_id']) ? ' - ' . $all_countries_details['state_name'] : '');
	
			$all_countries_table .= '<option value="' . $country_id . '">' . $country_name . '</option>';
		}
	
		$all_countries_table .= '</select>';
	
		$sql_select_selected_countries = $db->query("SELECT c.id, c.name, s.id AS state_id, s.name AS state_name, s.parent_id FROM
			" . DB_PREFIX . "countries c LEFT JOIN " . DB_PREFIX . "countries s ON c.id=s.parent_id WHERE
			(c.id IN (".$selected_countries.") OR s.id IN (".$selected_countries.")) AND c.parent_id=0 ORDER BY c.country_order ASC, c.name ASC");
	
		$selected_countries_table ='<select name="countries_id[]" size="15" multiple="multiple" id="countries_id" style="width: 100%;"> ';
	
		while ($selected_countries_details = $db->fetch_array($sql_select_selected_countries))
		{
			$country_id = ($selected_countries_details['state_id']) ? $selected_countries_details['state_id'] : $selected_countries_details['id'];
			$country_name = $selected_countries_details['name'] . (($selected_countries_details['state_id']) ? ' - ' . $selected_countries_details['state_name'] : '');
	
			$selected_countries_table .= '<option value="' . $country_id . '" selected>' . $country_name . '</option>';
		}
	
		$selected_countries_table .= '</select>';
	
		$template->set('all_countries_table', $all_countries_table);
		$template->set('selected_countries_table', $selected_countries_table);
	
		$template_output .= $template->process('shipping_locations_select.tpl.php');
	}
}
//echo $template_output;
?>
