<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<div id="exp1102170142">
<table border="0" cellpadding="3" cellspacing="3" width="100%" class="c1 border contentfont">
   <tr>
      <td class="c2" height="35" align="center">
      	<?=MSG_WELCOME_BACK;?>,<br><b><?=$member_username; ?></b>
      </td>
	</tr>
	<? if ($member_active == 'Active') { ?>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'summary'));?>"><?=MSG_MM_SUMMARY;?></a>
      </td>
	</tr>
   <tr>
      <td class="c3"><b><?=MSG_MM_MESSAGING;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'received'));?>"><?=MSG_MM_RECEIVED;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'messaging', 'section' => 'sent'));?>"><?=MSG_MM_SENT;?></a>
      </td>
	</tr>
   <tr>
      <td class="c3"><b><?=MSG_MM_BIDDING;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'current_bids'));?>"><?=MSG_MM_CURRENT_BIDS;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'bids_offers'));?>"><?=MSG_MM_ITEMS_WITH_OFFERS;?></a> <br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'));?>"><?=MSG_MM_WON_ITEMS;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'invoices_received'));?>"><?=MSG_MM_INVOICES_RECEIVED;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'item_watch'));?>"><?=MSG_MM_WATCHED_ITEMS;?></a><br />
			<? if ($setts['enable_stores']) { ?>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'favorite_stores'));?>"><?=MSG_MM_FAVORITE_STORES;?></a><br>
      	<? } ?>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'keywords_watch'));?>"><?=MSG_MM_KEYWORDS_WATCH;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bidding', 'section' => 'saved_searches'));?>"><?=MSG_MM_SAVED_SEARCHES;?></a>
      </td>
	</tr>
	<? if ($is_seller) { ?>
   <tr>
      <td class="c3"><b><?=MSG_MM_SELLING;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'open'));?>"><?=MSG_MM_OPEN_AUCTIONS;?></a> <br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'bids_offers'));?>"><?=MSG_MM_ITEMS_WITH_BIDS;?></a> <br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'scheduled'));?>"><?=MSG_MM_SCHEDULED_AUCTIONS;?></a> <br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'closed'));?>"><?=MSG_MM_CLOSED_AUCTIONS;?></a> <br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'drafts'));?>"><?=MSG_MM_DRAFTS;?></a> <br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'sold'));?>"><?=MSG_MM_SOLD_ITEMS;?></a><br />
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'invoices_sent'));?>"><?=MSG_MM_INVOICES_SENT;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'fees_calculator'));?>"><?=MSG_MM_FEES_CALCULATOR;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'prefilled_fields'));?>"><?=MSG_MM_PREFILLED_FIELDS;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'block_users'));?>"><?=MSG_MM_BLOCK_USERS;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'suggest_category'));?>"><?=MSG_MM_SUGGEST_CATEGORY;?></a>
      	<? if ($setts['enable_shipping_costs']) { ?>
      	<br>&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'postage_setup'));?>"><?=MSG_MM_POSTAGE_CALC_SETUP;?></a>
      	<? } ?>
      	<br>&raquo; <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'vouchers'));?>"><?=MSG_MM_SELLER_VOUCHERS;?></a>
      </td>
	</tr>
	<? } ?>
   <tr>
      <td class="c3"><b><?=MSG_MM_REPUTATION;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'received'));?>"><?=MSG_MM_MY_REPUTATION;?></a><br />
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'reputation', 'section' => 'sent'));?>"><?=MSG_MM_LEAVE_COMMENTS;?></a>
      </td>
	</tr>
   <? if ($is_seller && $setts['enable_bulk_lister']) { ?>
   <tr>
      <td class="c3"><b><?=MSG_MM_BULK;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'bulk', 'section' => 'details'));?>"><?=MSG_MM_DETAILS;?></a>
      </td>
	</tr>
	<? } ?>
   <tr>
      <td class="c3"><b><?=MSG_MM_ABOUT_ME;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'view'));?>"><?=MSG_MM_VIEW;?></a>
      	<? if ($setts['enable_profile_page']) { ?>
      	<br>&raquo; <a href="<?=process_link('members_area', array('page' => 'about_me', 'section' => 'profile'));?>"><?=MSG_PROFILE_PAGE;?></a>
      	<? } ?>
      </td>
	</tr>
	<? if ($setts['enable_stores'] && $is_seller) { ?>
   <tr>
      <td class="c3"><b><?=MSG_MM_STORE;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'subscription'));?>"><?=MSG_STORE_SETTINGS;?></a><br>
      	<!--&raquo; <a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'setup'));?>"><?=MSG_MM_MAIN_SETTINGS;?></a><br>-->
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'store_pages'));?>"><?=MSG_MM_STORE_PAGES;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'categories'));?>"><?=MSG_MM_CUSTOM_CATS;?></a>
      </td>
	</tr>
	<? } ?>
	<? if ($setts['enable_wanted_ads']) { ?>
   <tr>
      <td class="c3"><b><?=MSG_MM_WANTED_ADS;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'new'));?>"><?=MSG_MM_ADD_NEW;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'open'));?>"><?=MSG_MM_OPEN;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'wanted_ads', 'section' => 'closed'));?>"><?=MSG_MM_CLOSED;?></a>
      </td>
	</tr>
	<? } ?>
	<? if ($setts['enable_reverse_auctions']) { ?>
   <tr>
      <td class="c3"><b><?=MSG_MM_REVERSE_AUCTIONS;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <?=MSG_MM_GET_SERVICES;?><br>
      	&nbsp; &middot; <a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'new_auction'));?>"><?=MSG_MM_CREATE_REVERSE_AUCTION;?></a><br>
      	&nbsp; &middot; <a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'open'));?>"><?=MSG_MM_OPEN;?></a><br>
      	&nbsp; &middot; <a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'closed'));?>"><?=MSG_MM_CLOSED;?></a><br>
      	&nbsp; &middot; <a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'scheduled'));?>"><?=MSG_MM_SCHEDULED;?></a><br>
      	&nbsp; &middot; <a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'awarded'));?>"><?=MSG_MM_AWARDED;?></a><br>
      	&raquo; <?=MSG_MM_PROVIDE_SERVICES;?><br>
      	&nbsp; &middot; <a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'my_profile'));?>"><?=MSG_MM_PROFILE;?></a><br>
      	&nbsp; &middot; <a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'my_bids'));?>"><?=MSG_MM_MY_BIDS;?></a><br>
      	&nbsp; &middot; <a href="<?=process_link('members_area', array('page' => 'reverse', 'section' => 'won'));?>"><?=MSG_MM_MY_PROJECTS;?></a>      	
      </td>
	</tr>
	<? } ?>
	<? } ?>
   <tr>
      <td class="c3"><b><?=MSG_MM_MY_ACCOUNT;?></b></td>
   </tr>
   <tr>
      <td class="c2">
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'editinfo'));?>"><?=MSG_MM_PERSONAL_INFO;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'management'));?>"><?=MSG_MM_MANAGE_ACCOUNT;?></a><br>
      	<!--&raquo; <a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'invoices'));?>"><?=MSG_MM_INVOICES;?></a><br>-->
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'history'));?>"><?=MSG_MM_ACCOUNT_HISTORY;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'mailprefs'));?>"><?=MSG_MM_MAIL_PREFS;?></a><br>
      	&raquo; <a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'abuse_report'));?>"><?=MSG_MM_ABUSE_REPORT;?></a>
      	<? if ($setts['enable_refunds']) { ?>
      	<br>&raquo; <a href="<?=process_link('members_area', array('page' => 'account', 'section' => 'refund_requests'));?>"><?=MSG_MM_REFUND_REQUESTS;?></a>
      	<? } ?>
      </td>
	</tr>
</table>
</div>
<!--<script language="javascript">toggle(getObject('exp1102170142_link'), 'exp1102170142');</script>-->