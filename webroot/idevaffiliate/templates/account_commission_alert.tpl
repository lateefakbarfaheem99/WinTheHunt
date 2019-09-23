{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$commissionalert_title}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}" colspan="2" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td width="100%"><br />{$commissionalert_info}</td>
</tr>
</table>

<BR />

  <table border="0" cellspacing="1" width="95%">
    <tr>
      <td width="100%" colspan=3>&nbsp;<b>{$commissionalert_hint}</b></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$white_back}">&nbsp;{$commissionalert_profile}:</td>
      <td width="35%" bgcolor="{$white_back}">&nbsp;<input type="text" size="20" value="{$sitename}"></td>
      <td width="40%" bgcolor="{$white_back}" rowspan="4" align="center"><img border="0" src="images/ca1.gif" width="148" height="59"></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$white_back}">&nbsp;{$commissionalert_username}:</td>
      <td width="35%" bgcolor="{$white_back}">&nbsp;<input type="text" size="20" value="{$username}"></td>
    </tr>
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;{$commissionalert_password}:</td>
      <td width="35%" bgcolor="{$white_back}">&nbsp;<font color="#707070">[{$account_hidden}]</font></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$white_back}">&nbsp;{$commissionalert_id}:</td>
      <td width="35%" bgcolor="{$white_back}">&nbsp;<input type="text" size="20" value="{$link_id}"></td>
    </tr>
    <tr>
      <td width="25%" bgcolor="{$white_back}">&nbsp;{$commissionalert_source}:</td>
      <td width="75%" bgcolor="{$white_back}" colspan="2">&nbsp;<input type="text" size="50" value="{$base_url}/"></td>
    </tr>
  </table>

<BR />

</td></tr>
<tr>
<form method="POST" action="commissionalert/download.php">
<td width="100%" bgcolor="{$table_top}" align="center" height="40" valign="middle">
<input type="hidden" name="affid" value="{$link_id}">
<input type="submit" value="{$commissionalert_download}">
</td></form>
</tr>
</table>
</td>
</tr>
</table>

<BR />
