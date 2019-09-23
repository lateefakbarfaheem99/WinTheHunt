<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

function execute_query($query_id)
{
	global $db, $db_query;
	
	if (!empty($db_query[$query_id]))
	{
		$query_output = $db->query($db_query[$query_id], false, false);
		
		if (!$query_output)
		{
			return $db->query_error;
		}
	}
}

function query_output($query_id)
{
	global $db_desc;
	
	return $db_desc[$query_id];
}

$page_content .= '<p><b>Uploading Query: [ ' . ($db_step + 1) . ' / ' . ($total_steps + 1) . ' ]</b>';

if ($_REQUEST['time_passed'] > 0)
{
	$page_content .= '- (Last SQL query was run in ' . $_REQUEST['time_passed'] . ' seconds)';
}

$page_content .= '</p>';

$min_show = $db_step - 25; ## show a maximum of 20 query descriptions on the progress page.

if ($min_show<0)
{
	$show_start = 0;
}
else 
{
	$show_start = $min_show;
	$page_content .= '... <br>';
}

$next_step_proceed = true; ## javascript next step
@set_time_limit(300); ## no maximum execution time (300 seconds)
//@ini_set('memory_limit', '99999'); ## memory limit - no limit
@ini_set('max_input_time', '-1'); 

if ($_REQUEST['install_type'] == 'install')
{
	include_once ('fresh_install_queries.php');
	include_once ('upgrade_v600_to_v602.php');
	include_once ('upgrade_v602_to_v603.php');
	include_once ('upgrade_v603_to_v604.php');
	include_once ('upgrade_v604_to_v605.php');
	include_once ('upgrade_v605_to_v606.php');
	include_once ('upgrade_v606_to_v607.php');
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);

	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}
	}
}

if ($_REQUEST['install_type'] == 'upgrade_v525')
{
	include_once ('upgrade_v525_to_v600.php');
	include_once ('upgrade_v600_to_v602.php');
	include_once ('upgrade_v602_to_v603.php');
	include_once ('upgrade_v603_to_v604.php');
	include_once ('upgrade_v604_to_v605.php');
	include_once ('upgrade_v605_to_v606.php');
	include_once ('upgrade_v606_to_v607.php');
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);
	
	
	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}	
	}
}


/* v6.02 upgrade */
if ($_REQUEST['install_type'] == 'upgrade_v600')
{
	include_once ('upgrade_v600_to_v602.php');
	include_once ('upgrade_v602_to_v603.php');
	include_once ('upgrade_v603_to_v604.php');
	include_once ('upgrade_v604_to_v605.php');
	include_once ('upgrade_v605_to_v606.php');
	include_once ('upgrade_v606_to_v607.php');
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);
	
	
	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}	
	}
}

/* v6.03 upgrade */
if ($_REQUEST['install_type'] == 'upgrade_v602')
{
	include_once ('upgrade_v602_to_v603.php');
	include_once ('upgrade_v603_to_v604.php');
	include_once ('upgrade_v604_to_v605.php');
	include_once ('upgrade_v605_to_v606.php');
	include_once ('upgrade_v606_to_v607.php');
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);
	
	
	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}	
	}
}

/* v6.04 upgrade */
if ($_REQUEST['install_type'] == 'upgrade_v603')
{
	include_once ('upgrade_v603_to_v604.php');
	include_once ('upgrade_v604_to_v605.php');
	include_once ('upgrade_v605_to_v606.php');
	include_once ('upgrade_v606_to_v607.php');
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);
	
	
	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}	
	}
}

/* v6.05 upgrade */
if ($_REQUEST['install_type'] == 'upgrade_v604')
{
	include_once ('upgrade_v604_to_v605.php');
	include_once ('upgrade_v605_to_v606.php');
	include_once ('upgrade_v606_to_v607.php');
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);
	
	
	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}	
	}
}

/* v6.06 upgrade */
if ($_REQUEST['install_type'] == 'upgrade_v605')
{
	include_once ('upgrade_v605_to_v606.php');
	include_once ('upgrade_v606_to_v607.php');
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);
	
	
	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}	
	}
}

/* v6.07 upgrade */
if ($_REQUEST['install_type'] == 'upgrade_v606')
{
	include_once ('upgrade_v606_to_v607.php');
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);
	
	
	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}	
	}
}

/* v6.10 upgrade */
if ($_REQUEST['install_type'] == 'upgrade_v607')
{
	include_once ('upgrade_v607_to_v610.php');
	
	$result = execute_query($db_step);
	
	
	if (!empty($result))
	{
		$next_step_proceed = false;
		$page_content .= $result;
	}
	else 
	{
		for ($i=$show_start; $i<=$db_step; $i++)
		{
			$page_content .= query_output($i) . '<br>';
		}	
	}
}
?>