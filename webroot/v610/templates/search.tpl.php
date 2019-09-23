<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$header_search_page;?>
<? echo (!empty($no_results_message)) ? $no_results_message : '<br>';?>
<? if (!empty($search_options_menu)) { ?>

<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border contentfont">
   <tr>
      <td colspan="3" class="c2"><b><?=MSG_CHOOSE_SEARCH_METHOD;?></b>: <?=$search_options_menu;?></td>
   </tr>
</table>
<br>
<? } ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <? if (!empty($search_options_title)) { ?>
   <tr>
      <td colspan="5" class="c3"><b>
         <?=$search_options_title;?>
         </b> &nbsp; <? echo ($option == 'category_search') ? $cats_src_adv_search_link : '';?></td>
   </tr>
   <? } ?>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td width="100%" colspan="4"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
   </tr>
   <?
	$post_url = ($option == 'store_search') ? 'stores.php' : 'auction_search.php';
	$post_url = ($option == 'category_search') ? 'categories.php' : $post_url;
	?>
   <form action="<?=$post_url;?>" method="POST" name="form_advanced_search">
      <input type="hidden" name="option" value="<?=$option;?>">
      <? if ($option == 'auction_search') { ?>
      <tr class="c1">
         <td align="right"><?=MSG_SEARCH_AUCTION_ID;?></td>
         <td colspan="2"><input name="src_auction_id" type="text" id="src_auction_id" size="15" value="<?=$item_details['src_auction_id'];?>"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_SEARCH_KEYWORDS;?></td>
         <td colspan="2"><input name="keywords_search" type="text" id="keywords_search" size="50" value="<?=$item_details['keywords_search'];?>"></td>
      </tr>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="search_description" value="1" checked></td>
         <td  class="c1" width="100%"><?=MSG_SEARCH_DESCRIPTION;?></td>
      </tr>
      <? if ($layout['enable_buyout'] && $setts['buyout_process'] == 1) { ?>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="buyout_price" value="1" <? echo ($item_details['buyout_price'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="100%"><?=MSG_SEARCH_BUYOUT_ITEMS;?></td>
      </tr>
      <? } ?>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="reserve_price" value="1" <? echo ($item_details['reserve_price'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="100%"><?=MSG_SEARCH_RESERVE_PRICE_ITEMS;?></td>
      </tr>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="quantity" value="1" <? echo ($item_details['quantity'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="100%"><?=MSG_SEARCH_QUANTITY_DUTCH;?></td>
      </tr>
      <? if ($setts['enable_swaps']) { ?>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="enable_swap" value="1" <? echo ($item_details['enable_swap'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="100%"><?=MSG_SEARCH_SWAP_ENABLED;?></td>
      </tr>
      <? } ?>
      <? if ($setts['enable_stores']) { ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_LISTED_IN;?></td>
         <td colspan="2"><select name="list_in">
               <option value="" selected>
               <?=GMSG_ANY;?>
               </option>         
               <option value="auction" <? echo ($item_details['list_in'] == 'auction') ? 'selected' : '';?>>
               <?=GMSG_SITE;?>
               </option>
               <option value="store" <? echo ($item_details['list_in'] == 'store') ? 'selected' : '';?>>
               <?=GMSG_SHOP;?>
               </option>
               <option value="both" <? echo ($item_details['list_in'] == 'both') ? 'selected' : '';?>>
               <?=GMSG_BOTH;?>
               </option>
            </select></td>
      </tr>
      <? } ?>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_VIEW_RESULTS;?></td>
         <td colspan="2"><select name="results_view">
               <option value="all" <? echo ($item_details['results_view'] == 'all') ? 'selected' : '';?>>
               <?=GMSG_ALL;?>
               </option>
               <option value="open" selected>
               <?=GMSG_OPEN_AUCTIONS_ONLY;?>
               </option>
               <option value="closed" <? echo ($item_details['results_view'] == 'closed') ? 'selected' : '';?>>
               <?=GMSG_CLOSED_AUCTIONS_ONLY;?>
               </option>
            </select></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ORDER_BY;?></td>
         <td colspan="2"><select name="ordering">
               <option value="end_time_asc" selected>
               <?=MSG_ITEMS_ENDING_FIRST;?>
               </option>
               <option value="end_time_desc" <? echo ($item_details['ordering'] == 'end_time_desc') ? 'selected' : '';?>>
               <?=MSG_NEWEST_ITEMS_FIRST;?>
               </option>
               <option value="start_price_asc" <? echo ($item_details['ordering'] == 'start_price_asc') ? 'selected' : '';?>>
               <?=MSG_LOWEST_PRICES_FIRST;?>
               </option>
            </select></td>
      </tr>
      <?=$custom_sections_table;?>
      <tr>
         <td colspan="3" class="c3"><?=MSG_LOCATION;?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_COUNTRY;?> </td>
         <td colspan="2"><?=$country_dropdown;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ZIP_CODE;?> </td>
         <td colspan="2"><input type="text" name="zip_code" value="<?=$item_details['zip_code'];?>" size="25" /></td>
      </tr>
      <? } else if ($option == 'seller_search') { ?>
      <tr class="c1">
         <td align="right"><?=MSG_USERNAME;?></td>
         <td colspan="2"><input name="username" type="text" id="username" size="50" value="<?=$item_details['username'];?>"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_VIEW_RESULTS;?></td>
         <td colspan="2"><select name="results_view">
               <option value="all" <? echo ($item_details['results_view'] == 'all') ? 'selected' : '';?>>
               <?=GMSG_ALL;?>
               </option>
               <option value="open" selected>
               <?=GMSG_OPEN_AUCTIONS_ONLY;?>
               </option>
               <option value="closed" <? echo ($item_details['results_view'] == 'closed') ? 'selected' : '';?>>
               <?=GMSG_CLOSED_AUCTIONS_ONLY;?>
               </option>
            </select></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ORDER_BY;?></td>
         <td colspan="2"><select name="ordering">
               <option value="end_time_asc" selected>
               <?=MSG_ITEMS_ENDING_FIRST;?>
               </option>
               <option value="end_time_desc" <? echo ($item_details['ordering'] == 'end_time_desc') ? 'selected' : '';?>>
               <?=MSG_NEWEST_ITEMS_FIRST;?>
               </option>
               <option value="start_price_asc" <? echo ($item_details['ordering'] == 'start_price_asc') ? 'selected' : '';?>>
               <?=MSG_LOWEST_PRICES_FIRST;?>
               </option>
            </select></td>
      </tr>
      <? } else if ($option == 'buyer_search') { ?>
      <tr class="c1">
         <td align="right"><?=MSG_USERNAME;?></td>
         <td colspan="2"><input name="username" type="text" id="username" size="50" value="<?=$item_details['username'];?>"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_VIEW_RESULTS;?></td>
         <td colspan="2"><select name="results_view">
               <option value="all" <? echo ($item_details['results_view'] == 'all') ? 'selected' : '';?>>
               <?=GMSG_ALL;?>
               </option>
               <option value="open" selected>
               <?=GMSG_OPEN_AUCTIONS_ONLY;?>
               </option>
               <option value="closed" <? echo ($item_details['results_view'] == 'closed') ? 'selected' : '';?>>
               <?=GMSG_CLOSED_AUCTIONS_ONLY;?>
               </option>
            </select></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=MSG_ORDER_BY;?></td>
         <td colspan="2"><select name="ordering">
               <option value="end_time_asc" selected>
               <?=MSG_ITEMS_ENDING_FIRST;?>
               </option>
               <option value="end_time_desc" <? echo ($item_details['ordering'] == 'end_time_desc') ? 'selected' : '';?>>
               <?=MSG_NEWEST_ITEMS_FIRST;?>
               </option>
               <option value="start_price_asc" <? echo ($item_details['ordering'] == 'start_price_asc') ? 'selected' : '';?>>
               <?=MSG_LOWEST_PRICES_FIRST;?>
               </option>
            </select></td>
      </tr>
      <? } else if ($option == 'store_search') { ?>
      <tr class="c1">
         <td align="right"><?=MSG_STORE_NAME;?></td>
         <td colspan="2"><input name="shop_name" type="text" id="shop_name" size="50" value="<?=$item_details['shop_name'];?>"></td>
      </tr>
      <? } else if ($option == 'category_search') { ?>
      <input type="hidden" name="advanced_search" value="<?=$advanced_search;?>" >
      <tr class="c1">
         <td align="right"><?=GMSG_SEARCH;?></td>
         <td colspan="4"><input name="keywords_cat_search" type="text" id="shop_name" size="50" value="<?=$item_details['keywords_cat_search'];?>">
            <?=GMSG_IN;?> <?=$cats_src_drop_down;?></td>
      </tr>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="search_description" value="1" <? echo ($item_details['search_description'] == 1) ? 'checked' : '';?>></td>
         <td colspan="3" class="c1" width="100%"><?=MSG_SEARCH_DESCRIPTION;?></td>
      </tr>
      <? if ($advanced_search) { ?>
      <? if ($layout['enable_buyout'] && $setts['buyout_process'] == 1) { ?>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="buyout_price" value="1" <? echo ($item_details['buyout_price'] == 1) ? 'checked' : '';?>></td>
         <td colspan="3" class="c1" width="100%"><?=MSG_SEARCH_BUYOUT_ITEMS_ONLY;?></td>
      </tr>
      <? } ?>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="reserve_price" value="1" <? echo ($item_details['reserve_price'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="50%"><?=MSG_SEARCH_RESERVE_PRICE_ITEMS_ONLY;?></td>
         <td class="c1"><input type="checkbox" name="photos_only" value="1" <? echo ($item_details['photos_only'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="50%"><?=MSG_SEARCH_PHOTOS_ONLY;?></td>
      </tr>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="quantity_standard" value="1" <? echo ($item_details['quantity_standard'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="50%"><?=MSG_SEARCH_QUANTITY_STANDARD_ONLY;?></td>
         <td class="c1"><input type="checkbox" name="quantity" value="1" <? echo ($item_details['quantity'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="50%"><?=MSG_SEARCH_QUANTITY_DUTCH_ONLY;?></td>
      </tr>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="direct_payment_only" value="1" <? echo ($item_details['direct_payment_only'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="50%"><?=MSG_SEARCH_DIRECT_PM_ONLY;?></td>
         <td class="c1"><input type="checkbox" name="regular_payment_only" value="1" <? echo ($item_details['regular_payment_only'] == 1) ? 'checked' : '';?>></td>
         <td  class="c1" width="50%"><?=MSG_SEARCH_REGULAR_PM_ONLY;?></td>
      </tr>
		<? if ($setts['enable_swaps']) { ?>
      <tr>
         <td></td>
         <td class="c1"><input type="checkbox" name="enable_swap" value="1" <? echo ($item_details['enable_swap'] == 1) ? 'checked' : '';?>></td>
         <td colspan="3" class="c1" width="100%"><?=MSG_SEARCH_SWAP_ENABLED;?></td>
      </tr>
      <? } ?>
		<?=$custom_sections_table_categories;?>
      <? } ?>
      <? } ?>
      <tr class="c4">
         <td colspan="5"></td>
      </tr>
      <tr>
         <td></td>
         <td colspan="4"><input type="submit" name="form_search_proceed" value="<?=GMSG_SEARCH;?>"></td>
      </tr>
   </form>
</table>
