<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/tables.gif" align="absmiddle"> <?=AMSG_TABLES_MANAGEMENT;?></div>
<?=$msg_changes_saved;?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="4"><img src="images/c1.gif" width="4" height="4"></td>
		<td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
		<td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="3" class="fside">
   <form action="table_postage_tiers.php" method="post">
   	<input type="hidden" name="tier_type" value="<?=$tier_type;?>">
      <tr class="c3">
         <td colspan="2" style="padding: 3px;"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b><?=$subpage_title;?></b></td>
      </tr>
      <tr valign="top">
         <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
               <tr class="c4">
                  <td width="20">&nbsp;</td>
                  <td width="120"><? echo ($tier_type == 'weight') ? GMSG_WEIGHT_FROM : GMSG_AMOUNT_FROM;?></td>
                  <td width="120"><? echo ($tier_type == 'weight') ? GMSG_WEIGHT_TO : GMSG_AMOUNT_TO;?></td>
                  <td><?=GMSG_AMOUNT;?> [<?=$setts['currency'];?>]</td>
                  <td width="80" align="center"><?=AMSG_DELETE;?></td>
               </tr>
               <?=$postage_tiers_page_content;?>
            </table></td>
      </tr>
      <tr class="c4">
         <td style="padding: 3px;"><?=AMSG_ADD_TIER;?></td>
      </tr>
      <tr>
         <td><table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
            <tr class="c1">
               <td width="20">&nbsp;</td>
               <td width="120"><input type="text" name="new_tier_from" size="12" /></td>
               <td width="120"><input type="text" name="new_tier_to" size="12" /></td>
               <td><input type="text" name="new_postage_amount" size="12" /></td>
               <td width="80" align="center">&nbsp;</td>
            </tr>
         </table></td>
      </tr>
      <tr>
         <td align="center" style="padding: 3px;"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>"></td>
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