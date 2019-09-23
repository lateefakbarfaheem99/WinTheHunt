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

{if isset($use_faq) && ($faq_location == 1)}

<tr>
<td width="100%">

{section name=nr loop=$faq_results}

<table border="0" cellpadding="15" cellspacing="4" width="100%">
<tr {if $smarty.section.nr.iteration is odd} bgcolor="{$lighter_cells}"{else}bgcolor="{$light_cells}"{/if}>
<td width="100%"><font size="4"><b>{$faq_results[nr].faq_question}</b></font><BR />{$faq_results[nr].faq_answer}</td>
</tr>
</table>

{/section}

</td>
</tr>


<tr>
<td width="100%">

  <table border="0" cellpadding="10" cellspacing="10" width="100%">
    <tr>
      <td width="37%" align="right"><a href="login.php"><img border="0" src="images/affiliate_login.gif" width="188" height="56"></a></td>
      <td width="26%" align="center"><a href="signup.php"><img border="0" src="images/affiliate_signup.gif" width="188" height="56"></a></td>
      <td width="37%"><a href="contact.php"><img border="0" src="images/affiliate_contact.gif" width="188" height="56"></a></td>
    </tr>
  </table>

  </td>
</tr>

{else}

<tr>
<td width="100%"><center><br /><br />Our Frequently Asked Questions Are Not Made Public<br /><br /><br /></td>
</tr>

{/if}

</table>
</td>
</tr>
</table>

{include file='file:footer.tpl'}

