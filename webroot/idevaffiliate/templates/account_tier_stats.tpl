{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($tier_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" colspan="3" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$tier_stats_title}</font></b></td>
</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$tier_stats_accounts}</td>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$number_of_tier_accounts}</td>
<td width="35%" align="center" rowspan="3" bgcolor="{$white_back}"><a href="account.php?page=12"><font color="{$page_links}">{$tier_stats_grab_link}</font></a></td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}">&nbsp;{$tier_stats_payout}</td>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$tier_payout_amount}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$tier_stats_earnings}</td>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;<font color="{$red_text}">{$cur_sym}{$tier_summary_total_payments} {$currency}</font></td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$tier_stats_aff_title}</font></b></td>
</tr>

{if isset($tier_accounts_exist)}

<tr>
<td width="21%" bgcolor="{$lighter_cells}">&nbsp;<b>{$tier_stats_username}</b></td>
<td width="27%" bgcolor="{$lighter_cells}" align="right"><b>{$tier_stats_current}</b>&nbsp; </td>
<td width="25%" bgcolor="{$lighter_cells}" align="right"><b>{$tier_stats_previous}</b>&nbsp; </td>
<td width="27%" bgcolor="{$lighter_cells}" align="right"><b>{$tier_stats_totals}</b>&nbsp; </td>
</tr>

{section name=nr loop=$tier_results}

{if isset($display_tier_contact_info)}

<tr {if $smarty.section.nr.iteration is even} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>
<td width="20%">&nbsp;<a href="mailto:{$tier_results[nr].tier_email}" title="header=[{$tier_results[nr].tier_name}] body=[{$tier_results[nr].tier_email}<BR>{$tier_results[nr].tier_url}]">{$tier_results[nr].tier_username}</a></td>
<td width="30%" align="right">{$cur_sym}{$tier_results[nr].tier_current_payments} {$currency}&nbsp; </td>
<td width="25%" align="right">{$cur_sym}{$tier_results[nr].tier_archived_payments} {$currency}&nbsp; </td>
<td width="25%" align="right"><b>{$cur_sym}{$tier_results[nr].tier_total_payments} {$currency}&nbsp; </b></td>
</tr>

{else}

<tr {if $smarty.section.nr.iteration is even} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>
<td width="20%">&nbsp;{$tier_results[nr].tier_username}</td>
<td width="30%" align="right">{$cur_sym}{$tier_results[nr].tier_current_payments} {$currency}&nbsp; </td>
<td width="25%" align="right">{$cur_sym}{$tier_results[nr].tier_archived_payments} {$currency}&nbsp; </td>
<td width="25%" align="right"><b>{$cur_sym}{$tier_results[nr].tier_total_payments} {$currency}&nbsp; </b></td>
</tr>

{/if}

{/section}

<tr>
<td width="25%" bgcolor="{$light_cells}">&nbsp;<b>{$tier_stats_totals}</b></td>
<td width="25%" bgcolor="{$light_cells}" align="right"><b>{$cur_sym}{$tier_summary_current_payments} {$currency}</b>&nbsp; </td>
<td width="25%" bgcolor="{$light_cells}" align="right"><b>{$cur_sym}{$tier_summary_archived_payments} {$currency}</b>&nbsp; </td>
<td width="25%" bgcolor="{$light_cells}" align="right"><font color="{$red_text}"><b>{$cur_sym}{$tier_summary_total_payments} {$currency}</b></font>&nbsp; </td>
</tr>

{else}

<tr>
<td width="100%" bgcolor="{$lighter_cells}">&nbsp;{$tier_stats_none}<BR /><BR /></td>
</tr>

{/if}

</table>
</td>
</tr>
</table>

{/if}

<BR />
