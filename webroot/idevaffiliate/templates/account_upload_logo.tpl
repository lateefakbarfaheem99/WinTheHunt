{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($logos_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$logo_title}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%" colspan="2"><br />{$logo_info}</td>
</tr>
<tr><td width="100%" colspan="2" height="20"></td></tr>
<tr>
<td width="5%" align="center"><img border="0" src="images/bullet_blue.gif" width="8" height="8"></td>
<td width="95%">{$logo_bullet_one}</td>
</tr>
<tr>
<td width="5%" align="center"><img border="0" src="images/bullet_blue.gif" width="8" height="8"></td>
<td width="95%">{$logo_bullet_two}</td>
</tr>
<tr>
<td width="5%" align="center"><img border="0" src="images/bullet_blue.gif" width="8" height="8"></td>
<td width="95%">{$logo_bullet_three}</td>
</tr>
<tr>
<td width="5%" align="center"><img border="0" src="images/bullet_blue.gif" width="8" height="8"></td>
<td width="95%">{$logo_message}

{if isset($logo_size_required)}
{$logo_bullet_req_size_one} {$logo_width} {$logo_bullet_req_size_two} {$logo_height} {$logo_bullet_pixels}
{else}
{$logo_bullet_size_one} {$logo_width} {$logo_bullet_size_two} {$logo_height} {$logo_bullet_pixels}
{/if}

</td>
</tr>
<tr><td width="100%" colspan="2" height="20"></td></tr>

{if isset($upload_error)}
<tr><td width="100%" colspan="2" height="20"><font color="#CC0000"><b>{$logo_error_title}</b></font></td></tr>
<tr><td width="100%" colspan="2" height="20">{$error_message}</td></tr>
<tr><td width="100%" colspan="2" height="20"></td></tr>
{/if}

{if isset($upload_success)}
<tr><td width="100%" colspan="2" height="20"><font color="#CC0000">{$success_message}</font></td></tr>
<tr><td width="100%" colspan="2" height="20"></td></tr>
{/if}

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
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$logo_choose}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<FORM ENCTYPE="multipart/form-data" ACTION="account.php" METHOD="post">
<input type="hidden" name="update_logo" value="1">
<input type="hidden" name="page" value="27">
<tr height="30">
<td width="15%" align="right"><b>{$logo_file}&nbsp;&nbsp;</b></td>
<td width="40%"><input type="file" name="logo" size="20"></td>
<td width="45%"><input type="submit" value="{$logo_button}">&nbsp;</td>
</form>
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
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="50%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$logo_current}</font></b> {if isset($image_exists)}[<a href="account.php?page=27&remove_logo={$affiliate_id}">{$logo_remove}</a>]{/if}</td>
<td width="50%" bgcolor="{$table_top}" align="right">{if isset($image_exists)}<b><font color="{$section_head_txt}">{$logo_display_status} {$image_status}</font></b>&nbsp;{/if}</td>
</tr>
<tr>
<td width="100%" colspan="2" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="20"></td></tr>
<tr><td width="100%" align="center"><img border="0" src="{$image}" height="{$image_height}" width="{$image_width}"></td></tr>
<tr><td width="100%" height="20"></td></tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

{/if}

<BR />
