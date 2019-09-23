{if isset($one_click_delivery)}

{section name=nr loop=$banner_link_results}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group}: {$banner_link_results[nr].banner_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center"><BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2" height="20">
<b>{$banners_size}</b>: {$banner_link_results[nr].banner_size_1} x {$banner_link_results[nr].banner_size_2}<BR />
<b>{$banners_description}</b>: {$banner_link_results[nr].banner_description}<BR />
<b>{$marketing_target_url}</b>: <a href="{$banner_link_results[nr].banner_target_url}" target="_blank">{$banner_link_results[nr].banner_target_url}</a><BR /><BR />
{$banner_link_results[nr].banner_display}<BR /><BR />{$marketing_source_code}<BR />
<textarea rows="3" cols="56">{$banner_link_results[nr].banner_code}</textarea><BR /><BR />
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



<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">

<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$menu_banners}</font></b></td>
</tr>

<tr>
<td width="100%" bgcolor="{$lighter_cells}">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="page" value="7">
<tr height="30">
<td width="22%" align="right"><b>{$marketing_group_title}:&nbsp;&nbsp;</b></td>
<td width="43%">
<select size="1" name="banner_picked">
{section name=nr loop=$banner_results}
<option value="{$banner_results[nr].banner_group_id}">{$banner_results[nr].banner_group_name}</option>
{/section}
</select>
</td>
<td width="35%" align="right"><input type="submit" value="{$marketing_button} {$menu_banners}">&nbsp;</td></form>
</tr>

</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{if isset($banner_group_chosen)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group_title}:</font> <font color="{$red_text}">{$banner_chosen_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">

{section name=nr loop=$banner_link_results}

<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2" height="20">
<b>{$banners_size}</b>: {$banner_link_results[nr].banner_size_1} x {$banner_link_results[nr].banner_size_2}<BR />
<b>{$banners_description}</b>: {$banner_link_results[nr].banner_description}<BR />
<b>{$marketing_target_url}</b>: <a href="{$banner_link_results[nr].banner_target_url}" target="_blank">{$banner_link_results[nr].banner_target_url}</a><BR /><BR />
{$banner_link_results[nr].banner_display}<BR /><BR />
{$marketing_source_code}<BR />
<textarea rows="3" cols="56">{$banner_link_results[nr].banner_code}</textarea><BR /><BR />
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

