<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<table width="100%" border="0" cellspacing="3" cellpadding="3" class="fside">
   <form action="fees_management.php" method="post">
      <input type="hidden" name="category_id" value="<?=$category_id;?>">
      <input type="hidden" name="fee_column" value="<?=$fee_column;?>">
      <input type="hidden" name="fee_type" value="<?=$fee_type;?>">
      <input type="hidden" name="operation" value="submit" />
      <input type="hidden" name="tiers" value="1" />
      <tr class="c3">
         <td colspan="5"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b><?=$fee_box_title;?></b></td>
      </tr>
      <? if ($fee_column == 'endauction' || $fee_column == 'reverse_endauction') { ?>
      <tr class="c2">
         <td><?=AMSG_ENDAUCTION_FEE_APPLIES;?></td>
         <td colspan="4"><input type="radio" name="value" value="s" <? echo ($fee['endauction_fee_applies'] == 's') ? 'checked' : '';?>> <?=GMSG_SELLER;?>
         	<input type="radio" name="value" value="b" <? echo ($fee['endauction_fee_applies'] == 'b') ? 'checked' : '';?>> <?=GMSG_BUYER;?>
         </td>
      </tr>
      <tr class="c2">
         <td><?=AMSG_CALCULATION_TYPE;?></td>
         <td colspan="4"><input type="radio" name="endauction_calc_type" value="0" <? echo ($fee['endauction_calc_type'] == '0') ? 'checked' : '';?>> <?=GMSG_STANDARD;?>
         	<input type="radio" name="endauction_calc_type" value="1" <? echo ($fee['endauction_calc_type'] == '1') ? 'checked' : '';?>> <?=GMSG_PROGRESSIVE;?>
         </td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain" colspan="4"><?=AMSG_CALCULATION_TYPE_EXPL;?></td>
      </tr>
      <? } ?>
      <tr class="c4">
         <td width="120"><?=GMSG_FROM;?> [ <?=$setts['currency'];?> ]</td>
         <td width="120"><?=GMSG_TO;?> [ <?=$setts['currency'];?> ]</td>
         <td width="120"><?=GMSG_AMOUNT;?> [ <?=$setts['currency'];?> ]</td>
         <td><?=GMSG_FEE_TYPE;?></td>
         <td width="70" align="center"><?=AMSG_DELETE;?></td>
      </tr>
		<?=$fees_tiers_content;?>
      <tr class="c4">
         <td><?=AMSG_ADD_TIER;?></td>
         <td colspan="4">&nbsp;</td>
      </tr>
      <tr class="c1">
         <td><input name="new_fee_from" type="text" id="new_fee_from" size="9"></td>
         <td><input name="new_fee_to" type="text" id="new_fee_to" size="9"></td>
         <td><input name="new_fee_amount" type="text" id="new_fee_amount" size="9"></td>
         <td><select name="new_calc_type" id="new_calc_type">
               <option value="flat" selected><?=GMSG_FLAT;?></option>
               <option value="percent"><?=GMSG_PERCENT;?></option>
            </select></td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td colspan="5" align="center"><input type="submit" name="form_submit_fee" value="<?=AMSG_SAVE_CHANGES;?>"></td>
      </tr>
   </form>
</table>
