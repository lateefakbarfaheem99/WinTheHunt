{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($recurring_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" colspan="5" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$recurring_title}</font></b></td>
</tr>

{if isset($recurring_commissions_exist)}

<tr>
<td width="20%" bgcolor="{$lighter_cells}"><b>&nbsp;{$recurring_date}</b></td>
<td width="20%" bgcolor="{$lighter_cells}"><b>&nbsp;{$recurring_status}</b></td>
<td width="15%" bgcolor="{$lighter_cells}"><b>&nbsp;{$recurring_payout}</b></td>
<td width="25%" bgcolor="{$lighter_cells}"><b>&nbsp;{$sub_tracking_id}</b></td>
<td width="20%" bgcolor="{$lighter_cells}" align="right"><b>{$recurring_amount}&nbsp; </b></td>
</tr>

{section name=nr loop=$recurring_list_results}

<tr {if $smarty.section.nr.iteration is even} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>
<td width="20%">&nbsp;{$recurring_list_results[nr].recurring_results_date}</td>
<td width="20%">&nbsp;{$recurring_every} {$recurring_list_results[nr].recurring_results_duration} {$recurring_days}</td>
<td width="15%">&nbsp;{$recurring_in} {$recurring_list_results[nr].recurring_results_next} {$recurring_days}</td>
<td width="25%">&nbsp;{$recurring_list_results[nr].recurring_results_subid}</td>
<td width="20%" align="right">{$cur_sym}{$recurring_list_results[nr].recurring_results_amount} {$currency}&nbsp; </td>
</tr>

{/section}

<tr>
<td width="50%" colspan="4" bgcolor="{$light_cells}"></td>
<td width="20%" bgcolor="{$light_cells}" align="right"><font color="{$red_text}"><b>{$cur_sym}{$recurring_total_amount} {$currency}</b></font>&nbsp; </td>
</tr>

{else}

<tr>
<td width="100%" bgcolor="{$lighter_cells}">&nbsp;{$recurring_none}<BR /><BR /></td>
</tr>

{/if}

</table>
</td>
</tr>
</table>

{/if}

<BR />
