<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="JavaScript">
function submit_form(form_name) {
	form_name.operation.value = '';
	form_name.submit();
}
</script>

<table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
   <form action="table_user_accounts.php" method="post" name="form_user_account">
      <input type="hidden" name="do" value="<?=$do;?>" />
      <input type="hidden" name="account_id" value="<?=$account_details['account_id'];?>" />
      <input type="hidden" name="operation" value="submit" />
      <tr>
         <td colspan="2" align="center" class="c4"><?=$manage_box_title;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_NAME;?></td>
         <td width="100%"><input type="text" name="name" value="<?=$account_details['name'];?>" size="50" /></td>
      </tr>
      <tr class="c2">
         <td nowrap><?=GMSG_DESCRIPTION;?></td>
         <td width="100%"><textarea name="description" style=" width: 350px; height: 75px;"><?=$account_details['description'];?></textarea></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_PRICE;?></td>
         <td><?=$setts['currency'];?>
            <input name="price" type="text" id="price" size="8" value="<?=$account_details['price'];?>" /></td>
      </tr>
      <tr class="c2">
         <td nowrap><?=GMSG_RECURRING;?></td>
         <td><input name="recurring_days" type="text" id="recurring_days" value="<?=$account_details['recurring_days'];?>" size="8" />
            <?=GMSG_DAYS;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_FEES_REDUCTION;?> </td>
         <td><input type="text" name="fees_reduction" size="8" value="<?=$account_details['fees_reduction'];?>" />
            %</td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_REDUCTION_DESC;?> </td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_CUSTOM_FEES;?> </td>
         <td><input name="fees_custom" type="radio" value="1" checked />
            <?=GMSG_YES;?>
            <input name="fees_custom" type="radio" value="0" <? echo ($account_details['fees_custom']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_CUSTOM_FEES_DESC;?> </td>
      </tr>
      <tr class="c3">
         <td width="100%" colspan="2"><?=AMSG_PROFILE_ADS_SETTS;?>
            <?=$enable_profile_ad_status_message;?></td>
      </tr>
      <tr class="c1">
         <td nowrap> <?=GMSG_UPLOAD_IMAGES;?> </td>
         <td><input name="pa_upl_pic" type="radio" value="1" checked />
            <?=GMSG_YES;?>
            <input name="pa_upl_pic" type="radio" value="0" <? echo ($account_details['pa_upl_pic']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_PROFILE_UPL_IMG_DESC;?> </td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_SEND_MESSAGES;?></td>
         <td><input name="pa_send_msg" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="pa_send_msg" type="radio" value="0" <? echo ($account_details['pa_send_msg']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_PROFILE_SEND_MESSAGES_DESC;?></td>
      </tr>
      <tr class="c3">
         <td width="100%" colspan="2"><?=AMSG_STANDARDS_ADS_SETTS;?>
            <?=$enable_standard_ad_status_message;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_ENABLED;?></td>
         <td><input name="sa_enabled" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="sa_enabled" type="radio" value="0" <? echo ($account_details['sa_enabled']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_SA_ENABLED_DESC;?></td>
      </tr>
      <tr class="c1">
         <td nowrap> <?=GMSG_UPLOAD_IMAGES;?> </td>
         <td><input name="sa_upl_pic" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="sa_upl_pic" type="radio" value="0" <? echo ($account_details['sa_upl_pic']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_SA_UPL_PIC_DESC;?> </td>
      </tr>
      <tr class="c1">
         <td nowrap> <?=GMSG_HTML;?> </td>
         <td><input name="sa_html" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="sa_html" type="radio" value="0" <? echo ($account_details['sa_html']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_SA_HTML_DESC;?> </td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_FREE_ADS;?> </td>
         <td><input type="text" name="sa_free_ads" size="8" value="<?=$account_details['sa_free_ads'];?>" /></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_SA_FREE_ADS_DESC;?></td>
      </tr>
      <tr class="c3">
         <td width="100%" colspan="2"><?=AMSG_TRADE_ADS_SETTS;?>
            <?=$enable_trade_ad_status_message;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_ENABLED;?></td>
         <td><input name="ta_enabled" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="ta_enabled" type="radio" value="0" <? echo ($account_details['ta_enabled']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_TA_ENABLED_DESC;?></td>
      </tr>
      <tr class="c1">
         <td nowrap> <?=GMSG_UPLOAD_IMAGES;?> </td>
         <td><input name="ta_upl_pic" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="ta_upl_pic" type="radio" value="0" <? echo ($account_details['ta_upl_pic']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_TA_UPL_PIC_DESC;?></td>
      </tr>
      <tr class="c1">
         <td nowrap> <?=GMSG_HTML;?> </td>
         <td><input name="ta_html" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="ta_html" type="radio" value="0" <? echo ($account_details['ta_html']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_TA_HTML_DESC;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_FREE_ADS;?> </td>
         <td><input type="text" name="ta_free_ads" size="8" value="<?=$account_details['ta_free_ads'];?>" /></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_TA_FREE_ADS_DESC;?></td>
      </tr>
      <tr class="c3">
         <td width="100%" colspan="2"><?=AMSG_WANTED_ADS_SETTS;?>
            <?=$enable_wanted_ad_status_message;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_ENABLED;?></td>
         <td><input name="wa_enabled" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="wa_enabled" type="radio" value="0" <? echo ($account_details['wa_enabled']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_WA_ENABLED_DESC;?></td>
      </tr>
      <tr class="c1">
         <td nowrap> <?=GMSG_UPLOAD_IMAGES;?> </td>
         <td><input name="wa_upl_pic" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="wa_upl_pic" type="radio" value="0" <? echo ($account_details['wa_upl_pic']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_WA_UPL_PIC_DESC;?></td>
      </tr>
      <tr class="c1">
         <td nowrap> <?=GMSG_HTML;?> </td>
         <td><input name="wa_html" type="radio" value="1" checked="checked" />
            <?=GMSG_YES;?>
            <input name="wa_html" type="radio" value="0" <? echo ($account_details['wa_html']==0) ? 'checked' : '';?> />
            <?=GMSG_NO;?></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_WA_HTML_DESC;?></td>
      </tr>
      <tr class="c1">
         <td nowrap><?=GMSG_FREE_ADS;?> </td>
         <td><input type="text" name="wa_free_ads" size="8" value="<?=$account_details['wa_free_ads'];?>" /></td>
      </tr>
      <tr>
         <td nowrap>&nbsp;</td>
         <td><?=AMSG_WA_FREE_ADS_DESC;?></td>
      </tr>
      <tr>
         <td colspan="2" align="center" class="c3"><input type="submit" name="form_add_account_type" value="<?=AMSG_SAVE_CHANGES;?>">
         </td>
      </tr>
   </form>
</table>
<br />
