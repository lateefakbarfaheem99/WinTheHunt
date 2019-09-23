<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

?>

<input type="hidden" name="option" value="create_config" />
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="2" class="c3">Database Setup</td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right" class="contentfont">Host Name </td>
      <td class="contentfont"><input name="db_host" type="text" id="db_host" value="localhost" size="40" /></td>
   </tr>
   <tr class="reguser">
      <td>&nbsp;</td>
      <td>Enter the host's name (in most cases, it's localhost)</td>
   </tr>
   <tr class="c1">
      <td align="right" class="contentfont">Database Name</td>
      <td class="contentfont"><input name="db_name" type="text" class="contentfont" id="db_name" value="" size="40" /></td>
   </tr>
   <tr class="reguser">
      <td align="right" class="contentfont">&nbsp;</td>
      <td>Enter the database's name, as you have chosen it when you installed the database on the server</td>
   </tr>
   <tr class="c1">
      <td width="150" align="right" class="contentfont">Database User</td>
      <td class="contentfont"><input name="db_username" type="text" id="db_username" value="" size="25" /></td>
   </tr>
   <tr class="reguser">
      <td>&nbsp;</td>
      <td>Enter the database's username</td>
   </tr>
   <tr class="c1">
      <td width="150" align="right" class="contentfont">Database Password</td>
      <td class="contentfont"><input name="db_password" type="password" id="db_password" value="" size="25" /></td>
   </tr>
   <tr class="c1">
      <td width="150" align="right" class="contentfont">Tables Prefix</td>
      <td class="contentfont"><input name="table_prefix" type="text" id="table_prefix" value="probid_" size="40" /></td>
   </tr>
   <tr class="reguser">
      <td>&nbsp;</td>
      <td>Enter a prefix for your tables (default: <b>probid_</b>)</td>
   </tr>
</table>
