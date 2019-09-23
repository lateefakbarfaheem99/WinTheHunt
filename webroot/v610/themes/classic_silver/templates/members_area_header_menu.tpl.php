<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
   <tr align="center">
		<? if ($member_active == 'Active') { ?>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'received'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_messaging.gif" border="0"></a></td>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'current_bids'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_bidding.gif" border="0"></a></td>
      <? if ($is_seller) { ?>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'open'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_selling.gif" border="0"></a></td>
      <? } ?>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'received'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_feedback.gif" border="0"></a></td>
      <? if ($is_seller && $setts['enable_bulk_lister']) { ?>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'bulk', 'section' => 'details'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_bulk.gif" border="0"></a></td>
      <? } ?>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'view'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_aboutme.gif" border="0"></a></td>
      <? if ($setts['enable_stores'] && $is_seller) { ?>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'subscription'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_store.gif" border="0"></a></td>
      <? } ?>
      <? if ($setts['enable_wanted_ads']) { ?>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'open'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_wanted.gif" border="0"></a></td>
      <? } ?>
      <? if ($setts['enable_reverse_auctions']) { ?>
      <td class="membmenuicon" width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'open'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_reverse.gif" border="0"></a></td>
      <? } ?>
      <? } ?>
      <td class="membmenuicon" ><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'editinfo'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/system/ma_details.gif" border="0"></a></td>
   </tr>
   <tr align="center" height="21">
		<? if ($member_active == 'Active') { ?>
      <td <?=(($page == 'messaging') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'received'));?>"><?=MSG_MM_MESSAGING;?></a></td>
      <td <?=(($page == 'bidding') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'current_bids'));?>"><?=MSG_MM_BIDDING;?></a></td>
      <? if ($is_seller) { ?>
      <td <?=(($page == 'selling') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'open'));?>"><?=MSG_MM_SELLING;?></a></td>
      <? } ?>
      <td <?=(($page == 'reputation') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'received'));?>"><?=MSG_MM_REPUTATION;?></a></td>
      <? if ($is_seller && $setts['enable_bulk_lister']) { ?>
      <td <?=(($page == 'bulk') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'bulk', 'section' => 'details'));?>"><?=MSG_MM_BULK_SHORT;?></a></td>
      <? } ?>
      <td <?=(($page == 'about_me') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'view'));?>"><?=MSG_MM_ABOUT_ME;?></a></td>
      <? if ($setts['enable_stores'] && $is_seller) { ?>
      <td <?=(($page == 'store') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'subscription'));?>"><?=MSG_MM_STORE;?></a></td>
      <? } ?>
      <? if ($setts['enable_wanted_ads']) { ?>
      <td <?=(($page == 'wanted_ads') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'open'));?>"><?=MSG_MM_WANTED_ADS;?></a></td>
      <? } ?>
      <? if ($setts['enable_reverse_auctions']) { ?>
      <td <?=(($page == 'reverse') ? 'class="memmenu_a"' : 'class="memmenu_u"');?> width="<?=$cell_width;?>"><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'open'));?>"><?=MSG_MM_REVERSE_AUCTIONS;?></a></td>
      <? } ?>
      <? } ?>
      <td <?=(($page == 'account') ? 'class="memmenu_a"' : 'class="memmenu_u"');?>><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'editinfo'));?>"><?=MSG_MM_MY_ACCOUNT;?></a></td>
   </tr>
</table>

