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

include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_item.php');

if ($session->value('adminarea') != 'Active')
{
	$template_output .= '<p align="center" class="contentfont">' . GMSG_ACCESS_DENIED . '</p>';
}
else
{
	$table_name = ($_REQUEST['table'] == 'reverse') ? 'reverse_categories' : 'categories';
	$template->set('table', $_REQUEST['table']);
	
	$item = new item();
	$item->setts = &$setts;
	$item->setts['max_images'] = 1;
	$item->relative_path = '../'; /* declared because we are in the admin */

	$template->set('page_title', AMSG_EDIT_CATEGORY_OPTIONS);
	
	$cat_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . $table_name . " WHERE
		category_id='" . intval($_GET['category_id']) . "'");

	$template->set('cat_details', $cat_details);
	
	$item_details = (!empty($_POST)) ? $_POST : $cat_details;
	$item_details['ad_image'][0] = (!empty($_POST['ad_image'][0])) ? $_POST['ad_image'][0] : $cat_details['image_path'];
	
	$item_details['auction_id'] = ($item_details['category_id']) ? 'category_' . remove_spaces($item_details['category_id']) : 'category_logo';
	
	if (empty($_POST['file_upload_type']))
	{
		$template->set('media_upload_fields', $item->upload_manager($item_details));
	}
	else if (is_numeric($_POST['file_upload_id'])) /* means we remove a file / media url */
	{
		$media_upload = $item->media_removal($item_details, $item_details['file_upload_type'], $item_details['file_upload_id'], false);
		$media_upload_fields = $media_upload['display_output'];

		$item_details['ad_image'] = $media_upload['post_details']['ad_image'];
		//$item_details['ad_video'] = $media_upload['post_details']['ad_video'];

		$template->set('media_upload_fields', $media_upload_fields);
		$template->set('cat_details', $item_details);
	}
	else /* means we have a file upload */
	{
		$media_upload = $item->media_upload($item_details, $item_details['file_upload_type'], $_FILES, false);
		$media_upload_fields = $media_upload['display_output'];

		$item_details['ad_image'] = $media_upload['post_details']['ad_image'];
		//$item_details['ad_video'] = $media_upload['post_details']['ad_video'];

		$template->set('media_upload_fields', $media_upload_fields);
		$template->set('cat_details', $item_details);
	}
	
	if (isset($_POST['form_submit_catopts']))
	{
		$item_details = $db->rem_special_chars_array($item_details);
		$db->query("UPDATE " . DB_PREFIX . $table_name . " SET 
			hover_title='" . $item_details['hover_title'] . "', meta_description='" . $item_details['meta_description'] . "', 
			meta_keywords='" . $item_details['meta_keywords'] . "', 
			image_path='" . get_main_image($item_details['ad_image']) . "' WHERE category_id='" . $item_details['category_id'] . "'");
		
		$template->set('form_saved', 1);
	}
	
	$image_upload_manager = $item->upload_manager($item_details, 1, 'form_category_options', true);
	$template->set('image_upload_manager', $image_upload_manager);
	
	$template->change_path('../templates/');
	$template->set('global_header_content', $template->process('global_header.tpl.php'));
	$template->change_path('templates/');
	
	$template_output .= $template->process('table_categories_options.tpl.php');
}
echo $template_output;
?>
