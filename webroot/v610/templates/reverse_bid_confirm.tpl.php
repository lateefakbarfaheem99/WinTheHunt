<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <form action="reverse_bid.php" method="post">
      <input type="hidden" name="action" value="<?=$action;?>">
      <input type="hidden" name="reverse_id" value="<?=$item_details['reverse_id'];?>">
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
	            <tr class="c2">
	               <td align="right"><strong><?=MSG_BUDGET;?></strong></td>
	               <td><strong><?=$fees->budget_output($item_details['budget_id'], null, $item_details['currency']); ?></strong></td>
	            </tr>
               <tr class="c1">
                  <td width="150" align="right"><strong>
                     <?=MSG_YOUR_BID;?></strong></td>
                  <td><?=$item_details['currency'];?> <input name="max_bid" type="text" id="max_bid" value="<?=$max_bid;?>" size="15" onkeypress="return noenter()"></td>
               </tr>
               <tr class="c1">
                  <td width="150" align="right"><strong>
                     <?=GMSG_DESCRIPTION;?></strong></td>
                  <td><textarea name="description" style="width: 100%; height: 120px;"><?=$description;?></textarea></td>
               </tr>
               <tr>
               	<td></td>
               	<td><?=MSG_RB_DESCRIPTION_EXPL;?></td>
               </tr>
               <tr class="c1">
                  <td width="150" align="right"><strong>
                     <?=MSG_DELIVERY_WITHIN;?></strong></td>
                  <td><input name="delivery_days" type="text" id="delivery_days" value="<?=$delivery_days;?>" size="8" onkeypress="return noenter()"> <?=GMSG_DAYS;?></td>
               </tr>               
               <tr>
               	<td></td>
               	<td><?=MSG_RB_DELIVERY_EXPL;?></td>
               </tr>
				   <? if ($can_add_tax) { ?>
				   <tr class="c1">
				      <td width="150" align="right"><?=MSG_ADD_TAX;?></td>
				      <td colspan="2"><input type="checkbox" name="apply_tax" value="1" <? echo ($item_details['apply_tax']==1) ? 'checked' : ''; ?>/></td>
				   </tr>
				   <tr class="reguser">
				      <td>&nbsp;</td>
				      <td colspan="2"><?=MSG_ADD_TAX_REVERSE_BID_EXPL;?></td>
				   </tr>
				   <? } ?>
					<tr>
						<td width="150"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
						<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
					</tr>
            </table>
            <table width="100%" border="0" cellpadding="4" cellspacing="2" class="errormessage">
               <tr>
                  <td width="150" align="center"><input name="form_place_bid" type="submit" id="form_place_bid" value="<?=MSG_PLACE_BID;?>">
                  </td>
                  <td></td>
               </tr>
            </table>
   		</td>
   	</tr>
   </form>
</table>
