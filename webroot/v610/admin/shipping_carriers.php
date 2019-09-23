<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (isset($_POST['form_save_settings']))
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		$sql_reset_carriers = $db->query("UPDATE " . DB_PREFIX . "shipping_carriers SET
			enabled = 0");

		$carriers_enabled = $db->implode_array($_POST['checked']);

		$sql_update_checked = $db->query("UPDATE " . DB_PREFIX . "shipping_carriers SET
			enabled = 1 WHERE carrier_id IN (" . $carriers_enabled . ")");
	
		$carrier_setts = array(
			'usps_username' => $db->rem_special_chars($_POST['usps_username']),
			'fedex_account_number' => $db->rem_special_chars($_POST['fedex_account_number']),
			'fedex_meter_number' => $db->rem_special_chars($_POST['fedex_meter_number'])
		);
		
		$db->query("UPDATE " . DB_PREFIX . "gen_setts SET carrier_setts='" . serialize($carrier_setts) . "'");
	}

	$template->set('header_section', AMSG_AUCTIONS_MANAGEMENT);
	$template->set('subpage_title', AMSG_SHIPPING_CARRIERS_MANAGEMENT);

	$sql_select_active_carriers = $db->query("SELECT name FROM " . DB_PREFIX . "shipping_carriers WHERE enabled=1");

	(string) $active_carriers_message = null;

	while ($active_carrier_details = $db->fetch_array($sql_select_active_carriers))
	{
		$active_carriers_message .= ' [ <font color="#EEEE00">' . $active_carrier_details['name'] . '</font> ] ';
	}

	$template->set('active_carriers_message', $active_carriers_message);

	$sql_select_carriers = $db->query("SELECT * FROM
		" . DB_PREFIX . "shipping_carriers");

	(string) $carriers_table_rows = null;

	$carrier_setts = $db->get_sql_field("SELECT carrier_setts FROM " . DB_PREFIX . "gen_setts", 'carrier_setts');
	$carrier_setts = unserialize($carrier_setts);

	while ($carrier_details = $db->fetch_array($sql_select_carriers))
	{
		$template->set('carrier_details', $carrier_details);

		(string) $carrier_settings_rows = null;

		$background = ($counter++%2) ? 'c1' : 'c2';

		switch ($carrier_details['name'])
		{
			case 'USPS':
				$carrier_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . AMSG_USERNAME . '</td> '.
					'	<td><input name="usps_username" type="text" value="' . $carrier_setts['usps_username'] . '" size="50"></td> '.
					'</tr> ';
				$carrier_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . AMSG_USPS_CARRIER_EXPL . '</td> '.
					'</tr> ';
				break;
			case 'FedEx':
				$carrier_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . AMSG_ACCOUNT_NUMBER . '</td> '.
					'	<td><input name="fedex_account_number" type="text" value="' . $carrier_setts['fedex_account_number'] . '" size="50"></td> '.
					'</tr> ';
				$carrier_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . AMSG_METER_NUMBER . '</td> '.
					'	<td><input name="fedex_meter_number" type="text" value="' . $carrier_setts['fedex_meter_number'] . '" size="50"></td> '.
					'</tr> ';
				$carrier_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . AMSG_FEDEX_CARRIER_EXPL . '</td> '.
					'</tr> ';
				break;
			case 'UPS':
				$carrier_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . AMSG_UPS_CARRIER_EXPL . '</td> '.
					'</tr> ';
				break;
		}
		$template->set('carrier_settings_rows', $carrier_settings_rows);

		$carriers_table_rows .= $template->process('shipping_carriers_box.tpl.php');
	}

	$template->set('carriers_table_rows', $carriers_table_rows);

	$template_output .= $template->process('shipping_carriers.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>
