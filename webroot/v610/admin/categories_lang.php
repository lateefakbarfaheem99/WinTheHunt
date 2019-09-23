<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_fees.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$cat_file_name = ($_REQUEST['table'] == 'reverse') ? 'reverse_category.lang.php' : 'category.lang.php';
	$template->set('table', $_REQUEST['table']);
	
	$cat_lang = $_POST['language'];		

	$template->set('cat_lang', $cat_lang);

	$file_name_orig = '../language/' . $setts['site_lang'] . '/' . $cat_file_name;
	
	$template->set('cat_lang_drop_down', list_languages('admin', true, $cat_lang));
	if ($cat_lang)
	{
		$file_name_edit = '../language/' . $cat_lang . '/' . $cat_file_name;
	}

	if (isset($_POST['form_file_save'])) 
	{
		$save_file_output = save_file($file_name_edit, $db->rem_special_chars($_POST['file_edit']));
		
		$template->set('msg_changes_saved', $save_file_output);
	}

	if ($cat_lang)
	{
		(string) $file1_contents = null;
		$file1 = @fopen($file_name_orig, 'r');
		
		while (!feof ($file1)) 
		{
			$file1_contents .= fgets($file1, 4096);
		}
		fclose ($file1);
	
		(string) $file2_contents = null;
		$file2 = @fopen($file_name_edit, 'r');
		
		while (!feof ($file2)) 
		{
			$file2_contents .= fgets($file2, 4096);
		}
		fclose ($file2);
	
		$template->set('file1_contents', $file1_contents);
		$template->set('file2_contents', $file2_contents);
	}
	
	$template->set('header_section', (($_REQUEST['table'] == 'reverse') ? AMSG_REVERSE_AUCTIONS_MANAGEMENT : AMSG_CATEGORIES));
	$template->set('subpage_title', AMSG_EDIT_CAT_LANG_FILES);

	$template_output .= $template->process('categories_lang.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>