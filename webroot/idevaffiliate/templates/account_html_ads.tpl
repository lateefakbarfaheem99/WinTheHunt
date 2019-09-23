{if isset($one_click_delivery)}

{section name=nr loop=$html_link_results}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group}: {$html_link_results[nr].html_group_name}</b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2" height="20">
<b>{$html_name}</b>: {$html_link_results[nr].html_link_name}<BR />
<b>{$marketing_target_url}</b>: <a href="{$html_link_results[nr].html_target_url}" target="_blank">{$html_link_results[nr].html_target_url}</a><BR /><BR />
<a href="{$base_url}/adview.php?id={$html_link_results[nr].html_link_id}" target="_blank">{$html_view_link}</a><BR />
{$marketing_source_code}<BR />
<textarea rows="3" cols="56">{$html_link_results[nr].html_link_url}</textarea><BR /><BR />
</td>
</tr>
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

<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$menu_html_links}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="page" value="23">
<tr height="30">
<td width="22%" align="right"><b>{$marketing_group_title}:&nbsp;&nbsp;</b></td>
<td width="43%">
<select size="1" name="html_picked">
{section name=nr loop=$htmlad_results}
<option value="{$htmlad_results[nr].htmlad_group_id}">{$htmlad_results[nr].htmlad_group_name}</option>
{/section}
</select>
</td>
<td width="35%" align="right"><input type="submit" value="{$marketing_button} {$menu_html_links}">&nbsp;</td></form>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{if isset($html_group_chosen)}

<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group_title}:</font> <font color="{$red_text}">{$html_chosen_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">

{section name=nr loop=$html_link_results}
{literal}
<script type="text/javascript">
function openpopup(popurl){
var winpops=window.open(popurl,"","width=100%,height=100%,directories,status,scrollbars,resizable") }
</script>
{/literal}

<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2" height="20">
<b>{$html_link_results[nr].html_link_name}</b><BR />
<a href="{$base_url}/adview.php?id={$html_link_results[nr].html_link_id}" target="_blank">{$html_view_link}</a><BR /><BR />
{$marketing_source_code}<BR />
<textarea rows="3" cols="56">{$html_link_results[nr].html_link_url}</textarea><BR /><BR />
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

<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
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