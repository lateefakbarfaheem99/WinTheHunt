<?PHP

if (isset($videos_key)) {

// ----------------------------------------------------------------
// General Affiliate Marketing
// ----------------------------------------------------------------
$data = mysql_query("select * from idevaff_video_library where video_cat = '1' and video_enabled = '1' order by id");
$table_html = '';
$i = 0;
if (mysql_num_rows($data)) {
    while ($qry = mysql_fetch_array($data)) {
        $video_id = $qry['id'];
        $video_name = $qry['video_name'];
        $video_size = $qry['video_size'];
        $cell_html = "<td width='10%' bgcolor='$logged_menu' align='center'><img src='images/play.png' border='0' height='32' width='32'></td>";
        $cell_html .= "<td width='40%' bgcolor='$logged_menu'>" . "<a href='videos.php?id=" . $video_id . "' onclick='return GB_myShow(this.title, this.href)'><b>" . $video_name . "</b></a>" . "<br />Running Time: " . $video_size . " minutes.</td>";
        if($i%2 == 0) { 
            $table_html .= "<tr>" . $cell_html;
        } else {
            $table_html .= $cell_html . "</tr>"; 
        }
        $i++; } }
if($i%2 != 0) { $table_html .= "<td width='50%' colspan='2' bgcolor='$logged_menu'></td></tr>"; }
if (mysql_num_rows($data)) {
$smarty->assign('Table_Rows_General_Affiliate_Marketing', $table_html);
} else {
$cell_html = "<tr><td width='100%' bgcolor='$logged_menu'>No Videos Available</td></tr>";
$smarty->assign('Table_Rows_General_Affiliate_Marketing', $cell_html); }

// ----------------------------------------------------------------
// Marketing Materials
// ----------------------------------------------------------------
$data = mysql_query("select * from idevaff_video_library where video_cat = '2' and video_enabled = '1' order by id");
$table_html = '';
$i = 0;
if (mysql_num_rows($data)) {
    while ($qry = mysql_fetch_array($data)) {
        $video_id = $qry['id'];
        $video_name = $qry['video_name'];
        $video_size = $qry['video_size'];
        $cell_html = "<td width='10%' bgcolor='$logged_menu' align='center'><img src='images/play.png' border='0' height='32' width='32'></td>";
        $cell_html .= "<td width='40%' bgcolor='$logged_menu'>" . "<a href='videos.php?id=" . $video_id . "' onclick='return GB_myShow(this.title, this.href)'><b>" . $video_name . "</b></a>" . "<br />Running Time: " . $video_size . " minutes.</td>";
        if($i%2 == 0) { 
            $table_html .= "<tr>" . $cell_html;
        } else {
            $table_html .= $cell_html . "</tr>"; 
        }
        $i++; } }
if($i%2 != 0) { $table_html .= "<td width='50%' colspan='2' bgcolor='$logged_menu'></td></tr>"; }
if (mysql_num_rows($data)) {
$smarty->assign('Table_Rows_Marketing_Materials', $table_html);
} else {
$cell_html = "<tr><td width='100%' bgcolor='$logged_menu'>No Videos Available</td></tr>";
$smarty->assign('Table_Rows_Marketing_Materials', $cell_html); }

// ----------------------------------------------------------------
// General Account Functions
// ----------------------------------------------------------------
$data = mysql_query("select * from idevaff_video_library where video_cat = '3' and video_enabled = '1' order by id");
$table_html = '';
$i = 0;
if (mysql_num_rows($data)) {
    while ($qry = mysql_fetch_array($data)) {
        $video_id = $qry['id'];
        $video_name = $qry['video_name'];
        $video_size = $qry['video_size'];
        $cell_html = "<td width='10%' bgcolor='$logged_menu' align='center'><img src='images/play.png' border='0' height='32' width='32'></td>";
        $cell_html .= "<td width='40%' bgcolor='$logged_menu'>" . "<a href='videos.php?id=" . $video_id . "' onclick='return GB_myShow(this.title, this.href)'><b>" . $video_name . "</b></a>" . "<br />Running Time: " . $video_size . " minutes.</td>";
        if($i%2 == 0) { 
            $table_html .= "<tr>" . $cell_html;
        } else {
            $table_html .= $cell_html . "</tr>"; 
        }
        $i++; } }
if($i%2 != 0) { $table_html .= "<td width='50%' colspan='2' bgcolor='$logged_menu'></td></tr>"; }
if (mysql_num_rows($data)) {
$smarty->assign('Table_Rows_General_Account_Functions', $table_html);
} else {
$cell_html = "<tr><td width='100%' bgcolor='$logged_menu'>No Videos Available</td></tr>";
$smarty->assign('Table_Rows_General_Account_Functions', $cell_html); }


if ($second_tier == 1) {
// ----------------------------------------------------------------
// Tier System
// ----------------------------------------------------------------
$data = mysql_query("select * from idevaff_video_library where video_cat = '4' and video_enabled = '1' order by id");
$table_html = '';
$i = 0;
if (mysql_num_rows($data)) {
    while ($qry = mysql_fetch_array($data)) {
        $video_id = $qry['id'];
        $video_name = $qry['video_name'];
        $video_size = $qry['video_size'];
        $cell_html = "<td width='10%' bgcolor='$logged_menu' align='center'><img src='images/play.png' border='0' height='32' width='32'></td>";
        $cell_html .= "<td width='40%' bgcolor='$logged_menu'>" . "<a href='videos.php?id=" . $video_id . "' onclick='return GB_myShow(this.title, this.href)'><b>" . $video_name . "</b></a>" . "<br />Running Time: " . $video_size . " minutes.</td>";
        if($i%2 == 0) { 
            $table_html .= "<tr>" . $cell_html;
        } else {
            $table_html .= $cell_html . "</tr>"; 
        }
        $i++; } }
if($i%2 != 0) { $table_html .= "<td width='50%' colspan='2' bgcolor='$logged_menu'></td></tr>"; }
$smarty->assign('Table_Rows_Tier_System', $table_html);
}

// ----------------------------------------------------------------
// Advanced Affiliate Marketing
// ----------------------------------------------------------------
$data = mysql_query("select * from idevaff_video_library where video_cat = '5' and video_enabled = '1' order by id");
$table_html = '';
$i = 0;
if (mysql_num_rows($data)) {
    while ($qry = mysql_fetch_array($data)) {
        $video_id = $qry['id'];
        $video_name = $qry['video_name'];
        $video_size = $qry['video_size'];
        $cell_html = "<td width='10%' bgcolor='$logged_menu' align='center'><img src='images/play.png' border='0' height='32' width='32'></td>";
        $cell_html .= "<td width='40%' bgcolor='$logged_menu'>" . "<a href='videos.php?id=" . $video_id . "' onclick='return GB_myShow(this.title, this.href)'><b>" . $video_name . "</b></a>" . "<br />Running Time: " . $video_size . " minutes.</td>";
        if($i%2 == 0) { 
            $table_html .= "<tr>" . $cell_html;
        } else {
            $table_html .= $cell_html . "</tr>"; 
        }
        $i++; } }
if($i%2 != 0) { $table_html .= "<td width='50%' colspan='2' bgcolor='$logged_menu'></td></tr>"; }
if (mysql_num_rows($data)) {
$smarty->assign('Table_Rows_Advanced_Affiliate_Marketing', $table_html);
} else {
$cell_html = "<tr><td width='100%' bgcolor='$logged_menu'>No Videos Available</td></tr>";
$smarty->assign('Table_Rows_Advanced_Affiliate_Marketing', $cell_html); }


// ----------------------------------------------------------------
// Advanced Marketing Materials
// ----------------------------------------------------------------
$data = mysql_query("select * from idevaff_video_library where video_cat = '6' and video_enabled = '1' order by id");
$table_html = '';
$i = 0;
if (mysql_num_rows($data)) {
    while ($qry = mysql_fetch_array($data)) {
        $video_id = $qry['id'];
        $video_name = $qry['video_name'];
        $video_size = $qry['video_size'];
        $cell_html = "<td width='10%' bgcolor='$logged_menu' align='center'><img src='images/play.png' border='0' height='32' width='32'></td>";
        $cell_html .= "<td width='40%' bgcolor='$logged_menu'>" . "<a href='videos.php?id=" . $video_id . "' onclick='return GB_myShow(this.title, this.href)'><b>" . $video_name . "</b></a>" . "<br />Running Time: " . $video_size . " minutes.</td>";
        if($i%2 == 0) { 
            $table_html .= "<tr>" . $cell_html;
        } else {
            $table_html .= $cell_html . "</tr>"; 
        }
        $i++; } }
if($i%2 != 0) { $table_html .= "<td width='50%' colspan='2' bgcolor='$logged_menu'></td></tr>"; }
if (mysql_num_rows($data)) {
$smarty->assign('Table_Rows_Advanced_Marketing_Materials', $table_html);
} else {
$cell_html = "<tr><td width='100%' bgcolor='$logged_menu'>No Videos Available</td></tr>";
$smarty->assign('Table_Rows_Advanced_Marketing_Materials', $cell_html); }

// ----------------------------------------------------------------
// Professional Affiliate Marketing
// ----------------------------------------------------------------
$data = mysql_query("select * from idevaff_video_library where video_cat = '7' and video_enabled = '1' order by id");
$table_html = '';
$i = 0;
if (mysql_num_rows($data)) {
    while ($qry = mysql_fetch_array($data)) {
        $video_id = $qry['id'];
        $video_name = $qry['video_name'];
        $video_size = $qry['video_size'];
        $cell_html = "<td width='10%' bgcolor='$logged_menu' align='center'><img src='images/play.png' border='0' height='32' width='32'></td>";
        $cell_html .= "<td width='40%' bgcolor='$logged_menu'>" . "<a href='videos.php?id=" . $video_id . "' onclick='return GB_myShow(this.title, this.href)'><b>" . $video_name . "</b></a>" . "<br />Running Time: " . $video_size . " minutes.</td>";
        if($i%2 == 0) { 
            $table_html .= "<tr>" . $cell_html;
        } else {
            $table_html .= $cell_html . "</tr>"; 
        }
        $i++; } }
if($i%2 != 0) { $table_html .= "<td width='50%' colspan='2' bgcolor='$logged_menu'></td></tr>"; }
if (mysql_num_rows($data)) {
$smarty->assign('Table_Rows_Professional_Affiliate_Marketing', $table_html);
} else {
$cell_html = "<tr><td width='100%' bgcolor='$logged_menu'>No Videos Available</td></tr>";
$smarty->assign('Table_Rows_Professional_Affiliate_Marketing', $cell_html); }




} else {

// ----------------------------------------------------------------
// No Subscription - Give Free Movie Only
// ----------------------------------------------------------------
$data = mysql_query("select * from idevaff_video_library where id = '1' and video_enabled = '1' order by id");
$table_html = '';
$i = 0;
if (mysql_num_rows($data)) {
    while ($qry = mysql_fetch_array($data)) {
        $video_id = $qry['id'];
        $video_name = $qry['video_name'];
        $video_size = $qry['video_size'];
        $cell_html = "<td width='10%' bgcolor='$logged_menu' align='center'><img src='images/play.png' border='0' height='32' width='32'></td>";
        $cell_html .= "<td width='40%' bgcolor='$logged_menu'>" . "<a href='videos.php?id=" . $video_id . "' onclick='return GB_myShow(this.title, this.href)'><b>" . $video_name . "</b></a>" . "<br />Running Time: " . $video_size . " minutes.</td>";
        if($i%2 == 0) { 
            $table_html .= "<tr>" . $cell_html;
        } else {
            $table_html .= $cell_html . "</tr>"; 
        }
        $i++; } }
if($i%2 != 0) { $table_html .= "<td width='50%' colspan='2' bgcolor='$logged_menu'></td></tr>"; }
$smarty->assign('Table_Rows_General_Affiliate_Marketing', $table_html);

// ----------------------------------------------------------------
// No Subscription - No Paid Movies
// ----------------------------------------------------------------

$cell_html = "<tr><td width='100%' bgcolor='$logged_menu'>No Videos Available</td></tr>";
$smarty->assign('Table_Rows_Marketing_Materials', $cell_html);
$smarty->assign('Table_Rows_General_Account_Functions', $cell_html);
$smarty->assign('Table_Rows_Tier_System', $cell_html);
$smarty->assign('Table_Rows_Advanced_Affiliate_Marketing', $cell_html);
$smarty->assign('Table_Rows_Advanced_Marketing_Materials', $cell_html);
$smarty->assign('Table_Rows_Professional_Affiliate_Marketing', $cell_html);

}
?>

