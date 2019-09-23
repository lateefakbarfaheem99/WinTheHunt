<?
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_fees.php');
include_once ('../includes/class_messaging.php');


if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$smtp_result = smtp_mailer($setts['admin_email'], 'Site Administrator', $setts['admin_email'], 'Test SMTP Message', 'Test SMTP Message Content.');
	
	/* the test code starts here - no template is used */
	$template_output .= '<table width="100%" border="0" cellspacing="3" cellpadding="3" class="border"> '.
		'<tr><td><p>Trying to send a test email to the site admin email through your SMTP server..</p>'.
		$db->implode_array($smtp_result, '<br>').
		'</td></tr></table>';

	include_once ('footer.php');

	echo $template_output;
}
?>