<table border="0" cellpadding="3" cellspacing="0" width="100%" class="submembmenu">
   <tr>
   	<? if ($page == 'messaging') { ?>
   	<td nowrap <?=(($section == 'received') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'received'));?>">
         <?=MSG_MM_RECEIVED;?></a></td>
   	<td nowrap <?=(($section == 'sent') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'sent'));?>">
         <?=MSG_MM_SENT;?></a></td>
		<? } else if ($page == 'bidding') { ?>
   	<td nowrap <?=(($section == 'current_bids') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'current_bids'));?>">
         <?=MSG_MM_CURRENT_BIDS;?></a></td>
   	<td nowrap <?=(($section == 'bids_offers') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'bids_offers'));?>">
         <?=MSG_MM_ITEMS_WITH_OFFERS;?></a></td>
   	<td nowrap <?=(($section == 'won_items') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'));?>">
         <?=MSG_MM_WON_ITEMS;?></a></td>
   	<td nowrap <?=(($section == 'invoices_received') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'invoices_received'));?>">
         <?=MSG_MM_INVOICES_RECEIVED;?></a></td>
   	<td nowrap <?=(($section == 'item_watch') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'item_watch'));?>">
         <?=MSG_MM_WATCHED_ITEMS;?></a></td>
		<? if ($setts['enable_stores']) { ?>
   	<td nowrap <?=(($section == 'favorite_stores') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'favorite_stores'));?>">
         <?=MSG_MM_FAVORITE_STORES;?></a></td>
      <? } ?>
   	<td nowrap <?=(($section == 'keywords_watch') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'keywords_watch'));?>">
         <?=MSG_MM_KEYWORDS_WATCH;?></a></td>
   	<td nowrap <?=(($section == 'saved_searches') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'saved_searches'));?>">
         <?=MSG_MM_SAVED_SEARCHES;?></a></td>

		<? } else if ($page == 'selling') { ?>
   	<td nowrap <?=(($section == 'open') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'open'));?>">
         <?=MSG_MM_OPEN;?></a></td>
   	<td nowrap <?=(($section == 'bids_offers') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'bids_offers'));?>">
         <?=MSG_MM_ITEMS_WITH_BIDS;?></a></td>
   	<td nowrap <?=(($section == 'scheduled') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'scheduled'));?>">
         <?=MSG_MM_SCHEDULED;?></a></td>
   	<td nowrap <?=(($section == 'closed') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'closed'));?>">
         <?=MSG_MM_CLOSED;?></a></td>
   	<td nowrap <?=(($section == 'drafts') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'drafts'));?>">
         <?=MSG_MM_DRAFTS;?></a></td>
   	<td nowrap <?=(($section == 'sold') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'sold'));?>">
         <?=MSG_MM_SOLD;?></a></td>
   	<td nowrap <?=(($section == 'invoices_sent') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'invoices_sent'));?>">
         <?=MSG_MM_INVOICES_SENT;?></a></td>
   	<td width="100%"></td>	
	</tr>
</table>
<table border="0" cellpadding="3" cellspacing="0" width="100%">
	<tr>
   	<td nowrap <?=(($section == 'fees_calculator') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'fees_calculator'));?>">
         <?=MSG_MM_FEES_CALCULATOR;?></a></td>
   	<td nowrap <?=(($section == 'prefilled_fields') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'prefilled_fields'));?>">
         <?=MSG_MM_PREFILLED_FIELDS;?></a></td>
   	<td nowrap <?=(($section == 'block_users') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'block_users'));?>">
         <?=MSG_MM_BLOCK_USERS;?></a></td>
   	<td nowrap <?=(($section == 'suggest_category') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'suggest_category'));?>">
         <?=MSG_MM_SUGGEST_CATEGORY;?></a></td>
		<? if ($setts['enable_shipping_costs']) { ?>
   	<td nowrap <?=(($section == 'postage_setup') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'postage_setup'));?>">
         <?=MSG_MM_POSTAGE_CALC_SETUP;?></a></td>
		<? } ?>
   	<td nowrap <?=(($section == 'vouchers') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'vouchers'));?>">
         <?=MSG_MM_SELLER_VOUCHERS;?></a></td>

		<? } else if ($page == 'reputation') { ?>
   	<td nowrap <?=(($section == 'received') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'received'));?>">
         <?=MSG_MM_MY_REPUTATION;?></a></td>
   	<td nowrap <?=(($section == 'sent') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'sent'));?>">
         <?=MSG_MM_LEAVE_COMMENTS;?></a></td>

		<? } else if ($page == 'bulk') { ?>
   	<td nowrap <?=(($section == 'details') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'bulk', 'section' => 'details'));?>">
         <?=MSG_MM_DETAILS;?></a></td>

		<? } else if ($page == 'about_me') { ?>
   	<td nowrap <?=(($section == 'view') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'view'));?>">
         <?=MSG_MM_VIEW;?></a></td>
      <? if ($setts['enable_profile_page']) { ?>
   	<td nowrap <?=(($section == 'profile') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'profile'));?>">
         <?=MSG_PROFILE_PAGE;?></a></td>
      <? } ?>

		<? } else if ($page == 'store') { ?>
   	<td nowrap <?=(($section == 'subscription') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'subscription'));?>">
         <?=MSG_STORE_SETTINGS;?></a></td>
         <!--
   	<td nowrap <?=(($section == 'setup') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'setup'));?>">
         <?=MSG_MM_MAIN_SETTINGS;?></a></td>
         -->
   	<td nowrap <?=(($section == 'store_pages') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'store_pages'));?>">
         <?=MSG_MM_STORE_PAGES;?></a></td>
   	<td nowrap <?=(($section == 'categories') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'categories'));?>">
         <?=MSG_MM_CUSTOM_CATS;?></a></td>

		<? } else if ($page == 'wanted_ads') { ?>
   	<td nowrap <?=(($section == 'new') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'new'));?>">
         <?=MSG_MM_ADD_NEW;?></a></td>
   	<td nowrap <?=(($section == 'open') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'open'));?>">
         <?=MSG_MM_OPEN;?></a></td>
   	<td nowrap <?=(($section == 'closed') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'closed'));?>">
         <?=MSG_MM_CLOSED;?></a></td>

		<? } else if ($page == 'reverse') { ?>
   	<td nowrap <?=((in_array($section, $reverse_sect_get)) ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'open'));?>">
         <?=MSG_MM_GET_SERVICES;?></a></td>
   	<td nowrap <?=((in_array($section, $reverse_sect_provide)) ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'my_bids'));?>">
         <?=MSG_MM_PROVIDE_SERVICES;?></a></td>
         
		<? } else if ($page == 'account') { ?>
   	<td nowrap <?=(($section == 'editinfo') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'editinfo'));?>">
         <?=MSG_MM_PERSONAL_INFO;?></a></td>
   	<td nowrap <?=(($section == 'management') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'management'));?>">
         <?=MSG_MM_MANAGE_ACCOUNT;?></a></td>
   	<td nowrap <?=(($section == 'history') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'history'));?>">
         <?=MSG_MM_ACCOUNT_HISTORY;?></a></td>
   	<td nowrap <?=(($section == 'mailprefs') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'mailprefs'));?>">
         <?=MSG_MM_MAIL_PREFS;?></a></td>
   	<td nowrap <?=(($section == 'abuse_report') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'abuse_report'));?>">
         <?=MSG_MM_ABUSE_REPORT;?></a></td>
		<? if ($setts['enable_refunds']) { ?>
   	<td nowrap <?=(($section == 'refund_requests') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'refund_requests'));?>">
         <?=MSG_MM_REFUND_REQUESTS;?></a></td>		        
		<? } ?>
		<? } ?>
   	<td width="100%"></td>
   </tr>
