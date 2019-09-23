<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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

	$reverse_id = intval($_REQUEST['reverse_id']);
	
	(array) $user_details = null;
	(string) $page_handle = 'reverse';

	$start_time_id = 1;
	$end_time_id = 2;

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	$item->setts['max_dd'] = $setts['max_additional_files'];
	
	$reverse_fee = new fees(true);
	$reverse_fee->setts = &$setts;
	$reverse_fee->reverse_auction = true;	

	$sell_item_header = '<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border"> ' .
		'<tr><td class="c3"><b>' . (($_REQUEST['do'] == 'edit') ? MSG_EDIT_REVERSE : MSG_SUBMIT_REVERSE) . '</b></td></tr></table>';

	/**
	 * We create a temporary row in the items table for every ad that is made. If the ad is placed, this temporary row
	 * will become the final ad row.
	 */
	if ($session->value('user_id'))
	{
		$user_details = $db->get_sql_row("SELECT * FROM
			" . DB_PREFIX . "users WHERE user_id=" . $session->value('user_id'));
	}

	$frmchk_error = false;

	$custom_fld = new custom_field();

	$auction_edit = false;
	if ($_REQUEST['do'] == 'edit')
	{
		$item_details = $db->get_sql_row("SELECT * FROM
			" . DB_PREFIX . "reverse_auctions WHERE reverse_id='" . $reverse_id . "' AND owner_id=" . $session->value('user_id'));
		$start_time = $item_details['start_time'];
		
		$template->set('old_category_id', $item_details['category_id']);
		$template->set('old_addl_category_id', $item_details['addl_category_id']);
		
		$auction_edit = true;
		$template->set('auction_edit', $auction_edit);
		
	}
	else if (!$session->is_set('reverse_id'))
	{
		$session->set('reverse_id', $item->create_temporary_reverse($session->value('user_id')));
		$item_details['reverse_id'] = $session->value('reverse_id');
	}
	else if ($session->is_set('reverse_id'))
	{
		$item_details['reverse_id'] = $session->value('reverse_id');		
	}

	if ($_REQUEST['edit_option'] == 'new')
	{
		## first we remove the auction media for any upload_in_progress = 1.
		$sql_select_media = $db->query("SELECT am.* FROM " . DB_PREFIX . "auction_media am, " . DB_PREFIX . "reverse_auctions r WHERE
			r.reverse_id=am.reverse_id AND r.owner_id='" . $session->value('user_id') . "' AND
			am.reverse_id='" . $item_details['reverse_id'] . "' AND am.upload_in_progress=1 ORDER BY am.media_id ASC");

		while ($media_details = $db->fetch_array($sql_select_media))
		{
			$item_details['auction_id'] = $media_details['auction_id'];

			if ($media_details['media_type'] == 1)
			{
				$item_details['ad_image'][0] = $media_details['media_url'];
			}
			else if ($media_details['media_type'] == 2)
			{
				$item_details['ad_video'][0] = $media_details['media_url'];
			}
			else if ($media_details['media_type'] == 3)
			{
				$item_details['ad_dd'][0] = $media_details['media_url'];
			}

			$item->media_removal($item_details, $media_details['media_type'], 0);
		}
	}

	if ($_REQUEST['box_submit'] == 1 || isset($_REQUEST['form_edit_proceed']))
	{
		$item_details = $_POST;
		$item_details['description'] = $db->rem_special_chars(((!empty($_POST['description_main'])) ? $_POST['description_main'] : $item_details['description']));

		$start_time = ($auction_edit) ? $start_time : $item_details['start_time'];
		$item_details['start_time'] = ($item_details['start_time_type'] != 'custom') ? (($start_time < CURRENT_TIME && $start_time > 0) ? $start_time : CURRENT_TIME) : get_box_timestamp($item_details, $start_time_id);		
		$item_details['end_time'] = ($item_details['end_time_type'] == 'duration') ? ($item_details['start_time'] + $item_details['duration'] * 86400) : get_box_timestamp($item_details, $end_time_id);
		$custom_fld->save_vars($_POST);

		$old_category_id = intval($_REQUEST['old_category_id']);
		$old_addl_category_id = intval($_REQUEST['old_addl_category_id']);		
	}
	else
	{
		$custom_fld->save_edit_vars($item_details['reverse_id'], 'reverse');
		
		## upload initial images
		$media_details = $item->get_media_values($item_details['reverse_id'], false, true);
		$item_details['ad_image'] = $media_details['ad_image'];
		$item_details['ad_video'] = $media_details['ad_video'];
		$item_details['ad_dd'] = $media_details['ad_dd'];
	}

	if (isset($_REQUEST['form_edit_proceed']))
	{
		define ('FRMCHK_ITEM', 1);
		$frmchk_details = $item_details;

		include ('includes/procedure_frmchk_reverse.php'); /* Formchecker for reverse auction creation/edit */

		if ($fv->is_error())
		{
			$template->set('display_formcheck_errors', $fv->display_errors());
			$frmchk_error = true;
		}
		else
		{
			$form_submitted = true;

			$template->set('message_header', $sell_item_header);

			if ($session->value('reverse_refresh_id') == $item_details['reverse_id'])
			{
				$template->set('message_content', '<p align="center" class="contentfont">' . MSG_DOUBLE_POST_ERROR . '</p>');
			}
			else
			{
				$edit_reverse = ($_REQUEST['do'] == 'edit') ? true : false;

				if ($auction_edit)
				{
					$reverse_fee->edit_auction_id = $item_details['reverse_id'];
					$reverse_fee->edit_user_id = $session->value('user_id');

					$reverse_fee->prepare_rollback($item_details['reverse_id'], $session->value('user_id'));	
				}
				$setup_result = $reverse_fee->reverse_setup($user_details, $item_details);
				
				## item update function call
				$reverse_id = $item->insert_reverse($item_details, $session->value('user_id'), 'reverse', $edit_reverse);

				if ($edit_reverse)
				{
					$old_category_id = intval($_REQUEST['old_category_id']);
					$old_addl_category_id = intval($_REQUEST['old_addl_category_id']);

					if ($item_details['start_time'] < CURRENT_TIME)
					{
					   if ($old_category_id != $item_details['category_id'])
					   {
						   reverse_counter($old_category_id, 'remove');					
						   reverse_counter($item_details['category_id'], 'add');
					   }
					   if ($old_addl_category_id != $item_details['addl_category_id'])
					   {
						   reverse_counter($old_addl_category_id, 'remove');					
						   reverse_counter($item_details['addl_category_id'], 'add');
					   }
					}

					$old_start_time = $db->get_sql_field("SELECT start_time FROM " . DB_PREFIX . "reverse_auctions WHERE 
						reverse_id='" . $item_details['reverse_id'] . "' AND owner_id='" . $session->value('user_id') . "'", 'start_time');
							
					if ($old_start_time > CURRENT_TIME && $item_details['start_time_type'] == 'now')		
					{
						reverse_counter($item_details['category_id'], 'add');
						reverse_counter($item_details['addl_category_id'], 'add');
					}
				}
				else 
				{
					$mail_input_id = $reverse_id;## PHP Pro Bid v6.00 confirm posting to seller
					include('language/' . $setts['site_lang'] . '/mails/new_reverse_seller_confirmation.php');## PHP Pro Bid v6.00 if listed in store, announce users that have the store added to their favorites about the new item
					
				}
				
				$session->set('reverse_refresh_id', $item_details['reverse_id']);

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
			$item_details['ad_dd'] = $media_upload['post_details']['ad_dd'];

			$template->set('media_upload_fields', $media_upload_fields);
		}
		else /* means we have a file upload */
		{
			$media_upload = $item->media_upload($item_details, $item_details['file_upload_type'], $_FILES);
			$media_upload_fields = $media_upload['display_output'];

			$item_details['ad_image'] = $media_upload['post_details']['ad_image'];
			$item_details['ad_video'] = $media_upload['post_details']['ad_video'];
			$item_details['ad_dd'] = $media_upload['post_details']['ad_dd'];

			$template->set('media_upload_fields', $media_upload_fields);
		}## <<END>> media upload sequence

		$template->set('do', $_REQUEST['do']);
		$template->set('item_details', $item_details);
		$template->set('user_details', $user_details);

		$template->set('sell_item_header', $sell_item_header);

		$template->set('post_url', 'reverse_manage.php');
		## BEGIN pages upload
		## 1.- details section
		$template->set('main_category_display', category_navigator($item_details['category_id'], false, true, null, null, GMSG_NONE_CAT, true));
		$template->set('addl_category_display', category_navigator($item_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT, true));

		$selected_currency = ($item_details['currency']) ? $item_details['currency'] : $setts['currency'];
		$template->set('currency_drop_down', $item->currency_drop_down('currency', $selected_currency, 'ad_create_form'));
		
		$template->set('budget_drop_down', $item->budget_drop_down('budget_id', $item_details['currency'], $item_details['budget_id']));
		$template->set('duration_drop_down', $item->durations_drop_down('duration', $item_details['duration']));

		$custom_fld->new_table = false;
		$custom_fld->field_colspan = 2;
		$custom_sections_table = $custom_fld->display_sections($item_details, $page_handle);

		$template->set('custom_sections_table', $custom_sections_table);

		$start_date_box = date_form_field($item_details['start_time'], $start_time_id, 'ad_create_form');
		$template->set('start_date_box', $start_date_box);
		
		$end_date_box = date_form_field($item_details['end_time'], $end_time_id, 'ad_create_form');
		$template->set('end_date_box', $end_date_box);		
		
		/* display fees on the reverse auctions setup page */
		
		$setup_fee = $reverse_fee->display_fee('setup', $user_details, $item_details['category_id'], 'auction');
		$template->set('setup_fee_expl_message', $setup_fee['display_short']);

		$addlcat_fee = $reverse_fee->display_fee('second_cat_fee', $user_details, $item_details['category_id'], 'auction');
		$template->set('addlcat_fee_expl_message', $addlcat_fee['display_short']);
		
		$hpfeat_fee = $reverse_fee->display_fee('hpfeat_fee', $user_details, $item_details['category_id'], 'auction');
		$template->set('hpfeat_fee_expl_message', $hpfeat_fee['display_short']);
	
		$catfeat_fee = $reverse_fee->display_fee('catfeat_fee', $user_details, $item_details['category_id'], 'auction');
		$template->set('catfeat_fee_expl_message', $catfeat_fee['display_short']);
	
		$hl_fee = $reverse_fee->display_fee('hlitem_fee', $user_details, $item_details['category_id'], 'auction');
		$template->set('hl_fee_expl_message', $hl_fee['display_short']);
	
		$bold_fee = $reverse_fee->display_fee('bolditem_fee', $user_details, $item_details['category_id'], 'auction');
		$template->set('bold_fee_expl_message', $bold_fee['display_short']);
	
		$custom_start_fee = $reverse_fee->display_fee('custom_start_fee', $user_details, $item_details['category_id'], 'auction');
		$template->set('custom_start_fee_expl_message', $custom_start_fee['display_short']);
	
		$picture_fee = $reverse_fee->display_fee('picture_fee', $user_details, $item_details['category_id'], 'auction');
		$picture_fee_expl_message = $picture_fee['display_short'];
		$template->set('picture_fee_expl_message', $picture_fee_expl_message);
	
		$video_fee = $reverse_fee->display_fee('video_fee', $user_details, $item_details['category_id'], 'auction');
		$video_fee_expl_message = $video_fee['display_short'];
		$template->set('video_fee_expl_message', $video_fee_expl_message);
		
		$dd_fee = $reverse_fee->display_fee('dd_fee', $user_details, $item_details['category_id'], 'auction');
		$dd_fee_expl_message = $dd_fee['display_short'];
		$template->set('dd_fee_expl_message', $dd_fee['display_short']);

		$item->show_free_images = true;
		
		$image_upload_manager = $item->upload_manager($item_details, 1, 'ad_create_form', true, false, true, $picture_fee_expl_message);
		$template->set('image_upload_manager', $image_upload_manager);
		
		$video_upload_manager = $item->upload_manager($item_details, 2, 'ad_create_form', true, false, true, $video_fee_expl_message);
		$template->set('video_upload_manager', $video_upload_manager);

		/* start digital media code */
		$item->setts['max_dd'] = $setts['max_additional_files'];
		$dd_upload_manager = $item->upload_manager($item_details, 3, 'ad_create_form', true, false, true, $dd_fee_expl_message, true);
		$template->set('dd_upload_manager', $dd_upload_manager);
		/* end digital media code */
		
		$template_output .= $template->process('reverse_manage.tpl.php');
	}

	include_once ('global_footer.php');

	echo $template_output;
}
?>