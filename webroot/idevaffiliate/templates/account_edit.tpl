{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($display_edit_errors)}
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr><td width="100%"><font color="{$red_text}"><b>{$error_title}</b></font><br />{$error_list}</td></tr>
</table>
{/if}

<form method="POST" action="account.php">
<input type="hidden" name="edit" value="1">
<input type="hidden" name="page" value="17">

{if isset($optionals_used)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}" colspan="2">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="50%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$edit_standard_title}</font></b></td>
{if isset($update_notice)}
<td width="50%" bgcolor="{$red_text}" align="right"><b><font color="white">{$edit_success}</font></b>&nbsp; </td>
{elseif isset($update_warning)}
<td width="50%" bgcolor="{$tag_color}" align="right"><b><font color="white">{$edit_failed}</font></b>&nbsp; </td>
{else}
<td width="50%" bgcolor="{$table_top}"></td>
{/if}
</tr>
</table>
</td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td width="100%" colspan="2" height="10"></td></tr>
{if isset($row_email)}
<tr><td width="25%">&nbsp;{$edit_standard_email}</td><td width="75%" colspan="2"><input type="text" name="email" size="30" value="{$postemail}" style="width:200px;" tabindex="4"></td></tr>
{/if}
{if isset($row_company)}
<tr><td width="25%">&nbsp;{$edit_standard_company}</td><td width="75%" colspan="2"><input type="text" name="company" size="30" value="{$postcompany}" style="width:200px;" tabindex="5"></td></tr>
{/if}
{if isset($row_checks)}
<tr><td width="25%">&nbsp;{$edit_standard_checkspayable}</td><td width="75%" colspan="2"><input type="text" name="payable" size="30" value="{$postchecks}" style="width:200px;" tabindex="6"></td></tr>
{/if}
{if isset($row_website)}
<tr><td width="25%">&nbsp;{$edit_standard_weburl}</td><td width="75%" colspan="2"><input type="text" name="url" size="30" value="{$postwebsite}" style="width:200px;" tabindex="7"></td></tr>
{/if}
{if isset($row_taxinfo)}
<tr><td width="25%">&nbsp;{$edit_standard_taxinfo}</td><td width="75%" colspan="2"><input type="text" name="tax_id_ssn" size="30" value="{$posttax}" style="width:200px;" tabindex="8"></td></tr>
{/if}
<tr><td width="100%" colspan="2" height="10"></td></tr>
</table>
</table>
</td>
</tr>
</table>
<BR />
{/if}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$edit_personal_title}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td width="100%" colspan="4" height="10"></td></tr>
    <tr>
      <td width="20%">&nbsp;{$edit_personal_fname}</td><td width="30%"><input type="text" name="f_name" size="20" value="{$postfname}" style="width:140px;" tabindex="9"></td>
      <td width="20%">{$edit_personal_state}</td><td width="30%"><input type="text" name="state" size="20" value="{$poststate}" style="width:140px;" tabindex="14"></td>
    </tr>
    <tr>
      <td width="20%">&nbsp;{$edit_personal_lname}</td><td width="30%"><input type="text" name="l_name" size="20" value="{$postlname}" style="width:140px;" tabindex="10"></td>
      <td width="20%">{$edit_personal_phone}</td><td width="30%"><input type="text" name="phone" size="20" value="{$postphone}" style="width:140px;" tabindex="15"></td>
    </tr>
    <tr>
      <td width="20%">&nbsp;{$edit_personal_addr1}</td><td width="30%"><input type="text" name="address_one" size="20" value="{$postaddr1}" style="width:140px;" tabindex="11"></td>
      <td width="20%">{$edit_personal_fax}</td><td width="30%"><input type="text" name="fax" size="20" value="{$postfaxnm}" style="width:140px;" tabindex="16"></td>
    </tr>
    <tr>
      <td width="20%">&nbsp;{$edit_personal_addr2}</td><td width="30%"><input type="text" name="address_two" size="20" value="{$postaddr2}" style="width:140px;" tabindex="12"></td>
      <td width="20%">{$edit_personal_zip}</td><td width="30%"><input type="text" name="zip" size="20" value="{$postzip}" style="width:140px;" tabindex="17"></td>
    </tr>
    <tr>
      <td width="20%">&nbsp;{$edit_personal_city}</td><td width="30%"><input type="text" name="city" size="20" value="{$postcity}" style="width:140px;" tabindex="13"></td>
	<td width="20%">{$edit_personal_country}</td><td width="30%">{include file='file:account_edit_countries.tpl'}</td>
    </tr>
<tr><td width="100%" colspan="4" height="10"></td></tr>
</table>
</table>
</td>
</tr>
</table>

<BR/ >

{if isset($paypal_required)}
{include file='file:account_edit_paypal_required.tpl'}
{/if}

{if isset($paypal_optional)}
{include file='file:account_edit_paypal_optional.tpl'}
{/if}

<BR />

<table border="0" cellpadding="1" cellspacing="1" width="100%">
<td width="100%" colspan="4" align="center"><input type="submit" value="{$edit_button}"></td></form>
</tr>
</table>

<BR />
