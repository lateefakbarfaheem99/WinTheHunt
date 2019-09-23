<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<link rel="stylesheet" type="text/css" href="<? echo (IN_ADMIN == 1) ? '../' : '';?>themes/global.css" />
<script src="<? echo (IN_ADMIN == 1) ? '../' : '';?>JsHttpRequest/JsHttpRequest.js"></script>
<script src="<? echo (IN_ADMIN == 1) ? '../' : '';?>scripts/jsencode.js"></script>

<script language="javascript">
function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

function showResult(xmlHttp, id)
{
	if (xmlHttp.readyState == 4)
	{
		var response = xmlHttp.responseText;

		id.innerHTML = unescape(response);
	}
}

function state_box(country, user_id)
{
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = '<? echo (IN_ADMIN == 1) ? '../' : '';?>' + 'ajax_files/states_box.php';
	var action    = url + '?country_id=' + country.value;

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4)
		{
			var response = xmlHttp.responseText;
			document.getElementById('stateBox').innerHTML = response;
		}
	};
	xmlHttp.open("GET", action, true);
	xmlHttp.send(null);
}

function shipping_calculator(is_submit)
{
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = '<? echo (IN_ADMIN == 1) ? '../' : '';?>' + 'ajax_files/shipping_calculator.php';
	var action = url + '?sc_item_id=' + document.getElementById("sc_item_id").value + '&sc_quantity=' + document.getElementById("sc_quantity").value +
		'&sc_country=' + document.getElementById("sc_country").value;

	if (document.getElementById("sc_state"))
	{
		action = action + '&sc_state=' + document.getElementById("sc_state").value;
	}

	if (document.getElementById("sc_zip_code"))
	{
		action = action + '&sc_zip_code=' + document.getElementById("sc_zip_code").value;
	}

	if (document.getElementById("sc_carrier"))
	{
		action = action + '&sc_carrier=' + document.getElementById("sc_carrier").value;
	}

	if (is_submit == 1)
	{
		action = action + '&form_calculate_postage=1';
	}

	document.getElementById('shCalcBox').innerHTML = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="border">' +
		'<tr><td class="c3" colspan="2"><?=MSG_SHIPPING_CALCULATOR;?></td></tr>' +
		'<tr class="c5">' +
		'	<td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>' +
		'	<td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>' +
		'</tr>' +
		'<tr><td height="100" align="center" colspan="2"><img src="images/loading-ajax.gif"></td></tr></table>';
		//alert(action);

	xmlHttp.onreadystatechange = function() { showResult(xmlHttp, document.getElementById("shCalcBox")); };
	xmlHttp.open("GET", action, true);
	xmlHttp.send(null);
}

function delete_media_async(box_id, media_type) {
	// first we remove the entry from the page
	var file_name = document.getElementById('hidden_'+box_id).value;

	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = '<? echo (IN_ADMIN == 1) ? '../' : '';?>' + 'ajax_files/upload_file.php';
	var action = url + '?do=remove&file_name=' + file_name;

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4)
		{
			var response = xmlHttp.responseText;
			alert(response);

			document.getElementById('box_'+box_id).innerHTML = '';
			document.getElementById('box_'+box_id).className = 'thumbnail_display_empty';
			document.getElementById('hidden_'+box_id).value='';

			var nb_uploads = document.getElementById('nb_uploads_' + media_type).value;
			nb_uploads--;
			
			document.getElementById('nb_uploads_' + media_type).value = nb_uploads;

			document.getElementById('btn_upload_' + media_type).disabled = false;
			document.getElementById('item_file_upload_' + media_type).disabled = false;
			document.getElementById('item_file_url_' + media_type).disabled = false;
			document.getElementById('item_file_embed_' + media_type).disabled = false;
		}
	};
	
	xmlHttp.open("GET", action, true);
	xmlHttp.send(null);

}

