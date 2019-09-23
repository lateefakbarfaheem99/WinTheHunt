{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>{$sitename} - {$header_title}</title>
<link rel="stylesheet" type="text/css" href="templates/style.css">
<link rel="shortcut icon" href="images/favicon.ico">
<link rel="stylesheet" href="lightboxes/source/css/lightbox.css" type="text/css" />
<link href="templates/greybox/css/gb_styles.css" rel="stylesheet" type="text/css" media="all" />

{literal}
<script type="text/javascript" language="javascript1.2" src="lightboxes/source/js/prototype.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript1.2" src="lightboxes/source/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" language="javascript1.2" src="lightboxes/source/js/lightbox.js" type="text/javascript"></script>

<script type="text/javascript" language="javascript1.2">
	var fileLoadingImage = "lightboxes/source/images/loading.gif";	
	var fileBottomNavCloseImage = "lightboxes/source/images/closelabel.gif";
</script>

<script type="text/javascript">var dmWorkPath = "templates/menus/";</script>
<script type="text/javascript" src="templates/menus/menu.js"></script>

<script type="text/javascript">
GB_myShow = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: 'iDevAffiliate Video Training',
        height: height || 520,
        width: width || 660,
	  center_win:true,
        fullscreen: false,
        show_loading: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}
</script>

    <script type="text/javascript" language="javascript1.2">
        var GB_ROOT_DIR = "templates/greybox/";
    </script>

    <script type="text/javascript" language="javascript1.2" src="templates/greybox/AJS.js"></script>
    <script type="text/javascript" language="javascript1.2" src="templates/greybox/AJS_fx.js"></script>
    <script type="text/javascript" language="javascript1.2" src="templates/greybox/gb_scripts.js"></script>

<script language="JavaScript" type="text/javascript">
function textCounter(field,cntfield,maxlimit) {
if (field.value.length > maxlimit)
field.value = field.value.substring(0, maxlimit);
else
cntfield.value = maxlimit - field.value.length; }
</script>
{/literal}

</head>
{$custom_testname}
<body bgcolor="{$page_back}" background="{$page_bkg_image}">


<table align="{$page_align}" border="0" cellpadding="4" cellspacing="0" width="{$panel_width}{$joinperc}">
<form method="POST" action="{$localserver}">
<tr>
<td width="100%"><img border="0" src="{$main_logo}" alt="{$sitename} - {$header_title}"></td>
</tr>
</table>

<table align="{$page_align}" border="0" cellpadding="4" cellspacing="0" width="{$panel_width}{$joinperc}">

{* Here is your header content, have at it and let us know if you do something extra special with your design so we can showcase your website. *}

<tr>

<td width="55%" class="nomargins" bgcolor="{$cp_head_back}"><a href="index.php"><font color="{$top_bot_links}"><b>{$header_indexLink}</b></font></a><font color="{$top_bot_links}"> :: </font><a href="signup.php"><font color="{$top_bot_links}"><b>{$header_signupLink}</b></font></a><font color="{$top_bot_links}"> :: </font><a href="account.php"><font color="{$top_bot_links}"><b>{$header_accountLink}</b></font></a><font color="{$top_bot_links}"> :: </font><a href="contact.php"><font color="{$top_bot_links}"><b>{$header_emailLink}</b></font></a>{if isset($use_faq) && ($faq_location == 1)}<font color="{$top_bot_links}"> :: </font><a href="faq.php"><font color="{$top_bot_links}"><b>FAQ</b></font></a>{/if}</td>
<td width="30%" class="nomargins" bgcolor="{$cp_head_back}"><b><font color="{$top_bot_text}">{$header_greeting}, {if isset($affiliateUsername)}{$affiliateUsername} - </font></b><a href="logout.php"><font color="{$alt_links}"><b>{$header_logout}</b></font></a>{else}{$header_nonLogged}!</font></b>{/if}</td>
<td width="15%" class="nomargins" bgcolor="{$cp_head_back}" align="right">
<select size="1" name="language" onchange='this.form.submit()'>
{php}
$get_lang_packs = mysql_query("select name from idevaff_language_packs where status = '1' ORDER BY name");
if (mysql_num_rows($get_lang_packs)) {
while ($pack = mysql_fetch_array($get_lang_packs)) {
$pack_value = $pack[name];
$pack_name = ucwords($pack[name]);
echo "<option value='$pack_value'";
if ($_SESSION['language'] == $pack_value) {
echo " selected"; }
echo ">$pack_name</option>\n"; } }
{/php}</select></td></form>

</tr>

</table>


