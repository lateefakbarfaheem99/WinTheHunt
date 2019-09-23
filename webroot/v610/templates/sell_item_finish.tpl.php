<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<?=$sell_item_finish_content;?>
<table border="0" cellspacing="2" cellpadding="3" align="center">
   <tr class="contentfont">
		<td>[ <a href="auction_details.php?auction_id=<?=$item_details['auction_id'];?>"><?=MSG_VIEW_AUCTION;?></a> ]</td>   
      <? if ($show_list_similar) { ?>
   	<td>[ <a href="<?=process_link('sell_item', array('option' => 'sell_similar', 'auction_id' => $item_details['auction_id'])); ?>"><?=MSG_LIST_SIMILAR; ?></a> ]</td>
   	<? } ?>
      <td>[ <a href="<?=process_link('members_area', array('page' => 'selling', 'section' => 'open'));?>"><?=MSG_RETURN_TO_MBAREA;?></a> ]</td>
   </tr>
</table>

