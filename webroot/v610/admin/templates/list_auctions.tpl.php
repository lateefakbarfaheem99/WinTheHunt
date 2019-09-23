<?
#################################################################
## PHP Pro Bid v6.10															##
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

function send_form(form_name, page_status)
{
	var inactivate_total = 0;
	var checkboxes=form_name['inactivate[]'];
	var close_total = 0;
	var checkboxes_close=form_name['close[]'];

	for(var i=0; i < checkboxes.length; i++){
		if(checkboxes[i].checked) {
			inactivate_total++;
		}
	}

	if (checkboxes_close)
	{
		for(var i=0; i < checkboxes_close.length; i++){
			if(checkboxes_close[i].checked) {
				close_total++;
			}
		}
	}
	
	if (inactivate_total > 0 && page_status != 'suspended')
	{
		self.scrollTo(0,0);
		document.getElementById("centered_div").style.display = 'block';
		return false;
	}
	else if (close_total > 0)
	{
		self.scrollTo(0,0);
		document.getElementById("centered_div_close").style.display = 'block';
		return false;		
	}
	else
	{
		form_name.submit_auctions.value = 1;
		form_name.submit();
		return true;
	}
}

function susp_form_cancel()
{
	document.getElementById("centered_div").style.display = 'none';	
}

function susp_form_proceed(form_name)
{
	form_name.auction_suspension_reason.value = document.getElementById("suspension_reason").value;
	form_name.submit_auctions.value = 1;
	form_name.submit();
	return true;
}

function close_form_cancel()
{
	document.getElementById("centered_div_close").style.display = 'none';	
}

function close_form_proceed(form_name)
{
	form_name.auction_close_reason.value = document.getElementById("close_reason").value;
	form_name.submit_auctions.value = 1;
	form_name.submit();
	return true;
}
-->
</script>

<style type="text/css"> 
#centered_div, #centered_div_close {
	position:absolute;
	top: 50%;
	left: 50%;
	width:450px;
	height:250px;
	margin-top: -125px; 
	margin-left: -225px; 
	border: 2px solid #ccc;
	background-color: #FFFFFF;
	padding: 10px;
	display: none;
}
div > div#centered_div { position: fixed; }
div > div#centered_div_close { position: fixed; }
</style> 

<!--[if gte IE 5.5]>
<![if lt IE 7]>
<style type="text/css">
	div#centered_div {
		left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
		top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
	}
</style>
<![endif]>
<![endif]-->

<div id="centered_div">
	<div><b><?=AMSG_ENTER_SUSPENSION_REASON;?></b>:</div>
		<div align="center"><textarea style="width: 100%; height: 180;" name="suspension_reason" id="suspension_reason"></textarea>
	</div>
	<p align="center"><input type="submit" name="form_suspend_auctions" value="<?=GMSG_PROCEED;?>" onclick="susp_form_proceed(select_auctions);"> 
		<input type="button" name="form_cancel_suspension" value="<?=GMSG_CANCEL;?>" onclick="susp_form_cancel();"></p>
</div>   
         
<div id="centered_div_close">
	<div><b><?=AMSG_ENTER_CLOSURE_REASON;?></b>:</div>
		<div align="center"><textarea style="width: 100%; height: 180;" name="close_reason" id="close_reason"></textarea>
	</div>
	<p align="center"><input type="submit" name="form_close_auctions" value="<?=GMSG_PROCEED;?>" onclick="close_form_proceed(select_auctions);"> 
		<input type="button" name="form_cancel_closure" value="<?=GMSG_CANCEL;?>" onclick="close_form_cancel();"></p>
