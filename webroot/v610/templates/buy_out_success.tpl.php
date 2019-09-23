<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$buy_out_success_message;?>

<table width="100%" border="0" cellpadding="3" cellspacing="2">
   <tr class="c4">
      <td align="right"><strong>
         <?=MSG_ITEM_TITLE;?>
         </strong></td>
      <td><strong>
         <?=$item_details['name'];?>
         </strong></td>
   </tr>
   <tr class="c4">
      <td></td>
      <td></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><strong>
         <?=MSG_BUYOUT_PRICE;?>
         </strong></td>
      <td><? echo $fees->display_amount($item_details['buyout_price'], $item_details['currency']);?></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><strong>
         <?=MSG_QUANTITY_PURCHASED;?>
         </strong></td>
      <td><?=$quantity;?></td>
   </tr>
   <tr class="c4">
      <td></td>
      <td></td>
   </tr>
</table>
<br>
<?=$force_payment_expl;?>
<? if (!empty($direct_payment_box)) { ?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr height="21">
      <td colspan="5" class="c4"><strong>
         <?=MSG_DIRECT_PAYMENT;?>
         </strong></td>
   </tr>
   <tr>
      <td colspan="5" class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr>
      <td colspan="5" class="border"><?=$direct_payment_box;?></td>
   </tr>
</table>
<? } ?>
