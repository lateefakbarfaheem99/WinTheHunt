<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<br>
<?=$management_box;?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="10" class="c7"><b><?=MSG_MM_SELLER_VOUCHERS;?></b></td>
   </tr>
   <tr>
      <td colspan="5" class="contentfont">
      	[ <a href="members_area.php?page=selling&section=vouchers&do=add_voucher"><?=MSG_ADD_VOUCHER;?></a> ]
      </td>
   </tr>
	<tr class="c4">
   	<td width="150"><?=MSG_VOUCHER_NAME;?></td>
    <td width="100"><?=MSG_VOUCHER_CODE;?></td>
		<td><?=MSG_VOUCHER_DETAILS;?></td>
    <td width="150" align="center"><?=GMSG_OPTIONS;?></td>
   </tr>
	<?=$seller_vouchers_content;?>
</table>