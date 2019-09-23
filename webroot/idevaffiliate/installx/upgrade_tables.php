<?PHP
mysql_query("ALTER TABLE idevaff_admin ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_ads ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_affiliates ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_archive ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_banners ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_colors ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_config ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_custom ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_email ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_faq ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_groups ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_integration ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_iptracking ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_keywords ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_links ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_paylevels ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_payments ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_recurring ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_rewards ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_sales ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_terms ENGINE=MyISAM");
mysql_query("ALTER TABLE idevaff_tlog ENGINE=MyISAM");

if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'idevaff_alert'"))==1) {
mysql_query("ALTER TABLE idevaff_alert ENGINE=MyISAM"); }


mysql_query("ALTER TABLE idevaff_affiliates ADD suspended INT( 1 ) NOT NULL AFTER approved");
mysql_query("ALTER TABLE idevaff_archive ADD profile INT ( 2 ) NOT NULL DEFAULT '0' AFTER split");
mysql_query("ALTER TABLE idevaff_config DROP admin_email");
mysql_query("ALTER TABLE idevaff_config ADD tier_payout_flat DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00' AFTER tier_payout");
mysql_query("ALTER TABLE idevaff_config DROP lang");
mysql_query("ALTER TABLE idevaff_config DROP ssn_req");
mysql_query("ALTER TABLE idevaff_config DROP skin");
mysql_query("ALTER TABLE idevaff_config ADD license VARCHAR( 64 ) NOT NULL AFTER version");
mysql_query("ALTER TABLE idevaff_config ADD license_method ENUM( 'phpaudit_exec_socket', 'phpaudit_exec_curl', 'file_get_contents' ) NOT NULL DEFAULT 'phpaudit_exec_socket'");
mysql_query("ALTER TABLE idevaff_config ADD license_local_key BLOB NOT NULL");
mysql_query("ALTER TABLE idevaff_config ADD tpaystyle INT( 1 ) NOT NULL");
mysql_query("ALTER TABLE idevaff_config ADD filename VARCHAR( 128 ) NOT NULL");
mysql_query("ALTER TABLE idevaff_config ADD use_email INT( 1 ) NOT NULL");
mysql_query("ALTER TABLE idevaff_config ADD email_interval INT( 5 ) NOT NULL");
mysql_query("ALTER TABLE idevaff_config ADD lead_approval INT( 1 ) NOT NULL");
mysql_query("ALTER TABLE idevaff_config ADD secret INT( 25 ) NOT NULL");
mysql_query("ALTER TABLE idevaff_email DROP default_footer_aff");
mysql_query("ALTER TABLE idevaff_email DROP welcome_footer");
mysql_query("ALTER TABLE idevaff_email DROP admin_acct_footer");
mysql_query("ALTER TABLE idevaff_email DROP comm_footer");
mysql_query("ALTER TABLE idevaff_email DROP new_app_footer");
mysql_query("ALTER TABLE idevaff_email DROP admin_rec_footer");
mysql_query("ALTER TABLE idevaff_email DROP admin_rew_footer");
mysql_query("ALTER TABLE idevaff_email DROP rew_footer");
mysql_query("ALTER TABLE idevaff_email DROP dear_1");
mysql_query("ALTER TABLE idevaff_email DROP dear_2");
mysql_query("ALTER TABLE idevaff_email DROP dear_3");
mysql_query("ALTER TABLE idevaff_email DROP dear_4");
mysql_query("ALTER TABLE idevaff_email DROP dear_5");
mysql_query("ALTER TABLE idevaff_email DROP dear_6");
mysql_query("ALTER TABLE idevaff_email ADD admin_fail_subject TEXT NOT NULL");
mysql_query("ALTER TABLE idevaff_email ADD admin_fail_body TEXT NOT NULL");
mysql_query("ALTER TABLE idevaff_email ADD login_subject TEXT NOT NULL");
mysql_query("ALTER TABLE idevaff_email ADD login_body TEXT NOT NULL");
mysql_query("delete from idevaff_integration");

