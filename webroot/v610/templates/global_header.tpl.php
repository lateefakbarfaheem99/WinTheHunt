<?
#################################################################
## PHP Pro Bid v6.10d														##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<link rel="stylesheet" type="text/css" href="<? echo (IN_ADMIN == 1) ? '../' : '';?>themes/global.css">
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>JsHttpRequest/JsHttpRequest.js"></script>
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>scripts/jsencode.js"></script>

<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/js/jquery.blockUI.js"></script>

<link rel="stylesheet" type="text/css" href="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/css/swfupload.css">
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/swfupload/handlers.js"></script>

<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/js/jquery.jclock.js"></script>
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/js/jquery.clock.js"></script>
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/js/jquery.countdown.min.js"></script>

<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/tiny_mce/jquery.tinymce.js"></script>

<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>themes/<?=$setts['default_theme'];?>/main.js"></script>

<script type="text/javascript">
	var relative_path = '<? echo (IN_ADMIN == 1) ? '../' : '';?>';
	var sc_title = '<?=$db->rem_special_chars(MSG_SHIPPING_CALCULATOR);?>';
	var site_theme = '<?=$setts['default_theme'];?>';
	var upl_progress_msg = '<?=MSG_WAIT_UPL_PROGRESS;?>';
	var closed_msg = '<?=GMSG_CLOSED;?>';
	var day_msg = '<?=GMSG_DAY;?>';
	var days_msg = '<?=GMSG_DAYS;?>';
	var h_msg = '<?=GMSG_H;?>';
	var m_msg = '<?=GMSG_M;?>';
	var s_msg = '<?=GMSG_S;?>';
	var na_msg = '<?=GMSG_NA;?>';
	var save_msg = '<?=MSG_SAVE;?>';	
	var edit_msg = '<?=GMSG_EDIT;?>';
	var processing_bulk_msg = '<?=MSG_PROCESSING_BULK_LISTINGS;?>';
	var processing_msg = '<?=MSG_PLEASE_WAIT_PROCESSING;?>';
	
	<? 
	if (
		stristr($_SERVER['PHP_SELF'], 'auction_search.php') || 
		stristr($_SERVER['PHP_SELF'], 'other_items.php') || 
		stristr($_SERVER['PHP_SELF'], 'shop.php') || 
		stristr($_SERVER['PHP_SELF'], 'categories.php') || 
		stristr($_SERVER['PHP_SELF'], 'auctions_show.php')
	) { ?>
	var location_reload = true;
	<? } else { ?>
	var location_reload = false;
	<? } ?>	
	var s_usr = '<?=intval(session::value('user_id')); ?>';
	

	function confirm_refresh()
	{
		var is_confirmed = confirm('<?=MSG_PROCEED_CONFIRM;?>');
	
		if (is_confirmed) {
			return true;
		}
		else
		{
			window.location.reload();
		}
	
		return is_confirmed;
	}
	
	var currenttime = '<?=$current_time_display;?>';
	var serverdate=new Date(currenttime);
	
	function padlength(what){
		var output=(what.toString().length==1)? "0"+what : what;
		return output;
	}
	
	function displaytime(){
		serverdate.setSeconds(serverdate.getSeconds()+1)
		var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds());
		document.getElementById("servertime").innerHTML=timestring;
	}
	
	// swf upload code snippet for the bulk upload function
	var swfu;
	
	window.onload = function () {	
		<? if (IN_ADMIN != 1) { ?>
		setInterval("displaytime()", 1000);
		<? } ?>

	 	$.unblockUI();
	 	
	 	$('#form_bulk_list_all, #form_bulk_delete_all, #form_bulk_list_proceed').bind('click', function() {	
			$.blockUI({ message: '<p style="padding: 10px; font-size: 16px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold;">' + processing_msg + '</p>' });
		}); 		
		
		// load tinymce for all text areas which need to have wysiwyg enabled - v6.10 upgrade on Innova.
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<? echo (IN_ADMIN == 1) ? '../' : '';?>' + 'jquery/tiny_mce/tiny_mce_src.js',

			// General options
			theme : "advanced",
         relative_urls: false,
         remove_script_host: false,
         
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor,|,hr,removeformat,visualaid,|,sub,sup",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false

		});

		<? if (stristr($_SERVER['PHP_SELF'], 'auction_details.php') || stristr($_SERVER['PHP_SELF'], 'auction_print.php')) { ?>		
		<? if ($item_details['end_time'] > CURRENT_TIME) { ?>
		
		// adding jquery countdown functions
		setTimeout(function() {calcEndTime()}, 1000);
		
		function calcEndTime()
		{
			$.post(
			"ajax_files/refresh_countdown.php",
			{
				auction_id: <?=$item_details['auction_id'];?>
			},
			function(response)
			{			
				$('#time_left').countdown('destroy');
				
				$('#time_left').countdown({ 
					until: response, 
					serverSync: serverTime, 
					layout:'{d<}{dn} {dl},{d>} ' + '{hn}<?=GMSG_H;?> {mn}<?=GMSG_M;?> {sn}<?=GMSG_S;?>'
				});
				
				setTimeout(function() {calcEndTime()}, 20000);
			});
		}
		
		function serverTime() 
		{
			var time = null;
			
			$.ajax({
				url: 'ajax_files/server_time.php',
				async: false, 
				dataType: 'text',
				success: function(text) 
				{
					time = new Date(text);
				}, 
				error: function(http, message, exc) 
				{
					time = new Date();
				}
			});
			return time;
		}
		<? } ?>
		<? } ?>
	
		var bulk_upload_page = document.getElementById('spanButtonPlaceholder');
		
		if (bulk_upload_page != null)
		{
			swfu = new SWFUpload({
				// Backend settings
				upload_url: "ajax_files/bulk_uploader.php",
				file_post_name: "bulk_file",
		
				// Flash file settings
				file_size_limit : "50 MB",
				file_types : "*.csv;*.txt",			// or you could use something like: "*.doc;*.wpd;*.pdf",
				file_types_description : "CSV Files",
				file_upload_limit : "1",
				file_queue_limit : "1",
		
				// Event handler settings
				swfupload_loaded_handler : swfUploadLoaded,
		
				file_dialog_start_handler: fileDialogStart,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
		
				//upload_start_handler : uploadStart,	// I could do some client/JavaScript validation here, but I don't need to.
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
		
				// Button Settings
				button_image_url : "jquery/img/XPButtonUploadText_61x22.png",
				button_placeholder_id : "spanButtonPlaceholder",
				button_width: 61,
				button_height: 22,
		
				// Flash Settings
				flash_url : "jquery/swfupload/swfupload.swf",
		
				custom_settings : {
					progress_target : "fsUploadProgress",
					upload_successful : false
				},
		
				// Debug settings
				debug: false
			});
		}
	
	};	
</script>

<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/global.js"></script>

<? 
if (
	stristr($_SERVER['PHP_SELF'], 'auction_details.php')	||	
	stristr($_SERVER['PHP_SELF'], 'auction_print.php')	||	
	stristr($_SERVER['PHP_SELF'], 'sell_item.php')	||	
	stristr($_SERVER['PHP_SELF'], 'reverse_details.php') || 
	stristr($_SERVER['PHP_SELF'], 'reverse_print.php') || 
	stristr($_SERVER['PHP_SELF'], 'reverse_profile.php') || 
	stristr($_SERVER['PHP_SELF'], 'wanted_details.php')
) { ?>

<link href="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/css/jquery.thumbnailScroller.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/js/jquery.easing.1.3.js"></script>

<script type="text/javascript" src="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<? echo (IN_ADMIN == 1) ? '../' : '';?>jquery/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<script type="text/javascript">
	$(document).ready(function(){
		$("a.lightbox").fancybox({
			'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	false
		});		
	});		
</script>
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
<!--[if lt IE 8]><style>
.wraptocenter span {
    display: inline-block;
    height: 100%;
}
</style><![endif]-->
