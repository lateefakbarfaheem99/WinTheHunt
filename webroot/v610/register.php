<?
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

(string) $page_handle = 'register';

include_once ('includes/global.php');

include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_item.php');
include_once ('includes/class_user.php');
include_once ('includes/class_fees.php');
include_once ('includes/functions_login.php');

if ($session->value('user_id'))
{
	header_redirect('members_area.php');
}
else
{
	$custom_fld = new custom_field();
	$tax = new tax();

	$voucher = new item();
	$voucher->setts = &$setts;
	
	include_once ('global_header.php');

	$banned_output = check_banned($_SERVER['REMOTE_ADDR'], 1);

	if ($banned_output['result'])
	{
		$template->set('message_header', header5(MSG_REGISTRATION));
		$template->set('message_content', $banned_output['display']);

		$template_output .= $template->process('single_message.tpl.php');
	}
	else
	{
		$template->set('imgarrowit', $imgarrowit);
		$template->set('header_registration_message', header5(MSG_REGISTRATION));

		/* From here we load the custom registration sections */

		(string) $custom_sections_table = null;

		$user = new user();
		$user->setts = &$setts;## PHP Pro Bid v6.00 now we will save all post variables selected
		$user->save_vars($_POST);

		$form_submitted = FALSE;## PHP Pro Bid v6.00 if save button is pressed, proceed
		if ($_REQUEST['operation'] == 'submit')
		{
			define ('FRMCHK_USER', 1);
			(bool) $frmchk_user_edit = 0;
			$frmchk_details = $_POST;

			include ('includes/procedure_frmchk_user.php'); /* Formchecker for user creation/edit */

			$banned_output = check_banned($_POST['email'], 2);

			if ($banned_output['result'])
			{
				$template->set('banned_email_output', $banned_output['display']);
			}
			else if ($fv->is_error())
			{
				$template->set('display_formcheck_errors', $fv->display_errors());

			}
			else
			{
				$form_submitted = TRUE;## PHP Pro Bid v6.00 atm we wont create any emails either until we decide how many ways of registration we have.
				(string) $register_success_message = null;

				$user_id = $user->insert($_POST);

				$template->set('register_success_header', header5(MSG_REGISTRATION_CONFIRMATION));## PHP Pro Bid v6.00 add signup fee procedure here.
				$signup_fee = new fees();
				$signup_fee->setts = &$setts;

				// voucher settings
				(array) $voucher_result = null;
				if (!empty($_POST['voucher_value']))
				{
					## voucher is deducted
					$voucher_result = $voucher->check_voucher($_POST['voucher_value'], 'signup', true);
				}
				
				(array) $signup_result = null;
				if (!$voucher_result['valid'])
				{
					$signup_result = $signup_fee->signup($user_id);
				}

				if ($signup_result['amount'])
				{
					$template->set('payment_table_display', $signup_result['display']);					
				}
				else if ($setts['signup_settings'] == 1)
				{
					// email confirmation
					$sql_update_user = $db->query("UPDATE " . DB_PREFIX . "users SET
					active=1, approved=0, payment_status='confirmed' WHERE user_id=" . $user_id);

					$register_success_message = '<p align="center" class="contentfont">' . MSG_REGISTER_SUCCESS_TYPE1 . '</p>';## PHP Pro Bid v6.00 include registration confirmation email
					$mail_input_id = $user_id;
					include('language/' . $setts['site_lang'] . '/mails/register_confirm_user_notification.php');					
				}
				else if ($setts['signup_settings'] == 2)
				{
					// admin approval
					$sql_update_user = $db->query("UPDATE " . DB_PREFIX . "users SET
					active=1, approved=0, payment_status='confirmed' WHERE user_id=" . $user_id);

					$register_success_message = '<p align="center" class="contentfont">' . MSG_REGISTER_SUCCESS_TYPE2 . '</p>';## PHP Pro Bid v6.00 notify user & admin that user approval is required
					$mail_input_id = $user_id;
					include('language/' . $setts['site_lang'] . '/mails/register_approval_user_notification.php');
					include('language/' . $setts['site_lang'] . '/mails/register_approval_admin_notification.php');
				}
				else
				{
					// instant activation
					$sql_update_user = $db->query("UPDATE " . DB_PREFIX . "users SET
					active=1, approved=1, payment_status='confirmed', mail_activated=1 WHERE user_id=" . $user_id);

					$register_success_message = '<p align="center" class="contentfont">' . MSG_REGISTER_SUCCESS_TYPE0 . '</p>';## PHP Pro Bid v6.00 include registration success email
					$mail_input_id = $user_id;
					include('language/' . $setts['site_lang'] . '/mails/register_success_no_fee_user_notification.php');
				}

				$template->set('register_success_message', $register_success_message);

				$template_output .= $template->process('register_success.tpl.php');
			}
		}

		if (!$form_submitted)
		{
			$template->set('register_post_url', 'register.php');
			$template->set('proceed_button', GMSG_REGISTER_BTN);
			$template->set('user_details', $_POST);

			$post_country = ($_POST['country']) ? $_POST['country'] : $db->get_sql_field("SELECT c.id FROM " . DB_PREFIX . "countries c WHERE
				c.parent_id=0 ORDER BY c.country_order ASC, c.name ASC LIMIT 1", 'id');
				
			$template->set('country_dropdown', $tax->countries_dropdown('country', $post_country, 'registration_form'));
			$template->set('state_box', $tax->states_box('state', $_POST['state'], $post_country));

			$template->set('birthdate_box', $user->birthdate_box($_POST));

			$custom_sections_table = $user->display_sections($_POST, $page_handle);

			$template->set('custom_sections_table', $custom_sections_table);

			$session->set('pin_value', md5(rand(2,99999999)));
			$generated_pin = generate_pin($session->value('pin_value'));

			$pin_image_output = show_pin_image($session->value('pin_value'), $generated_pin);

			$template->set('pin_image_output', $pin_image_output);
			$template->set('generated_pin', $generated_pin);

			// voucher settings
			if (!empty($_POST['voucher_value']))
			{
				$voucher_details = $voucher->check_voucher($_POST['voucher_value'], 'signup');

				$template->set('check_voucher_message', $voucher_details['display']);
			}
			$template->set('display_direct_payment_methods', $user->direct_payment_methods_edit($_POST));
			
			$template->set('signup_voucher_box', voucher_form('signup', $_POST['voucher_value']));
			
			$template->set('registration_terms_box', terms_box('registration', $_POST['agree_terms']));

			$template_output .= $template->process('register.tpl.php');
		}
	}
	include_once ('global_footer.php');

	echo $template_output;
}
?>