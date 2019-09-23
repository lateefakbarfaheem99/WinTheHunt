{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{include file='file:header.tpl'}

{if isset($maintenance_mode)}
<table align="{$page_align}" border="0" cellspacing="0" cellpadding="40" width="{$panel_width}{$joinperc}" bgcolor="{$page_border}">
<div align="center"><center>
    <tr>
      <td width="100%" bgcolor="{$lighter_cells}" align="center"><font size="3"><b>{$signup_maintenance_heading}</b></font><br />{$signup_maintenance_info}</td>
	</td>
</center></div></table>
{else}

<table align="{$page_align}" border="0" cellspacing="0" width="{$panel_width}{$joinperc}" bgcolor="{$page_border}">
<tr><td width="100%"><table border="0" cellspacing="0" width="100%" cellpadding="4" bgcolor="{$white_back}">
<tr><td width="25%" bgcolor="{$left_column}" align="center" valign="top"> 
<table border="0" cellpadding="0" cellspacing="0" width="96%">

<form method="POST" action="signup.php">
<input type="hidden" name="submit" value="1">
<br /><tr><td width="100%"><img border="0" src="images/signup.gif" width="32" height="32"><BR /><BR /><b>{$signup_left_column_title}</b><br />{$signup_left_column_text}<br /><br /></td>
</tr><tr><td width="100%" colspan="2"></td></tr>
</table></td>

<td width="75%" align="center" valign="top">


<table border="0" cellspacing="1" width="100%" bgcolor="{$white_back}">
<div align="center"><center>

{if isset($signup_complete)}
<BR /><tr><td width="100%" colspan="4"><center>
<font color="{$red_text}"><b>{$signup_page_success}</b></font><BR />{$signup_success_email_comment}
<br /><br /><a href="account.php"><b>{$signup_success_login_link}</b></a>
</center></td></tr></table></tr></td></table></tr></td></table>
{else}

{if isset($display_signup_errors)}
<tr><td width="100%" colspan="4"><font color="{$red_text}"><b>{$error_title}</b></font><br />{$error_list}<br /></td></tr>
{/if}

    <tr>
      <td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<font color="{$section_head_txt}"><b>{$signup_login_title}</b></font></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_login_username}</td>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="username" size="20" value="{if isset($postuser)}{$postuser}{/if}" style="width:150px;" tabindex="1"></td>
      <td width="50%" bgcolor="{$lighter_cells}" colspan="2">&nbsp;<img src="images/help.gif" title="header=[{$signup_login_username}] body=[{$signup_login_minmax_chars}]" style="cursor:pointer;">
	</td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_login_password}</td>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="password" name="password" size="20" value="{if isset($postpass)}{$postpass}{/if}" style="width:150px;" tabindex="2"></td>
      <td width="50%" bgcolor="{$lighter_cells}" colspan="2">&nbsp;<img src="images/help.gif" title="header=[{$signup_login_password}] body=[{$signup_login_minmax_chars}]" style="cursor:pointer;"></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_login_password_again}</td>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="password" name="password_c" size="20" value="{$postpasc}" style="width:150px;" tabindex="3"></td>
      <td width="50%" bgcolor="{$lighter_cells}" colspan="2">&nbsp;<img src="images/help.gif" title="header=[{$signup_login_password_again}] body=[{$signup_login_must_match}]" style="cursor:pointer;"></td>
    </tr>
<tr><td width="100%" colspan="4" height="5"></td></tr>

{if isset($optionals_used)}
<tr><td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<font color="{$section_head_txt}"><b>{$signup_standard_title}</b></font></td></tr>
{if isset($row_email)}
<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_standard_email}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="email" size="30" value="{$postemail}" style="width:150px;" tabindex="4"></td>
<td width="50%" bgcolor="{$lighter_cells}" colspan="2"></td>
</tr>
{/if}
{if isset($row_company)}
<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_standard_company}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="company" size="30" value="{$postcompany}" style="width:150px;" tabindex="5"></td>
<td width="50%" bgcolor="{$lighter_cells}" colspan="2"></td>
</tr>
{/if}
{if isset($row_checks)}
<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_standard_checkspayable}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="payable" size="30" value="{$postchecks}" style="width:150px;" tabindex="6"></td>
<td width="50%" bgcolor="{$lighter_cells}" colspan="2"></td>
</tr>
{/if}
{if isset($row_website)}
<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_standard_weburl}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="url" size="30" value="{$postwebsite}" style="width:150px;" tabindex="7"></td>
<td width="50%" bgcolor="{$lighter_cells}" colspan="2"></td>
</tr>
{/if}
{if isset($row_taxinfo)}
<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_standard_taxinfo}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="tax_id_ssn" size="30" value="{$posttax}" style="width:150px;" tabindex="8"></td>
<td width="50%" bgcolor="{$lighter_cells}" colspan="2"></td>
</tr>
{/if}
<tr><td width="100%" colspan="4" height="5"></td></tr>
{/if}

    <tr>
      <td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<font color="{$section_head_txt}"><b>{$signup_personal_title}</b></font></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_fname}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="f_name" size="20" value="{$postfname}" style="width:150px;" tabindex="9"></td>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_state}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="state" size="20" value="{$poststate}" style="width:150px;" tabindex="14"></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_lname}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="l_name" size="20" value="{$postlname}" style="width:150px;" tabindex="10"></td>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_phone}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="phone" size="20" value="{$postphone}" style="width:150px;" tabindex="15"></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_addr1}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="address_one" size="20" value="{$postaddr1}" style="width:150px;" tabindex="11"></td>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_fax}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="fax" size="20" value="{$postfaxnm}" style="width:150px;" tabindex="16"></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_addr2}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="address_two" size="20" value="{$postaddr2}" style="width:150px;" tabindex="12"></td>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_zip}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="zip" size="20" value="{$postzip}" style="width:150px;" tabindex="17"></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_city}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="city" size="20" value="{$postcity}" style="width:150px;" tabindex="13"></td>
	<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_personal_country}</td><td width="25%" bgcolor="{$lighter_cells}">&nbsp;{include file='file:countries.tpl'}</td>
    </tr>
	<tr><td width="100%" colspan="4" height="5"></td></tr>

{if isset($payment_choice_used)}
{include file='file:signup_payment_choices.tpl'}
{/if}

{if isset($paypal_required)}
{include file='file:signup_paypal_required.tpl'}
{/if}

{if isset($paypal_optional)}
{include file='file:signup_paypal_optional.tpl'}
{/if}

{if isset($terms_conditions)}
{include file='file:signup_terms.tpl'}
{/if}

{if isset($canspam_conditions)}
{include file='file:signup_canspam.tpl'}
{/if}

{if isset($insert_custom_fields)}
{include file='file:signup_custom.tpl'}
{/if}

{if isset($security_required)}
{include file='file:signup_security_code.tpl'}
{/if}

<tr><td width="100%" colspan="4" height="10"></td></tr>
<tr>
<td width="100%" colspan="4" align="center"><hr width="90%"></td>
</tr>
<tr><td width="100%" colspan="4" height="10"></td></tr>
<tr>
<td width="100%" colspan="4" align="center"><input type="submit" value="{$signup_page_button}"></td></form>
</tr>
<tr><td width="100%" colspan="4" height="10"></td></tr>
</table>
</center>
</div>
</table></table>

{/if}{/if}

{include file='file:footer.tpl'}