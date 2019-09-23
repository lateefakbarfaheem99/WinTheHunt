<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('INCLUDED', 1);

define('DEFAULT_DB_LANGUAGE', 'english');

function getmicrotime()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

include_once ('../language/'.DEFAULT_DB_LANGUAGE.'/db.lang.php');

include_once ('../includes/class_database.php');

include_once ('../includes/class_template.php');
$template = new template('templates/');

$db = new database;
$db->die = false;

$config_exists = (file_exists('../includes/config.php')) ? true : false;

if ($config_exists)
{
	include_once ('../includes/config.php');
	
	$connect_output = $db->connect($db_host, $db_username, $db_password);
	$select_output = $db->select_db($db_name);
}
	
## install related functions
function create_config($post_details)
{
	$fp = fopen('../includes/config.php', 'w');
	
	if ($fp)
	{
		$content = "<?php \n".
			" \n".
			"/* Database Host Name */ \n".
			"\$db_host = '" . $post_details['db_host'] . "'; \n".
			" \n".
			"/* Database Username */ \n".
			"\$db_username = '" . $post_details['db_username'] . "'; \n".
			" \n".
			"/* Database Login Password */ \n".
			"\$db_password = '" . $post_details['db_password'] . "'; \n".
			" \n".
			"/* Database and Session prefixes */ \n".
			"define('DB_PREFIX', '" . $post_details['table_prefix'] . "'); ## Do not edit ! \n".
			"define('SESSION_PREFIX', 'probid_'); \n".
			" \n".
			"/* Database Name */ \n".
			"\$db_name = '" . $post_details['db_name'] . "'; \n".
			"?>";

		fputs($fp, $content); 
		fclose($fp); 
		
		$output['display'] = '<b>The configuration file was created successfully.</b>';
		$output['result'] = true;
	}
	else 
	{
		$output['display'] = '<b>Error: Could not create the configuration file.</b><br> '.
			'Please make sure the <b>includes</b> folder has writing permissions and the <b>config.php</b> file doesn\'t already exist.';
		$output['result'] = false;		
	}
	
	return $output;

}

$install_step = ($_REQUEST['install_step']) ? $_REQUEST['install_step'] : 'welcome';

if ($_REQUEST['btn_refresh'])
{
	if ($install_step == 'connection')
	{
		$install_step = 'config_details';
	}
}

$template->set('install_step', $install_step);

(string) $template_output = null;
(string) $page_content = null;
$refresh = false;

