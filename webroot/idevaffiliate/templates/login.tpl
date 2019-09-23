{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{include file='file:header.tpl'}

<table align="{$page_align}" border="0" cellspacing="0" width="{$panel_width}{$joinperc}" bgcolor="{$page_border}">
<tr>
<td width="100%">
<table border="0" cellspacing="0" width="100%" cellpadding="4" bgcolor="{$white_back}">
<tr>
<td width="25%" bgcolor="{$left_column}" align="center" valign="top"><BR />
<table border="0" cellpadding="0" cellspacing="0" width="96%">
<tr>
<td width="100%"><img border="0" src="images/login.gif" width="32" height="32"><BR /><BR /><b>{$login_left_column_title}</b><br />{$login_left_column_text}</td>
</tr>
</table>
</td>
<td width="75%" align="center" valign="top">
<br />
<table border="0" cellspacing="0" width="95%" bgcolor="{$table_top}" cellpadding="0">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$login_title}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="95%">
<tr><td width="100%" colspan="2" height="15"></td></tr>
<form method="POST" action="login.php">
<tr>
<td width="40%" align="right">{$login_username}:&nbsp;&nbsp;</td>
<td width="60%"><input type="text" name="userid" size="20"></td>
</tr>
<tr>
<td width="40%" align="right">{$login_password}:&nbsp;&nbsp;</td>
<td width="60%"><input type="password" name="password" size="20" autocomplete="off"></td>
</tr>

{if isset($login_invalid)}
<tr>
<td width="40%" align="right"></td>
<td width="60%"><font color="#CC0000">{$login_invalid}</font></td>
</tr>
{/if}

<tr><td width="100%" colspan="2" height="15"></td></tr>
<tr>
<td width="40%" align="right"></td><td width="60%"><input type="submit" value="{$login_now}">
</td>
</tr>
</form>
<tr><td width="100%" colspan="2" height="30"></td></tr>

<form method="POST" action="login.php">

<tr>
<td width="40%" align="right"></td>
<td width="60%"><b>{$login_send_title}</b></td>
</tr>
<tr>
<td width="40%" align="right">{$login_send_username}:&nbsp;&nbsp;</td>
<td width="60%"><input type="text" name="sendpass" size="20"></td>
</tr>

{if isset($login_details)}
<tr>
<td width="40%" align="right"></td>
<td width="60%"><font color="#CC0000">{$login_details}</font></td>
</tr>
{/if}

<tr><td width="100%" colspan="2" height="15"></td></tr>
<tr>
<td width="40%"></td>
<td width="60%"><input type="submit" value="{$login_send_pass}"></td>
</tr>
</form>
<tr><td width="100%" colspan="2" height="15"></td></tr>
</table>
</td></tr></table></td></tr></table></form><BR />
</td>
</tr>
</table>
</td>
</tr>
</table>

{include file='file:footer.tpl'}
