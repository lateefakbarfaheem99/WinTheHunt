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

include_once ('../includes/functions_login.php');

if (stristr($_GET['option'], 'logout'))
{
	logout(true);
}

if (isset($_POST['adminloginok']))
{
	$login_output = login_admin($_POST['username'], $_POST['password'], $_POST['pin_generated'], $_POST['pin_submitted']);

	$session->set('adminarea', $login_output['active']);
	$session->set('adminlevel', $login_output['level']);

	$redirect_url = 'index.php';
	header_redirect($redirect_url);
}

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	$msg_shown = false;
	if ($_GET['viewmsg']==1)
	{
		$insufficient_priv_msg = '<table width="100%" bgcolor="red"><tr><td align="center"> 			'.
			'<font size="+1" color="#ffffff">' . AMSG_INSUFFICIENT_LVL_MSG . '</font></td></tr></table>';

		$template->set('insufficient_priv_msg', $insufficient_priv_msg);
		$msg_shown = true;
	}
	
	if (isset($_POST['form_change_language']))
	{
		$db->query("UPDATE " . DB_PREFIX . "gen_setts SET admin_lang='" . $_POST['language'] . "'");
		header_redirect('index.php');
	}

	include_once ('header.php');

	$template_output .= $template->process('index.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>