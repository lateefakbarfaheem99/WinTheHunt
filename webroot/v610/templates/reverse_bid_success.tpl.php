<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$bidding_success_message;?>
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
                     <?=MSG_YOUR_BID;?></strong></td>
                  <td><? echo $fees->display_amount($max_bid, $item_details['currency']);?></td>
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
   		</td>
   	</tr>
</table>
<?=$reverse_bid_output;?>