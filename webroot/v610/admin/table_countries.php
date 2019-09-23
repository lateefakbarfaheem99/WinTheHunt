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

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$parent_id = (!$_REQUEST['parent_id']) ? 0 : $_REQUEST['parent_id'];

	if (isset($_POST['form_save_settings']))
	{

		$template->set('msg_changes_saved', $msg_changes_saved);

		if (count($_POST['country_id']))
		{
			foreach ($_POST['country_id'] as $key => $value)
			{
				$country_order = ($_POST['country_order'][$key]>0 && $_POST['country_order'][$key]<1000) ? $_POST['country_order'][$key] : 1000;

				$sql_update_countries = $db->query("UPDATE " . DB_PREFIX . "countries SET
					name='" . $db->rem_special_chars($_POST['name'][$key]) . "', 
					country_iso_code='" . $db->rem_special_chars($_POST['country_iso_code'][$key]) . "', 
					country_order=" . $country_order . " WHERE
					id=" . $value);
			}
		}

		if (!empty($_POST['new_name']))
		{
			$sql_insert_country = $db->query("INSERT INTO " . DB_PREFIX . "countries (name, country_order, parent_id) VALUES
				('" . $db->rem_special_chars($_POST['new_name']) . "', 1000, " . $parent_id . ")");
		}

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_countries = $db->query_silent("DELETE c,s FROM " . DB_PREFIX . "countries c LEFT JOIN
				" . DB_PREFIX . "countries s ON s.parent_id=c.id WHERE
				c.id IN (" . $delete_array . ")");
			
			if (!$sql_delete_countries)
			{
				$db->query("DELETE FROM " . DB_PREFIX . "countries WHERE id IN (" . $delete_array . ")");
				$db->query("DELETE FROM " . DB_PREFIX . "countries WHERE parent_id IN (" . $delete_array . ")");
			}
		}
	}

	(string) $countries_page_content = NULL;

	$sql_select_countries = $db->query("SELECT id, name, country_order, country_iso_code FROM
		" . DB_PREFIX . "countries WHERE parent_id=" . $parent_id . " ORDER BY country_order ASC, name ASC");

	while ($country_details = $db->fetch_array($sql_select_countries))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';
		$order_value = ($country_details['country_order']>0 && $country_details['country_order']<1000) ? $country_details['country_order'] : '';

		$countries_page_content .= '<input type="hidden" name="country_id[]" value="' . $country_details['id'] . '"> '.
			'<tr class="' . $background . '"> '.
			'	<td> ';

		if (!$_REQUEST['parent_id'])
		{
			$countries_page_content .= '<a href="table_countries.php?parent_id=' . $country_details['id'] . '"> '.
			'		<img src="images/catplus.gif" alt="' . AMSG_EDIT_STATES . '" width="20" height="20" border="0"></a>';
		}

		$countries_page_content .= '</td> '.
      	'	<td><input name="name[]" type="text" value="' . $country_details['name'] . '" size="60"></td> '.
      	'	<td align="center"><input name="country_iso_code[]" type="text" value="' . $country_details['country_iso_code'] . '" size="10"></td>'.
			'	<td align="center"><input name="country_order[]" type="text" value="' . $order_value . '" size="8"></td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $country_details['id'] . '"></td> '.
			'</tr> ';
	}

	if ($parent_id)
	{
		(string) $state_header_message = null;

		$country_name = $db->get_sql_field("SELECT name FROM " . DB_PREFIX . "countries WHERE id=" . $parent_id, "name");

		$state_header_message = '<tr class="c2"><td style="padding: 3px;">' . AMSG_EDIT_STATES_FOR . ' ' . $country_name .
			' [ <a href="table_countries.php">' . GMSG_BACK . '</a> ]</td></tr>';

		$template->set('state_header_message', $state_header_message);
	}

	$template->set('header_section', AMSG_TABLES_MANAGEMENT);
	$template->set('subpage_title', AMSG_EDIT_COUNTRIES);

	$template->set('parent_id', $parent_id);
	$template->set('countries_page_content', $countries_page_content);

	$template_output .= $template->process('table_countries.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>