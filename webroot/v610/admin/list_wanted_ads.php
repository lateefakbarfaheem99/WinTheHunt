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
include_once ('../includes/class_user.php');
include_once ('../includes/class_fees.php');
include_once ('../includes/class_item.php');
include_once ('../includes/functions_item.php');
include_once ('../includes/functions_login.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$item_management_pages = array('open', 'closed', 'suspended');

	$status = !in_array($_REQUEST['status'], $item_management_pages) ? 'open' : $_REQUEST['status'];

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	$item->relative_path = '../'; /* declared because we are in the admin */

	(string) $management_box = NULL;
	(string) $page_handle = 'wanted_ad';

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$form_submitted = false;

	$limit = 20;

	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'w.wanted_ad_id';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$additional_vars = '&status=' . $status . '&keywords=' . $_REQUEST['keywords'] . '&src_wanted_ad_id=' . $_REQUEST['src_wanted_ad_id'];
	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	$show_link = '&show=' . $_REQUEST['show'];

	$form_details = array ('status' => $status, 'keywords' => $_REQUEST['keywords'],
		'src_wanted_ad_id' => $_REQUEST['src_wanted_ad_id'], 'order_field' => $order_field, 'order_type' => $order_type,
		'start' => $start);

	$template->set('form_details', $form_details);

	if (isset($_REQUEST['form_save_settings']))
	{
		if (count($_REQUEST['delete'])>0)
		{
			$delete_array = $db->implode_array($_REQUEST['delete']);

			$item->delete_wanted_ad($delete_array, 0, true);
		}

		if (count($_REQUEST['activate'])>0)
		{
			$activate_array = $db->implode_array($_REQUEST['activate']);## PHP Pro Bid v6.00 counter related routine
			foreach ($_REQUEST['activate'] as $value)
			{
				$cnt_details = $db->get_sql_row("SELECT wanted_ad_id, active, closed, deleted, category_id, addl_category_id FROM 
					" . DB_PREFIX . "wanted_ads WHERE wanted_ad_id='" . intval($value) . "'");
				
				if ($cnt_details['active'] == 0 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0)
				{
					wanted_counter($cnt_details['category_id'], 'add');
					wanted_counter($cnt_details['addl_category_id'], 'add');
				}
			}
			
			$db->query("UPDATE " . DB_PREFIX . "wanted_ads SET active=1 WHERE
					wanted_ad_id IN (" . $activate_array . ")");
		}

		if (count($_REQUEST['inactivate'])>0)
		{
			$inactivate_array = $db->implode_array($_REQUEST['inactivate']);## PHP Pro Bid v6.00 counter related routine
			foreach ($_REQUEST['inactivate'] as $value)
			{
				$cnt_details = $db->get_sql_row("SELECT wanted_ad_id, active, closed, deleted, category_id, addl_category_id FROM 
					" . DB_PREFIX . "wanted_ads WHERE wanted_ad_id='" . intval($value) . "'");
				
				if ($cnt_details['active'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0)
				{
					wanted_counter($cnt_details['category_id'], 'remove');
					wanted_counter($cnt_details['addl_category_id'], 'remove');
				}
			}

			$db->query("UPDATE " . DB_PREFIX . "wanted_ads SET active=0 WHERE
					wanted_ad_id IN (" . $inactivate_array . ")");
		}
	}

	$template->set('management_box', $management_box);

	(string) $search_filter = null;

	$search_filter .= " WHERE w.creation_in_progress=0";## PHP Pro Bid v6.00 we always only show auctions with creation_in_progress = 0!
	if ($status == 'open')
	{
		$subpage_title = AMSG_OPEN_AUCTIONS;
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " w.active=1 AND w.closed=0";
	}
	else if ($status == 'closed')
	{
		$subpage_title = AMSG_CLOSED_AUCTIONS;
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " w.active=1 AND w.closed=1 AND w.end_time<='" . CURRENT_TIME . "'";
	}
	else if ($status == 'suspended')
	{
		$subpage_title = AMSG_SUSPENDED_AUCTIONS;
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " w.active=0";
	}

	if ($_REQUEST['keywords'])
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " MATCH(w.name, w.description) AGAINST ('".$_REQUEST['keywords']."*' IN BOOLEAN MODE)";
		$template->set('keywords', $_REQUEST['keywords']);
	}
	if ($_REQUEST['src_wanted_ad_id'])
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " w.wanted_ad_id='" . $_REQUEST['src_wanted_ad_id'] . "'";
		$template->set('src_wanted_ad_id', $_REQUEST['src_wanted_ad_id']);
	}

	$nb_wanted_ads = $db->count_rows('wanted_ads w', $search_filter);

	$template->set('nb_wanted_ads', $nb_wanted_ads);
	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_wanted_ads));

	$template->set('default_selection_link', '[ <a href="list_wanted_ads.php?start=' . $start . $order_link . $additional_vars . '"><font color="#EEEE00">' . GMSG_DEFAULT . '</font></a> ]');

	$sql_select_items = $db->query("SELECT w.wanted_ad_id, w.name, w.start_time, w.end_time, w.active, u.username,
		c.name AS category_name FROM " . DB_PREFIX ."wanted_ads w
		LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.owner_id
		LEFT JOIN " . DB_PREFIX . "categories c ON c.category_id=w.category_id
		" . $search_filter . "
		ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

	while ($item_details = $db->fetch_array($sql_select_items))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$wanted_ads_content .= '<tr class="' . $background . '"> '.
			'	<td valign="top">' . $item_details['name'] . '<br>' .
			'		[ <a href="../wanted_details.php?wanted_ad_id=' . $item_details['wanted_ad_id'] . '" target="_blank">' . GMSG_VIEW . '</a> ] ';

		$wanted_ads_content .= '</td> '.
		'	<td valign="top">' . AMSG_OWNER . ': <b>' . $item_details['username'] . '</b><br>' .
		'		' . GMSG_START_TIME . ': <b>' . show_date($item_details['start_time']) . '</b><br>' .
		'		' . GMSG_END_TIME  . ': <b>' . show_date($item_details['end_time']) . '</b><br>' .
		'		' . GMSG_CATEGORY . ': <b>' . $item_details['category_name'] . '</b></td> ';

		$wanted_ads_content .= '<td align="center"><table border="0" cellspacing="1" cellpadding="1"> '.
			'	<tr> '.
			'		<td>' . GMSG_ACTIVE . '</td> '.
			'		<td><input name="activate[]" type="checkbox" id="activate[]" value="' . $item_details['wanted_ad_id'] . '" class="checkactivate" ' . (($item_details['active']==1) ? 'checked' : '') . '></td> '.
			'	</tr> '.
			'	<tr> '.
			'		<td>' . GMSG_SUSPENDED . '</td> '.
			'		<td><input name="inactivate[]" type="checkbox" id="inactivate[]" value="' . $item_details['wanted_ad_id'] . '" class="checkinactivate" ' . (($item_details['active']==0) ? 'checked' : '') . '></td> '.
			'	</tr> '.
			'</table></td> ';

		$wanted_ads_content .= '<td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="' . $item_details['wanted_ad_id'] . '" class="checkdelete"></td>'.
		'</tr> ';
	}

	$template->set('wanted_ads_content', $wanted_ads_content);

	(string) $filter_wanted_ads_content = null;

	$filter_wanted_ads_content .= display_link('list_wanted_ads.php?status=open', GMSG_OPEN, ((!$_REQUEST['status'] || $_REQUEST['status'] == 'open') ? false : true)) . ' | ';
	$filter_wanted_ads_content .= display_link('list_wanted_ads.php?status=closed', GMSG_CLOSED, (($_REQUEST['status'] == 'closed') ? false : true)) . ' | ';
	$filter_wanted_ads_content .= display_link('list_wanted_ads.php?status=suspended', GMSG_SUSPENDED, (($_REQUEST['status'] == 'suspended') ? false : true));

	$template->set('filter_wanted_ads_content', $filter_wanted_ads_content);

	$pagination = paginate($start, $limit, $nb_wanted_ads, 'list_wanted_ads.php', $additional_vars . $order_link . $show_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_AUCTIONS_MANAGEMENT);
	$template->set('subpage_title', AMSG_WANTED_ADS_MANAGEMENT);
	$template->set('status', $status);

	$template->set('page_order_itemname', page_order('list_wanted_ads.php', 'w.name', $start, $limit, $additional_vars . $show_link, MSG_ITEM_TITLE));
	$template->set('page_order_start_time', page_order('list_wanted_ads.php', 'w.start_time', $start, $limit, $additional_vars . $show_link, GMSG_START_TIME));

	$template_output .= $template->process('list_wanted_ads.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>