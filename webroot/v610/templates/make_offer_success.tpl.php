<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$make_offer_success_message;?>

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
         <?=MSG_OFFER_AMOUNT;?>
         </strong></td>
      <td><? echo $fees->display_amount($amount, $item_details['currency']);?></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right"><strong>
         <?=GMSG_QUANTITY;?>
         </strong></td>
      <td><?=$quantity;?></td>
   </tr>
   <tr class="c4">
      <td></td>
      <td></td>
   </tr>
</table>