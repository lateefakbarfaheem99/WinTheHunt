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
      <td align="center" class="contentfont">
      	<? if ($shop_status['enabled'] && $shop_status['remaining_items'] <= 0) { ?>
         <h5 style="margin-bottom: 5px; margin-top: 3px;"><?=MSG_STORE_ONLY_MODE_NO_MORE_ITEMS_EXPL;?></h5>
         <table>
            <tr>
               <td>[ <a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'subscription'));?>"><?=MSG_UPGRADE_STORE;?></a> ]</td>
            </tr>
         </table>
      	<? } else { ?>
         <h5 style="margin-bottom: 5px; margin-top: 3px;"><?=MSG_STORE_ONLY_MODE_EXPL;?></h5>
         <table>
            <tr>
               <td>[ <a href="<?=process_link('members_area', array('page' => 'store', 'section' => 'subscription'));?>"><?=MSG_CREATE_STORE;?></a> ]</td>
            </tr>
         </table>
         <? } ?></td>
   </tr>
</table>
