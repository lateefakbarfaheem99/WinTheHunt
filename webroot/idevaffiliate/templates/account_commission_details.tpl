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
<td width="100%" bgcolor="{$table_top}" colspan="2">&nbsp;<b><font color="{$section_head_txt}">{$comdetails_title}</font></b></td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}">&nbsp;{$comdetails_date}</td>
<td width="65%" bgcolor="{$white_back}">&nbsp;{$commission_details_date}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$comdetails_time}</td>
<td width="65%" bgcolor="{$lighter_cells}">&nbsp;{$commission_details_time}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}">&nbsp;{$comdetails_type}</td>
<td width="65%" bgcolor="{$white_back}">&nbsp;{$commission_details_type}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$lighter_cells}">&nbsp;{$comdetails_status}</td>
<td width="65%" bgcolor="{$lighter_cells}">&nbsp;{$commission_details_status}</td>
</tr>
<tr>
<td width="35%" bgcolor="{$white_back}"><b>&nbsp;{$comdetails_amount}</b></td>
<td width="65%" bgcolor="{$white_back}">&nbsp;<b>{$commission_details_payment}</b></td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{if isset($commission_details_show_extras)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}" colspan="2">&nbsp;<b><font color="{$section_head_txt}">{$comdetails_additional_title}</font></b></td>
</tr>
<tr>
<td width="25%" bgcolor="{$white_back}">&nbsp;{$comdetails_additional_ordnum}</td>
<td width="75%" bgcolor="{$white_back}">&nbsp;{$commission_details_extras_ordernum}</td>
</tr>
<tr>
<td width="25%" bgcolor="{$white_back}">&nbsp;{$comdetails_additional_saleamt}</td>
<td width="75%" bgcolor="{$white_back}">&nbsp;{$commission_details_extras_saleamount}</td>
</tr>
{if isset($commission_details_optional_one)}
<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$commission_details_optional_name_one}</td>
<td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$commission_details_optional_value_one}</td>
</tr>
{/if}
{if isset($commission_details_optional_two)}
<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$commission_details_optional_name_two}</td>
<td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$commission_details_optional_value_two}</td>
</tr>
{/if}
{if isset($commission_details_optional_three)}
<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$commission_details_optional_name_three}</td>
<td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$commission_details_optional_value_three}</td>
</tr>
{/if}
</table>
</td>
</tr>
</table>

<BR />

{/if}

{if isset($sub_affiliates_enabled) || isset($custom_links_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}" colspan="2">&nbsp;<b><font color="{$section_head_txt}">{$sub_tracking_title}</font></b></td>
</tr>
{if isset($sub_affiliates_enabled)}
<tr>
<td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$sub_tracking_id}</b></td>
<td width="75%" bgcolor="{$white_back}">&nbsp;<b>{$commission_details_subid}</b></td>
</tr>
{/if}
{if isset($custom_links_enabled)}
<tr>
<td width="25%" bgcolor="{$white_back}">&nbsp;TID1</td>
<td width="75%" bgcolor="{$white_back}">&nbsp;{$commission_details_tid1}</td>
</tr>
<tr>
<td width="25%" bgcolor="{$white_back}">&nbsp;TID2</td>
<td width="75%" bgcolor="{$white_back}">&nbsp;{$commission_details_tid2}</td>
</tr>
<tr>
<td width="25%" bgcolor="{$white_back}">&nbsp;TID3</td>
<td width="75%" bgcolor="{$white_back}">&nbsp;{$commission_details_tid3}</td>
</tr>
<tr>
<td width="25%" bgcolor="{$white_back}">&nbsp;TID4</td>
<td width="75%" bgcolor="{$white_back}">&nbsp;{$commission_details_tid4}</td>
</tr>
{/if}
</table>
</td>
</tr>
</table>

<BR />

{/if}

