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

		switch ($_REQUEST['page'])
		{
			case 'signup_settings':
				$sql_update_signup_setts = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					signup_settings = '" . $_POST['signup_settings'] . "'");
				break;
			case 'closed_auctions_deletion':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					closed_auction_deletion_days='" . $post_details['closed_auction_deletion_days'] . "'");
				break;
			case 'hpfeat_items':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					hpfeat_nb='" . $post_details['hpfeat_nb'] . "',
					hpfeat_width='" . $post_details['hpfeat_width'] . "',
					hpfeat_max='" . $post_details['hpfeat_max'] . "'");
				break;
			case 'catfeat_items':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					catfeat_nb='" . $post_details['catfeat_nb'] . "',
					catfeat_width='" . $post_details['catfeat_width'] . "',
					catfeat_max='" . $post_details['catfeat_max'] . "'");
				break;
			case 'recently_listed_auctions':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					nb_recent_auct='" . $post_details['nb_recent_auct'] . "'");
				break;
			case 'popular_auctions':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					nb_popular_auct='" . $post_details['nb_popular_auct'] . "'");
				break;
			case 'ending_soon_auctions':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					nb_ending_auct='" . $post_details['nb_ending_auct'] . "'");
				break;
			case 'auction_images':
				$post_details['watermark_size'] = ($post_details['watermark_size'] > 50) ? $post_details['watermark_size'] : 50;
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					max_images='" . $post_details['max_images'] . "',
					images_max_size='" . $post_details['images_max_size'] . "',
					watermark_text='" . $post_details['watermark_text'] . "',
					watermark_size='" . $post_details['watermark_size'] . "',
					watermark_pos='" . $post_details['watermark_pos'] . "', 
					thumb_display_type='" . $post_details['thumb_display_type'] . "'");
				break;
			case 'currency_setts':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					currency='" . $post_details['currency'] . "',
					amount_format='" . $post_details['amount_format'] . "',
					amount_digits='" . $post_details['amount_digits'] . "',
					currency_position='" . $post_details['currency_position'] . "'");
				break;
			case 'time_date_setts':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					time_offset='" . $post_details['time_zone'] . "'");

				$sql_reset_dateformat = $db->query("UPDATE " . DB_PREFIX . "dateformat SET active=''");

				$sql_update_dateformat = $db->query("UPDATE " . DB_PREFIX . "dateformat SET
					active='checked' WHERE id='" . $post_details['date_format'] . "'");
				break;
			case 'ssl_support':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					is_ssl='" . $post_details['is_ssl'] . "',
					site_path_ssl='" . $post_details['site_path_ssl'] . "', 
					enable_enhanced_ssl='" . $post_details['enable_enhanced_ssl'] . "'");
				break;
			case 'meta_tags':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					metatags='" . $post_details['metatags'] . "'");
				break;
			case 'cron_jobs':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					cron_job_type='" . $post_details['cron_job_type'] . "'");
				break;
			case 'min_reg_age':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					min_reg_age='" . $post_details['min_reg_age'] . "',
					birthdate_type='" . $post_details['birthdate_type'] . "'");
				break;
			case 'recent_wanted_ads':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					nb_want_ads='" . $post_details['nb_want_ads'] . "'");
				break;
			case 'auction_media':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					max_media='" . $post_details['max_media'] . "',
					media_max_size='" . $post_details['media_max_size'] . "', 
					enable_embedded_media='" . $post_details['enable_embedded_media'] . "'");
				break;
			case 'buy_out_method':
				$buyout_process = ($setts['enable_store_only_mode']) ? 1 : $post_details['buyout_process'];
				
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					buyout_process='" . $buyout_process . "', 
					makeoffer_process='" . $post_details['makeoffer_process'] . "'");
				break;
			case 'sellitem_buttons':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					sell_nav_position='" . $post_details['sell_nav_position'] . "'");
				break;
			case 'nb_autorelists':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					nb_autorelist_max='" . $post_details['nb_autorelist_max'] . "', 
					enable_auto_relist='" . $post_details['enable_auto_relist'] . "'");
				break;
			case 'enable_tax':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					enable_tax = '" . $post_details['enable_tax'] . "',
					vat_number = '" . $post_details['vat_number'] . "'");
				break;
			case 'invoices_settings':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					invoice_header='" . $post_details['invoice_header'] . "',
					invoice_footer='" . $post_details['invoice_footer'] . "',
					invoice_comments='" . $post_details['invoice_comments'] . "'");
				break;
			case 'mcrypt':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					mcrypt_enabled='" . $post_details['mcrypt_enabled'] . "',
					mcrypt_key='" . $post_details['mcrypt_key'] . "'");
				break;
			case 'digital_downloads':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					dd_enabled='" . $post_details['dd_enabled'] . "',
					dd_max_size='" . $post_details['dd_max_size'] . "',
					dd_expiration='" . $post_details['dd_expiration'] . "',
					dd_terms='" . $post_details['dd_terms'] . "', 
					dd_folder='" . $post_details['dd_folder'] . "'");
				
				if ($post_details['dd_folder'] != $setts['dd_folder'] || !is_dir('../' . $post_details['dd_folder']))
				{
					$create_folder = secret_folder($post_details['dd_folder']);
					
					$msg_changes_saved .= '<p align="center">' . (($create_folder) ? AMSG_FOLDER_CREATE_SUCCESS : AMSG_FOLDER_CREATE_FAILURE) . '</p>';
				}
				break;
			case 'force_payment':
				$bo_time = ($post_details['force_payment_time'] > 0) ? $post_details['force_payment_time'] : 0;
				$bo_enabled = ($bo_time > 0 && $post_details['enable_force_payment'] > 0) ? 1 : 0;
				
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					enable_force_payment='" . $bo_enabled . "',
					force_payment_time='" . $bo_time . "'");
				break;
			case 'ga_code':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					ga_code='" . $post_details['ga_code'] . "'");
				break;
			case 'r_hpfeat_items':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					r_hpfeat_nb='" . $post_details['r_hpfeat_nb'] . "',
					r_hpfeat_max='" . $post_details['r_hpfeat_max'] . "'");
				break;
			case 'r_catfeat_items':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					r_catfeat_nb='" . $post_details['r_catfeat_nb'] . "',
					r_catfeat_max='" . $post_details['r_catfeat_max'] . "'");
				break;
			case 'recent_reverse':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "layout_setts SET
					r_recent_nb='" . $post_details['r_recent_nb'] . "'");
				break;
			case 'fulltext_search_method':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					fulltext_search_method='" . $post_details['fulltext_search_method'] . "'");
				break;
			case 'browse_thumb_size':
				$sql_update_query = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
					browse_thumb_size='" . $post_details['browse_thumb_size'] . "'");
				break;
		}
		$template->set('msg_changes_saved', $msg_changes_saved);
	}

	(string) $header_section = null;
	(string) $subpage_title = null;

	$setts_tmp = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "gen_setts");
	$layout_tmp  = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "layout_setts");

	$template->set('setts_tmp', $setts_tmp);
	$template->set('layout_tmp', $layout_tmp);
	$template->set('page', $_REQUEST['page']);

	if ($_REQUEST['page'] == 'signup_settings')
	{
		$header_section = AMSG_USERS_MANAGEMENT;
		$subpage_title = AMSG_USER_SIGNUP_SETTS;
	}
	else if ($_REQUEST['page'] == 'closed_auctions_deletion')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_CLOSED_AUCT_DEL;
	}
	else if ($_REQUEST['page'] == 'hpfeat_items')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_HPFEAT_ITEMS;
	}
	else if ($_REQUEST['page'] == 'catfeat_items')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_CATFEAT_ITEMS;
	}
	else if ($_REQUEST['page'] == 'recently_listed_auctions')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_RECENT_AUCTIONS;
	}
	else if ($_REQUEST['page'] == 'popular_auctions')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_POPULAR_AUCTIONS;
	}
	else if ($_REQUEST['page'] == 'ending_soon_auctions')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_ENDING_SOON_AUCTIONS;
	}
	else if ($_REQUEST['page'] == 'auction_images')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_AUCTION_IMAGES_SETTS;
	}
	else if ($_REQUEST['page'] == 'currency_setts')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_CURRENCY_SETTS;

		$template->set('currency_drop_down', $item->currency_drop_down('currency', $setts_tmp['currency']));
	}
	else if ($_REQUEST['page'] == 'time_date_setts')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_TIME_DATE_SETTS;

		$template->set('timezones_drop_down', timezones_drop_down($setts_tmp['time_offset']));
	}
	else if ($_REQUEST['page'] == 'ssl_support')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_SETUP_SSL_SUPPORT;
	}
	else if ($_REQUEST['page'] == 'meta_tags')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_META_TAGS_SETTS;
	}
	else if ($_REQUEST['page'] == 'cron_jobs')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_CRON_JOBS_SETTS;
	}
	else if ($_REQUEST['page'] == 'min_reg_age')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_MIN_REG_AGE_SETTS;
	}
	else if ($_REQUEST['page'] == 'recent_wanted_ads')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_RECENT_WANTED_ADS;
	}
	else if ($_REQUEST['page'] == 'auction_media')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_MEDIA_UPLOAD_SETTS;
	}
	else if ($_REQUEST['page'] == 'buy_out_method')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_SEL_BUY_OUT_METHOD;
	}
	else if ($_REQUEST['page'] == 'sellitem_buttons')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_SELLING_PROCESS_NAV_BTNS;
	}
	else if ($_REQUEST['page'] == 'nb_autorelists')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_AUTO_RELIST_SETTINGS;
	}
	else if ($_REQUEST['page'] == 'enable_tax')
	{
		$header_section = AMSG_TAX_SETTINGS;
		$subpage_title = AMSG_ENABLE_TAX;
	}
	else if ($_REQUEST['page'] == 'invoices_settings')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_INVOICES_SETTINGS;
	}
	else if ($_REQUEST['page'] == 'mcrypt')
	{
		$header_section = AMSG_FEES;
		$subpage_title = AMSG_MCRYPT_SETTINGS;
	}
	else if ($_REQUEST['page'] == 'digital_downloads')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_DIGITAL_DOWNLOADS;
	}
	else if ($_REQUEST['page'] == 'convert_tax')
	{
		$header_section = AMSG_TAX_SETTINGS;
		$subpage_title = AMSG_TAX_CONVERSION;

		$tax_info = new tax();
		$convert_tax = $tax_info->convert_tax();
		$template->set('convert_tax', $convert_tax);
	}
	else if ($_REQUEST['page'] == 'force_payment')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_BUY_OUT_FORCE_PAYMENT;
	}
	else if ($_REQUEST['page'] == 'ga_code')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_GA_CODE;
	}
	else if ($_REQUEST['page'] == 'r_hpfeat_items')
	{
		$header_section = AMSG_REVERSE_AUCTIONS_MANAGEMENT;
		$subpage_title = AMSG_HPFEAT_RA;
	}
	else if ($_REQUEST['page'] == 'r_catfeat_items')
	{
		$header_section = AMSG_REVERSE_AUCTIONS_MANAGEMENT;
		$subpage_title = AMSG_CATFEAT_RA;
	}
	else if ($_REQUEST['page'] == 'recent_reverse')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_RECENT_REVERSE;
	}
	else if ($_REQUEST['page'] == 'fulltext_search_method')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_FULLTEXT_SEARCH_METHOD;
	}
	else if ($_REQUEST['page'] == 'browse_thumb_size')
	{
		$header_section = AMSG_GENERAL_SETTINGS;
		$subpage_title = AMSG_BROWSE_THUMB_SIZE;
	}

	$template->set('header_section', $header_section);
	$template->set('subpage_title', $subpage_title);

	$template_output .= $template->process('general_settings.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>