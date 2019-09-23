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
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_user.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_item.php');
include_once ('includes/functions_item.php');
include_once ('includes/class_messaging.php');
include_once ('includes/class_reputation.php');

if ($setts['enable_wanted_ads'])
{
	require ('global_header.php');
	
	(array) $user_details = null;
	
	$start_time_id = 1;
	$end_time_id = 2;
	
	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	
	$reputation = new reputation();
	$reputation->setts = &$setts;
	
	$page_handle = 'wanted_ad';
	
	$addl_query = ($session->value('adminarea')!="Active") ? " AND active=1" : '';
	
	$wanted_ad_id = intval($_REQUEST['wanted_ad_id']);
	
	$item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "wanted_ads WHERE
		wanted_ad_id='" . $wanted_ad_id . "'" . $addl_query);
	
	if ($item->count_contents($item_details))
	{
		$blocked_user = blocked_user($session->value('user_id'), $item_details['owner_id']);
		$template->set('blocked_user', $blocked_user);
	
		if ($blocked_user)
		{
			$template->set('block_reason_msg', block_reason($session->value('user_id'), $item_details['owner_id']));
		}
		
		if (isset($_GET['form_offer_proceed']))
		{
			$db->query("INSERT INTO " . DB_PREFIX . "wanted_offers (wanted_ad_id, auction_id) VALUES 
				('" . $wanted_ad_id . "', '" . intval($_REQUEST['auction_id']) . "')");
			$db->query("UPDATE " . DB_PREFIX . "wanted_ads SET nb_bids=nb_bids+1 WHERE wanted_ad_id=" . $wanted_ad_id);
			
			header_redirect('wanted_details.php?wanted_ad_id=' . $item_details['wanted_ad_id'] . '&operation=offer_proceed');			
		}
		
		if ($_REQUEST['operation'] == 'offer_proceed')
		{
			$msg_changes_saved = '<p align="center" class="contentfont">' . MSG_OFFER_POSTED_SUCCESSFULLY . '</p>';
		}
	
		$template->set('wanted_ad_id', intval($_REQUEST['wanted_ad_id']));## PHP Pro Bid v6.00 add click
		$sql_add_click = $db->query("UPDATE " . DB_PREFIX . "wanted_ads SET nb_clicks=nb_clicks+1 WHERE wanted_ad_id=" . $item_details['wanted_ad_id']);
	
		$user_details = $db->get_sql_row("SELECT user_id, username, shop_account_id, shop_categories,
			shop_active, preferred_seller, reg_date, country, state, zip_code, balance,
			default_name, default_description, default_duration, default_hidden_bidding,
			default_enable_swap, default_shipping_method, default_shipping_int, default_postage_amount,
			default_insurance_amount, default_type_service, default_shipping_details, default_payment_methods,
			default_public_questions FROM
			" . DB_PREFIX . "users WHERE user_id=" . $item_details['owner_id']);
	
		$custom_fld = new custom_field();
	
		$msg = new messaging();
		$msg->setts = &$setts;
	
		/**
		 * if we have a user logged in, we mark as read any questions/answers he has received
		 */
		if ($session->value('user_id'))
		{
			$msg->mark_read($session->value('user_id'), 0, $wanted_ad_id, 4); //<-- needs mysql optimization!
		}
	
		if ($_REQUEST['option'] == 'post_question')
		{
			$msg->new_topic($wanted_ad_id, $session->value('user_id'), $item_details['owner_id'], 1, '', $_REQUEST['message_content'], $_REQUEST['message_handle']);
	
			header_redirect('wanted_details.php?wanted_ad_id=' . $item_details['wanted_ad_id'] . '&operation=post_question');
		}
		else if ($_REQUEST['option'] == 'post_answer')
		{
			$msg->reply($_REQUEST['question_id'], $session->value('user_id'), '', $_REQUEST['message_content']);
	
			header_redirect('wanted_details.php?wanted_ad_id=' . $item_details['wanted_ad_id'] . '&operation=post_answer');
		}
	
		if ($_REQUEST['operation'] == 'post_question')
		{
			$msg_changes_saved = '<p align="center" class="contentfont">' . MSG_QUESTION_POSTED_SUCCESSFULLY . '</p>';
		}
		else if ($_REQUEST['operation'] == 'post_answer')
		{
			$msg_changes_saved = '<p align="center" class="contentfont">' . MSG_ANSWER_POSTED_SUCCESSFULLY . '</p>';
		}

		if ($_REQUEST['do'] == 'delete_topic' && $session->value('adminarea') == 'Active') /* delete public question - admin area feature only */
		{
			$db->query("DELETE FROM " . DB_PREFIX . "messaging WHERE topic_id='" . intval($_REQUEST['topic_id']) . "'");
			$msg_changes_saved = '<p align="center">' . MSG_TOPIC_DELETED . '</p>';
		}
		
		$template->set('msg_changes_saved', $msg_changes_saved);
	
		$custom_fld->save_edit_vars($item_details['owner_id'], $page_handle);
	
		$media_details = $item->get_media_values(intval($_REQUEST['wanted_ad_id']), true);
		$item_details['ad_image'] = $media_details['ad_image'];
		$item_details['ad_video'] = $media_details['ad_video'];
	
		$template->set('item_details', $item_details);
	
		$template->set('user_details', $user_details);
	
		//$template->set('fees', $fees);
		$template->set('session', $session);
		$template->set('item', $item);
	
		$template->set('main_category_display', category_navigator($item_details['category_id'], true, false, 'wanted_ads.php'));
		$template->set('addl_category_display', category_navigator($item_details['addl_category_id'], true, false, 'wanted_ads.php'));
	
		$tax = new tax();
		$seller_country = $tax->display_countries($user_details['country']);
		$template->set('seller_country', $seller_country);
		
		$template->set('auction_location', $item->item_location($item_details));
		$template->set('auction_country', $tax->display_countries($item_details['country']));
	
		$reputation_table_small = $reputation->rep_table_small($item_details['owner_id']);
		$template->set('reputation_table_small', $reputation_table_small);
	
		$custom_fld->new_table = false;
		$custom_fld->field_colspan = 1;
		$custom_sections_table = $custom_fld->display_sections($item_details, $page_handle, true, $item_details['wanted_ad_id'], $db->main_category($item_details['category_id']));
		$template->set('custom_sections_table', $custom_sections_table);
	
		$ad_image_thumbnails = $item->item_media_thumbnails($item_details, 1);
		$template->set('ad_image_thumbnails', $ad_image_thumbnails);
	
		$ad_video_thumbnails = $item->item_media_thumbnails($item_details, 2);
		$template->set('ad_video_thumbnails', $ad_video_thumbnails);
	
		$video_play_file = (!empty($_REQUEST['video_name'])) ? $_REQUEST['video_name'] : $item_details['ad_video'][0];
		$ad_video_main_box = $item->video_box($video_play_file);
		$template->set('ad_video_main_box', $ad_video_main_box);

		if ($setts['enable_asq'])
		{
			$public_messages = $msg->public_messages($item_details['wanted_ad_id'], 4);
	
			(string) $public_questions_content = null;
			while ($msg_details = $db->fetch_array($public_messages))
			{
				$public_questions_content .= '<tr class="c2"> '.
					'	<td><table width="100%"> '.
	   			'			<tr> '.
	   			'				<td><img src="themes/' . $setts['default_theme'] . '/img/system/q.gif" /></td> '.
	   			'				<td width="100%" align="right"><strong>' . MSG_QUESTION . '</strong></td> '.
	   			'			</tr> '.
	   			'		</table></td> '.
	   			'	<td>' . $msg_details['question_content'] . '</td>'.
	   			'</tr> '.
	   			'<tr class="c1"> '.
	   			'	<td><table width="100%"> '.
	   			'			<tr> '.
	   			'				<td><img src="themes/' . $setts['default_theme'] . '/img/system/a.gif" /></td> '.
	   			'				<td width="100%" align="right"><strong>' . MSG_ANSWER . '</strong></td> '.
	   			'			</tr> '.
	   			'		</table></td> '.
	   			'	<td>' . ((!empty($msg_details['answer_content'])) ? $msg_details['answer_content'] : '-') . '</td> '.
	   			'</tr>';
	
	   		if ($session->value('adminarea') == 'Active')
	   		{
		   		$public_questions_content .= '<tr> '.
		   			'	<td></td> '.
		   			'	<td class="c1 contentfont"> '.
	         		'		[ <a href="wanted_details.php?do=delete_topic&topic_id=' . $msg_details['topic_id'] . '&wanted_ad_id=' . $item_details['wanted_ad_id'] . '" onclick="return confirm(\'' . MSG_DELETE_CONFIRM . '\');">' . MSG_DELETE_TOPIC . '</a> ]</td> '.
		   			'</tr>';
	   		}
	   		else if ($session->value('user_id') == $item_details['owner_id'])
	   		{
		   		$public_questions_content .= '<tr> '.
		   			'	<td></td> '.
		   			'	<form method="get"> '.
		   			'	<td class="c1"> '.
	         		'		<input type="button" value="'.MSG_SUBMIT_EDIT_ANSWER.'" onClick="openPopup(\'popup_edit_public_question.php?wanted_ad_id=' . $item_details['wanted_ad_id'] . '&question_id='.$msg_details['question_id'].'\')"></td> '.
	      			'	</form> '.
		   			'</tr>';
	   		}
	
	   		$public_questions_content .= '<tr class="c4"> '.
	   			'	<td></td> '.
	   			'	<td></td> '.
	   			'</tr>';
			}
	
			$template->set('public_questions_content', $public_questions_content);
		}
		
		$sql_select_auctions = $db->query("SELECT a.auction_id, a.name, a.start_price, a.max_bid, a.currency, a.nb_bids, a.end_time, a.owner_id FROM 
			" . DB_PREFIX . "auctions a, " . DB_PREFIX . "wanted_offers w WHERE 
			a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0 AND a.list_in!='store' AND 
			a.auction_id=w.auction_id AND w.wanted_ad_id=" . $wanted_ad_id);
		
		$is_wanted_offers = $db->num_rows($sql_select_auctions);
		$template->set('is_wanted_offers', $is_wanted_offers);
		
		(string) $active_offers_content = null;
		if ($is_wanted_offers)
		{
			while ($item_details = $db->fetch_array($sql_select_auctions))
			{
				$background = ($counter++%2) ? 'c1' : 'c2';
				
				$auction_link = process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));
				$auction_image = (!empty($item_details['media_url'])) ? $item_details['media_url'] : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif';
				
				$active_offers_content .= '<tr class="contentfont ' . $background . '"> '.
			    	'	<td align="center"><a href="' . $auction_link . '"><img src="thumbnail.php?pic=' . $auction_image . '&w=50&sq=Y&b=Y" border="0" alt="' . $item_details['name'] . '"></a></td> '.
			    	'	<td><a href="' . $auction_link . '">' . $item_details['name'] . '</a> ' . item_pics($item_details) . '</td> '.
			    	'	<td align="center">' . $fees->display_amount($item_details['start_price'], $item_details['currency']) . '</td> '.
			    	'	<td align="center">' . $fees->display_amount($item_details['max_bid'], $item_details['currency']) . '</td> '.
			    	'	<td align="center">' . $item_details['nb_bids'] . '</td> '.
			    	'	<td align="center">' . time_left($item_details['end_time']) . '</td> '.
			  		'</tr> ';
			}
		}
		$template->set('active_offers_content', $active_offers_content);
		
		(string) $offer_drop_down = null;
		if ($session->value('user_id') && $session->value('user_id') != $item_details['owner_id'])
		{
			$offer_drop_down = $item->wanted_offers_drop_down('auction_id', $session->value('user_id'));
			$template->set('offer_drop_down', $offer_drop_down);
		}
	
		$template->change_path('themes/' . $setts['default_theme'] . '/templates/');
		$template_output .= $template->process('wanted_details.tpl.php');
		$template->change_path('templates/');
	}
	else
	{
		$template->set('message_header', header5(MSG_WANTED_DETAILS_ERROR_TITLE));
		$template->set('message_content', '<p align="center">' . MSG_WANTED_DETAILS_ERROR_CONTENT . '</p>');
	
		$template_output .= $template->process('single_message.tpl.php');
	}
	
	include_once ('global_footer.php');
	
	echo $template_output;
}
else 
{
	header_redirect('index.php');
}
?>