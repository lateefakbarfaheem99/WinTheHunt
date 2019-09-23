<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

$time_end = getmicrotime();
//$memory_end = memory_get_usage();

$time_passed = $time_end - $time_start;
$template->set('time_passed', number_format($time_passed, 6));

//$memory_usage = ($memory_end - $memory_start) / 1024;
//$template->set('memory_usage', $memory_usage);

$is_custom_pages = $db->count_rows('content_pages', "WHERE MATCH (topic_lang) AGAINST
	('" . $session->value('site_lang') . "*' IN BOOLEAN MODE) AND page_handle='custom_page'");

if ($is_custom_pages)
{
	$sql_select_cpages = $db->query("SELECT topic_id, topic_name FROM " . DB_PREFIX . "content_pages WHERE
		MATCH (topic_lang) AGAINST	('" . $session->value('site_lang') . "*' IN BOOLEAN MODE) AND show_link=1 AND
		page_handle='custom_page' ORDER BY topic_order ASC");

	while ($cpage_details = $db->fetch_array($sql_select_cpages))
	{
		$custom_pages_links .= ' | <a href="' . process_link('content_pages', array('page' => 'custom_page', 'topic_id' => $cpage_details['topic_id'])) . '">' . strtoupper($cpage_details['topic_name']) . '</a> ';
	}

	$template->set('custom_pages_links', $custom_pages_links);
}

$template->change_path('themes/' . $setts['default_theme'] . '/templates/');
$template_output .= $template->process('footer.tpl.php');
$template->change_path('templates/');
?>