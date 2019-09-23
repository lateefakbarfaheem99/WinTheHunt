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

<table align="{$page_align}" border="0" cellspacing="0" width="{$panel_width}{$joinperc}" bgcolor="{$page_border}">
<tr>
<td>
<table border="0" cellpadding="4" cellspacing="0" width="100%" bgcolor="{$white_back}">
<tr>
<td width="75%"><b>{$index_heading_1}</b><br />{$index_paragraph_1}<br /></td>
<td width="25%" rowspan="2" valign="top">

{* -- Start Login Box -- *}

<form method="POST" action="login.php">
<table border="0" cellspacing="0" width="95%">
<tr>
<td width="100%" bgcolor="{$page_border}">
<table border="0" cellspacing="0" width="100%" cellpadding="2">
<tr>
<td width="100%" bgcolor="{$page_border}" colspan="2"> <font color="white"><b>{$index_login_title}</b></font></td>
</tr>
<tr>
<td width="40%" bgcolor="{$lighter_cells}"> {$index_login_username}:</td>
<td width="60%" bgcolor="{$lighter_cells}"><input type="text" name="userid" size="10" value="{$index_login_username_field}" style="width:90px;"></td>
</tr>
<tr>
<td width="40%" bgcolor="{$lighter_cells}"> {$index_login_password}:</td>
<td width="60%" bgcolor="{$lighter_cells}"><input type="password" name="password" size="10" value="{$index_login_password_field}" autocomplete="off" style="width:90px;"></td>
</tr>
<tr>
<td width="40%" bgcolor="{$lighter_cells}"> </td>
<td width="60%" bgcolor="{$lighter_cells}"><input type="submit" value="{$index_login_button}"></td>
</tr>
</table>
</td>
</tr>
</table>
</form>

<center><a href="signup.php"><font color="{$page_links}"><b>{$index_login_signup_link}</b></font></a></center>

{* -- End Login Box -- *}

</td>
</tr>
<tr><td width="75%"><b>{$index_heading_2}</b><br />{$index_paragraph_2}<br /></td></tr>
<tr><td width="75%"><b>{$index_heading_3}</b><br />{$index_paragraph_3}</td></tr>

<tr><td width="100%" colspan="2">
<center>
<table border="0" cellpadding="0" cellspacing="1" width="98%" bgcolor="{$white_back}">
<tr>
<td width="100%" bgcolor="{$table_top}" colspan=2>&nbsp;<b><font color="{$section_head_txt}">{$index_table_title}</font></b></td>
</tr>
<tr><td width="25%" bgcolor="{$lighter_cells}"><b>&nbsp;{$index_table_commission_type}</b></td>
<td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$commission_type_info}
</td>
</tr>

{* The following IF statements are only used if allowing affiliates to choose commission type.
   ------------------------------------------------------------------------------------------- *}
{if isset($choose_percentage_payout)}
<tr><td width="25%" bgcolor="{$lighter_cells}">&nbsp;&nbsp;&nbsp;{$index_table_sale}:</td><td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$bot1}% {$index_table_sale_text}</td></tr>
{/if}

{if isset($choose_flatrate_payout)}
<tr><td width="25%" bgcolor="{$lighter_cells}">&nbsp;&nbsp;&nbsp;{$index_table_sale}:</td><td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$cur_sym}{$bot2} {$currency} {$index_table_sale_text}</td></tr>
{/if}

{if isset($choose_perclick_payout)}
<tr><td width="25%" bgcolor="{$lighter_cells}">&nbsp;&nbsp;&nbsp;{$index_table_click}:</td><td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$cur_sym}{$bot3} {$currency} {$index_table_click_text}</td></tr>
{/if}

{if isset($payout_add_small_row)}
<tr><td width="100%" bgcolor="{$table_top}" colspan="2" height="2"></td></tr>
{/if}
{* ---------------------------------------------------------------------------------------
   The above IF statements are only used if allowing affiliates to choose commission type. *}

{if isset($add_balance_row)}
<tr><td bgcolor="{$lighter_cells}" width="25%"><b>&nbsp;{$index_table_initial_deposit}</b></td><td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$cur_sym}{$init_deposit} {$currency} - <font color="#CC0000"><b>{$index_table_deposit_tag}</b></font></td></tr>
{/if}

{if isset($add_requirements_row)}
<tr><td bgcolor="{$lighter_cells}" width="25%"><b>&nbsp;{$index_table_requirements}</b></td><td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$cur_sym}{$init_req} {$currency} - {$index_table_requirements_tag}</td></tr>
{/if}

<tr>
<td bgcolor="{$lighter_cells}" width="25%"><b>&nbsp;{$index_table_duration}</b></td><td width="75%" bgcolor="{$lighter_cells}">&nbsp;{$index_table_duration_tag}</td>
</tr>
</table>
</center>

<BR />

  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td width="33%" align="center"><a href="login.php"><img border="0" src="images/affiliate_login.gif" width="188" height="56"></a></td>
      <td width="34%" align="center"><a href="signup.php"><img border="0" src="images/affiliate_signup.gif" width="188" height="56"></a></td>
      <td width="33%" align="center"><a href="contact.php"><img border="0" src="images/affiliate_contact.gif" width="188" height="56"></a></td>
    </tr>
  </table>

<BR />
</td>
</tr>
</table>
</td></tr>
</table>

{include file='file:footer.tpl'}