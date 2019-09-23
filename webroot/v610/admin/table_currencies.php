<?
#################################################################
## PHP Pro Bid v6.06															##
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

	if (isset($_POST['form_save_settings']))
	{

		$template->set('msg_changes_saved', $msg_changes_saved);

		$sql_update_default_currency = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
			currency='" . $_POST['currency'] . "'");

		$setts['currency'] = $_POST['currency'];

		if (count($_POST['currency_id']))
		{
			foreach ($_POST['currency_id'] as $key => $value)
			{
				$sql_update_currenices = $db->query("UPDATE " . DB_PREFIX . "currencies SET
					symbol='" . $db->rem_special_chars($_POST['symbol'][$key]) . "',
					currency_symbol='" . $db->rem_special_chars($_POST['currency_symbol'][$key]) . "',
					caption='" . $db->rem_special_chars($_POST['caption'][$key]) . "',
					convert_rate='" . $_POST['convert_rate'][$key] . "', convert_date=" . CURRENT_TIME . "  WHERE
					id=" . $value);
			}
		}

		if (!empty($_POST['new_symbol']))
		{
			$sql_insert_currency = $db->query("INSERT INTO " . DB_PREFIX . "currencies
				(symbol, currency_symbol, caption, convert_date) VALUES
				('" . $db->rem_special_chars($_POST['new_symbol']) . "', '" . $db->rem_special_chars($_POST['new_currency_symbol']) . "', 
				'" . $db->rem_special_chars($_POST['new_caption']) . "',	" . CURRENT_TIME . ")");
		}

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_currencies = $db->query("DELETE FROM " . DB_PREFIX . "currencies WHERE id IN (" . $delete_array . ")");
		}

		$sql_order_table = $db->query("ALTER TABLE " . DB_PREFIX . "currencies ORDER BY caption ASC");
	}

	(string) $default_currency_dropdown = null;
	(string) $currencies_page_content = NULL;

	$sql_select_currencies = $db->query("SELECT id, symbol, currency_symbol, caption, convert_rate, convert_date FROM
		" . DB_PREFIX . "currencies ORDER BY caption ASC");

	$default_currency_dropdown = '<select name="currency">';

	while ($currency_details = $db->fetch_array($sql_select_currencies))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$convert_readonly = ($setts['currency'] == $currency_details['symbol']) ? 'readonly' : '';

		$default_currency_dropdown .= '<option value="' . $currency_details['symbol'] . '" ' . (($currency_details['symbol'] == $setts['currency']) ? 'selected' : '') . '>' . $currency_details['caption'] . '</option>';

		$currencies_page_content .= '<input type="hidden" name="currency_id[]" value="' . $currency_details['id'] . '"> '.
			'<tr class="' . $background . '"> '.
      	'	<td><input name="symbol[]" type="text" value="' . $currency_details['symbol'] . '" size="8"></td> '.
      	'	<td><input name="currency_symbol[]" type="text" value="' . $currency_details['currency_symbol'] . '" size="8"></td> '.
      	'	<td><input name="caption[]" type="text" value="' . $currency_details['caption'] . '" size="40"></td> '.
      	'	<td align="center">1 ' . $setts['currency'] . ' = <input name="convert_rate[]" type="text" value="' . $currency_details['convert_rate'] . '" size="12" ' . $convert_readonly . '> ' . $currency_details['symbol'] . '</td> '.
      	'	<td align="center">' . show_date($currency_details['convert_date']) . '</td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $currency_details['id'] . '"></td> '.
			'</tr> ';
	}

	$default_currency_dropdown .= '</select>';

	$template->set('header_section', AMSG_FEES_MANAGEMENT);
	$template->set('subpage_title', AMSG_CURRENCY_SETTINGS);

	$template->set('default_currency_dropdown', $default_currency_dropdown);
	$template->set('currencies_page_content', $currencies_page_content);

	$template_output .= $template->process('table_currencies.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>