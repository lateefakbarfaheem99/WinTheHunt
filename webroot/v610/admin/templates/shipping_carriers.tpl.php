<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/auction.gif" align="absmiddle"> <?=$header_section;?></div>
<?=$msg_changes_saved;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="4"><img src="images/c1.gif" width="4" height="4"></td>
		<td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
		<td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="3" class="fside">
   <form name="form" action="shipping_carriers.php" method="post">
      <tr>
         <td class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
            <?=$subpage_title;?>
            </b></td>
		</tr>
      <tr>
         <td><?=AMSG_SHIPPING_CARRIERS_NOTE;?></td>
      </tr>
      <tr class="c4">
         <td><b><?=AMSG_ACTIVE;?>: <?=$active_carriers_message;?></b></td>
      </tr>
      <?=$carriers_table_rows;?>
      <tr>
         <td align="center"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>"></td>
      </tr>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="4"><img src="images/c3.gif" width="4" height="4"></td>
		<td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
		<td width="4"><img src="images/c4.gif" width="4" height="4"></td>
	</tr>
</table>