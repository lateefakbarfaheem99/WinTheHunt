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
      <td><?=$management_box;?></td>
   </tr>
   <tr>
      <td align="center"><?=$query_results_message;?></td>
   </tr>
	<tr>
   	<td><table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
      	<tr class="c4">
         	<td nowrap><?=AMSG_ITEM_DETAILS;?></td>
            <td align="center"><?=AMSG_WINNING_BID_DETAILS;?></td>
            <td align="center"><?=GMSG_BUYER;?></td>
            <td align="center"><?=GMSG_SELLER;?></td>
            <td align="center"><?=GMSG_STATUS;?></td>
            <td align="center"><?=GMSG_OPTIONS;?></td>
			</tr>
		   <tr class="c5">
		      <td><img src="images/pixel.gif" width="120" height="1"></td>
		      <td><img src="images/pixel.gif" width="150" height="1"></td>
		      <td><img src="images/pixel.gif" width="175" height="1"></td>
		      <td><img src="images/pixel.gif" width="175" height="1"></td>
		      <td width="100%"><img src="images/pixel.gif" width="1" height="1"></td>
		      <td><img src="images/pixel.gif" width="100" height="1"></td>
		   </tr>
			
         <?=$auctions_content;?>
			</table></td>
      </tr>
      <? if ($nb_winners>0) { ?>
      <tr>
         <td align="center"><?=$pagination;?></td>
      </tr>
      <? } ?>
      <tr>
         <td align="center"><?=AMSG_REFUND_REQUESTS_NOTE;?></td>
      </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