if ($install_step == 'welcome') ## first step
{
	$step_title = 'STEP 1 - Welcome';
	$next_step = 'config_details';
	$page_content = '<p><b>Welcome to PHP Pro Bid v6.10</b></p> '.
	'<p>This process will install/upgrade the software on your server.</p> '.
	'<p>Before proceeding, please make sure the following steps were followed: '.
	'	<ul> '.
	'		<li>The files provided in the zipped kit have been uploaded on your server</li> '.
	'		<li>In case of a clean installation, the database you wish to use was created and is empty</li> '.
	'		<li>Writing permissions (CHMOD = 777) have been set on the <b>includes</b> folder</li> '.
	'	</ul> '.
	'</p> '.
	'<p>If the steps above have been completed, please click on the <b>Next Step</b> button</p> ';
}
else if ($install_step == 'config_details')
{
	$step_title = 'STEP 2 - Configuration Details';
	$next_step = 'connection';
	
	$refresh = true;
	
	if ($config_exists)
	{
		$page_content .= '<p><b>Configuration file exists.</b><br> '.
			'	If you wish to change your database connection configuration, please delete <b>includes/config.php</b> and reload this page.</p> ';
	}
	else 
	{
		$page_content .= '<p><b>Enter your database connection variables.</b><br> '.
			'	If you wish to proceed with a fresh installation, the database must not contain any tables.</p> ';
			
		$page_content .= $template->process('step_2_db_setup.tpl.php');
	}
}
else if ($install_step == 'connection') 
{
	$post_details = $_REQUEST;
	
	if (!$config_exists)
	{
		$create_config = create_config($post_details);
		$page_content .= '<p>' . $create_config['display'] . '</p> ';
		
	}
	else 
	{
		$create_config['result'] = true;
	}
	
	if ($create_config['result'])
	{
		include_once ('../includes/config.php');
		
		$connect_output = $db->connect($db_host, $db_username, $db_password);
		$select_output = $db->select_db($db_name);

		$page_content .= '<p>' . (($connect_output) ? 'The connection to the database server was established successfully.' : '<b>Error</b>: Could not connect to the database server with the credentials provided.') . '<br> '.
			(($select_output) ? 'The database <b>' . $db_name . '</b> was selected successfully.' : '<b>Error</b>: Could not connect to the database <b>' . $db_name . '</b>.') . '</p>';
	}

	
	$step_title = 'STEP 3 - Database Connection';
	$next_step = 'choose_install';
}
else if ($install_step == 'choose_install') 
{
	$step_title = 'STEP 4 - Choose Installation Type';
	$next_step = 'upload_sql';
	$page_content = '<p>Please choose if you wish to proceed with a fresh database installation or an upgrade installation.<br><br> '.
		'<b>Important</b>: If you wish to upgrade, please make sure you have backed up your tables first.<br><br>'.		
		'<input type="radio" name="install_type" value="install"> Fresh Installation<br> '.
		'<input type="radio" name="install_type" value="upgrade_v525"> Upgrade from v5.25<br> '.
		'<input type="radio" name="install_type" value="upgrade_v600"> Upgrade from v6.00<br> '.
		'<input type="radio" name="install_type" value="upgrade_v602"> Upgrade from v6.02<br> '.
		'<input type="radio" name="install_type" value="upgrade_v603"> Upgrade from v6.03<br> '.
		'<input type="radio" name="install_type" value="upgrade_v604"> Upgrade from v6.04<br> '.
		'<input type="radio" name="install_type" value="upgrade_v605"> Upgrade from v6.05<br> '.
		'<input type="radio" name="install_type" value="upgrade_v606"> Upgrade from v6.06<br> '.
		'<input type="radio" name="install_type" value="upgrade_v607"> Upgrade from v6.07<br> '.
		'</p> ';
}
else if ($install_step == 'upload_sql') 
{
	$time_start = getmicrotime();
	
	$step_title = 'STEP 5 - Upload SQL Queries';
	
	$db_step = ($_REQUEST['db_step']) ? $_REQUEST['db_step'] : 0;
	
	$v600_steps = 4; ## 6.00 to 6.02 upgrade
	
	$v603_steps = 1; ## 6.02 to 6.03 upgrade
	
	$v604_steps = 7; ## 6.03 to 6.04 upgrade

	$v605_steps = 5; ## 6.04 to 6.05 upgrade

	$v606_steps = 81; ## 6.05 to 6.06 upgrade
	
	$v607_steps = 7; ## 6.06 to 6.07 upgrade

	$v610_steps = 53; ## 6.07 to 6.10 upgrade
	
	switch ($_REQUEST['install_type'])
	{
		case 'install':
			$total_steps = 74 + $v600_steps + $v603_steps + $v604_steps + $v605_steps + $v606_steps + $v607_steps + $v610_steps;
			break;
		case 'upgrade_v525':
			$total_steps = 177 + $v600_steps + $v603_steps + $v604_steps + $v605_steps + $v606_steps + $v607_steps + $v610_steps; 
			break;
		case 'upgrade_v600':
			$total_steps = $v600_steps + $v603_steps + $v604_steps + $v605_steps + $v606_steps + $v607_steps + $v610_steps; 
			break;
		case 'upgrade_v602':
			$total_steps = $v603_steps + $v604_steps + $v605_steps + $v606_steps + $v607_steps + $v610_steps; 
			break;
		case 'upgrade_v603':
			$total_steps = $v604_steps + $v605_steps + $v606_steps + $v607_steps + $v610_steps; 
			break;
		case 'upgrade_v604':
			$total_steps = $v605_steps + $v606_steps + $v607_steps + $v610_steps; 
			break;
		case 'upgrade_v605':
			$total_steps = $v606_steps + $v607_steps + $v610_steps; 
			break;
		case 'upgrade_v606':
			$total_steps = $v607_steps + $v610_steps; 
			break;
		case 'upgrade_v607':
			$total_steps = $v610_steps; 
			break;
	}

	include_once ('database_upload.php');
	$db_step++;
	
	$time_end = getmicrotime();
	
	$time_passed = $time_end - $time_start;
	$time_passed = number_format($time_passed, 2);

	if ($db_step <= $total_steps)
	{		
		if ($next_step_proceed)
		{
			$page_content .= '<script language="JavaScript" type="text/javascript">'.
				'window.setTimeout(\'location.href="install.php?install_step=upload_sql&install_type=' . $_REQUEST['install_type'] . '&db_step=' . $db_step . '&total_steps=' . $total_steps . '&time_passed=' . $time_passed . '"\', 900);</script> ';	
		}
		else 
		{
			$page_content .= '<p align="center" class="contentfont">'.
				'[ <a href="install.php?install_step=upload_sql&install_type=' . $_REQUEST['install_type'] . '&db_step=' . ($db_step-1) . '&total_steps=' . $total_steps . '">Execute Again</a> ] &nbsp; '.
				'[ <a href="install.php?install_step=upload_sql&install_type=' . $_REQUEST['install_type'] . '&db_step=' . $db_step . '&total_steps=' . $total_steps . '">Next Query</a> ]</p>';
		}
	}
	else 
	{
		$next_step = 'site_settings';
	}	
}
else if ($install_step == 'site_settings') 
{
	$step_title = 'STEP 6 - Site Settings';
	$next_step = 'finish';
	
	$page_content .= '<p><b>Enter your site\'s settings.</b></p> ';
	
	$page_content .= $template->process('step_6_site_settings.tpl.php');

}
else if ($install_step == 'finish') 
{

	$post_details = $_POST;
	$db->query("UPDATE " . DB_PREFIX . "gen_setts SET 
		sitename='" . $post_details['sitename'] . "', site_path='" . $post_details['site_path'] . "', 
		admin_email='" . $post_details['admin_email'] . "'");
	$db->query("INSERT INTO " . DB_PREFIX . "admins 
		(username, password, date_created, level) VALUES
		('" . $db->rem_special_chars($post_details['username']) . "', '" . md5($post_details['password']) . "',
		'" . time() . "', '1')");
	
	$step_title = 'STEP 7 - Installation Successful';
	$next_step = 'redirect';
	$page_content = '<p><b>Installation Successful</b></p> '.
	'<p>PHP Pro Bid v6.10 was successfully installed on your server.</p>';
}
else if ($install_step == 'redirect')
{
	$db->query("UPDATE " . DB_PREFIX . "categories SET items_counter=0, wanted_counter=0, order_id=0, hidden=0, hover_title='', 
		meta_description='', meta_keywords='', image_path='', user_id=0, custom_fees=0, minimum_age=0");
	
	$site_path = $db->get_sql_field("SELECT site_path FROM " . DB_PREFIX . "gen_setts", 'site_path');
	
	header('Location: ' . $site_path . 'index.php?');
}

$template->set('refresh', $refresh);
$template->set('step_title', $step_title);
$template->set('next_step', $next_step);
$template->set('install_page_content', $page_content);

$template_output .= $template->process('install.tpl.php');

echo $template_output;
?>