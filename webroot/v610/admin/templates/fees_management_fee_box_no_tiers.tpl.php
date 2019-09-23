<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table width="100%" border="0" cellspacing="3" cellpadding="3" class="border">
   <form action="fees_management.php" method="get">
      <input type="hidden" name="category_id" value="<?=$category_id;?>">
      <input type="hidden" name="fee_column" value="<?=$fee_column;?>">
      <input type="hidden" name="fee_type" value="<?=$fee_type;?>">
		<input type="hidden" name="operation" value="submit" />
      <tr class="c3">
         <td colspan="2" align="center"><?=$fee_box_title;?></td>
      </tr>
      <tr class="c2">
         <td width="150"><?=GMSG_FEE_AMOUNT;?></td>
         <td>
         	<? if ($fee_column == 'durations_fee') { ?>
         	<?=duration_fees_list($fee[$fee_column]); ?>
         	<? } else { ?>
         	<? echo ($fee_column != 'relist_fee_reduction' && $fee_column != 'swap_fee') ? $setts['currency'] : '';?>
            <input name="value" type="text" id="value" value="<?=$fee[$fee_column];?>" size="12">
            <? echo ($fee_column == 'relist_fee_reduction') ? '%' : '';?>
            <? if ($fee_column == 'swap_fee') { ?>
            <select name="swap_fee_calc_type" id="swap_fee_calc_type">
               <option value="flat" selected><?=$setts['currency'];?> (<?=GMSG_FLAT;?>)</option>
               <option value="percent" <? echo ($fee['swap_fee_calc_type'] == 'percent') ? 'selected' : ''; ?>>% (<?=GMSG_PERCENT;?>)</option>
            </select>
            <? } ?>
            <? } ?>
         </td>
      </tr>
      <tr>
         <td></td>
         <td><?=$fee_description;?></td>
      </tr>
      <? if ($fee_column == 'picture_fee') { ?>
      <tr class="c2">
         <td width="150"><?=AMSG_FREE_IMAGES;?></td>
         <td><input name="free_images" type="text" id="free_images" value="<?=$fee['free_images'];?>" size="6"></td>
      </tr>
      <tr>
         <td></td>
         <td><?=AMSG_FREE_IMAGES_EXPL;?></td>
      </tr>
      <? } ?>
      <? if ($fee_column == 'video_fee') { ?>
      <tr class="c2">
         <td width="150"><?=AMSG_FREE_MEDIA;?></td>
         <td><input name="free_media" type="text" id="free_media" value="<?=$fee['free_media'];?>" size="6"></td>
      </tr>
      <tr>
         <td></td>
         <td><?=AMSG_FREE_MEDIA_EXPL;?></td>
      </tr>
      <? } ?>
      <tr class="c3">
         <td colspan="2" align="center"><input type="submit" name="form_submit_fee" value="<?=AMSG_SAVE_CHANGES;?>"></td>
      </tr>
   </form>
</table>
