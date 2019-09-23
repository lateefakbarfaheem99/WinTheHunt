{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($commission_group_chosen)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}" colspan="5">&nbsp;<b><font color="{$section_head_txt}">{$commission_group_name}</font></b></td>
</tr>

{if isset($commission_results_exist)}

<tr>
<td width="15%" bgcolor="{$lighter_cells}"><b>&nbsp;{$details_date}</b></td>
<td width="35%" bgcolor="{$lighter_cells}"><b>&nbsp;{$details_status}</b></td>
<td width="20%" bgcolor="{$lighter_cells}"><b>&nbsp;{$sub_tracking_id}</b></td>
<td width="15%" bgcolor="{$lighter_cells}"><b>&nbsp;{$details_commission}</b></td>
<td width="15%" bgcolor="{$lighter_cells}" align="right"><b>{$details_details}&nbsp; </b></td>
</tr>

{section name=nr loop=$commission_group_results}

<tr {if $smarty.section.nr.iteration is even} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>
<td width="15%">&nbsp;{$commission_group_results[nr].commission_results_date}</td>
<td width="35%">&nbsp;{$commission_group_results[nr].commission_results_type}</td>
<td width="20%">&nbsp;{$commission_group_results[nr].commission_results_sub_id}</td>
<td width="15%">&nbsp;{$cur_sym}{$commission_group_results[nr].commission_results_amount} {$currency}</td>
<td width="15%" align="right"><a href=account.php?page=22&type={$commission_group_results[nr].commission_results_record_type}&id={$commission_group_results[nr].commission_results_record_id}>{$details_details}</a>&nbsp; </td>
</tr>

{/section}

{else}

<tr>
<td width="100%" bgcolor="{$lighter_cells}">&nbsp;{$details_none}<BR /><BR /></td>
</tr>

{/if}

</table>
</td>
</tr>
</table>

{else}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$details_no_group}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center"><BR /><BR /><b>{$details_choose}</b><BR /><BR /><BR /></td>
</tr>
</table>
</td>
</tr>
</table>

{/if}

<BR />
