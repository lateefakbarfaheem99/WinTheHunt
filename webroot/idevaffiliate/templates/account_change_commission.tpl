{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($change_commission)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}" colspan="2">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="50%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$change_comm_page_title}</font></b></td>
{if isset($commission_updated)}
<td width="50%" bgcolor="{$red_text}" align="right"><b><font color="white">{$commission_updated}</font></b>&nbsp; </td>
{else}
<td width="50%" bgcolor="{$table_top}"></td>
{/if}
</tr>
</table>
</td>
</tr>

<tr>
<td width="100%" bgcolor="{$lighter_cells}" colspan="2">
<form method="POST" action="account.php">
<input type="hidden" name="changec" value="1">
<input type="hidden" name="page" value="19">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr height="10"><td></td></tr>

<tr>
<td width="40%" align="right"><b>{$change_comm_page_curr_comm}:</b>&nbsp;&nbsp;</td>
<td width="60%">{$current_style}</td>
</tr>
<tr height="5"><td></td></tr>
<tr>
<td width="40%" align="right"><b>{$change_comm_page_curr_pay}:</b>&nbsp;&nbsp;</td>
<td width="60%">{$current_level}</td>
</tr>
<tr height="15"><td></td></tr>

{if isset($available)}

<tr height="24">
<td width="40%" align="right"><b>{$change_comm_page_new_comm}:</b>&nbsp;&nbsp;</td>
<td width="60%"><select size="1" name="type">
{if isset($type_perc)}<option value="1">{$index_table_sale}: {$bot1}%</option>{/if}
{if isset($type_flat)}<option value="2">{$index_table_sale}: {$cur_sym}{$bot2} {$currency}</option>{/if}
{if isset($type_clck)}<option value="3">{$index_table_click}: {$cur_sym}{$bot3} {$currency}</option>{/if}
</select>
</td></tr>
<tr height="15"><td></td></tr>
<tr>
<td width="100%" colspan="2" align="center"><font color="{$red_text}">{$change_comm_page_warning}</font></td>
</tr>
<tr height="15"><td></td></tr>
<tr>
<td width="100%" colspan="2" align="center"><input type="submit" value="{$change_comm_page_button}"></td></form>
</tr>
<tr height="15"><td></td></tr>

{else}

<tr>
<td width="40%" align="right"><b>{$change_comm_page_new_comm}:</b>&nbsp;&nbsp;</td>
<td width="60%"><font color="{$red_text}">{$no_styles_available}</font></td></tr>
<tr height="15"><td></td></tr>

{/if}

</table>
</td></tr>
</table>
</td>
</tr>
</table>

{/if}

<BR />
