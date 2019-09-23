<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>
<?=$setts['sitename'];?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CODEPAGE;?>">
<link href="themes/<?=$setts['default_theme'];?>/style.css" rel="stylesheet" type="text/css">
<? if ($setts['default_theme'] == 'ultra') { ?>
<script src="themes/<?=$setts['default_theme'];?>/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="themes/<?=$setts['default_theme'];?>/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="themes/<?=$setts['default_theme'];?>/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="themes/<?=$setts['default_theme'];?>/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<? } ?>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
</head>
<body>