<?PHP

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






// UPDATE GOLD/PLATINUM/SEO WITH LANGUAGE ITEMS
$checkifplatplus = mysql_query("select id from idevaff_language_packs");
if (mysql_num_rows($checkifplatplus) > 1) {

// -------------------------------------------
// --- Update French Language
// -------------------------------------------
$french_check = mysql_query("select id from idevaff_language_packs where table_name = 'french'");
if (!mysql_num_rows($french_check)) {
mysql_query("update idevaff_language_packs set table_name = 'french' where name = 'french'");
$french_check = mysql_query("select id from idevaff_language_packs where table_name = 'french'");
$french_check = mysql_fetch_array($french_check);
$french_check = $french_check['id'];
$french_check = "pack_" . $french_check;
mysql_query("ALTER TABLE idevaff_language_custom_values ADD `$french_check` longtext");
mysql_query("update idevaff_language_custom_values set $french_check = 'Matériel de marketing'");
}
$french_check = mysql_query("SHOW COLUMNS from idevaff_language_french LIKE 'invoice_button'");
if (!mysql_num_rows($french_check)) {
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_button` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_header` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_aff_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_co_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_acct_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_payment_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_comm_date` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_comm_amt` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_comm_type` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_admin_note` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_footer` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_print` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_none` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_aff_id` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_french ADD `invoice_aff_user` mediumtext NOT NULL");
mysql_query("update idevaff_language_french set invoice_button = 'Facture', invoice_header = 'FACTURE DE PAIEMENT DE FILIALE', invoice_aff_info = 'L\'information de filiale', invoice_co_info = 'L\'information', invoice_acct_info = 'L\'information de compte', invoice_payment_info = 'L\'information de paiement', invoice_comm_date = 'Date paiement', invoice_comm_amt = 'Montant de la commission', invoice_comm_type = 'Type de commission', invoice_admin_note = 'Remarques du gestionnaire', invoice_footer = 'FIN DE FACTURE', invoice_print = 'Facture d\'impression', invoice_none = 'N/A', invoice_aff_id = 'Filiale', invoice_aff_user = 'Nom d\'utilisateur'");
}

// -------------------------------------------
// --- Update German Language
// -------------------------------------------
$german_check = mysql_query("select id from idevaff_language_packs where table_name = 'german'");
if (!mysql_num_rows($german_check)) {
mysql_query("update idevaff_language_packs set table_name = 'german' where name = 'german'");
$german_check = mysql_query("select id from idevaff_language_packs where table_name = 'german'");
$german_check = mysql_fetch_array($german_check);
$german_check = $german_check['id'];
$german_check = "pack_" . $german_check;
mysql_query("ALTER TABLE idevaff_language_custom_values ADD `$german_check` longtext");
mysql_query("update idevaff_language_custom_values set $german_check = 'Marketing-Materialien'");
}
$german_check = mysql_query("SHOW COLUMNS from idevaff_language_german LIKE 'invoice_button'");
if (!mysql_num_rows($german_check)) {
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_button` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_header` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_aff_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_co_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_acct_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_payment_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_comm_date` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_comm_amt` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_comm_type` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_admin_note` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_footer` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_print` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_none` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_aff_id` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_german ADD `invoice_aff_user` mediumtext NOT NULL");
mysql_query("update idevaff_language_german set invoice_button = 'Rechnung', invoice_header = 'TEILNEHMER-ZAHLUNG RECHNUNG', invoice_aff_info = 'Teilnehmer-Informationen', invoice_co_info = 'Informationen', invoice_acct_info = 'Konto-Informationen', invoice_payment_info = 'Zahlung Informationen', invoice_comm_date = 'Auszahlungs-Datum', invoice_comm_amt = 'Kommissions-Summe', invoice_comm_type = 'Typ der Kommission', invoice_admin_note = 'Hinweise vom Administrator', invoice_footer = 'ENDE DER RECHNUNG', invoice_print = 'Druck-Rechnung', invoice_none = 'N/A', invoice_aff_id = 'Teilnehmer ID', invoice_aff_user = 'Benutzername'");
}

// -------------------------------------------
// --- Update Italian Language
// -------------------------------------------
$italian_check = mysql_query("select id from idevaff_language_packs where table_name = 'italian'");
if (!mysql_num_rows($italian_check)) {
mysql_query("update idevaff_language_packs set table_name = 'italian' where name = 'italian'");
$italian_check = mysql_query("select id from idevaff_language_packs where table_name = 'italian'");
$italian_check = mysql_fetch_array($italian_check);
$italian_check = $italian_check['id'];
$italian_check = "pack_" . $italian_check;
mysql_query("ALTER TABLE idevaff_language_custom_values ADD `$italian_check` longtext");
mysql_query("update idevaff_language_custom_values set $italian_check = 'Materiali di Marketing'");
}
$italian_check = mysql_query("SHOW COLUMNS from idevaff_language_italian LIKE 'invoice_button'");
if (!mysql_num_rows($italian_check)) {
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_button` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_header` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_aff_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_co_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_acct_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_payment_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_comm_date` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_comm_amt` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_comm_type` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_admin_note` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_footer` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_print` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_none` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_aff_id` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_italian ADD `invoice_aff_user` mediumtext NOT NULL");
mysql_query("update idevaff_language_italian set invoice_button = 'Fattura', invoice_header = 'FATTURA DI PAGAMENTO DELLA FILIALE', invoice_aff_info = 'Le informazioni della filiale', invoice_co_info = 'Le informazioni', invoice_acct_info = 'Le informazioni di cliente', invoice_payment_info = 'Le informazioni di pagamento', invoice_comm_date = 'Data del pagamento', invoice_comm_amt = 'Importo della commissione', invoice_comm_type = 'Tipo di commissione', invoice_admin_note = 'Note dall\'Amministratore', invoice_footer = 'ESTREMITÀ DELLA FATTURA', invoice_print = 'Fattura della stampa', invoice_none = 'N/A', invoice_aff_id = 'Filiale ID', invoice_aff_user = 'Nome utente'");
}

// -------------------------------------------
// --- Update Portuguese Language
// -------------------------------------------
$portuguese_check = mysql_query("select id from idevaff_language_packs where table_name = 'portuguese'");
if (!mysql_num_rows($portuguese_check)) {
mysql_query("update idevaff_language_packs set table_name = 'portuguese' where name = 'portuguese'");
$portuguese_check = mysql_query("select id from idevaff_language_packs where table_name = 'portuguese'");
$portuguese_check = mysql_fetch_array($portuguese_check);
$portuguese_check = $portuguese_check['id'];
$portuguese_check = "pack_" . $portuguese_check;
mysql_query("ALTER TABLE idevaff_language_custom_values ADD `$portuguese_check` longtext");
mysql_query("update idevaff_language_custom_values set $portuguese_check = 'Materiais de Marketing'");
}
$portuguese_check = mysql_query("SHOW COLUMNS from idevaff_language_portuguese LIKE 'invoice_button'");
if (!mysql_num_rows($portuguese_check)) {
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_button` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_header` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_aff_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_co_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_acct_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_payment_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_comm_date` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_comm_amt` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_comm_type` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_admin_note` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_footer` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_print` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_none` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_aff_id` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_portuguese ADD `invoice_aff_user` mediumtext NOT NULL");
mysql_query("update idevaff_language_portuguese set invoice_button = 'Invoice', invoice_header = 'INVOICE DO PAGAMENTO DA FILIAL', invoice_aff_info = 'Informação da filial', invoice_co_info = 'Informação', invoice_acct_info = 'Informação do cliente', invoice_payment_info = 'Informação do pagamento', invoice_comm_date = 'Data de Pagamento', invoice_comm_amt = 'Valor Total da Comissão', invoice_comm_type = 'Tipo de Comissão', invoice_admin_note = 'Notas Do Administrador', invoice_footer = 'EXTREMIDADE DO INVOICE', invoice_print = 'Invoice da cópia', invoice_none = 'N/A', invoice_aff_id = 'Filial ID', invoice_aff_user = 'Nome de usuário'");
}

// -------------------------------------------
// --- Update Spanish Language
// -------------------------------------------
$spanish_check = mysql_query("select id from idevaff_language_packs where table_name = 'spanish'");
if (!mysql_num_rows($spanish_check)) {
mysql_query("update idevaff_language_packs set table_name = 'spanish' where name = 'spanish'");
$spanish_check = mysql_query("select id from idevaff_language_packs where table_name = 'spanish'");
$spanish_check = mysql_fetch_array($spanish_check);
$spanish_check = $spanish_check['id'];
$spanish_check = "pack_" . $spanish_check;
mysql_query("ALTER TABLE idevaff_language_custom_values ADD `$spanish_check` longtext");
mysql_query("update idevaff_language_custom_values set $spanish_check = 'Matériel de marketing'");
}
$spanish_check = mysql_query("SHOW COLUMNS from idevaff_language_spanish LIKE 'invoice_button'");
if (!mysql_num_rows($spanish_check)) {
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_button` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_header` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_aff_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_co_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_acct_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_payment_info` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_comm_date` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_comm_amt` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_comm_type` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_admin_note` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_footer` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_print` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_none` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_aff_id` mediumtext NOT NULL");
mysql_query("ALTER TABLE idevaff_language_spanish ADD `invoice_aff_user` mediumtext NOT NULL");
mysql_query("update idevaff_language_spanish set invoice_button = 'Factura', invoice_header = 'FACTURA DEL PAGO DEL AFILIADO', invoice_aff_info = 'Información del afiliado', invoice_co_info = 'Información', invoice_acct_info = 'Información de la cuenta', invoice_payment_info = 'Información del pago', invoice_comm_date = 'Fecha de pago', invoice_comm_amt = 'Monto de la comisión', invoice_comm_type = 'Tipo de comisión', invoice_admin_note = 'Notas del administrador', invoice_footer = 'EXTREMO DE LA FACTURA', invoice_print = 'Factura de la impresión', invoice_none = 'N/A', invoice_aff_id = 'Afiliado ID', invoice_aff_user = 'Nombre de usuario'");
}

// -------------------------------------------
// --- Add Dutch Language
// -------------------------------------------
$dutch_check = mysql_query("select id from idevaff_language_packs where table_name = 'dutch'");
if (!mysql_num_rows($dutch_check)) {
mysql_query("insert into idevaff_language_packs (name, status, table_name, def) VALUES ('dutch', 1, 'dutch', 0)");
$dutch_check = mysql_query("select id from idevaff_language_packs where table_name = 'dutch'");
$dutch_check = mysql_fetch_array($dutch_check);
$dutch_check = $dutch_check['id'];
$dutch_check = "pack_" . $dutch_check;
mysql_query("ALTER TABLE idevaff_language_custom_values ADD `$dutch_check` longtext");
mysql_query("update idevaff_language_custom_values set $dutch_check = 'Marketing Materiaal'");

mysql_query("CREATE TABLE IF NOT EXISTS idevaff_language_dutch (
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
  contact_invalid_message mediumtext NOT NULL,
  invoice_button mediumtext NOT NULL,
  invoice_header mediumtext NOT NULL,
  invoice_aff_info mediumtext NOT NULL,
  invoice_co_info mediumtext NOT NULL,
  invoice_acct_info mediumtext NOT NULL,
  invoice_payment_info mediumtext NOT NULL,
  invoice_comm_date mediumtext NOT NULL,
  invoice_comm_amt mediumtext NOT NULL,
  invoice_comm_type mediumtext NOT NULL,
  invoice_admin_note mediumtext NOT NULL,
  invoice_footer mediumtext NOT NULL,
  invoice_print mediumtext NOT NULL,
  invoice_none mediumtext NOT NULL,
  invoice_aff_id mediumtext NOT NULL,
  invoice_aff_user mediumtext NOT NULL
) ENGINE=MyISAM");

$checkdata = mysql_query("select * from idevaff_language_dutch");
$checkdata = mysql_num_rows($checkdata); if (!$checkdata) {
mysql_query("insert into idevaff_language_dutch VALUES (
'Affiliate Programma', 'Home', 'Nu inschrijven', 'Beheer Account', 'Contact Ons', 'Welkom', 'Gast', 'Uitloggen', 'Affiliate Software By iDevAffiliate', 'Copyright 2007', 'Alle Rechten Voorbehouden', 'Welkom bij ons Webmaster Programma!', 'Ons programma is gratis om aan mee te doen, het is makkelijk om je in te schrijven en u heeft er totaal geen technische kennis voor nodig. Webmaster programma''s zijn een bekend verschijnsel op internet en bieden website eigenaars een goede manier om hun programma uit te breiden. Affiliates genereren meer verkeer voor de commerciele websites en hiervoor in ruil krijgen zij een vergoeding.', 'Hoe werkt het?', 'Wanneer u aan ons affiliate programma deelneemt, wordt u voorzien van een groot aantal banners en tekstlinks die U op uw website kunt plaatsen. Wanneer uw bezoeker op de link klikt en bij ons terecht komt, traceren wij de activiteit van deze bezoeker met onze affiliate software. U ontvangt een commissie die is gebaseerd op het door u gekozen commissie type.', 'Real-Time Statistieken en rapportage!', 'Log in 24 uur per dag om uw verkopen in te zien en om te controleren hoe goed uw banners en tekstlinks het doen.', 'Affiliate Login', 'Gebruikersnaam', 'Wachtwoord', 'gebruikersnaam', 'wachtwoord', 'Login', 'Klik hier om u aan te melden', 'Programma Details', 'Commissie Type', 'InitiÃ«le inleg', 'Uitbetaling vereisten', 'Betaal cyclus', 'Kies uit de volgende uitbetaling types.', 'Pay-Per-Sale', 'Pay-Per-Click', 'Voor iedere verkoop.', 'voor elke klik die u ons stuurt.', 'Alleen maar voor het inschrijven!', 'Minimum bedrag benodigd voor uitbetaling.', 'Betalingen worden eens per maand gedaan, over de voorgaande maand.', 'Neem nu deel aan ons affiliate programma en begin met geld verdienen voor iedere verkoop die u onze kant op stuurt. Maak simpelweg een account aan, plaats de link codes op uw website en zie hoe uw account balans stijgt!', 'Welkom Affiliate!', 'CreÃ«er Uw Account', 'Gebruikersnaam', 'Wachtwoord', 'Nogmaals uw wachtwoord', 'Moet minimaal 4 en niet meer dan 12 tekens in lengte zijn. Het mag alleen uit cijfers, letters en underscores bestaan.', 'Dit veld moet gelijk zijn aan het wachtwoord veld.', 'Standaard Informatie', 'Email Adres', 'Bedrijfsnaam', 'Checks uitbetalen aan', 'Website Adres', 'Sofi- of BTWnummer', 'Persoonlijke Informatie', 'Voornaam', 'Provincie', 'Achternaam', 'Telefoonnummer', 'Straatnaam', 'Faxnummer', 'Huisnummer', 'PostCode', 'Stad', 'Land', 'Commissie betaling', 'Hoe wilt u betaald worden?', 'Pay-Per-Sale', 'Pay-Per-Click', 'Optionele PayPal betaling', 'Betaal mij met PayPal', 'checkbox', 'PayPal Account', 'Het ontvangen van PayPal betalingen is bij ons een optie Indien u ervoor kiest om geen Paypal betalingen te ontvangen, dan maken wij het bedrag per bank over, of we sturen u een cheque.', 'Benodigde PayPal Informatie', 'PayPal Account', 'Het ontvangen van PayPal betalingen is bij ons verplicht U moet in het bezit zijn van een PayPal account om commissies te kunnen ontvangen.', 'Algemene voorwaarden', 'Ik heb bovenstaande voorwaarden gelezen en ga hiermee akkoord.', 'CreÃ«er mijn account', 'Wij hebben u een email gestuurd met uw Gebruikersnaam en Wachtwoord.\r\nBewaar deze goed voor het geval dat u die in de toekomst nodig heeft.', 'Login bij uw account', 'Extra informatie', 'U bent nu uitgelogdBedankt voor uw deelname aan ons programma!', 'Uw account is gecreÃ«erd', 'Account Login', 'Vul uw gebruikersnaam en wachtwoord in om toegang te krijgen tot uw Account Statistieken, banners, link codes, FAQ en meer.Indien u uw wachtwoord niet meer weet, vult u dan uw gebruikersnaam in en wij zenden uw login informatie naar u via email.', 'Login bij uw account', 'Gebruikersnaam', 'Wachtwoord', 'Ongeldige login', 'Login bij mijn Account', 'Heeft u uw wachtwoord nodig?', 'Vul uw gebruikersnaam in', 'Login gegevens zijn naar uw email adres gezonden', 'Naar email verzenden', 'Gebruikersnaam niet gevonden', 'Nieuw Wachtwoord', 'Uw wachtwoord moet uit minimaal 4 en maximaal 12 tekens bestaan. Het mag alleen uit cijfers, letters en underscores bestaan.', 
'Bevestig nieuw Wachtwoord', 'Dit Wachtwoord veld moet overeen komen met het Nieuw Wachtwoord veld.', 'Tracking Sleutelwoord', 'Uw sleutelwoord mag niet langer zijn dan 30 tekens. Het mag alleen uit cijfers, letters en koppeltekens bestaan.', 'Footer', 'Het onderwerp mag niet langer zijn dan 100 tekens. Het mag alleen uit cijfers, letters, punten, uitroeptekens, vraagtekens en commas bestaan.', 'Inhoud van het bericht', 'Het bericht mag niet langer zijn dan 250 tekens. Het mag alleen uit cijfers, letters, punten, uitroeptekens, vraagtekens en comma''s bestaan.', 'Onderwerp', 'Het onderwerp mag niet langer zijn dan 80 tekens. Het mag alleen uit cijfers, letters, punten, uitroeptekens, vraagtekens en commas bestaan.', 'De volgende foutmeldingen zijn er.', 'Ongeldige gebruikersnaam. Het mag alleen uit cijfers, letters en underscores bestaan.', 'De gebruikersnaam die u hebt gekozen is al in gebruik.', 'Uw gebruikersnaam is te kort, deze moet minimaal 4 tekens lang zijn.', 'Uw gebruikersnaam is te lang, maximaal aantal tekens is 12.', 'Ongeldig wachtwoord. Het mag alleen uit cijfers, letters en underscores bestaan.', 'Uw wachtwoord is te kort, deze moet minimaal 4 tekens lang zijn.', 'Uw wachtwoord is te lang, maximaal aantal tekens is 12.', 'Uw wachtwoorden komen niet overeen.', 'Vul a.u.b. een geadresseerde in als ontvanger van de cheques.', 'Vul a.u.b. uw sofi- of BTW-nummer in.', 'Vul a.u.b. uw voornaam in.', 'Vul a.u.b. uw achternaam in.', 'Vul a.u.b. uw emailadres in.', 'Uw email adres is ongeldig.', 'Vul a.u.b. uw straatnaam in.', 'Vul a.u.b. uw stad in.', 'Vul a.u.b. uw bedrijfsnaam in.', 'Vul a.u.b. uw provincie in.', 'Vul a.u.b. uw postcode in.', 'Vul a.u.b. telefoonnummer in.', 'Vul a.u.b. uw website adres in.', 'U heeft gekozen voor PayPal betalingen, Vul a.u.b. uw PayPal account in.', 'U heeft onze voorwaarden niet geaccepteerd.', 'Een PayPal account is noodzakelijk voor uitbetaling.', 'Vul a.u.b. het volgende veld juist in:', 'Totaal aantal Transactie''s', 'Standaard Link Code - Perfect in emails!', 'Kopieer en plak de bovenstaande code in uw website of emails', 'Uw account wacht op goedkeuring', 'Uw account is op non-actief gesteld', 'Standaard verdiensten', 'inclusief bonus', 'Tier verdiensten', 'Terugkerende verdiensten', 'N/A', 'Totaal verdiend tot vandaag', 'Account Overzicht', 'Algemene Statistieken', 'Tier Statistieken', 'Betalings historie', 'Commissie Details', 'Terugkerende Commissies', 'Inkomend verkeer overzicht', 'Marketing Materiaal', 'Banners', 'Tekst Ads', 'Tekst Links', 'Email Links', 'HTML Ads', 'Offline Marketing', 'Tier Link Code', 'Email vrienden en relaties', 'CreÃ«er en Traceer uw eigen links', 'Account Management', 'CommissionAlert Setup', 'CommissionStats Setup', 'Wijzig mijn Account', 'Verander mijn Wachtwoord', 'Verander mijn commissie type', 'Algemene Informatie', 'Browse andere Affiliates', 'Veel gestelde vragen', 'Account Status Notificatie', 'Uw Account is momenteel inactief', 'Bericht van de beheerder', 'Account Status Notificatie', 'Uw Account wacht op goedkeuring', 'Zodra wij uw account hebben goedgekeurd, worden onze marketing middelen beschikbaar gesteld.', 'Veel gestelde vragen', 'Nog geen veel gestelde vragen', 'Browse andere Affiliates', 'Geen andere affiliates om te bekijken', 'Verander soort commissie', 'Huidige soort commissie', 'Huidig minimum bedrag', 'Nieuw soort commissie', 'Indien u het soort commissie verandert, wordt uw account op Payout Level 1 gezet', 'Verander soort commissies', 'Geen ander soort commissie beschikbaar', 'Level', 'soort commissie bijgewerkt', 'Verander mijn wachtwoord', 'Oud Wachtwoord', 'Nieuw Wachtwoord', 'Bevestig nieuw Wachtwoord', 'Verander Wachtwoord', 'Oud Wachtwoord Is Incorrect of Ontbreekt', 'Nieuw wachtwoord niet ingevuld', 'Nieuw wachtwoord klopt niet', 'Wachtwoord Ongeldig - Klik op de Help link', 'Wachtwoord Bijgewerkt', 'Update Mislukt - Zie bovenstaande foutmeldingen', 'Account Bijgewerkt', 'Wijzig mijn Account', 'CommissionStats Setup', 'Indien u CommissionStats installeerd, kunt u uw stats direct zien, vanaf uw eigen desktop! Om deze functie te installeren, download u CommissionStats en unzip het pakket op uw computer. Hierna voert u het setup.exe bestand uit. Wanneer u gevraagd wordt om uw login gegevens, vult u dan de volgende gegevens in.', 'Hint: KopiÃ«er & Plak elk veld om zeer accuraat te werk te gaan', 'Profiel naam', 'Gebruikersnaam', 'Wachtwoord', 'Affiliate ID', 'Bron Pad URL', 'Download CommissionStats', 'CommissionAlert Setup', 'Met het gebruik van CommissionAlert stellen wij u direct op de hoogte van nieuwe commissies, gewoon op uw eigen Desktop! Om dit unieke programma te installeren, download u CommissionAlert en unzip het pakket op uw computer. Hierna voert u het setup.exe bestand uit. Wanneer u gevraagd wordt om uw login gegevens, vult u dan de volgende gegevens in.', 'Hint: Kopieer & Plak elk veld om zeer accuraat te werk te gaan', 'Profiel naam', 'Gebruikersnaam', 'Wachtwoord', 'Affiliate ID', 'Bron pad URL', 'Download CommissionAlert', 'Maak uw eigen Link', 'Wanneer u een Eigen Link maakt, kunt u verkeer sturen naar elke pagina die u kiest binnen de websites die wij hebben. U kan dan ook het succes meten door uw eigen sleutelwoord te gebruiken. U kunt hier een bestaande, of een nieuwe link die u zelf maakt, kiezen. Uw bezoekers worden naar de pagina gestuurd die u kiest!', 'Inkomende pagina', 'Kies een bestaande link hierboven en bezoekers worden direct naar die pagina gestuurd.', 'Definieer uw eigen link', 'Kies een willekeurige link op onze websites en bezoekers worden direct naar die pagina gestuurd.', 'browse onze website', 'Tracking Sleutelwoord', 'CreÃ«er nieuwe Link', 'Eigen Sleutelwoord Link', 'Sleutelwoord Link', 'Inkomende pagina', 'Unieke bezoekers', 'Verkopen', 'Conversie Ratio', 'Verwijder', 'Open In Nieuw Scherm', 'Verwijder', 'Deze link is nu inaktief gemaakt.', 'Optie is Inaktief', 'Deze optie is niet aktief voor Pay-Per-Click Accounts', 'Geen sleutelwoord ingevuld', 'Sleutelwoord bestaat al', 'Sleutelwoord ongeldig - Klik op de help link', 'Custom URL Locatie Ongeldig', 
'Sleutelwoord Link GecreÃ«erd', 'Sleutelwoord Link Verwijderd', 'Email Vrienden & Relaties', 'Email tot 3 vrienden of relaties in Ã©Ã©n keer.', 'U kunt berichten sturen eens in de', 'minuten', 'Naam', 'Email Adres', 'Ontvanger #1', 'Ontvanger #2', 'Ontvanger #3', 'Onderwerp', 'Inhoud v.h. Bericht ', 'Automatisch invoegen', 'Footer', 'tekens over', 'Email Notes', 'Bij het verzenden van dit bericht wordt uw emailadres gebruikt.', 'Dit bericht wordt verzonden met uw echte voor- en achternaam in het bericht.', 'Om spam-blokkering te voorkomen, wordt het bericht als PLAIN tekst verzonden.', 'Misbruik van dit systeem resulteert in het verwijderen van uw Account', 'Verzend email bericht', 'Footer Ongeldig - Klik de Help link', 'Bericht Ongeldig - Klik de Help link', 'Onderwerp Ongeldig - Klik de Help link', 'Ontvanger #1 - Ongeldige Email', 'Ontvanger #1 - Ongeldige Naam', 'Ontvanger #2 - Ongeldige Email', 'Ontvanger #2 - Ongeldige Naam', 'Ontvanger #3 - Ongeldige Email', 'Ontvanger #3 - Ongeldige Naam', 'Bericht verzonden aan', 'Ontvanger', 'Verzend een ander bericht in ', 'Seconden', 'Offline Marketing', 'Verdien geld met de promotie van onze websites bij uw vrienden en relaties.', 'Zend bezoekers naar', 'bekijk pagina', 'Uw klanten zullen uw Affiliate ID nummer in het blok hierboven invullen, waardoor u als de affiliate wordt geregistreerd bij iedere verkoop die zij doen.', 'Banners', 'Marketing Groep', 'Laat Banners zien', 'Geen Groep Geselecteerd', 'Kies a.u.b. een marketing groep hierboven', 'Marketing Groepen hebben afzonderlijke binnenkomende pagina''s', 'Banner Grootte', 'Banner Omschrijving', 'Bron Code - Kopieer en Plak in uw website', 'Tekst Ads', 'Marketing Groep', 'Laat Tekst Ads zien', 'Geen groep geselecteerd', 'Kies a.u.b. een marketing groep hierboven', 'Marketing Groepen kunnen afzonderlijke binnenkomende pagina''s hebben', 'Indien u de aangegeven link code gebruikt, kunt u de kleuren schema''s, hoogte en breedte van uw tekst advertentie makkelijk integreren met uw eigen website!', 'Bron Code - Kopieer/Plak in uw website', 'Tekst Links', 'Marketing Groep', 'Laat Tekst Links Zien', 'Geen Groep Geselecteerd', 'Kies a.u.b. een marketing groep hierboven', 'Marketing Groepen kunnen afzonderlijke binnenkomende pagina''s hebben', 'Bron Code - Kopieer/Plak in uw website', 'Email Links', 'Marketing Groep', 'Laat Email Links Zien', 'Geen Groep Geselecteerd', 'Kies a.u.b. een marketing groep hierboven', 'Marketing Groepen kunnen afzonderlijke binnenkomende pagina''s hebben', 'ASCII/Tekst Versie - Om te gebruiken in Plain Tekst emails.', 'HTML Versie - Om te gebruiken in HTML emails.', 'Test Link', 'Dit is waar uw bezoekers onze website binnenkomen', 'Bron Code - Kopieer/Plak in uw Email bericht', 'HTML Ads', 'Marketing Groep', 'Laat HTML Ads Zien', 'Geen Groep Geselecteerd', 'Kies a.u.b. een marketing groep hierboven', 'Marketing Groepen kunnen afzonderlijke binnenkomende pagina''s hebben', 'Bekijk deze HTML Advertentie', 'Bron Code - Kopieer/Plak in uw website', 'Binnekomend verkeer Log', 'Laat de laatste zien', 
'Bezoekers', 'Bekijk Verkeer Log', 'Binnenkomend Verkeer Details', 'IP Adres', 'Referring URL', 'Datum', 'Tijd', 'Laat de laatste zien', 'of', 'Totaal Aantal Unieke Bezoekers', 'Er is geen Traffic Log', 'N/A - Eventuele Bookmark of Email Link', 'Gehele Referring URL', 'Klik de link om de website te bezoeken', 'Betalings Historie', 'Betaal datum', 'Commissies', 'Betaalhoeveelheid', 'Totalen', 'Er is geen betalings historie', 'Tier Statistieken', 'Tier Accounts', 'Huidige Uitbetaling', 'Tier Verdiensten', 'Pak hier uw Tier Link Code', 'Er is geen Tier Account', 'Tier Affiliates', 'Gebruikersnaam', 'Huidige Commissies', 'Vorige Uitbetalingen', 'Totalen', 'Terugkerende Commissies', 'Er zijn geen terugkerende commissies ', 'Commissie Datum', 'Terugkerende Status', 'Volgende betaling', 'Hoeveelheid', 'Iedere', 'In', 'Dagen', 'Totaal', 'Voeg anderen aan uw Tier toe en verdien ook geld aan hen!', 'Tier Signups worden reeds toegekend in uw standaard affiliate links!', 'U wordt de bovenste lijn (tier) van iedere webmaster die zich inschrijft voro ons affiliate programma via uw link.', 'Huidige Tier Uitbetaling', 'Over iedere commissie die door een affiliate in uw lijn (Tier) is gegenereerd.', 'Over iedere commissie die door een affiliate in uw lijn (Tier) is gegenereerd.', 'Verdien', 'Over iedere commissie die door een affiliate in uw lijn (Tier) is gegenereerd.', 'Over iedere commissie die door een affiliate in uw lijn (Tier) is gegenereerd.', 'Gebruik de volgende code om ons programma bij andere webmasters te promoten.', 'Tekst Link Code', 'Kopieer/Plak het bovenstaande in uw website', 'Webmasters Verdienen Hier Geld!', 'Commissie Details', 'Commissie Datum', 'Commissie Tijd', 'Commissie Type', 'Huidige Status', 'Commissie Hoeveelheid', 'Additionele Commissie Details', 'Order Nummer', 'Verkoop hoeveelheid', 'Bonus Commissie', 'Terugkerende Commissie', 'Tier Commissie', 'Standaard Commissie', 'Betaald', 'Goedgekeurd - In afwachting van Betaling', 'In afwachting van goedkeuring', 'N/A', 'Commissie Details', 'Huidige standaard commissie', 'Huidige Tier Commissie', 'Commissies in afwachting van goedkeuring', 'Uitbetaalde Standaard Commissies', 'Uitbetaalde Tier Commissies', 'Bekijk Commissies', 'Datum', 'Status', 'Commissie', 'Bekijk Details', 'Betaald', 'In afwachting van goedkeuring', 'Goedgekeurd - in afwachting van uitbetaling', 'Geen Commissies Om Te Bekijken', 'Geen Commissie Groep Geselecteerd', 'Kies a.u.b. een Commissie Groep hierboven', 'Huidige Commissies - Vanaf de laatste uitbetaling tot vandaag', 'Transacties', 'Verdiensten tot vandaag', 'Bekijk uitbetalings historie', 'Standaard Verdiensten', 'Huidige verdiensten', 'Verkeer Statistieken', 'Bezoekers', 'Unieke Bezoekers', 'Totaal Verkopen', 'Verkoop Ratio', 'Totaal Verkopen en Verkoop RatioDeze statistieken omvatten niet de terugkerende of tier commissies.', 'Betalings Type', 'Huidig betalings type', 'Bericht(en) van de beheerder', 'CreÃ«er datum', 'Aan', 'Alle Affiliates', 'Geen berichten om te bekijken', 'Neem contact met ons op', 'Voelt u vrij om contact met onze affiliate manager op te nemen door middel van het formulier rechts.', 'Neem contact met ons op', 'Uw Naam', 'Uw Email Adres', 'Bericht', 'tekens over', 'Verzend bericht', 'Wij hebben uw bericht ontvangen, het kan tot 24 uur duren voordat u een reaktie ontvangt.', 'Ongeldige Naam', 'Ongeldig Email Adres', 'Ongeldig Bericht', 'Faktuur', 'FAKTUUR AFFILIATE BETALING', 'Affiliate Informatie', 'Informatie', 'Account Informatie', 'Betaling Informatie', 'Betalings Datum', 'Hoeveelheid Commissie', 'Commissie Type', 'Bericht Van De Beheerder', 'EINDE FAKTUUR', 'Print Faktuur', 'N/A', 'Affiliate ID', 'Gebruikersnaam'
)");
}
}
}




// --------------------------------------------------------------------------------------------------------------------------

$upgrade_version = '5.1';

mysql_query("update idevaff_config set version = '$upgrade_version'");


?>
