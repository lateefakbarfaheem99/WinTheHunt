<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript">
function bulk_popup_open()
{
	self.scrollTo(0,0);
	document.getElementById("centered_div").style.display = 'block';
	return false;
}

function bulk_popup_close()
{
	document.getElementById("centered_div").style.display = 'none';	
	return false;
}

function bulk_popup_categories_open()
{
	self.scrollTo(0,0);
	document.getElementById("categories_div").style.display = 'block';
	return false;
}

function bulk_popup_categories_close()
{
	document.getElementById("categories_div").style.display = 'none';
	return false;
}

function bulk_popup_countries_open()
{
	self.scrollTo(0,0);
	document.getElementById("countries_div").style.display = 'block';
	return false;
}

function bulk_popup_countries_close()
{
	document.getElementById("countries_div").style.display = 'none';
	return false;
}

function bulk_popup_custom_fields_open()
{
	self.scrollTo(0,0);
	document.getElementById("custom_fields_div").style.display = 'block';
	return false;
}

function bulk_popup_custom_fields_close()
{
	document.getElementById("custom_fields_div").style.display = 'none';
	return false;
}

function printSelection(node){

  var content=node.innerHTML
  var pwin=window.open('','print_content','width=100,height=100');

  pwin.document.open();
  pwin.document.write('<html><body onload="window.print()">'+content+'</body></html>');
  pwin.document.close();
 
  setTimeout(function(){pwin.close();},1000);

}

function checkAll(field, array_len, check) {
	if (array_len == 1) {
		field.checked = check;
	} else {
		for (i = 0; i < array_len; i++)
			field[i].checked = check ;
	}
}
</script>

<style type="text/css"> 
#centered_div {
	position:absolute;
	top: 10%;
	left: 50%;
	width:920px;
	height:650px;
	margin-left: -460px; 
	border: 2px solid #ccc;
	background-color: #FFFFFF;
	padding: 10px;
	display: none;
	overflow: auto;
}

#categories_div {
	position:absolute;
	top: 15%;
	left: 50%;
	width:500px;
	height:700px;
	margin-left: -250px; 
	border: 2px solid #ccc;
	background-color: #FAFAFA;
	padding: 10px;
	display: none;
	overflow: auto;
} 

#countries_div {
	position:absolute;
	top: 15%;
	left: 50%;
	width:350px;
	height:730px;
	margin-left: -175px; 
	border: 2px solid #ccc;
	background-color: #FAFAFA;
	padding: 10px;
	display: none;
	overflow: auto;
}

#custom_fields_div {
	position:absolute;
	top: 15%;
	left: 50%;
	width:600px;
	height:400px;
	margin-left: -300px; 
	border: 2px solid #ccc;
	background-color: #FAFAFA;
	padding: 10px;
	display: none;
	overflow: auto;
} 

div > div#centered_div { position: fixed; }
div > div#categories_div { position: fixed; }
div > div#countries_div { position: fixed; }
div > div#custom_fields_div { position: fixed; }
</style> 

<!--[if gte IE 5.5]>
<![if lt IE 7]>
<style type="text/css">
	div#centered_div {
		left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
		top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
	}
	div#categories_div {
		left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
		top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
	}
	div#countries_div {
		left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
		top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
	}
	div#custom_fields_div {
		left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
		top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
	}
</style>
<![endif]>
<![endif]-->

<? if (!empty($bulk_listing_process_output)) { ?>
<div class="errormessage"><?=$bulk_listing_process_output;?></div>
<? } ?>
<div id="centered_div">
	<div align="right" style="padding-bottom: 10px;">
		<!--
		<input type="image" src="images/print_icon.gif" name="bulk_print_fields" onclick="printSelection(document.getElementById('centered_div'));return false">
		&nbsp;
		-->
		<input type="image" src="images/close_icon.gif" name="bulk_popup_close" onclick="bulk_popup_close();" alt="<?=GMSG_CLOSE;?>">
	</div>
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
		<tr>
	   	<td class="c7" colspan="5"><b><?=MSG_BT_TITLE;?></b></td>
	 	</tr>	
	 	<tr>
	 		<td colspan="5">
	 			<?=MSG_BT_DELIMITER_DESCRIPTION;?>
	 		</td>
	 	</tr>
	 	<tr class="c3">
	 		<td><?=MSG_FIELD_NAME;?></td>
	 		<td align="center"><?=MSG_FIELD_TYPE;?></td>
	 		<td align="center"><?=MSG_ACCEPTED_VALUES;?></td>
	 		<td align="center"><?=MSG_MANDATORY;?></td>
	 		<td align="center"><?=MSG_NOTES;?></td>
	 	</tr>
	   <tr class="c5">
	      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="300" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="250" height="1"></td>
		</tr>
		<? foreach ($bulk_details->fields_details as $field) { ?>
	 	<tr class="<? echo ($counter++%2) ? 'c1' : 'c2';?>">
	 		<td><b><?=$field['name'];?></b></td>
	 		<td align="center"><?=$field['description'];?></td>
	 		<td align="center"><?=$bulk_details->displayAcceptedValues($field['accepted_values']);?></td>
	 		<td align="center"><?=$bulk_details->displayMandatory($field['mandatory']);?></td>
	 		<td><?=$field['notes'];?></td>
	 	</tr>		
		<? } ?>
	</table>
