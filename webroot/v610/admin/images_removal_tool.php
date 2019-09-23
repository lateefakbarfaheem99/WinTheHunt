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

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$template->set('header_section', AMSG_AUCTIONS_MANAGEMENT);
	$template->set('subpage_title', AMSG_OLD_IMAGES_REMOVAL_TOOL);	

	$template_output .= $template->process('images_removal_tool.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>