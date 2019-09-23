<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c7"><?=MSG_LEAVE_COMMENTS;?>
         <?=strtolower(GMSG_TO);?>
         <b>
         <?=$reputation_details['username'];?>
         </b>
         <?=strtolower(GMSG_FOR);?>
         <b>
         <?=$reputation_details['auction_name'];?>
         </b></td>
   </tr>
   <tr>
      <td class="c4"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <?=$display_formcheck_errors;?>
   <tr>
      <td><table width="450" align="center" border="0" cellpadding="3" cellspacing="2" class="border">
            <form action="members_area.php?page=reputation&section=post" method="post">
               <input type="hidden" name="reputation_ids" value="<?=$reputation_ids;?>">
               <tr class="membmenu">
                  <td align="center"><?=MSG_RATE;?></td>
                  <td><?=MSG_COMMENTS;?></td>
               </tr>
               <tr class="c5">
                  <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
                  <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
               </tr>
               <tr class="c1">
                  <td align="center"><input name="reputation_rate" type="radio" value="5" checked="checked" />
                     <img src="themes/<?=$setts['default_theme'];?>/img/system/5stars.gif" /><br />
                     <input type="radio" name="reputation_rate" value="4" <? echo ($post_details['reputation_rate']==4) ? "checked" : ""; ?> />
                     <img src="themes/<?=$setts['default_theme'];?>/img/system/4stars.gif" /><br />
                     <input type="radio" name="reputation_rate" value="3" <? echo ($post_details['reputation_rate']==3) ? "checked" : ""; ?> />
                     <img src="themes/<?=$setts['default_theme'];?>/img/system/3stars.gif" /><br />
                     <input type="radio" name="reputation_rate" value="2" <? echo ($post_details['reputation_rate']==2) ? "checked" : ""; ?> />
                     <img src="themes/<?=$setts['default_theme'];?>/img/system/2stars.gif" /><br />
                     <input type="radio" name="reputation_rate" value="1" <? echo ($post_details['reputation_rate']==1) ? "checked" : ""; ?> />
                     <img src="themes/<?=$setts['default_theme'];?>/img/system/1stars.gif" /></td>
                  <td><textarea name="reputation_content" style="width: 100%; height: 100" id="reputation_content"><?=$post_details['reputation_content'];?></textarea></td>
               </tr>
               <tr>
                  <td colspan="2" class="c4"></td>
               </tr>
               <?=$custom_sections_table;?>
               <tr>
                  <td colspan="2" class="c4"></td>
               </tr>
               <tr>
                  <td colspan="2" class="contentfont" align="center"><input type="submit" value="<?=MSG_LEAVE_COMMENTS;?>" name="form_leave_comments">
                  </td>
               </tr>
            </form>
         </table></td>
   </tr>
</table>
