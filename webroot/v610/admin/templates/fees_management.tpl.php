<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/fees.gif" align="absmiddle">
   <?=$header_section;?>
</div>
<?=$display_formcheck_errors;?>
<?=$msg_changes_saved;?>
<?=$management_box;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <form action="fees_management.php" method="get">
      <tr>
         <td colspan="2" class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
            <?=strtoupper($subpage_title);?>
            </b></td>
      </tr>
      <tr class="c2">
         <td width="150"><b>Select Category </b></td>
         <td nowrap><?=$categories_list_menu;?>
            <input type="submit" name="form_select_account" value="<?=GMSG_PROCEED;?>" <?=$disabled_button;?> /></td>
      </tr>
   </form>
   <tr>
      <td colspan="2"><?=$fees_table;?></td>
   </tr>
</table>
<?=$fees_box;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