function upload_media_async(media_type, file_path, file_url, file_embed, nb_uploads, max_uploads, upload_id) {
	jsHttp = new JsHttpRequest();
	xmlHttp=GetXmlHttpObject();

	if (jsHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var media_name = '';
	switch (media_type)
	{
		case 1:
			media_name = 'ad_image';
			break;
		case 2:
			media_name = 'ad_video';
			break;
		case 3:
			media_name = 'ad_dd';
			break;		
	}
	
	media_box_name = 'display_media_boxes_' + media_name;

	file_embed = base64Encode(file_embed);
	var url    = '<? echo (IN_ADMIN == 1) ? '../' : '';?>' + 'ajax_files/upload_file.php';
	var action = url + '?do=add&media_type=' + media_type + '&file_url=' + file_url +
		'&file_embed=' + file_embed + '&nb_uploads=' + nb_uploads + '&upload_id=' + upload_id;

	var thumbnail_div = document.getElementById('display_media_boxes_' + media_name);
	var new_content = document.createElement('div');
	
	if (file_embed != '')
	{
		xmlHttp.onreadystatechange = function() {
			if (xmlHttp.readyState == 4)
			{
				var response = xmlHttp.responseText;
				results = response.split('|');

				if (results[5] != '')
				{
					alert (results[5]);
				}
				else
				{
					new_content.innerHTML = results[3];

					while (new_content.firstChild) {
						thumbnail_div.appendChild(new_content.firstChild);
					}

					var hidden_div = document.getElementById('hidden_media_boxes');
					var hidden_content = document.createElement('div');
					hidden_content.innerHTML = '<input type="hidden" name="' + results[1] + '[]" id="hidden_' + results[2] + '" value="' + results[4] + '">';

					while (hidden_content.firstChild) {
						hidden_div.appendChild(hidden_content.firstChild);
					}
					nb_uploads++;
				}

				document.getElementById('div_file_' + media_type).innerHTML = document.getElementById('div_file_' + media_type).innerHTML;
				document.getElementById('item_file_url_' + media_type).value = '';
				document.getElementById('item_file_embed_' + media_type).value = '';

				if (nb_uploads>=max_uploads)
				{
					document.getElementById('btn_upload_' + media_type).disabled = true;
					document.getElementById('item_file_upload_' + media_type).disabled = true;
					document.getElementById('item_file_url_' + media_type).disabled = true;
					document.getElementById('item_file_embed_' + media_type).disabled = true;
				}
				document.getElementById('nb_uploads_' + media_type).value = nb_uploads;
			}
		};
		xmlHttp.open("POST", action, true);
		xmlHttp.send(null);
	}
	else
	{
		var image_loading = document.createElement('div');
		image_loading.innerHTML = '<img src="<? echo (IN_ADMIN == 1) ? '../' : '';?>images/loading-media.gif">';
		thumbnail_div.appendChild(image_loading); 	
		
		jsHttp.onreadystatechange = function() {
			if (jsHttp.readyState == 4)
			{
				var response = jsHttp.responseText;
				results = response.split('|');

				if (results[5] != '')
				{
					alert (results[5]);
				}
				else
				{
					new_content.innerHTML = results[3];

					thumbnail_div.replaceChild(new_content.firstChild, image_loading);

					var hidden_div = document.getElementById('hidden_media_boxes');
					var hidden_content = document.createElement('div');
					hidden_content.innerHTML = '<input type="hidden" name="' + results[1] + '[]" id="hidden_' + results[2] + '" value="' + results[4] + '">';

					while (hidden_content.firstChild) {
						hidden_div.appendChild(hidden_content.firstChild);
					}
					nb_uploads++;
				}

				document.getElementById('div_file_' + media_type).innerHTML = document.getElementById('div_file_' + media_type).innerHTML;
				document.getElementById('item_file_url_' + media_type).value = '';
				document.getElementById('item_file_embed_' + media_type).value = '';

				if (nb_uploads>=max_uploads)
				{
					document.getElementById('btn_upload_' + media_type).disabled = true;
					document.getElementById('item_file_upload_' + media_type).disabled = true;
					document.getElementById('item_file_url_' + media_type).disabled = true;
					document.getElementById('item_file_embed_' + media_type).disabled = true;
				}
				document.getElementById('nb_uploads_' + media_type).value = nb_uploads;
			}
		};
		jsHttp.open("POST", action, true);
		jsHttp.send( { file: file_path } );
	}
}

function select_category(category_id, box_id, prefix, reverse, click_select)
{
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = '<? echo (IN_ADMIN == 1) ? '../' : '';?>' + 'ajax_files/select_category.php';
	var action    = url + '?category_id=' + category_id + '&target_box_id=' + box_id +
	'&prefix=' + prefix + '&reverse_categories=' + reverse + '&click_select=' + click_select;

	//		xmlHttp.onreadystatechange = function() { showResult(xmlHttp, box_id); };
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4)
		{
			var response = xmlHttp.responseText;
			//document.getElementById(box_id).innerHTML = response;
			if (response.indexOf('change_category') == 0 && click_select != true) 
			{ 
				eval(response); 
			} 
			else 
			{ 
				document.getElementById(box_id).innerHTML = response; 
			}
		}
	};
	xmlHttp.open("GET", action, true);
	xmlHttp.send(null);
}

