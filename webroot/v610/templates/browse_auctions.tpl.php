<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<? echo (IS_SHOP == 1) ? $shop_header : '';?>
<? echo (IS_CATEGORIES == 1) ? $categories_header : '';?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr style="padding-top: 5px;">
		<td valign="top" width="180" style="padding-right: 5px;">
			<? if (IS_CATEGORIES == 1 && $is_shop_stores) { ?>
			<? echo header5(MSG_SHOP_IN_STORES); ?>
			<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
				<?=$shop_stores_content;?>
			</table>
			<br>
			<? } ?>
			<?=$search_browse_box;?>
		</td>
		<td valign="top">
			<?=$header_browse_auctions;?>
			<?=$item_types_tab;?>
			<h3 id="browse_found"><?=$nb_items;?> <?=($nb_items == 1) ? MSG_ITEM_FOUND : MSG_ITEMS_FOUND;?></h3>
			
			<table width="100%" border="0" cellpadding="3" cellspacing="2">
				<tr class="contentfont">
					<form action="<?=$form_action;?>" method="GET">
					<?=$hidden_sort;?>
					<? if ($nb_items > 0) { ?>
					<td style="padding: 5px;">
						<b><?=GMSG_SHOW;?></b>:
						<select name="order_fld">
							<option value="order_closing_soon" <? echo ($src_details['order_fld'] == 'order_closing_soon') ? 'selected' : '';?>><?=MSG_ORDER_CLOSING_SOON;?></option>
							<option value="order_recently_listed" <? echo ($src_details['order_fld'] == 'order_recently_listed') ? 'selected' : '';?>><?=MSG_ORDER_RECENTLY_LISTED;?></option>
						</select>
						<input type="submit" name="form_order_fld" value="<?=GMSG_GO;?>">
					</td>
					<? } ?>
					<td style="padding: 5px 0; text-align: right;">
						<div id="save_search"><?=$saved_searches_content;?></div>
					</td>
					</form>
				</tr>
			</table>
				
			<? if ($nb_items > 0) { ?>
			<table width="100%" border="0" cellpadding="3" cellspacing="2" class="<? echo (IS_SHOP == 1 || IS_CATEGORIES == 1) ? '' : ''; ?>">
				<form action="compare_items.php" method="POST">
			   <input type="hidden" name="redirect" value="<?=$redirect;?>">
			
				<tr class="<? echo (IS_SHOP == 1) ? 'c1_shop' : 'membmenu'; ?>" valign="top">
			      <td align="center"></td>
			      <td align="center"><input type="submit" name="form_compare_items" value="<?=MSG_COMPARE;?>"></td>
			      <td><?=MSG_ITEM_TITLE;?><br><?=$page_order_itemname;?></td>
			      <td align="center"><?=MSG_NR_BIDS;?><br><?=$page_order_nb_bids;?></td>
			      <td align="center"><?=MSG_CURRENTLY;?><br><?=$page_order_current_price;?></td>   
			      <? if ($src_details['order_fld'] == 'order_recently_listed') { ?>
			      <td align="center"><?=MSG_LISTED_FOR;?><br><?=$page_order_start_time;?></td>      
			      <? } else { ?>
			      <td align="center"><?=MSG_ENDS;?><br><?=$page_order_end_time;?></td>
			      <? } ?>
			   </tr>
			   <tr class="<? echo (IS_SHOP == 1) ? 'c5_shop' : 'c5';?>">
			      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="15" height="1"></td>
			      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="<?=$setts['browse_thumb_size']+10;?>" height="1"></td>
			      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
			      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
			      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
			      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
			   </tr>
			   <?=$browse_auctions_content;?>
			
				<tr class="contentfont">
			      <td colspan="3" style="padding: 5px;"><?=$query_results_message;?></td>
			      
			      <td colspan="3" align="right" style="padding: 5px;"><?=$items_per_page;?></td>
			   </tr>
			   <tr class="contentfont">
					<td colspan="6" align="center" style="padding: 5px;">
						<? if (!empty($pagination)) { ?>
						<b><?=MSG_PAGE;?></b>: <?=$pagination;?>
						<? } ?>
					</td>			   
				</tr>
			   </form>
			</table>
			<? } ?>
		</td>
	</tr>
</table>

<? echo (IS_CATEGORIES == 1) ? $categories_footer : '';?>
<? echo (IS_SHOP == 1) ? $shop_footer : '';?>

