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
include_once ('../includes/class_fees.php');

include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_user.php');
include_once ('../includes/class_shop.php');
include_once ('../includes/functions_login.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$form_submitted = false;

	$user = new user();
	$user->setts = &$setts;
	
	$shop = new shop();
	$shop->setts = &$setts;

	if ($_REQUEST['do'] == 'default_account')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		$shop_active = ($_REQUEST['option'] == 'assign') ? 1 : 0;
		
		$db->query("UPDATE " . DB_PREFIX . "users SET
			shop_active='" . $shop_active . "', shop_account_id='0', shop_next_payment='0' WHERE
			user_id=" . intval($_REQUEST['user_id']));
	} 
	else if ($_REQUEST['do'] == 'activate_store') 
	{
		$shop_details = $db->get_sql_row("SELECT f.*, u.shop_next_payment 
			FROM " . DB_PREFIX . "fees_tiers f, " . DB_PREFIX . "users u 
			WHERE u.user_id='" . intval($_REQUEST['user_id']) . "' AND u.shop_account_id=f.tier_id");
			
		$shop_last_payment = CURRENT_TIME;
		$shop_next_payment = ($shop_details['store_recurring'] > 0) ? ($shop_last_payment + ($shop_details['store_recurring'] * 24 * 60 * 60)) : 0;
		$store_inactivated = (intval($_REQUEST['value'])) ? 0 : 1;
		
		$db->query("UPDATE " . DB_PREFIX . "users 
			SET shop_active='" . intval($_REQUEST['value']) . "', store_inactivated='" . $store_inactivated . "'  
			" . ((intval($_REQUEST['value'])) ? ", shop_last_payment='" . $shop_last_payment . "', shop_next_payment='" . $shop_next_payment . "'" : ", shop_next_payment='" . CURRENT_TIME . "'") . "			 
			WHERE user_id=" . intval($_REQUEST['user_id']));		
	}
	else if (isset($_REQUEST['shop_change_subscription']))
	{
		$db->query("UPDATE " . DB_PREFIX . "users SET 
			shop_account_id='" . intval($_REQUEST['shop_account_id']) . "' WHERE user_id='" . intval($_REQUEST['user_id']) . "'");
	}

	$limit = 20;

	$order_field = ($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'u.user_id';
	$order_type = ($_REQUEST['order_type']) ? $_REQUEST['order_type'] : 'DESC';

	$additional_vars = '&keywords_name=' . $_REQUEST['keywords_name'];
	$order_link = '&order_field=' . $order_field . '&order_type=' . $order_type;
	$limit_link = '&start=' . $start . '&limit=' . $limit;
	$show_link = '&show=' . $_REQUEST['show'];

	(string) $search_filter = null;

	if ($_REQUEST['keywords_name'])
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " u.username LIKE '%".$_REQUEST['keywords_name']."%'";
		$template->set('keywords_name', $_REQUEST['keywords_name']);
	}
	if ($_REQUEST['show'] == 'active')
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " u.shop_active=1";
	}
	else if ($_REQUEST['show'] == 'suspended')
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " u.shop_active=0 AND u.shop_account_id>0";
	}
	else if ($_REQUEST['show'] == 'default_account')
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " u.shop_active=1 AND u.shop_account_id=0";
	}
	else 
	{
		$search_filter .= (($search_filter) ? ' AND' : ' WHERE') . " (u.shop_active=1 OR u.shop_account_id>0)";		
	}

	$nb_users = $db->count_rows('users u', $search_filter);

	$template->set('query_results_message', display_pagination_results($start, $limit, $nb_users));

	$sql_select_users = $db->query("SELECT u.* FROM " . DB_PREFIX ."users u	" . $search_filter . "
		ORDER BY " . $order_field . " " . $order_type . " LIMIT " . $start . ", " . $limit);

	while ($user_details = $db->fetch_array($sql_select_users))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';
		$shop->user_id = $user_details['user_id'];

		$shop_status = $shop->shop_status($user_details, true);

		(string) $site_user_options = null;

		if ($user_details['shop_active'] && !$user_details['shop_account_id'])
		{
			$site_user_options .= '[ <a href="stores_management.php?do=default_account&option=remove&user_id=' . $user_details['user_id'] . $additional_vars . $order_link . $limit_link . $show_link . '">' . AMSG_REMOVE_DEFAULT_ACCOUNT . '</a> ]<br>';
		}
		else 
		{
			$site_user_options .= '[ <a href="stores_management.php?do=default_account&option=assign&user_id=' . $user_details['user_id'] . $additional_vars . $order_link . $limit_link . $show_link . '">' . AMSG_ASSIGN_DEFAULT_ACCOUNT . '</a> ]<br>';
			
		}
		
		if ($user_details['shop_account_id'])
		{
			if ($user_details['shop_active'])
			{
				$site_user_options .= '[ <a href="stores_management.php?do=activate_store&user_id=' . $user_details['user_id'] . $additional_vars . $order_link . $limit_link . $show_link . '&value=0">' . AMSG_SUSPEND_STORE . '</a> ]';
			}
			else
			{
				$site_user_options .= '[ <a href="stores_management.php?do=activate_store&user_id=' . $user_details['user_id'] . $additional_vars . $order_link . $limit_link . $show_link . '&value=1">' . AMSG_RENEW_SUBSCRIPTION . '</a> ]';
			}
		}

		$account_options = $shop->store_subscriptions_drop_down('shop_account_id', $user_details['shop_account_id'], true) . 
			' <input type="hidden" name="user_id" value="' . $user_details['user_id'] . '">'.
			' <input type="submit" name="shop_change_subscription" value="' . GMSG_PROCEED . '">';
			
		$stores_details_content .= '<form action="" method="get">'.
			'<tr class="' . $background . '"> '.
      	'	<td valign="top"><a href="list_site_users.php?do=user_details&user_id=' . $user_details['user_id'] . '">' . $user_details['username'] . '</a></td> '.
			'	<td valign="top"><b>' . AMSG_ACCOUNT_TYPE . '</b>: ' . $account_options . '<br>' .
      	'		<b>' . MSG_LAST_SUBSCR_PAYMENT . '</b>: ' . show_date($user_details['shop_last_payment']) . '<br>' .
      	'		<b>' . MSG_NEXT_SUBSCR_PAYMENT  . '</b>: ' . show_date($user_details['shop_next_payment']) . '<br>' .
      	'		<b>' . MSG_TOTAL_ITEMS . '</b>: ' . $shop_status['total_items'] . ' ' .
      	'		' . (($user_details['shop_account_id']) ? '<br><b>' . MSG_REMAINING_ITEMS . '</b>: ' . $shop_status['remaining_items'] : '') . '</td> ' .
			'	<td align="center">' . $site_user_options . '	</td>'.
			'</tr> '.
			'</form>';
	}

	$template->set('stores_details_content', $stores_details_content);

	(string) $filter_users_content = null;

	$filter_users_content .= display_link('stores_management.php', GMSG_ALL, ((!$_REQUEST['show']) ? false : true)) . ' | ';
	$filter_users_content .= display_link('stores_management.php?show=active', GMSG_ACTIVE, (($_REQUEST['show'] == 'active') ? false : true)) . ' | ';
	$filter_users_content .= display_link('stores_management.php?show=suspended', GMSG_SUSPENDED, (($_REQUEST['show'] == 'suspended') ? false : true)) . ' | ';
	$filter_users_content .= display_link('stores_management.php?show=default_account', AMSG_DEFAULT_ACCOUNT, (($_REQUEST['show'] == 'default_account') ? false : true));

	$template->set('filter_users_content', $filter_users_content);

	$pagination = paginate($start, $limit, $nb_users, 'stores_management.php', $additional_vars . $order_link . $show_link);

	$template->set('pagination', $pagination);

	$template->set('header_section', AMSG_STORES_MANAGEMENT);
	$template->set('subpage_title', AMSG_STORES_MANAGEMENT);

	$template->set('page_order_username', page_order('stores_management.php', 'u.username', $start, $limit, $additional_vars . $show_link, AMSG_USERNAME));

	$template_output .= $template->process('stores_management.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>