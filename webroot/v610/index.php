<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);
define ('INDEX_PAGE', 1); ## for integration

if (!file_exists('includes/config.php')) echo "<script>document.location.href='install/install.php'</script>";

include_once ('includes/global.php');

include_once ('includes/functions_login.php');
include_once ('includes/functions_item.php');

if (stristr($_GET['option'], 'logout'))
{
	logout();
}

include_once ('global_header.php');

if (isset($_GET['change_language']))
{
	$all_languages = list_languages('site');

	if (in_array($_GET['change_language'], $all_languages))
	{
		$session->set('site_lang', $_GET['change_language']);
	}

	$refresh_link = 'index.php';

	$template_output .= '<br><p class="contentfont" align="center">' . MSG_SITE_LANG_CHANGED . '<br><br>
		Please click <a href="' . process_link('index') . '">' . MSG_HERE . '</a> ' . MSG_PAGE_DOESNT_REFRESH . '</p>';
	$template_output .= '<script>window.setTimeout(\'changeurl();\',300); function changeurl(){window.location=\'' . $refresh_link . '\'}</script>';
}
else if (isset($_GET['change_skin']))
{
	$all_skins = list_skins('site');

	if (in_array($_GET['default_theme'], $all_skins))
	{
		$session->set('site_theme', $_GET['default_theme']);
	}

	$refresh_link = 'index.php';

	$template_output .= '<br><p class="contentfont" align="center">' . MSG_SITE_SKIN_CHANGED . '<br><br>
		Please click <a href="' . process_link('index') . '">' . MSG_HERE . '</a> ' . MSG_PAGE_DOESNT_REFRESH . '</p>';
	$template_output .= '<script>window.setTimeout(\'changeurl();\',300); function changeurl(){window.location=\'' . $refresh_link . '\'}</script>';	
}
else
{
	include_once ('global_mainpage.php');
}

include_once ('global_footer.php');

echo $template_output;

?>