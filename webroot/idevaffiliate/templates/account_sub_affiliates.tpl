{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($sub_affiliates_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr><td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$sub_tracking_title}</font></b></td></tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$sub_tracking_info}</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><input type="text" name="sub_link" value="{$sub_affiliate_linkurl}" size="95" /></td></tr>
<tr><td width="100%">{$sub_tracking_build}</td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$sub_tracking_example}: {$sub_affiliate_sample_link}<font color="#CC0000">&sub_id=123</font></td></tr>
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%"><a href="tutorials/Custom_Links.pdf" target="_blank"><b>{$sub_tracking_tutorial}</b></a></td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
</td></tr>
</table>
</td>
</tr>
</table>

{/if}

<br />


