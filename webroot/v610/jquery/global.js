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

	var url    = relative_path + 'ajax_files/states_box.php';
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

	var url    = relative_path + 'ajax_files/shipping_calculator.php';
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
		'<tr><td class="c3" colspan="2">' + sc_title +'</td></tr>' +
		'<tr class="c5">' +
		'	<td><img src="themes/' + site_theme + '/img/pixel.gif" width="150" height="1"></td>' +
		'	<td width="100%"><img src="themes/' + site_theme + '/img/pixel.gif" width="1" height="1"></td>' +
		'</tr>' +
		'<tr><td height="100" align="center" colspan="2"><img src="images/loading-ajax.gif"></td></tr></table>';
		//alert(action);

	xmlHttp.onreadystatechange = function() { showResult(xmlHttp, document.getElementById("shCalcBox")); };
	xmlHttp.open("GET", action, true);
	xmlHttp.send(null);
}

function delete_media_async(box_id, media_type, auction_id) {
	// first we remove the entry from the page
	var file_name = document.getElementById('hidden_'+box_id).value;

	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = relative_path + 'ajax_files/upload_file.php';
	var action = url + '?do=remove&file_name=' + file_name + '&auction_id=' + auction_id;

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

function upload_media_async(form_name, media_type, file_path, file_url, file_embed, nb_uploads, max_uploads, upload_id) {	
	var radio_buttons = new Array();
	for (var i=0; i<form_name.length; i++)
	{
		if (form_name.elements[i].type == 'radio' && form_name.elements[i].checked == true)
		{
			radio_buttons[form_name.elements[i].name] = form_name.elements[i].value;
		}
	}

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
	var url    = relative_path + 'ajax_files/upload_file.php';
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
		jQuery.blockUI({ message: '<p style="padding: 10px; font-size: 16px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold;">' + upl_progress_msg + '</p>' });
		
		var image_loading = document.createElement('div');
		image_loading.innerHTML = '<img src="' + relative_path + 'images/loading-media.gif">';
		thumbnail_div.appendChild(image_loading); 	
		
		jsHttp.onreadystatechange = function() {
			if (jsHttp.readyState == 4)
			{
				var response = jsHttp.responseText;
            //alert(response);

				results = response.split('|');

				if (results[5] != '')
				{
					thumbnail_div.removeChild(image_loading);
					alert (results[5]);
					setTimeout(jQuery.unblockUI, 500);
				}
				else
				{
					new_content.innerHTML = results[3];

					while (new_content.firstChild) {
						thumbnail_div.replaceChild(new_content.firstChild, image_loading);
					}
					setTimeout(jQuery.unblockUI, 500);

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
				
				for (var i=0; i<form_name.length; i++)
				{
					if (form_name.elements[i].type == 'radio' && radio_buttons[form_name.elements[i].name] == form_name.elements[i].value)
					{
						form_name.elements[i].checked = true;
					}
				}						
			}			
		};
		jsHttp.open("POST", action, true);
		jsHttp.send( { file: file_path } );
	}
}

function select_category(category_id, box_id, prefix, reverse, click_select, listing_type, list_in)
{
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = relative_path + 'ajax_files/select_category.php';
	var action    = url + '?category_id=' + category_id + '&target_box_id=' + box_id +
	'&prefix=' + prefix + '&reverse_categories=' + reverse + '&click_select=' + click_select + 
	'&listing_type=' + listing_type + '&list_in=' + list_in;

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

	var url    = relative_path + 'ajax_files/change_category.php';
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

function edit_field(div_id, caption, table, field_id, value_id, field_changed, field_owner)
{
	textbox_id = div_id + '_' + field_changed;
	document.getElementById(div_id).innerHTML = '<input type="text" name="' + field_changed + '" size="50" value="' + caption + '" id="' + textbox_id + '" maxlength="70" /> ' + 
		'<input type="button" value="' + save_msg + '" onclick="save_field(\'' + textbox_id + '\', \'' + div_id + '\', \'' + caption + '\', \'' + table + '\', \'' + field_id + '\', \'' + value_id + '\', \'' + field_changed + '\', \'' + field_owner + '\');" />';
}

function save_field(textbox_id, div_id, caption, table, field_id, value_id, field_changed, field_owner)
{
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = relative_path + 'ajax_files/save_field.php';
	var action    = url + '?table=' + table + '&field_id=' + field_id + '&value_id=' + value_id + 
		'&field_changed=' + field_changed + '&field_owner=' + field_owner + 
		'&changed_value=' + document.getElementById(textbox_id).value;

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4)
		{
			var response = xmlHttp.responseText;
			document.getElementById(div_id).innerHTML = response + 
				' [ <a href="javascript:;" onclick="edit_field(\'' + div_id + '\', \'' + response + '\', \'' + table + '\', \'' + field_id + '\', ' + value_id + ', \'' + field_changed + '\', \'' + field_owner + '\');">' + edit_msg + '</a> ]';

			if (location_reload == true) {
				location.reload(true);
			}
		}
	};
	xmlHttp.open("POST", action, true);
	xmlHttp.send(null);	
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

function pg_popup_open(id)
{
	if (document.getElementById(id).style.display == 'block')
	{
		document.getElementById(id).style.display = 'none';
	}
	else
	{
		document.getElementById(id).style.display = 'block';
	}
	return false;
}

function pg_update_settings(id, input_array)
{
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url    = relative_path + 'ajax_files/direct_payment_box.php';
	var action    = url + '?id=' + id + '&user_id=' + s_usr;

	var chk_disabled = false;
	for ( var i in input_array )
	{
		if (i == parseInt(i))
		{
			action += '&' + input_array[i] + '=' + document.getElementById(input_array[i]).value;

			if (document.getElementById(input_array[i]).value == '')
			{
				chk_disabled = true;
			}
		}
	}

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4)
		{
			var response = xmlHttp.responseText;
		}
	};
	xmlHttp.open("GET", action, true);
	xmlHttp.send(null);

	document.getElementById('checkbox_' + id).disabled = chk_disabled;
	if (chk_disabled == true)
	{
		document.getElementById('checkbox_' + id).checked = false;
	}
	document.getElementById(id).style.display = 'none';
	return false;
}

function change_pic ( image_path, id )
{
	document.getElementById(id).src = image_path;
}

var myPopup = '';

function openPopup(url) {
	myPopup = window.open(url,'popupWindow','width=640,height=150,status=yes');
   if (!myPopup.opener) myPopup.opener = self;
}
function converter_open(url) {
	output = window.open(url,"popDialog","height=220,width=700,toolbar=no,resizable=yes,scrollbars=yes,left=10,top=10");
}
