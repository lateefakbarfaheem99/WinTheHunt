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

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (stristr($_REQUEST['category_id'], 'reverse') !== false)
	{
		list($fee_type, $category_id) = @explode('|', $_REQUEST['category_id']);
	}
	else 
	{
		$fee_type = $_REQUEST['fee_type'];
		$category_id = $_REQUEST['category_id'];
	}
	$category_id = intval($category_id);
	$category_id = ($fee_type == 'reverse' && $category_id > 0) ? (-1) * $category_id : $category_id;			
	
	if ($_REQUEST['operation'] == 'submit')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		if ($_REQUEST['tiers'] == 1)
		{
			if (count($_POST['tier_id']))
			{
				foreach ($_POST['tier_id'] as $key => $value)
				{
					$sql_update_tiers = $db->query("UPDATE " . DB_PREFIX . "fees_tiers SET
						fee_from='" . $_POST['fee_from'][$key] . "', fee_to='" . $_POST['fee_to'][$key] . "',
						fee_amount='" . $_POST['fee_amount'][$key] . "', calc_type='" . $_POST['calc_type'][$key] . "' WHERE
						tier_id=" . $value);
				}
			}

			if (!empty($_POST['new_fee_amount']))
			{
				$sql_insert_tier = $db->query("INSERT INTO " . DB_PREFIX . "fees_tiers
					(fee_from, fee_to, fee_amount, calc_type, category_id, fee_type) VALUES
					('" . $_POST['new_fee_from'] . "', '" . $_POST['new_fee_to'] . "', '" . $_POST['new_fee_amount'] . "',
					'" . $_POST['new_calc_type'] . "', " . $category_id . ", '" . $_POST['fee_column'] . "')");
			}

			if (count($_POST['delete'])>0)
			{
				$delete_array = $db->implode_array($_POST['delete']);

				$sql_delete_tiers = $db->query("DELETE FROM " . DB_PREFIX . "fees_tiers WHERE tier_id IN (" . $delete_array . ")");
			}
		}

		if ($_REQUEST['tiers'] !=1 || $_REQUEST['fee_column'] == 'endauction' || $_REQUEST['fee_column'] == 'reverse_endauction')
		{
			$is_fee_row = $db->count_rows('fees', "WHERE category_id=" . $category_id);

			if (!$is_fee_row)
			{
				$sql_insert_fee = $db->query("INSERT INTO " . DB_PREFIX . "fees
					(category_id) VALUES (" . $category_id . ")");
			}

			if ($fee_type == 'reverse' && $category_id <= 0)
			{
				$reverse_fees = $db->get_sql_field("SELECT reverse_fees FROM " . DB_PREFIX . "fees WHERE 
					category_id='" . $category_id . "'", 'reverse_fees');
				
				$reverse_fees = unserialize($reverse_fees);
				
				if ($_REQUEST['fee_column'] == 'reverse_endauction')
				{
					$reverse_fees['endauction_fee_applies'] = $_REQUEST['value'];
					$reverse_fees['endauction_calc_type'] = intval($_REQUEST['endauction_calc_type']);
				}
				else 
				{
					$reverse_fees[$_REQUEST['fee_column']] = number_format(doubleval($_REQUEST['value']), 2);
					
					if ($_REQUEST['fee_column'] == 'picture_fee')
					{
						$reverse_fees['free_images'] = intval($_REQUEST['free_images']);
					}
					else if ($_REQUEST['fee_column'] == 'video_fee')
					{
						$reverse_fees['free_media'] = intval($_REQUEST['free_media']);
					}
				}
				
				$db->query("UPDATE " . DB_PREFIX . "fees SET reverse_fees='" . serialize($reverse_fees) . "' WHERE 
					category_id='" . $category_id . "'");
			}
			else 
			{
				$fee_column = ($_REQUEST['fee_column'] == 'endauction') ? 'endauction_fee_applies' : $_REQUEST['fee_column'];
	
				if ($fee_column == 'durations_fee')
				{
					$fee_value = serialize_duration_fees($_REQUEST);
				}
				else 
				{
					$fee_value = $_REQUEST['value'];					
				}
				
				$sql_update_fee = $db->query("UPDATE " . DB_PREFIX . "fees SET
					" . $fee_column . "='" . $fee_value . "', 
					endauction_calc_type='" . intval($_REQUEST['endauction_calc_type']) . "'  
					" . (($fee_column == 'picture_fee') ? ", free_images=" . intval($_REQUEST['free_images']) : '') . " 
					" . (($fee_column == 'video_fee') ? ", free_media=" . intval($_REQUEST['free_media']) : '') . " 
					" . (($fee_column == 'swap_fee') ? ", swap_fee_calc_type='" . $_REQUEST['swap_fee_calc_type'] . "'" : '') . " 
					WHERE category_id=" . $category_id);
			}
		}
	}

	$template->set('header_section', AMSG_FEES);
	$template->set('subpage_title', AMSG_FEES_MANAGEMENT);

	(string) $categories_list_menu = null;

	$categories_list_menu = categories_list ($category_id, 0, true, true);

	$template->set('categories_list_menu', $categories_list_menu);
	$template->set('fee_type', $fee_type);

	if (isset($category_id))
	{
		$template->set('category_id', $category_id);

		$fees_table = $template->process('fees_management_fees_table.tpl.php');

		$template->set('fees_table', $fees_table);
	}

	if (isset($_REQUEST['fee_column']))
	{
		$fee_row = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "fees WHERE category_id=" . $category_id);

		if ($fee_type == 'reverse')
		{
			$fee_row = unserialize($fee_row['reverse_fees']);
		}
		
		$template->set('fee', $fee_row);

		$template->set('fee_column', $_REQUEST['fee_column']);

		if ($_REQUEST['tiers'] == 1)
		{

			$sql_select_tiers = $db->query("SELECT tier_id, fee_from, fee_to, fee_amount, calc_type, category_id FROM
				" . DB_PREFIX ."fees_tiers WHERE fee_type='".$_REQUEST['fee_column']."' AND category_id=" . $category_id. " ORDER BY fee_from ASC");

			switch ($_REQUEST['fee_column'])
			{
				case 'setup':
					$fee_box_title =  GMSG_SETUP_FEE;
					break;
				case 'endauction':
					$fee_box_title = GMSG_ENDAUCTION_FEE;
					break;
				case 'reverse_endauction':
					$fee_box_title = GMSG_ENDAUCTION_FEE;
					break;
			}

			$template->set('fee_box_title', $fee_box_title);

			(string) $fees_tiers_content = null;

			while ($tier_details = $db->fetch_array($sql_select_tiers))
			{
				$background = ($counter++%2) ? 'c1' : 'c2';

				$fees_tiers_content .= '<input type="hidden" name="tier_id[]" value="' . $tier_details['tier_id'] . '"> '.
      			'<tr class="' . $background . '"> '.
         		'	<td><input name="fee_from[]" type="text" id="fee_from[]" value="' . $tier_details['fee_from'] . '" size="9"></td> '.
         		'	<td><input name="fee_to[]" type="text" id="fee_to[]" value="' . $tier_details['fee_to'] . '" size="9"></td> '.
         		'	<td><input name="fee_amount[]" type="text" id="fee_amount[]" value="' . $tier_details['fee_amount'] . '" size="9"></td> '.
					'	<td><select name="calc_type[]" id="calc_type[]"> '.
               '			<option value="flat" selected>' . GMSG_FLAT . '</option> '.
               '			<option value="percent" ' . (($tier_details['calc_type']== 'percent') ? 'selected' : '') . '>' . GMSG_PERCENT . '</option> '.
					'		</select></td> '.
         		'	<td align="center"><input type="checkbox" name="delete[]" value="' . $tier_details['tier_id'] . '"></td> '.
      			'</tr>';
			}

			$template->set('fees_tiers_content', $fees_tiers_content);

			$fees_box = $template->process('fees_management_fee_box_tiers.tpl.php');

			$template->set('fees_box', $fees_box);
		}
		else
		{
			switch ($_REQUEST['fee_column'])
			{
				case 'setup':
					$fee_box_title =  GMSG_SETUP_FEE;
					$fee_description = AMSG_SETUP_FEE_DESC;
					break;
				case 'signup_fee':
					$fee_box_title = GMSG_USER_SIGNUP_FEE;
					$fee_description = AMSG_USER_SIGNUP_FEE_DESC;
					break;
				case 'hpfeat_fee':
					$fee_box_title = GMSG_HPFEAT_FEE;
					$fee_description = AMSG_HPFEAT_FEE_DESC;
					break;
				case 'catfeat_fee':
					$fee_box_title = GMSG_CATFEAT_FEE;
					$fee_description = AMSG_CATFEAT_FEE_DESC;
					break;
				case 'hlitem_fee':
					$fee_box_title = GMSG_HL_FEE;
					$fee_description = AMSG_HL_FEE_DESC;
					break;
				case 'bolditem_fee':
					$fee_box_title = GMSG_BOLD_FEE;
					$fee_description = AMSG_BOLD_FEE_DESC;
					break;
				case 'picture_fee':
					$fee_box_title = GMSG_IMG_UPL_FEE;
					$fee_description = AMSG_IMG_UPL_FEE_DESC;
					break;
				case 'video_fee':
					$fee_box_title = GMSG_MEDIA_UPL_FEE;
					$fee_description = AMSG_MEDIA_UPL_FEE_DESC;
					break;
				case 'second_cat_fee':
					$fee_box_title = GMSG_ADDLCAT_FEE;
					$fee_description = AMSG_ADDLCAT_FEE_DESC;
					break;
				case 'custom_start_fee':
					$fee_box_title = GMSG_CUSTOM_START_FEE;
					$fee_description = AMSG_CUSTOM_START_FEE_DESC;
					break;
				case 'buyout_fee':
					$fee_box_title = GMSG_BUYOUT_FEE;
					$fee_description = AMSG_BUYOUT_FEE_DESC;
					break;
				case 'rp_fee':
					$fee_box_title = GMSG_RP_FEE;
					$fee_description = AMSG_RP_FEE_DESC;
					break;
				case 'relist_fee_reduction':
					$fee_box_title = GMSG_REL_FEES_RED_FEE;
					$fee_description = AMSG_REL_FEES_RED_FEE_DESC;
					break;
				case 'wanted_ad_fee':
					$fee_box_title = GMSG_WA_SETUP_FEE;
					$fee_description = AMSG_WA_SETUP_FEE_DESC;
					break;
				case 'endauction':
					$fee_description = AMSG_ENDAUCTION_FEE_APPLIES;
					break;
				case 'makeoffer_fee':
					$fee_box_title = GMSG_MAKEOFFER_FEE;
					$fee_description = AMSG_MAKEOFFER_FEE_DESC;
					break;
				case 'swap_fee':
					$fee_box_title = GMSG_SWAP_FEE;
					$fee_description = AMSG_SWAP_FEE_DESC;
					break;
				case 'dd_fee':
					$fee_box_title = GMSG_DD_FEE;
					$fee_description = AMSG_DD_FEE_DESC;
					break;
				case 'bid_fee':
					$fee_box_title = GMSG_REVERSE_BID_FEE;
					$fee_description = AMSG_REVERSE_BID_FEE_DESC;
					break;
				case 'durations_fee':
					$fee_box_title = GMSG_DURATIONS_FEE;
					$fee_description = AMSG_DURATIONS_FEE_DESC;
					break;					
			}

			$template->set('fee_box_title', $fee_box_title);
			$template->set('fee_description', $fee_description);
			
			$fees_box .= $template->process('fees_management_fee_box_no_tiers.tpl.php');

			$template->set('fees_box', $fees_box);
		}
	}

	$template_output .= $template->process('fees_management.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>