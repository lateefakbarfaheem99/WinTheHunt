<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

?>

<input type="hidden" name="option" value="create_settings" />
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="2" class="c3">Site Settings</td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right" class="contentfont">Site Name </td>
      <td class="contentfont"><input name="sitename" type="text" id="sitename" value="<?=$setts['sitename'];?>" size="40" /></td>
   </tr>
   <tr class="reguser">
      <td>&nbsp;</td>
      <td>Enter your site's name (eg. PHP Pro Bid)</td>
   </tr>
   <tr class="c1">
      <td align="right" class="contentfont">Site URL</td>
      <td class="contentfont"><input name="site_path" type="text" class="contentfont" id="site_path" value="<? echo ($setts['site_path']) ? $setts['site_path'] : 'http://'; ?>" size="40" /></td>
   </tr>
   <tr class="reguser">
      <td align="right" class="contentfont">&nbsp;</td>
      <td>Enter your site's URL (eg. http://www.phpprobid.com/)<br> 
        <strong>NOTE:</strong> You must enter the &quot;http://&quot; statement before your address, and a slash at the end of the address;<br> 
        for eg www.phpprobid.com is invalid!<br> 
        <strong>Correct Value: </strong>http://www.phpprobid.com/</td>
   </tr>
   <tr class="c1">
      <td width="150" align="right" class="contentfont">Admin Email</td>
      <td class="contentfont"><input name="admin_email" type="text" id="admin_email" value="<?=$setts['admin_email'];?>" size="40" /></td>
   </tr>
   <tr class="reguser">
      <td>&nbsp;</td>
      <td>Enter your admin email (eg. admin@phpprobid.com)<br> 
        <b>NOTE:</b> This email will be used by the script to send emails, so all your users will reply to this email</td>
   </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="2" class="c3">Default Admin User Setup</td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right" class="contentfont">Username </td>
      <td class="contentfont"><input name="username" type="text" id="username" value="" size="30" /></td>
   </tr>
   <tr class="reguser">
      <td>&nbsp;</td>
      <td>Enter the default username to access the site's admin area</td>
   </tr>
   <tr class="c1">
      <td align="right" class="contentfont">Password</td>
      <td class="contentfont"><input name="password" type="text" class="contentfont" id="password" value="" size="30" /></td>
   </tr>
   <tr class="reguser">
      <td align="right" class="contentfont">&nbsp;</td>
      <td>Enter the password for the default admin user</td>
   </tr>
</table>