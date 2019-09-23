<?
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<table width="80%" border="0" cellpadding="5" cellspacing="0" class="errormessage" align="center">
   <tr>
      <td class="contentfont">
      	<h5 style="margin-bottom: 5px; "><? echo ($setts['seller_verification_mandatory']) ? MSG_GET_VERIFIED_EXPL_1 : MSG_GET_VERIFIED_EXPL_2;?></h5>
      	<?=MSG_GET_VERIFIED_EXPL_3;?>
      	<table align="center">
            <tr>
               <td>[ <a href="<?=process_link('fee_payment', array('do' => 'seller_verification'));?>"><?=MSG_GET_VERIFIED;?></a> ]</td>
               <? if (!$setts['seller_verification_mandatory']) { ?>
               <td>[ <a href="<?=process_link('sell_item', array('option' => 'new_item', 'current_step' => 'verification_checked'));?>"><?=MSG_SKIP_VERIFICATION;?></a> ]</td>
					<? } ?>
            </tr>
         </table></td>
   </tr>
</table>
