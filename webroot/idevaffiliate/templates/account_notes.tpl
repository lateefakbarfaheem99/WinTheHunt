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
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$general_notes_title}</font></b></td>
</tr>

{section name=nr loop=$note_results}

<tr><td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="95%">
<tr><td width="100%" colspan="2" height="5"></td></tr>
<tr>
<td width="50%">{$general_notes_date}: {$note_results[nr].note_date}</td>
<td width="50%">{$general_notes_to}: {$note_results[nr].note_to}</td>
</tr>
<tr><td width="100%" colspan="2" height="5"></td></tr>
<tr>
<td width="100%" colspan="2"><b>{$note_results[nr].note_subject}</b></td>
</tr>
<tr>
<td width="100%" colspan="2">{$note_results[nr].note_content}</td>
</tr>
<tr><td width="100%" colspan="2" height="5"></td></tr>
</table>
</td></tr>

{sectionelse}

<tr><td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="95%">
<tr><td width="100%" colspan="2" height="5"></td></tr>
<tr><td width="100%" bgcolor="{$lighter_cells}">{$general_notes_none}</td></tr>
<tr><td width="100%" colspan="2" height="5"></td></tr>
</table>
</td></tr>

{/section}

</table>
</td>
</tr>
</table>

<br />

