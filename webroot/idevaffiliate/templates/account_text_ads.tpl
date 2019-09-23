{if isset($one_click_delivery)}

{section name=nr loop=$textad_link_results}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group}: {$textad_link_results[nr].textad_group_name}</b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%">

<b>{$marketing_target_url}</b>: <a href="{$textad_link_results[nr].textad_target_url}" target="_blank">{$textad_link_results[nr].textad_target_url}</a><BR /><BR />

<script type="text/javascript"><!--
iDevAffiliate_BoxWidth = "220";
iDevAffiliate_BoxHeight = "80";
iDevAffiliate_OutlineColor = "#000099";
iDevAffiliate_TitleTextColor = "#FFFFFF";
iDevAffiliate_LinkColor = "#0033CC";
iDevAffiliate_TextColor = "#000000";
iDevAffiliate_TextBackgroundColor = "#F3F3F3";
//-->
</script>

{if isset($seo_links)}
<script language="JavaScript" type="text/javascript" src="{$siteurl}{$link_id}-textad-{$textad_link_results[nr].textad_link_id}{$textad_link_results[nr].textad_link_location}.html"></script>
{else}
<script language="JavaScript" type="text/javascript" src="{$base_url}/idevads.php?id={$link_id}&ad={$textad_link_results[nr].textad_link_id}{$textad_link_results[nr].textad_link_location}"></script>
{/if}

<BR />{$marketing_source_code}<BR />

<textarea rows="3" cols="56">
<script type="text/javascript"><!--
iDevAffiliate_BoxWidth = "220";
iDevAffiliate_BoxHeight = "80";
iDevAffiliate_OutlineColor = "#000099";
iDevAffiliate_TitleTextColor = "#FFFFFF";
iDevAffiliate_LinkColor = "#0033CC";
iDevAffiliate_TextColor = "#000000";
iDevAffiliate_TextBackgroundColor = "#F3F3F3";
//-->
</script>

{if isset($seo_links)}
<script language="JavaScript" type="text/javascript" src="{$siteurl}{$link_id}-textad-{$textad_link_results[nr].textad_link_id}{$textad_link_results[nr].textad_link_location}.html"></script>
{else}
<script language="JavaScript" type="text/javascript" src="{$base_url}/idevads.php?id={$link_id}&ad={$textad_link_results[nr].textad_link_id}{$textad_link_results[nr].textad_link_location}"></script>{/if}</textarea><BR /><BR />
{$ad_info}<BR /><BR />
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



<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$menu_text_ads}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="page" value="8">
<tr height="30">
<td width="22%" align="right"><b>{$marketing_group_title}:&nbsp;&nbsp;</b></td>
<td width="43%">
<select size="1" name="textads_picked">
{section name=nr loop=$textad_results}
<option value="{$textad_results[nr].textad_group_id}">{$textad_results[nr].textad_group_name}</option>
{/section}
</select>
</td>
<td width="35%" align="right"><input type="submit" value="{$marketing_button} {$menu_text_ads}">&nbsp;</td></form>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{if isset($textad_group_chosen)}

<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group_title}:</font> <font color="{$red_text}">{$textad_chosen_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">

{section name=nr loop=$textad_link_results}
<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">

<tr><td width="100%" colspan="2"><b>{$marketing_target_url}</b>: <a href="{$textad_link_results[nr].textad_target_url}" target="_blank">{$textad_link_results[nr].textad_target_url}</a><BR /><BR /></td></tr>
<tr><td width="50%">
<script type="text/javascript"><!--
iDevAffiliate_BoxWidth = "220";
iDevAffiliate_BoxHeight = "80";
iDevAffiliate_OutlineColor = "#000099";
iDevAffiliate_TitleTextColor = "#FFFFFF";
iDevAffiliate_LinkColor = "#0033CC";
iDevAffiliate_TextColor = "#000000";
iDevAffiliate_TextBackgroundColor = "#F3F3F3";
//-->
</script>
{if isset($seo_links)}
<script language="JavaScript" type="text/javascript" src="{$siteurl}{$link_id}-textad-{$textad_link_results[nr].textad_link_id}{$textad_link_results[nr].textad_link_location}.html"></script>
{else}
<script language="JavaScript" type="text/javascript" src="{$base_url}/idevads.php?id={$link_id}&ad={$textad_link_results[nr].textad_link_id}{$textad_link_results[nr].textad_link_location}"></script>
{/if}
</td>

<td width="50%" align="center">{$ad_info}</td>
</tr>
<tr><td width="100%" colspan="2"><br /><br />{$marketing_source_code}</td></tr>
<tr><td width="100%" colspan="2">
<textarea rows="3" cols="56">
<script type="text/javascript"><!--
iDevAffiliate_BoxWidth = "220";
iDevAffiliate_BoxHeight = "80";
iDevAffiliate_OutlineColor = "#000099";
iDevAffiliate_TitleTextColor = "#FFFFFF";
iDevAffiliate_LinkColor = "#0033CC";
iDevAffiliate_TextColor = "#000000";
iDevAffiliate_TextBackgroundColor = "#F3F3F3";
//-->
</script>
{if isset($seo_links)}
<script language="JavaScript" type="text/javascript" src="{$siteurl}{$link_id}-textad-{$textad_link_results[nr].textad_link_id}{$textad_link_results[nr].textad_link_location}.html"></script>
{else}
<script language="JavaScript" type="text/javascript" src="{$base_url}/idevads.php?id={$link_id}&ad={$textad_link_results[nr].textad_link_id}{$textad_link_results[nr].textad_link_location}"></script>{/if}
</textarea><BR /><BR />
</td></tr>
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

