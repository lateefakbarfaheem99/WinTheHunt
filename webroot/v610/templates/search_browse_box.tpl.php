<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript">
	function check_fields()
	{
		if (document.getElementById('zip_code').value == '<?=MSG_ENTER_ZIP_CODE;?>')
		{
			document.getElementById('zip_code').value = '';
		}
	}
</script>
<? echo header5(MSG_REFINE_SEARCH); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="2" class="border">
   <form action="<?=$form_action;?>" name="form_advanced_search" method="GET">
		<?=$hidden_src;?>
      <tr class="c1 srcbox_title">
         <td><?=MSG_SEARCH_AUCTION_ID;?></td>
      </tr>
      <tr>
         <td>
         	<input name="src_auction_id" type="text" id="src_auction_id" value="<?=$src_details['src_auction_id'];?>" class="src_input">
         </td>
      </tr>
      <tr class="c1 srcbox_title">
         <td><?=MSG_SEARCH_KEYWORDS;?></td>
      </tr>
      <tr>
         <td>
         	<input name="keywords_search" type="text" id="keywords_search" size="50" value="<?=$src_details['keywords_search'];?>" class="src_input">
         </td>
      </tr>
      <tr>
         <td>
         	<input type="checkbox" name="search_description" value="1" <? echo ($src_details['search_description'] == 1) ? 'checked' : '';?>> 
         	<?=MSG_SEARCH_DESCRIPTION;?>
         </td>
      </tr>   
      <tr class="c1 srcbox_title">
      	<td><?=MSG_CURRENT_PRICE;?></td>      	
      </tr>
      <tr>
	      <td align="center">
	      	<input type="text" name="min_price" id="min_price" size="6" value="<?=$src_details['min_price'];?>" />
	      	<?=GMSG_TO;?>
	      	<input type="text" name="max_price" id="max_price" size="6" value="<?=$src_details['max_price'];?>" />
	      </td>
      </tr>
      <tr class="c1 srcbox_title">
      	<td class="contentfont"><?=MSG_CATEGORIES;?> &nbsp; <?=$category_reset_link; ?></td>      	
      </tr>   
      <?=$subcategories_content;?>
      <tr class="c1 srcbox_title">
      	<td><?=MSG_LISTING_OPTIONS;?></td>
      </tr>
      <? if (IS_SHOP != 1) { ?>
      <tr>
         <td>
         	<input type="checkbox" name="reserve_price" value="1" <? echo ($src_details['reserve_price'] == 1) ? 'checked' : '';?>> 
         	<?=MSG_SEARCH_RESERVE_PRICE_ITEMS;?>
         </td>
      </tr>
      <tr>
         <td>
         	<input type="checkbox" name="quantity_standard" value="1" <? echo ($src_details['quantity_standard'] == 1) ? 'checked' : '';?>>
         	<?=MSG_SEARCH_QUANTITY_STANDARD_ONLY;?>
         </td>
      </tr>      
      <tr>
         <td>
         	<input type="checkbox" name="quantity" value="1" <? echo ($src_details['quantity'] == 1) ? 'checked' : '';?>>
         	<?=MSG_SEARCH_QUANTITY_DUTCH;?>
         </td>
      </tr>
      <? } ?>
      <tr>
         <td>
         	<input type="checkbox" name="photos_only" value="1" <? echo ($src_details['photos_only'] == 1) ? 'checked' : '';?>>
         	<?=MSG_SEARCH_PHOTOS_ONLY;?>
         </td>
      </tr>      
      <tr>
         <td>
         	<input type="checkbox" name="direct_payment_only" value="1" <? echo ($src_details['direct_payment_only'] == 1) ? 'checked' : '';?>>
         	<?=MSG_SEARCH_DIRECT_PM_ONLY;?>
         </td>
      </tr>
         <td>
         	<input type="checkbox" name="regular_payment_only" value="1" <? echo ($src_details['regular_payment_only'] == 1) ? 'checked' : '';?>>
         	<?=MSG_SEARCH_REGULAR_PM_ONLY;?>
         </td>
      </tr>      
      <? if ($setts['enable_swaps']) { ?>
      <tr>
         <td>
         	<input type="checkbox" name="enable_swap" value="1" <? echo ($src_details['enable_swap'] == 1) ? 'checked' : '';?>>
         	<?=MSG_SEARCH_SWAP_ENABLED;?>
         </td>
      </tr>
      <? } ?>
      <!--
      <? if ($setts['enable_stores']) { ?>
      <tr class="c1 srcbox_title">
         <td><?=MSG_LISTED_IN;?></td>
      </tr>
      <tr>
         <td>
         	<select name="list_in" class="src_input">
               <option value="" selected><?=GMSG_ANY;?></option>         
               <option value="auction" <? echo ($src_details['list_in'] == 'auction') ? 'selected' : '';?>><?=GMSG_SITE;?></option>
               <option value="store" <? echo ($src_details['list_in'] == 'store') ? 'selected' : '';?>><?=GMSG_SHOP;?></option>
               <option value="both" <? echo ($src_details['list_in'] == 'both') ? 'selected' : '';?>><?=GMSG_BOTH;?></option>
            </select>
			</td>
      </tr>
      <? } ?>
      -->
      <tr class="c1 srcbox_title">
         <td><?=MSG_VIEW_RESULTS;?></td>
      </tr>
      <tr>
         <td>
         	<select name="results_view" class="src_input">
               <option value="open" selected><?=GMSG_OPEN_AUCTIONS_ONLY;?></option>
               <option value="closed" <? echo ($src_details['results_view'] == 'closed') ? 'selected' : '';?>><?=GMSG_CLOSED_AUCTIONS_ONLY;?></option>
               <option value="all" <? echo ($src_details['results_view'] == 'all') ? 'selected' : '';?>><?=GMSG_ALL;?></option>
            </select>
         </td>
      </tr>
      <?=$custom_sections_table;?>
      <tr class="c1 srcbox_title">
         <td><?=MSG_LOCATION;?></td>
      </tr>
      <tr>
         <td><?=$country_dropdown;?></td>
      </tr>
      <tr>
         <td><input type="text" name="zip_code" id="zip_code" value="<? echo (!empty($src_details['zip_code'])) ? $src_details['zip_code'] : MSG_ENTER_ZIP_CODE;?>" class="src_input" /></td>
      </tr>
      <tr>
         <td align="right"><input type="submit" name="form_search_proceed" value="<?=GMSG_SEARCH;?>" onclick="check_fields();"></td>
      </tr>
   </form>
</table>
