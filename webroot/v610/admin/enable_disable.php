<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_item.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	$item = new item();
	$item->setts = &$setts;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (isset($_POST['form_save_settings']))
	{
		$post_details = $db->rem_special_chars_array($_POST);

		$allowed_tables = array('gen_setts', 'layout_setts');

		if (in_array($post_details['table_name'], $allowed_tables))
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$sql_update_query = $db->query("UPDATE " . DB_PREFIX . $post_details['table_name'] . " SET
				" . $post_details['field_name'] . "='" . $post_details['field_value'] . "'");

			switch ($_REQUEST['page'])
			{
				case 'hp_news_box':
					$sql_update_secondary = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
						d_news_nb='" . $post_details['d_news_nb'] . "'");
					break;
				case 'buy_out_method':
					if ($setts['enable_store_only_mode'])
					{
						$db->query("UPDATE " . DB_PREFIX . "layout_setts SET enable_buyout='1'");
					}
					
					$sql_update_secondary = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						always_show_buyout='" . $post_details['always_show_buyout'] . "', 
						makeoffer_private='" . $post_details['makeoffer_private'] . "'");
					break;
				case 'registration_terms':
					$sql_update_secondary = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
						reg_terms_content='" . str_ireplace("\n", '<br>', $post_details['reg_terms_content']) . "'");
					break;
				case 'sellitem_terms':
					$sql_update_secondary = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
						auct_terms_content='" . str_ireplace("\n", '<br>', $post_details['auct_terms_content']) . "'");
					break;
				case 'auction_sniping':
					$sql_update_secondary = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						sniping_duration='" . $post_details['sniping_duration'] . "'");
					break;
				case 'auction_approval':
					$sql_update_categories = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						approval_categories='" . $db->implode_array($_POST['categories_id']) . "'");
					break;
				case 'preferred_sellers':
					$sql_update_pref_sell = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						pref_sellers_reduction='" . $post_details['pref_sellers_reduction'] . "', 
						preferred_days='" . $post_details['preferred_days'] . "'");
					
					if ($post_details['preferred_days'] > 0)
					{
						$expiration_date = CURRENT_TIME + $post_details['preferred_days'] * 24 * 60 * 60;
						
						$db->query("UPDATE " . DB_PREFIX . "users SET preferred_seller_exp_date='" . intval($expiration_date) . "' WHERE 
							preferred_seller=1 AND preferred_seller_exp_date=0");
					}
					break;
				case 'change_duration':
					$sql_update_duration = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						duration_change_days='" . $post_details['duration_change_days'] . "'");
					break;
				case 'seller_verification':
					$sql_update_verif = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						seller_verification_mandatory='" . $post_details['seller_verification_mandatory'] . "', 
						seller_verification_refund='" . $post_details['seller_verification_refund'] . "'");
					$sql_update_fee = $db->query("UPDATE " . DB_PREFIX . "fees SET
						verification_fee='" . $post_details['verification_fee'] . "', 
						verification_recurring='" . $post_details['verification_recurring'] . "' WHERE category_id=0");
					break;
				case 'store_only_mode':
					if ($post_details['field_value'])
					{
						$db->query("UPDATE " . DB_PREFIX . "layout_setts SET enable_buyout='1'");
						$db->query("UPDATE " . DB_PREFIX . "gen_setts SET buyout_process='1'");
					}
					break;
				case 'second_chance':
					$sql_update_second_chance = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						second_chance_days='" . $post_details['second_chance_days'] . "'");
					break;
				case 'enable_refunds':
					$sql_update_second_chance = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						refund_min_days='" . $post_details['refund_min_days'] . "',
						refund_max_days='" . $post_details['refund_max_days'] . "'");
					break;
				case 'reverse_auctions':
					$sql_update_secondary = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						max_portfolio_files='" . $post_details['max_portfolio_files'] . "', 
						max_additional_files='" . $post_details['max_additional_files'] . "'");
					break;
				case 'bulk_lister':
					$sql_update_bulk = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						csv_delimiter='" . $post_details['csv_delimiter'] . "'");
					break;
				case 'bidder_verification':
					$sql_update_verif = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						bidder_verification_mandatory='" . $post_details['bidder_verification_mandatory'] . "', 
						bidder_verification_refund='" . $post_details['bidder_verification_refund'] . "'");

					$sql_update_fee = $db->query("UPDATE " . DB_PREFIX . "fees SET
						bidder_verification_fee='" . $post_details['bidder_verification_fee'] . "', 
						bidder_verification_recurring='" . $post_details['bidder_verification_recurring'] . "' WHERE category_id=0");
					break;
				case 'enable_stores':
					$sql_update_categories = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
						hide_empty_stores='" . $post_details['hide_empty_stores'] . "', 
						store_listing_type='" . $post_details['store_listing_type'] . "', 
						enable_store_upgrade='" . $post_details['enable_store_upgrade'] . "', 
						store_upgrade_days='" . $post_details['store_upgrade_days'] . "'");
					break;
			}
		}
	}

	(string) $header_section = null;
	(string) $subpage_title = null;
	(string) $table_name = null;
	(string) $field_name = null;

	$setts_tmp = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "gen_setts");
	$layout_tmp  = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "layout_setts");

	$template->set('setts_tmp', $setts_tmp);
	$template->set('layout_tmp', $layout_tmp);
	$template->set('page', $_REQUEST['page']);

	$gen_setts_pages = array('shipping_costs', 'swapping', 'hp_counter', 'addl_category_listing',
		'user_languages', 'auction_sniping', 'private_site', 'preferred_sellers', 'bcc_emails',
		'seller_questions', 'registration_approval', 'wanted_ads', 'bid_retraction',
		'seller_other_items', 'bulk_lister', 'category_counters', 'phone_nb_sale', 'mod_rewrite', 'auction_approval',
		'enable_stores', 'change_duration', 'seller_verification', 'profile_page', 'store_only_mode', 'skin_change', 'second_chance', 
		'remove_marked_deleted', 'enable_addthis', 'enable_private_reputation', 'enable_refunds', 'end_auction_early', 
		'reverse_auctions', 'fb_auctions', 'swdefeat', 'custom_end_time', 'buyer_create_invoice', 
		'display_free_fees', 'proxy_bidding', 'free_category_change', 'limit_nb_bids', 'bidder_verification');

	$layout_setts_pages = array('hp_login_box', 'hp_news_box', 'buy_out_method', 'registration_terms',
		'sellitem_terms', 'site_fees_page');


	if (in_array($_REQUEST['page'], $gen_setts_pages))
	{
		$table_name = 'gen_setts';
	}
	else if (in_array($_REQUEST['page'], $layout_setts_pages))
	{
		$table_name = 'layout_setts';
	}
	$template->set('table_name', $table_name);

	if ($_REQUEST['page'] == 'shipping_costs')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_SHIPPING_COSTS;

		$template->set('field_name', 'enable_shipping_costs');
	}
	else if ($_REQUEST['page'] == 'hp_login_box')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_HP_LOGIN_BOX;

		$template->set('field_name', 'd_login_box');
	}
	else if ($_REQUEST['page'] == 'hp_news_box')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_HP_NEWS_BOX;

		$template->set('field_name', 'd_news_box');
	}
	else if ($_REQUEST['page'] == 'buy_out_method')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_BUY_OUT_METHOD;

		$template->set('field_name', 'enable_buyout');
	}
	else if ($_REQUEST['page'] == 'registration_terms')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_REGISTRATION_TERMS;

		$template->set('field_name', 'enable_reg_terms');
	}
	else if ($_REQUEST['page'] == 'sellitem_terms')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_SELLITEM_TERMS;

		$template->set('field_name', 'enable_auct_terms');
	}
	else if ($_REQUEST['page'] == 'swapping')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_SWAPPING;

		$template->set('field_name', 'enable_swaps');
	}
	else if ($_REQUEST['page'] == 'hp_counter')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_HP_COUNTER;

		$template->set('field_name', 'enable_header_counter');
	}
	else if ($_REQUEST['page'] == 'addl_category_listing')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ADDL_CATEGORY_LISTING;

		$template->set('field_name', 'enable_addl_category');
	}
	else if ($_REQUEST['page'] == 'user_languages')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_USER_LANGUAGES;

		$template->set('field_name', 'user_lang');
	}
	else if ($_REQUEST['page'] == 'auction_sniping')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_AUCTION_SNIPING;

		$template->set('field_name', 'enable_sniping_feature');
	}
	else if ($_REQUEST['page'] == 'private_site')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_PRIVATE_SITE;

		$template->set('field_name', 'enable_private_site');
	}
	else if ($_REQUEST['page'] == 'preferred_sellers')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title =AMSG_PREFERRED_SELLERS;

		$template->set('field_name', 'enable_pref_sellers');
	}
	else if ($_REQUEST['page'] == 'bcc_emails')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_BCC_EMAILS;

		$template->set('field_name', 'enable_bcc');
	}
	else if ($_REQUEST['page'] == 'seller_questions')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_SELLER_QUESTIONS;

		$template->set('field_name', 'enable_asq');
	}
	else if ($_REQUEST['page'] == 'registration_approval')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_REGISTRATION_APPROVAL;

		$template->set('field_name', 'enable_reg_approval');
	}
	else if ($_REQUEST['page'] == 'wanted_ads')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_WANTED_ADS;

		$template->set('field_name', 'enable_wanted_ads');
	}
	else if ($_REQUEST['page'] == 'bid_retraction')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_BID_RETRACTION;

		$template->set('field_name', 'enable_bid_retraction');
	}
	else if ($_REQUEST['page'] == 'seller_other_items')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_SELLER_OTHER_ITEMS;

		$template->set('field_name', 'enable_other_items_adp');
	}
	else if ($_REQUEST['page'] == 'bulk_lister')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_BULK_LISTER;

		$template->set('field_name', 'enable_bulk_lister');
	}
	else if ($_REQUEST['page'] == 'category_counters')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_CATEGORY_COUNTERS;

		$template->set('field_name', 'enable_cat_counters');
	}
	else if ($_REQUEST['page'] == 'phone_nb_sale')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_PHONE_NB_SALE;

		$template->set('field_name', 'enable_display_phone');
	}
	else if ($_REQUEST['page'] == 'mod_rewrite')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_MOD_REWRITE;

		$template->set('field_name', 'is_mod_rewrite');
	}
	else if ($_REQUEST['page'] == 'enable_stores')
	{
		$header_section = AMSG_STORES_MANAGEMENT;
		$subpage_title = AMSG_ENABLE_STORES;

		$template->set('field_name', 'enable_stores');
	}
	else if ($_REQUEST['page'] == 'auction_approval')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_AUCT_APPROVAL;

		$template->set('field_name', 'enable_auctions_approval');
		$template->set('setts', $setts);

		(string) $all_categories_table = null;
		(string) $selected_categories_table = null;

		$selected_categories = (!empty($setts_tmp['approval_categories'])) ? $setts_tmp['approval_categories'] : 0;

		$selected_categories = last_char($selected_categories);
						
		$sql_select_all_categories = $db->query("SELECT category_id, name FROM " . DB_PREFIX . "categories WHERE
			parent_id=0 AND category_id NOT IN (" . $selected_categories . ") ORDER BY order_id ASC, name ASC");

		$all_categories_table = '<select name="all_categories" size="15" multiple="multiple" id="all_categories" style="width: 100%;">';

		while ($all_categories_details = $db->fetch_array($sql_select_all_categories))
		{
			$all_categories_table .= '<option value="' . $all_categories_details['category_id'] . '">' . $all_categories_details['name'] . '</option>';
		}

		$all_categories_table .= '</select>';

		$sql_select_selected_categories = $db->query("SELECT category_id, name FROM " . DB_PREFIX . "categories WHERE
			parent_id=0 AND category_id IN (" . $selected_categories . ") ORDER BY order_id ASC, name ASC");

		$selected_categories_table ='<select name="categories_id[]" size="15" multiple="multiple" id="categories_id" style="width: 100%;"> ';

		while ($selected_categories_details = $db->fetch_array($sql_select_selected_categories))
		{
			$selected_categories_table .= '<option value="' . $selected_categories_details['category_id'] . '" selected>' . $selected_categories_details['name'] . '</option>';
		}

		$selected_categories_table .= '</select>';

		$template->set('all_categories_table', $all_categories_table);
		$template->set('selected_categories_table', $selected_categories_table);

	}
	else if ($_REQUEST['page'] == 'change_duration')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_CHG_DURATION_ON_BID_PLACED;

		$template->set('field_name', 'enable_duration_change');
	}
	else if ($_REQUEST['page'] == 'seller_verification')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_SELLER_VERIFICATION;
		
		$fees_tmp = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "fees WHERE category_id=0");
		$template->set('fees_tmp', $fees_tmp);

		$template->set('field_name', 'enable_seller_verification');
	}
	else if ($_REQUEST['page'] == 'profile_page')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_PROFILE_PAGE;

		$template->set('field_name', 'enable_profile_page');
	}
	else if ($_REQUEST['page'] == 'store_only_mode')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_STORE_ONLY_MODE;

		$template->set('field_name', 'enable_store_only_mode');
	}
	else if ($_REQUEST['page'] == 'skin_change')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_SKIN_CHANGE;

		$template->set('field_name', 'enable_skin_change');
	}
	else if ($_REQUEST['page'] == 'second_chance')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_SECOND_CHANCE;

		$template->set('field_name', 'enable_second_chance');
	}
	else if ($_REQUEST['page'] == 'remove_marked_deleted')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_REMOVE_MARKED_DELETED_AUCTIONS;

		$template->set('field_name', 'remove_marked_deleted');
		
		$nb_marked_deleted_items = $db->count_rows('auctions', "WHERE deleted=1");
		$template->set('nb_marked_deleted_items', $nb_marked_deleted_items);		
	}
	else if ($_REQUEST['page'] == 'enable_addthis')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_SITE_SHARING;

		$template->set('field_name', 'enable_addthis');
	}
	else if ($_REQUEST['page'] == 'enable_private_reputation')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_PRIVATE_REPUTATION_COMMENTS;

		$template->set('field_name', 'enable_private_reputation');
	}
	else if ($_REQUEST['page'] == 'enable_refunds')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_REFUNDS;

		$template->set('field_name', 'enable_refunds');
	}
	else if ($_REQUEST['page'] == 'end_auction_early')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_END_AUCT_EARLY;

		$template->set('field_name', 'end_auction_early');
	}
	else if ($_REQUEST['page'] == 'reverse_auctions')
	{
		$header_section = AMSG_REVERSE_AUCTIONS_MANAGEMENT;
		$subpage_title = AMSG_ENABLE_REVERSE_AUCTIONS;

		$template->set('field_name', 'enable_reverse_auctions');
	}
	else if ($_REQUEST['page'] == 'fb_auctions')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_FIRST_BIDDER_AUCTIONS;

		$template->set('field_name', 'enable_fb_auctions');
	}
	else if ($_REQUEST['page'] == 'swdefeat')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_SIDEWIKI_BLOCKER;

		$template->set('field_name', 'enable_swdefeat');
	}
	else if ($_REQUEST['page'] == 'custom_end_time')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_CUSTOM_END_TIME;

		$template->set('field_name', 'enable_custom_end_time');
	}
	else if ($_REQUEST['page'] == 'buyer_create_invoice')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_BUYER_CREATE_INVOICE;

		$template->set('field_name', 'enable_buyer_create_invoice');
	}
	else if ($_REQUEST['page'] == 'display_free_fees')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_DISPLAY_FREE_FEES;

		$template->set('field_name', 'display_free_fees');
	}
	else if ($_REQUEST['page'] == 'proxy_bidding')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_PROXY_BIDDING;

		$template->set('field_name', 'enable_proxy_bidding');
	}
	else if ($_REQUEST['page'] == 'free_category_change')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_FREE_CATEGORY_CHANGE;

		$template->set('field_name', 'free_category_change');
	}
	else if ($_REQUEST['page'] == 'site_fees_page')
	{
		$header_section = AMSG_SITE_CONTENT;
		$subpage_title = AMSG_ENABLE_SITE_FEES_PAGE;

		$template->set('field_name', 'enable_site_fees_page');
	}
	else if ($_REQUEST['page'] == 'limit_nb_bids')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_LIMIT_NB_BIDS;

		$template->set('field_name', 'limit_nb_bids');
	}
	else if ($_REQUEST['page'] == 'bidder_verification')
	{
		$header_section = AMSG_ENABLE_DISABLE;
		$subpage_title = AMSG_ENABLE_BIDDER_VERIFICATION;
		
		$fees_tmp = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "fees WHERE category_id=0");
		$template->set('fees_tmp', $fees_tmp);

		$template->set('field_name', 'enable_bidder_verification');
	}
	

	$template->set('header_section', $header_section);
	$template->set('subpage_title', $subpage_title);

	$template_output .= $template->process('enable_disable.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>