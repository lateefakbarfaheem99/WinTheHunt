<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="Javascript">
<!--
function checkAll(field, array_len, check) {
	if (array_len == 1) {
		field.checked = check;
	} else {
		for (i = 0; i < array_len; i++)
			field[i].checked = check ;
	}
}
-->
</script>

<div class="mainhead"><img src="images/auction.gif" align="absmiddle">
   <?=$header_section;?>
</div>
<?=$msg_changes_saved;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr>
      <td class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
         <?=strtoupper($subpage_title);?>
         </b></td>
   </tr>
   <tr>
      <td align="center"><?=$query_results_message;?></td>
   </tr>
   <form action="" method="get" name="select_bids">
		<tr>
         <td>				
         	<table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
               <input type="hidden" name="status" value="<?=$form_details['status'];?>">
               <input type="hidden" name="start" value="<?=$form_details['start'];?>">
               <input type="hidden" name="order_field" value="<?=$form_details['order_field'];?>">
               <input type="hidden" name="order_type" value="<?=$form_details['order_type'];?>">
               <tr class="c4">
                  <td><?=MSG_ITEM_TITLE;?></td>
                  <td align="center"><?=AMSG_BIDDER;?></td>
                  <td align="center"><?=MSG_BID_AMOUNT;?></td>
                  <td align="center"><?=MSG_QUANTITY;?></td>
                  <td align="center"><?=MSG_PROXY_BID;?></td>
                  <td align="center"><?=MSG_BID_DATE;?></td>
                  <td align="center"><?=AMSG_RETRACTION_DATE;?></td>
                  <td align="center"><?=AMSG_DELETE;?>
                     <br />
                     [ <a href="javascript:void(0);" onclick="checkAll(document.select_bids['delete[]'], <?=$nb_bids;?>, true);"> <font color="#EEEE00">
                     <?=GMSG_ALL;?></font></a> | 
                     <a href="javascript:void(0);" onclick="checkAll(document.select_bids['delete[]'], <?=$nb_bids;?>, false);"> <font color="#EEEE00">
                     <?=GMSG_NONE;?></font></a> ] </td>
               </tr>
               <?=$retracted_bids_content;?>
            </table></td>
      </tr>
      <? if ($nb_bids>0) { ?>
      <tr>
         <td align="center"><?=$pagination;?></td>
      </tr>
      <tr>
         <td align="center"><input type="submit" name="form_save_settings" value="<?=GMSG_PROCEED;?>" <?=$disabled_button;?> /></td>
      </tr>
      <? } ?>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>