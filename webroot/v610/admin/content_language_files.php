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
	if (get_magic_quotes_gpc())
	{
		$_GET = array_map('stripslashes', $_GET); 
		$_POST = array_map('stripslashes', $_POST);
	}
		
	include_once ('header.php');

	$site_content = new site_content();

	(string) $management_box = NULL;

	$selected_lang = ($_REQUEST['language']) ? $_REQUEST['language'] : $setts['site_lang'];
	$template->set('selected_lang', $selected_lang);

	$languages_dropdown = list_languages('admin', true, $selected_lang);
	$template->set('languages_dropdown', $languages_dropdown);

	//$template->set('db', $db);

	$file_name = '../language/' . $selected_lang . '/site.lang.php';

	if (isset($_POST['form_save_settings']))
	{
		$save_file_output = save_file($file_name, $_POST['file_content']);

		$msg_changes_saved = '<p align="center" class="contentfont">' . $save_file_output . '</p>';
		$template->set('msg_changes_saved', $msg_changes_saved);
	}

	//(string) $file_content = null;

	/*
	$fp = fopen($file_name,"r");

	while (!feof ($fp))
	{
		$file_content .= fread($fp, 4096);
	}
	fclose ($fp);
	*/
	$file_content = file_get_contents($file_name);

	$template->set('file_content', $file_content);

	$template->set('header_section', AMSG_SITE_CONTENT);
	$template->set('subpage_title', AMSG_EDIT_SITE_LANGUAGE_FILES);

	$template_output .= $template->process('content_language_files.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>