<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);


include_once ('includes/global.php');

$advert_id = intval($_REQUEST['advert_id']);

if ($advert_id)
{
	$add_click = $db->query("UPDATE " . DB_PREFIX . "adverts SET clicks=clicks+1 WHERE advert_id='" . $advert_id . "'");

	$advert_url = $db->get_sql_field("SELECT advert_url FROM " . DB_PREFIX . "adverts WHERE advert_id='" . $advert_id . "'", 'advert_url');
	header_redirect($db->add_special_chars($advert_url), true);
}
else 
{
	require ('global_header.php');
	
	$template->set('message_header', header5(MSG_BANNER_REDIRECT_ERROR));
	$template->set('message_content', '<p align="center">' . MSG_BANNER_REDIRECT_ERROR_EXPL . '</p>');

	$template_output .= $template->process('single_message.tpl.php');
	
	include_once ('global_footer.php');

	echo $template_output;
}
?>