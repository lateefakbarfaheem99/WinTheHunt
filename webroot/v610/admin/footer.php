<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ($setts['debug_load_time'])
{
	$time_end = getmicrotime();
	$time_passed = $time_end - $time_start;
	$template->set('time_passed', number_format($time_passed, 6));
}

if ($setts['debug_load_memory'])
{
	$memory_end = memory_get_usage();
	$memory_usage = ($memory_end - $memory_start) / 1024;
	$template->set('memory_usage', $memory_usage);
}

$template_output .= $template->process('footer.tpl.php');

?>