<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>
<?=$page_title;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CODEPAGE;?>">
<?=$page_meta_tags;?>
<link href="themes/<?=$setts['default_theme'];?>/style.css" rel="stylesheet" type="text/css">
<script src="themes/<?=$setts['default_theme'];?>/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="themes/<?=$setts['default_theme'];?>/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="themes/<?=$setts['default_theme'];?>/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="themes/<?=$setts['default_theme'];?>/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.bg {
 background-image: url(themes/<?=$setts['default_theme'];?>/img/subbg.gif);
}
.TabbedPanelsTab {
 BACKGROUND: url(themes/<?=$setts['default_theme'];?>/img/tabg2.gif) no-repeat right top;
}
.TabbedPanelsTab a {
 BACKGROUND: url(themes/<?=$setts['default_theme'];?>/img/tabg1.gif) no-repeat left top;
}
.TabbedPanelsTabSelected {
 BACKGROUND: url(themes/<?=$setts['default_theme'];?>/img/tabbrown2.gif) no-repeat right top;
}
.TabbedPanelsTabSelected a {
 BACKGROUND: url(themes/<?=$setts['default_theme'];?>/img/tabbrown1.gif) no-repeat left top;
}
.placebid {
	font-size: 18px;
	font-weight: bold;
	height: 38px;
}
.lb {
	border-right: 1px solid #111212;
	border-left: 1px solid #606468;
	font-size: 11px;
	font-weight: bold;
	background-image: url(themes/<?=$setts['default_theme'];?>/img/subbg.gif);
}
.lb a {
	color: #ffffff;
	text-decoration: none;
}
.lb a:hover {
	color: #ffffff;
	text-decoration: none;
}
.db {
	font-size: 11px;
	font-weight: bold;
	border-right: 1px solid #111212;
	border-left: 1px solid #606468;
	background-image: url(themes/<?=$setts['default_theme'];?>/img/db_bg.gif);
}
.db a {
	color: #ffffff;
	text-decoration: none;
}
.db a:hover {
	color: #ffffff;
	text-decoration: none;
}
.today {
background: #ffffff url(themes/<?=$setts['default_theme'];?>/img/listedtoday.gif) top right no-repeat;
}
.day {
background: #ffffff url(themes/<?=$setts['default_theme'];?>/img/day.gif) bottom left no-repeat;
}
.hour {
background: #ffffff url(themes/<?=$setts['default_theme'];?>/img/hour.gif) bottom left no-repeat;
}
.hl_item1 {
	border: 2px solid #ffa500;
}
-->
</style>

