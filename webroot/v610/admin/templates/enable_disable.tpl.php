<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript" src="../includes/main_functions.js" type="text/javascript"></script>

<div class="mainhead"><img src="images/enable.gif" align="absmiddle">
   <?=$header_section;?>
</div>
<?=$msg_changes_saved;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr class="c3">
      <td colspan="2"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
         <?=strtoupper($subpage_title);?>
         </b></td>
   </tr>
   <form name="form_enable_disable" method="post" action="enable_disable.php" <? echo ($page=='auction_approval') ? 'onSubmit="SelectOption(this.categories_id)"' : '';?>>
      <input type="hidden" name="page" value="<?=$page;?>">
      <input type="hidden" name="table_name" value="<?=$table_name;?>">
      <input type="hidden" name="field_name" value="<?=$field_name;?>">
      <tr class="c1">
         <td width="150" align="right"><?=$subpage_title;?></td>
         <td><input name="field_value" type="checkbox" id="field_value" value="1" <? echo ($setts_tmp[$field_name] || $layout_tmp[$field_name]) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_CLICK_TO_ENABLE_FEATURE;?></td>
      </tr>
      <? if ($page == 'hp_news_box') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_NB_NEWS_DISPLAYED;?></td>
         <td><input name="d_news_nb" type="text" id="d_news_nb" value="<?=$layout_tmp['d_news_nb'];?>" size="8"></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_NB_NEWS_DISPLAYED_EXPL;?></td>
      </tr>
      <? } else if ($page == 'buy_out_method') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_ALWAYS_SHOW_BUYOUT;?></td>
         <td><input name="always_show_buyout" type="checkbox" id="field_value" value="1" <? echo ($setts_tmp['always_show_buyout']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_ALWAYS_SHOW_BUYOUT_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SHOW_MAKEOFFER_RANGE;?></td>
         <td><input name="makeoffer_private" type="checkbox" id="makeoffer_private" value="1" <? echo ($setts_tmp['makeoffer_private']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_SHOW_MAKEOFFER_RANGE_EXPL;?></td>
      </tr>
      <? } else if ($page == 'registration_terms') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_REG_TERMS_CONTENT;?></td>
         <td><textarea name="reg_terms_content" style="width: 100%; height: 150px;"><?=str_ireplace('<br>', "\n", $layout_tmp['reg_terms_content']); ?></textarea></td>
      </tr>
      <? } else if ($page == 'sellitem_terms') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SELLITEM_TERMS_CONTENT;?></td>
         <td><textarea name="auct_terms_content" style="width: 100%; height: 150px;"><?=str_ireplace('<br>', "\n", $layout_tmp['auct_terms_content']); ?></textarea></td>
      </tr>
      <? } else if ($page == 'auction_sniping') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SNIPING_DURATION;?></td>
         <td><input name="sniping_duration" type="text" id="sniping_duration" value="<?=$setts_tmp['sniping_duration'];?>" size="8">
            <?=GMSG_MINUTES;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_SNIPING_DURATION_EXPL;?></td>
      </tr>
      <? } else if ($page == 'auction_approval') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_AUCT_APPROVAL_NOTE;?></td>
      </tr>
      <? if (!$setts['enable_auctions_approval']) { ?>
      <tr class="c1">
         <td align="right"><?=AMSG_USERS;?></td>
         <td>[ <a href="list_site_users.php">
            <?=GMSG_SELECT;?>
            </a> ]</td>
      </tr>
      <tr class="c2">
         <td align="right"><?=AMSG_CATEGORIES;?></td>
         <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
               <tr>
                  <td width="45%">[
                     <?=AMSG_ALL_CATEGORIES;?>
                     ] </td>
                  <td width="10%">&nbsp;</td>
                  <td width="45%">[
                     <?=AMSG_SELECTED_CATEGORIES;?>
                     ] </td>
               </tr>
               <tr>
                  <td><?=$all_categories_table;?></td>
                  <td align="center"><input type="button" name="Disable" value=" -&gt; " style="width: 50px;" onclick="MoveOption(this.form.all_categories, this.form.categories_id)" />
                     <br />
                     <br />
                     <input type="button" name="Enable" value=" &lt;- " style="width: 50px;" onclick="MoveOption(this.form.categories_id, this.form.all_categories)" /></td>
                  <td><?=$selected_categories_table;?></td>
               </tr>
            </table></td>
      </tr>
      <? } ?>
      <? } else if ($page == 'preferred_sellers') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_PREF_SELLER_EXP_DATE;?></td>
         <td><input name="preferred_days" type="text" id="preferred_days" value="<?=$setts_tmp['preferred_days'];?>" size="8">
            <?=GMSG_DAYS;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_PREF_SELLER_EXP_DATE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_REDUCTION;?></td>
         <td><input name="pref_sellers_reduction" type="text" id="pref_sellers_reduction" value="<?=$setts_tmp['pref_sellers_reduction'];?>" size="8">%</td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_REDUCTION_DESC;?></td>
      </tr>
      <? } else if ($page == 'change_duration') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_NEW_DURATION;?></td>
         <td><input name="duration_change_days" type="text" id="duration_change_days" value="<?=$setts_tmp['duration_change_days'];?>" size="8">
            <?=GMSG_DAYS;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_NEW_DURATION_DESC;?></td>
      </tr>
      <? } else if ($page == 'seller_verification') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SELLER_VERIF_MANDATORY;?></td>
         <td><input name="seller_verification_mandatory" type="checkbox" id="seller_verification_mandatory" value="1" <? echo ($setts_tmp['seller_verification_mandatory']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_SELLER_VERIF_MANDATORY_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_VERIFICATION_FEE;?></td>
         <td><?=$setts['currency'];?>
            <input name="verification_fee" type="text" id="verification_fee" value="<?=$fees_tmp['verification_fee'];?>" size="8">,
            <?=AMSG_RECURRING_EVERY;?>
            <input name="verification_recurring" type="text" id="verification_recurring" value="<?=$fees_tmp['verification_recurring'];?>" size="8">
            <?=GMSG_DAYS;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_VERIFICATION_FEE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SELLER_VERIF_REFUND;?></td>
         <td><input name="seller_verification_refund" type="checkbox" id="seller_verification_refund" value="1" <? echo ($setts_tmp['seller_verification_refund']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_SELLER_VERIF_REFUND_EXPL;?></td>
      </tr>
      <? } else if ($page == 'seller_other_items') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_SELLER_OTHER_ITEMS_EXPL;?></td>
      </tr>
      <? } else if ($page == 'store_only_mode') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_ENABLE_STORE_ONLY_MODE_EXPL;?></td>
      </tr>
      <? } else if ($page == 'second_chance') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SELECT_INTERVAL;?></td>
         <td><input name="second_chance_days" type="text" id="second_chance_days" value="<?=$setts_tmp['second_chance_days'];?>" size="8">
            <?=GMSG_DAYS;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_SECOND_CHANCE_EXPL;?></td>
      </tr>
      <? } else if ($page == 'remove_marked_deleted') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_REMOVE_MDA_1;?> <?=$nb_marked_deleted_items;?> <?=AMSG_REMOVE_MDA_2;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_REMOVE_MARKED_DELETED_AUCTIONS_EXPL;?></td>
      </tr>
      <? } else if ($page == 'private_site') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_PRIVATE_SITE_EXPL;?></td>
      </tr>      
      <? } else if ($page == 'enable_refunds') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SELECT_INTERVAL;?></td>
         <td><input name="refund_min_days" type="text" id="refund_min_days" value="<?=$setts_tmp['refund_min_days'];?>" size="8">
            - <input name="refund_max_days" type="text" id="refund_max_days" value="<?=$setts_tmp['refund_max_days'];?>" size="8">
            <?=GMSG_DAYS;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_REFUND_DAYS_INTERVAL_EXPL;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_REFUNDS_IMPORTANT_NOTE . ' <b>' . show_date($setts['refund_start_date']) . '</b>.';?> </td>
      </tr>
      <? } else if ($page == 'end_auction_early') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_END_AUCT_EARLY_EXPL;?></td>
      </tr>
      <? } else if ($page == 'fb_auctions') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_FIRST_BIDDER_AUCTIONS_EXPL;?></td>
      </tr>
      <? } else if ($page == 'reverse_auctions') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_MAX_PORTFOLIO_FILES;?></td>
         <td><input name="max_portfolio_files" type="text" id="max_portfolio_files" value="<?=$setts_tmp['max_portfolio_files'];?>" size="8"></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_MAX_PORTFOLIO_FILES_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_MAX_ADDL_FILES;?></td>
         <td><input name="max_additional_files" type="text" id="max_additional_files" value="<?=$setts_tmp['max_additional_files'];?>" size="8"></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_MAX_ADDL_FILES_EXPL;?></td>
      </tr>
      <? } else if ($page == 'swdefeat') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_ENABLE_SIDEWIKI_BLOCKER_EXPL;?></td>
      </tr>
      <? } else if ($page == 'bulk_lister') { ?>
      <tr class="c1">
         <td align="right" nowrap><?=AMSG_CSV_DELIMITER;?></td>
         <td><input type="radio" name="csv_delimiter" value="comma" checked /> <?=GMSG_COMMA;?> (,)</td>
      </tr>
      <tr>
         <td align="right" nowrap></td>
         <td class="c1"><input type="radio" name="csv_delimiter" value="semicolon" <? echo ($setts_tmp['csv_delimiter']=='semicolon') ? 'checked' : ''; ?> /> <?=GMSG_SEMICOLON;?> (;)</td>
      </tr>
      <tr>
         <td align="right" class="explain"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_CSV_DELIMITER_EXPL;?></td>
      </tr>
      
      <tr class="c1">
         <td width="150" align="right"></td>
         <td><a href="../bulk_generate_sample.php" target="_blank"><?=AMSG_GENERATE_SAMPLE_FILE;?></a></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_GENERATE_SAMPLE_FILE_EXPL;?></td>
      </tr>
      <? } else if ($page == 'limit_nb_bids') { ?>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_LIMIT_NB_BIDS_EXPL;?></td>
      </tr>
      <? } else if ($page == 'bidder_verification') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SELLER_VERIF_MANDATORY;?></td>
         <td><input name="bidder_verification_mandatory" type="checkbox" id="bidder_verification_mandatory" value="1" <? echo ($setts_tmp['bidder_verification_mandatory']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_BIDDER_VERIF_MANDATORY_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_VERIFICATION_FEE;?></td>
         <td><?=$setts['currency'];?>
            <input name="bidder_verification_fee" type="text" id="bidder_verification_fee" value="<?=$fees_tmp['bidder_verification_fee'];?>" size="8">,
            <?=AMSG_RECURRING_EVERY;?>
            <input name="bidder_verification_recurring" type="text" id="bidder_verification_recurring" value="<?=$fees_tmp['bidder_verification_recurring'];?>" size="8">
            <?=GMSG_DAYS;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_BIDDER_VERIFICATION_FEE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_SELLER_VERIF_REFUND;?></td>
         <td><input name="bidder_verification_refund" type="checkbox" id="bidder_verification_refund" value="1" <? echo ($setts_tmp['bidder_verification_refund']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_SELLER_VERIF_REFUND_EXPL;?></td>
      </tr>      
      <? } else if ($page == 'enable_stores') { ?>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_HIDE_EMPTY_STORES;?></td>
         <td><input name="hide_empty_stores" type="checkbox" id="hide_empty_stores" value="1" <? echo ($setts_tmp['hide_empty_stores']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_HIDE_EMPTY_STORES_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td align="right" nowrap><?=AMSG_STORE_LISTINGS;?></td>
         <td><input type="radio" name="store_listing_type" value="0" checked /> <?=AMSG_STANDARD_STORE;?></td>
      </tr>
      <tr>
         <td align="right" class="explain"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_STANDARD_STORE_EXPL;?></td>
      </tr>
      <tr>
         <td align="right" nowrap></td>
         <td class="c1"><input type="radio" name="store_listing_type" value="1" <? echo ($setts_tmp['store_listing_type']=='1') ? 'checked' : ''; ?> /> <?=AMSG_ALTERNATIVE_STORE;?></td>
      </tr>
      <tr>
         <td align="right" class="explain"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_ALTERNATIVE_STORE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_ENABLE_STORE_UPGRADE;?></td>
         <td><input name="enable_store_upgrade" type="checkbox" id="enable_store_upgrade" value="1" <? echo ($setts_tmp['enable_store_upgrade']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_ENABLE_STORE_UPGRADE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=AMSG_STORE_UPGRADE_DAYS;?></td>
         <td><input name="store_upgrade_days" type="text" id="store_upgrade_days" value="<?=$setts_tmp['store_upgrade_days'];?>" size="8">
            <?=GMSG_DAYS;?></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain"><?=AMSG_STORE_UPGRADE_DAYS_EXPL;?></td>
      </tr>
      <? } ?>
      <tr align="center">
         <td colspan="2"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>"></td>
      </tr>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
