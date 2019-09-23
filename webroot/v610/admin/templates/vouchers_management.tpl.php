<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<div class="mainhead"><img src="images/content.gif" align="absmiddle"> <?=$header_section;?></div>
<?=$msg_changes_saved;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="4"><img src="images/c1.gif" width="4" height="4"></td>
		<td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
		<td width="4"><img src="images/c2.gif" width="4" height="4"></td>
	</tr>
</table>
<?=$management_box;?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   	<tr class="c3">
       <td colspan="5"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b><?=strtoupper($subpage_title);?></b></td>
   </tr>
   <tr>
      <td colspan="5"><img src="images/a.gif" align="absmiddle" ><b><?=AMSG_SIGNUP_VOUCHERS;?></b> / [ <a href="vouchers_management.php?do=add_voucher&voucher_type=signup">
         <?=AMSG_ADD_SIGNUP_VOUCHER;?>
         </a> ]</td>
   </tr>
	<tr class="c4">
   	<td width="150"><?=AMSG_VOUCHER_NAME;?></td>
    <td width="100"><?=AMSG_VOUCHER_CODE;?></td>
		<td><?=AMSG_VOUCHER_DETAILS;?></td>
    <td width="150" align="center"><?=AMSG_OPTIONS;?></td>
   </tr>
	<?=$signup_vouchers_content;?>
   <tr>
      <td colspan="5"><img src="images/a.gif" align="absmiddle" ><b><?=AMSG_SETUP_VOUCHERS;?></b> / [ <a href="vouchers_management.php?do=add_voucher&voucher_type=setup">
         <?=AMSG_ADD_SETUP_VOUCHER;?>
         </a> ]</td>
   </tr>
	<tr class="c4">
   	<td width="150"><?=AMSG_VOUCHER_NAME;?></td>
      <td width="100"><?=AMSG_VOUCHER_CODE;?></td>
		<td><?=AMSG_VOUCHER_DETAILS;?></td>
      <td width="150" align="center"><?=AMSG_OPTIONS;?></td>
   </tr>
   <?=$setup_vouchers_content;?>
   <tr>
      <td colspan="5"> </td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>