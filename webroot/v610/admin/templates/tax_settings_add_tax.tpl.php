<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript" src="../includes/main_functions.js" type="text/javascript"></script>
<script language="JavaScript">
function submit_form(form_name) {
	SelectOption(form_name.countries_id);
	SelectOption(form_name.seller_countries_id);
}
</script>

<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form action="tax_settings.php" method="post" name="form_tax" onSubmit="submit_form(form_tax)">
      <input type="hidden" name="do" value="<?=$do;?>" />
      <input type="hidden" name="tax_id" value="<?=$tax_details['tax_id'];?>" />
      <input type="hidden" name="operation" value="submit" />
      <tr>
         <td colspan="2" class="c4"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <?=$manage_box_title;?></td>
      </tr>
      <tr class="c2">
         <td nowrap><b><?=AMSG_TAX_NAME;?></b></td>
         <td width="100%"><input type="text" name="tax_name" value="<?=$tax_details['tax_name'];?>" size="50" /></td>
      </tr>
      <tr class="c1">
         <td nowrap><b><?=AMSG_TAX_RATE;?></b></td>
         <td width="100%"><input type="text" name="amount" value="<?=$tax_details['amount'];?>" size="10" />
            %</td>
      </tr>
      <tr class="c2">
         <td nowrap><b><?=AMSG_APPLIED_BY;?></b></td>
         <td width="100%"><table width="100%" border="0" cellspacing="2" cellpadding="2">
               <tr>
                  <td width="45%">[ <?=AMSG_ALL_COUNTRIES;?> ] </td>
                  <td width="10%">&nbsp;</td>
                  <td width="45%">[ <?=AMSG_SELECTED_COUNTRIES;?> ] </td>
               </tr>
               <tr>
                  <td><?=$all_countries_table_seller;?></td>
                  <td align="center"><input type="button" name="seller_Disable" value=" -&gt; " style="width: 50px;" onclick="MoveOption(this.form.seller_all_countries, this.form.seller_countries_id)" />
                     <br />
                     <br />
                     <input type="button" name="seller_Enable" value=" &lt;- " style="width: 50px;" onclick="MoveOption(this.form.seller_countries_id, this.form.seller_all_countries)" /></td>
                  <td><?=$selected_countries_table_seller;?></td>
               </tr>
            </table></td>
      </tr>
      <tr class="c2">
         <td nowrap><b><?=AMSG_APPLIES_TO;?></b></td>
         <td width="100%"><table width="100%" border="0" cellspacing="2" cellpadding="2">
               <tr>
                  <td width="45%">[ <?=AMSG_ALL_COUNTRIES;?> ] </td>
                  <td width="10%">&nbsp;</td>
                  <td width="45%">[ <?=AMSG_SELECTED_COUNTRIES;?> ] </td>
               </tr>
               <tr>
                  <td><?=$all_countries_table;?></td>
                  <td align="center"><input type="button" name="Disable" value=" -&gt; " style="width: 50px;" onclick="MoveOption(this.form.all_countries, this.form.countries_id)" />
                     <br />
                     <br />
                     <input type="button" name="Enable" value=" &lt;- " style="width: 50px;" onclick="MoveOption(this.form.countries_id, this.form.all_countries)" /></td>
                  <td><?=$selected_countries_table;?></td>
               </tr>
            </table></td>
      </tr>
      <tr class="c1">
         <td nowrap><b><?=AMSG_USERS_ALLOWED_TO_CHARGE_TAX;?></b></td>
         <td width="100%"><?=$tax_settings_allowed_users_box;?></td>
      </tr>
      <tr>
         <td colspan="2" align="center"><input type="submit" name="form_tax_save" value="<?=AMSG_SAVE_CHANGES;?>">
         </td>
      </tr>
   </form>
</table>