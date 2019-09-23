<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
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

	$template->set('reverse', true);
	
	$item_management_pages = array('open', 'closed', 'unstarted', 'suspended');

 	if (!in_array($_REQUEST['status'], $item_management_pages))
	{
		$template_output .= '<p align="center" class="contentfont">' . AMSG_INVALID_PAGE_SELECTED . '</p>';
	}
	else
	{
		$item = new item();
		$item->setts = &$setts;
		$item->layout = &$layout;
		$item->relative_path = '../'; /* declared because we are in the admin */

		(string) $management_box = NULL;
		(string) $page_handle = 'auction';

		$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

		$form_submitted = false;

		$limit = 20;
		$template->set('limit', $limit);

		$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'r.reverse_id';
		$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

		$additional_vars = '&status=' . $_REQUEST['status'] . '&keywords=' . $_REQUEST['keywords'] . '&src_auction_id=' . $_REQUEST['src_auction_id'] . '&owner_id=' . $_REQUEST['owner_id'];
		$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
		$limit_link = '&start=' . $start . '&limit=' . $limit;
		$show_link = '&show=' . $_REQUEST['show'];

		$form_details = array ('status' => $_REQUEST['status'], 'keywords' => $_REQUEST['keywords'],
			'src_auction_id' => $_REQUEST['src_auction_id'], 'order_field' => $order_field, 'order_type' => $order_type,
			'start' => $start);

		$template->set('form_details', $form_details);

		if (isset($_REQUEST['form_save_settings']))
		{
			if (count($_REQUEST['delete'])>0)
			{
				$delete_array = $db->implode_array($_REQUEST['delete']);

				$item->delete_reverse($delete_array, 0, true, true);
			}
			
			if (count($_REQUEST['activate'])>0)
			{
				$activate_array = $db->implode_array($_REQUEST['activate']);## PHP Pro Bid v6.00 auctions counter - add process - multiple auctions (activate auctions)
				foreach ($_REQUEST['activate'] as $value)
				{
					$cnt_details = $db->get_sql_row("SELECT reverse_id, active, closed, deleted, category_id, addl_category_id FROM 
						" . DB_PREFIX . "reverse_auctions WHERE reverse_id='" . intval($value) . "'");
					
					if ($cnt_details['active'] == 0 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0)
					{
						reverse_counter($cnt_details['category_id'], 'add');
						reverse_counter($cnt_details['addl_category_id'], 'add');
					}
				}
				
				$sql_update_auctions = $db->query("UPDATE " . DB_PREFIX . "reverse_auctions SET active=1 WHERE
					reverse_id IN (" . $activate_array . ")");
			}

			if (count($_REQUEST['inactivate'])>0)
			{
				$inactivate_array = $db->implode_array($_REQUEST['inactivate']);## PHP Pro Bid v6.00 auctions counter - remove process - multiple auctions (inactivate auctions)
				foreach ($_REQUEST['inactivate'] as $value)
				{
					$cnt_details = $db->get_sql_row("SELECT reverse_id, active, closed, deleted, category_id, addl_category_id FROM 
						" . DB_PREFIX . "reverse_auctions WHERE reverse_id='" . intval($value) . "'");
					
					if ($cnt_details['active'] == 0 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0)
					{
						reverse_counter($cnt_details['category_id'], 'remove');
						reverse_counter($cnt_details['addl_category_id'], 'remove');
					}
				}
				
				$sql_update_auctions = $db->query("UPDATE " . DB_PREFIX . "reverse_auctions SET active=0 WHERE
					reverse_id IN (" . $inactivate_array . ")");
			}
		}
		if ($_REQUEST['do'] == 'marked_deleted')
		{
			$sql_select_marked_deleted = $db->query("SELECT reverse_id FROM " . DB_PREFIX . "reverse_auctions WHERE deleted=1");

			$delete_ids = null;

			while ($deleted_details = $db->fetch_array($sql_select_marked_deleted))
			{
				$delete_ids[] = $deleted_details['reverse_id'];
			}

			$delete_array = $db->implode_array($delete_ids);

			$item->delete_reverse($delete_array, 0, true, true);
			$template->set('msg_changes_saved', '<p align="center">' . AMSG_MARKED_DELETED_REMOVED . '</p>');
		}

		$template->set('management_box', $management_box);

		(string) $search_filter = null;

		$search_filter .= " WHERE r.creation_in_progress=0";
		if ($_REQUEST['status'] == 'open')
		{
			$subpage_title = AMSG_OPEN_AUCTIONS;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " r.active=1 AND r.closed=0";
		}
		else if ($_REQUEST['status'] == 'closed')
		{
			$subpage_title = AMSG_CLOSED_AUCTIONS;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " r.active=1 AND r.closed=1 AND r.end_time<='" . CURRENT_TIME . "'";
		}
		else if ($_REQUEST['status'] == 'unstarted')
		{
			$subpage_title = AMSG_UNSTARTED_AUCTIONS;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " r.active=1 AND r.closed=1 AND r.end_time>'" . CURRENT_TIME . "'";
		}
		else if ($_REQUEST['status'] == 'suspended')
		{
			$subpage_title = AMSG_SUSPENDED_AUCTIONS;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " r.active=0";
		}

		if ($_REQUEST['keywords'])
		{
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " MATCH(r.name, r.description) AGAINST ('".$_REQUEST['keywords']."*' IN BOOLEAN MODE)";
			$template->set('keywords', $_REQUEST['keywords']);
		}
		if ($_REQUEST['src_auction_id'])
		{
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " r.reverse_id='" . $_REQUEST['src_auction_id'] . "'";
			$template->set('src_auction_id', $_REQUEST['src_auction_id']);
		}
		if ($_REQUEST['owner_id'])
		{
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " r.owner_id='" . $_REQUEST['owner_id'] . "'";
		}

		$nb_auctions = $db->count_rows('reverse_auctions r', $search_filter);

		$template->set('nb_auctions', $nb_auctions);
		$template->set('query_results_message', display_pagination_results($start, $limit, $nb_auctions));

		$template->set('default_selection_link', '[ <a href="list_reverse.php?start=' . $start . $order_link . $additional_vars . '"><font color="#EEEE00">' . GMSG_DEFAULT . '</font></a> ]');

		$sql_select_items = $db->query("SELECT r.reverse_id, r.name, r.start_time, r.end_time, r.active, u.username, r.deleted, 
			c.name AS category_name, w.winner_id FROM
			" . DB_PREFIX ."reverse_auctions r
			LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=r.owner_id
			LEFT JOIN " . DB_PREFIX . "reverse_categories c ON c.category_id=r.category_id
			LEFT JOIN " . DB_PREFIX . "reverse_winners w ON w.reverse_id=r.reverse_id
			" . $search_filter . "
			GROUP BY r.reverse_id
			ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

		while ($item_details = $db->fetch_array($sql_select_items))
		{
			$background = ($counter++%2) ? 'c1' : 'c2';

			$auctions_content .= '<tr class="' . $background . '"> '.
	      	'	<td valign="top">' . $item_details['name'] . 
	      	'		<br>' .
	      	'		[ <a href="../reverse_details.php?reverse_id=' . $item_details['reverse_id'] . '" target="_blank">' . GMSG_VIEW . '</a> ] '.
	      	//'		[ <a href="list_reverse.php?do=edit_auction&reverse_id=' . $item_details['reverse_id'] . $additional_vars . $order_link . $limit_link . $show_link . '">' . AMSG_EDIT . '</a> ]'.
	      	(($item_details['deleted'] == 1) ? '<br>[ <b>' . AMSG_AUCT_MARKED_DELETED . '</b> ]' : '');

	      $auctions_content .= '</td> '.
				'	<td valign="top">' . AMSG_OWNER . ': <b>' . $item_details['username'] . '</b><br>' .
	      	'		' . GMSG_START_TIME . ': <b>' . show_date($item_details['start_time']) . '</b><br>' .
	      	'		' . GMSG_END_TIME  . ': <b>' . show_date($item_details['end_time']) . '</b><br>' .
	      	'		' . GMSG_CATEGORY . ': <b>' . $item_details['category_name'] . '</b></td> ';

      	$auctions_content .= '<td align="center"><table border="0" cellspacing="1" cellpadding="1"> '.
	      	'	<tr> '.
	      	'		<td>' . GMSG_ACTIVE . '</td> '.
	      	'		<td><input name="activate[]" type="checkbox" id="activate[]" value="' . $item_details['reverse_id'] . '" class="checkactivate" ' . (($item_details['active']==1) ? 'checked' : '') . '></td> '.
	      	'	</tr> '.
	      	'	<tr> '.
	      	'		<td>' . GMSG_SUSPENDED . '</td> '.
	      	'		<td><input name="inactivate[]" type="checkbox" id="inactivate[]" value="' . $item_details['reverse_id'] . '" class="checkinactivate" ' . (($item_details['active']==0) ? 'checked' : '') . '></td> '.
	      	'	</tr> '.
	      	'</table></td> ';

			$auctions_content .= '<td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="' . $item_details['reverse_id'] . '" class="checkdelete"></td>'.
				'</tr> ';
		}

		$template->set('auctions_content', $auctions_content);

		$pagination = paginate($start, $limit, $nb_auctions, 'list_reverse.php', $additional_vars . $order_link . $show_link);

		$template->set('pagination', $pagination);

		$template->set('header_section', AMSG_REVERSE_AUCTIONS_MANAGEMENT);
		$template->set('subpage_title', $subpage_title);
		$template->set('status', $_REQUEST['status']);

		$template->set('page_order_itemname', page_order('list_reverse.php', 'r.name', $start, $limit, $additional_vars . $show_link, MSG_ITEM_TITLE));
		$template->set('page_order_start_time', page_order('list_reverse.php', 'r.start_time', $start, $limit, $additional_vars . $show_link, GMSG_START_TIME));

		$nb_marked_deleted_items = $db->count_rows('reverse_auctions', "WHERE deleted=1");
		$template->set('nb_marked_deleted_items', $nb_marked_deleted_items);

		$template_output .= $template->process('list_auctions.tpl.php');
	}

	include_once ('footer.php');

	echo $template_output;
}
?>