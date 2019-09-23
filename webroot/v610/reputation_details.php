<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_item.php');
include_once ('includes/class_reputation.php');

(string) $message_content = null;

$reputation = new reputation();

$custom_header = $template->process('empty_header.tpl.php');
$template->set('custom_header', $custom_header);

$custom_footer = $template->process('empty_footer.tpl.php');
$template->set('custom_footer', $custom_footer);

$user_details = $db->get_sql_row("SELECT username, enable_aboutme_page, aboutme_page_content, shop_account_id, shop_active FROM
	" . DB_PREFIX . "users WHERE user_id='" . $_REQUEST['user_id'] . "'");

$reputation_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "reputation WHERE 
	reputation_id='" . intval($_REQUEST['reputation_id']) . "'");

$custom_fld = new custom_field();

$custom_fld->new_table = false;
$custom_fld->field_colspan = 1;
$page_handle = $reputation->cf_page_handle($reputation_details);
$custom_sections_table = $custom_fld->display_sections($user_details, $page_handle, true, $_REQUEST['reputation_id']);

$message_content = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border"> '.
   '	<tr> '.
	'		<td class="c4" colspan="2"><strong>' . MSG_REPUTATION_DETAILS . '</strong></td> '.
   '	</tr> '.
	$custom_sections_table .
	'</table>';

$template->set('message_content', $message_content);

$template_output .= $template->process('single_message.tpl.php');

echo $template_output;

?>