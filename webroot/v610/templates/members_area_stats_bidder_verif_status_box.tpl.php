<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table border="0" cellspacing="2" cellpadding="3" class="border">
   <tr>
      <td rowspan="2" class="c1"><img align=absmiddle src="images/verified_bidder.gif" border="0"></td>
      <td colspan="2" class="buyingtitle"><b><?=MSG_BIDDER_STATUS;?></b></td>
   </tr>
   <tr>
      <td><? echo ($bidder_details['bidder_verified']) ? '<b>' . MSG_VERIFIED . '</b>' : '<span style="color: red; ">' . MSG_NOT_VERIFIED . '</span>'; ?></td>      
      <? if (!$bidder_details['bidder_verified']) { ?>
      <td nowrap class="contentfont">[ <a href="fee_payment.php?do=bidder_verification"><?=MSG_GET_VERIFIED;?></a> ]</td>
      <? } ?>
   </tr>
</table>