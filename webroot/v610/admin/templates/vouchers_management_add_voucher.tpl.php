<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript" src="../includes/main_functions.js" type="text/javascript"></script>
<script language="JavaScript">
function submit_form(form_name) {
	form_name.operation.value = '';
	form_name.submit();
}
</script>

<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form action="vouchers_management.php" method="post" name="form_tax">
      <input type="hidden" name="do" value="<?=$do;?>" />
      <input type="hidden" name="voucher_id" value="<?=$voucher_details['voucher_id'];?>" />
      <input type="hidden" name="voucher_type" value="<?=$voucher_type;?>" />
      <input type="hidden" name="operation" value="submit" />
      <tr>
         <td colspan="2" class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b><?=$manage_box_title;?></b></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=AMSG_VOUCHER_CODE;?></b></td>
         <td width="100%"><input type="text" name="voucher_code" value="<?=$voucher_details['voucher_code'];?>" size="50" /></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td width="100%" class="explain" ><?=AMSG_VOUCHER_CODE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=AMSG_VOUCHER_NAME;?></b></td>
         <td width="100%"><input type="text" name="voucher_name" value="<?=$voucher_details['voucher_name'];?>" size="50" /></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=AMSG_VOUCHER_TYPE;?></b></td>
         <td width="100%"><?=$voucher_type;?></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=AMSG_VOUCHER_REDUCTION;?></b></td>
         <td width="100%"><input type="text" name="voucher_reduction" value="<? echo ($voucher_type == 'signup') ? '100' : $voucher_details['voucher_reduction'];?>" size="8" <? echo ($voucher_type == 'signup') ? 'readonly' : ''; ?> />%</td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td width="100%" class="explain" ><?=AMSG_VOUCHER_REDUCTION_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=AMSG_START_DATE;?></b></td>
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
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain" width="100%"><?=AMSG_VOUCHER_DURATION_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b><?=AMSG_NB_OF_USES; ?></b></td>
         <td width="100%"><input type="text" name="nb_uses" value="<?=$voucher_details['nb_uses']; ?>" size="8" /></td>
      </tr>
      <tr>
         <td class="explain" align="right"><img src="images/info.gif"></td>
         <td class="explain" width="100%"><?=AMSG_NB_OF_USES_EXPL;?></td>
      </tr>
      <? if ($voucher_type == 'setup') { ?>
      <tr class="c1">
         <td nowrap align="right"><b><?=AMSG_ASSIGNED_FEES; ?></b></td>
         <td width="100%"><?=$select_reduced_fees_boxes;?></td>
      </tr>
      <? } ?>
      <tr>
         <td colspan="2" align="center"><input type="submit" name="form_tax_save" value="<?=AMSG_SAVE_CHANGES;?>">
         </td>
      </tr>
   </form>
</table>