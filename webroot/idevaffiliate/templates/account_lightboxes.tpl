{if isset($one_click_delivery)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$cp_head_back}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr><td width="100%" bgcolor="{$cp_head_back}">&nbsp;<b><font color="{$section_head_txt}">{$lb_head_title}</font></b></td></tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$lb_head_description}</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$lb_head_source_code}<BR />
<textarea rows="3" cols="65"><link rel="stylesheet" href="{$install_url}/lightboxes/source/css/lightbox.css" type="text/css" />
<script type="text/javascript" language="javascript1.2" src="{$install_url}/lightboxes/source/js/prototype.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript1.2" src="{$install_url}/lightboxes/source/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" language="javascript1.2" src="{$install_url}/lightboxes/source/js/lightbox.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript1.2">
	var fileLoadingImage = "{$install_url}/lightboxes/source/images/loading.gif";	
	var fileBottomNavCloseImage = "{$install_url}/lightboxes/source/images/closelabel.gif";
</script></textarea><BR />
{$lb_head_code_notes}
</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><a href="tutorials/Lightboxes.pdf" target="_blank"><b>{$lb_head_tutorial}</b></a></td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
</td></tr>
</table>
</td>
</tr>
</table>


<br />

{section name=nr loop=$lightbox_link_results}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group}: {$lightbox_link_results[nr].lightbox_group_name}</b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" colspan="2" height="20">
<b>{$lb_body_title}</b>: {$lightbox_link_results[nr].lightbox_link_name}<BR />
<b>{$lb_body_description}</b>: {$lightbox_link_results[nr].lightbox_description}<BR />
<b>{$marketing_target_url}</b>: <a href="{$lightbox_link_results[nr].lightbox_target_url}" target="_blank">{$lightbox_link_results[nr].lightbox_target_url}</a><BR /><BR />
<a href="lightboxes/{$lightbox_link_results[nr].lightbox_image}" width="{$lightbox_link_results[nr].lightbox_main_width}" height="{$lightbox_link_results[nr].lightbox_main_height}" title="{$lightbox_link_text}" rev="{$lightbox_link_results[nr].lightbox_link}" rel="lightbox">
<img src="lightboxes/{$lightbox_link_results[nr].lightbox_thumbnail}" width="{$lightbox_link_results[nr].lightbox_thumb_width}" height="{$lightbox_link_results[nr].lightbox_thumb_height}" border="0" /></a><BR />
{$lb_body_click}<BR /><BR />
{$lb_body_source_code}<BR />
<textarea rows="3" cols="65">{$lightbox_link_results[nr].lightbox_code}</textarea>
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
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$menu_lightboxes}</font></b></td>
</tr>

<tr>
<td width="100%" bgcolor="{$lighter_cells}">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="page" value="38">
<tr height="30">
<td width="22%" align="right"><b>{$marketing_group_title}:&nbsp;&nbsp;</b></td>
<td width="43%">
<select size="1" name="lb_picked">
{section name=nr loop=$lb_results}
<option value="{$lb_results[nr].lb_group_id}">{$lb_results[nr].lb_group_name}</option>
{/section}
</select>
</td>
<td width="35%" align="right"><input type="submit" value="{$marketing_button} {$menu_lightboxes}">&nbsp;</td></form>
</tr>

</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{if isset($lb_group_chosen)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$cp_head_back}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr><td width="100%" bgcolor="{$cp_head_back}">&nbsp;<b><font color="{$section_head_txt}">{$lb_head_title}</font></b></td></tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$lb_head_description}</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$lb_head_source_code}<BR />
<textarea rows="3" cols="65"><link rel="stylesheet" href="{$install_url}/lightboxes/source/css/lightbox.css" type="text/css" />
<script type="text/javascript" language="javascript1.2" src="{$install_url}/lightboxes/source/js/prototype.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript1.2" src="{$install_url}/lightboxes/source/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" language="javascript1.2" src="{$install_url}/lightboxes/source/js/lightbox.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript1.2">
	var fileLoadingImage = "{$install_url}/lightboxes/source/images/loading.gif";	
	var fileBottomNavCloseImage = "{$install_url}/lightboxes/source/images/closelabel.gif";
</script></textarea><BR />
{$lb_head_code_notes}
</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><a href="tutorials/Lightboxes.pdf" target="_blank"><b>{$lb_head_tutorial}</b></a></td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
</td></tr>
</table>
</td>
</tr>
</table>


<br />

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$marketing_group_title}:</font> <font color="{$red_text}">{$lb_chosen_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">

{section name=nr loop=$lightbox_link_results}

<BR />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2" height="20">
<b>{$lb_body_title}</b>: {$lightbox_link_results[nr].lightbox_link_name}<BR />
<b>{$lb_body_description}</b>: {$lightbox_link_results[nr].lightbox_description}<BR />
<b>{$marketing_target_url}</b>: <a href="{$lightbox_link_results[nr].lightbox_target_url}" target="_blank">{$lightbox_link_results[nr].lightbox_target_url}</a><BR /><BR />
<a href="lightboxes/{$lightbox_link_results[nr].lightbox_image}" width="{$lightbox_link_results[nr].lightbox_main_width}" height="{$lightbox_link_results[nr].lightbox_main_height}" title="{$lightbox_link_text}" rev="{$lightbox_link_results[nr].lightbox_link}" rel="lightbox">
<img src="lightboxes/{$lightbox_link_results[nr].lightbox_thumbnail}" width="{$lightbox_link_results[nr].lightbox_thumb_width}" height="{$lightbox_link_results[nr].lightbox_thumb_height}" border="0" /></a><BR />
{$lb_body_click}<BR /><BR />
{$lb_body_source_code}<BR />
<textarea rows="3" cols="65">{$lightbox_link_results[nr].lightbox_code}</textarea><BR /><BR />
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