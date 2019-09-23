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
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$traffic_title}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="page" value="6">
<tr height="30">
	<td width="70%" align="right"><b>{$traffic_display}</b>&nbsp; 
	<select size="1" name="cut">
        <option value="10"{$cut_10}>10</option>
        <option value="25"{$cut_25}>25</option>
        <option value="50"{$cut_50}>50</option>
        <option value="100"{$cut_100}>100</option>
	  <option value="250"{$cut_250}>250</option>
	  <option value="500"{$cut_500}>500</option>
	</select>&nbsp; <b>{$traffic_display_visitors}</b>
</td>
<td width="30%" align="right"><input type="submit" value="{$traffic_button}">&nbsp;</td></form>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%" colspan="4">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$traffic_title_details}</font></b></td>
</tr>

{if isset($traffic_logs_exist)}

<tr>
<td width="18%" bgcolor="{$lighter_cells}"><b>&nbsp;{$traffic_ip}</b></td>
<td width="54%" bgcolor="{$lighter_cells}"><b>&nbsp;{$traffic_refer}</b></td>
<td width="14%" bgcolor="{$lighter_cells}"><b>&nbsp;{$traffic_date}</b></td>
<td width="14%" bgcolor="{$lighter_cells}"><b>&nbsp;{$traffic_time}&nbsp; </b></td>
</tr>

{section name=nr loop=$traffic_results}

<tr {if $smarty.section.nr.iteration is even} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>
<td width="18%">&nbsp;{$traffic_results[nr].traffic_ip}</td>
<td width="54%">&nbsp;{$traffic_results[nr].traffic_refer}</td>
<td width="14%">&nbsp;{$traffic_results[nr].traffic_date}</td>
<td width="14%">&nbsp;{$traffic_results[nr].traffic_time}</td>

</tr>

{/section}

<tr>
<td width="100%" colspan="4" align="center" height="35" bgcolor="{$light_cells}"><b>{$traffic_bottom_tag_one} {$search_limit} {$traffic_bottom_tag_two} {$search_total} {$traffic_bottom_tag_three}</b></td>
</tr>

{else}

<tr>
<td width="100%" bgcolor="{$lighter_cells}">&nbsp;{$traffic_none}<BR /><BR /></td>
</tr>

{/if}

</table>
</td>
</tr>
</table>

<BR />
