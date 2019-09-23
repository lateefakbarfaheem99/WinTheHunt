{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

<tr><td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<font color="{$section_head_txt}"><b>{$custom_fields_title}</b></font></td></tr>

{php}

$getcellcolor = mysql_query("select lighter_cells from idevaff_colors");
$lighter_cells = mysql_fetch_array($getcellcolor);
$lighter_cells = $lighter_cells[lighter_cells];
$getcustomrows = mysql_query("select name, title, def_value from idevaff_form_fields_custom order by sort");
if (mysql_num_rows($getcustomrows)) {
while ($qry = mysql_fetch_array($getcustomrows)) {
$custom_title = $qry['title'];
$custom_name = $qry['name'];
$custom_value = $qry['def_value'];
if ($_POST[$custom_name]) { $custom_value = $_POST[$custom_name]; } else { $custom_value = "$custom_value"; }
echo "<tr>";
echo "<td width='25%' bgcolor='{$lighter_cells}'>&nbsp;{$custom_title}</td>";
echo "<td width='75%' bgcolor='{$lighter_cells}' colspan='3'>&nbsp;<input type='text' name='{$custom_name}' size='20' value='{$custom_value}' style='width:250px'></td>";
echo "</tr>"; } }

{/php}

<tr><td width="100%" colspan="4" height="5"></td></tr>