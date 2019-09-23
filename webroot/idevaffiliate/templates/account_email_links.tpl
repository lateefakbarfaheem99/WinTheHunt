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
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$email_title}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="page" value="10">
<tr height="30">
<td width="22%" align="right"><b>{$email_group}:&nbsp;&nbsp;</b></td>
<td width="43%">
<select size="1" name="email_picked">
{section name=nr loop=$email_results}
<option value="{$email_results[nr].email_group_id}">{$email_results[nr].email_group_name}</option>
{/section}
</select>
</td>
<td width="35%" align="right"><input type="submit" value="{$email_button}">&nbsp;</td></form>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{if isset($email_group_chosen)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$email_group}:</font> <font color="{$red_text}">{$email_chosen_group_name}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<BR />&nbsp;
{$email_ascii}
<BR />&nbsp;
<textarea rows="3" cols="56">{$email_chosen_url}</textarea>
<BR />&nbsp;
{$email_source}
<BR /><BR />&nbsp;
{$email_html}
<BR />&nbsp;
<textarea rows="3" cols="56"><a href="{$email_chosen_url}">{$email_chosen_group_name}</a></textarea>
<BR />&nbsp;
{$email_source}
<BR /><BR />&nbsp;
<b>{$email_test}</b>: <a href="{$email_chosen_url}" target="_blank">{$email_chosen_display_tag}</a>
<BR />&nbsp;
{$email_test_info}
<BR />
<BR />
</td>
</tr>
</table>
</td>
</tr>
</table>

{else}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$email_no_group}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center"><BR /><BR /><b>{$email_choose}</b><BR /><BR /><font color="{$red_text}">{$email_notice}</font><BR /><BR /><BR /></td>
</tr>
</table>
</td>
</tr>
</table>

{/if}

<BR />
