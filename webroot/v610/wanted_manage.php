<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_user.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_item.php');
include_once ('includes/functions_item.php');

if ($session->value('membersarea')!='Active')
{
	if ($session->value('user_id')) /* user inactive - redirect to account management page */
	{
		header_redirect('members_area.php?page=account&section_management');
	}
	else
	{
		header_redirect('login.php');
	}
}
else
{
	require ('global_header.php');

	(array) $user_details = null;
	(string) $page_handle = 'wanted_ad';

	$start_time_id = 1;
	$end_time_id = 2;

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;

	$sell_item_header = '<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border"> ' .
		'<tr><td class="c3"><b>' . (($_REQUEST['do'] == 'edit') ? MSG_EDIT_WANTED_AD : MSG_SUBMIT_WANTED_AD) . '</b></td></tr></table>';

	/**
	 * We create a temporary row in the items table for every ad that is made. If the ad is placed, this temporary row
	 * will become the final ad row.
	 */
	if ($session->value('user_id'))
	{
		$user_details = $db->get_sql_row("SELECT user_id, username, shop_account_id, shop_categories,
			shop_active, preferred_seller, reg_date, country, state, zip_code, balance,
			default_name, default_description, default_duration, default_hidden_bidding,
			default_enable_swap, default_shipping_method, default_shipping_int, default_postage_amount,
			default_insurance_amount, default_type_service, default_shipping_details, default_payment_methods FROM
			" . DB_PREFIX . "users WHERE user_id=" . $session->value('user_id'));
	}

	$setup_fee = new fees();
	$setup_fee->setts = &$setts;

	$frmchk_error = false;

	$custom_fld = new custom_field();

	if ($_REQUEST['do'] == 'edit')
	{
		$item_details = $db->get_sql_row("SELECT * FROM
			" . DB_PREFIX . "wanted_ads WHERE wanted_ad_id='" . intval($_REQUEST['wanted_ad_id']) . "' AND owner_id=" . $session->value('user_id'));
		
		$template->set('old_category_id', $item_details['category_id']);
		$template->set('old_addl_category_id', $item_details['addl_category_id']);
		
	}
	else if (!$session->is_set('wanted_ad_id'))
	{
		$session->set('wanted_ad_id', $item->create_temporary_wanted_ad($session->value('user_id')));
		$item_details['wanted_ad_id'] = $session->value('wanted_ad_id');
	}
	else if ($session->is_set('wanted_ad_id'))
	{
		$item_details['wanted_ad_id'] = $session->value('wanted_ad_id');		
	}

	if ($_REQUEST['edit_option'] == 'new')
	{
		## first we remove the auction media for any upload_in_progress = 1.
		$sql_select_media = $db->query("SELECT am.* FROM " . DB_PREFIX . "auction_media am, " . DB_PREFIX . "wanted_ads w WHERE
			w.wanted_ad_id=am.wanted_ad_id AND w.owner_id='" . $session->value('user_id') . "' AND
			am.wanted_ad_id='" . $item_details['wanted_ad_id'] . "' AND am.upload_in_progress=1 ORDER BY am.media_id ASC");

		while ($media_details = $db->fetch_array($sql_select_media))
		{
			$item_details['auction_id'] = $media_details['auction_id'];

			if ($media_details['media_type'] == 1)
			{
				$item_details['ad_image'][0] = $media_details['media_url'];
			}
			else
			{
				$item_details['ad_video'][0] = $media_details['media_url'];
			}

			$item->media_removal($item_details, $media_details['media_type'], 0);
		}
	}

	if ($_REQUEST['box_submit'] == 1 || isset($_REQUEST['form_edit_proceed']))
	{
		$item_details = $_POST;
		$item_details['description'] = $db->rem_special_chars(((!empty($_POST['description_main'])) ? $_POST['description_main'] : $item_details['description']));
		$custom_fld->save_vars($_POST);
	}
	else
	{
		$custom_fld->save_edit_vars($item_details['wanted_ad_id'], 'wanted_ad');
		
		## upload initial images
		$media_details = $item->get_media_values($item_details['wanted_ad_id'], true);
		$item_details['ad_image'] = $media_details['ad_image'];
		$item_details['ad_video'] = $media_details['ad_video'];
	}

	$item_details['country'] = (!empty($item_details['country'])) ? $item_details['country'] : $user_details['country'];
	$item_details['state'] = (!empty($item_details['state'])) ? $item_details['state'] : $user_details['state'];
	$item_details['zip_code'] = (!empty($item_details['zip_code'])) ? $item_details['zip_code'] : $user_details['zip_code'];

	if (isset($_REQUEST['form_edit_proceed']))
	{
		define ('FRMCHK_ITEM', 1);
		$frmchk_details = $item_details;

		include ('includes/procedure_frmchk_wanted_ad.php'); /* Formchecker for wanted ad creation/edit */

		if ($fv->is_error())
		{
			$template->set('display_formcheck_errors', $fv->display_errors());
			$frmchk_error = true;
		}
		else
		{
			$form_submitted = true;

			$template->set('message_header', $sell_item_header);

			if ($session->value('wa_refresh_id') == $item_details['wanted_ad_id'])
			{
				$template->set('message_content', '<p align="center" class="contentfont">' . MSG_DOUBLE_POST_ERROR . '</p>');
			}
			else
			{
				$edit_wa = ($_REQUEST['do'] == 'edit') ? true : false;

				## item update function call
				$item->insert_wanted_ad($item_details, $session->value('user_id'), 'wanted_ad', $edit_wa);

				$setup_fee = new fees();
				$setup_fee->setts = &$setts;

				$setup_result = $setup_fee->wanted_ad_setup($user_details, $item_details, $edit_wa);
				
				if ($edit_wa)
				{
					$old_category_id = intval($_REQUEST['old_category_id']);
					$old_addl_category_id = intval($_REQUEST['old_addl_category_id']);

					if ($old_category_id != $item_details['category_id'])
					{
						wanted_counter($old_category_id, 'remove');					
						wanted_counter($item_details['category_id'], 'add');
					}
					if ($old_addl_category_id != $item_details['addl_category_id'])
					{
						wanted_counter($old_addl_category_id, 'remove');					
						wanted_counter($item_details['addl_category_id'], 'add');
					}
				}
				
				$session->set('wa_refresh_id', $item_details['wanted_ad_id']);

				$template->set('message_content', $setup_result['display']);
			}

			$template_output .= $template->process('single_message.tpl.php');
		}
	}

	if (!$form_submitted)
	{ ## <<BEGIN>> media upload sequence
		if (empty($_POST['file_upload_type']))
		{
			$template->set('media_upload_fields', $item->upload_manager($item_details));
		}
		else if (is_numeric($_POST['file_upload_id'])) /* means we remove a file / media url */
		{
			$media_upload = $item->media_removal($item_details, $item_details['file_upload_type'], $item_details['file_upload_id']);
			$media_upload_fields = $media_upload['display_output'];

			$item_details['ad_image'] = $media_upload['post_details']['ad_image'];
			$item_details['ad_video'] = $media_upload['post_details']['ad_video'];

			$template->set('media_upload_fields', $media_upload_fields);
		}
		else /* means we have a file upload */
		{
			$media_upload = $item->media_upload($item_details, $item_details['file_upload_type'], $_FILES);
			$media_upload_fields = $media_upload['display_output'];

			$item_details['ad_image'] = $media_upload['post_details']['ad_image'];
			$item_details['ad_video'] = $media_upload['post_details']['ad_video'];

			$template->set('media_upload_fields', $media_upload_fields);
		}## <<END>> media upload sequence

		$template->set('do', $_REQUEST['do']);
		$template->set('item_details', $item_details);
		$template->set('user_details', $user_details);

		$template->set('sell_item_header', $sell_item_header);

		$template->set('post_url', 'wanted_manage.php');
		## BEGIN pages upload
		## 1.- details section
		$item_description_editor = "<script> \n" .
			" 	var oEdit1 = new InnovaEditor(\"oEdit1\"); \n" .
			" 	oEdit1.width=\"100%\";//You can also use %, for example: oEdit1.width=\"100%\" \n" .
			"	oEdit1.height=300; \n" .
			"	oEdit1.REPLACE(\"description_main\");//Specify the id of the textarea here \n" .
			"</script>";

		$template->set('item_description_editor', $item_description_editor);

		$template->set('main_category_display', category_navigator($item_details['category_id'], false, true, null, null, GMSG_NONE_CAT));
		$template->set('addl_category_display', category_navigator($item_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT));

		$template->set('duration_drop_down', $item->durations_drop_down('duration', $item_details['duration']));

		$custom_fld->new_table = false;
		$custom_fld->field_colspan = 2;
		$custom_sections_table = $custom_fld->display_sections($item_details, $page_handle);

		$template->set('custom_sections_table', $custom_sections_table);

		$image_upload_manager = $item->upload_manager($item_details, 1, 'ad_create_form', true, false, true, $picture_fee_expl_message);
		$template->set('image_upload_manager', $image_upload_manager);

		$tax = new tax();
		$template->set('country_dropdown', $tax->countries_dropdown('country', $item_details['country'], 'ad_create_form', 'setup'));
		$template->set('state_box', $tax->states_box('state', $item_details['state'], $item_details['country']));

		$wa_fee = $setup_fee->display_fee('wanted_ad_fee', $user_details, $item_details['category_id'], 'auction');
		$template->set('setup_fee_expl_message', $wa_fee['display_short']);
		
		$template_output .= $template->process('wanted_manage.tpl.php');
	}

	include_once ('global_footer.php');

	echo $template_output;
}
?>