<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$bidding_success_message;?>
<? if ($item_details['auction_type'] != 'first_bidder') { ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="errormessage">
	<tr>
		<td><?=MSG_OUTBID_EXPL_NOTE;?></td>
 	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
         <td class="contentfont"><table width="100%" border="0" cellpadding="3" cellspacing="2">
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
	               <td align="right"><b><?=MSG_TIME_LEFT;?></b></td>
	               <td><?=time_left($item_details['end_time']); ?></td>
	            </tr>
               <tr class="c1">
                  <td width="150" align="right"><strong>
                     <?=MSG_CURRENT_BID;?></strong></td>
                  <td><? echo $fees->display_amount($item_details['max_bid'], $item_details['currency']);?></td>
               </tr>
               <tr class="c4">
                  <td></td>
                  <td></td>
               </tr>
					<tr>
						<td width="150"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
						<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
					</tr>
            </table>
            <div align="center" class="contentfont"><?=MSG_TRACK_BID_EXPL;?></div>
   		</td>
   	</tr>
</table>
<? } ?>