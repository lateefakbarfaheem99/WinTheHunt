<?
#################################################################
## PHP Pro Bid v6.02															##
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

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if ($_REQUEST['operation'] == 'submit')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		if (count($_POST['tier_id']))
		{
			foreach ($_POST['tier_id'] as $key => $value)
			{
				$store_featured = ($_POST['store_featured'][$value] == $value) ? 1 : 0;
				
				$sql_update_tiers = $db->query("UPDATE " . DB_PREFIX . "fees_tiers SET
					fee_amount='" . $_POST['fee_amount'][$key] . "', store_nb_items='" . $_POST['store_nb_items'][$key] . "',
					store_recurring='" . $_POST['store_recurring'][$key] . "',
					store_name='" . $db->rem_special_chars($_POST['store_name'][$key]) . "', 
					store_featured='" . $store_featured . "' WHERE
					tier_id=" . $value);
			}
		}

		if (!empty($_POST['new_fee_amount']))
		{
			$sql_insert_tier = $db->query("INSERT INTO " . DB_PREFIX . "fees_tiers
				(fee_amount, calc_type, fee_type, store_nb_items, store_recurring, store_name) VALUES
				('" . $_POST['new_fee_amount'] . "', 'flat', 'store',
				'" . $_POST['new_store_nb_items'] . "', '" . $_POST['new_store_recurring'] . "',
				'" . $db->rem_special_chars($_POST['new_store_name']) . "')");
		}

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_tiers = $db->query("DELETE FROM " . DB_PREFIX . "fees_tiers WHERE tier_id IN (" . $delete_array . ")");
			
			/**
			 * v6.02 addition
			 * - if no store subscriptions are active, reset all users with shop_active=1 to shop_account_id=0
			 * - also, if there still are subscriptions active, then suspend the store subscriptions for the users 
			 * for which the subscription types have been removed
			 */
			
			$nb_subscriptions = $db->count_rows('fees_tiers', "WHERE fee_type='store'");
			
			if (!$nb_subscriptions)
			{
				$db->query("UPDATE " . DB_PREFIX . "users SET shop_account_id='0', shop_next_payment='0' WHERE
					shop_active='1'");
			}
			else 
			{
				$db->query("UPDATE " . DB_PREFIX . "users SET shop_active='0' WHERE 
					shop_active='1' AND shop_account_id IN (" . $delete_array . ")");
			}
		}
	}

	$template->set('header_section', AMSG_STORES_MANAGEMENT);
	$template->set('subpage_title', AMSG_STORE_SUBSCRIPTIONS_MANAGEMENT);

	$sql_select_tiers = $db->query("SELECT * FROM
		" . DB_PREFIX ."fees_tiers WHERE fee_type='store' ORDER BY fee_amount ASC");

	$template->set('fee_box_title', AMSG_STORE_SUBSCRIPTIONS_MANAGEMENT);

	(string) $stores_subscriptions_content = null;

	while ($tier_details = $db->fetch_array($sql_select_tiers))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$stores_subscriptions_content .= '<input type="hidden" name="tier_id[]" value="' . $tier_details['tier_id'] . '"> '.
			'<tr class="' . $background . '"> '.
			'	<td><input name="store_name[]" type="text" id="store_name[]" value="' . $tier_details['store_name'] . '" size="40"></td> '.
			'	<td align="center"><input name="store_nb_items[]" type="text" id="store_nb_items[]" value="' . $tier_details['store_nb_items'] . '" size="9"></td> '.
			'	<td align="center"><input name="fee_amount[]" type="text" id="fee_amount[]" value="' . $tier_details['fee_amount'] . '" size="9"></td> '.
			'	<td align="center"><input name="store_recurring[]" type="text" id="store_recurring[]" value="' . $tier_details['store_recurring'] . '" size="9"></td> '.
			'	<td align="center"><input type="checkbox" name="store_featured[' . $tier_details['tier_id'] . ']" value="' . $tier_details['tier_id'] . '" ' . (($tier_details['store_featured']) ? 'checked' : '') . '></td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $tier_details['tier_id'] . '"></td> '.
			'</tr>';
	}

	$template->set('stores_subscriptions_content', $stores_subscriptions_content);

	$template_output .= $template->process('stores_subscriptions.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>