<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

function login_user ($username, $password, $redirect_url = '', $admin_login = false)
{
	global $db, $setts, $signup_fee;

	(array) $login_output = NULL;

	if ($admin_login) ## the spoofer login, we dont need to check for the password here
	{
		logout(false, false);

		$login_query = $db->query("SELECT user_id, username, active, approved, salt, payment_status, is_seller, mail_activated FROM " . DB_PREFIX . "users WHERE
			username='" . $username . "' LIMIT 0,1");
	}
	else
	{
		$salt = $db->get_sql_field("SELECT salt FROM " . DB_PREFIX . "users WHERE username='" . $username . "'", "salt");

		$password_hashed = password_hash($password, $salt);
		
		$password_old = substr(md5($password), 0, 30); ## added for backward compatibility (v5.25 and older versions)

		$login_query = $db->query("SELECT user_id, username, active, approved, salt, 
			payment_status, is_seller, mail_activated FROM " . DB_PREFIX . "users WHERE username='" . $username . "' AND 
			(password='" . $password_hashed . "' OR password='" . $password_old . "') LIMIT 0,1");
	}

	$is_login = $db->num_rows($login_query);

	$login_output['redirect_url'] = 'login.php?invalid_login=1';
	$login_output['user_exists'] = false;

	/**
	 * Important: the redirect to activate_account.php only needs to happen if the signup fee wasnt paid.
	 */

	if ($is_login)
	{
		$login_output = $db->fetch_array($login_query);
		$login_output['user_exists'] = true;

		$login_output['redirect_url'] = (!empty($redirect_url)) ? $redirect_url : 'index.php';

		$login_output['is_seller'] = ($setts['enable_private_site']) ? $login_output['is_seller'] : 1;

		## add signup fee procedure here.
		$signup_result = $signup_fee->signup($login_output['user_id']);

		if ($login_output['active'] == 1 && $login_output['approved'] == 1 && $login_output['mail_activated'] == 1)
		{
			$login_output['active'] = 'Active';
		}
		else if ($login_output['approved'] == 0 || $login_output['mail_activated'] == 0 || ($signup_result['amount']>0 && $login_output['payment_status'] != 'confirmed')) /* the signup fee wasnt paid, redirect to the payment page */
		{
			$login_output['active'] = null;
			$login_output['redirect_url'] = 'activate_account.php';

			// user_id and username wont be activated either, the user will need to log in again after making the signup fee payment
			$login_output['temp_user_id'] = $login_output['user_id'];
			$login_output['user_id'] = null;
			$login_output['username'] = null;
		}
		else /* means the user is suspended for whichever reason. Members area access is limited. */
		{
			$login_output['active']	= null;
			$login_output['redirect_url'] = 'members_area.php?page=account&section=management';
		}

		## need to fix the function here to see how it handles every situation.
	}

	return $login_output;
}

function login_admin ($username, $password, $pin_generated, $pin_submitted, $check_pin = true)
{
	global $db;

	(array) $login_output = NULL;

	$login_query = $db->query("SELECT * FROM " . DB_PREFIX . "admins WHERE
		username='" . $username . "' AND password='" . md5($password) . "' LIMIT 0,1");

	$is_login = $db->num_rows($login_query);

	if ($is_login)
	{
		$login_details = $db->fetch_array($login_query);

		$valid_pin = ($check_pin) ? check_pin($pin_generated, $pin_submitted) : true;

		if ($valid_pin)
		{
			$login_output['active'] = 'Active';
			$login_output['level'] = $login_details['level'];

			$update_last_login = $db->query("UPDATE " . DB_PREFIX . "admins SET
				date_lastlogin='" . CURRENT_TIME . "' WHERE id='" . $login_details['id'] . "'");
		}
	}

	return $login_output;
}

function logout ($logout_admin = false, $redirect = true)
{
	global $session;

	if ($logout_admin)
	{
		$session->unregister('adminarea');
		$session->unregister('adminlevel');
	}
	else
	{
		$session->unregister('membersarea');
		$session->unregister('username');
		$session->unregister('user_id');
		$session->unregister('is_seller');
		$session->unregister('rm_username');
		$session->unregister('login_store');
		$session->unregister('login_category');
		
		$session->unset_cookie('username_cookie');
	}

	if ($redirect)
	{
		header_redirect('index.php');
	}
}

function password_hash ($password, $salt)
{
	return md5(md5($password) . $salt);
}

function login_spoofer ($username, $admin_username, $admin_password)
{
	global $db;
	(array) $login_output = NULL;

	$login_query = $db->query("SELECT * FROM " . DB_PREFIX . "admins WHERE
		username='" . $admin_username . "' AND password='" . md5($admin_password) . "' AND level='1' LIMIT 0,1");

	$is_login = $db->num_rows($login_query);

	$login_output['admin_exists'] = false;
	if ($is_login)
	{
		$login_output = login_user($username, '', '', true);
		$login_output['admin_exists'] = true;
	}

	return $login_output;
}

?>