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
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$pdf_title} {$pdf_training}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">

<tr><td width="100%" height="5" bgcolor="{$white_back}"></td></tr>

<tr><td width="100%" bgcolor="{$white_back}">

  <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td width="75%">&nbsp;{$pdf_description_1}</td>
  <td width="25%" rowspan="2" align="center"><a target="_blank" href="http://www.adobe.com/products/acrobat/readstep2.html"><img border="0" src="images/get_adobe_reader.gif" width="112" height="33"></a></td>
  </tr>
  <tr>
  <td width="75%">&nbsp;{$pdf_description_2}</td>
  </tr>
  </table>


</td></tr>
<tr><td width="100%" height="5" bgcolor="{$white_back}"></td></tr>

<tr>
<td width="100%" bgcolor="{$table_top}" height="20">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="5%"></td>
        <td width="25%"><b><font color="{$section_head_txt}">{$pdf_file_name}</font></b></td>
        <td width="20%"><b><font color="{$section_head_txt}">{$pdf_file_size}</font></b></td>
        <td width="50%"><b><font color="{$section_head_txt}">{$pdf_file_description}</font></b></td>
      </tr>
    </table>
</td>
</tr>

<tr><td width="100%">


{section name=nr loop=$pdf_results}

<table border="0" cellpadding="2" cellspacing="0" width="100%">

<tr {if $smarty.section.nr.iteration is odd} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>
<td width="100%">

  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td width="5%" align="center" rowspan="2"><img border="0" src="images/pdficon_small.gif" width="17" height="17"></td>
      <td width="25%"><a href="docs/{$pdf_results[nr].pdf_filename}" target="_blank">{$pdf_results[nr].pdf_filename}</a></td>
      <td width="20%">{$pdf_results[nr].pdf_size} {$pdf_bytes}</td>
      <td width="50%">{$pdf_results[nr].pdf_desc}</td>

    </tr>
  </table>

</td>
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







<BR />
