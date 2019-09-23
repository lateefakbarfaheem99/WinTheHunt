{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($custom_links_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr><td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$keyword_title}</font></b></td></tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$keyword_info}</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><b>{$keyword_heading}</b></td></tr>
<tr><td width="100%" height="5"></td></tr>
<tr><td width="100%">{$keyword_tracking} 1: <font color="#CC0000">tid1</font></td></tr>
<tr><td width="100%">{$keyword_tracking} 2: <font color="#CC0000">tid2</font></td></tr>
<tr><td width="100%">{$keyword_tracking} 3: <font color="#CC0000">tid3</font></td></tr>
<tr><td width="100%">{$keyword_tracking} 4: <font color="#CC0000">tid4</font></td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$keyword_build}</td></tr>
<tr><td width="100%"><input type="text" name="sub_link" value="{$custom_keyword_linkurl}" size="95" /></td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$keyword_example}: {$custom_keyword_linkurl}<font color="#CC0000">&tid1=<b>google</b></font></td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><a href="tutorials/Custom_Links.pdf" target="_blank"><b>{$keyword_tutorial}</b></a></td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
</td></tr>
</table>
</td>
</tr>
</table>

{/if}

<br />
