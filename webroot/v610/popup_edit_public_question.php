<?
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');

include_once ('includes/class_messaging.php');

$wanted_ad_id = intval($_REQUEST['wanted_ad_id']);
$auction_id = intval($_REQUEST['auction_id']);
$question_id = intval($_REQUEST['question_id']);

if ($wanted_ad_id)
{
	$table_name = 'wanted_ads';
	$id_field = 'wanted_ad_id';
}
else 
{
	$table_name = 'auctions';
	$id_field = 'auction_id';	
}

$template->set('auction_id', $auction_id);
$template->set('wanted_ad_id', $wanted_ad_id);
$template->set('question_id', $question_id);

$message_content = $db->get_sql_field("SELECT m.message_content FROM 
	" . DB_PREFIX . "messaging m, " . DB_PREFIX . $table_name . " a WHERE
	m.is_question=0 AND m." . $id_field . "=a." . $id_field . " AND a.owner_id='" . $session->value('user_id') . "' AND
	m.topic_id='" . $question_id . "'", 'message_content', '');

$template->set('message_content', $message_content);

$template_output = $template->process('popup_edit_public_question.tpl.php');

echo $template_output;
?>