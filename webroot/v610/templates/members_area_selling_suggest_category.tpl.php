<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c7" colspan="2"><b>
         <?=MSG_MM_SUGGEST_CATEGORY;?>
         </b></td>
   </tr>
   <tr>
      <td class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td class="c5" width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <?=$display_formcheck_errors;?>
   <form action="members_area.php?page=selling&section=suggest_category" method="post">
      <input type="hidden" name="do" value="add_suggested_category">
      <tr class="c1">
         <td nowrap="nowrap" align="right"><?=MSG_ENTER_DESCRIPTION;?></td>
         <td width="100%"><textarea name="category_desc" style="width: 100%; height: 100px;"></textarea></td>
      </tr>
      <tr>
         <td colspan="2" class="c4"></td>
      </tr>
      <tr>
         <td colspan="2" class="contentfont"><input type="submit" value="<?=GMSG_PROCEED;?>" name="form_suggest_category"></td>
      </tr>
   </form>
</table>
