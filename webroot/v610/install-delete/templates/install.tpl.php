<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PHP Pro Bid v6.10 Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.c1feat { background-image:  url(templates/img/bgfeat.gif);} /* blue */
-->
</style>
</head>
<body bgcolor="#ffffff" leftmargin="10" topmargin="5" marginwidth="10" marginheight="5">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
      <td width="100%"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="templates/img/headbg.gif">
            <tr valign="top" height="97">
               <td width="31" style="padding-top: 74px;"><img src="templates/img/pixel.gif" width="31" height="11" border="0"></td>
               <td width="260" style="background-image:url(templates/img/logo_bg.gif); background-repeat: no-repeat;" align="center" valign="middle"><div><img src="../images/probidlogo.gif" alt="Professional Auction Script Software by PHP Pro Bid" border="0" width="216" height="50"></div>
                  <div><img src="templates/img/pixel.gif" width="260" height="6"></div></td>
               <td width="100%" class="toplink" style="padding-top: 29px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr valign="top" align="left">
                        <td width="5"><img src="templates/img/pixel.gif" width="5" height="1"></td>
                        <? if ($install_step == 'welcome') { ?>
                        <td width="16"><img src="templates/img/db_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="db" width="14%">Welcome</td>
                        <? } else { ?>
                        <td width="16"><img src="templates/img/lb_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="lb" width="14%">Welcome</td>
                        <? } ?>
                        <? if ($install_step == 'config_details') { ?>
                        <td width="16"><img src="templates/img/db_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="db" width="14%">Configuration</td>
                        <? } else { ?>
                        <td width="16"><img src="templates/img/lb_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="lb" width="14%">Configuration</td>
                        <? } ?>
                        <? if ($install_step == 'connection') { ?>
                        <td width="16"><img src="templates/img/db_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="db" width="14%">Database Connection</td>
                        <? } else { ?>
                        <td width="16"><img src="templates/img/lb_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="lb" width="14%">Database Connection</td>
                        <? } ?>
                        <? if ($install_step == 'choose_install') { ?>
                        <td width="16"><img src="templates/img/db_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="db" width="14%">Installation Type</td>
                        <? } else { ?>
                        <td width="16"><img src="templates/img/lb_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="lb" width="14%">Installation Type</td>
                        <? } ?>
                        <? if ($install_step == 'upload_sql') { ?>
                        <td width="16"><img src="templates/img/db_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="db" width="14%">Upload SQL Queries</td>
                        <? } else { ?>
                        <td width="16"><img src="templates/img/lb_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="lb" width="14%">Upload SQL Queries</td>
                        <? } ?>
                        <? if ($install_step == 'site_settings') { ?>
                        <td width="16"><img src="templates/img/db_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="db" width="14%">Site Settings</td>
                        <? } else { ?>
                        <td width="16"><img src="templates/img/lb_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="lb" width="14%">Site Settings</td>
                        <? } ?>
                        <? if ($install_step == 'finish') { ?>
                        <td width="16"><img src="templates/img/db_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="db" width="14%">Finish</td>
                        <? } else { ?>
                        <td width="16"><img src="templates/img/lb_bg.gif" width="16" height="30" border="0"></td>
                        <td nowrap class="lb" width="14%">Finish</td>
                        <? } ?>
                     </tr>
                  </table>
                  <div><img src="templates/img/pixel.gif" width="1" height="11"></div>
                  <div style="padding-left: 15px; font-weight: bold; font-size: 16px;">
                     <?=$step_title;?>
                  </div></td>
            </tr>
         </table>
         <br>
         <form action="install.php" method="POST">
	         <input type="hidden" name="install_step" value="<?=$next_step;?>" >
         <table width="75%" border="0" cellspacing="4" cellpadding="4" align="center">
            <tr valign="top">
               <td><?=$install_page_content;?></td>
            </tr>
            <? if ($next_step) { ?>
            <tr valign="top">
               <td align="right">
               	<? if ($refresh) { ?>
               	<input type="submit" name="btn_refresh" value="Refresh" > &nbsp;
               	<? } ?>
               	<input type="submit" name="next_step_proceed" value="Next Step >" ></td>
            </tr>
            <? } ?>
         </table>
         </form>
         <br>
         <div style="border-top: 2px solid #a6a6a6;"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
         <div align="center" class="footerfont1"> Copyright &copy;2010 <strong>PHP Pro Software LTD</strong>. All Rights Reserved.<br>Designated trademarks and brands are the property of their respective owners.<br>
         </div></td>
   </tr>
</table>
</body>
</html>
