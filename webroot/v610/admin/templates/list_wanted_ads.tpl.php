<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
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

function checkAll2(field_a, field_b, array_len, check) {
	if (check==true) check2=false;
	else check2=true;

	if (array_len == 1) {
		field_a.checked = check;
		field_b.checked = check2;
	} else {
		for (i = 0; i < array_len; i++)
			field_a[i].checked = check ;
		for (i = 0; i < array_len; i++)
			field_b[i].checked = check2 ;
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
      <td><?=$management_box;?></td>
   </tr>
   <tr>
      <td colspan="5" align="center"><table border="0" cellpadding="3" cellspacing="3" class="border" align="center">
            <form action="list_wanted_ads.php" method="get">
               <input type="hidden" name="status" value="<?=$form_details['status'];?>">
               <tr class="c4">
                  <td colspan="3"><b>
                     <?=GMSG_WA_SEARCH;?>
                     </b></td>
               </tr>
               <tr class="c2">
                  <td><b>
                     <?=AMSG_BY_KEYWORDS;?>
                     </b> :</td>
                  <td colspan="2"><input name="keywords" type="text" id="keywords" value="<?=$keywords;?>" /></td>
               </tr>
               <tr class="c1">
                  <td><b>
                     <?=AMSG_BY_WA_ID;?>
                     </b> :</td>
                  <td><input name="src_wanted_ad_id" type="text" id="src_wanted_ad_id" value="<?=$src_wanted_ad_id;?>" /></td>
                  <td><input name="form_wanted_ad_search" type="submit" id="form_wanted_ad_search" value="<?=GMSG_SEARCH;?>" /></td>
               </tr>
            </form>
         </table></td>
   </tr>
   <tr>
      <td align="center"><?=$query_results_message;?></td>
   </tr>
   <tr>
      <td align="center"><?=GMSG_SHOW;?>
         :
         <?=$filter_wanted_ads_content;?></td>
   </tr>
   <form action="list_wanted_ads.php" method="get" name="select_auctions">
      <tr>
         <td><table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
               <input type="hidden" name="status" value="<?=$form_details['status'];?>">
               <input type="hidden" name="start" value="<?=$form_details['start'];?>">
               <input type="hidden" name="order_field" value="<?=$form_details['order_field'];?>">
               <input type="hidden" name="order_type" value="<?=$form_details['order_type'];?>">
               <input type="hidden" name="src_wanted_ad_id" value="<?=$form_details['src_wanted_ad_id']?>">
               <input type="hidden" name="keywords" value="<?=$form_details['keywords'];?>">
               <tr class="c4">
                  <td><?=MSG_ITEM_TITLE;?>
                     <?=$page_order_itemname;?></td>
                  <td><?=AMSG_ITEM_DETAILS;?>
                     <?=$page_order_start_time;?></td>
                  <td align="center"><?=GMSG_STATUS;?>
                     <br>
                     [ <a href="javascript:void(0);" onclick="checkAll2(document.select_auctions['activate[]'], document.select_auctions['inactivate[]'], <?=$nb_wanted_ads;?>, true);"> <font color="#EEEE00">
                     <?=AMSG_ACTIVATE_ALL;?></font></a> ]
                     [ <a href="javascript:void(0);" onclick="checkAll2(document.select_auctions['activate[]'], document.select_auctions['inactivate[]'], <?=$nb_wanted_ads;?>, false);"> <font color="#EEEE00">
							<?=AMSG_SUSPEND_ALL;?></font></a> ]
                     <?=$default_selection_link;?>
                  </td>
                  <td align="center"><?=AMSG_DELETE;?>
                     <br>
                     [ <a href="javascript:void(0);" onclick="checkAll(document.select_auctions['delete[]'], <?=$nb_wanted_ads;?>, true);"> <font color="#EEEE00">
                     <?=GMSG_ALL;?></font></a> | 
                     <a href="javascript:void(0);" onclick="checkAll(document.select_auctions['delete[]'], <?=$nb_wanted_ads;?>, false);"> <font color="#EEEE00">
                     <?=GMSG_NONE;?></font></a> ] </td>
               </tr>
               <?=$wanted_ads_content;?>
            </table></td>
      </tr>
      <? if ($nb_wanted_ads>0) { ?>
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
