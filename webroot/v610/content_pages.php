<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');

include_once ('includes/functions_login.php');
include_once ('includes/functions_item.php');

include_once ('global_header.php');

(string) $message_content = null;

## all default content pages
$pages_array_src = array('help', 'news', 'faq', 'about_us',	'contact_us', 'terms', 'privacy', 'announcements');

$pages_array = array('help' => MSG_HELP_TOPICS, 'news' => MSG_SITE_NEWS, 'faq' => MSG_FAQ_TITLE, 'about_us' => MSG_ABOUT_US,
	'contact_us' => MSG_CONTACT_US, 'terms' => MSG_TERMS, 'privacy' => MSG_PRIVACY, 'announcements' => MSG_ANNOUNCEMENTS_TITLE);

## content pages that support multiple rows
$content_pages_array = array('help', 'news', 'faq', 'announcements');

$addl_query = ($_REQUEST['topic_id']) ? "AND topic_id='" . $_REQUEST['topic_id'] . "'" : '';

$sql_select_pages = $db->query("SELECT topic_id, topic_name, topic_content FROM " . DB_PREFIX . "content_pages WHERE
	MATCH (topic_lang) AGAINST	('" . $session->value('site_lang') . "*' IN BOOLEAN MODE) AND
	page_handle='" . $_REQUEST['page'] . "' " . $addl_query . " ORDER BY topic_order ASC, reg_date DESC");

if (in_array($_REQUEST['page'], $pages_array_src))
{
	$message_header = $pages_array[$_REQUEST['page']];
}

$message_content = '<br>'.
'<script language="javascript">
	var ie4 = false;
	if(document.all) { ie4 = true; }

	function getObject(id) { if (ie4) { return document.all[id]; } else { return document.getElementById(id); } }
	function toggle(link, divId) {
		var d = getObject(divId);
		if (d.style.display == \'\') { d.style.display = \'none\'; }
		else { d.style.display = \'\'; }
	}
</script>';

$counter = 0;
while ($content_page = $db->fetch_array($sql_select_pages))
{
	if (in_array($_REQUEST['page'], array('custom_page')))
	{
		$message_header = $content_page['topic_name'];
	}

	if (in_array($_REQUEST['page'], $content_pages_array))
	{
		$message_content .= '<div class="topic_id"> '.
    		//'<a href="' . process_link('content_pages', array('page' => $_REQUEST['page'], 'topic_id' => $content_page['topic_id'])) . '">' . $content_page['topic_name'] . '</a> '.
    		'<a href="#" onclick="toggle(this, \'topic_content_' . $counter . '\');">' . $content_page['topic_name'] . '</a> '.
  			'</div>';
	}

	$style_display = (in_array($_REQUEST['page'], $content_pages_array) && $_REQUEST['page'] != 'news') ? 'none' : '';
	$message_content .= '<div class="topic_content" id="topic_content_' . $counter . '" style="display: ' . $style_display . ';"> ' . $db->add_special_chars($content_page['topic_content']) . '</div>';
	
	$counter++;
}

$topic_id = intval($_REQUEST['topic_id']);

if ($_REQUEST['page'] == 'contact_us')
{
	$user_details = $db->get_sql_row("SELECT name, email, username FROM " . DB_PREFIX . "users WHERE
		user_id='" . $session->value('user_id') . "'");

	if (isset($_POST['form_contactus_send']))
	{
		define ('FRMCHK_ITEM', 1);
		(int) $item_post = 1;

		$user_details = $db->rem_special_chars_array($_POST);
		$frmchk_details = $user_details;

		include('includes/procedure_frmchk_contactus.php');

		$form_submitted = 0;

		if ($fv->is_error())
		{
			$template->set('display_formcheck_errors', '<tr><td colspan="2">' . $fv->display_errors() . '</td></tr>');
		}
		else
		{
			$form_submitted = 1;
			
			## send email to admin
			include('language/' . $setts['site_lang'] . '/mails/contact_us.php');
			$message_content .= '<p align="center">' . MSG_CONTACT_EMAIL_SENT_SUCCESS . '</p>';
		}
	}

	if (!$form_submitted)
	{
		$template->set('user_details', $user_details);
		$template->set('topic_id', $topic_id);

		$session->set('pin_value', md5(rand(2,99999999)));
		$generated_pin = generate_pin($session->value('pin_value'));

		$pin_image_output = show_pin_image($session->value('pin_value'), $generated_pin);

		$template->set('pin_image_output', $pin_image_output);
		$template->set('generated_pin', $generated_pin);

		$message_content .= $template->process('contact_us.tpl.php');
	}
}

$template->set('message_header', header5($message_header));
$template->set('message_content', $message_content);

$template_output .= $template->process('single_message.tpl.php');

include_once ('global_footer.php');

echo $template_output;

?>