</head>
<body bgcolor="#f5f6f7">
<table width="980" border="0" align="center" cellpadding="10" cellspacing="0">
<tr>
   <td>
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr valign="bottom">
         <td style="padding-bottom: 10px;"><a href="<?=$index_link;?>"><img src="images/probidlogo.gif" alt="Professional Auction Script Software by PHP Pro Bid" border="0"></a></td>
         <td width="100%" valign="bottom" style="padding-left: 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr height="60">
                  <td nowrap style="border-left: 1px solid #cccccc; padding-left: 15px; padding-top: 8px;" class="mainmenu" width="100%"><div style="padding-bottom: 3px;">
                        <?=$current_date;?>
                        <span id="servertime"></span></div>
                     <? if ($member_active == 'Active') { ?>
                     <?=MSG_WELCOME_BACK;?>, <b><?=$member_username; ?></b><br>
                     <a href="<?=$login_link;?>"><?=$login_btn_msg;?></a>
                     <? } else { ?>
                     <?=MSG_WELCOME;?>! &nbsp;
                     <a href="<?=$login_link;?>"><?=$login_btn_msg;?></a> or 
                     <a href="<?=$register_link;?>"><?=$register_btn_msg;?></a>
                     <? } ?>
                     &nbsp;&nbsp;&nbsp;
                     <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="200" height="1"></div></td>
						<td nowrap style="padding-right: 10px;" class="smallfont">[ <a href="search.php"><?=MSG_ADVANCED_SEARCH;?></a> ]</td>
						<? if ($setts['enable_addthis']) { ?>
						<td nowrap style="padding-right: 10px;"><?=$share_code;?></td>
						<? } ?>
                  <? if ($setts['user_lang']) { ?>
                  <td nowrap align="center">&nbsp;&nbsp;<?=$languages_list;?>&nbsp;&nbsp;</td>
                  <? } ?>
                  <td><div align="center"><a href="rss_feed.php"><img src="themes/<?=$setts['default_theme'];?>/img/system/rss.gif" border="0" align="absmiddle" hspace="10"></a></div>
                     <? if ($setts['enable_skin_change']) { ?>
                     <br>
                     <form action="index.php" method="GET">
                        <div align="center">
                           <?=MSG_CHOOSE_SKIN;?>:<br>
                           <?=$site_skins_dropdown;?>
                           <input type="submit" name="change_skin" value="<?=GMSG_GO;?>">
                        </div>
                     </form>
                     <? } ?></td>
               </tr>
            </table>
            <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="10"></div></td>
      </tr>
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" background="themes/<?=$setts['default_theme'];?>/img/subbg.gif">
      <tr align="center">
         <td width="6" style="border-right: 1px solid #111212;"><a href="<?=$index_link;?>"><img src="themes/<?=$setts['default_theme'];?>/img/home_i.gif" width="49" height="49" border="0"></a></td>
         <td nowrap width="<?=$header_cell_width;?>" <? if (stristr($_SERVER['PHP_SELF'], "categories.php")) { ?>class="db" <? } else { ?> class="lb" ONMOUSEOVER="this.className='db';" ONMOUSEOUT="this.className='lb';"<? } ?>>
         	<ul id="MenuBarCategories" class="MenuBarHorizontal">
               <li style="background-color: transparent;">
               	<a style="background-color: transparent; color: #ffffff; border: 0px;" class="MenuBarItemSubmenu" href="categories.php"><?=strtoupper(MSG_CATEGORIES);?></a>
                  
               	<ul><?=$category_box_content;?></ul>
               </li>
            </ul></td>
         <? if (!$setts['enable_private_site'] || $is_seller) { ?>
         <? if (stristr($_SERVER['PHP_SELF'], "sell_item.php")) { ?>
         <td nowrap class="db" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=$place_ad_link;?>"><?=$place_ad_btn_msg;?></a>&nbsp;</td>
         <? } else { ?>
         <td nowrap class="lb" ONMOUSEOVER="this.className='db';" ONMOUSEOUT="this.className='lb';" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=$place_ad_link;?>"><?=$place_ad_btn_msg;?></a>&nbsp;</td>
         <? } ?>
			<? } ?>
         <!-- Members Area Menu -->
         <td nowrap <? if (stristr($_SERVER['PHP_SELF'], "members_area.php")||stristr($_SERVER['PHP_SELF'], "login.php")) { ?> class="db" <? } else { ?> class="lb" ONMOUSEOVER="this.className='db';" ONMOUSEOUT="this.className='lb';" <? } ?> width="<?=$header_cell_width;?>">
	         <ul id="MenuBar1" class="MenuBarHorizontal">
	            <li style="background-color: transparent;"><a style="background-color: transparent; color: #ffffff; border: 0px;" href="members_area.php">
	               <?=MSG_BTN_MEMBERS_AREA;?>
	               </a>
	               <ul>
	                  <? if ($member_active == 'Active') { ?>
	                  <li><a class="MenuBarItem" href="<?=process_link('members_area', array('page' => 'summary'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_summary.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_SUMMARY;?>
	                     </a></li>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'received'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_message.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_MESSAGING;?>
	                     </a>
	                     <ul>
	                        <li><a href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'received'));?>">
	                           <?=MSG_MM_RECEIVED;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'sent'));?>">
	                           <?=MSG_MM_SENT;?>
	                           </a></li>
	                     </ul>
	                  </li>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'current_bids'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_bidding.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_BIDDING;?>
	                     </a>
	                     <ul >
	                        <li><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'current_bids'));?>">
	                           <?=MSG_MM_CURRENT_BIDS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'bids_offers'));?>">
	                           <?=MSG_MM_ITEMS_WITH_OFFERS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'));?>">
	                           <?=MSG_MM_WON_ITEMS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'invoices_received'));?>">
	                           <?=MSG_MM_INVOICES_RECEIVED;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'item_watch'));?>">
	                           <?=MSG_MM_WATCHED_ITEMS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'favorite_stores'));?>">
	                           <?=MSG_MM_FAVORITE_STORES;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'keywords_watch'));?>">
	                           <?=MSG_MM_KEYWORDS_WATCH;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'saved_searches'));?>">
	                           <?=MSG_MM_SAVED_SEARCHES;?>
	                           </a></li>
	                     </ul>
	                  </li>
	                  <? if ($is_seller) { ?>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'open'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_selling.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_SELLING;?>
	                     </a>
	                     <ul>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'open'));?>">
	                           <?=MSG_MM_OPEN_AUCTIONS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'bids_offers'));?>">
	                           <?=MSG_MM_ITEMS_WITH_BIDS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'scheduled'));?>">
	                           <?=MSG_MM_SCHEDULED_AUCTIONS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'closed'));?>">
	                           <?=MSG_MM_CLOSED_AUCTIONS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'drafts'));?>">
	                           <?=MSG_MM_DRAFTS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'sold'));?>">
	                           <?=MSG_MM_SOLD_ITEMS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'invoices_sent'));?>">
	                           <?=MSG_MM_INVOICES_SENT;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'fees_calculator'));?>">
	                           <?=MSG_MM_FEES_CALCULATOR;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'prefilled_fields'));?>">
	                           <?=MSG_MM_PREFILLED_FIELDS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'block_users'));?>">
	                           <?=MSG_MM_BLOCK_USERS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'suggest_category'));?>">
	                           <?=MSG_MM_SUGGEST_CATEGORY;?>
	                           </a></li>
						      	<? if ($setts['enable_shipping_costs']) { ?>
						      	<li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'postage_setup'));?>">
						      		<?=MSG_MM_POSTAGE_CALC_SETUP;?>
						      		</a></li>
						      	<? } ?>
						      	<li><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'vouchers'));?>">
						      		<?=MSG_MM_SELLER_VOUCHERS;?>
						      		</a></li>
	                     </ul>
	                  </li>
	                  <? } ?>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'received'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_reputation.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_REPUTATION;?>
	                     </a>
	                     <ul>
	                        <li><a href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'received'));?>">
	                           <?=MSG_MM_MY_REPUTATION;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'sent'));?>">
	                           <?=MSG_MM_LEAVE_COMMENTS;?>
	                           </a></li>
	                     </ul>
	                  </li>
	                  <? if ($is_seller && $setts['enable_bulk_lister']) { ?>
	                  <li><a class="MenuBarItem" href="<?=process_link('members_area', array('page' => 'bulk', 'section' => 'details'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_bulk.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_BULK;?>
	                     </a></li>
	                  <? } ?>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'view'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_aboutme.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_ABOUT_ME;?>
	                     </a>
	                     <ul>
	                        <li><a href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'view'));?>">
	                           <?=MSG_MM_VIEW;?>
	                           </a></li>
	                        <? if ($setts['enable_profile_page']) { ?>
	                        <li><a href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'profile'));?>">
	                           <?=MSG_PROFILE_PAGE;?>
	                           </a></li>
	                        <? } ?>
	                     </ul>
	                  </li>
	                  <? if ($setts['enable_stores'] && $is_seller) { ?>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'store', 'section' => 'subscription'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_mystore.gif" align='absmiddle' id="icomenu" border="0">
	                     <?=MSG_MM_STORE;?>
	                     </a>
	                     <ul>
	                        <li><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'subscription'));?>">
	                           <?=MSG_STORE_SETTINGS;?>
	                           </a></li>
	                        <!--
	                        <li><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'setup'));?>">
	                           <?=MSG_MM_MAIN_SETTINGS;?>
	                           </a></li>
	                        -->
	                        <li><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'store_pages'));?>">
	                           <?=MSG_MM_STORE_PAGES;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'categories'));?>">
	                           <?=MSG_MM_CUSTOM_CATS;?>
	                           </a></li>
	                     </ul>
	                  </li>
	                  <? } ?>
	                  <? if ($setts['enable_wanted_ads']) { ?>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'new'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_wanted.gif" align='absmiddle' id="icomenu" border="0">
	                     <?=MSG_MM_WANTED_ADS;?>
	                     </a>
	                     <ul>
	                        <li><a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'new'));?>">
	                           <?=MSG_MM_ADD_NEW;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'open'));?>">
	                           <?=MSG_MM_OPEN;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'closed'));?>">
	                           <?=MSG_MM_CLOSED;?>
	                           </a></li>
	                     </ul>
	                  </li>
	                  <? } ?>
							<? if ($setts['enable_reverse_auctions']) { ?>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'open'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_selling.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_REVERSE_AUCTIONS;?>
	                     </a>
	                     <ul>
						      	<li><?=MSG_MM_GET_SERVICES;?></li>
						      	<li><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'new_auction'));?>"><?=MSG_MM_CREATE_REVERSE_AUCTION;?></a></li>
					      		<li><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'open'));?>"><?=MSG_MM_OPEN;?></a></li>
					      		<li><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'closed'));?>"><?=MSG_MM_CLOSED;?></a></li>
					      		<li><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'scheduled'));?>"><?=MSG_MM_SCHEDULED;?></a></li>
					      		<li><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'awarded'));?>"><?=MSG_MM_AWARDED;?></a></li>
						      	<li><?=MSG_MM_PROVIDE_SERVICES;?></li>
					      		<li><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'my_profile'));?>"><?=MSG_MM_PROFILE;?></a></li>
					      		<li><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'my_bids'));?>"><?=MSG_MM_MY_BIDS;?></a></li>
					      		<li><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'won'));?>"><?=MSG_MM_MY_PROJECTS;?></a></li>      	
						      </ul>
						   </li>
							<? } ?>
	                  <li><a class="MenuBarItemSubmenu" href="<?=process_link('members_area', array('page' => 'account', 'section' => 'editinfo'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_myaccount.gif" border="0" align='absmiddle' id="icomenu">
	                     <?=MSG_MM_MY_ACCOUNT;?>
	                     </a>
	                     <ul>
	                        <li><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'editinfo'));?>">
	                           <?=MSG_MM_PERSONAL_INFO;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'management'));?>">
	                           <?=MSG_MM_MANAGE_ACCOUNT;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'history'));?>">
	                           <?=MSG_MM_ACCOUNT_HISTORY;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'mailprefs'));?>">
	                           <?=MSG_MM_MAIL_PREFS;?>
	                           </a></li>
	                        <li><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'abuse_report'));?>">
	                           <?=MSG_MM_ABUSE_REPORT;?>
	                           </a></li>
	                     </ul>
	                  </li>
	                  <? } ?>
	                  <? if ($member_active == 'Active') { ?>
	                  <li><a href="<?=$login_link;?>" class="MenuBarItem"><img src="themes/<?=$setts['default_theme'];?>/img/ico_logout.gif" align='absmiddle' id="icomenu" border="0">
	                     <?=$login_btn_msg;?>
	                     </a></li>
	                  <?} else { ?>
	                  <li><a href="<?=$login_link;?>" class="MenuBarItem"><img src="themes/<?=$setts['default_theme'];?>/img/ico_login.gif" align='absmiddle' id="icomenu" border="0">
	                     <?=$login_btn_msg;?>
	                     </a></li>
	                  <li><a href="<?=$register_link;?>" class="MenuBarItem"><img src="themes/<?=$setts['default_theme'];?>/img/ico_register.gif" align='absmiddle' id="icomenu" border="0">
	                     <?=$register_btn_msg;?>
	                     </a></li>
	                  <? } ?>
	               </ul>
	            </li>
	         </ul>
			</td>
      
	      <!-- EOF MEMBERS AREA MENU -->
	      <? if ($setts['enable_stores']) { ?>
	      <? if (stristr($_SERVER['PHP_SELF'], "stores.php")) { ?>
	      <td nowrap class="db" width="<?=$header_cell_width;?>">
	      	&nbsp;<a href="<?=process_link('stores');?>"><?=MSG_BTN_STORES;?></a>&nbsp;</td>
			<? } else { ?>
			<td nowrap class="lb" ONMOUSEOVER="this.className='db';" ONMOUSEOUT="this.className='lb';" width="<?=$header_cell_width;?>">
				&nbsp;<a href="<?=process_link('stores');?>"><?=MSG_BTN_STORES;?></a>&nbsp;</td>
			<? } ?>
			<? } ?>
			<? if ($setts['enable_reverse_auctions']) { ?> 
			<? if (stristr($_SERVER['PHP_SELF'], "reverse_auctions.php")) { ?>
			<td nowrap class="db" width="<?=$header_cell_width;?>">
				&nbsp;<a href="<?=process_link('reverse_auctions');?>"><?=MSG_REVERSE;?></a>&nbsp;</td>
			<? } else { ?>
			<td nowrap class="lb" ONMOUSEOVER="this.className='db';" ONMOUSEOUT="this.className='lb';"  width="<?=$header_cell_width;?>">
				&nbsp;<a href="<?=process_link('reverse_auctions');?>"><?=MSG_REVERSE;?></a>&nbsp;</td>
			<? } ?>
			<? } ?>
			<? if ($setts['enable_wanted_ads']) { ?> 
			<? if (stristr($_SERVER['PHP_SELF'], "wanted_ads.php")) { ?>
			<td nowrap class="db" width="<?=$header_cell_width;?>">
				&nbsp;<a href="<?=process_link('wanted_ads');?>"><?=MSG_BTN_WANTED_ADS;?></a>&nbsp;</td>
			<? } else { ?>
			<td nowrap class="lb" ONMOUSEOVER="this.className='db';" ONMOUSEOUT="this.className='lb';"  width="<?=$header_cell_width;?>">
				&nbsp;<a href="<?=process_link('wanted_ads');?>"><?=MSG_BTN_WANTED_ADS;?></a>&nbsp;</td>
			<? } ?>
			<? } ?>
         <td nowrap <? if ($_REQUEST['page']=='help') { ?>class="db" <? } else { ?> class="lb" ONMOUSEOVER="this.className='db';" ONMOUSEOUT="this.className='lb';" <? } ?> width="<?=$header_cell_width;?>">
         	<ul id="MenuBarHelp" class="MenuBarHorizontal">
               <li style="background-color: transparent;"> <a style="background-color: transparent; color: #ffffff; border: 0px;" href="<?=process_link('content_pages', array('page' => 'help'));?>">
                  <?=MSG_BTN_HELP;?>
                  </a>
                  <ul>
                     <li><a class="MenuBarItem" href="<?=process_link('content_pages', array('page' => 'help'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_faq.gif" align='absmiddle' id="icomenu" border="0">
                        <?=MSG_BTN_HELP;?>
                        </a></li>
                     <li><a class="MenuBarItem" href="<?=process_link('content_pages', array('page' => 'faq'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_faq.gif" align='absmiddle' id="icomenu" border="0">
                        <?=MSG_BTN_FAQ;?>
                        </a></li>
                     <? if ($layout['is_about']) { ?>
                     <li><a class="MenuBarItem" href="<?=process_link('content_pages', array('page' => 'about_us'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_about.gif" align='absmiddle' id="icomenu" border="0">
                        <?=MSG_BTN_ABOUT_US;?>
                        </a></li>
                     <? } ?>
                     <? if ($layout['is_contact']) { ?>
                     <li><a class="MenuBarItem" href="<?=process_link('content_pages', array('page' => 'contact_us'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_contact.gif" align='absmiddle' id="icomenu" border="0">
                        <?=MSG_BTN_CONTACT_US;?>
                        </a></li>
                     <? } ?>
                     <? if ($layout['enable_site_fees_page']) { ?>
                     <li><a class="MenuBarItem" href="<?=process_link('site_fees');?>"><img src="themes/<?=$setts['default_theme'];?>/img/ico_fees.gif" align='absmiddle' id="icomenu" border="0">
                        <?=MSG_BTN_SITE_FEES;?>
                        </a></li>
                     <? } ?>
                  </ul>
               </li>
            </ul></td>
         <form action="auction_search.php" method="post">
            <input type="hidden" name="option" value="basic_search">
            <td class="lb" nowrap width="100%" align="right" style="border-right: 0px;"><input type="text" size="20" name="basic_search" style="background-image: url(themes/<?=$setts['default_theme'];?>/img/searchbg.gif); height: 20px; border: 0px;padding-left: 10px; padding-top: 2px;"></td>
            <td nowrap  style="padding-right: 10px;"><input name="form_basic_search" type="image" src="themes/<?=$setts['default_theme'];?>/img/search.gif" border="0"></td>
         </form>
         <td width="6"><img src="themes/<?=$setts['default_theme'];?>/img/sub2.gif" width="5" height="49"></td>
      </tr>
   </table>
   <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="10"></div>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
   <tr>
      <td width="10"><img src="themes/<?=$setts['default_theme'];?>/img/c1.gif" width="10" height="10"></td>
      <td width="100%" style="border-top: 1px solid #bbbbbb;"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="10"><img src="themes/<?=$setts['default_theme'];?>/img/c2.gif" width="10" height="10"></td>
   </tr>
   <tr>
      <td width="10" style="border-left: 1px solid #bbbbbb;"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr valign="top">
            <td width="100%">
					<?=$banner_position[5];?>
