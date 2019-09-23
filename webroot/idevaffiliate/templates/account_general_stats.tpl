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
<td width="100%" bgcolor="{$table_top}" colspan="3">&nbsp;<b><font color="{$section_head_txt}">{$general_title}</font></b></td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}">&nbsp;{$general_transactions}</td>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$current_transactions}</td>
<td width="35%" align="center" rowspan="5" bgcolor="{$white_back}">

{if isset($traffic_exists)}
{php}
	include_once("templates/charts/quickstats-gen.php");
	echo InsertChart ( "templates/charts/charts.swf", "templates/charts/charts_library", "templates/charts/quickstats.php" );
{/php}
{/if}

</td>

<!-- <td width="35%" align="center" rowspan="5" bgcolor="{$white_back}"><img border="0" src="images/earnings.gif" width="32" height="32"><BR /><b>{$general_earnings_to_date}</b><br /><font color="{$red_text}">{$total_amount_earned}</font><br /><a href="account.php?page=3"><font color="{$page_links}">{$general_history_link}</font></a></td> -->

</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$general_standard_earnings}</td>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$current_approved_commissions}
</td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}">&nbsp;{$account_second_tier}</td>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$current_tier_commissions}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$account_recurring}</td>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$current_recurring_commissions}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}"><b>&nbsp;{$general_current_earnings}</b></td>
<td width="30%" bgcolor="{$white_back}"><b>&nbsp;{$current_total_commissions}</b></td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}" colspan="3">&nbsp;<b><font color="{$section_head_txt}">{$general_traffic_title}</font></b></td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}">&nbsp;{$general_traffic_visitors}</td>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$hin}</td>
<td width="35%" align="center" rowspan="4" bgcolor="{$white_back}">{$general_traffic_info}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$general_traffic_unique}</td>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$unchits}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}">&nbsp;{$general_traffic_sales}</td>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$salenum}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$general_traffic_ratio}</td>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$perc}%</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="35%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$general_traffic_pay_type}</font></b></td>
<td width="65%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$general_traffic_pay_level}</font></b></td>
</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$current_style}</td>
<td width="65%" bgcolor="{$lighter_cells}">&nbsp;{$current_level}</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{include file='file:account_notes.tpl'}
