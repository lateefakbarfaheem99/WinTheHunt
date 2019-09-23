<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');## PHP Pro Bid v6.00 generate the admin pin value
$session->set('admin_pin_value', md5(rand(2,99999999)));
$generated_pin = generate_pin($session->value('admin_pin_value'));

$pin_image_output = show_pin_image($session->value('admin_pin_value'), $generated_pin, '../');

$template->set('pin_image_output', $pin_image_output);
$template->set('admin_pin_value', $session->value('admin_pin_value'));

$template_output = $template->process('login.tpl.php');

echo $template_output;
?>