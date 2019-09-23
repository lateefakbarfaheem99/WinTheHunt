<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

		</td>
   </tr>
   <tr>
   	<td>&nbsp;</td>
   </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td class="footer_shop" align="center" style="padding: 3px;">
      	<a href="shop.php?user_id=<?=$user_id;?>"><?=MSG_STORE_HOME;?></a> | 
      	<a href="shop.php?user_id=<?=$user_id;?>&page=shop_about"><?=MSG_STORE_ABOUT_PAGE;?></a> | 
      	<a href="shop.php?user_id=<?=$user_id;?>&page=shop_specials"><?=MSG_STORE_SPECIALS?></a> | 
      	<a href="shop.php?user_id=<?=$user_id;?>&page=shop_shipping_info"><?=MSG_STORE_SHIPPING_INFO;?></a> | 
      	<a href="shop.php?user_id=<?=$user_id;?>&page=shop_company_policies"><?=MSG_STORE_COMPANY_POILICIES;?></a> <strong>|</strong> 
      	<a href="other_items.php?owner_id=<?=$user_id;?>"><?=MSG_VIEW_AUCTIONS;?></a> | 
      	<a href="user_reputation.php?user_id=<?=$user_id;?>"><?=MSG_VIEW_REPUTATION?></a> </td>
   </tr>
</table>
