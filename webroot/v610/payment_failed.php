<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');

include_once ('global_header.php');

$template->set('message_header', header5(MSG_PAYMENT_FAILED));

$template->set('message_content', '<p align="center">' . MSG_PAYMENT_FAILED_DESC . '</p>');

$template_output .= $template->process('single_message.tpl.php');

include_once ('global_footer.php');

echo $template_output;
?>