mysql_query("DROP TABLE IF EXISTS idevaff_email_interval");
mysql_query("CREATE TABLE idevaff_email_interval (
  id int(255) NOT NULL auto_increment,
  aff int(255) NOT NULL default '0',
  wait int(40) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM");


mysql_query("DROP TABLE IF EXISTS idevaff_email_settings");
mysql_query("CREATE TABLE idevaff_email_settings (
  address varchar(128) NOT NULL default '',
  alternate_email_address varchar(128) NOT NULL default '',
  from_name varchar(64) NOT NULL default '',
  signature text NOT NULL,
  transport int(1) NOT NULL default '0',
  smtp_port int(5) NOT NULL default '0',
  smtp_host varchar(64) NOT NULL default '',
  smtp_auth varchar(10) NOT NULL default '',
  smtp_user varchar(64) NOT NULL default '',
  smtp_pass varchar(64) NOT NULL default '',
  PRIMARY KEY  (address)
) ENGINE=MyISAM");


mysql_query("DROP TABLE IF EXISTS idevaff_form_custom_data");
mysql_query("CREATE TABLE idevaff_form_custom_data (
  id int(255) NOT NULL auto_increment,
  affid int(255) NOT NULL default '0',
  custom_id int(255) NOT NULL default '0',
  custom_value varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM");


mysql_query("DROP TABLE IF EXISTS idevaff_form_fields");
mysql_query("CREATE TABLE idevaff_form_fields (
  id int(11) NOT NULL auto_increment,
  used int(11) NOT NULL default '0',
  req int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM");

mysql_query("DROP TABLE IF EXISTS idevaff_form_fields_custom");
mysql_query("CREATE TABLE idevaff_form_fields_custom (
  id int(255) NOT NULL auto_increment,
  name varchar(64) NOT NULL default '',
  title varchar(128) NOT NULL default '',
  def_value varchar(128) NOT NULL default '',
  req int(1) NOT NULL default '0',
  sort int(255) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM");




mysql_query("ALTER TABLE idevaff_groups ADD hads INT( 10 ) NOT NULL AFTER links");


mysql_query("DROP TABLE IF EXISTS idevaff_htmlads");
mysql_query("CREATE TABLE idevaff_htmlads (
  id int(255) NOT NULL auto_increment,
  name varchar(128) NOT NULL default '',
  grp int(255) NOT NULL default '0',
  html_code longtext NOT NULL,
  hits int(255) NOT NULL default '0',
  conv int(255) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM");

mysql_query("ALTER TABLE idevaff_integration ADD cart_var1 TEXT NOT NULL AFTER idev_var1");
mysql_query("ALTER TABLE idevaff_integration ADD cart_var2 TEXT NOT NULL AFTER idev_var2");
mysql_query("ALTER TABLE idevaff_integration ADD cart_var3 TEXT NOT NULL AFTER idev_var3");


mysql_query("DROP TABLE IF EXISTS idevaff_invoice");
mysql_query("CREATE TABLE idevaff_invoice (
  company varchar(255) NOT NULL default '',
  ad1 varchar(100) NOT NULL default '',
  ad2 varchar(50) NOT NULL default '',
  city varchar(100) NOT NULL default '',
  state varchar(50) NOT NULL default '',
  zip varchar(20) NOT NULL default '',
  country char(2) NOT NULL default '',
  note varchar(255) NOT NULL default ''
) ENGINE=MyISAM");

mysql_query("ALTER TABLE idevaff_keywords ADD url TEXT NOT NULL");


mysql_query("DROP TABLE IF EXISTS idevaff_language_english");
mysql_query("CREATE TABLE idevaff_language_english (
  header_title mediumtext NOT NULL,
  header_indexLink mediumtext NOT NULL,
  header_signupLink mediumtext NOT NULL,
  header_accountLink mediumtext NOT NULL,
  header_emailLink mediumtext NOT NULL,
  header_greeting mediumtext NOT NULL,
  header_nonLogged mediumtext NOT NULL,
  header_logout mediumtext NOT NULL,
  footer_tag mediumtext NOT NULL,
  footer_copyright mediumtext NOT NULL,
  footer_rights mediumtext NOT NULL,
  index_heading_1 mediumtext NOT NULL,
  index_paragraph_1 mediumtext NOT NULL,
  index_heading_2 mediumtext NOT NULL,
  index_paragraph_2 mediumtext NOT NULL,
  index_heading_3 mediumtext NOT NULL,
  index_paragraph_3 mediumtext NOT NULL,
  index_login_title mediumtext NOT NULL,
  index_login_username mediumtext NOT NULL,
  index_login_password mediumtext NOT NULL,
  index_login_username_field mediumtext NOT NULL,
  index_login_password_field mediumtext NOT NULL,
  index_login_button mediumtext NOT NULL,
  index_login_signup_link mediumtext NOT NULL,
  index_table_title mediumtext NOT NULL,
  index_table_commission_type mediumtext NOT NULL,
  index_table_initial_deposit mediumtext NOT NULL,
  index_table_requirements mediumtext NOT NULL,
  index_table_duration mediumtext NOT NULL,
  index_table_choose mediumtext NOT NULL,
  index_table_sale mediumtext NOT NULL,
  index_table_click mediumtext NOT NULL,
  index_table_sale_text mediumtext NOT NULL,
  index_table_click_text mediumtext NOT NULL,
  index_table_deposit_tag mediumtext NOT NULL,
  index_table_requirements_tag mediumtext NOT NULL,
  index_table_duration_tag mediumtext NOT NULL,
  signup_left_column_text mediumtext NOT NULL,
  signup_left_column_title mediumtext NOT NULL,
  signup_login_title mediumtext NOT NULL,
  signup_login_username mediumtext NOT NULL,
  signup_login_password mediumtext NOT NULL,
  signup_login_password_again mediumtext NOT NULL,
  signup_login_minmax_chars mediumtext NOT NULL,
  signup_login_must_match mediumtext NOT NULL,
  signup_standard_title mediumtext NOT NULL,
  signup_standard_email mediumtext NOT NULL,
  signup_standard_company mediumtext NOT NULL,
  signup_standard_checkspayable mediumtext NOT NULL,
  signup_standard_weburl mediumtext NOT NULL,
  signup_standard_taxinfo mediumtext NOT NULL,
  signup_personal_title mediumtext NOT NULL,
  signup_personal_fname mediumtext NOT NULL,
  signup_personal_state mediumtext NOT NULL,
  signup_personal_lname mediumtext NOT NULL,
  signup_personal_phone mediumtext NOT NULL,
  signup_personal_addr1 mediumtext NOT NULL,
  signup_personal_fax mediumtext NOT NULL,
  signup_personal_addr2 mediumtext NOT NULL,
  signup_personal_zip mediumtext NOT NULL,
  signup_personal_city mediumtext NOT NULL,
  signup_personal_country mediumtext NOT NULL,
  signup_commission_title mediumtext NOT NULL,
  signup_commission_howtopay mediumtext NOT NULL,
  signup_commission_style_PPS mediumtext NOT NULL,
  signup_commission_style_PPC mediumtext NOT NULL,
  signup_paypal_optional_title mediumtext NOT NULL,
  signup_paypal_optional_payme mediumtext NOT NULL,
  signup_paypal_optional_checkbox mediumtext NOT NULL,
  signup_paypal_optional_account mediumtext NOT NULL,
  signup_paypal_optional_notes mediumtext NOT NULL,
  signup_paypal_required_title mediumtext NOT NULL,
  signup_paypal_required_account mediumtext NOT NULL,
  signup_paypal_required_notes mediumtext NOT NULL,
  signup_terms_title mediumtext NOT NULL,
  signup_terms_agree mediumtext NOT NULL,
  signup_page_button mediumtext NOT NULL,
  signup_success_email_comment mediumtext NOT NULL,
  signup_success_login_link mediumtext NOT NULL,
  custom_fields_title mediumtext NOT NULL,
  logout_msg mediumtext NOT NULL,
  signup_page_success mediumtext NOT NULL,
  login_left_column_title mediumtext NOT NULL,
  login_left_column_text mediumtext NOT NULL,
  login_title mediumtext NOT NULL,
  login_username mediumtext NOT NULL,
  login_password mediumtext NOT NULL,
  login_invalid mediumtext NOT NULL,
  login_now mediumtext NOT NULL,
  login_send_title mediumtext NOT NULL,
  login_send_username mediumtext NOT NULL,
  login_send_info mediumtext NOT NULL,
  login_send_pass mediumtext NOT NULL,
  login_send_bad mediumtext NOT NULL,
  help_new_password_heading mediumtext NOT NULL,
  help_new_password_info mediumtext NOT NULL,
  help_confirm_password_heading mediumtext NOT NULL,
  help_confirm_password_info mediumtext NOT NULL,
  help_custom_links_heading tinytext NOT NULL,
  help_custom_links_info tinytext NOT NULL,
  help_friends_footer_heading mediumtext NOT NULL,
  help_friends_footer_info mediumtext NOT NULL,
  help_friends_message_heading mediumtext NOT NULL,
  help_friends_message_info mediumtext NOT NULL,
  help_friends_subject_heading mediumtext NOT NULL,
  help_friends_subject_info mediumtext NOT NULL,
  error_title mediumtext NOT NULL,
  username_invalid mediumtext NOT NULL,
  username_taken mediumtext NOT NULL,
  username_short mediumtext NOT NULL,
  username_long mediumtext NOT NULL,
  password_invalid mediumtext NOT NULL,
  password_short mediumtext NOT NULL,
  password_long mediumtext NOT NULL,
  password_mismatch mediumtext NOT NULL,
  missing_checks mediumtext NOT NULL,
  missing_tax mediumtext NOT NULL,
  missing_fname mediumtext NOT NULL,
  missing_lname mediumtext NOT NULL,
  missing_email mediumtext NOT NULL,
  invalid_email mediumtext NOT NULL,
  missing_address mediumtext NOT NULL,
  missing_city mediumtext NOT NULL,
  missing_company mediumtext NOT NULL,
  missing_state mediumtext NOT NULL,
  missing_zip mediumtext NOT NULL,
  missing_phone mediumtext NOT NULL,
  missing_website mediumtext NOT NULL,
  missing_paypal mediumtext NOT NULL,
  missing_terms mediumtext NOT NULL,
  paypal_required mediumtext NOT NULL,
  missing_custom mediumtext NOT NULL,
  account_total_transactions mediumtext NOT NULL,
  account_standard_linking_code mediumtext NOT NULL,
  account_copy_paste mediumtext NOT NULL,
  account_not_approved mediumtext NOT NULL,
  account_suspended mediumtext NOT NULL,
  account_standard_earnings mediumtext NOT NULL,
  account_inc_bonus mediumtext NOT NULL,
  account_second_tier mediumtext NOT NULL,
  account_recurring mediumtext NOT NULL,
  account_not_available mediumtext NOT NULL,
  account_earned_todate mediumtext NOT NULL,
  menu_heading_overview mediumtext NOT NULL,
  menu_general_stats mediumtext NOT NULL,
  menu_tier_stats mediumtext NOT NULL,
  menu_payment_history mediumtext NOT NULL,
  menu_commission_details mediumtext NOT NULL,
  menu_recurring_commissions mediumtext NOT NULL,
  menu_traffic_log mediumtext NOT NULL,
  menu_heading_marketing mediumtext NOT NULL,
  menu_banners mediumtext NOT NULL,
  menu_text_ads mediumtext NOT NULL,
  menu_text_links mediumtext NOT NULL,
  menu_email_links mediumtext NOT NULL,
  menu_html_links mediumtext NOT NULL,
  menu_offline mediumtext NOT NULL,
  menu_tier_linking_code mediumtext NOT NULL,
  menu_email_friends mediumtext NOT NULL,
  menu_custom_links mediumtext NOT NULL,
  menu_heading_management mediumtext NOT NULL,
  menu_comalert mediumtext NOT NULL,
  menu_comstats mediumtext NOT NULL,
  menu_edit_account mediumtext NOT NULL,
  menu_change_pass mediumtext NOT NULL,
  menu_change_commission mediumtext NOT NULL,
  menu_heading_general_info mediumtext NOT NULL,
  menu_browse_affiliates mediumtext NOT NULL,
  menu_faq mediumtext NOT NULL,
  suspended_title mediumtext NOT NULL,
  suspended_heading mediumtext NOT NULL,
  suspended_notes mediumtext NOT NULL,
  pending_title mediumtext NOT NULL,
  pending_heading mediumtext NOT NULL,
  pending_note mediumtext NOT NULL,
  faq_title mediumtext NOT NULL,
  faq_none mediumtext NOT NULL,
  browse_title mediumtext NOT NULL,
  browse_none mediumtext NOT NULL,
  change_comm_title mediumtext NOT NULL,
  change_comm_curr_comm mediumtext NOT NULL,
  change_comm_curr_pay mediumtext NOT NULL,
  change_comm_new_comm mediumtext NOT NULL,
  change_comm_warning mediumtext NOT NULL,
  change_comm_button mediumtext NOT NULL,
  change_comm_no_other mediumtext NOT NULL,
  change_comm_level mediumtext NOT NULL,
  change_comm_updated mediumtext NOT NULL,
  password_title mediumtext NOT NULL,
  password_old_password mediumtext NOT NULL,
  password_new_password mediumtext NOT NULL,
  password_confirm_password mediumtext NOT NULL,
  password_button mediumtext NOT NULL,
  password_warning_old_missing mediumtext NOT NULL,
  password_warning_new_missing mediumtext NOT NULL,
  password_warning_mismatch mediumtext NOT NULL,
  password_warning_invalid mediumtext NOT NULL,
  password_notice mediumtext NOT NULL,
  edit_failed mediumtext NOT NULL,
  edit_success mediumtext NOT NULL,
  edit_button mediumtext NOT NULL,
  commissionstats_title mediumtext NOT NULL,
  commissionstats_info mediumtext NOT NULL,
  commissionstats_hint mediumtext NOT NULL,
  commissionstats_profile mediumtext NOT NULL,
  commissionstats_username mediumtext NOT NULL,
  commissionstats_password mediumtext NOT NULL,
  commissionstats_id mediumtext NOT NULL,
  commissionstats_source mediumtext NOT NULL,
  commissionstats_download mediumtext NOT NULL,
  commissionalert_title mediumtext NOT NULL,
  commissionalert_info mediumtext NOT NULL,
  commissionalert_hint mediumtext NOT NULL,
  commissionalert_profile mediumtext NOT NULL,
  commissionalert_username mediumtext NOT NULL,
  commissionalert_password mediumtext NOT NULL,
  commissionalert_id mediumtext NOT NULL,
  commissionalert_source mediumtext NOT NULL,
  commissionalert_download mediumtext NOT NULL,
  custom_title tinytext NOT NULL,
  custom_info mediumtext NOT NULL,
  custom_incoming_page tinytext NOT NULL,
  custom_incoming_info tinytext NOT NULL,
  custom_define_page tinytext NOT NULL,
  custom_define_info tinytext NOT NULL,
  custom_browse_link tinytext NOT NULL,
  custom_keyword tinytext NOT NULL,
  custom_create_button tinytext NOT NULL,
  custom_table_title tinytext NOT NULL,
  custom_table_link tinytext NOT NULL,
  custom_table_page tinytext NOT NULL,
  custom_table_hits tinytext NOT NULL,
  custom_table_sales tinytext NOT NULL,
  custom_table_rate tinytext NOT NULL,
  custom_table_remove tinytext NOT NULL,
  custom_table_open_link tinytext NOT NULL,
  custom_table_delete_link tinytext NOT NULL,
  custom_table_inactive tinytext NOT NULL,
  custom_disabled_title tinytext NOT NULL,
  custom_disabled_info tinytext NOT NULL,
  custom_warning_none tinytext NOT NULL,
  custom_warning_exists tinytext NOT NULL,
  custom_warning_invalid tinytext NOT NULL,
  custom_warning_url_invalid tinytext NOT NULL,
  custom_success tinytext NOT NULL,
  custom_remove_success tinytext NOT NULL,
  friends_title mediumtext NOT NULL,
  friends_info_one mediumtext NOT NULL,
  friends_info_two mediumtext NOT NULL,
  friends_info_three mediumtext NOT NULL,
  friends_heading_name mediumtext NOT NULL,
  friends_heading_email mediumtext NOT NULL,
  friends_recip_one mediumtext NOT NULL,
  friends_recip_two mediumtext NOT NULL,
  friends_recip_three mediumtext NOT NULL,
  friends_subject mediumtext NOT NULL,
  friends_body mediumtext NOT NULL,
  friends_insert mediumtext NOT NULL,
  friends_footer mediumtext NOT NULL,
  friends_chars_left mediumtext NOT NULL,
  friends_note_heading mediumtext NOT NULL,
  friends_note_one mediumtext NOT NULL,
  friends_note_two mediumtext NOT NULL,
  friends_note_three mediumtext NOT NULL,
  friends_note_four mediumtext NOT NULL,
  friends_button mediumtext NOT NULL,
  friends_footer_invalid mediumtext NOT NULL,
  friends_message_invalid mediumtext NOT NULL,
  friends_subject_invalid mediumtext NOT NULL,
  friends_recip_1_invalid_email mediumtext NOT NULL,
  friends_recip_1_invalid_name mediumtext NOT NULL,
  friends_recip_2_invalid_email mediumtext NOT NULL,
  friends_recip_2_invalid_name mediumtext NOT NULL,
  friends_recip_3_invalid_email mediumtext NOT NULL,
  friends_recip_3_invalid_name mediumtext NOT NULL,
  friends_success_one mediumtext NOT NULL,
  friends_success_two mediumtext NOT NULL,
  friends_send_again mediumtext NOT NULL,
  friends_send_again_sec mediumtext NOT NULL,
  offline_title mediumtext NOT NULL,
  offline_paragraph_one mediumtext NOT NULL,
  offline_send mediumtext NOT NULL,
  offline_page_link mediumtext NOT NULL,
  offline_paragraph_two mediumtext NOT NULL,
  banners_title mediumtext NOT NULL,
  banners_group mediumtext NOT NULL,
  banners_button mediumtext NOT NULL,
  banners_no_group mediumtext NOT NULL,
  banners_choose mediumtext NOT NULL,
  banners_notice mediumtext NOT NULL,
  banners_size mediumtext NOT NULL,
  banners_description mediumtext NOT NULL,
  banners_source mediumtext NOT NULL,
  ad_title mediumtext NOT NULL,
  ad_group mediumtext NOT NULL,
  ad_button mediumtext NOT NULL,
  ad_no_group mediumtext NOT NULL,
  ad_choose mediumtext NOT NULL,
  ad_notice mediumtext NOT NULL,
  ad_info mediumtext NOT NULL,
  ad_source mediumtext NOT NULL,
  links_title mediumtext NOT NULL,
  links_group mediumtext NOT NULL,
  links_button mediumtext NOT NULL,
  links_no_group mediumtext NOT NULL,
  links_choose mediumtext NOT NULL,
  links_notice mediumtext NOT NULL,
  links_source mediumtext NOT NULL,
  email_title mediumtext NOT NULL,
  email_group mediumtext NOT NULL,
  email_button mediumtext NOT NULL,
  email_no_group mediumtext NOT NULL,
  email_choose mediumtext NOT NULL,
  email_notice mediumtext NOT NULL,
  email_ascii mediumtext NOT NULL,
  email_html mediumtext NOT NULL,
  email_test mediumtext NOT NULL,
  email_test_info mediumtext NOT NULL,
  email_source mediumtext NOT NULL,
  html_title mediumtext NOT NULL,
  html_group mediumtext NOT NULL,
  html_button mediumtext NOT NULL,
  html_no_group mediumtext NOT NULL,
  html_choose mediumtext NOT NULL,
  html_notice mediumtext NOT NULL,
  html_view_link mediumtext NOT NULL,
  html_source mediumtext NOT NULL,
  traffic_title mediumtext NOT NULL,
  traffic_display mediumtext NOT NULL,
  traffic_display_visitors mediumtext NOT NULL,
  traffic_button mediumtext NOT NULL,
  traffic_title_details mediumtext NOT NULL,
  traffic_ip mediumtext NOT NULL,
  traffic_refer mediumtext NOT NULL,
  traffic_date mediumtext NOT NULL,
  traffic_time mediumtext NOT NULL,
  traffic_bottom_tag_one mediumtext NOT NULL,
  traffic_bottom_tag_two mediumtext NOT NULL,
  traffic_bottom_tag_three mediumtext NOT NULL,
  traffic_none mediumtext NOT NULL,
  traffic_no_url mediumtext NOT NULL,
  traffic_box_title mediumtext NOT NULL,
  traffic_box_info mediumtext NOT NULL,
  payment_title mediumtext NOT NULL,
  payment_date mediumtext NOT NULL,
  payment_commissions mediumtext NOT NULL,
  payment_amount mediumtext NOT NULL,
  payment_totals mediumtext NOT NULL,
  payment_none mediumtext NOT NULL,
  tier_stats_title mediumtext NOT NULL,
  tier_stats_accounts mediumtext NOT NULL,
  tier_stats_payout mediumtext NOT NULL,
  tier_stats_earnings mediumtext NOT NULL,
  tier_stats_grab_link mediumtext NOT NULL,
  tier_stats_none mediumtext NOT NULL,
  tier_stats_aff_title mediumtext NOT NULL,
  tier_stats_username mediumtext NOT NULL,
  tier_stats_current mediumtext NOT NULL,
  tier_stats_previous mediumtext NOT NULL,
  tier_stats_totals mediumtext NOT NULL,
  recurring_title mediumtext NOT NULL,
  recurring_none mediumtext NOT NULL,
  recurring_date mediumtext NOT NULL,
  recurring_status mediumtext NOT NULL,
  recurring_payout mediumtext NOT NULL,
  recurring_amount mediumtext NOT NULL,
  recurring_every mediumtext NOT NULL,
  recurring_in mediumtext NOT NULL,
  recurring_days mediumtext NOT NULL,
  recurring_total mediumtext NOT NULL,
  tlinks_title mediumtext NOT NULL,
  tlinks_embedded_one mediumtext NOT NULL,
  tlinks_embedded_two mediumtext NOT NULL,
  tlinks_embedded_current mediumtext NOT NULL,
  tlinks_embedded_type_1 mediumtext NOT NULL,
  tlinks_embedded_type_2 mediumtext NOT NULL,
  tlinks_forced_earn mediumtext NOT NULL,
  tlinks_forced_type_1 mediumtext NOT NULL,
  tlinks_forced_type_2 mediumtext NOT NULL,
  tlinks_forced_two mediumtext NOT NULL,
  tlinks_forced_code mediumtext NOT NULL,
  tlinks_forced_paste mediumtext NOT NULL,
  tlinks_forced_money mediumtext NOT NULL,
  comdetails_title mediumtext NOT NULL,
  comdetails_date mediumtext NOT NULL,
  comdetails_time mediumtext NOT NULL,
  comdetails_type mediumtext NOT NULL,
  comdetails_status mediumtext NOT NULL,
  comdetails_amount mediumtext NOT NULL,
  comdetails_additional_title mediumtext NOT NULL,
  comdetails_additional_ordnum mediumtext NOT NULL,
  comdetails_additional_saleamt mediumtext NOT NULL,
  comdetails_type_1 mediumtext NOT NULL,
  comdetails_type_2 mediumtext NOT NULL,
  comdetails_type_3 mediumtext NOT NULL,
  comdetails_type_4 mediumtext NOT NULL,
  comdetails_status_1 mediumtext NOT NULL,
  comdetails_status_2 mediumtext NOT NULL,
  comdetails_status_3 mediumtext NOT NULL,
  comdetails_not_available mediumtext NOT NULL,
  details_title mediumtext NOT NULL,
  details_drop_1 mediumtext NOT NULL,
  details_drop_2 mediumtext NOT NULL,
  details_drop_3 mediumtext NOT NULL,
  details_drop_4 mediumtext NOT NULL,
  details_drop_5 mediumtext NOT NULL,
  details_button mediumtext NOT NULL,
  details_date mediumtext NOT NULL,
  details_status mediumtext NOT NULL,
  details_commission mediumtext NOT NULL,
  details_details mediumtext NOT NULL,
  details_type_1 mediumtext NOT NULL,
  details_type_2 mediumtext NOT NULL,
  details_type_3 mediumtext NOT NULL,
  details_none mediumtext NOT NULL,
  details_no_group mediumtext NOT NULL,
  details_choose mediumtext NOT NULL,
  general_title mediumtext NOT NULL,
  general_transactions mediumtext NOT NULL,
  general_earnings_to_date mediumtext NOT NULL,
  general_history_link mediumtext NOT NULL,
  general_standard_earnings mediumtext NOT NULL,
  general_current_earnings mediumtext NOT NULL,
  general_traffic_title mediumtext NOT NULL,
  general_traffic_visitors mediumtext NOT NULL,
  general_traffic_unique mediumtext NOT NULL,
  general_traffic_sales mediumtext NOT NULL,
  general_traffic_ratio mediumtext NOT NULL,
  general_traffic_info mediumtext NOT NULL,
  general_traffic_pay_type mediumtext NOT NULL,
  general_traffic_pay_level mediumtext NOT NULL,
  general_notes_title mediumtext NOT NULL,
  general_notes_date mediumtext NOT NULL,
  general_notes_to mediumtext NOT NULL,
  general_notes_all mediumtext NOT NULL,
  general_notes_none mediumtext NOT NULL,
  contact_left_column_title mediumtext NOT NULL,
  contact_left_column_text mediumtext NOT NULL,
  contact_title mediumtext NOT NULL,
  contact_name mediumtext NOT NULL,
  contact_email mediumtext NOT NULL,
  contact_message mediumtext NOT NULL,
  contact_chars mediumtext NOT NULL,
  contact_button mediumtext NOT NULL,
  contact_received mediumtext NOT NULL,
  contact_invalid_name mediumtext NOT NULL,
  contact_invalid_email mediumtext NOT NULL,
  contact_invalid_message mediumtext NOT NULL
) ENGINE=MyISAM");


mysql_query("DROP TABLE IF EXISTS idevaff_language_packs");
mysql_query("CREATE TABLE idevaff_language_packs (
  id int(255) NOT NULL auto_increment,
  name varchar(20) NOT NULL default '',
  status int(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM");


mysql_query("DROP TABLE IF EXISTS idevaff_notes");
mysql_query("CREATE TABLE idevaff_notes (
  id mediumint(255) NOT NULL auto_increment,
  note_to int(255) NOT NULL default '0',
  note_sub text NOT NULL,
  note_con text NOT NULL,
  note_display int(1) NOT NULL default '0',
  note_attach int(1) NOT NULL default '0',
  note_date varchar(24) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM");

mysql_query("ALTER TABLE idevaff_payments ADD export INT( 1 ) NOT NULL AFTER stamp");


mysql_query("DROP TABLE IF EXISTS idevaff_pp_transactions");
mysql_query("CREATE TABLE idevaff_pp_transactions (
  id int(255) NOT NULL auto_increment,
  aff_id int(255) NOT NULL default '0',
  order_num varchar(50) NOT NULL default '',
  rec int(1) NOT NULL default '0',
  date date NOT NULL default '0000-00-00',
  time time NOT NULL default '00:00:00',
  amt decimal(10,2) NOT NULL default '0.00',
  op1 varchar(64) NOT NULL default '',
  op2 varchar(64) NOT NULL default '',
  op3 varchar(64) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM");

mysql_query("ALTER TABLE idevaff_recurring DROP time_stamp");
mysql_query("ALTER TABLE idevaff_recurring ADD profile INT ( 2 ) NOT NULL DEFAULT '0' AFTER type");

mysql_query("ALTER TABLE idevaff_sales ADD profile INT( 2 ) NOT NULL AFTER split");

mysql_query("DROP TABLE IF EXISTS idevaff_suspensions");
mysql_query("CREATE TABLE idevaff_suspensions (
  id int(255) NOT NULL auto_increment,
  affid int(255) NOT NULL default '0',
  notice mediumtext NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM");

mysql_query("ALTER TABLE idevaff_config CHANGE `offline_loc` `offline_loc` varchar(128) NOT NULL");
mysql_query("ALTER TABLE idevaff_config CHANGE `offline_send` `offline_send` varchar(128) NOT NULL");










$checkdata = mysql_query("select * from idevaff_email");
$checkdata = mysql_num_rows($checkdata); if (!$checkdata) {
mysql_query("delete from idevaff_email");
mysql_query("insert into idevaff_email VALUES ('Our Affiliate Program Affiliate Approval', 'Dear _firstname_,\r\n\r\nWe have approved your account!  You can now login and get your banner linking code, check stats, etc.', 'Sincerely,\r\n\r\nAffiliates Manager\r\nYour Site Name\r\nhttp://www.yoursitenamehere.com', 'Our Affiliate Program Affiliate Decline Notice', 'Dear _firstname_,\r\n\r\nWe are sorry to inform you that we have decided not to approve your affiliate account at this time.  If you would like more information, please respond to this email and we would be happy to explain our decision in more detail.', 'Sincerely,\r\n\r\nAffiliates Manager\r\nYour Site Name\r\nhttp://www.yoursitenamehere.com', 'Welcome To The iDevTest Affiliate Program!', 'Dear _firstname_,\r\n\r\nWelcome to the iDevTest affiliate program.  Once we have approved your account, you can login and retrieve your banner linking code, check your sales and traffic stats and much more.', 'New Affiliate Account on Our Affiliate Program', 'Dear Admin,\r\n\r\nYou have a new affiliate.  If you chose to approve new accounts, you will need to login to your admin center and either approve or decline this account.\r\n\r\nAffiliate ID: _id_', 'New Commission on Our Affiliate Program', '-----------------------------------------\r\nAuto Message Sent By iDevAffiliate (v4.0)', 'Dear Admin,\r\n\r\nYou have a new affiliate commission on Our Affiliate Program.  If you chose to approve commissions, you will need to login to your admin center and either approve or decline this commission.', 'Payment Notification - Our Affiliate Program Affiliate Program', 'Dear _firstname_,\r\n\r\nWe have sent your commission payment for this month.  Be sure to login and check your financial history as well as other important stats.  We hope to continue building a strong partnership with you!\r\n\r\n_email_', 'New Commission Notification - Our Affiliate Program Affiliate Program', 'Dear _firstname_,\r\n\r\nCongratulations!  You have generated a commission on the Our Affiliate Program affiliate program.  Be sure to login to your account to check your accounting history and current stats.', 'While surfing around, I found a site you might like.  You can get to it using the link below.', 'Found A Site For You!', 'New Recurring Commission on Our Affiliate Program', 'Dear Admin,\r\n\r\niDevAffiliate has automatically generated a new sale from your list of recurring sales.  Please login to approve this recurring sale and manage your affiliates.', 'Performance Reward Issued', 'Dear Admin,\r\n\r\niDevAffiliate has issued a performance reward and has automatically increased the payout level of an affiliate.', 'Performance Reward Issued', 'Dear _firstname_,\r\n\r\nOur affiliate system has issued you a performance reward and has automatically increased your payout level!  Please login to check your new commission status.', 'Commission Failure on Sitename', 'Dear Admin,\r\n\r\niDevAffiliate tried processing a commission and failed.  You will only receive this message if you chose not to approve commissions in the admin center.  This commission was not written to the database due to one of the following reasons.\r\n\r\nA.) iDevAffiliate didn''t receive the sale amount.\r\nB.) The commission amount was to low to calculate.\r\nC.) Your cart integration is not setup properly.\r\n\r\nCheck your Cart Integration, Processing Code Placement or make sure the sale amount was large enough to perform a percentage calculation on.', 'Our Affiliate Program Login Details', 'Dear _firstname_,\r\n\r\nYour requested login information is below.\r\n\r\nUsername: _username_\r\nPassword: _password_\r\n\r\nLogin Here:\r\n_loginpage_')"); }

$checkdata = mysql_query("select * from idevaff_email_settings");
$checkdata = mysql_num_rows($checkdata); if (!$checkdata) {
mysql_query("insert into idevaff_email_settings VALUES ('you@yoursite.com', 'you@yoursite.com', 'Your Name', 'Sincerely,\r\n\r\nYour Name', 1, 0, 'localhost', 'false', '', '')"); }

$checkdata = mysql_query("select * from idevaff_form_fields");
$checkdata = mysql_num_rows($checkdata); if (!$checkdata) {
mysql_query("insert into idevaff_form_fields VALUES (1, 1, 1)");
mysql_query("insert into idevaff_form_fields VALUES (2, 1, 1)");
mysql_query("insert into idevaff_form_fields VALUES (3, 1, 1)");
mysql_query("insert into idevaff_form_fields VALUES (4, 1, 1)");
mysql_query("insert into idevaff_form_fields VALUES (5, 1, 1)"); }

$checkdata = mysql_query("select * from idevaff_invoice");
$checkdata = mysql_num_rows($checkdata); if (!$checkdata) {
mysql_query("insert into idevaff_invoice VALUES ('Your Business Name', '123 Main Street', 'Unit #904', 'Los Angeles', 'CA', '91355', 'US', 'Thank you for your continued participation in our affiliate program.')"); }

$checkdata = mysql_query("select * from idevaff_language_english");
$checkdata = mysql_num_rows($checkdata); if (!$checkdata) {
mysql_query("insert into idevaff_language_english VALUES (
'Affiliate Program', 'Home', 'Signup Now', 'Manage Account', 'Contact Us', 'Welcome', 'Guest', 'Logout Here', 'Affiliate Software By iDevAffiliate', 'Copyright 2006', 'All Rights Reserved', 'Welcome To Our Affiliate Program!', 'Our program is free to join, it''s easy to sign-up and requires no technical knowledge.  Affiliate programs are common throughout the Internet and offer website owners an additional way to profit from their websites.  Affiliates generate traffic and sales for commercial websites and in return receive a commission payment.', 'How Does It Work?', 'When you join our affiliate program, you will be supplied with a range of banners and textual links that you place within your site.  When a user clicks on one of your links, they will be brought to our website and their activity will be tracked by our affiliate software.  You will earn a commission based on your commission type.', 'Real-Time Statistics and Reporting!', 'Login 24 hours a day to check your sales, traffic, account balance and see how your banners are performing.', 'Affiliate Login', 'Username', 'Password', 'username', 'password', 'Login', 'Click Here To Signup', 'Program Details', 'Commission Type', 'Initial Deposit', 'Payout Requirements', 'Payout Duration', 'Choose from the following payout options!', 'Pay-Per-Sale', 'Pay-Per-Click', 'for each sale you deliver.', 'for each click you deliver.', 'Just for signing up!', 'Minimum balance required for payout.', 'Payments are made once per month, for the previous month.', 'Join our affiliate program and start earning money for every sale you send our way!  Simply create your account, place your linking code into your website and watch your account balance grow as your visitors become our customers.', 'Welcome Affiliate!', 'Create Your Account', 'Username', 'Password', 'Password Again', 'Must be at least 4 characters in length and not more than 12 characters in length. It may only contain letters, numbers and underscores.', 'This entry must match the Password entry.', 'Standard Information', 'Email Address', 'Company Name', 'Checks Payable To', 'Website Address', 'Tax ID, SSN or VAT', 'Personal Information', 'First Name', 'State or Province', 'Last Name', 'Phone Number', 'Street Address', 'Fax Number', 'Additional Address', 'Zip Code', 'City', 'Country', 'Commission Payment', 'How should we pay you?', 'Pay-Per-Sale', 'Pay-Per-Click', 'Optional PayPal Payment', 'Pay Me Using PayPal', 'checkbox', 'PayPal Account', '<b>Receiving A PayPal Payment From Us Is Optional</b><BR />&nbsp;If you choose not to receive PayPal payments from us, we''ll send you a paper check in the mail.', 'Required PayPal Payment Information', 'PayPal Account', '<b>Receiving A PayPal Payment From Us Is Required</b><BR />&nbsp;You must have a PayPal account in order for us to pay you commissions.', 'Terms and Conditions', 'I have read, understand and agree to the above terms and conditions.', 'Create My Account', 'We have sent an email to you with your Username and Password.<BR />\r\nYou should keep this in a safe place for future reference.', 'Login To Your Account', 'User Defined Fields', '<b>You Are Now Logged Out</b><BR />Thank you for your participation in our affiliate program.', 'Your Account Has Been Created', 'Account Login', 'Enter your username and password to gain access to your account statistics, banners, linking code, FAQ and more.<BR/ ><BR/ >If you can''t remember your password, enter your username and we''ll send your login information to you via email.<BR /><BR />', 'Login To Your Account', 'Username', 'Password', 'Invalid Login', 'Login To My Account', 'Need Your Password?', 'Enter Your Username', 'Login Details Sent To Email', 'Send To Email', 'Username Not Found', 'New Password', 'Your password must be at least 4 characters in length and not more than 12 characters in length. It may only contain letters, numbers and underscores.', 'Confirm New Password', 'This password entry must match the New Password entry.', 'Tracking Keyword', 'Your keyword may not be more than 15 characters in length. It may only contain letters, numbers and hyphens.', 'Footer', 'Your subject may not be more than 100 characters in length. It may only contain letters, numbers, periods, exclamation points, commas and question marks.', 'Message Body', 'Your message body may not be more than 250 characters in length. It may only contain letters, numbers, periods, exclamation points, commas and question marks.', 'Subject', 'Your subject may not be more than 40 characters in length. It may only contain letters, numbers, periods, exclamation points, commas and question marks.', 'The Following Errors Were Detected', 'Invalid username. It may only contain letters, numbers and underscores.', 'The username you have chosen has already been taken.', 'Your username is too short, it must be at least 4 characters in length.', 'Your username is too long, it must be a maximum of 12 characters in length.', 'Invalid password. It may only contain letters, numbers and underscores.', 'Your password is too short, it must be at least 4 characters in length.', 'Your password is too long, it must be a maximum of 12 characters in length.', 'Your password entries do not match.', 'Please enter a payee name to make checks payable to.', 'Please enter your Tax ID, SSN or VAT information.', 'Please enter your first name.', 'Please enter your last name.', 'Please enter your email address.', 'Your email address is invalid.', 'Please enter your street address.', 'Please enter your city.', 'Please enter your company name.', 'Please enter your state or province.', 'Please enter your zip code.', 'Please enter your phone number.', 'Please enter your website address.', 'You have chosen to receive PayPal payments, please enter your PayPal account.', 'You have not accepted our terms and conditions.', 'A PayPal account is required for payment.', 'Please complete the field named:', 'Total Transactions', 'Standard Linking Code - Great For Use In Emails!', 'Copy/Paste The Above Code Into Your Website or Emails', 'Your Account Is Currently Pending Approval', 'Your Account Is Currently Suspended', 'Standard Earnings', 'includes bonus', 'Tier Earnings', 'Recurring Earnings', 'N/A', 'Total Earned To Date', 'Account Overview', 'General Statistics', 'Tier Statistics', 'Payment History', 'Commission Details', 'Recurring Commissions', 'Incoming Traffic Log', 'Marketing Materials', 'Banners', 'Text Ads', 'Text Links', 'Email Links', 'HTML Ads', 'Offline Marketing', 'Tier Linking Code', 'Email Friends & Associates', 'Build & Track Your Own Links', 'Account Management', 'CommissionAlert Setup', 'CommissionStats Setup', 'Edit My Account', 'Change My Password', 'Change My Commission Style', 'General Information', 'Browse Other Affiliates', 'Frequently Asked Questions', 'Account Status Alert', 'Your Account Is Currently Suspended', 'Administrator Notes', 'Account Status Alert', 'Your Account Is Currently Pending Approval', 'Once we have approved your account, marketing materials will be made available to you.', 'Frequently Asked Questions', 'No FAQ''s Yet', 'Browse Other Affiliates', 'No Other Affiliates To View', 'Change Commission Style', 'Current Commission Style', 'Current Payout Level', 'New Commission Style', 'If You Change Commission Styles, Your Account Will Be Reset To Payout Level 1', 'Change Commission Styles', 'No Other Commission Styles Available', 'Level', 'Commission Style Updated', 'Change My Password', 'Old Password', 'New Password', 'Confirm New Password', 'Change Password', 'Old Password Is Incorrect or Missing', 'New Password Entry Missing', 
'New Password Does Not Match', 'Password Invalid - Click The Help Links', 'Password Updated', 'Update Failed - See Above Errors', 'Account Updated', 'Edit My Account', 'CommissionStats Setup', 'By installing CommissionStats you can check your stats instantly, right from your Windows desktop!  To install this feature, download CommissionStats and <a href=\"http://www.winzip.com/downwz.htm\" target=\"_blank\"><b>unzip</b></a> the package to your hard drive then run the <b>setup.exe</b> file.  When prompted for your login information, enter the following details.', 'Hint: Copy & Paste Each Entry To Ensure Accuracy', 'Profile Name', 'Username', 'Password', 'Affiliate ID', 'Source Path URL', 'Download CommissionStats', 'CommissionAlert Setup', 'By installing CommissionAlert we''ll notify you instantly of new commissions, right on your Windows desktop!  To install this feature, download CommissionAlert and <a href=\"http://www.winzip.com/downwz.htm\" target=\"_blank\"><b>unzip</b></a> the package to your hard drive then run the <b>setup.exe</b> file.  When prompted for your login information, enter the following details.', 'Hint: Copy & Paste Each Entry To Ensure Accuracy', 'Profile Name', 'Username', 'Password', 'Affiliate ID', 'Source Path URL', 'Download CommissionAlert', 'Create A Custom Link', 'Creating a custom link allows you to deliver traffic into any page of our website you want.  You''ll also be able to track the success of the link by adding a custom keyword to it.  You can pick a predefined link or you can define your own.  Your customers will be sent the page you choose.', 'Incoming Page', 'Pick a <font color=\"#CC0000\">pre-defined</font> link above and customers will be sent directly to that page.', 'Define Your Own', 'Pick <font color=\"#CC0000\">any page</font> on our website and customers will be sent directly to that page.', 'browse our website', 'Tracking Keyword', 'Create New Link', 'Custom Keyword Link', 'Keyword Link', 'Incoming Page', 'Unique Hits', 'Sales', 'Conv. Rate', 'Remove', 'Open In New Window', 'Delete', 'This link has been made inactive.', 'Featured Disabled', 'This Feature Is Disabled For Pay-Per-Click Accounts', 'No Keyword Entered', 'Keyword Already Exists', 'Keyword Invalid - Click The Help Link', 'Custom URL Location Invalid', 'Keyword Link Created', 'Keyword Link Removed', 'Email Friends & Associates', 'Email up to 3 friends or associates at one time.', 'You can send messages once every', 'minutes', 'Name', 'Email Address', 'Recipient #1', 'Recipient #2', 'Recipient #3', 'Subject', 'Message Body', 'Auto Insert', 'Footer', 'characters left', 'Email Notes', 'This message will be sent using your email address', 'This message will be sent using your real first and last name in the email headers', 'To help prevent SPAM blockage, this message will be sent in text mode', 'Abuse of this system will result in a suspension or termination of your account', 'Send Email Message', 'Footer Invalid - Click The Help Link', 'Message Invalid - Click The Help Link', 'Subject Invalid - Click The Help Link', 'Recipient #1 - Invalid Email', 'Recipient #1 - Invalid Name', 'Recipient #2 - Invalid Email', 'Recipient #2 - Invalid Name', 'Recipient #3 - Invalid Email', 'Recipient #3 - Invalid Name', 'Message Sent To', 'Recipient', 'Send Another Message In', 'Seconds', 'Offline Marketing', 'Earn money by promoting our website (offline) to your friends and associates!', 'Send Customers To', 'view page', 'Your customers will enter your <b>Affiliate ID number</b> into the box on the above page which will register you as the affiliate for any purchases they make.', 'Banners', 'Marketing Group', 'Display Banners', 'No Group Selected', 'Please Choose A Marketing Group Above', 'Marketing Groups May Have Different Incoming Traffic Pages', 'Banner Size', 'Banner Description', 'Source Code - Copy/Paste Into Your Website', 'Text Ads', 'Marketing Group', 'Display Text Ads', 'No Group Selected', 'Please Choose A Marketing Group Above', 'Marketing Groups May Have Different Incoming Traffic Pages', 'Using the provided linking code, you can adjust the <b>color scheme</b>, <b>height</b> and <b>width</b> of your Text Ad to easily integrate with your site!', 'Source Code - Copy/Paste Into Your Website', 'Text Links', 'Marketing Group', 'Display Text Links', 'No Group Selected', 'Please Choose A Marketing Group Above', 'Marketing Groups May Have Different Incoming Traffic Pages', 'Source Code - Copy/Paste Into Your Website', 'Email Links', 'Marketing Group', 'Display Email Links', 'No Group Selected', 'Please Choose A Marketing Group Above', 'Marketing Groups May Have Different Incoming Traffic Pages', '<b>ASCII/Text Version</b> - For use in Plain Text emails.', '<b>HTML Version</b> - For use in HTML formatted emails.', 'Test Link', 'This is where your customers will be sent into our website.', 'Source Code - Copy/Paste Into Your Email Message', 'HTML Ads', 'Marketing Group', 'Display HTML Ads', 'No Group Selected', 'Please Choose A Marketing Group Above', 'Marketing Groups May Have Different Incoming Traffic Pages', 'View This HTML Ad', 'Source Code - Copy/Paste Into Your Website', 'Incoming Traffic Log', 'Display Last', 'Visitors', 'View Traffic Log', 'Incoming Traffic Details', 'IP Address', 'Referring URL', 'Date', 'Time', 'Displaying Last', 'of', 'Total Unique Visitors', 'No Traffic Logs Exist', 'N/A - Possible Bookmark or Email Link', 'Complete Referring URL', 'Click The Link To Visit Webpage', 'Payment History', 'Payment Date', 'Commissions', 'Payment Amount', 'Totals', 'No Payment History Exists', 'Tier Statistics', 'Tier Accounts', 'Current Payout', 'Tier Earnings', 'Grab Your Tier Linking Code', 'No Tier Accounts Exist', 'Tier Affiliates', 'Username', 'Current Commissions', 'Previous Payouts', 'Totals', 'Recurring Commissions', 'No Recurring Commissions Exists', 'Commission Date', 'Recurring Status', 'Next Payout', 'Amount', 'Every', 'In', 'Days', 'Total', 'Add Others To Your Tier And Make Money From Them Too!', 'Tier Signup Crediting Is Already Active In Your Standard Affiliate Links!', 'You will become the Top Tier for anyone who joins our affiliate program through your affiliate link.', 'Current Tier Payout', 'of each commission generated by an affiliate in your tier.', 'for each commission generated by an affiliate in your tier.', 'Earn', 'of each commission generated by an affiliate in your tier.', 'for each commission generated by an affiliate in your tier.', 'Use the following code to promote our affiliate program to other website owners.', 'Textual Linking Code', 'Copy/Paste The Above Code Into Your Website', 'Webmasters Earn Money Here!', 'Commission Details', 'Commission Date', 'Commission Time', 'Type of Commission', 'Current Status', 'Commission Amount', 'Additional Commission Details', 'Order Number', 'Sale Amount', 'Bonus Commission', 'Recurring Commission', 'Tier Commission', 'Standard Commission', 'Paid', 'Approved - Pending Payment', 'Pending Approval', 'N/A', 'Commission Details', 'Current Standard Commissions', 'Current Tier Commissions', 'Commissions Pending Approval', 'Paid Standard Commissions', 'Paid Tier Commissions', 'View Commissions', 'Date', 'Status', 'Commission', 'View Details', 'Paid', 'Pending Approval', 'Approved - Pending Payment', 'No Commissions To View', 'No Commission Group Selected', 'Please Choose A Commission Group Above', 'Current Commissions - From Last Payout To Date', 'Transactions', 'Earnings To Date', 'View Payment History', 'Standard Earnings', 'Current Earnings', 'Traffic Statistics', 'Visitors', 'Unique Visitors', 'Total Sales', 'Sales Ratio', 
'<b>Total Sales</b> and <b>Sales Ratio</b><BR />These statistics do not include recurring or tier commissions.', 'Payout Type', 'Current Payout Level', 'Notes From The Administrator', 'Date Created', 'To', 'All Affiliates', 'No Notes To View', 'Contact Us', 'Please feel free to contact our affiliates manager using the form to the right.', 'Contact Us', 'Your Name', 'Your Email Address', 'Message', 'characters left', 'Send Message', 'We''ve received your message, please allow 24 hours for a response.', 'Invalid Name', 'Invalid Email Address', 'Invalid Message'
)"); }

$checkdata = mysql_query("select * from idevaff_language_packs");
$checkdata = mysql_num_rows($checkdata); if (!$checkdata) {
mysql_query("insert into idevaff_language_packs VALUES (1, 'english', 1)"); }

mysql_query("update idevaff_config set tpaystyle = '1'");
mysql_query("update idevaff_config set filename = 'idevaffiliate.php'");
mysql_query("update idevaff_config set use_email = '1'");
mysql_query("update idevaff_config set email_interval = '2'");
mysql_query("update idevaff_config set lead_approval = '1'");
mysql_query("update idevaff_config set secret = '$random_key'");
mysql_query("update idevaff_config set license = '$license'");

















// -------------------------------------------
	$oldver = $version;
	$newver = "5.1";
// -------------------------------------------
// --- Start 5.0 to 5.1 Upgrade
// -------------------------------------------

mysql_query("update idevaff_config set version = '$newver'");

// UPDATE ENGLISH LANGUAGE PACK
$checkdat = mysql_query("SHOW COLUMNS from idevaff_language_english LIKE 'invoice_button'");
if (!mysql_num_rows($checkdat)) {
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_button` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_header` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_aff_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_co_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_acct_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_payment_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_comm_date` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_comm_amt` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_comm_type` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_admin_note` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_footer` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_print` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_none` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_aff_id` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_english ADD `invoice_aff_user` mediumtext NOT NULL");
mysql_query("update idevaff_language_english set invoice_button = 'Invoice', invoice_header = 'AFFILIATE PAYMENT INVOICE', invoice_aff_info = 'Affiliate Information', invoice_co_info = 'Information', invoice_acct_info = 'Account Information', invoice_payment_info = 'Payment Information', invoice_comm_date = 'Payment Date', invoice_comm_amt = 'Commission Amount', invoice_comm_type = 'Commission Type', invoice_admin_note = 'Administrator Note', invoice_footer = 'END OF INVOICE', invoice_print = 'Print Invoice', invoice_none = 'N/A', invoice_aff_id = 'Affiliate ID', invoice_aff_user = 'Username'");
}

mysql_query("ALTER TABLE idevaff_config CHANGE `offline_loc` `offline_loc` varchar(128)");
mysql_query("ALTER TABLE idevaff_config CHANGE `offline_send` `offline_send` varchar(128)");
mysql_query("ALTER TABLE idevaff_config CHANGE `offline_tag` `offline_tag` varchar(64)");

$checkdat = mysql_query("SHOW COLUMNS from idevaff_language_packs LIKE 'table_name'");
if (!mysql_num_rows($checkdat)) {
mysql_query("ALTER TABLE idevaff_language_packs ADD `table_name` varchar(64) NOT NULL default '0'");
mysql_query("update idevaff_language_packs set table_name = 'english' where name = 'english'");
}

$checkdat = mysql_query("SHOW COLUMNS from idevaff_language_packs LIKE 'def'");
if (!mysql_num_rows($checkdat)) {
mysql_query("ALTER TABLE idevaff_language_packs ADD `def` int(1) NOT NULL default '0'");
mysql_query("update idevaff_language_packs set def = '1' where table_name = 'english'");
}

// ADD LANGUAGE_CUSTOM TABLE
mysql_query("CREATE TABLE IF NOT EXISTS idevaff_language_custom (
  id int(255) NOT NULL auto_increment,
  name text NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM");
mysql_query("insert into idevaff_language_custom VALUES (1, 'custom_page_header')");

// ADD LANGUAGE_CUSTOM_VALUES TABLE
mysql_query("CREATE TABLE IF NOT EXISTS idevaff_language_custom_values (
  id int(255) NOT NULL auto_increment,
  pack_1 longtext,
  PRIMARY KEY  (id)
) ENGINE=MyISAM");
mysql_query("insert into idevaff_language_custom_values VALUES (1, 'Marketing Materials')");

// UPDATE INVOICE TABLE
$checkdat = mysql_query("SHOW COLUMNS from idevaff_invoice LIKE 'aff_inv'");
if (!mysql_num_rows($checkdat)) {
mysql_query("ALTER TABLE idevaff_invoice ADD `aff_inv` int(1) NOT NULL default '0'");
mysql_query("update idevaff_invoice set aff_inv = '1'");
}

?>