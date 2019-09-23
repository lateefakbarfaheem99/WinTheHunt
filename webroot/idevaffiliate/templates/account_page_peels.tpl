{if isset($one_click_delivery)}

{section name=nr loop=$peel_link_results}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group}: {$peel_link_results[nr].peel_group_name}</b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">

{literal}
<script type="text/javascript">
function openpopup(popurl){
var winpops=window.open(popurl,"","width=100%,height=100%,directories,status,scrollbars,resizable") }
</script>
{/literal}

<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" colspan="2" height="20">

<b>{$peels_title}</b>: {$peel_link_results[nr].peel_link_name}<BR />
<b>{$peels_description}</b>: {$peel_link_results[nr].peel_description}<BR />
<b>{$marketing_target_url}</b>: <a href="{$peel_link_results[nr].peel_target_url}" target="_blank">{$peel_link_results[nr].peel_target_url}</a><BR /><BR />
<a href="{$peel_link_results[nr].peel_sample_url}" title="{$peels_title}: {$peel_link_results[nr].peel_link_name}" rel="gb_page_center[650, 650]">{$peels_view}</a>
<BR />{$marketing_source_code}<BR />
<textarea rows="3" cols="56"><script language="JavaScript1.2" type="text/javascript" src="{$peel_link_results[nr].peel_link_url}"></script></textarea>
<BR /><BR />
</td></tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{/section}

{else}


<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">

<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$menu_page_peels}</font></b></td>
</tr>

<tr>
<td width="100%" bgcolor="{$lighter_cells}">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="page" value="37">
<tr height="30">
<td width="22%" align="right"><b>{$marketing_group_title}:&nbsp;&nbsp;</b></td>
<td width="43%">
<select size="1" name="peels_picked">
{section name=nr loop=$peels_results}
<option value="{$peels_results[nr].peels_group_id}">{$peels_results[nr].peels_group_name}</option>
{/section}
</select>
</td>
<td width="35%" align="right"><input type="submit" value="{$marketing_button} {$menu_page_peels}">&nbsp;</td></form>
</tr>

</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{if isset($peels_group_chosen)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group_title}:</font> <font color="{$red_text}">{$peels_chosen_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">

{section name=nr loop=$peels_link_results}

<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2" height="20">

<b>{$peels_title}</b>: {$peels_link_results[nr].peels_link_name}<BR />
<b>{$peels_description}</b>: {$peels_link_results[nr].peels_description}<BR />
<b>{$marketing_target_url}</b>: <a href="{$peels_link_results[nr].peels_target_url}" target="_blank">{$peels_link_results[nr].peels_target_url}</a><BR /><BR />
<a href="{$peels_link_results[nr].peels_sample_url}" title="{$peels_title}: {$peels_link_results[nr].peels_link_name}" rel="gb_page_center[650, 650]">{$peels_view}</a>
<br />{$marketing_source_code}<BR />
<textarea rows="3" cols="56"><script language="JavaScript1.2" type="text/javascript" src="{$peels_link_results[nr].peels_link_url}"></script></textarea><BR /><BR />
<hr noshade color="{$table_top}" size="1">
</td>
</tr>
</table>

{/section}

</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{else}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_no_group}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center"><BR /><BR /><b>{$marketing_choose}</b><BR /><BR /><font color="{$red_text}">{$marketing_notice}</font><BR /><BR /><BR /></td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{/if}

{/if}