</div>   

<div id="categories_div">
	<div align="right" style="padding-bottom: 10px;"><input type="image" src="images/close_icon.gif" name="bulk_popup_close" onclick="bulk_popup_categories_close();" alt="<?=GMSG_CLOSE;?>"></div>
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
		<tr>
	   	<td class="c7" colspan="2"><b><?=MSG_CATEGORIES_IDS;?></b></td>
	 	</tr>	
	 	<tr class="c3">
	 		<td><?=MSG_CATEGORY_NAME;?></td>
	 		<td align="center"><?=MSG_CATEGORY_ID;?></td>
	 	</tr>
	   <tr class="c5">
	      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
		</tr>
		<? foreach ($bulk_details->categories as $category) { ?>
	 	<tr class="<? echo ($counter++%2) ? 'c1' : 'c2';?>">
	 		<td><b><?=$category['name'];?></b></td>
	 		<td align="center"><?=$category['id'];?></td>
	 	</tr>		
		<? } ?>
	</table>
</div>

<div id="custom_fields_div">
	<div align="right" style="padding-bottom: 10px;"><input type="image" src="images/close_icon.gif" name="bulk_popup_close" onclick="bulk_popup_custom_fields_close();" alt="<?=GMSG_CLOSE;?>"></div>
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
		<tr>
	   	<td class="c7" colspan="6"><b><?=MSG_CUSTOM_FIELDS;?></b></td>
	 	</tr>	
	 	<tr>
	 		<td colspan="6">
	 			<p>
	 				<?=MSG_BT_CUSTOM_FIELDS_EXPL1;?>
	 			</p>
	 			<p>
		 			<?=MSG_BT_CUSTOM_FIELDS_EXPL2;?>
	 			</p>
	 		</td>
	 	</tr>
	 	<tr class="c3">
	 		<td><?=MSG_BOX_FIELD_NAME;?></td>
	 		<td align="center"><?=MSG_ID;?></td>
	 		<td align="center"><?=MSG_BOX_TYPE;?></td>
	 		<td align="center"><?=MSG_ACCEPTED_VALUES;?></td>
	 		<td align="center"><?=MSG_MANDATORY;?></td>
	 		<td align="center"><?=MSG_CATEGORIES;?></td>
	 	</tr>
	   <tr class="c5">
	      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="70" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="50" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100" height="1"></td>
		</tr>
		<? foreach ($bulk_details->custom_fields as $field) { ?>
	 	<tr class="<? echo ($counter++%2) ? 'c1' : 'c2';?>">
	 		<td><b><?=$field['name'];?></b></td>
	 		<td align="center"><?=$field['id'];?></td>
	 		<td align="center"><?=$field['box_type_desc'];?></td>
	 		<td align="center"><?=$db->implode_array($bulk_details->splitCfValues($field['box_value']), ', ', true, '');?></td>
	 		<td align="center"><?=$bulk_details->displayMandatory($field['mandatory']);?></td>
	 		<td align="center"><?=field_display($field['category_name'], GMSG_ALL);?></td>
	 	</tr>		
		<? } ?>
	</table>
</div>

<div id="countries_div">
	<div align="right" style="padding-bottom: 10px;"><input type="image" src="images/close_icon.gif" name="bulk_popup_close" onclick="bulk_popup_countries_close();" alt="<?=GMSG_CLOSE;?>"></div>
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
		<tr>
	   	<td class="c7" colspan="2"><b><?=MSG_COUNTRIES_IDS;?></b></td>
	 	</tr>	
	 	<tr class="c3">
	 		<td><?=MSG_COUNTRY_NAME;?></td>
	 		<td align="center"><?=MSG_COUNTRY_ID;?></td>
	 	</tr>
	   <tr class="c5">
	      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
	      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="70" height="1"></td>
		</tr>
		<? foreach ($bulk_details->countries as $country) { ?>
	 	<tr class="<? echo ($counter++%2) ? 'c1' : 'c2';?>">
	 		<td><b><?=$country['name'];?></b></td>
	 		<td align="center"><?=$country['id'];?></td>
	 	</tr>		
		<? } ?>
	</table>
