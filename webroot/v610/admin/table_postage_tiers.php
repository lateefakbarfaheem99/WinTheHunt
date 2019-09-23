<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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

	$tier_type = (in_array($_REQUEST['tier_type'], array('weight', 'amount'))) ? $_REQUEST['tier_type'] : 'weight';
	$template->set('tier_type', $tier_type);
	
	if (isset($_POST['form_save_settings']))
	{

		$template->set('msg_changes_saved', $msg_changes_saved);

		$post_details = convert_amount($_POST, 'STN');
		
		if (count($post_details['tier_id']))
		{
			foreach ($post_details['tier_id'] as $key => $value)
			{
				$sql_update_tiers = $db->query("UPDATE " . DB_PREFIX . "postage_calc_tiers SET
					tier_from='" . $post_details['tier_from'][$key] . "', tier_to='" . $post_details['tier_to'][$key] . "', 
					postage_amount='" . $post_details['postage_amount'][$key] . "' WHERE tier_id=" . $value);
			}
		}

		if ($post_details['new_tier_from'] >= 0 && $post_details['new_tier_to'] > 0 && $post_details['new_postage_amount'] > 0)
		{
			$sql_insert_tier = $db->query("INSERT INTO " . DB_PREFIX . "postage_calc_tiers (tier_from, tier_to, postage_amount, tier_type) VALUES
				('" . $post_details['new_tier_from'] . "', '" . $post_details['new_tier_to'] . "', '" . $post_details['new_postage_amount'] . "', '" . $tier_type . "')");
		}

		if (count($post_details['delete'])>0)
		{
			$delete_array = $db->implode_array($post_details['delete']);

			$sql_delete_increments = $db->query("DELETE FROM " . DB_PREFIX . "postage_calc_tiers WHERE
				tier_id IN (" . $delete_array . ")");
		}
	}

	(string) $postage_tiers_page_content = NULL;

	$sql_select_tiers = $db->query("SELECT * FROM
		" . DB_PREFIX . "postage_calc_tiers WHERE user_id=0 AND tier_type='" . $tier_type . "' ORDER BY tier_from ASC");

	while ($tier_details = $db->fetch_array($sql_select_tiers))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$tier_details = convert_amount($tier_details, 'NTS');
		
		$postage_tiers_page_content .= '<input type="hidden" name="tier_id[]" value="' . $tier_details['tier_id'] . '"> '.
			'<tr class="' . $background . '"> '.
			'	<td></td> '.
      	'	<td><input name="tier_from[]" type="text" value="' . $tier_details['tier_from'] . '" size="12"></td> '.
      	'	<td><input name="tier_to[]" type="text" value="' . $tier_details['tier_to'] . '" size="12"></td> '.
      	'	<td><input name="postage_amount[]" type="text" value="' . $tier_details['postage_amount'] . '" size="12"></td> '.
			'	<td align="center"><input type="checkbox" name="delete[]" value="' . $tier_details['tier_id'] . '"></td> '.
			'</tr> ';
	}

	$template->set('header_section', AMSG_TABLES_MANAGEMENT);
	$template->set('subpage_title', (($tier_type == 'weight') ? AMSG_EDIT_POSTAGE_TIERS_WEIGHT : AMSG_EDIT_POSTAGE_TIERS_AMOUNT));

	$template->set('postage_tiers_page_content', $postage_tiers_page_content);

	$template_output .= $template->process('table_postage_tiers.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>