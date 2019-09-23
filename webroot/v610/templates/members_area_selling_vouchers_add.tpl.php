<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c7" colspan="2"><b>
         <?=MSG_ADD_EDIT_VOUCHER;?>
         </b></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <form action="members_area.php" method="post">
      <input type="hidden" name="do" value="<?=$do;?>" />
      <input type="hidden" name="page" value="selling" />
      <input type="hidden" name="section" value="vouchers" />
      <input type="hidden" name="voucher_id" value="<?=$voucher_details['voucher_id'];?>" />
      <input type="hidden" name="operation" value="submit" />
      <tr class="c1">
         <td nowrap align="right"><b><?=MSG_VOUCHER_CODE;?></b></td>
         <td width="100%"><input type="text" name="voucher_code" value="<?=$voucher_details['voucher_code'];?>" size="50" /></td>
      </tr>
	   <tr class="reguser">
	      <td>&nbsp;</td>
         <td width="100%"><?=MSG_VOUCHER_CODE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=MSG_VOUCHER_NAME;?></b></td>
         <td width="100%"><input type="text" name="voucher_name" value="<?=$voucher_details['voucher_name'];?>" size="50" /></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=MSG_VOUCHER_REDUCTION;?></b></td>
         <td width="100%"><input type="text" name="voucher_reduction" value="<?=$voucher_details['voucher_reduction'];?>" size="8" />%</td>
      </tr>
	   <tr class="reguser">
	      <td>&nbsp;</td>
         <td width="100%"><?=MSG_VOUCHER_REDUCTION_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=MSG_START_DATE;?></b></td>
         <td width="100%"><? echo ($do == 'add_voucher') ? GMSG_NOW : show_date($voucher_details['reg_date']); ?></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=GMSG_DURATION;?></b></td>
         <td width="100%"><input type="text" name="voucher_duration" value="<?=$voucher_details['voucher_duration']; ?>" size="8" /> <?=GMSG_DAYS;?></td>
      </tr>
      <? if ($do != 'add_voucher') { ?>
      <tr>
         <td nowrap></td>
         <td class="c1" width="100%"><?=GMSG_EXPIRES_ON; ?>: <b><?=show_date($voucher_details['exp_date']);?></b></td>
      </tr>
      <? } ?>
	   <tr class="reguser">
	      <td>&nbsp;</td>
         <td width="100%"><?=MSG_VOUCHER_DURATION_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=MSG_NB_OF_USES; ?></b></td>
         <td width="100%"><input type="text" name="nb_uses" value="<?=$voucher_details['nb_uses']; ?>" size="8" /></td>
      </tr>
	   <tr class="reguser">
	      <td>&nbsp;</td>
         <td width="100%"><?=MSG_NB_OF_USES_EXPL;?></td>
      </tr>
      <tr>
         <td colspan="2" align="center"><input type="submit" name="form_tax_save" value="<?=MSG_SAVE_CHANGES;?>">
         </td>
      </tr>
   </form>
</table>
<br>