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

	if (!in_array($page_handle, $custom_section_pages))
	{
		$template_output .= '<p align="center" class="contentfont">' . AMSG_CUSTOM_PAGE_SEL_ERROR . '</p>';
	}
	else
	{
		$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

		if (isset($_POST['form_save_settings']) && in_array($page_handle, $custom_section_pages_ordering))
		{
			foreach ($_POST['page_id'] as $key => $value)
			{
				$update_ordering = $db->query("UPDATE " . DB_PREFIX . "content_pages SET
					topic_order='" . $_POST['topic_order'][$key] . "' WHERE page_id='" . $value . "' AND page_handle='" . $page_handle . "'");
			}
		}

		if ($_REQUEST['do'] == 'add_topic')
		{
			if ($_REQUEST['operation'] == 'submit')
			{
				$template->set('msg_changes_saved', $msg_changes_saved);

				$post_details = $db->rem_special_chars_array($_POST);
				$page_id = md5(uniqid(rand(2,99999999))); // generated the unique id for the new page

				foreach ($languages as $value)
				{
					$site_content->insert_topic($post_details, $value, $page_id, $page_handle);
				}
			}
			else
			{
				$template->set('disabled_button', 'disabled');
				$template->set('do', $_REQUEST['do']);
				$template->set('manage_box_title', AMSG_ADD_TOPIC);

				$management_box = $template->process('content_section_add_topic.tpl.php');
			}
		}
		else if ($_REQUEST['do'] == 'edit_topic')
		{

			if ($_REQUEST['operation'] == 'submit')
			{
				$template->set('msg_changes_saved', $msg_changes_saved);

				$post_details = $db->rem_special_chars_array($_POST);

				foreach ($languages as $value)
				{
					$site_content->edit_topic($post_details, $value, $_POST['page_id'], $page_handle);
				}
			}
			else
			{
				$template->set('disabled_button', 'disabled');
				$template->set('do', $_REQUEST['do']);
				$template->set('manage_box_title', AMSG_EDIT_TOPIC);
				$template->set('page_id', $_REQUEST['page_id']);

				$management_box = $template->process('content_section_add_topic.tpl.php');
			}
		}
		else if ($_REQUEST['do'] == 'delete_topic')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$site_content->delete_topic($_REQUEST['page_id'], $page_handle);
		}

		$template->set('management_box', $management_box);

		$sql_select_topics = $db->query("SELECT * FROM " . DB_PREFIX . "content_pages WHERE
	   	topic_lang='" . $setts['site_lang'] . "' AND
	   	page_handle='" . $page_handle . "' ORDER BY topic_order ASC, reg_date DESC");

	   while ($topic_details = $db->fetch_array($sql_select_topics))
		{
			$background = ($counter++%2) ? 'c1' : 'c2';

			$content_pages_content .= '<input type="hidden" name="page_id[]" value="' . $topic_details['page_id'] . '">'.
				'<tr class="' . $background . '"> '.
	      	'	<td>' . $topic_details['topic_name'] . '</td> ';

	      if (in_array($page_handle, $custom_section_pages_ordering))
	      {
	      	$content_pages_content .=	'	<td align="center"><input name="topic_order[]" type="text" value="' . $topic_details['topic_order'] . '" size="8"></td> ';

	      }

	      $content_pages_content .= '	<td align="center">' . show_date($topic_details['reg_date']) . '</td> '.
	      	'	<td align="center"> '.
				'		[ <a href="content_section.php?do=edit_topic&page_id=' . $topic_details['page_id'] . '&page=' . $page_handle . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
				'		[ <a href="content_section.php?do=delete_topic&page_id=' . $topic_details['page_id'] . '&page=' . $page_handle . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
				'</tr> ';

		}

		$template->set('content_pages_content', $content_pages_content);

		$subpage_title = $site_content->subpage_title($page_handle);

		$template->set('header_section', AMSG_SITE_CONTENT);
		$template->set('subpage_title', $subpage_title);

		$template_output .= $template->process('content_section.tpl.php');
	}

	include_once ('footer.php');

	echo $template_output;
}
?>