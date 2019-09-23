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

	$item_management_pages = array('open', 'closed', 'unstarted', 'suspended', 'approval');

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

		$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'a.auction_id';
		$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

		$additional_vars = '&status=' . $_REQUEST['status'] . '&keywords=' . $_REQUEST['keywords'] . '&src_auction_id=' . $_REQUEST['src_auction_id'] . '&owner_id=' . $_REQUEST['owner_id'];
		$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
		$limit_link = '&start=' . $start . '&limit=' . $limit;
		$show_link = '&show=' . $_REQUEST['show'];

		$form_details = array ('status' => $_REQUEST['status'], 'keywords' => $_REQUEST['keywords'],
			'src_auction_id' => $_REQUEST['src_auction_id'], 'order_field' => $order_field, 'order_type' => $order_type,
			'start' => $start);

		$template->set('form_details', $form_details);

		if ($_REQUEST['do'] == 'edit_auction')
		{
			define('EDIT_AUCTION', 1);

			$frmchk_error = false;

			$start_time_id = 1;
			$end_time_id = 2;

			$custom_fld = new custom_field();
			$item_details = $db->get_sql_row("SELECT * FROM
				" . DB_PREFIX . "auctions WHERE auction_id=" . $_REQUEST['auction_id']);

			$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
				user_id=" . $item_details['owner_id']);## PHP Pro Bid v6.00 set here the checkboxes
			
			$start_time = $item_details['start_time'];## PHP Pro Bid v6.00 set here the checkboxes
			$item_details = $item->edit_set_checkboxes($item_details);
			
			if ($_REQUEST['box_submit'] == 1 || isset($_REQUEST['form_edit_proceed']))
			{
				$item_details = $_POST;
				$item_details['description'] = $db->rem_special_chars((($_POST['description_main']) ? $_POST['description_main'] : $item_details['description']));
				$item_details['start_time'] = ($item_details['start_time_type'] == 'now' || ($start_time < CURRENT_TIME)) ? $start_time : get_box_timestamp($item_details, $start_time_id);
				$item_details['end_time'] = ($item_details['end_time_type'] == 'duration') ? ($item_details['start_time'] + $item_details['duration'] * 86400) : get_box_timestamp($item_details, $end_time_id);
				$item_details['direct_payment'] = (count($_POST['payment_gateway'])) ? $db->implode_array($_POST['payment_gateway']) : $item_details['direct_payment'];
				$item_details['payment_methods'] = (count($_POST['payment_option'])) ? $db->implode_array($_POST['payment_option']) : $item_details['payment_methods'];
				$custom_fld->save_vars($_POST);
				
				if ($item_details['auction_type'] == 'first_bidder')
				{
					$item_details['fb_decrement_interval'] = $item->convert_fb_decrement($item_details, 'STN');
				}
			}
			else
			{
				$custom_fld->save_edit_vars($_REQUEST['auction_id'], 'auction');## PHP Pro Bid v6.00 upload initial images
				$media_details = $item->get_media_values($_REQUEST['auction_id']);
				$item_details['ad_image'] = $media_details['ad_image'];
				$item_details['ad_video'] = $media_details['ad_video'];
				$item_details['ad_dd'] = $media_details['ad_dd'];

				$fb_interval = $item->convert_fb_decrement($item_details, 'NTS');
				$item_details['fb_hours'] = $fb_interval['fb_hours'];
				$item_details['fb_minutes'] = $fb_interval['fb_minutes'];
				$item_details['fb_seconds'] = $fb_interval['fb_seconds'];		
			}

			if (isset($_REQUEST['form_edit_proceed']))
			{
				define ('FRMCHK_ITEM', 1);
				$frmchk_details = $item_details;

				include ('../includes/procedure_frmchk_item.php'); /* Formchecker for user creation/edit */

				if ($fv->is_error())
				{
					$template->set('display_formcheck_errors', $fv->display_errors());
					$frmchk_error = true;
				}
				else
				{
					$form_submitted = true;

					$template->set('msg_changes_saved', $msg_changes_saved);## PHP Pro Bid v6.00 item update function call
					
					$old_category_id = intval($_REQUEST['old_category_id']);
					$old_addl_category_id = intval($_REQUEST['old_addl_category_id']);
					
					if ($item_details['start_time'] < CURRENT_TIME)
					{
						if ($old_category_id != $item_details['category_id'])
						{
							auction_counter($old_category_id, 'remove', $item_details['auction_id']);					
							auction_counter($item_details['category_id'], 'add', $item_details['auction_id']);
						}
						if ($old_addl_category_id != $item_details['addl_category_id'])
						{
							auction_counter($old_addl_category_id, 'remove', $item_details['auction_id']);					
							auction_counter($item_details['addl_category_id'], 'add', $item_details['auction_id']);
						}
					}					
					
					$old_start_time = $db->get_sql_field("SELECT start_time FROM " . DB_PREFIX . "auctions WHERE 
						auction_id='" . $item_details['auction_id'] . "' AND owner_id='" . $session->value('user_id') . "'", 'start_time');
							
					if ($old_start_time > CURRENT_TIME && $item_details['start_time_type'] == 'now')		
					{
						auction_counter($item_details['category_id'], 'add', $item_details['auction_id']);
						auction_counter($item_details['addl_category_id'], 'add', $item_details['auction_id']);
					}
					
					$item->edit_auction = true;
					$item->insert($item_details, $user_details['user_id'], 'auction', false, true);
				}
			}

			if (!$form_submitted)
			{## PHP Pro Bid v6.00 <<BEGIN>> media upload sequence
				if (empty($_POST['file_upload_type']))
				{
					$template->set('media_upload_fields', $item->upload_manager($item_details));
				}
				else if (is_numeric($_POST['file_upload_id'])) /* means we remove a file / media url */
				{
					$media_upload = $item->media_removal($item_details, $item_details['file_upload_type'], $item_details['file_upload_id']);
					$media_upload_fields = $media_upload['display_output'];

					$item_details['ad_image'] = $media_upload['post_details']['ad_image'];
					$item_details['ad_video'] = $media_upload['post_details']['ad_video'];
					$item_details['ad_dd'] = $media_upload['post_details']['ad_dd'];

					$template->set('media_upload_fields', $media_upload_fields);
				}
				else /* means we have a file upload */
				{
					$media_upload = $item->media_upload($item_details, $item_details['file_upload_type'], $_FILES);
					$media_upload_fields = $media_upload['display_output'];

					$item_details['ad_image'] = $media_upload['post_details']['ad_image'];
					$item_details['ad_video'] = $media_upload['post_details']['ad_video'];
					$item_details['ad_dd'] = $media_upload['post_details']['ad_dd'];

					$template->set('media_upload_fields', $media_upload_fields);
				}## PHP Pro Bid v6.00 <<END>> media upload sequence

				$template->set('auction_edit', 1);
				$template->set('do', $_REQUEST['do']);
				$template->set('item_details', $item_details);
				$template->set('user_details', $user_details);

				$sell_item_header = '<table width="100%" border="0" cellpadding="3" cellspacing="3" class="border"> ' .
	      		'<tr><td class="c3"><b>' . MSG_EDIT_AUCTION . '</b></td></tr></table>';

				$template->set('sell_item_header', $sell_item_header);

				$template->set('post_url', 'list_auctions.php');

				$template->set('path_relative', '../');
				$template->change_path('../templates/');

				include_once('../includes/page_edit_auction.php');

				$management_box = $template->process('edit_auction.tpl.php');
				$template->change_path('templates/');
			}
		}
		else if (isset($_REQUEST['form_save_settings']) || $_REQUEST['submit_auctions'] == 1)
		{
			$template->set('msg_changes_saved', $msg_changes_saved);
			
			if (count($_REQUEST['delete'])>0)
			{
				$delete_array = $db->implode_array($_REQUEST['delete']);

				$item->delete($delete_array, 0, true, true);
			}

			if (count($_REQUEST['approve'])>0)
			{
				
				$approve_array = $db->implode_array($_REQUEST['approve']);## PHP Pro Bid v6.00 auctions counter - add process - multiple auctions (approve auctions)
				foreach ($_REQUEST['approve'] as $value)
				{
					$cnt_details = $db->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM 
						" . DB_PREFIX . "auctions WHERE auction_id='" . intval($value) . "'");
					
					if ($cnt_details['active'] == 1 && $cnt_details['approved'] == 0 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store')
					{
						auction_counter($cnt_details['category_id'], 'add', $cnt_details['auction_id']);
						auction_counter($cnt_details['addl_category_id'], 'add', $cnt_details['auction_id']);
					}
					
					$mail_input_id = $cnt_details['auction_id'];
					include('../language/' . $setts['site_lang'] . '/mails/auction_approval_user_notification.php');
				}
				
				$sql_update_auctions = $db->query("UPDATE " . DB_PREFIX . "auctions SET approved=1 WHERE
					auction_id IN (" . $approve_array . ")");
			}

			if (count($_REQUEST['activate'])>0)
			{
				$activate_array = $db->implode_array($_REQUEST['activate']);## PHP Pro Bid v6.00 auctions counter - add process - multiple auctions (activate auctions)
				foreach ($_REQUEST['activate'] as $value)
				{
					$cnt_details = $db->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM 
						" . DB_PREFIX . "auctions WHERE auction_id='" . intval($value) . "'");
					
					if ($cnt_details['active'] == 0 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store')
					{
						auction_counter($cnt_details['category_id'], 'add', $cnt_details['auction_id']);
						auction_counter($cnt_details['addl_category_id'], 'add', $cnt_details['auction_id']);
					}
				}
				
				$sql_update_auctions = $db->query("UPDATE " . DB_PREFIX . "auctions SET active=1 WHERE
					auction_id IN (" . $activate_array . ")");
				
				
			}

			if (count($_REQUEST['inactivate'])>0)
			{
				$inactivate_array = $db->implode_array($_REQUEST['inactivate']);## PHP Pro Bid v6.00 auctions counter - remove process - multiple auctions (inactivate auctions)
				foreach ($_REQUEST['inactivate'] as $value)
				{
					$cnt_details = $db->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM 
						" . DB_PREFIX . "auctions WHERE auction_id='" . intval($value) . "'");
					
					if ($cnt_details['active'] == 1 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store')
					{
						auction_counter($cnt_details['category_id'], 'remove', $cnt_details['auction_id']);
						auction_counter($cnt_details['addl_category_id'], 'remove', $cnt_details['auction_id']);
					}
				}
				
				$sql_update_auctions = $db->query("UPDATE " . DB_PREFIX . "auctions SET active=0 WHERE
					auction_id IN (" . $inactivate_array . ")");
				
				if ($_REQUEST['status'] != 'suspended')
				{
					$mail_input_id = $inactivate_array;
					$suspension_reason = $db->rem_special_chars($_REQUEST['auction_suspension_reason']);
	
					include('../language/' . $setts['site_lang'] . '/mails/auctions_suspended_email.php');	
				}
			}

			if (count($_REQUEST['close'])>0)
			{
				$close_array = $db->implode_array($_REQUEST['close']);
				foreach ($_REQUEST['close'] as $value)
				{
					$close_item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE auction_id='" . intval($value) . "'");
					$item->close($close_item_details, false, false);
				}
				
				$mail_input_id = $close_array;
				$close_reason = $db->rem_special_chars($_REQUEST['auction_close_reason']);
	
				include('../language/' . $setts['site_lang'] . '/mails/auctions_closed_email.php');	
			}
		}
		
		if ($_REQUEST['do'] == 'marked_deleted')
		{
			$sql_select_marked_deleted = $db->query("SELECT auction_id FROM " . DB_PREFIX . "auctions WHERE deleted=1");

			$delete_ids = null;

			while ($deleted_details = $db->fetch_array($sql_select_marked_deleted))
			{
				$delete_ids[] = $deleted_details['auction_id'];
			}

			$delete_array = $db->implode_array($delete_ids);

			$item->delete($delete_array, 0, true, true);
			$template->set('msg_changes_saved', '<p align="center">' . AMSG_MARKED_DELETED_REMOVED . '</p>');
		}

		$template->set('management_box', $management_box);

		(string) $search_filter = null;

		$search_filter .= " WHERE a.creation_in_progress=0 AND a.is_draft=0 ";## PHP Pro Bid v6.00 we always only show auctions with creation_in_progress = 0!
		if ($_REQUEST['status'] == 'open')
		{
			$subpage_title = AMSG_OPEN_AUCTIONS;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " a.active=1 AND a.closed=0 AND a.approved=1";
		}
		else if ($_REQUEST['status'] == 'closed')
		{
			$subpage_title = AMSG_CLOSED_AUCTIONS;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " a.active=1 AND a.closed=1 AND a.approved=1 AND a.end_time<='" . CURRENT_TIME . "'";
		}
		else if ($_REQUEST['status'] == 'unstarted')
		{
			$subpage_title = AMSG_UNSTARTED_AUCTIONS;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " a.active=1 AND a.closed=1 AND a.approved=1 AND a.end_time>'" . CURRENT_TIME . "'";
		}
		else if ($_REQUEST['status'] == 'suspended')
		{
			$subpage_title = AMSG_SUSPENDED_AUCTIONS;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " a.active=0 AND a.approved=1";
		}
		else if ($_REQUEST['status'] == 'approval')
		{
			$subpage_title = AMSG_AUCTIONS_AWAITING_APPROVAL;
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " a.approved=0";
		}

		if ($_REQUEST['keywords'])
		{
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " MATCH(a.name, a.description) AGAINST ('".$_REQUEST['keywords']."*' IN BOOLEAN MODE)";
			$template->set('keywords', $_REQUEST['keywords']);
		}
		if ($_REQUEST['src_auction_id'])
		{
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " a.auction_id='" . $_REQUEST['src_auction_id'] . "'";
			$template->set('src_auction_id', $_REQUEST['src_auction_id']);
		}
		if ($_REQUEST['owner_id'])
		{
			$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " a.owner_id='" . $_REQUEST['owner_id'] . "'";
		}

		$nb_auctions = $db->count_rows('auctions a', $search_filter);

		$template->set('nb_auctions', $nb_auctions);
		$template->set('query_results_message', display_pagination_results($start, $limit, $nb_auctions));

		$template->set('default_selection_link', '[ <a href="list_auctions.php?start=' . $start . $order_link . $additional_vars . '"><font color="#EEEE00">' . GMSG_DEFAULT . '</font></a> ]');

		$sql_select_items = $db->query("SELECT a.auction_id, a.name, a.start_time, a.end_time, a.active, u.username, a.deleted, 
			c.name AS category_name, w.winner_id FROM
			" . DB_PREFIX ."auctions a
			LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
			LEFT JOIN " . DB_PREFIX . "categories c ON c.category_id=a.category_id
			LEFT JOIN " . DB_PREFIX . "winners w ON w.auction_id=a.auction_id
			" . $search_filter . "
			GROUP BY a.auction_id
			ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

		while ($item_details = $db->fetch_array($sql_select_items))
		{
			$background = ($counter++%2) ? 'c1' : 'c2';

			$auctions_content .= '<tr class="' . $background . '"> '.
	      	'	<td valign="top">' . $item_details['name'] . 
				(($item_details['winner_id']) ? ' <img src="images/item_sold.gif" border="0" alt="' . MSG_ITEM_WAS_SOLD . '" align="absmiddle">' : '') . '<br>' . $item->listed_in($item_details, true) .	      	
	      	'		<br>' .
	      	'		[ <a href="../auction_details.php?auction_id=' . $item_details['auction_id'] . '" target="_blank">' . GMSG_VIEW . '</a> ] '.
	      	'		[ <a href="list_auctions.php?do=edit_auction&auction_id=' . $item_details['auction_id'] . $additional_vars . $order_link . $limit_link . $show_link . '">' . AMSG_EDIT . '</a> ]'.
	      	(($item_details['deleted'] == 1) ? '<br>[ <b>' . AMSG_AUCT_MARKED_DELETED . '</b> ]' : '');


	      $auctions_content .= '</td> '.
				'	<td valign="top">' . AMSG_OWNER . ': <b>' . $item_details['username'] . '</b><br>' .
	      	'		' . GMSG_START_TIME . ': <b>' . show_date($item_details['start_time']) . '</b><br>' .
	      	'		' . GMSG_END_TIME  . ': <b>' . show_date($item_details['end_time']) . '</b><br>' .
	      	'		' . GMSG_CATEGORY . ': <b>' . $item_details['category_name'] . '</b></td> ';

	      if ($_REQUEST['status'] == 'approval')
	      {
				$auctions_content .= '<td align="center"><input name="approve[]" type="checkbox" id="approve[]" value="' . $item_details['auction_id'] . '" class="checkapprove"></td>';
	      }
	      else
	      {
				$auctions_content .= '<td align="center"><table border="0" cellspacing="1" cellpadding="1"> '.
               '	<tr> '.
               '		<td>' . GMSG_ACTIVE . '</td> '.
					'		<td><input name="activate[]" type="checkbox" id="activate[]" value="' . $item_details['auction_id'] . '" class="checkactivate" ' . (($item_details['active']==1) ? 'checked' : '') . '></td> '.
               '	</tr> '.
               '	<tr> '.
					'		<td>' . GMSG_SUSPENDED . '</td> '.
					'		<td><input name="inactivate[]" type="checkbox" id="inactivate[]" value="' . $item_details['auction_id'] . '" class="checkinactivate" ' . (($item_details['active']==0) ? 'checked' : '') . '></td> '.
               '	</tr> '.
            	'</table></td> ';
	      }
	      
	      if ($_REQUEST['status'] == 'open')
	      {
				$auctions_content .= '<td align="center"><input name="close[]" type="checkbox" id="close[]" value="' . $item_details['auction_id'] . '" class="checkclose"></td>';
	      }

			$auctions_content .= '<td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="' . $item_details['auction_id'] . '" class="checkdelete"></td>'.
				'</tr> ';
		}

		$template->set('auctions_content', $auctions_content);

		$pagination = paginate($start, $limit, $nb_auctions, 'list_auctions.php', $additional_vars . $order_link . $show_link);

		$template->set('pagination', $pagination);

		$template->set('header_section', AMSG_AUCTIONS_MANAGEMENT);
		$template->set('subpage_title', $subpage_title);
		$template->set('status', $_REQUEST['status']);

		$template->set('page_order_itemname', page_order('list_auctions.php', 'a.name', $start, $limit, $additional_vars . $show_link, MSG_ITEM_TITLE));
		$template->set('page_order_start_time', page_order('list_auctions.php', 'a.start_time', $start, $limit, $additional_vars . $show_link, GMSG_START_TIME));

		$nb_marked_deleted_items = $db->count_rows('auctions', "WHERE deleted=1");
		$template->set('nb_marked_deleted_items', $nb_marked_deleted_items);

		$template_output .= $template->process('list_auctions.tpl.php');
	}

	include_once ('footer.php');

	echo $template_output;
}
?>