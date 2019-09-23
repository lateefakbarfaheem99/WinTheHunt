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
      <td class="c7" colspan="2"><b>
         <?=MSG_REPORT_ABUSE_TO_ADMIN;?>
         </b></td>
   </tr>
   <tr class="c5">
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <?=$display_formcheck_errors;?>
   <form action="members_area.php?page=account&section=abuse_report" method="post">
   	<input type="hidden" name="auction_id" value="<?=$auction_id;?>">
   	<? if ($auction_id) { ?>
      <tr class="c1">
         <td nowrap="nowrap" align="right"><?=MSG_AUCTION_ID;?> / <?=MSG_ITEM_TITLE;?></td>
         <td width="100%">#<?=$auction_id;?> - <?=$item_details['name'];?></td>
      </tr>
		<? } ?>   	
      <tr class="c1">
         <td nowrap="nowrap" align="right"><?=MSG_USERNAME;?></td>
         <td width="100%">
         	<? if ($auction_id) { ?>
         		<?=$item_details['username'];?>
         		<input type="hidden" name="abuser_username" value="<?=$item_details['username'];?>" />         	
         	<? } else { ?>
         		<input type="text" name="abuser_username" value="<?=$post_details['abuser_username'];?>" />
         	<? } ?>
         </td>
      </tr>
      <tr class="c1">
         <td nowrap="nowrap" align="right"><?=MSG_COMMENTS;?></td>
         <td ><textarea name="comment" style="width: 100%; height: 100" id="block_reason"><?=$post_details['comment'];?></textarea></td>
      </tr>
      <tr>
         <td colspan="2" class="c4"></td>
      </tr>
      <tr>
         <td colspan="2" class="contentfont"><input type="submit" value="<?=GMSG_PROCEED;?>" name="form_add_abuse_report"></td>
      </tr>
   </form>
</table>