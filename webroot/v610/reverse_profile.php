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
include_once ('includes/class_reputation.php');

require ('global_header.php');

$user_id = intval($_REQUEST['user_id']);
$reverse_id = intval($_REQUEST['reverse_id']);
$rep_view = (in_array($_REQUEST['view'], array('all', 'positive', 'neutral', 'negative', 'from_providers', 'from_purchasers', 'left'))) ? $_REQUEST['view'] : 'all';

$page_handle = 'provider_profile';

$limit = 20;

$additional_vars = '&view=' . $rep_view . '&user_id=' . $user_id . '&reverse_id=' . $reverse_id;

$user_details = $db->get_sql_row("SELECT * FROM
	" . DB_PREFIX . "users WHERE user_id=" . $user_id);

if ($user_details['user_id'])
{
	$reputation = new reputation();
	$reputation->setts = &$setts;

	$item = new item();
	$item->setts = &$setts;
	$item->layout = &$layout;
	
	$db->categories_table = 'reverse_categories';
	
	$template->set('profile_header', header5(MSG_USER_PROFILE . ' - ' . $user_details['username']));

	$template->set('user_id', $user_id);
	$template->set('reverse_id', $reverse_id);
	$template->set('user_details', $user_details);

	$tax = new tax();
	$seller_country = $tax->display_countries($user_details['country']);
	$template->set('seller_country', $seller_country);

	$custom_fld = new custom_field();

	$custom_fld->save_edit_vars($user_details['user_id'], $page_handle);

	$media_details = $item->get_media_values($user_details['user_id'], false, false, true);
	$user_details['ad_image'] = $media_details['ad_image'];
	
	$custom_fld->new_table = false;
	$custom_fld->field_colspan = 1;
	$custom_sections_table = $custom_fld->display_sections($user_details, $page_handle, true, $user_details['user_id']);
	$template->set('custom_sections_table', $custom_sections_table);

	$portfolio_thumbnails = $item->item_media_thumbnails($user_details, 1, false, false, 'h');
	$full_size_images_link = $item->full_size_images($user_details);
	$template->set('portfolio_thumbnails', $portfolio_thumbnails . '<br>' . $full_size_images_link);
	
	$template->set('one_month', 30 * 86400);
	$template->set('six_months', 180 * 86400);
	$template->set('twelve_months', 365 * 86400);

	$total_comments = $db->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted='1' AND reverse_id>0");
	$template->set('total_comments', $total_comments);

	$reputation_output = $reputation->calc_reputation($user_id, null, true);
	$template->set('reputation_rating', $reputation_output['percentage']);

	$template->set('rep_view', $rep_view);
	switch ($rep_view)
	{
		case 'positive':
			$search_pattern = " r.user_id='" . $user_id . "' AND r.reputation_rate>3 ";
			break;
		case 'neutral':
			$search_pattern = " r.user_id='" . $user_id . "' AND r.reputation_rate=3 ";
			break;
		case 'negative':
			$search_pattern = " r.user_id='" . $user_id . "' AND r.reputation_rate<3 ";
			break;
		case 'from_buyers':
			$search_pattern = " r.user_id='" . $user_id . "' AND r.reputation_type='sale' ";
			break;
		case 'from_sellers':
			$search_pattern = " r.user_id='" . $user_id . "' AND r.reputation_type='purchase' ";
			break;
		case 'left':
			$search_pattern = " r.from_id='" . $user_id . "' ";
			break;
		default:
			$search_pattern = " r.user_id='" . $user_id . "' ";
	}
	$search_pattern .= " AND reverse_id>0";

	$show_reputation_details = ($setts['enable_private_reputation'] && $user_details['enable_private_reputation']) ? 0 : 1;
	$template->set('show_reputation_details', $show_reputation_details);
	
	if ($show_reputation_details)
	{
		$sql_select_reputation = $db->query("SELECT r.*, f.username AS from_username, t.username AS to_username FROM " . DB_PREFIX . "reputation r
			LEFT JOIN " . DB_PREFIX . "users f ON r.from_id=f.user_id
			LEFT JOIN " . DB_PREFIX . "users t ON r.user_id=t.user_id WHERE
			" . $search_pattern . " AND r.submitted=1 ORDER BY r.reg_date DESC LIMIT ".$start.",".$limit);
	
		$total_rep = $db->count_rows('reputation r', "WHERE " . $search_pattern . " AND r.submitted=1");
	
		(string) $rep_details_content = null;
		while ($rep_details = $db->fetch_array($sql_select_reputation))
		{
	  		$rep_username = ($rep_view == 'left') ? $rep_details['to_username'] : $rep_details['from_username'];
	  		$rep_user_id = ($rep_view == 'left') ? $rep_details['user_id'] : $rep_details['from_id'];
	
			$background = ($counter++%2) ? 'c1' : 'c2';
	
			$rep_details_content .= '<tr class="' . $background . '"> '.
	      	'	<td colspan="4">'. $reputation->rep_rate($rep_details['reputation_rate']) . ' | '.
				'		<strong>' . GMSG_DATE . '</strong>: ' . show_date($rep_details['reg_date']) . ' | '.
				'		<strong>' . MSG_TYPE . '</strong>: ' .$reputation->reputation_type($rep_details) . ' | '.
				'		<strong>' . (($rep_view == 'left') ? GMSG_TO : GMSG_FROM) . '</strong>: '.
				'			' . $rep_username . user_pics($rep_user_id, true, true) . '</a> | '.
				'		<strong>' . MSG_AUCTION_ID . '</strong>: '.
				'			<a href="' . process_link('reverse_details', array('reverse_id' => $rep_details['reverse_id'])) . '">' . $rep_details['reverse_id'] . '</a> | '.
				'		[ <strong><a href="javascript://" onclick="popUp(\'reputation_details.php?reputation_id=' . $rep_details['reputation_id'] . '\');">' . MSG_DETAILS . '</a></strong> ]<br>'.
				'		' . $rep_details['reputation_content'];
				'	</td> '.
	   		'</tr>';
	   }
	
	   $template->set('rep_details_content', $rep_details_content);
	
		$pagination = paginate($start, $limit, $total_rep, 'reverse_profile.php', $additional_vars . $order_link);
		$template->set('pagination', $pagination);
	}

	$template_output .= $template->process('reverse_profile.tpl.php');
}
else
{
	$template->set('message_header', header5(MSG_USER_PROFILE));
	$template->set('message_content', '<p align="center">' . MSG_USER_DOESNT_EXIST . '</p>');

	$template_output .= $template->process('single_message.tpl.php');
}

include_once ('global_footer.php');

echo $template_output;

?>