<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td colspan="10" class="c7"><b><?=MSG_MM_SAVED_SEARCHES;?></b></td>
   </tr>
	<tr class="c4">
		<td><?=MSG_DETAILS;?></td>
		<td width="150" align="center"><?=GMSG_OPTIONS;?></td>
   </tr>
	<?=$saved_searches_content;?>
</table>