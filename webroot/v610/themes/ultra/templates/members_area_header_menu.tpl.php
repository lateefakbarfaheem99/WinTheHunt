<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>


<? if ($pref_seller_reduction) { ?>
<img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" border="0" width="1" height="5">
<table border="0" cellpadding="6" cellspacing="0" width="100%">
   <tr>
      <td class="c1" align="center"><? echo '[ <strong>' . MSG_PREFERRED_SELLER . ' - ' . $setts['pref_sellers_reduction'] . '% ' . MSG_REDUCTION_EXPL . '</strong> ]';?> </td>
   </tr>
</table>
<? } ?>

<? if ($credit_limit_warning) { ?>
<img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" border="0" width="1" height="5">
<table border="0" cellpadding="6" cellspacing="0" width="100%">
   <tr>
      <td class="c2"><?=MSG_CREDIT_LIMIT_WARNING;?></td>
   </tr>
</table>
<? } ?>