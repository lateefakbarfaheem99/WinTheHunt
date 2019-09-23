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
<td width="100%" bgcolor="{$table_top}" colspan="2">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="50%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$password_title}</font></b></td>
{if isset($password_notice)}
<td width="50%" bgcolor="{$red_text}" align="right"><b><font color="white">{$password_notice}</font></b>&nbsp; </td>
{elseif isset($password_warning)}
<td width="50%" bgcolor="{$tag_color}" align="right"><b><font color="white">{$password_warning}</font></b>&nbsp; </td>
{else}
<td width="50%" bgcolor="{$table_top}"></td>
{/if}
</tr>
</table>
</td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<form method="POST" action="account.php">
<input type="hidden" name="change_password" value="1">
<input type="hidden" name="page" value="18">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="20" colspan="2"></td></tr>


<tr>
<td width="40%" align="right">{$password_new_password}:&nbsp;&nbsp;</td>
<td width="60%"><input type="password" name="pass2" size="20">&nbsp;<img src="images/help.gif" height="12" width="12" title="header=[{$help_new_password_heading}] body=[{$help_new_password_info}]" style="cursor:pointer;">
</td>
</tr>
<tr>
<td width="40%" align="right">{$password_confirm_password}:&nbsp;</td>
<td width="60%"><input type="password" name="pass3" size="20">&nbsp;<img src="images/help.gif" height="12" width="12" title="header=[{$help_confirm_password_heading}] body=[{$help_confirm_password_info}]" style="cursor:pointer;">

</td>
</tr>
<tr><td width="100%" height="10" colspan="2"></td></tr>
<tr>
<td width="40%">&nbsp;</td>
<td width="60%"><input type="submit" value="{$password_button}"></td></form>
</tr>
<tr><td width="100%" height="20" colspan="2"></td></tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />



