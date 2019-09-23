{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($custom_tracking_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="1" cellspacing="1" width="100%">

<tr><td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$cr_title}</font></b></td></tr>

<tr>
<td width="100%" bgcolor="{$lighter_cells}">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<form method="POST" action="account.php">
<input type="hidden" name="custom_report" value="1">
<input type="hidden" name="page" value="36">

<tr><td width="100%">
<table width="100%" border="0" cellpadding="2">

<tr>

<td width="30%" bgcolor="{$logged_menu}" align="center" height="35">

{php}
$get_user_id=mysql_query("select id from idevaff_affiliates where username = '" . $_SESSION['valid_user'] . "'");
$result = mysql_fetch_array($get_user_id);
$linkid = $result['id'];
echo "<select size='1' name='tid1' style=width:154px;>\n";
$get1 = mysql_query("select distinct tid1 from idevaff_iptracking where tid1 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get1)) {
echo "<option value='none'>TID1: ";
{/php}
{$cr_select}
{php}
echo "</option>\n";
while ($qry = mysql_fetch_array($get1)) {
$tid1_value = $qry['tid1'];
echo "<option value='$tid1_value'>$tid1_value</option>\n";
} } else {
echo "<option value='none'>TID1: ";
{/php}
{$cr_none}
{php}
echo "</option>\n"; }
echo "</select>";
{/php}

</td>

<td width="30%" bgcolor="{$logged_menu}" align="center" height="35">

{php}
echo "<select size='1' name='tid2' style=width:154px;>\n";
$get2 = mysql_query("select distinct tid2 from idevaff_iptracking where tid2 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get2)) {
echo "<option value='none'>TID2: ";
{/php}
{$cr_select}
{php}
echo "</option>\n";
while ($qry = mysql_fetch_array($get2)) {
$tid2_value = $qry['tid2'];
echo "<option value='$tid2_value'>$tid2_value</option>\n";
} } else {
echo "<option value='none'>TID2: ";
{/php}
{$cr_none}
{php}
echo "</option>\n"; }
echo "</select>";
{/php}

</td>

<td width="40%" bgcolor="{$logged_menu}" align="center" colspan="2" rowspan="2"><input type="submit" value="{$cr_button}"></td>

</tr>

<tr>

<td width="30%" bgcolor="{$logged_menu}" align="center" height="35">

{php}
echo "<select size='1' name='tid3' style=width:154px;>\n";
$get3 = mysql_query("select distinct tid3 from idevaff_iptracking where tid3 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get3)) {
echo "<option value='none'>TID3: ";
{/php}
{$cr_select}
{php}
echo "</option>\n";
while ($qry = mysql_fetch_array($get3)) {
$tid3_value = $qry['tid3'];
echo "<option value='$tid3_value'>$tid3_value</option>\n";
} } else {
echo "<option value='none'>TID3: ";
{/php}
{$cr_none}
{php}
echo "</option>\n"; }
echo "</select>";
{/php}

</td>

<td width="30%" bgcolor="{$logged_menu}" align="center" height="35">

{php}
echo "<select size='1' name='tid4' style=width:154px;>\n";
$get4 = mysql_query("select distinct tid4 from idevaff_iptracking where tid4 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get4)) {
echo "<option value='none'>TID4: ";
{/php}
{$cr_select}
{php}
echo "</option>\n";
while ($qry = mysql_fetch_array($get4)) {
$tid4_value = $qry['tid4'];
echo "<option value='$tid4_value'>$tid4_value</option>\n";
} } else {
echo "<option value='none'>TID4: ";
{/php}
{$cr_none}
{php}
echo "</option>\n"; }
echo "</select>";
{/php}

</td></form>



</tr>


</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />


{if isset($custom_logs_exist)}



<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%" colspan="3">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="50%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$cr_title}</font></b></td>
<td width="50%" colspan="2" bgcolor="{$table_top}" align="right"><b><font color="{$section_head_txt}">{$report_total_links} {$cr_unique}</font></b>&nbsp;</td>
</tr>

<tr>
<td width="62%" bgcolor="{$lighter_cells}"><b>&nbsp;{$cr_used}</b></td>
<td width="15%" align="center" bgcolor="{$lighter_cells}"><b>{$cr_found}</b></td>
<td width="23%" align="center" bgcolor="{$lighter_cells}"><b>{$cr_detailed}</b></td>
</tr>

{section name=nr loop=$report_results}

<tr {if $smarty.section.nr.iteration is even} bgcolor="{$lighter_cells}"{else}bgcolor="{$white_back}"{/if}>

<td width="62%">&nbsp;{$report_results[nr].report_keywords}</td>
<td width="15%" align="center">{$report_results[nr].report_links} {$cr_times}</td>
<td width="23%" align="center"><form method="POST" action="export/export.php">
<input type="hidden" name="export" value="1">
<input type="hidden" name="custom_links_report" value="1">
<input type="hidden" name="linkid" value="{$affiliate_id}">

<input type="hidden" name="tid1" value="{$report_results[nr].report_tid1}">
<input type="hidden" name="tid2" value="{$report_results[nr].report_tid2}">
<input type="hidden" name="tid3" value="{$report_results[nr].report_tid3}">
<input type="hidden" name="tid4" value="{$report_results[nr].report_tid4}">

<input type="submit" value="{$cr_export}" name="print_invoice" class="ReportsButton"> 

</td></form></td>

</tr>

{/section}

</table>
</td>
</tr>
</table>

{elseif isset($no_results_found)}



<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%" colspan="3">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$cr_title}</font></b></td>
</tr>

<tr><td width="100%" align="center" bgcolor="{$lighter_cells}"><br /><b>{$cr_no_results}</b><BR />{$cr_no_results_info}<br /><BR /></td></tr>

</table>
</td>
</tr>
</table>

{/if}

{/if}

<br />