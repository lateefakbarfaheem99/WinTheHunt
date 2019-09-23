<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="JavaScript">
function check_products(form_name){
	form_name.send_invoice.value = 1;
	form_name.submit();
}

function check_all_products(form_name, value)
{
	if (value==1)
	{
		form_name.select_all.value = 1;
	}
	else
	{
		form_name.select_none.value = 1;
	}
	
	form_name.tmp_post.value = 1;
	form_name.submit();	
}

function submit_form(form_name)
{
	form_name.tmp_post.value = 1;
	form_name.submit();	
}
</script> 
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c7"><b><? echo ($edit_invoice) ? MSG_EDIT_PRODUCT_INVOICE : MSG_CREATE_PRODUCT_INVOICE;?></b></td>
   </tr>
   <tr>
      <td class="membmenu"><?=MSG_BUYER_USERNAME;?>
         : <b><?=$user_details['username']; ?></b></td>
   </tr>
   <tr>
      <td class="membmenu"><?=MSG_SELLER_USERNAME;?>
         : <b><?=$seller_details['username']; ?></b></td>
   </tr>
   <tr>
      <td class="c4"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
	<? if (!empty($product_invoice_content)) { ?>
   <tr>
      <td align="center"><table width="90%" border="0" cellpadding="3" cellspacing="2" class="border">
            <form action="" method="post" name="product_invoice_form">
               <input type="hidden" name="buyer_id" value="<?=$user_details['user_id'];?>">
               <input type="hidden" name="seller_id" value="<?=$seller_details['user_id'];?>">
               <input type="hidden" name="auction_id" value="<?=$auction_id;?>">
               <input type="hidden" name="send_invoice" value="0">
               <input type="hidden" name="tmp_post" value="0">
               <input type="hidden" name="select_all" value="0" />
               <input type="hidden" name="select_none" value="0" />
               <? if (!$edit_invoice) { ?>
               <tr>
                  <td colspan="8"><b><?=MSG_SELECT_PRODUCTS;?></b></td>
               </tr>
               <? } ?>
               <tr class="membmenu">
                  <td nowrap align="center">
                  	<? if ($option != 'edit_invoice') { ?>
                  	<?=MSG_SELECT;?><br>
                  	[ <a href="javascript:;" onclick="check_all_products(product_invoice_form, 1);"><?=GMSG_ALL;?></a> | 
                  	<a href="javascript:;" onclick="check_all_products(product_invoice_form, 0);"><?=GMSG_NONE;?></a> ]
                  	<? } ?>
                  </td>
                  <td><?=MSG_AUCTION_ID;?></td>
                  <td><?=MSG_ITEM_TITLE;?></td>
                  <td align="center"><?=MSG_WINNING_BID;?></td>
                  <td align="center"><?=GMSG_QUANTITY;?></td>
                  <? if ($seller_details['pc_postage_type'] == 'item') { ?>
                  <td align="center"><?=MSG_POSTAGE;?></td>
                  <? } ?>
                  <td align="center"><?=MSG_INSURANCE;?></td>
               </tr>
               <tr class="c5">
                  <td></td>
                  <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
                  <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
                  <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
                  <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
                  <? if ($seller_details['pc_postage_type'] == 'item') { ?>
                  <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
                  <? } ?>
                  <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
               </tr>
               <?=$product_invoice_content;?>
               <? if ($seller_details['pc_postage_type'] != 'item') { ?>               
               <tr>
               	<td class="c5" colspan="8"></td>
               </tr>
               <? if (!empty($shipping_method)) { ?>
               <tr>
               	<td colspan="3"></td>
               	<td align="right" class="c1"><b><?=MSG_SHIPPING_METHOD;?></b>:</td>
               	<td colspan="4" class="c1"><?=$shipping_method;?></td>
               </tr>
               <? } ?>
               <? } ?>
               <tr>
               	<td colspan="3"><?=MSG_COMMENTS;?></td>
               	<? if ($seller_details['pc_postage_type'] != 'item') { ?>
               	<td align="right" class="c2"><b><?=MSG_POSTAGE;?></b>:</td>
               	<td colspan="4" class="c2"><?=$total_postage_box;?></td>
               	<? } else { ?>
               	<td align="right"></td>
               	<td colspan="4"></td>
               	<? } ?>
               </tr>
               <tr>
               	<td colspan="3"><textarea name="invoice_comments" style="width: 60%; height: 75px;"><?=$invoice_comments;?></textarea></td>
               	<td align="right"></td>
               	<td colspan="4"></td>
               </tr>
               <tr class="membmenu">
                  <td colspan="8" align="center" class="contentfont"><input type="<? echo (!$edit_invoice) ? 'button' : 'submit'; ?>" name="form_send_invoice" value="<?=GMSG_PROCEED;?>" <? echo (!$edit_invoice) ? 'onclick="check_products(product_invoice_form);"' : ''; ?> <?=$disabled_button;?> /></td>
               </tr>
               <tr>
               	<td colspan="8"><?=MSG_CREATE_INVOICE_NOTE;?></td>
               </tr>
               
            </form>
         </table></td>
   </tr>
	<? } else { ?>
	<tr>
		<td align="center"><?=MSG_NO_ITEMS_INVOICE;?></td>
	</tr>
	<? } ?>
</table>
