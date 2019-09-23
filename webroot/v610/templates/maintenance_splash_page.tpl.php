<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="themes/<?=$setts['default_theme'];?>/style.css" rel="stylesheet" type="text/css">
<title><?=$setts['sitename'];?> - <?=MSG_MAINTENANCE_MODE;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<br><br><br><br><br><br>
<table width="300" border="0" cellpadding="3" cellspacing="2" align="center" class="border">
	<tr>
		<td colspan="2" class="c1" align="center">
		<?=$setts['sitename'];?> - <?=MSG_MAINTENANCE_MODE;?>
		</td>
	</tr>
	<tr>
		<td class="c2"><img src="themes/<?=$setts['default_theme'];?>/img/system/maintenance.gif"></td>
		<td width="100%" class="c2">
		<?=MSG_MAINTENANCE_MODE_EXPL;?>
		</td>
	</tr>
</table>
</body>
</html>
