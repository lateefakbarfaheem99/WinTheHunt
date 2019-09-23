{if isset($one_click_delivery)}

{section name=nr loop=$textlink_link_results}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group}: {$textlink_link_results[nr].textlink_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center"><BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2" height="20">
<b>{$textlink_name}</b>: {$textlink_link_results[nr].textlink_link_text}<BR />
<b>{$marketing_target_url}</b>: <a href="{$textlink_link_results[nr].textlink_target_url}" target="_blank">{$textlink_link_results[nr].textlink_target_url}</a><BR /><BR />
{$marketing_source_code}<BR />
<textarea rows="3" cols="56"><a href="{$textlink_link_results[nr].textlink_link_url}" target="_blank">{$textlink_link_results[nr].textlink_link_text}</a></textarea><BR /><BR />
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
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$menu_text_links}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="page" value="9">
<tr height="30">
<td width="22%" align="right"><b>{$marketing_group_title}:&nbsp;&nbsp;</b></td>
<td width="43%">
<select size="1" name="textlinks_picked">
{section name=nr loop=$textlink_results}
<option value="{$textlink_results[nr].textlink_group_id}">{$textlink_results[nr].textlink_group_name}</option>
{/section}
</select>
</td>
<td width="35%" align="right"><input type="submit" value="{$links_button} {$menu_text_links}">&nbsp;</td></form>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{if isset($textlink_group_chosen)}


<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group_title}:</font> <font color="{$red_text}">{$textlink_chosen_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">

{section name=nr loop=$textlink_link_results}

<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2" height="20">
<b>{$textlink_name}</b>: {$textlink_link_results[nr].textlink_link_text}<BR />
<b>{$marketing_target_url}</b>: <a href="{$textlink_link_results[nr].textlink_target_url}" target="_blank">{$textlink_link_results[nr].textlink_target_url}</a><BR /><BR />
{$marketing_source_code}<BR />
<textarea rows="3" cols="56"><a href="{$textlink_link_results[nr].textlink_link_url}" target="_blank">{$textlink_link_results[nr].textlink_link_text}</a></textarea><BR /><BR />
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