</div>

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
      <td align="center"><table border="0" cellpadding="3" cellspacing="3" class="border" align="center">
            <form action="<? echo ($reverse) ? 'list_reverse.php' : 'list_auctions.php';?>" method="get" name="list_auctions_form">
               <input type="hidden" name="status" value="<?=$form_details['status'];?>">
               <tr class="c4">
                  <td colspan="3"><b>
                     <?=GMSG_AUCTION_SEARCH;?>
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
                     <?=AMSG_BY_AUCTION_ID;?>
                     </b> :</td>
                  <td><input name="src_auction_id" type="text" id="src_auction_id" value="<?=$src_auction_id;?>" /></td>
                  <td><input name="form_auction_search" type="submit" id="form_auction_search" value="<?=GMSG_SEARCH;?>" /></td>
               </tr>
            </form>
         </table></td>
   </tr>
   <tr>
      <td align="center"><?=$query_results_message;?></td>
   </tr>
   <form action="<? echo ($reverse) ? 'list_reverse.php' : 'list_auctions.php';?>" method="get" name="select_auctions">
		<tr>
         <td>
				
         	<table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
               <input type="hidden" name="status" value="<?=$form_details['status'];?>">
               <input type="hidden" name="start" value="<?=$form_details['start'];?>">
               <input type="hidden" name="order_field" value="<?=$form_details['order_field'];?>">
               <input type="hidden" name="order_type" value="<?=$form_details['order_type'];?>">
               <input type="hidden" name="src_auction_id" value="<?=$form_details['src_auction_id']?>">
               <input type="hidden" name="keywords" value="<?=$form_details['keywords'];?>">
               <input type="hidden" name="submit_auctions" id="submit_auctions" value="0">
               <input type="hidden" name="auction_suspension_reason" id="auction_suspension_reason" value="">
               <input type="hidden" name="auction_close_reason" id="auction_close_reason" value="">
               <tr class="c4">
                  <td ><?=MSG_ITEM_TITLE;?>
                     &nbsp;
                     <?=$page_order_itemname;?></td>
                  <td><?=AMSG_ITEM_DETAILS;?>
                     &nbsp;
                     <?=$page_order_start_time;?></td>
                  <? if ($status == 'approval') { ?>
                  <input type="hidden" name="inactivate[]" id="inactivate[]" value="">
                  <td align="center"><?=AMSG_APPROVE;?>
                     <br>
                     [ <a href="javascript:void(0);" onclick="checkAll(document.select_auctions['approve[]'], <?=(($nb_auctions > $limit) ? $limit : $nb_auctions);?>, true);"> <font color="#EEEE00">
                     <?=GMSG_ALL;?></font></a> | 
                     <a href="javascript:void(0);" onclick="checkAll(document.select_auctions['approve[]'], <?=(($nb_auctions > $limit) ? $limit : $nb_auctions);?>, false);"> <font color="#EEEE00">
                     <?=GMSG_NONE;?></font></a> ] </td>
                  <? } else { ?>
                  <td align="center" width="150"><?=GMSG_STATUS;?>
                     <br />
                     [ <a href="javascript:void(0);" onclick="checkAll2(document.select_auctions['activate[]'], document.select_auctions['inactivate[]'], <?=(($nb_auctions > $limit) ? $limit : $nb_auctions);?>, true);"> <font color="#EEEE00">
                     <?=AMSG_ACTIVATE_ALL;?></font></a> ]
                     [ <a href="javascript:void(0);" onclick="checkAll2(document.select_auctions['activate[]'], document.select_auctions['inactivate[]'], <?=(($nb_auctions > $limit) ? $limit : $nb_auctions);?>, false);"> <font color="#EEEE00">
                     <?=AMSG_SUSPEND_ALL;?></font></a> ]
                     <?=$default_selection_link;?>
                  </td>                  
                  <? } ?>
                  <? if ($status == 'open' && !$reverse) { ?>
                  <td align="center"><?=AMSG_CLOSE;?>
                     <br />
                     [ <a href="javascript:void(0);" onclick="checkAll(document.select_auctions['close[]'], <?=(($nb_auctions > $limit) ? $limit : $nb_auctions);?>, true);"> <font color="#EEEE00">
                     <?=GMSG_ALL;?></font></a> | 
                     <a href="javascript:void(0);" onclick="checkAll(document.select_auctions['close[]'], <?=(($nb_auctions > $limit) ? $limit : $nb_auctions);?>, false);"> <font color="#EEEE00">
                     <?=GMSG_NONE;?></font></a> ] </td>                  
                  <? } ?>
                  <td align="center"><?=AMSG_DELETE;?>
                     <br />
                     [ <a href="javascript:void(0);" onclick="checkAll(document.select_auctions['delete[]'], <?=(($nb_auctions > $limit) ? $limit : $nb_auctions);?>, true);"> <font color="#EEEE00">
                     <?=GMSG_ALL;?></font></a> | 
                     <a href="javascript:void(0);" onclick="checkAll(document.select_auctions['delete[]'], <?=(($nb_auctions > $limit) ? $limit : $nb_auctions);?>, false);"> <font color="#EEEE00">
                     <?=GMSG_NONE;?></font></a> ] </td>
               </tr>
               <?=$auctions_content;?>
            </table></td>
      </tr>
      <? if ($nb_auctions>0) { ?>
      <tr>
         <td align="center"><?=$pagination;?></td>
      </tr>
      <tr>
     		<? if ($reverse) { ?>      
         <td align="center"><input type="submit" name="form_save_settings" value="<?=GMSG_PROCEED;?>" <?=$disabled_button;?> /></td>
         <? } else { ?>
         <td align="center"><input type="button" onclick="send_form(select_auctions, '<?=$form_details['status'];?>');" name="form_save_settings" id="form_save_settings" value="<?=GMSG_PROCEED;?>" <?=$disabled_button;?> /></td>
         <? } ?>
      </tr>
      <? } ?>
      <? if ($nb_marked_deleted_items) { ?>
      <tr>
         <td align="center">[ <a href="<? echo ($reverse) ? 'list_reverse.php' : 'list_auctions.php';?>?status=<?=$status;?>&do=marked_deleted">
            <?=AMSG_DELETE_MARKED_DELETED_ITEMS;?></a> ] 
            (<?=$nb_marked_deleted_items;?> <?=AMSG_ITEMS;?>)</td>
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