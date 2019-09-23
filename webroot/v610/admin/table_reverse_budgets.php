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
include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_fees.php');
include_once ('../includes/class_item.php');

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

		if (count($_POST['increment_id']))
		{
			foreach ($_POST['increment_id'] as $key => $value)
			{
				$order_id = intval($_POST['order_id'][$key]);
				
				$order_id = ($order_id>=0 && $order_id<10000) ? $order_id : 10000;
				
				$sql_update_budgets = $db->query("UPDATE " . DB_PREFIX . "reverse_budgets SET
					value_from='" . $_POST['value_from'][$key] . "', value_to='" . $_POST['value_to'][$key] . "', 
					order_id='" . $order_id . "' WHERE id=" . $value);
			}
		}

		if ($_POST['new_value_from'] > 0 || $_POST['new_value_to'] > 0)
		{
			$sql_insert_budget = $db->query("INSERT INTO " . DB_PREFIX . "reverse_budgets (value_from, value_to) VALUES
				('" . $_POST['new_value_from'] . "', '" . $_POST['new_value_to'] . "')");
		}

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_increments = $db->query("DELETE FROM " . DB_PREFIX . "reverse_budgets WHERE
				id IN (" . $delete_array . ")");
		}
	}

	(string) $budgets_page_content = NULL;

	$sql_select_budgets = $db->query("SELECT * FROM
		" . DB_PREFIX . "reverse_budgets ORDER BY order_id ASC, value_from ASC");

	while ($budget_details = $db->fetch_array($sql_select_budgets))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$order_value = ($budget_details['order_id']>0 && $budget_details['order_id']<1000) ? $budget_details['order_id'] : '';
		
		$budgets_page_content .= '<input type="hidden" name="increment_id[]" value="' . $budget_details['id'] . '"> '.
			'<tr class="' . $background . '"> '.
			'	<td></td> '.
      	'	<td><input name="value_from[]" type="text" value="' . $budget_details['value_from'] . '" size="12"></td> '.
      	'	<td><input name="value_to[]" type="text" value="' . $budget_details['value_to'] . '" size="12"></td> '.
      	'	<td><input name="order_id[]" type="text" value="' . $order_value . '" size="12"></td> '.
      	'	<td>' . $fees->budget_output($budget_details['id'], $budget_details) . '</td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $budget_details['id'] . '"></td> '.
			'</tr> ';
	}

	$template->set('header_section', AMSG_REVERSE_AUCTIONS_MANAGEMENT);
	$template->set('subpage_title', AMSG_EDIT_BUDGETS_TABLE);

	$template->set('budgets_page_content', $budgets_page_content);

	$template_output .= $template->process('table_reverse_budgets.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>