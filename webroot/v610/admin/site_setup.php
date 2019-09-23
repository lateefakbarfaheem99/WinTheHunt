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

		$save_vars = $db->rem_special_chars_array($_POST);

		$addl_query = null;
		
		if ($save_vars['mailer'] == 'sendmail')
		{
			$addl_query = ", sendmail_path='" . $save_vars['sendmail_path'] . "'";
		}
		else if ($save_vars['mailer'] == 'smtp')
		{
			$addl_query = ", smtp_host='" . $save_vars['smtp_host'] . "', 
				smtp_port='" . $save_vars['smtp_port'] . "', 
				smtp_username='" . $save_vars['smtp_username'] . "', 
				smtp_password='" . $save_vars['smtp_password'] . "'";
		}

		@copy('../' . get_main_image($save_vars['ad_image']), '../images/probidlogo.gif');
		
		$sql_save_settings = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
			sitename='" . $save_vars['sitename'] . "', site_path='" . $save_vars['site_path'] . "',
			admin_email='" . $save_vars['admin_email'] . "', 
			email_admin_title='" . $save_vars['email_admin_title'] . "', 
			mailer='" . $save_vars['mailer'] . "', default_theme='" . $save_vars['default_theme'] . "',
			site_logo_path='" . get_main_image($save_vars['ad_image']) . "', site_lang='" . $save_vars['language'] . "',
			maintenance_mode='" . $save_vars['maintenance_mode'] . "'" . $addl_query);

		$session->set('language', $_POST['language']);
	}

	(string) $header_section = null;
	(string) $subpage_title = null;

	(string) $management_box = NULL;

	$form_submitted = false;

	$item = new item();
	$item->setts = &$setts;
	$item->setts['max_images'] = 1;
	$item->relative_path = '../'; /* declared because we are in the admin */

	$item->upload_url = false;
	//$item->add_unique = false;## PHP Pro Bid v6.00 special setting to not alter the filename
	//$item->image_basedir = 'images/';## PHP Pro Bid v6.00 special setting to not alter the file name
	//$item->extension = 'gif';## PHP Pro Bid v6.00 special setting to not alter the file name (images/probidlogo.gif)

	$post_details = $_POST;
	$post_details['auction_id'] = 'probidlogo';

	if (!isset($_POST['form_save_settings']))
	{
		$post_main_image = get_main_image($_POST['ad_image']);
		$post_details['ad_image'][0] = (!empty($post_main_image)) ? $post_main_image : ((!empty($setts['site_logo_path'])) ? $setts['site_logo_path'] : '');
	}

	if (empty($_POST['file_upload_type']))
	{
		$template->set('media_upload_fields', $item->upload_manager($post_details));
	}
	else if (is_numeric($_POST['file_upload_id'])) /* means we remove a file / media url */
	{
		$media_upload = $item->media_removal($post_details, $post_details['file_upload_type'], $post_details['file_upload_id'], false);
		$media_upload_fields = $media_upload['display_output'];

		$post_details['ad_image'] = $media_upload['post_details']['ad_image'];

		$db->query("UPDATE " . DB_PREFIX . "gen_setts SET site_logo_path=''");

		$template->set('media_upload_fields', $media_upload_fields);
	}
	else /* means we have a file upload */
	{
		$media_upload = $item->media_upload($post_details, $post_details['file_upload_type'], $_FILES, false);
		$media_upload_fields = $media_upload['display_output'];

		$post_details['ad_image'] = $media_upload['post_details']['ad_image'];
		
		$db->query("UPDATE " . DB_PREFIX . "gen_setts SET site_logo_path='" . get_main_image($post_details['ad_image']) . "'");
		
		$template->set('media_upload_fields', $media_upload_fields);
	}

	$setts_tmp = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "gen_setts");

	$template->set('setts_tmp', $setts_tmp);

	$header_section = AMSG_SITE_SETUP;
	$subpage_title = AMSG_SITE_SETUP;

	$template->set('header_section', $header_section);
	$template->set('subpage_title', $subpage_title);

	$template->set('site_skins_dropdown', list_skins('admin', true, $setts_tmp['default_theme']));
	$template->set('languages_dropdown', list_languages('admin', true, $setts_tmp['site_lang']));

	$image_upload_manager = $item->upload_manager($post_details, 1, 'form_site_setup', true, true, false);
	$template->set('image_upload_manager', $image_upload_manager);

	$template_output .= $template->process('site_setup.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>