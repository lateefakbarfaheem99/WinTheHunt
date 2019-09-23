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

include_once ('../includes/class_site_content.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$site_content = new site_content();

	(string) $page_handle = null;
	(string) $management_box = NULL;

	$languages = list_languages('admin');
	$template->set('languages', $languages);
	//$template->set('db', $db);

	$page_handle = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : '';

	$template->set('page_handle', $page_handle);
	$template->set('custom_section_pages_ordering', $custom_section_pages_ordering);

	if (!in_array($page_handle, $custom_pages))
	{
		$template_output .= '<p align="center" class="contentfont">' . AMSG_CUSTOM_PAGE_SEL_ERROR . '</p>';
	}
	else
	{
		$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

		if (isset($_POST['form_save_settings']))
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$post_details = $db->rem_special_chars_array($_POST);

			if (in_array($post_details['field_name'], array('is_about', 'is_terms', 'is_contact', 'is_pp')))
			{
				$update_page_status = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					" . $post_details['field_name'] . "='" . $post_details['field_value'] . "'");
			}

			foreach ($languages as $value)
			{
				$site_content->edit_topic($post_details, $value, $_POST['page_id'], $page_handle);
			}
		}

		$subpage_title = $site_content->subpage_title($page_handle);

		$layout_tmp  = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "layout_setts");
		$template->set('layout_tmp', $layout_tmp);

		(string) $field_name = null;

		switch ($page_handle)
		{
			case 'about_us': $field_name = 'is_about';
				break;
			case 'contact_us': $field_name = 'is_contact';
				break;
			case 'terms': $field_name = 'is_terms';
				break;
			case 'privacy': $field_name = 'is_pp';
				break;
		}

				$template->set('field_name', $field_name);


		$template->set('header_section', AMSG_SITE_CONTENT);
		$template->set('subpage_title', $subpage_title);

		$template_output .= $template->process('content_pages.tpl.php');
	}

	include_once ('footer.php');

	echo $template_output;
}
?>