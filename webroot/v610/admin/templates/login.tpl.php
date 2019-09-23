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
<?=$setts['sitename'];?> Admin Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" bgcolor="#f6f8fa">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height: 100%;">
   <tr>
      <td align="center"><form name="form1" method="post" action="index.php">
            <input name="adminloginok" type="hidden" id="adminloginok" value="Login">
            <div style="width: 245px; height: 219px; background-image:url(images/loginbg.gif); background-repeat: no-repeat;" align="center">
               <div><img src="images/pixel.gif" width="1" height="65"></div>
               <table width="220" border="0" cellspacing="1" cellpadding="1">
                  <tr align="center">
                     <td colspan="2" bgcolor="#63676c" style="color: #ffffff; font-weight: bold;"><?=AMSG_LOGIN_ADMIN_AREA;?></td>
                  </tr>
                  <tr align="center">
                     <td colspan="2"><img src="images/pixel.gif" width="1" height="2"></td>
                  </tr>
                  <tr>
                     <td width="35%" align="right" class="login"><?=AMSG_USERNAME;?>
                        :&nbsp;</td>
                     <td width="65%"><input name="username" type="text" id="username" size="25"></td>
                  </tr>
                  <tr>
                     <td align="right" class="login"><?=AMSG_PASSWORD;?>
                        :&nbsp;</td>
                     <td><input name="password" type="password" id="password" size="25"></td>
                  </tr>
                  <tr>
                     <td align="right" class="login"><?=AMSG_PIN_CODE;?>
                        :&nbsp;</td>
                     <td><div style="border: 1px solid #dbeff9; width:50px ;">
                           <?=$pin_image_output;?>
                        </div>
                        <input type="hidden" name="pin_generated" value="<?=$admin_pin_value;?>"></td>
                  </tr>
                  <tr>
                     <td align="right" class="login"><?=AMSG_ENTER_PIN_CODE;?>
                        :&nbsp;</td>
                     <td><input name="pin_submitted" type="text" id="pin_submitted" size="25"></td>
                  </tr>
                  <tr>
                     <td>&nbsp;</td>
                     <td><input name="adminloginok" type="image" src="images/login.gif" id="adminloginok" value="Login"></td>
                  </tr>
               </table>
            </div>
            <div class="copy">Copyright &copy;2011 PHP Pro Software LTD.<br>
               All rights reserved.</div>
            <div class="version">Current Version:
               <?=$current_version;?>
            </div>
         </form></td>
   </tr>
</table>
</body>
</html>
