{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($alternate_keywords_enabled)}

{if isset($display_custom_errors)}
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr><td width="100%"><font color="{$red_text}"><b>{$custom_error_title}</b></font><br />{$custom_error_list}</td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
{/if}

{if isset($display_custom_success)}
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr><td width="100%"><font color="{$red_text}"><b>{$custom_success_title}</b></font><br />{$custom_success_message}</td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
{/if}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">

<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="50%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$alternate_title}</font></b></td>
<td width="50%" align="right" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$alternate_option_1}</font></b>&nbsp;</td>
</tr>
<tr>
<td width="100%" colspan="2" bgcolor="{$lighter_cells}" align="center">

<table border="0" cellpadding="0" cellspacing="0" width="98%">
<form action="account.php" method="post">
<input type="hidden" name="create_alternate" value="1">
<input type="hidden" name="page" value="35">
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><b>{$alternate_heading_1}</b></td></tr>
<tr><td width="100%">{$alternate_info_1}</td></tr>
<tr><td width="100%" height="10"></td></tr>

<tr><td width="100%"><input type="text" name="custom_link" value="http://" size="95" /></td></tr>
<tr><td width="100%" height="5"></td></tr>
<tr><td width="100%"><input type="submit" value="{$alternate_button}" name="{$alternate_button}"></td></form></tr>
<tr><td width="100%" height="5"></td></tr>

<tr bgcolor="{$light_cells}"><td width="100%" height="25">&nbsp; <b>{$alternate_links_heading}</b></td></tr>

<tr bgcolor="{$light_cells}"><td width="100%" align="center">


<table width="95%" border="0" cellpadding="0" cellspacing="0">

{section name=nr loop=$clinks_results}

<tr><td><font color="#CC0000">{$clinks_results[nr].clink_url}</font></td></tr>
<tr><td><input type="text" name="sub_link" value="{$clinks_results[nr].clink_linkurl}" size="85" />&nbsp; [<a href="account.php?page=35&custom_remove={$clinks_results[nr].clink_id}">{$alternate_links_remove}</a>]</td></tr>
<tr><td width="100%" height="5"></td></tr>


{sectionelse}

<tr><td width="100%">{$alternate_none}</td></tr>

{/section}

<tr><td width="100%" height="5"></td></tr>
</table>

</td></tr>

<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$alternate_links_note}</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><a href="tutorials/Custom_Links.pdf" target="_blank"><b>{$alternate_tutorial}</b></a></td></tr>
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
<td width="50%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$alternate_title}</font></b></td>
<td width="50%" align="right" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$alternate_option_2}</font></b>&nbsp;</td>
</tr>
<tr>
<td width="100%" colspan="2" bgcolor="{$lighter_cells}" align="center">

<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$alternate_info_2}</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$alternate_variable}: <font color="#CC0000">url</font></td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$alternate_build}</td></tr>
<tr><td width="100%"><input type="text" name="sub_link" value="{$alternate_keyword_linkurl}" size="95" /></td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$alternate_example}: {$alternate_keyword_linkurl}<font color="#CC0000">&url=<b>http://www.yahoo.com</b></font></td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><a href="tutorials/Custom_Links.pdf" target="_blank"><b>{$alternate_tutorial}</b></a></td></tr>
<tr><td width="100%" height="10"></td></tr>


</table>

</td></tr>
</table>
</td>
</tr>
</table>

{/if}

<br />

