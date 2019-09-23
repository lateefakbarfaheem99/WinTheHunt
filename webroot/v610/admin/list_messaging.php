<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');
include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_user.php');
include_once ('../includes/class_fees.php');
include_once ('../includes/class_item.php');
include_once ('../includes/functions_item.php');
include_once ('../includes/class_messaging.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	if ($_REQUEST['do'] == 'delete')
	{
		$db->query("DELETE FROM " . DB_PREFIX . "messaging WHERE topic_id='" . intval($_REQUEST['topic_id']) . "'");
		$template->set('msg_changes_saved', '<p align="center">' . AMSG_TOPIC_DELETED . '</p>');
	}

	$limit = 20;

	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'm.topic_id';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	//$additional_vars = '&submitted=' . $_REQUEST['submitted'] . '&src_from=' . $_REQUEST['src_from'] . '&src_to=' . $_REQUEST['src_to'] . '&src_rating=' . $_REQUEST['src_rating'];

	$nb_topics = $db->get_sql_field("SELECT COUNT(DISTINCT topic_id) AS count_rows FROM
		" . DB_PREFIX . "messaging WHERE topic_id!=0", 'count_rows');

	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_topics));

	$sql_select_topics = $db->query("SELECT m.*, a.name, s.username AS sender_username, 
		r.username AS receiver_username, w.name AS wanted_name, ra.name AS reverse_name FROM
		" . DB_PREFIX ."messaging AS m
		LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=m.auction_id 
		LEFT JOIN " . DB_PREFIX . "wanted_ads w ON w.wanted_ad_id=m.wanted_ad_id 
		LEFT JOIN " . DB_PREFIX . "reverse_auctions ra ON ra.reverse_id=m.reverse_id 
		LEFT JOIN " . DB_PREFIX ."users AS s ON s.user_id=m.sender_id
		LEFT JOIN " . DB_PREFIX ."users AS r ON r.user_id=m.receiver_id
		WHERE m.topic_id!=0
		GROUP BY m.topic_id
		ORDER BY " . $order_field . " " . $order_type . "
		LIMIT " . $start . ", " . $limit);

	$msg = new messaging();

	while ($topic_details = $db->fetch_array($sql_select_topics))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$messaging_content .= '<tr class="' . $background . '"> '.
    		'	<td>' . $topic_details['topic_id'] . '</td> '.
    		'	<td>' . $msg->message_subject($topic_details) . '</td>'.
    		'	<td align="center">' . $db->count_rows('messaging', "WHERE topic_id='" . $topic_details['topic_id'] . "'") . '</td>'.
			'	<td align="center" class="contentfont"> '.
			'		[ <a href="list_messaging.php?do=delete&topic_id=' . $topic_details['topic_id'] . $additional_vars . $order_link . $limit_link . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]<br> '.
			'		[ <a href="' . $msg->msg_board_link($topic_details) . '" target="_blank">' . AMSG_VIEW_TOPIC . '</a> ]</td> '.
			'</tr> ';
	}

	$template->set('messaging_content', $messaging_content);

	$pagination = paginate($start, $limit, $nb_topics, 'list_messaging.php', $additional_vars . $order_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_AUCTIONS_MANAGEMENT);
	$template->set('subpage_title', AMSG_USER_MESSAGES_MANAGEMENT);

	$template_output .= $template->process('list_messaging.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>