{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($offline_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$offline_title}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="95%">
<tr>
<td width="100%"><BR />{$offline_paragraph_one}<BR /><BR />
<table border="0" cellpadding="0" cellspacing="0" width="95%">
<tr>
<td width="30%">&nbsp;&nbsp;<b>{$offline_tag}:</b></td>
<td width="70%">&nbsp;&nbsp;<b><font color="{$red_text}">{$link_id}</font></b></td>
</tr>
<tr><td height="6"></td></tr>
<tr>
<td width="30%">&nbsp;&nbsp;<b>{$offline_send}:</b></td>
<td width="70%">&nbsp;&nbsp;{$offline_location}</td>
</tr>
<tr>
<td width="30%">&nbsp;&nbsp;</td>
<td width="70%">&nbsp;&nbsp;(<a href="{$offline_location}" target="_blank">{$offline_page_link}</a>)</td>
</tr>
</table>
<BR />{$offline_paragraph_two}<BR /><BR />
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

{/if}

<br />
