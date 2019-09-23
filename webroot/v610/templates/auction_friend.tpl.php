<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
   <tr>
      <td class="c3" colspan="2"><b>
         <?=MSG_SEND_TO_FRIEND;?>
         </b></td>
   </tr>
   <tr>
      <td class="c5" colspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <?=$display_formcheck_errors;?>
   <form action="auction_details.php" method="post">
      <input type="hidden" name="option" value="auction_friend">
      <input type="hidden" name="auction_id" value="<?=$auction_id;?>">
   	<input type="hidden" name="generated_pin" value="<?=$generated_pin;?>">
      <tr class="c1">
         <td nowrap align="right"><?=MSG_YOUR_NAME;?></td>
         <td><input type="text" name="name" value="<?=$post_details['name'];?>" size="40"></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><?=MSG_YOUR_EMAIL_ADDRESS;?></td>
         <td><input type="text" name="email" value="<?=$post_details['email'];?>" size="40"></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><?=MSG_FRIENDS_NAME;?></td>
         <td><input type="text" name="friend_name" value="<?=$post_details['friend_name'];?>" size="40"></td>
      </tr>
      <tr class="c1">
         <td align="right" nowrap><?=MSG_FRIENDS_EMAIL;?></td>
         <td><input type="text" name="friend_email" value="<?=$post_details['friend_email'];?>" size="40"></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr class="c1">
         <td align="right"><b>
            <?=MSG_PIN_CODE;?>
            </b></td>
         <td><?=$pin_image_output;?></td>
      </tr>
      <tr class="c1">
         <td align="right"><b>
            <?=MSG_CONF_PIN;?>
            </b></td>
         <td><input name="pin_value" type="text" class="contentfont" id="pin_value" value="" size="20" /></td>
      </tr>
      <tr class="c4">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
         <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      </tr>
      <tr class="c1">
         <td align="right" nowrap><?=MSG_COMMENTS;?></td>
         <td><textarea name="comments" style="width: 100%; height: 100" id="comments"><?=$post_details['comments'];?></textarea></td>
      </tr>
      <tr>
         <td colspan="2" class="c4"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
         <td colspan="2" class="contentfont" align="center"><input type="submit" value="<?=GMSG_PROCEED;?>" name="form_auction_friend">
         </td>
      </tr>
   </form>
</table>
<br>
