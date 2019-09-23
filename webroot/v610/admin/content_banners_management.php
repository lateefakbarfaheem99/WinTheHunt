<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_banner.php');
include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_item.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $page_handle = null;
	(string) $management_box = NULL;

	//$template->set('db', $db);

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$advert_type = ($_REQUEST['advert_type']) ? $_REQUEST['advert_type'] : 0;
	$template->set('advert_type', $advert_type);

	$advert = new banner();

	if (($_REQUEST['do'] == 'add_banner' || $_REQUEST['do'] == 'edit_banner') && !isset($_POST['form_save_settings']))
	{
		$item = new item();
		$item->setts = &$setts;
		$item->setts['max_images'] = 1;
		$item->relative_path = '../'; /* declared because we are in the admin */

		$post_details = $_POST;
		$post_details['item_id'] = 'custom_banner';

		if ($_REQUEST['do'] == 'edit_banner')
		{
			$row_advert = $db->get_sql_row("SELECT * FROM
				" . DB_PREFIX ."adverts WHERE advert_id=" . $_REQUEST['advert_id']);
		}

		$post_details['ad_image'][0] = (!empty($_POST['ad_image'][0])) ? $_POST['ad_image'][0] : $row_advert['advert_img_path'];
		//$post_details['ad_image'][0] = (!empty($post_details['ad_image'][0])) ? $post_details['ad_image'][0] : $row_advert['advert_img_path'];

		if (empty($_POST['file_upload_type']))
		{
			$template->set('media_upload_fields', $item->upload_manager($post_details));
		}
		else if (is_numeric($_POST['file_upload_id'])) /* means we remove a file / media url */
		{
			$media_upload = $item->media_removal($post_details, $post_details['file_upload_type'], $post_details['file_upload_id'], false);
			$media_upload_fields = $media_upload['display_output'];

			$post_details['ad_image'] = $media_upload['post_details']['ad_image'];

			if ($_REQUEST['do'] == 'edit_banner')
			{
				$db->query("UPDATE " . DB_PREFIX . "adverts SET advert_img_path='' WHERE advert_id='" . intval($_REQUEST['advert_id']) . "'");	
			}

			$template->set('media_upload_fields', $media_upload_fields);
		}
		else /* means we have a file upload */
		{
			$media_upload = $item->media_upload($post_details, $post_details['file_upload_type'], $_FILES, false);
			$media_upload_fields = $media_upload['display_output'];

			$post_details['ad_image'] = $media_upload['post_details']['ad_image'];

			$template->set('media_upload_fields', $media_upload_fields);
		}

		$image_upload_manager = $item->upload_manager($post_details, 1, 'form_content_banners', true, true, false);
		$template->set('image_upload_manager', $image_upload_manager);

		/**
		 * the two dropdowns for the advert categories field.
		 */
		(string) $all_categories_table = null;
		(string) $selected_categories_table = null;

		$banner_details = ($_POST['box_submit']) ? $_POST : $row_advert;
		$template->set('banner_details', $banner_details);

		$selected_categories = (!empty($row_advert['advert_categories'])) ? $row_advert['advert_categories'] : 0;
		$selected_categories = (is_array($_POST['categories_id'])) ? $db->implode_array($_POST['categories_id']) : $selected_categories;

		$sql_select_all_categories = $db->query("SELECT category_id, name FROM " . DB_PREFIX . "categories WHERE
			parent_id=0 AND category_id NOT IN (" . $selected_categories . ") ORDER BY order_id ASC, name ASC");

		$all_categories_table = '<select name="all_categories" size="15" multiple="multiple" id="all_categories" style="width: 100%;">';

		while ($all_categories_details = $db->fetch_array($sql_select_all_categories))
		{
			$all_categories_table .= '<option value="' . $all_categories_details['category_id'] . '">' . $all_categories_details['name'] . '</option>';
		}

		$all_categories_table .= '</select>';

		$sql_select_selected_categories = $db->query("SELECT category_id, name FROM " . DB_PREFIX . "categories WHERE
			parent_id=0 AND category_id IN (" . $selected_categories . ") ORDER BY order_id ASC, name ASC");

		$selected_categories_table ='<select name="categories_id[]" size="15" multiple="multiple" id="categories_id" style="width: 100%;"> ';

		while ($selected_categories_details = $db->fetch_array($sql_select_selected_categories))
		{
			$selected_categories_table .= '<option value="' . $selected_categories_details['category_id'] . '" selected>' . $selected_categories_details['name'] . '</option>';
		}

		$selected_categories_table .= '</select>';

		$template->set('all_categories_table', $all_categories_table);
		$template->set('selected_categories_table', $selected_categories_table);
	}

	if ($_REQUEST['do'] == 'add_banner')
	{
		if (isset($_POST['form_save_settings']))
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$advert->insert_banner($_POST);
		}
		else
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_ADD_BANNER);

			$management_box = $template->process('content_banners_management_add_banner.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'edit_banner')
	{
		if (isset($_POST['form_save_settings']))
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$advert->edit_banner($_POST, $_POST['advert_id']);

		}
		else
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_EDIT_BANNER);
			$template->set('advert_id', $_REQUEST['advert_id']);
			$template->set('advert_type', $banner_details['advert_type']);

			$management_box = $template->process('content_banners_management_add_banner.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'delete_banner')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		$advert->delete_banner($_REQUEST['advert_id']);
	}

	$template->set('management_box', $management_box);

	$addl_query = null;
	if (isset($_REQUEST['form_filter_section']) && $_REQUEST['filter_section_id'] > 0)
	{
		$addl_query = "WHERE section_id='" . intval($_REQUEST['filter_section_id']) . "'";
	}
	
	$template->set('filter_section_id', intval($_REQUEST['filter_section_id']));
	
	$sql_select_banners = $db->query("SELECT * FROM " . DB_PREFIX . "adverts " . $addl_query);

	while ($banner_details = $db->fetch_array($sql_select_banners))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$banners_management_content .= '<tr class="' . $background . '"> '.
		'	<td>' . $advert->display_banner($banner_details, true) . '</td> '.
		'	<td>' . $advert->banner_details($banner_details) . '</td> '.
		'	<td align="center">' . $setts['banner_positions'][$banner_details['section_id']] . '</td> '.
		'	<td align="center"> '.
		'		[ <a href="content_banners_management.php?do=edit_banner&advert_id=' . $banner_details['advert_id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
		'		[ <a href="content_banners_management.php?do=delete_banner&advert_id=' . $banner_details['advert_id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
		'</tr> ';

	}

	$template->set('banners_management_content', $banners_management_content);

	$template->set('header_section', AMSG_SITE_CONTENT);
	$template->set('subpage_title', AMSG_SITE_BANNERS_MANAGEMENT);

	$template_output .= $template->process('content_banners_management.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>