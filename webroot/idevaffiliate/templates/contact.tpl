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
<td width="100%"><table border="0" cellspacing="0" width="100%" cellpadding="4" bgcolor="{$white_back}">
<tr>
<td width="25%" bgcolor="{$left_column}" align="center" valign="top"><BR />
<table border="0" cellpadding="0" cellspacing="0" width="96%">
<td width="100%"><img border="0" src="images/contact.gif" width="32" height="32"><BR /><BR /><b>{$contact_left_column_title}</b><br />{$contact_left_column_text}</td></tr>
<tr><td width="100%"></td></tr>
</table>
</td>
<td width="75%" align="center" valign="top">
<br />
<div align="center">
<center>
<table border="0" cellspacing="0" width="95%" bgcolor="{$table_top}" cellpadding="0">
<tr><td width="100%">
<div align="center">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$contact_title_display}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<div align="center"><table border="0" cellpadding="0" cellspacing="0" width="95%">
<form name="contact_form" method="POST" action="contact.php">
<input type="hidden" name="email_contact" value="1">
<tr><td width="100%" colspan="2" height="15"></td></tr>

{if isset($display_contact_errors)}
<tr><td width="100%" colspan="4"><font color="{$red_text}"><b>{$error_title}</b></font><br />{$error_list}<br /></td></tr>
{/if}

<tr height="25">
<td width="25%">{$contact_name_display}:&nbsp;&nbsp;</td>
<td width="75%"><input type="text" name="name" size="30" value="{$contact_name}"></td>
</tr>
<tr height="25">
<td width="25%">{$contact_email_display}:&nbsp;&nbsp;</td>
<td width="75%"><input type="text" name="email" size="30" value="{$contact_email}"></td>
</tr>
<tr>
<td width="25%" valign="top">{$contact_message_display}:&nbsp;&nbsp;</td>
<td width="75%"><textarea name="message" wrap="physical" cols="40" rows="5"
onKeyDown="textCounter(document.contact_form.message,document.contact_form.remLen,250)"
onKeyUp="textCounter(document.contact_form.message,document.contact_form.remLen,250)">{$contact_message}</textarea>
<br />
<input readonly type="text" name="remLen" size="3" maxlength="3" value="250">
{$contact_chars_display}</td>
</tr>
<tr><td width="100%" colspan="2" height="15"></td></tr>

{if isset($contact_email_received)}
<tr>
<td width="25%"></td>
<td width="75%"><font color="{$red_text}">{$contact_received_display}</font></td>
</tr>

{else}

<tr>
<td width="25%"></td>
<td width="75%"><input type="submit" value="{$contact_button_display}"></td></form>
</tr>

{/if}

<tr><td width="100%" colspan="2" height="15"></td></tr>
</table></div></td></tr></table></div></td></tr></table></center></div><BR />
</td></tr></table>
</td></tr></table>

{include file='file:footer.tpl'}
