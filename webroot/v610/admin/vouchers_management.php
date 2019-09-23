<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$voucher = new voucher();

	if ($_REQUEST['do'] == 'add_voucher')
	{
		if ($_REQUEST['operation'] == 'submit')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$voucher->add_voucher($_POST);
		}
		else
		{
			$template->set('voucher_details', $_POST);
			$template->set('voucher_type', $_REQUEST['voucher_type']);
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_ADD_VOUCHER);
			$template->set('select_reduced_fees_boxes', $voucher->select_reduced_fees($_POST));

			$management_box = $template->process('vouchers_management_add_voucher.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'edit_voucher')
	{
		if ($_REQUEST['operation'] == 'submit')
		{
			$template->set('msg_changes_saved', $msg_changes_saved);

			$voucher->edit_voucher($_POST);
		}
		else
		{
			$row_voucher = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "vouchers WHERE voucher_id='" . $_REQUEST['voucher_id'] . "'");
			$template->set('voucher_details', $row_voucher);
			$template->set('voucher_type', $row_voucher['voucher_type']);
			$template->set('do', $_REQUEST['do']);
			$template->set('manage_box_title', AMSG_EDIT_VOUCHER);
			$template->set('select_reduced_fees_boxes', $voucher->select_reduced_fees($row_voucher));

			$management_box = $template->process('vouchers_management_add_voucher.tpl.php');
		}
	}
	else if ($_REQUEST['do'] == 'delete_voucher')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		$voucher->delete_voucher($_REQUEST['voucher_id']);
	}

	$template->set('management_box', $management_box);

   $sql_select_vouchers = $db->query("SELECT * FROM " . DB_PREFIX . "vouchers");

   while ($voucher_details = $db->fetch_array($sql_select_vouchers))
	{
		if ($voucher_details['voucher_type'] == 'signup')
		{
			$signup_vouchers_content .= '<tr class="c1"> '.
	      	'	<td>' . $voucher_details['voucher_name'] . '</td> '.
	      	'	<td>' . $voucher_details['voucher_code'] . '</td> '.
	      	'	<td>' . AMSG_START_DATE . ': <b>' . show_date($voucher_details['reg_date']) . '</b><br>'.
	      	'		' . GMSG_EXPIRES_ON . ': <b>' . show_date($voucher_details['exp_date']) . '</b><br>'.
	      	'		' . AMSG_USES_LEFT . ': <b>' . (($voucher_details['nb_uses']) ? $voucher_details['uses_left'] : GMSG_NA) . '</b>'.
	      	'	</td> '.
	      	'	<td align="center"> '.
				'		[ <a href="vouchers_management.php?do=edit_voucher&voucher_id=' . $voucher_details['voucher_id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
				'		[ <a href="vouchers_management.php?do=delete_voucher&voucher_id=' . $voucher_details['voucher_id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
				'</tr> ';
		}
		else if ($voucher_details['voucher_type'] == 'setup')
		{
			$setup_vouchers_content .= '<tr class="c1"> '.
	      	'	<td>' . $voucher_details['voucher_name'] . '</td> '.
	      	'	<td>' . $voucher_details['voucher_code'] . '</td> '.
	      	'	<td>' . AMSG_START_DATE . ': <b>' . show_date($voucher_details['reg_date']) . '</b><br>'.
	      	'		' . GMSG_EXPIRES_ON . ': <b>' . show_date($voucher_details['exp_date']) . '</b><br>'.
	      	'		' . AMSG_USES_LEFT . ': <b>' . (($voucher_details['nb_uses']) ? $voucher_details['uses_left'] : GMSG_NA) . '</b><br>'.
	      	'		' . AMSG_ASSIGNED_FEES . ': <b>' . $voucher_details['assigned_fees'] . '</b>'.
	      	'	</td> '.
	      	'	<td align="center"> '.
				'		[ <a href="vouchers_management.php?do=edit_voucher&voucher_id=' . $voucher_details['voucher_id'] . '">' . AMSG_EDIT . '</a> ] &nbsp;'.
				'		[ <a href="vouchers_management.php?do=delete_voucher&voucher_id=' . $voucher_details['voucher_id'] . '" onclick="return confirm(\'' . AMSG_DELETE_CONFIRM . '\');">' . AMSG_DELETE . '</a> ]</td> '.
				'</tr> ';
		}
	}

	$template->set('signup_vouchers_content', $signup_vouchers_content);
	$template->set('setup_vouchers_content', $setup_vouchers_content);


	$template->set('header_section', AMSG_SITE_CONTENT);
	$template->set('subpage_title', AMSG_VOUCHERS_MANAGEMENT);

	$template_output .= $template->process('vouchers_management.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>