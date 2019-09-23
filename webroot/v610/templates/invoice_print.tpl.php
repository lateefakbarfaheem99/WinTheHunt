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
<?=$setts['sitename'];?>
-
<?=MSG_DISPLAY_INVOICE;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CODEPAGE;?>">
<link href="themes/<?=$setts['default_theme'];?>/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
</head>
<body>
<table width="790" cellpadding="0" cellspacing="2" align="center" class="border">
   <tr>
      <td><?=$invoice_header;?></td>
   </tr>
   <? if ($invoice_type == 'product_invoice') { ?>
   <tr>
      <td><?=$seller_full_name;?><br>
			<?=$seller_full_address;?></td>
   </tr>
   <? } ?>
   <tr class="c4">
      <td></td>
   </tr>
   <tr>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
               <td width="50%"><table width="70%" border="0" cellpadding="3" cellspacing="2" class="border">
                     <tr>
                        <td class="c4"><?=MSG_BILL_TO;?>:</td>
                     </tr>
                     <tr class="c2">
                        <td><?=$buyer_full_name;?><br>
                       		<?=$buyer_full_address;?></td>
                     </tr>
                  </table></td>
               <td width="50%"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
                     <tr>
                        <td class="c4" nowrap><?=MSG_INVOICE_DATE;?></td>
                        <td class="c1"><?=$invoice_date;?></td>
                     </tr>
                     <? if ($tax_details['apply']) { ?>
                     <tr>
                        <td class="c4" nowrap><?=MSG_TAX_REG_NUMBER;?></td>
                        <td class="c1"><?=$tax_details['tax_reg_number'];?></td>
                     </tr>
                     <? } ?>
                     <tr>
                        <td class="c4"><?=MSG_INVOICE_NUMBER;?></td>
                        <td class="c1"><?=$invoice_number;?></td>
                     </tr>
                     <tr>
                        <td class="c4"><?=MSG_ORDER_METHOD;?></td>
                        <td class="c1"><?=MSG_ONLINE;?></td>
                     </tr>
                     <tr>
                        <td class="c4"><?=MSG_PRODUCT_TYPE;?></td>
                        <td class="c1"><?=MSG_DIGITAL_GOODS;?></td>
                     </tr>
                     <tr>
                        <td class="c4"><?=MSG_PAYMENT_TERMS;?></td>
                        <td class="c1"><?=MSG_ON_DEMAND;?></td>
                     </tr>
                     <? if ($invoice_type == 'product_invoice') { ?>
                     <tr>
                     	<td class="c4" colspan="2"><?=MSG_PAYMENT_METHODS;?></td>                     	
                     </tr>
                     <tr>
                     	<td class="c1" colspan="2"><?=$payment_methods_accepted;?></td>
                     </tr>
                     <? } ?>
                  </table></td>
            </tr>
         </table></td>
   </tr>
   <tr>
      <td align="center"><font size="+2" color="#666666"><b> <?=$invoice_name;?> </b></font></td>
   </tr>
   <tr>
      <td><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
            <tr class="c4" align="center">
               <td><?=GMSG_QUANTITY;?></td>
               <td><?=GMSG_DESCRIPTION;?></td>
               <td><?=GMSG_PRICE;?></td>
               <td><?=MSG_TAX_RATE;?></td>
               <td><?=MSG_TAX_AMOUNT;?></td>
               <td><?=GMSG_TOTAL;?></td>
            </tr>
            <tr class="c3">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
               <td width="100%"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
            </tr>
            <?=$invoice_content;?>
         </table></td>
   </tr>
   <tr>
      <td><p>&nbsp;</p></td>
   </tr>
   <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
               <td width="50%"><table width="70%" border="0" cellpadding="3" cellspacing="2" class="border">
                     <tr>
                        <td class="c4"><?=MSG_DELIVERY_ADDRESS;?>:</td>
                     </tr>
                     <tr class="c2">
                        <td><?=$buyer_full_name;?><br>
                       		<?=$buyer_full_address;?></td>
                     </tr>
                  </table></td>
               <td width="50%"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
               		<? if ($invoice_type == 'product_invoice') { ?>
                     <tr>
                        <td class="c4"><?=MSG_POSTAGE;?></td>
                        <td class="c1"><?=$total_postage;?></td>
                     </tr>
                     <tr>
                        <td class="c4"><?=MSG_INSURANCE;?></td>
                        <td class="c1"><?=$total_insurance;?></td>
                     </tr>
               		<? } ?>
                     <? if ($invoice_type != 'product_invoice') { ?>
                     <tr>
                        <td class="c4"><?=MSG_TOTAL_EXC_TAX;?></td>
                        <td class="c1"><?=$total_no_tax;?></td>
                     </tr>
                     <tr>
                     	<td class="c4"><?=MSG_TAX_RATE;?></td>
                        <td class="c1"><?=$tax_details['tax_rate'];?></td>
                     </tr>
                     <tr>
                        <td class="c4"><?=MSG_TAX_AMOUNT;?></td>
                        <td class="c1"><?=$total_tax;?></td>
                     </tr>
                     <? } ?>                     
                     <tr>
                        <td class="c4"></td>
                        <td class="c4"></td>
                     </tr>
                     <tr>
                        <td class="c4"><?=MSG_INVOICE_TOTAL;?></td>
                        <td class="c1"><?=$total_amount;?></td>
                     </tr>
                  </table>
					</td>
            </tr>
         </table></td>
   </tr>
   <? if ($invoice_type != 'product_invoice' || !empty($invoice_comments)) { ?>
   <tr>
      <td><p>&nbsp;</p></td>
   </tr>
   <tr>
      <td><table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
            <tr>
               <td class="c4"><b>
                  <?=MSG_COMMENTS;?>:</b></td>
            </tr>
            <tr>
               <td class="c1"><? echo ($invoice_type == 'product_invoice') ? $invoice_comments : $setts['invoice_comments'];?></td>
            </tr>
         </table></td>
   </tr>
   <tr class="c4">
      <td></td>
   </tr>
   <tr>
      <td><?=$invoice_footer;?></td>
   </tr>
   <? } ?>
</table>
</body>
</html>
