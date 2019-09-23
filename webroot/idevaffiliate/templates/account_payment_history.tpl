{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$payment_title}</font></b></td>
</tr>

{if isset($payment_history_exists)}

<tr>
<td width="25%" bgcolor="{$lighter_cells}"><b>&nbsp;{$payment_date}</b></td>
<td width="25%" bgcolor="{$lighter_cells}" align="right"><b>{$payment_commissions}</b>&nbsp; </td>
<td width="35%" bgcolor="{$lighter_cells}" align="right"><b>{$payment_amount}</b>&nbsp; </td>
<td width="15%" bgcolor="{$lighter_cells}"></td>
</tr>

{section name=nr loop=$payment_results}

<tr {if $smarty.section.nr.iteration is even} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>
<td width="25%">&nbsp;{$payment_results[nr].payment_date}</td>
<td width="25%" align="right">{$payment_results[nr].payment_total}&nbsp; </td>
<td width="35%" align="right">{$cur_sym}{$payment_results[nr].payment_amount} {$currency}&nbsp; </td>
<td width="15%" align="center"><form method="post" action="invoice.php" target="_blank">

{if $invoice_enabled}
<input type="hidden" name="stamp" value="{$payment_results[nr].payment_stamp}">
<input type="submit" value="{$invoice_button}" name="print_invoice" class="button">&nbsp; 
{/if}

</td></form>
</tr>

{/section}

<tr>
<td width="25%" height="25" bgcolor="{$light_cells}">&nbsp;<b>{$payment_totals}</b></td>
<td width="25%" height="25" bgcolor="{$light_cells}" align="right"><b>{$payments_total}</b>&nbsp; </td>
<td width="35%" height="25" bgcolor="{$light_cells}" align="right"><font color="{$red_text}"><b>{$cur_sym}{$payments_archived} {$currency}</b></font>&nbsp; </td>
<td width="15%" height="25" bgcolor="{$light_cells}"></td>
</tr>

{else}

<tr>
<td width="100%" bgcolor="{$lighter_cells}">&nbsp;{$payment_none}<BR /><BR /></td>
</tr>

{/if}

</table>
</td>
</tr>
</table>

<BR />