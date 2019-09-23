{*
-------------------------------------------------------
iDevAffiliate Version 5.1
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($email_friends_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}" colspan="2">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="50%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$friends_title}</font></b></td>
{if isset($email_warning)}
<td width="50%" bgcolor="{$tag_color}" align="right"><b><font color="white">{$email_warning}</font></b>&nbsp; </td>
{elseif isset($email_success)}
<td width="50%" bgcolor="{$red_text}" align="right"><b><font color="white">{$email_success}</font></b>&nbsp; </td>
{else}
<td width="50%" bgcolor="{$table_top}"></td>
{/if}
</tr>
</table>
</td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<center>
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="25%" height="16" colspan="3"></td></tr>
<tr>
<td width="25%" colspan="3" align="center">{$friends_info_one}&nbsp; {$friends_info_two} {$email_interval} {$friends_info_three}.</td>
</tr>
<tr><td width="25%" height="16" colspan="3"></td></tr>
<tr>
<td width="25%" align="right"></td>
<td width="28%"><b>{$friends_heading_name}</b></td>
<td width="47%">&nbsp;&nbsp;<b>{$friends_heading_email}</b></td>
<form method="POST" action="account.php" name="email_friends">
<input type="hidden" name="page" value="13">
<input type="hidden" name="email_friends" value="1">
</tr>
<tr bgcolor="{$table_top}">
<td width="25%" align="right"><b>{$friends_recip_one}</b>:&nbsp;&nbsp;</td>
<td width="28%"><input type="text" name="name1" size="18" value="{$post_name1}"></td>
<td width="47%">&nbsp;&nbsp;<input type="text" name="email1" size="26" value="{$post_email1}"></td>
</tr>
<tr bgcolor="{$light_cells}">
<td width="25%" align="right"><b>{$friends_recip_two}</b>:&nbsp;&nbsp;</td>
<td width="28%"><input type="text" name="name2" size="18" value="{$post_name2}"></td>
<td width="47%">&nbsp;&nbsp;<input type="text" name="email2" size="26" value="{$post_email2}"></td>
</tr>
<tr bgcolor="{$table_top}">
<td width="25%" align="right"><b>{$friends_recip_three}</b>:&nbsp;&nbsp;</td>
<td width="28%"><input type="text" name="name3" size="18" value="{$post_name3}"></td>
<td width="47%">&nbsp;&nbsp;<input type="text" name="email3" size="26" value="{$post_email3}"></td>
</tr>
<tr><td width="100%" align="center" colspan="3" height="10"></td></tr>
<tr>
<td width=25% align="right"><b>{$friends_subject}</b>:&nbsp;&nbsp;</td>
<td width=75% colspan="2"><input type="text" name="subject" size="52" value="{$sub}"> <img src="images/help.gif" height="12" width="12" title="header=[{$help_friends_subject_heading}] body=[{$help_friends_subject_info}]" style="cursor:pointer;">
</td>
</tr>
<tr><td width="25%" height="8" colspan="3"></td></tr>
<tr>
<td width="25%" align="right" valign="top"><b>{$friends_body}</b>:&nbsp;&nbsp;</td>
<td width="75%" colspan="2"><textarea name="body" wrap="physical" cols="40" rows="5"
onKeyDown="textCounter(document.email_friends.body,document.email_friends.remLen1,250)"
onKeyUp="textCounter(document.email_friends.footer,document.email_friends.remLen2,100)">{$bod}</textarea> <img src="images/help.gif" height="12" width="12" title="header=[{$help_friends_message_heading}] body=[{$help_friends_message_info}]" style="cursor:pointer;">
<br />
<input readonly type="text" name="remLen1" size="3" maxlength="3" value="250">
{$friends_chars_left}</td>
</tr>
<tr><td width="25%" height="8" colspan="3"></td></tr>
<tr>
<td width="25%" align="right"><font color="{$red_text}"><b>{$friends_insert}</b>:&nbsp;&nbsp;</font></td>
<td width="75%" colspan="2"><font color="{$red_text}">{$email_friends_url}</font></td>
</tr>
<tr><td width="25%" height="8" colspan="3"></td></tr>
<tr>
<td width="25%" align="right" valign="top"><b>{$friends_footer}</b>:&nbsp;&nbsp;</td>
<td width="75%" colspan="2"><textarea name="footer" wrap="physical" cols="40" rows="3"
onKeyDown="textCounter(document.email_friends.footer,document.email_friends.remLen2,100)"
onKeyUp="textCounter(document.email_friends.footer,document.email_friends.remLen2,100)">{$foot}</textarea> <img src="images/help.gif" height="12" width="12" title="header=[{$help_friends_footer_heading}] body=[{$help_friends_footer_info}]" style="cursor:pointer;">
<br />
<input readonly type="text" name="remLen2" size="3" maxlength="3" value="100">
{$friends_chars_left}</td>
</tr>
<tr><td width="100%" align="center" colspan="3"><hr width="95%"></td></tr>
<tr>
<td width="100%" align="center" colspan="3">
<table border="0" cellspacing="0" width="95%" cellpadding="0">
<tr><td width="100%" colspan="2"><b>{$friends_note_heading}</b></td></tr>
<tr>
<td width="5%" align="center"><img border="0" src="images/bullet.gif" width="8" height="8"></td>
<td width="95%">{$friends_note_one} (<font color={$red_text}>{$affemail}</font>).</td>
</tr>
<tr>
<td width="5%" align="center"><img border="0" src="images/bullet.gif" width="8" height="8"></td>
<td width="95%">{$friends_note_two}.</td>
</tr>
<tr>
<td width="5%" align="center"><img border="0" src="images/bullet.gif" width="8" height="8"></td>
<td width="95%">{$friends_note_three}.</td>
</tr>
<tr>
<td width="5%" align="center"><img border="0" src="images/bullet.gif" width="8" height="8"></td>
<td width="95%">{$friends_note_four}.</td>
</tr>
</table>
</td>
</tr>
<tr><td width="100%" align="center" colspan="3"><hr width="95%"></td></tr>
<tr>
<td width="100%" colspan="3" align="center"><input type="submit" value="{$friends_button}"></td></form>
</tr>
<tr><td width="25%" height="16" colspan="3"></td></tr>
</table>
</center>
</td>
</tr>
</table>
</td>
</tr>
</table>

{/if}

<BR />
