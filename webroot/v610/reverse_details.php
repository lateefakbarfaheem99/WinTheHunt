<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_user.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_item.php');
include_once ('includes/functions_item.php');
include_once ('includes/class_messaging.php');
include_once ('includes/class_reputation.php');

require ('global_header.php');

(array) $user_details = null;

$start_time_id = 1;
$end_time_id = 2;

$item = new item();
$item->setts = &$setts;
$item->layout = &$layout;

$db->categories_table = 'reverse_categories';

$reputation = new reputation();
$reputation->setts = &$setts;

$page_handle = 'reverse';

$addl_query = ($session->value('adminarea')!="Active") ? " AND active=1" : '';

$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "reverse_auctions WHERE
	reverse_id='" . intval($_REQUEST['reverse_id']) . "'" . $addl_query);

if ($session->value('user_id') == $item_details['owner_id'])
{
	$bid_id = intval($_REQUEST['bid_id']);

	$reload_row = false;
	if ($_REQUEST['do'] == 'accept_bid')
	{
		// we can only award the project to a pending or declined bid
		$is_bid = $db->count_rows('reverse_bids', "WHERE bid_id='" . $bid_id . "' AND bid_status!='accepted'");

		if ($is_bid)
		{
			$reload_row = true;
			$item->accept_reverse_bid($item_details, $bid_id);
			$item->reverse_close($item_details);

			$msg_changes_saved = MSG_RA_WINNER_AWARDED_SUCCESS;
		}
		else
		{
			$msg_changes_saved = MSG_RA_WINNER_AWARDED_FAILURE;
		}
	}
	else if ($_REQUEST['do'] == 'decline_bid')
	{
		// we can only decline a pending bid
		$is_bid = $db->count_rows('reverse_bids', "WHERE bid_id='" . $bid_id . "' AND bid_status='pending'");

		if ($is_bid)
		{
			$reload_row = true;
			$item->reject_reverse_bid($bid_id);
			$msg_changes_saved = MSG_RA_BID_DECLINED_SUCCESS;
		}
		else
		{
			$msg_changes_saved = MSG_RA_BID_DECLINED_FAILURE;
		}
	}
	else if ($bid_id)
	{
		$msg_changes_saved = MSG_INVALID_OPTION_SELECTED;
	}

	if ($reload_row)
	{
		$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "reverse_auctions WHERE
			reverse_id='" . intval($_REQUEST['reverse_id']) . "'" . $addl_query);
	}
	
	$template->set('msg_changes_saved', '<p align="center">' . $msg_changes_saved . '</p>');
}



$main_category_id = $db->main_category($item_details['category_id']);

$can_view = false;
if ($item_details['reverse_id'])
{
	if (($session->value('adminarea')=="Active") || ($item_details['active'] ==1) || ($session->value('user_id') == $item_details['owner_id']))
	{
		$can_view = true;	
	}
}

