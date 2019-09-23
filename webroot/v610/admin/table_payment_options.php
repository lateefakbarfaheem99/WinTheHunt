<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);
define ('IN_SITE', 1);

include_once ('../includes/global.php');

include_once ('../includes/class_formchecker.php');
include_once ('../includes/class_custom_field.php');
include_once ('../includes/class_item.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$form_submitted = false;

	$item = new item();
	$item->setts = &$setts;
	$item->setts['max_images'] = 1;
	$item->relative_path = '../'; /* declared because we are in the admin */

	$item_details = $_POST;
	$item_details['auction_id'] = ($_POST['name']) ? remove_spaces($_POST['name']) : 'pmethod_logo';

	if ($_REQUEST['do'] == 'edit_option')
	{
		$row_payment_option = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "payment_options WHERE id=" . $_REQUEST['option_id']);

		$item_details['ad_image'][0] = ((!empty($_POST['ad_image'][0])) ? $_POST['ad_image'][0] : $row_payment_option['logo_url']);
	}

	if (empty($_POST['file_upload_type']))
	{
		$template->set('media_upload_fields', $item->upload_manager($item_details));
	}
	else if (is_numeric($_POST['file_upload_id'])) /* means we remove a file / media url */
	{
		$media_upload = $item->media_removal($item_details, $item_details['file_upload_type'], $item_details['file_upload_id'], false);
		$media_upload_fields = $media_upload['display_output'];

		$item_details['ad_image'] = $media_upload['post_details']['ad_image'];

		if ($_REQUEST['do'] == 'edit_option')
		{
			$db->query("UPDATE " . DB_PREFIX . "payment_options SET logo_url='' WHERE id='" . intval($_REQUEST['option_id']) . "'");	
		}

		$template->set('media_upload_fields', $media_upload_fields);
		$template->set('pm_details', $item_details);
	}
	else /* means we have a file upload */
	{
		$media_upload = $item->media_upload($item_details, $item_details['file_upload_type'], $_FILES, false);
		$media_upload_fields = $media_upload['display_output'];

		$item_details['ad_image'] = $media_upload['post_details']['ad_image'];

		$template->set('media_upload_fields', $media_upload_fields);
		$template->set('pm_details', $item_details);
	}

	if ($_REQUEST['do'] == 'add_option')
	{
		if (isset($_POST['form_payment_option_save']))
		{
			$form_submitted = TRUE;

			$template->set('msg_changes_saved', $msg_changes_saved);

			$sql_insert_payment_option = $db->query("INSERT INTO " . DB_PREFIX . "payment_options
				(name, logo_url) VALUES
				('" . $db->rem_special_chars($_POST['name']) . "', '" . get_main_image($_POST['ad_image']) . "')");
		}

		if (!$form_submitted)
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_ADD_PAYMENT_OPTION);
			$template->set('disabled_button', 'disabled');

			$image_upload_manager = $item->upload_manager($item_details, 1, 'form_payment_option', true);
			$template->set('image_upload_manager', $image_upload_manager);

			$management_box = $template->process('table_payment_options_add_option.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'edit_option')
	{
		$template->set('pm_details', $row_payment_option);

		if (isset($_POST['form_payment_option_save']))
		{
			$form_submitted = TRUE;

			$template->set('msg_changes_saved', $msg_changes_saved);

			$sql_update_payment_option = $db->query("UPDATE " . DB_PREFIX . "payment_options SET
				name = '" . $db->rem_special_chars($_POST['name']) . "',
				logo_url = '" . get_main_image($_POST['ad_image']) . "' WHERE
				id=" . $_POST['option_id']);
		}

		if (!$form_submitted)
		{
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_EDIT_PAYMENT_OPTION);
			$template->set('disabled_button', 'disabled');

			$image_upload_manager = $item->upload_manager($item_details, 1, 'form_payment_option', true);
			$template->set('image_upload_manager', $image_upload_manager);

			$management_box = $template->process('table_payment_options_add_option.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'delete_option')
	{
		$row_payment_option = $db->get_sql_row("SELECT logo_url FROM " . DB_PREFIX . "payment_options WHERE id=" . $_REQUEST['option_id']);

		@unlink('../' . $row_payment_option['logo_url']);
		$sql_delete_payment_option = $db->query("DELETE FROM " . DB_PREFIX . "payment_options WHERE
			id=" . $_REQUEST['option_id']);
	}

	$template->set('header_section', AMSG_USERS_MANAGEMENT);
	$template->set('subpage_title', AMSG_EDIT_PAYMENT_OPTIONS);

	(string) $payment_options_content = NULL;

	$template->set('management_box', $management_box);

	$sql_select_payment_options = $db->query("SELECT * FROM
		" . DB_PREFIX . "payment_options");

	while ($payment_option = $db->fetch_array($sql_select_payment_options))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';

		$logo_url = (($payment_option['logo_url']) ? $payment_option['logo_url'] : 'images/noimg.gif');

		$payment_options_content .= '<input type="hidden" name="option_id[]" value="' . $payment_option['id'] . '"> '.
		'<tr class="' . $background . '"> '.
		'	<td>' . $payment_option['name'] . '</td> '.
		'	<td align="center"><img src="../thumbnail.php?pic=' . $logo_url . '&w=80&sq=Y&b=Y" border="0" alt="' . $payment_option['name'] . '"></td> '.
		'	<td align="center"> '.
		'		[ <a href="table_payment_options.php?do=edit_option&option_id=' . $payment_option['id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
		'		[ <a href="table_payment_options.php?do=delete_option&option_id=' . $payment_option['id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
		'</tr> ';
	}

	$template->set('payment_options_content', $payment_options_content);

	$template_output .= $template->process('table_payment_options.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>