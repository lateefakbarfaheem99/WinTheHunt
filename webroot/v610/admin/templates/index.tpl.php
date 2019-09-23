<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$insufficient_priv_msg;?>
<!-- Draw main menu on Admin home page -->

<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td valign="top" width="50%">
      	<div class="mainhead"><img src="images/general.gif" align="absmiddle"><?=AMSG_SITE_SETUP;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="site_setup.php"><?=AMSG_SITE_NAME;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="site_setup.php"><?=AMSG_SITE_URL;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="site_setup.php"><?=AMSG_ADMIN_EMAIL;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="site_setup.php"><?=AMSG_CHOOSE_SITE_SKIN;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="site_setup.php"><?=AMSG_CHOOSE_SITE_LOGO;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="site_setup.php"><?=AMSG_CHOOSE_DEFAULT_LANG;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="site_setup.php"><?=AMSG_MAINTENANCE_MODE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="../initialize_counters.php" target="_blank"><?=AMSG_INITIALIZE_COUNTERS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="reset_installation.php"><?=AMSG_RESET_INSTALLATION;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/set.gif" align="absmiddle"><?=AMSG_GENERAL_SETTINGS;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=signup_settings"><?=AMSG_USER_SIGNUP_SETTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=closed_auctions_deletion"><?=AMSG_CLOSED_AUCT_DEL;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=hpfeat_items"><?=AMSG_HPFEAT_ITEMS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=catfeat_items"><?=AMSG_CATFEAT_ITEMS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=recently_listed_auctions"><?=AMSG_RECENT_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=popular_auctions"><?=AMSG_POPULAR_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=ending_soon_auctions"><?=AMSG_ENDING_SOON_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=auction_images"><?=AMSG_AUCTION_IMAGES_SETTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=currency_setts"><?=AMSG_CURRENCY_SETTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=time_date_setts"><?=AMSG_TIME_DATE_SETTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=ssl_support"><?=AMSG_SETUP_SSL_SUPPORT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=meta_tags"><?=AMSG_META_TAGS_SETTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=cron_jobs"><?=AMSG_CRON_JOBS_SETTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=min_reg_age"><?=AMSG_MIN_REG_AGE_SETTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=recent_wanted_ads"><?=AMSG_RECENT_WANTED_ADS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=auction_media"><?=AMSG_MEDIA_UPLOAD_SETTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=buy_out_method"><?=AMSG_SEL_BUY_OUT_METHOD;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=sellitem_buttons"><?=AMSG_SELLING_PROCESS_NAV_BTNS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=nb_autorelists"><?=AMSG_MAX_NB_AUTORELISTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=invoices_settings"><?=AMSG_INVOICES_SETTINGS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=digital_downloads"><?=AMSG_DIGITAL_DOWNLOADS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=force_payment"><?=AMSG_BUY_OUT_FORCE_PAYMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=ga_code"><?=AMSG_GA_CODE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=recent_reverse"><?=AMSG_RECENT_REVERSE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=fulltext_search_method"><?=AMSG_FULLTEXT_SEARCH_METHOD;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=browse_thumb_size"><?=AMSG_BROWSE_THUMB_SIZE;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/enable.gif" align="absmiddle"><?=AMSG_ENABLE_DISABLE;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=shipping_costs"><?=AMSG_SHIPPING_COSTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=hp_login_box"><?=AMSG_HP_LOGIN_BOX;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=hp_news_box"><?=AMSG_HP_NEWS_BOX;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=buy_out_method"><?=AMSG_BUY_OUT_METHOD;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=registration_terms"><?=AMSG_REGISTRATION_TERMS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=sellitem_terms"><?=AMSG_SELLITEM_TERMS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=swapping"><?=AMSG_SWAPPING;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=hp_counter"><?=AMSG_HP_COUNTER;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=addl_category_listing"><?=AMSG_ADDL_CATEGORY_LISTING;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=user_languages"><?=AMSG_USER_LANGUAGES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=auction_sniping"><?=AMSG_AUCTION_SNIPING;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=private_site"><?=AMSG_PRIVATE_SITE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=preferred_sellers"><?=AMSG_PREFERRED_SELLERS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=bcc_emails"><?=AMSG_BCC_EMAILS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=seller_questions"><?=AMSG_SELLER_QUESTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=wanted_ads"><?=AMSG_WANTED_ADS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=bid_retraction"><?=AMSG_BID_RETRACTION;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=seller_other_items"><?=AMSG_SELLER_OTHER_ITEMS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=bulk_lister"><?=AMSG_BULK_LISTER;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=category_counters"><?=AMSG_CATEGORY_COUNTERS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=phone_nb_sale"><?=AMSG_PHONE_NB_SALE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=mod_rewrite"><?=AMSG_MOD_REWRITE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=auction_approval"><?=AMSG_ENABLE_AUCT_APPROVAL;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=change_duration"><?=AMSG_CHG_DURATION_ON_BID_PLACED;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=seller_verification"><?=AMSG_ENABLE_SELLER_VERIFICATION;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=profile_page"><?=AMSG_ENABLE_PROFILE_PAGE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=store_only_mode"><?=AMSG_ENABLE_STORE_ONLY_MODE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=skin_change"><?=AMSG_ENABLE_SKIN_CHANGE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=second_chance"><?=AMSG_ENABLE_SECOND_CHANCE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=remove_marked_deleted"><?=AMSG_REMOVE_MARKED_DELETED_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=enable_addthis"><?=AMSG_ENABLE_SITE_SHARING;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=enable_private_reputation"><?=AMSG_ENABLE_PRIVATE_REPUTATION_COMMENTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=enable_refunds"><?=AMSG_ENABLE_REFUNDS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=end_auction_early"><?=AMSG_END_AUCT_EARLY;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=fb_auctions"><?=AMSG_ENABLE_FIRST_BIDDER_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=swdefeat"><?=AMSG_ENABLE_SIDEWIKI_BLOCKER;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=custom_end_time"><?=AMSG_ENABLE_CUSTOM_END_TIME;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=buyer_create_invoice"><?=AMSG_ENABLE_BUYER_CREATE_INVOICE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=display_free_fees"><?=AMSG_DISPLAY_FREE_FEES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=proxy_bidding"><?=AMSG_ENABLE_PROXY_BIDDING;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=free_category_change"><?=AMSG_ENABLE_FREE_CATEGORY_CHANGE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=limit_nb_bids"><?=AMSG_LIMIT_NB_BIDS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=bidder_verification"><?=AMSG_ENABLE_BIDDER_VERIFICATION;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/fees.gif" align="absmiddle"><?=AMSG_FEES;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="fees_settings.php"><?=AMSG_MAIN_SETTINGS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="fees_payment_gateways.php"><?=AMSG_SETUP_PAYMENT_GATEWAYS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="fees_management.php"><?=AMSG_FEES_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_currencies.php"><?=AMSG_CURRENCY_SETTINGS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="refund_requests.php"><?=AMSG_REFUND_REQUESTS;?></a>
                  <!--
            		<br><img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=mcrypt"><?=AMSG_MCRYPT_SETTINGS;?></a>
		            -->
               </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/fields.gif" align="absmiddle"><?=AMSG_CUSTOM_FIELDS_SETUP;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields_types.php"><?=AMSG_SETUP_FIELD_TYPES;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table></td>
      <td><img src="images/pixel.gif" height="1" width="20"></td>
      <td width="50%" valign="top">
      	<div class="mainhead"><img src="images/user.gif" align="absmiddle"><?=AMSG_USERS_MANAGEMENT;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_admin_users.php"><?=AMSG_ADMIN_USERS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_site_users.php"><?=AMSG_USERS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=register"><?=AMSG_CUSTOM_REG_FIELDS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="user_login.php"><?=AMSG_LOGIN_AS_SITE_USER;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_users_reputations.php"><?=AMSG_USERS_REP_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=reputation_sale"><?=AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_SALE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=reputation_purchase"><?=AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_PURCHASE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="send_activation_emails.php"><?=AMSG_REG_ACTIVATION_EMAILS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="user_newsletter.php"><?=AMSG_SEND_NEWSLETTER;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="abuse_reports.php"><?=AMSG_ABUSE_REPORTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="ban_users.php"><?=AMSG_BAN_USERS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="blocked_users.php"><?=AMSG_BLOCKED_USERS;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/auction.gif" align="absmiddle"><?=AMSG_AUCTIONS_MANAGEMENT;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_auctions.php?status=open"><?=AMSG_OPEN_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_auctions.php?status=closed"><?=AMSG_CLOSED_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_auctions.php?status=unstarted"><?=AMSG_UNSTARTED_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_auctions.php?status=suspended"><?=AMSG_SUSPENDED_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_sold_items.php"><?=AMSG_SOLD_ITEMS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_auctions.php?status=approval"><?=AMSG_AUCTIONS_AWAITING_APPROVAL;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=auction"><?=AMSG_CUSTOM_AUCT_FIELDS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_wanted_ads.php"><?=AMSG_WANTED_ADS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=wanted_ad"><?=AMSG_CUSTOM_WANTED_ADS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_messaging.php"><?=AMSG_USER_MESSAGES_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="images_removal_tool.php"><?=AMSG_OLD_IMAGES_REMOVAL_TOOL;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="shipping_carriers.php"><?=AMSG_SHIPPING_CARRIERS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_retracted_bids.php"><?=AMSG_VIEW_RETRACTED_BIDS;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/auction.gif" align="absmiddle"><?=AMSG_REVERSE_AUCTIONS_MANAGEMENT;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=reverse_auctions"><?=AMSG_ENABLE_REVERSE_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=r_hpfeat_items"><?=AMSG_HPFEAT_RA;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=r_catfeat_items"><?=AMSG_CATFEAT_RA;?></a> <br>
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_categories.php?table=reverse"><?=AMSG_EDIT_CATEGORIES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="categories_lang.php?table=reverse"><?=AMSG_EDIT_CAT_LANG_FILES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_reverse_budgets.php"><?=AMSG_EDIT_BUDGETS_TABLE;?></a> <br>
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_reverse.php?status=open"><?=AMSG_OPEN_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_reverse.php?status=closed"><?=AMSG_CLOSED_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_reverse.php?status=unstarted"><?=AMSG_UNSTARTED_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_reverse.php?status=suspended"><?=AMSG_SUSPENDED_AUCTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="list_awarded_reverse.php"><?=AMSG_AWARDED_PROJECTS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=reverse"><?=AMSG_CUSTOM_REVERSE_AUCT_FIELDS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=provider_profile"><?=AMSG_CUSTOM_PROVIDER_PROFILE_FIELDS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=reputation_poster"><?=AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_POSTER;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="custom_fields.php?page=reputation_provider"><?=AMSG_CUSTOM_REP_FIELDS_MANAGEMENT_PROVIDER;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/tables.gif" align="absmiddle"><?=AMSG_TABLES_MANAGEMENT;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_countries.php"><?=AMSG_EDIT_COUNTRIES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_item_durations.php"><?=AMSG_EDIT_ITEM_DURATIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_payment_options.php"><?=AMSG_EDIT_PAYMENT_OPTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_shipping_options.php"><?=AMSG_EDIT_SHIPPING_OPTIONS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_bid_increments.php"><?=AMSG_EDIT_BID_INCREMENTS;?></a> <br>
						<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_postage_tiers.php?tier_type=weight"><?=AMSG_EDIT_POSTAGE_TIERS_WEIGHT;?></a> <br>
						<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_postage_tiers.php?tier_type=amount"><?=AMSG_EDIT_POSTAGE_TIERS_AMOUNT;?></a></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/stores.gif" align="absmiddle"><?=AMSG_STORES_MANAGEMENT;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=enable_stores"><?=AMSG_ENABLE_STORES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="stores_subscriptions.php"><?=AMSG_STORE_SUBSCRIPTIONS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="stores_management.php"><?=AMSG_STORES_MANAGEMENT;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/cat.gif" align="absmiddle"><?=AMSG_CATEGORIES;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_categories.php"><?=AMSG_EDIT_CATEGORIES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="categories_lang.php"><?=AMSG_EDIT_CAT_LANG_FILES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="table_suggested_categories.php"><?=AMSG_VIEW_SUGGESTED_CATEGORIES;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/content.gif" align="absmiddle"><?=AMSG_SITE_CONTENT;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="vouchers_management.php"><?=AMSG_VOUCHERS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_section.php?page=help"><?=AMSG_EDIT_HELP_SECTION;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_section.php?page=news"><?=AMSG_EDIT_NEWS_SECTION;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_section.php?page=faq"><?=AMSG_EDIT_FAQ_SECTION;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_pages.php?page=about_us"><?=AMSG_EDIT_ABOUT_US_PAGE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_pages.php?page=contact_us"><?=AMSG_EDIT_CONTACT_US_PAGE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_pages.php?page=terms"><?=AMSG_EDIT_TERMS_PAGE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_pages.php?page=privacy"><?=AMSG_EDIT_PRIVACY_PAGE;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_section.php?page=custom_page"><?=AMSG_CUSTOM_PAGES_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_system_emails.php"><?=AMSG_EDIT_SYSTEM_EMAILS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_banners_management.php"><?=AMSG_SITE_BANNERS_MANAGEMENT;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_language_files.php"><?=AMSG_EDIT_SITE_LANGUAGE_FILES;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="content_section.php?page=announcements"><?=AMSG_EDIT_MEMBERS_ANNOUNCEMENTS;?></a> <br>
						<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="enable_disable.php?page=site_fees_page"><?=AMSG_ENABLE_SITE_FEES_PAGE;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/tax.gif" align="absmiddle"><?=AMSG_TAX_SETTINGS;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=enable_tax"><?=AMSG_ENABLE_TAX;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="tax_settings.php"><?=AMSG_TAX_CONFIGURATION;?></a> <br>
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="general_settings.php?page=convert_tax"><?=AMSG_TAX_CONVERSION;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table>
         <br>
         <div class="mainhead"><img src="images/tools.gif" align="absmiddle"><?=AMSG_TOOLS;?></div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
               <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="2" cellspacing="2" class="fside">
            <tr>
               <td width="100%" class="menulink">
               	<img src="images/a.gif" align="absmiddle" vspace="2"> <a href="word_filter.php"><?=AMSG_WORD_FILTER;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="block_free_emails.php"><?=AMSG_BLOCK_FREE_EMAILS;?></a> <br>
                  <img src="images/a.gif" align="absmiddle" vspace="2"> <a href="http://www.xe.com/ucc/" target="_blank"><?=AMSG_CURRENCY_CONVERTER;?></a> </td>
            </tr>
         </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
               <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
               <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
            </tr>
         </table></td>
   </tr>
</table>