if ($can_view)
{
	if ($_REQUEST['do'] == 'download_file')
	{
		$file_name = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE 
			reverse_id='" . intval($_REQUEST['reverse_id']) . "' AND 
			media_url LIKE '%" . $db->rem_special_chars($_REQUEST['file_name']) . "'", 'media_url');
		
		header('Location: ' . $file_name);
	}
	$blocked_user = blocked_user($session->value('user_id'), $item_details['owner_id']);
	$template->set('blocked_user', $blocked_user);

	if ($blocked_user)
	{
		$template->set('block_reason_msg', block_reason($session->value('user_id'), $item_details['owner_id']));
	}

	$template->set('reverse_id', intval($_REQUEST['reverse_id']));## PHP Pro Bid v6.00 add click
	$sql_add_click = $db->query("UPDATE " . DB_PREFIX . "reverse_auctions SET nb_clicks=nb_clicks+1 WHERE 
		reverse_id=" . $item_details['reverse_id']);

	$user_details = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);

	$custom_fld = new custom_field();

	$blocked_user = blocked_user($session->value('user_id'), $item_details['owner_id'], 'message');
		
	$template->set('msg_changes_saved', $msg_changes_saved);

	$custom_fld->save_edit_vars($item_details['reverse_id'], $page_handle);

	$media_details = $item->get_media_values(intval($_REQUEST['reverse_id']), false, true);
	$item_details['ad_image'] = $media_details['ad_image'];
	$item_details['ad_video'] = $media_details['ad_video'];
	$item_details['ad_dd'] = $media_details['ad_dd'];

	$template->set('item_details', $item_details);

	$template->set('user_details', $user_details);

	$template->set('session', $session);
	$template->set('item', $item);

	$template->set('item_can_bid', $item->reverse_can_bid($session->value('user_id'), $item_details));

	$template->set('main_category_display', category_navigator($item_details['category_id'], true, false, 'reverse_auctions.php', null, null, true));
	$template->set('addl_category_display', category_navigator($item_details['addl_category_id'], true, false, 'reverse_auctions.php', null, null, true));

	/* to do */
	$template->set('direct_payment_box', $item->reverse_direct_payment_box($item_details, $session->value('user_id'))); 
	$template->set('ad_display', 'live'); /* if ad_display = preview, then some table fields will be disabled */

	$template->set('your_bid', $item->your_bid($item_details['auction_id'], $session->value('user_id'), true));

	$tax = new tax();
	$seller_country = $tax->display_countries($user_details['country']);
	$template->set('seller_country', $seller_country);
	
	$item->show_hidden_bid = ($item_details['owner_id'] == $session->value('user_id') || $session->value('adminarea') == 'Active') ? true : false;
	$template->set('winners_content', $item->reverse_winners_show($item_details));

	$winners_message_board = $item->reverse_pmb_link($item_details, $session->value('user_id'));
	$template->set('winners_message_board', $winners_message_board);

	$custom_fld->new_table = ($setts['default_theme'] == 'ultra') ? true : false;
	$custom_fld->field_colspan = 1;
	$custom_sections_table = $custom_fld->display_sections($item_details, $page_handle, true, $item_details['reverse_id'], $db->main_category($item_details['category_id']));
	$template->set('custom_sections_table', $custom_sections_table);

	$ad_image_thumbnails = $item->item_media_thumbnails($item_details, 1);
	$full_size_images_link = $item->full_size_images($item_details);
	$template->set('ad_image_thumbnails', $ad_image_thumbnails . '<br>' . $full_size_images_link);

	$ad_video_thumbnails = $item->item_media_thumbnails($item_details, 2);
	$template->set('ad_video_thumbnails', $ad_video_thumbnails);

	$ad_dd_thumbnails = $item->item_media_thumbnails($item_details, 3, true, true);
	$template->set('ad_dd_thumbnails', $ad_dd_thumbnails);
	
	$video_play_file = (!empty($_REQUEST['video_name'])) ? $_REQUEST['video_name'] : $item_details['ad_video'][0];
	$ad_video_main_box = $item->video_box($video_play_file);
	$template->set('ad_video_main_box', $ad_video_main_box);## PHP Pro Bid v6.00 auction questions
	
	/*
	## add the search details back link if the auction was accessed through the search page.
	(string) $search_url = null;
	if ($_REQUEST['auction_search'] == 1)
	{
		$additional_vars = '&option=' . $_REQUEST['option'] . '&src_auction_id=' . $_REQUEST['src_auction_id'] . '&keywords_search=' . $_REQUEST['keywords_search'] .
			'&buyout_price=' . $_REQUEST['buyout_price'] . '&reserve_price=' . $_REQUEST['reserve_price'] . 
			'&quantity=' . $_REQUEST['quantity'] . '&enable_swap=' . $_REQUEST['enable_swap'] . 
			'&list_in=' . $_REQUEST['list_in'] . '&results_view=' . $_REQUEST['results_view'] . 
			'&country=' . $_REQUEST['country'] . '&zip_code=' . $_REQUEST['zip_code'] . '&username=' . $_REQUEST['username'] . 
			'&basic_search=' . $_REQUEST['basic_search'];		
			
		$search_url = 'auction_search.php?start=0' . $additional_vars;
		$template->set('search_url', $search_url);	
	}
	*/
	
	// now display bids placed and their status, and also create the assign winner/decline bid engines
	$bids_placed_table = null;
	if ($item_details['nb_bids'])
	{		
		(string) $filter_bids_content = null;
	
		$filter_bids_content .= display_link('reverse_details.php?reverse_id=' . $item_details['reverse_id'], GMSG_ALL, ((!$_REQUEST['bid_status']) ? false : true)) . ' | ';
		$filter_bids_content .= display_link('reverse_details.php?reverse_id=' . $item_details['reverse_id'] . '&bid_status=accepted', GMSG_ACCEPTED, (($_REQUEST['bid_status'] == 'accepted') ? false : true)) . ' | ';
		$filter_bids_content .= display_link('reverse_details.php?reverse_id=' . $item_details['reverse_id'] . '&bid_status=declined', GMSG_DECLINED, (($_REQUEST['bid_status'] == 'declined') ? false : true)) . ' | ';
		$filter_bids_content .= display_link('reverse_details.php?reverse_id=' . $item_details['reverse_id'] . '&bid_status=pending', GMSG_PENDING, (($_REQUEST['bid_status'] == 'pending') ? false : true));

		$template->set('filter_bids_content', $filter_bids_content);
		
		$bid_status = (in_array($_REQUEST['bid_status'], array('accepted', 'declined', 'pending'))) ? $_REQUEST['bid_status'] : null;
		
		$sql_select_bids = $db->query("SELECT b.*, u.username, u.state, u.country  
			FROM " . DB_PREFIX . "reverse_bids b
			LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=b.bidder_id 
			WHERE b.reverse_id='" . $item_details['reverse_id'] . "' AND b.active=1 AND b.payment_status='confirmed' " . 
			((!empty($bid_status)) ? "AND bid_status='" . $bid_status . "'" : ''));
		
		$is_bids = $db->num_rows($sql_select_bids);
		
		if ($is_bids)	
		{
			while ($bid_details = $db->fetch_array($sql_select_bids)) 
			{			
				$state_name = $item->item_location($bid_details, false);
				$country_name = $tax->display_countries($bid_details['country']);
				$bidder_location = ((!empty($state_name)) ?  $state_name . ', ' : '') . $country_name;
	
				$sealed_bid = ($item_details['hidden_bidding'] && $session->value('user_id') != $item_details['owner_id'] && $session->value('adminarea') != 'Active' && $session->value('user_id') != $bid_details['bidder_id']) ? true : false;
				
				if ($sealed_bid)
				{
					$bid_amount = MSG_BID_SEALED;
				}
				else 
				{
					$bid_amount = $fees->display_amount($bid_details['bid_amount'], $item_details['currency']);
					if ($bid_details['apply_tax'])
					{
						$auction_tax = $tax->auction_tax($bid_details['bidder_id'], $setts['enable_tax'], $item_details['owner_id']);
						$bid_amount .= $auction_tax['display_short'];
					}
				}

				$total_comments = $db->count_rows('reputation', "WHERE user_id='" . $bid_details['bidder_id'] . "' AND submitted='1' AND reverse_id>0");
				$reputation_output = $reputation->calc_reputation($bid_details['bidder_id'], null, true);
				
				$bidder_reputation = $total_comments . ' ' . MSG_REVIEWS_S . '<br>' . $reputation_output['percentage'] . ' ' . MSG_POSITIVE_COMMENTS;
				
				$bid_process = null;
				
				if ($item_details['owner_id'] == $session->value('user_id'))
				{
					if ($bid_details['bid_status'] != 'accepted')
					{
						$bid_process[] = '[ <a href="' . process_link('reverse_details', array('reverse_id' => $item_details['reverse_id'], 'do' => 'accept_bid', 'bid_id' => $bid_details['bid_id'])) . '">' . MSG_ACCEPT_BID . '</a> ]';
					}
					if ($bid_details['bid_status'] == 'pending')
					{
						$bid_process[] = '[ <a href="' . process_link('reverse_details', array('reverse_id' => $item_details['reverse_id'], 'do' => 'decline_bid', 'bid_id' => $bid_details['bid_id'])) . '">' . MSG_DECLINE_BID . '</a> ]';
					}					
					
					$bid_process = '<br>' . $db->implode_array($bid_process, ' &middot; ', true, '');			
				}
				
				if (!$sealed_bid)
				{
					$bid_description = '<tr>'.
						'	<td colspan="5">' . $db->add_special_chars($bid_details['bid_description']) . '</td>'.
						'<tr>';
				}
				
				if ($session->value('user_id') == $item_details['owner_id'] || $session->value('adminarea') == 'Active' || $session->value('user_id') == $bid_details['bidder_id'])
				{
					$pmb_link = ' &middot; [ <a href="' . process_link('message_board', array('message_handle' => '15', 'bid_id' => $bid_details['bid_id'])) . '"><b class="greenfont">' . MSG_PMB . '</b></a> ]';
				}
				
				$bids_placed_table .= '<tr class="c1"> '.
					'	<td class="contentfont"><b>' . $bid_details['username'] . '</b> &middot; [ <a href="' . process_link('reverse_profile', array('user_id' => $bid_details['bidder_id'], 'reverse_id' => $bid_details['reverse_id'])) . '">' . MSG_VIEW_PROFILE . '</a> ] '.
					'		' . $pmb_link . '</td>'.
				   '	<td align="center">' . $bidder_location . '</td>'.
				   '	<td align="center">' . $bid_amount . '</td>'.
				   '	<td align="center">' . $bidder_reputation . '</td>'.
				   '	<td align="center" class="contentfont">' . $item->reverse_bid_status($bid_details['bid_status']) . $bid_process . '</td>'.
					'</tr>'.
					$bid_description .
					'<tr class="c2">'.
					'	<td colspan="5" class="smallfont">' . MSG_DELIVERY_WITHIN . ' ' . field_display($bid_details['delivery_days'], GMSG_NA, $bid_details['delivery_days'] . ' ' . GMSG_DAYS) . '; ' . MSG_BID_DATE . ': ' . show_date($bid_details['bid_date']) . '</td>'.
					'</tr>';
					
			}
		}
		else 
		{
			$bids_placed_table = '<tr class="c1"><td colspan="5" align="center">' . MSG_NO_BIDS_PLACED . '</td></tr>';
		}
	}
	$template->set('bids_placed_table', $bids_placed_table);
	
	$template->change_path('themes/' . $setts['default_theme'] . '/templates/');
	$template_output .= $template->process('reverse_details.tpl.php');
	$template->change_path('templates/');
}
else
{
	$template->set('message_header', header5(MSG_AUCTION_DETAILS_ERROR_TITLE));
	$template->set('message_content', '<p align="center">' . MSG_AUCTION_DETAILS_ERROR_CONTENT . '</p>');

	$template_output .= $template->process('single_message.tpl.php');
}

include_once ('global_footer.php');

echo $template_output;
?>