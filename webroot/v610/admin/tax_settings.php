<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_formchecker.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (isset($_POST['form_save_settings']))
	{

		$template->set('msg_changes_saved', $msg_changes_saved);

		$sql_reset_site_tax = $db->query("UPDATE " . DB_PREFIX . "tax_settings SET site_tax = 0");
		$sql_update_site_tax = $db->query("UPDATE " . DB_PREFIX . "tax_settings SET site_tax = 1 WHERE tax_id=" . intval($_POST['site_tax']));
	}
	
	## generate the countries/states interactive selection boxes
	if ($_REQUEST['do'] == 'add_tax' || $_REQUEST['do'] == 'edit_tax')
	{
		(string) $all_countries_table = null;
		(string) $selected_countries_table = null;

		if ($_REQUEST['do'] == 'edit_tax')
		{
			$row_tax = $db->get_sql_row("SELECT tax_id, tax_name, amount, countries_id, tax_user_types, seller_countries_id FROM
				" . DB_PREFIX ."tax_settings WHERE tax_id=" . $_REQUEST['tax_id']);
		}

		/* seller countries tables */
		$selected_countries_seller = (!empty($row_tax['seller_countries_id'])) ? $row_tax['seller_countries_id'] : 0;

		$sql_select_all_countries_seller = $db->query("SELECT c.id, c.name, s.id AS state_id, s.name AS state_name, s.parent_id FROM
			" . DB_PREFIX . "countries c LEFT JOIN " . DB_PREFIX . "countries s ON c.id=s.parent_id AND s.id NOT IN (".$selected_countries_seller.")  WHERE
			(c.id NOT IN (".$selected_countries_seller.")) AND c.parent_id=0 ORDER BY c.country_order ASC, c.name ASC");

		$all_countries_table_seller = '<select name="seller_all_countries" size="15" multiple="multiple" id="seller_all_countries" style="width: 100%;">';

		while ($all_countries_seller_details = $db->fetch_array($sql_select_all_countries_seller))
		{
			$country_id = ($all_countries_seller_details['state_id']) ? $all_countries_seller_details['state_id'] : $all_countries_seller_details['id'];
			$country_name = $all_countries_seller_details['name'] . (($all_countries_seller_details['state_id']) ? ' - ' . $all_countries_seller_details['state_name'] : '');

			$all_countries_table_seller .= '<option value="' . $country_id . '">' . $country_name . '</option>';
		}

		$all_countries_table_seller .= '</select>';

		$sql_select_selected_countries_seller = $db->query("SELECT c.id, c.name, s.id AS state_id, s.name AS state_name, s.parent_id FROM
			" . DB_PREFIX . "countries c LEFT JOIN " . DB_PREFIX . "countries s ON c.id=s.parent_id WHERE
			(c.id IN (".$selected_countries_seller.") OR s.id IN (".$selected_countries_seller.")) AND c.parent_id=0 ORDER BY c.country_order ASC, c.name ASC");

		$selected_countries_table_seller ='<select name="seller_countries_id[]" size="15" multiple="multiple" id="seller_countries_id" style="width: 100%;"> ';

		while ($selected_countries_seller_details = $db->fetch_array($sql_select_selected_countries_seller))
		{
			$country_id = ($selected_countries_seller_details['state_id']) ? $selected_countries_seller_details['state_id'] : $selected_countries_seller_details['id'];
			$country_name = $selected_countries_seller_details['name'] . (($selected_countries_seller_details['state_id']) ? ' - ' . $selected_countries_seller_details['state_name'] : '');
			
			$selected_countries_table_seller .= '<option value="' . $country_id . '" selected>' . $country_name . '</option>';
		}

		$selected_countries_table_seller .= '</select>';
		
		/* buyer countries tables */
		$selected_countries = (!empty($row_tax['countries_id'])) ? $row_tax['countries_id'] : 0;

		$sql_select_all_countries = $db->query("SELECT c.id, c.name, s.id AS state_id, s.name AS state_name, s.parent_id FROM
			" . DB_PREFIX . "countries c LEFT JOIN " . DB_PREFIX . "countries s ON c.id=s.parent_id AND s.id NOT IN (".$selected_countries.") WHERE
			(c.id NOT IN (".$selected_countries.")) AND c.parent_id=0 ORDER BY c.country_order ASC, c.name ASC");

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

		(string) $tax_settings_allowed_users_box = null;

		$tax_user_types = array(
			1 => array('a', AMSG_TAX_BUSINESS_WITH_TAX_NB),
			2 => array('b', AMSG_TAX_BUSINESS_WITHOUT_TAX_NB),
			3 => array('c', AMSG_TAX_INDIVIDUAL_WITH_TAX_NB),
			4 => array('d', AMSG_TAX_INDIVIDUAL_WITHOUT_TAX_NB)
		);

		foreach ($tax_user_types as $value)
		{
			$box_checked = stristr($row_tax['tax_user_types'], $value[0]) ? 'checked' : '';

			$tax_settings_allowed_users_box_array[] = '<input type="checkbox" name="tax_user_types[]" value="' . $value[0] . '" ' . $box_checked . '> ' . $value[1];
		}

		$tax_settings_allowed_users_box = $db->implode_array($tax_settings_allowed_users_box_array, '<br>');

		$template->set('all_countries_table_seller', $all_countries_table_seller);
		$template->set('selected_countries_table_seller', $selected_countries_table_seller);
		$template->set('all_countries_table', $all_countries_table);
		$template->set('selected_countries_table', $selected_countries_table);
		$template->set('tax_settings_allowed_users_box', $tax_settings_allowed_users_box);
	}

	if ($_REQUEST['do'] == 'add_tax')
	{
		if ($_REQUEST['operation'] == 'submit')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$countries_id = $db->implode_array($_POST['countries_id']);
			$seller_countries_id = $db->implode_array($_POST['seller_countries_id']);

			$tax_user_types = $db->implode_array($_POST['tax_user_types']);

			$sql_insert_tax = $db->query("INSERT INTO " . DB_PREFIX . "tax_settings
				(tax_name, amount, countries_id, tax_user_types, seller_countries_id) VALUES
				('" . $db->rem_special_chars($_POST['tax_name']) . "', '" . $_POST['amount'] . "',
				'" . $countries_id . "', '" . $tax_user_types . "', '" . $seller_countries_id . "')");
		}
		else
		{
			$template->set('tax_details', $_POST);
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_ADD_TAX);

			$management_box = $template->process('tax_settings_add_tax.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'edit_tax')
	{
		if ($_REQUEST['operation'] == 'submit')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$seller_countries_id = $db->implode_array($_POST['seller_countries_id']);
			$countries_id = $db->implode_array($_POST['countries_id']);

			$tax_user_types = $db->implode_array($_POST['tax_user_types']);

			$sql_update_tax = $db->query("UPDATE " . DB_PREFIX . "tax_settings SET
				tax_name='" . $db->rem_special_chars($_POST['tax_name']) . "',
				amount='" . $_POST['amount'] . "', countries_id='" . $countries_id . "',
				tax_user_types='" . $tax_user_types . "', seller_countries_id='" . $seller_countries_id . "' WHERE tax_id=" . $_POST['tax_id']);
		}
		else
		{
			$template->set('tax_details', $row_tax);
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_EDIT_TAX);

			$management_box = $template->process('tax_settings_add_tax.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'delete_tax')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		$sql_delete_tax = $db->query("DELETE FROM " . DB_PREFIX . "tax_settings WHERE tax_id=" . intval($_GET['tax_id']));
	}

	$template->set('management_box', $management_box);

	$sql_select_tax_settings = $db->query("SELECT tax_id, tax_name, amount, countries_id, tax_user_types, site_tax, seller_countries_id FROM
		" . DB_PREFIX ."tax_settings");

	$tax = new tax();

	while ($tax_details = $db->fetch_array($sql_select_tax_settings))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$seller_countries = $tax->display_countries($tax_details['seller_countries_id']);
		$seller_countries = (!$seller_countries) ? GMSG_NA : $seller_countries;
		
		$tax_settings_content .= '<input type="hidden" name="tax_id[]" value="' . $tax_details['tax_id'] . '"> '.
			'<tr class="' . $background . '"> '.
      	'	<td>' . $tax_details['tax_name'] . '</td> '.
      	'	<td>' . $tax_details['amount'] . '%</td> '.
      	'	<td>' . $seller_countries . '</td> '.
      	'	<td>' . $tax->display_countries($tax_details['countries_id']) . '</td> '.
      	'	<td align="center"><input type="radio" name="site_tax" value="' . $tax_details['tax_id'] . '" ' . (($tax_details['site_tax']) ? 'checked' : '') . '></td> '.
      	'	<td align="center"> '.
			'		[ <a href="tax_settings.php?do=edit_tax&tax_id=' . $tax_details['tax_id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
			'		[ <a href="tax_settings.php?do=delete_tax&tax_id=' . $tax_details['tax_id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
			'</tr> ';
	}

	$template->set('tax_settings_content', $tax_settings_content);


	$template->set('header_section', AMSG_TAX_SETTINGS);
	$template->set('subpage_title', AMSG_TAX_CONFIGURATION);

	$template_output .= $template->process('tax_settings.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>