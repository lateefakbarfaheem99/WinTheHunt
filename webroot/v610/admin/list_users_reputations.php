<?
#################################################################
## PHP Pro Bid v6.10															##
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
include_once ('../includes/class_item.php');
include_once ('../includes/class_reputation.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	if (isset($_POST['form_save_settings']))
	{
		$rep_total = count($_POST['reputation_id']);

		for ($i=0; $i<$rep_total; $i++)
		{
			(string) $addl_query = null;

			if (!$_POST['submitted'][$i] && !empty($_POST['reputation_content'][$i]) && $_POST['reputation_rate'][$i] > 0)
			{
				$addl_query = ", submitted=1, reg_date='" . CURRENT_TIME . "' ";
			}

			$db->query("UPDATE " . DB_PREFIX . "reputation SET
				reputation_rate='" . $_POST['reputation_rate'][$i] . "',
				reputation_content='" . $db->rem_special_chars($_POST['reputation_content'][$i]) . "'
				" . $addl_query . " WHERE reputation_id='" . $_POST['reputation_id'][$i] . "'");
		}

		$template->set('msg_changes_saved', '<p align="center">' . AMSG_CHANGES_SAVED . '</p>');
	}

	if ($_REQUEST['do'] == 'delete')
	{
		$db->query("DELETE FROM " . DB_PREFIX . "reputation WHERE reputation_id='" . intval($_REQUEST['reputation_id']) . "'");
		$template->set('msg_changes_saved', '<p align="center">' . AMSG_RECORD_DELETED . '</p>');
	}

	$limit = 20;

	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'r.reputation_id';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	$additional_vars = '&rep_submitted=' . $_REQUEST['rep_submitted'] . '&src_from=' . $_REQUEST['src_from'] . '&src_to=' . $_REQUEST['src_to'] . '&src_rating=' . $_REQUEST['src_rating'];

	(string) $search_filter = " WHERE f.user_id=r.from_id AND t.user_id=r.user_id";

	if ($_REQUEST['src_from'])
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " f.username LIKE '%".$_REQUEST['src_from']."%'";
		$template->set('src_from', $_REQUEST['src_from']);
	}
	if ($_REQUEST['src_to'])
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " t.username LIKE '%".$_REQUEST['src_to']."%'";
		$template->set('src_to', $_REQUEST['src_to']);
	}
	if (!empty($_REQUEST['src_rating']))
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " r.reputation_rate='" . intval($_REQUEST['src_rating']) . "'";
		$template->set('src_rating', $_REQUEST['src_rating']);
	}
	if (!empty($_REQUEST['rep_submitted']))
	{
		$submitted = ($_REQUEST['rep_submitted'] == 'yes') ? '1' : '0';
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " r.submitted='" . $submitted . "'";
	}

	$query_result = $db->query("SELECT count(*) AS count_rows FROM " . DB_PREFIX ."reputation r, " . DB_PREFIX ."users f, " . DB_PREFIX ."users t " . $search_filter);
	$nb_reps = $db->sql_result($query_result, 0, 'count_rows');

	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_reps));

	$sql_select_reps = $db->query("SELECT r.*, t.username AS to_username, f.username AS from_username FROM
		" . DB_PREFIX ."reputation r, " . DB_PREFIX ."users f, " . DB_PREFIX ."users t
		" . $search_filter . "
		ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

	$reputation = new reputation();
	$reputation->setts = &$setts;
	
	while ($rep_details = $db->fetch_array($sql_select_reps))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';
		$background = (!$rep_details['submitted']) ? 'c5' : $background;

		$rep_details_content .= '<tr class="' . $background . '"> '.
			'	<input type="hidden" name="reputation_id[]" value="' . $rep_details['reputation_id'] . '"> '.
			'	<input type="hidden" name="submitted[]" value="' . $rep_details['submitted'] . '"> '.
    		'	<td> <b>' . GMSG_FROM . '</b>: ' . $rep_details['from_username'] . '<br> '.
    		'		<b>' . GMSG_TO . '</b>: ' . $rep_details['to_username'] . '<br> '.
    		'		<b>' . GMSG_TYPE . '</b>: ' . $reputation->reputation_type($rep_details) . '<br> '.
    		'		<b>' . GMSG_DATE . '</b>: ' . show_date($rep_details['reg_date']) . '</td> '.
    		'	<td><select name="reputation_rate[]"> '.
			'		<option value="5" ' . (($rep_details['reputation_rate']==5) ? 'selected' : '') . ' style="color:#009933; ">' . GMSG_FIVE_TICKS . '</option> '.
			'		<option value="4" ' . (($rep_details['reputation_rate']==4) ? 'selected' : '') . ' style="color:#009933; ">' . GMSG_FOUR_TICKS . '</option> '.
			'		<option value="3" ' . (($rep_details['reputation_rate']==3) ? 'selected' : '') . ' style="color:#666666; ">' . GMSG_THREE_TICKS . '</option> '.
			'		<option value="2" ' . (($rep_details['reputation_rate']==2) ? 'selected' : '') . ' style="color:#FF0000; ">' . GMSG_TWO_TICKS . '</option> '.
			'		<option value="1" ' . (($rep_details['reputation_rate']==1) ? 'selected' : '') . ' style="color:#FF0000; ">' . GMSG_ONE_TICK . '</option> '.
			'		<option value="0" ' . (($rep_details['reputation_rate']==0) ? 'selected' : '') . '>' . GMSG_NA . '</option> '.
			'	</select></td>'.
    		'	<td><textarea name="reputation_content[]" style="width: 100%; height: 50" id="reputation_content">' . $rep_details['reputation_content'] . '</textarea><br> '.
			'		[ <strong><a href="javascript://" onclick="popUp(\'../reputation_details.php?reputation_id=' . $rep_details['reputation_id'] . '\');">' . MSG_DETAILS . '</a></strong> ]</td>'.
			'	<td align="center" class="contentfont"> '.
			'		[ <a href="list_users_reputations.php?do=delete&reputation_id=' . $rep_details['reputation_id'] . $additional_vars . $order_link . $limit_link . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
			'</tr> ';
	}

	$template->set('rep_details_content', $rep_details_content);

	(string) $filter_reps_content = null;

	$filter_reps_content .= display_link('list_users_reputations.php', GMSG_ALL, ((empty($_REQUEST['rep_submitted'])) ? false : true)) . ' | ';
	$filter_reps_content .= display_link('list_users_reputations.php?rep_submitted=yes', AMSG_SUBMITTED, (($_REQUEST['rep_submitted'] == 'yes') ? false : true)) . ' | ';
	$filter_reps_content .= display_link('list_users_reputations.php?rep_submitted=no', AMSG_NOT_SUBMITTED, (($_REQUEST['rep_submitted'] == 'no')) ? false : true);

	$template->set('filter_reps_content', $filter_reps_content);

	$pagination = paginate($start, $limit, $nb_reps, 'list_users_reputations.php', $additional_vars . $order_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_USERS_REP_MANAGEMENT);

	$template_output .= $template->process('list_users_reputations.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>