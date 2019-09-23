<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');## PHP Pro Bid v6.00# reset all counters

if ($session->value('adminarea')!='Active')
{
	echo 'Access Denied';
}
else
{
	include_once('modules/exception.php');
	include_once('modules/members_area/bulk.php');
	include_once('modules/members_area/bulk/details.php');

	$bulk_details = new Module_Members_Bulk_Details(0, $setts, $categories_array);

	$bulk_details->generateSampleFile();
	
	echo 'The bulk sample file has been generated successfully.';
}
?>