</table>

<? if ($page == 'reverse') { ?>
<table border="0" cellpadding="3" cellspacing="0" class="submembmenu">
   <tr>
   	<? if (in_array($section, $reverse_sect_get)) { ?>
   	<td nowrap <?=(($section == 'create') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'new_auction'));?>">
         <?=MSG_MM_CREATE_REVERSE_AUCTION;?></a></td>
   	<td nowrap <?=(($section == 'open') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'open'));?>">
         <?=MSG_MM_OPEN;?></a></td>
   	<td nowrap <?=(($section == 'closed') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'closed'));?>">
         <?=MSG_MM_CLOSED;?></a></td>
   	<td nowrap <?=(($section == 'scheduled') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'scheduled'));?>">
         <?=MSG_MM_SCHEDULED;?></a></td>
   	<td nowrap <?=(($section == 'awarded') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'awarded'));?>">
         <?=MSG_MM_AWARDED;?></a></td>
         
		<? } else if (in_array($section, $reverse_sect_provide)) { ?>
   	<td nowrap <?=(($section == 'my_profile') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'my_profile'));?>">
         <?=MSG_MM_PROFILE;?></a></td>
   	<td nowrap <?=(($section == 'my_bids') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'my_bids'));?>">
         <?=MSG_MM_MY_BIDS;?></a></td>
   	<td nowrap <?=(($section == 'won') ? 'class="subcell_a"' : 'class="subcell_u"');?>><a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'won'));?>">
         <?=MSG_MM_MY_PROJECTS;?></a></td>
      <? } ?>

	</tr>
</table>
<? } ?>

<? if ($pref_seller_reduction) { ?>
<img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" border="0" width="1" height="5">
<table border="0" cellpadding="6" cellspacing="0" width="100%">
   <tr>
      <td class="c1" align="center"><? echo '[ <strong>' . MSG_PREFERRED_SELLER . ' - ' . $setts['pref_sellers_reduction'] . '% ' . MSG_REDUCTION_EXPL . '</strong> ]';?> </td>
   </tr>
</table>
<? } ?>
<? if ($credit_limit_warning) { ?>
<img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" border="0" width="1" height="5">
<table border="0" cellpadding="6" cellspacing="0" width="100%">
   <tr>
      <td class="c2"><?=MSG_CREDIT_LIMIT_WARNING;?></td>
   </tr>
</table>
<? } ?>