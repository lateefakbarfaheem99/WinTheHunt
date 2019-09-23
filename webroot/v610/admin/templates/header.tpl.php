<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<html>
<head>
<title>
<?=$setts['sitename'];?> 
<?=AMSG_ADMIN_AREA?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CODEPAGE;?>">
<?=$global_header_content;?>
</head>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="main.js"></script>
<!--<script language=JavaScript src='../scripts/innovaeditor.js'></script>-->
</head><body leftmargin="8" topmargin="20" bgcolor="#ffffff">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #777777; background-image: url(images/bg_head.gif); background-repeat: repeat-x; background-position: bottom;">
   <tr valign="top">
      <td height="67"><img src="images/adminlogo.gif"></td>
      <td><div><img src="images/admin_txt.gif"></div>
         <div align="center" class="version">current version:
            <?=$current_version;?>
         </div></td>
      <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr align="center" valign="top">
               <td width="14%"><a href="index.php"><img src="images/admin_home.gif" border="0"></a>
                  <div style="icontext">Admin Home</div></td>
               <td width="14%"><a href="<?=SITE_PATH;?>index.php" target="_blank"><img src="images/site_home.gif" border="0"></a>
                  <div style="icontext">Site Home</div></td>
               <td width="14%"><a href="http://www.phpprobid.com/client/support/pdesk.cgi" target="_blank"><img src="images/support.gif" border="0"></a>
                  <div style="icontext">
                     <?=AMSG_SUPPORT_DESK;?>
                  </div></td>
               <td width="14%"><a href="http://www.phpprobid.com/client/manuals/manual.pdf" target="_blank"><img src="images/manual.gif" border="0"></a>
                  <div style="icontext">
                     <?=AMSG_PPB_MANUAL;?>
                  </div></td>
               <td width="14%"><a href="accounting.php"><img src="images/account.gif" border="0"></a>
                  <div style="icontext">
                     <?=AMSG_ACCOUNTING;?>
                  </div></td>
               <td width="30%" align="right" style="padding-right: 15px;"><a href="index.php?option=logout"><img src="images/logout.gif" border="0"></a>
                  <div style="icontext">Logout&nbsp;</div></td>
            </tr>
         </table></td>
   </tr>
</table>
<div><img src="images/pixel.gif" border="0" width="1" height="7"></div>
<table width="100%" border="0" cellspacing="4" cellpadding="0">
<tr>
   <td width="220" valign="top"><?=$admin_left_menu;?>
      <div><img src="images/pixel.gif" border="0" width="220" height="1"></div></td>
   <td width="10"><img src="images/pixel.gif" height="1" width="10"></td>
   <td  valign="top" width="100%"><?=$updated_categories_message;?>
