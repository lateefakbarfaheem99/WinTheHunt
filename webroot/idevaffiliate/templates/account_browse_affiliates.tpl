{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($browse_affiliates_enabled)}

<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">

<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$browse_page_title}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td width="100%">

{section name=nr loop=$others_results}

<table border="0" cellpadding="2" cellspacing="0" width="100%">

<tr {if $smarty.section.nr.iteration is odd} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>
<td width="100%">&nbsp;&nbsp;<img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;&nbsp;<a href="{$others_results[nr].others_url}" target="_blank">{$others_results[nr].others_url}</a></td>
</tr>
</table>

{sectionelse}

<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
<td width="100%">{$browse_page_none}<BR /><BR /></td>
</tr>
</table>

{/section}

</td></tr>

</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

{/if}

<BR />