function change_category(category_id, prefix, reverse)
{
	var category_name = 'category_id';
	if (prefix != 'main_')
	{
		category_name = 'addl_category_id';
	}

	document.getElementById(category_name).value = category_id;
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = '<? echo (IN_ADMIN == 1) ? '../' : '';?>' + 'ajax_files/change_category.php';
	var action    = url + '?category_id=' + category_id + '&reverse=' + reverse;

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4)
		{
			var response = xmlHttp.responseText;
			document.getElementById(prefix+'category_display').innerHTML = response;
		}
	};
	xmlHttp.open("GET", action, true);
	xmlHttp.send(null);

	document.getElementById(prefix+'category_field').innerHTML = '';
}

var ie4 = false;
if(document.all) {
	ie4 = true;
}

function getObjectDetails(id) 	{
	if (ie4) {
		return document.all[id];
	} else {
		return document.getElementById(id);
	}
}

function toggle_default(divId) {
	var d = getObjectDetails(divId);

	if (d.style.display == '') {
		d.style.display = 'none';
	} else {
		d.style.display = '';
	}
}

function toggle_simple(divId, fieldId) {
	var d = getObjectDetails(divId);
	var fld = getObjectDetails(fieldId);

	if (d.style.display == '') {
		d.style.display = 'none';

		if (fld.value) {
			fld.value = '';
		}
	} else {
		d.style.display = '';
	}
}

function toggle_double(divId, fieldId, fieldIdB) {
	var d = getObjectDetails(divId);
	var fld = getObjectDetails(fieldId);
	var fld1 = getObjectDetails(fieldIdB);

	if (d.style.display == '') {
		d.style.display = 'none';

		if (fld.value)	{
			fld.value = '';
		}
		if (fld1.value) {
			fld1.value = '';
		}
	} else {
		d.style.display = '';
	}
}

function toggle_radio(divId, radioId, value_display) {
	var d = getObjectDetails(divId);
	var r = getObjectDetails(radioId);

	if (r.value == value_display)
	{
		d.style.display = '';
	} else {
		d.style.display = 'none';
	}
}

function page_redirect(id)
{
	if (document.getElementById(id).value != '')
	{
		document.location.href =document.getElementById(id).value;
	}
	return false;
}

</script>

<? 
if (
	eregi('auction_details.php', $_SERVER['PHP_SELF'])	||	
	eregi('reverse_details.php', $_SERVER['PHP_SELF']) || 
	eregi('reverse_profile.php', $_SERVER['PHP_SELF'])
) { ?>
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>lightbox/js/prototype.js"></script> 
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>lightbox/js/scriptaculous.js?load=effects,builder"></script> 
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>lightbox/js/lightbox.js"></script> 
<link rel="stylesheet" href="<? echo (IN_ADMIN == 1) ? '../' : '';?>lightbox/css/lightbox.css" type="text/css" media="screen" /> 
<? } ?>

<? if ($setts['enable_swdefeat'] && IN_ADMIN != 1) { ?>
<script type="text/javascript">	
	var url_address = window.location.href;
	if (url_address.indexOf('#') == -1) 
	{
		window.location.href = url_address + '#' + '<?=substr(md5(uniqid(rand(2, 999999999))),-12);?>';
	}	
</script>
<? } ?>