</div>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<form action="" method="POST" enctype="multipart/form-data" name="bulk_form" id="bulk_form">
	<tr>
   	<td class="c7" colspan="2"><b><?=MSG_BULK_LISTER;?></b></td>
 	</tr>
	<tr class="contentfont">
		<td class="c1" width="11"><?=$imgarrow;?></td>
		<td class="c2"><b><?=MSG_INSTRUCTIONS;?>:</b></td>
	</tr>
	<tr class="contentfont">
		<td></td>
		<td>
         <?=MSG_BULK_LISTER_DESCRIPTION;?>
      </td>
	</tr>
	<tr class="contentfont">
		<td></td>
		<td><img src="images/zip.gif" align="absmiddle" border="0"> <a href="bulk_sample.csv"><b><?=MSG_DOWNLOAD_SAMPLE_FILE;?></b></a></td>
	</tr>
	<tr>
		<td class="c1" width="11"><?=$imgarrow;?></td>
		<td class="c2"><b><?=MSG_UPLOAD_BULK_FILE;?>:</b></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<div style="height: 22px; line-height: 22px;">
				<input type="text" id="txtFileName" disabled="true" style="width: 200px;" />
				<span id="spanButtonPlaceholder"></span>					
			</div>
			<div class="flash" id="fsUploadProgress"></div>
				<input type="hidden" name="hidFileID" id="hidFileID" value="" />		
			</div>			
			<noscript>
				<input type="file" name="bulk_file" id="bulk_file"> 
			</noscript>
			<input type="button" name="form_bulk_upload" id="btnSubmit" value="<?=GMSG_PROCEED;?>">
		</td>
	</tr>
	</form>
</table>
<br>
<form action="" method="post" name="bulk_listings" id="bulk_listings">
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<input type="hidden" name="do" value="import_listings">
	<tr>
      <td colspan="8" class="c7"><b><?=MSG_PENDING_BULK_LISTINGS;?></b> (<?=$nb_items;?> <?=MSG_ITEMS;?>)
      </td>
   </tr>
   <? if ($bulk_fees_amount > 0) { ?>
	<tr>
      <td colspan="8" class="errormessage">   
      	<?=MSG_LISTING_ITEMS_TOTAL;?> <b><?=$fees->display_amount($bulk_fees_amount, null, true);?></b> <?=MSG_IN_LISTING_FEES;?>.
		</td>
   </tr>
   <? } ?>
   <tr class="membmenu">
      <td><?=MSG_ITEM_TITLE;?></td>
      <td align="center"><?=GMSG_START_TIME;?></td>
      <td align="center"><?=GMSG_END_TIME;?>/<?=GMSG_DURATION;?></td>
      <td align="center"><?=MSG_START_BID;?></td>
      <td align="center" class="contentfont"><?=MSG_LIST;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.bulk_listings['list[]'], <?=$nb_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.bulk_listings['list[]'], <?=$nb_items;?>, false);"><?=GMSG_NONE;?></a> ]
			<? if ($nb_items > 0) { ?>
      	<br>
      	<input type="submit" value="<?=MSG_LIST_ALL;?> <?=$nb_items;?> <?=MSG_ITEMS;?>" name="form_bulk_list_all" id="form_bulk_list_all" onclick="return confirm_refresh();">
      	<? } ?>
		</td>
      <td align="center" class="contentfont"><?=GMSG_DELETE;?>
      	<br>
      	[ <a href="javascript:void(0);" onclick="checkAll(document.bulk_listings['delete[]'], <?=$nb_items;?>, true);"><?=GMSG_ALL;?></a> |
			<a href="javascript:void(0);" onclick="checkAll(document.bulk_listings['delete[]'], <?=$nb_items;?>, false);"><?=GMSG_NONE;?></a> ]
			<? if ($nb_items > 0) { ?>
      	<br>
      	<input type="submit" value="<?=MSG_DELETE_ALL;?> <?=$nb_items;?> <?=MSG_ITEMS;?>" name="form_bulk_delete_all" id="form_bulk_delete_all" onclick="return confirm_refresh();">
      	<? } ?>
		</td>
		<td align="center"><?=GMSG_OPTIONS;?></td>
   </tr>
   <tr class="c5">
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="120" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="130" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="130" height="1"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="60" height="1"></td>
   </tr>
   <?=$pending_bulk_listings_content;?>
   <? if ($nb_items>0) { ?>
   <tr class="membmenu">
      <td colspan="8" align="center" class="contentfont"><input type="submit" name="form_bulk_list_proceed" id="form_bulk_list_proceed" value="<?=GMSG_PROCEED;?>" onclick="confirm_refresh();" /></td>
   </tr>

   <tr>
      <td colspan="8" align="center" class="contentfont"><?=$pagination;?></td>
   </tr>
	<? } ?>
   
   <? if ($nb_open_items_no_bids > 0) { ?>
   <tr>
      <td colspan="8" align="center" class="contentfont">
         <input type="submit" name="delete_open_items" value="<?=MSG_MASS_DELETE_OPEN_ITEMS;?> (<?=$nb_open_items_no_bids;?> <?=MSG_ITEMS;?>)" onclick="return confirm('<?=MSG_MASS_DELETE_OPEN_ITEMS_CONFIRM;?>');" />
      </td>
   </tr>   
   <? } ?>
</table>
</form>
