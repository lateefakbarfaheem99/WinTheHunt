<?php
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);
define ('IN_AJAX', 1);

include_once('../includes/global.php');

include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_item.php');

if ($_REQUEST['do'] == 'remove')
{
   $can_delete = false;
   $auction_id = intval($_REQUEST['auction_id']);
   
   if ($session->value('adminarea') == 'Active')
   {
      // admin can delete any files
      $can_delete = true;
   }
   else
   {
	   $user_id = $db->get_sql_field("SELECT a.owner_id
	      FROM " . DB_PREFIX . "auctions a, " . DB_PREFIX . "auction_media am
	      WHERE a.auction_id=am.auction_id AND 
	      am.media_url='" . $db->rem_special_chars($_REQUEST['file_name']) . "' AND 
	      am.auction_id='{$auction_id}'", 'owner_id');
	   
	   if ($user_id == $session->value('user_id') || !$user_id)
	   {
	   	$can_delete = true;
	   }
   }
   
   if ($can_delete)
   {
		// we restrict this to only one row
		$db->query("DELETE FROM " . DB_PREFIX . "auction_media 
			WHERE media_url='" . $db->rem_special_chars($_REQUEST['file_name']) . "' AND auction_id='" . $auction_id . "'");   	
			
		$is_media = $db->count_rows('auction_media', "WHERE media_url='" . $db->rem_special_chars($_REQUEST['file_name']) . "'");
			
		if (!$is_media)
		{
			@unlink('../' . $_REQUEST['file_name']);
		}
	   
	   echo MSG_REMOVAL_SUCCESSFUL;
   }
}

if ($_REQUEST['do'] == 'add')
{
	$can_add = true;
	
	if (empty($_REQUEST['file_embed']))
	{
		require_once "../JsHttpRequest/JsHttpRequest.php";
		$JsHttpRequest = new JsHttpRequest("windows-1251");
	}
			
	// we copy the file if there is an upload, we return the hidden id, the hidden content and then we return a media upload box
	$errors = '';
	$item_details = $db->rem_special_chars_array($_REQUEST);
	$item_details['file_embed'] = js_base64_decode($_REQUEST['file_embed']);
	
	$media_type = intval($_REQUEST['media_type']);
	
	list($listing_type, $listing_id) = @explode('_', $_REQUEST['upload_id']);

	switch ($listing_type)
	{
		case 'W':
			$item_details['wanted_ad_id'] = $listing_id;
			break;
		case 'R':
			$item_details['reverse_id'] = $listing_id;
			break;
		case 'P':
			$item_details['profile_id'] = $listing_id;
			break;
		default:
			$item_details['auction_id'] = $listing_id;
			break;
	}
	$create_row = ($listing_id > 0) ? true : false;

	$item = new item();
	$item->setts = &$setts;
   $creation_in_progress = $db->get_sql_field("SELECT creation_in_progress FROM " . DB_PREFIX . "auctions 
      WHERE auction_id='{$auction_id}'", 'creation_in_progress');
	$item->edit_auction = ($creation_in_progress) ? 0 : 1;
	$result = $item->media_upload_async($item_details, $media_type, $_FILES, $create_row);
	
	$file_name = $result['file_name'];
	$errors = $result['errors'];
	// create thumb image
	// output = media type, hidden value, thumbnail output display, error output
	
	$box_id = $item->box_id($file_name);

	switch ($media_type)
	{
		case 1:
			$media_name = 'ad_image';
			$thumbnail_display = '<img src="' . SITE_PATH . 'thumbnail.php?pic=' . $file_name . '&w=80&sq=Y&b=Y" border="0" alt="' . $file_name . '"> ';
			break;
		case 2:
			$media_name = 'ad_video';
			$thumbnail_display = '<img src="' . SITE_PATH . 'thumbnail.php?pic=images/media_icon.gif&w=80&sq=Y&b=Y" border="0" alt="' . $db->rem_special_chars($file_name) . '"> ';
			break;
		case 3:
			$media_name = 'ad_dd';
			$thumbnail_display = '<img src="' . SITE_PATH . 'thumbnail.php?pic=images/dd_icon.gif&w=80&sq=Y&b=Y" border="0" alt="' . $item->addlfile_name_display($file_name, $item_details['reverse_id']) . '"> ';
			break;
		default:
			$errors = MSG_INVALID_FILE_TYPE;
         break;
	}

	$thumbnail_display .= '<br>' . GMSG_DELETE .
		' <input type="checkbox" name="delete_media[]" value="1" onclick="delete_media_async(\'' . $item->box_id($file_name, '') . '\', ' . $media_type . ', ' . intval($item_details['auction_id']) . ');" />';

	$thumbnail_output = '<div class="thumbnail_display" id="' . $box_id . '">' . $thumbnail_display . '</div>';
	
	echo $media_type . '|' . $media_name . '|' . $item->box_id($file_name, '') . '|' . $thumbnail_output . '|' . $file_name . '|' . $errors;
}
?>