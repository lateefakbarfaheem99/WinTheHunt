<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<div class="mainhead"><img src="images/tables.gif" align="absmiddle"> <?=$header_section;?></div>
<?=$msg_changes_saved;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="4"><img src="images/c1.gif" width="4" height="4"></td>
		<td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
		<td width="4"><img src="images/c2.gif" width="4" height="4"></td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form action="table_reverse_budgets.php" method="post">
    <tr class="c3">
       <td colspan="3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b><?=strtoupper($subpage_title);?></b></td>
    </tr>
     <tr valign="top">
         <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="1">
               <tr class="c4">
                  <td width="20">&nbsp;</td>
                  <td width="120"><?=GMSG_FROM;?></td>
                  <td width="120"><?=GMSG_TO;?></td>
                  <td width="120"><?=AMSG_ORDER_ID;?></td>
                  <td><?=GMSG_SAMPLE_OUTPUT;?></td>
                  <td width="80" align="center"><?=AMSG_DELETE;?></td>
               </tr>
               <?=$budgets_page_content;?>
            </table></td>
      </tr>
      <tr class="c4">
         <td><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <?=AMSG_ADD_BUDGET;?></td>
      </tr>
      <tr>
         <td><table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
            <tr class="c2">
               <td width="20">&nbsp;</td>
               <td width="120"><input type="text" name="new_value_from" size="12" /></td>
               <td width="120"><input type="text" name="new_value_to" size="12" /></td>
               <td width="120"></td>
               <td></td>
               <td width="80" align="center">&nbsp;</td>
            </tr>
         </table></td>
      </tr>
      <tr valign="top" class="c1">
         <td><img src="images/info.gif" align="absmiddle"> <?=AMSG_REVERSE_BUDGETS_TABLE_NOTE;?></td>
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