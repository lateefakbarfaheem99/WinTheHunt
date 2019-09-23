<?
#################################################################
## PHP Pro Bid v6.00															##
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

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	if (isset($_POST['form_save_settings']))
	{
		$blocks_total = count($_POST['block_id']);

		for ($i=0; $i<$blocks_total; $i++)
		{
			$db->query("UPDATE " . DB_PREFIX . "blocked_users SET
				show_reason='" . $_POST['show_reason'][$i] . "',
				block_reason='" . $db->rem_special_chars($_POST['block_reason'][$i]) . "'
				WHERE block_id='" . $_POST['block_id'][$i] . "'");
		}

		$template->set('msg_changes_saved', '<p align="center">' . AMSG_CHANGES_SAVED . '</p>');
	}

	if ($_REQUEST['do'] == 'delete')
	{
		$db->query("DELETE FROM " . DB_PREFIX . "blocked_users WHERE block_id='" . intval($_REQUEST['block_id']) . "'");
		$template->set('msg_changes_saved', '<p align="center">' . AMSG_RECORD_DELETED . '</p>');
	}

	$limit = 20;

	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'b.block_id';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	//$additional_vars = '&submitted=' . $_REQUEST['submitted'] . '&src_from=' . $_REQUEST['src_from'] . '&src_to=' . $_REQUEST['src_to'] . '&src_rating=' . $_REQUEST['src_rating'];

	$nb_blocks = $db->count_rows('blocked_users');

	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_blocks));

	$sql_select_blocks = $db->query("SELECT b.*, u.username AS user_username, o.username AS owner_username FROM
		" . DB_PREFIX ."blocked_users AS b
		LEFT JOIN " . DB_PREFIX ."users AS u ON u.user_id=b.user_id
		LEFT JOIN " . DB_PREFIX ."users AS o ON o.user_id=b.owner_id
		ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

	while ($block_details = $db->fetch_array($sql_select_blocks))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$blocked_users_content .= '<tr class="' . $background . '"> '.
			'	<input type="hidden" name="block_id[]" value="' . $block_details['block_id'] . '"> '.
    		'	<td> <b>' . AMSG_BLOCKER . '</b>: ' . $block_details['owner_username'] . '<br> '.
    		'		<b>' . AMSG_BLOCKED_USER . '</b>: ' . $block_details['user_username'] . '</td> '.
    		'	<td align="center"> '.
    		'		<input type="checkbox" name="show_reason[]" value="1" ' . (($block_details['show_reason'] == 1) ? 'checked' : '') . '></td>'.
    		'	<td><textarea name="block_reason[]" style="width: 100%; height: 50" id="block_reason">' . $block_details['block_reason'] . '</textarea></td>'.
			'	<td align="center" class="contentfont"> '.
			'		[ <a href="blocked_users.php?do=delete&block_id=' . $block_details['block_id'] . $additional_vars . $order_link . $limit_link . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
			'</tr> ';
	}

	$template->set('blocked_users_content', $blocked_users_content);

	$pagination = paginate($start, $limit, $nb_blocks, 'blocked_users.php', $additional_vars . $order_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_BLOCKED_USERS);

	$template_output .= $template->process('blocked_users.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>