<?
#################################################################
## PHP Pro Bid v6.05															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c7" colspan="3"><b>
         <?=$block_users_header_message;?>
         </b></td>
   </tr>
   <tr>
      <td class="c5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td class="c5" width="100%" colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <?=$display_formcheck_errors;?>
   <form action="members_area.php?page=selling&section=block_users" method="post">
      <input type="hidden" name="block_id" value="<?=$post_details['block_id'];?>">
      <input type="hidden" name="do" value="<?=$do;?>">
      <tr class="c1">
         <td nowrap="nowrap" align="right"><?=MSG_USERNAME;?></td>
         <td width="100%" colspan="2"><? echo ($do == 'add_user') ? '<input type="text" name="username" value="' . $post_details['username'] . '" />' : $post_details['username'];?></td>
      </tr>
      <tr class="c1">
         <td nowrap="nowrap" align="right"><?=MSG_BLOCK;?></td>
         <td><input type="checkbox" name="block_bid" value="1" <? echo ($post_details['block_bid']) ? 'checked' : ''; ?> /></td>
         <td width="100%"><?=MSG_BLOCK_BID_EXPL;?></td>
      </tr>
      <tr>
         <td nowrap="nowrap" align="right"></td>
         <td class="c1"><input type="checkbox" name="block_message" value="1" <? echo ($post_details['block_message']) ? 'checked' : ''; ?> /></td>
         <td width="100%" class="c1"><?=MSG_BLOCK_MESSAGE_EXPL;?></td>
      </tr>
      <!--
      <tr>
         <td nowrap="nowrap" align="right"></td>
         <td class="c1"><input type="checkbox" name="block_reputation" value="1" <? echo ($post_details['block_reputation']) ? 'checked' : ''; ?> /></td>
         <td width="100%" class="c1"><?=MSG_BLOCK_REPUTATION_EXPL;?></td>
      </tr>
      -->
      <tr class="c1">
         <td nowrap="nowrap" align="right"><?=MSG_BLOCK_REASON;?></td>
         <td colspan="2" ><textarea name="block_reason" style="width: 100%; height: 100" id="block_reason"><?=$post_details['block_reason'];?></textarea></td>
      </tr>
      <tr class="c1">
         <td nowrap="nowrap" align="right"><?=MSG_SHOW_REASON;?></td>
         <td width="100%" colspan="2"><input type="checkbox" name="show_reason" value="1" <? echo ($post_details['show_reason']) ? 'checked' : ''; ?> /></td>
      </tr>
      <tr>
         <td colspan="3" class="c4"></td>
      </tr>
      <tr>
         <td colspan="3" class="contentfont"><input type="submit" value="<?=GMSG_PROCEED;?>" name="form_add_blocked_user"></td>
      </tr>
   </form>
</table>
