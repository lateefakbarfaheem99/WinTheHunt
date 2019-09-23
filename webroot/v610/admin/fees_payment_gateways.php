<?
#################################################################
## PHP Pro Bid v6.10															##
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

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if (isset($_POST['form_save_settings']))
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

		$sql_reset_pgs = $db->query("UPDATE " . DB_PREFIX . "payment_gateways SET
			dp_enabled = 0, checked = 0");

		$pg_checked = $db->implode_array($_POST['checked']);

		$sql_update_checked = $db->query("UPDATE " . DB_PREFIX . "payment_gateways SET
			checked = 1 WHERE pg_id IN (" . $pg_checked . ")");

		$pg_dp_enabled = $db->implode_array($_POST['dp_enabled']);

		$sql_update_checked = $db->query("UPDATE " . DB_PREFIX . "payment_gateways SET
			dp_enabled = 1 WHERE pg_id IN (" . $pg_dp_enabled . ")");

		$sql_update_pg_details = $db->query("UPDATE " . DB_PREFIX . "gen_setts SET
			pg_paypal_email = '" . $db->rem_special_chars($_POST['pg_paypal_email']) . "',
			pg_worldpay_id = '" . $db->rem_special_chars($_POST['pg_worldpay_id']) . "',
			pg_checkout_id = '" . $db->rem_special_chars($_POST['pg_checkout_id']) . "',
			pg_nochex_email = '" . $db->rem_special_chars($_POST['pg_nochex_email']) . "',
			pg_ikobo_username = '" . $db->rem_special_chars($_POST['pg_ikobo_username']) . "',
			pg_ikobo_password = '" . $db->rem_special_chars($_POST['pg_ikobo_password']) . "',
			pg_protx_username = '" . $db->rem_special_chars($_POST['pg_protx_username']) . "',
			pg_protx_password = '" . $db->rem_special_chars($_POST['pg_protx_password']) . "',
			pg_authnet_username = '" . $db->rem_special_chars($_POST['pg_authnet_username']) . "',
			pg_authnet_password = '" . $db->rem_special_chars($_POST['pg_authnet_password']) . "',
			pg_mb_email = '" . $db->rem_special_chars($_POST['pg_mb_email']) . "', 
			pg_paymate_merchant_id = '" . $db->rem_special_chars($_POST['pg_paymate_merchant_id']) . "',
			pg_gc_merchant_id = '" . $db->rem_special_chars($_POST['pg_gc_merchant_id']) . "',
			pg_gc_merchant_key = '" . $db->rem_special_chars($_POST['pg_gc_merchant_key']) . "',
			pg_amazon_access_key = '" . $db->rem_special_chars($_POST['pg_amazon_access_key']) . "',
			pg_amazon_secret_key = '" . $db->rem_special_chars($_POST['pg_amazon_secret_key']) . "', 
			pg_alertpay_id = '" . $db->rem_special_chars($_POST['pg_alertpay_id']) . "',
			pg_alertpay_securitycode = '" . $db->rem_special_chars($_POST['pg_alertpay_securitycode']) . "', 
			pg_gunpal_id = '" . $db->rem_special_chars($_POST['pg_gunpal_id']) . "'");
	}

	$template->set('header_section', AMSG_FEES);
	$template->set('subpage_title', AMSG_SETUP_PAYMENT_GATEWAYS);

	$sql_select_active_pg = $db->query("SELECT name FROM " . DB_PREFIX . "payment_gateways WHERE checked=1");

	(string) $active_pg_message = null;

	while ($active_pg_details = $db->fetch_array($sql_select_active_pg))
	{
		$active_pg_message .= ' [ <font color="#EEEE00">' . $active_pg_details['name'] . '</font> ] ';
	}

	$template->set('active_pg_message', $active_pg_message);

	$sql_select_pg = $db->query("SELECT pg_id, name, dp_enabled, checked, logo_url FROM
		" . DB_PREFIX . "payment_gateways");

	(string) $pg_box_table_rows = null;

	$gen_setts = $db->get_sql_row("SELECT * FROM
		" . DB_PREFIX . "gen_setts LIMIT 0,1");

	while ($pg_details = $db->fetch_array($sql_select_pg))
	{
		$template->set('pg_details', $pg_details);

		(string) $pg_settings_rows = null;

		$background = ($counter++%2) ? 'c1' : 'c2';

		switch ($pg_details['name'])
		{
			case 'PayPal':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_PAYPAL_EMAIL . '</td> '.
					'	<td><input name="pg_paypal_email" type="text" value="' . $gen_setts['pg_paypal_email'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_PAYPAL_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_paypal.php</b></td> '.
					'</tr> ';
				break;
			case 'Worldpay':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_WORLDPAY_ID . '</td> '.
					'	<td><input name="pg_worldpay_id" type="text" value="' . $gen_setts['pg_worldpay_id'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_WORLDPAY_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_worldpay.php</b></td> '.
					'</tr> ';
				break;
			case '2Checkout':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_CHECKOUT_ID . '</td> '.
					'	<td><input name="pg_checkout_id" type="text" value="' . $gen_setts['pg_checkout_id'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_CHECKOUT_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_checkout.php</b></td> '.
					'</tr> ';
				break;
			case 'Nochex':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_NOCHEX_EMAIL . '</td> '.
					'	<td><input name="pg_nochex_email" type="text" value="' . $gen_setts['pg_nochex_email'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_NOCHEX_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_nochex.php</b></td> '.
					'</tr> ';
				break;
			case 'Ikobo':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_IKOBO_USERNAME . '</td> '.
					'	<td><input name="pg_ikobo_username" type="text" value="' . $gen_setts['pg_ikobo_username'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_IKOBO_PASSWORD . '</td> '.
					'	<td><input name="pg_ikobo_password" type="text" value="' . $gen_setts['pg_ikobo_password'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_IKOBO_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_ikobo.php</b></td> '.
					'</tr> ';
				break;
			case 'Protx':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_PROTX_USERNAME . '</td> '.
					'	<td><input name="pg_protx_username" type="text" value="' . $gen_setts['pg_protx_username'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_PROTX_PASSWORD . '</td> '.
					'	<td><input name="pg_protx_password" type="text" value="' . $gen_setts['pg_protx_password'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_PROTX_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_protx.php</b></td> '.
					'</tr> ';
				break;
			case 'Authorize.net':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_AUTHNET_USERNAME . '</td> '.
					'	<td><input name="pg_authnet_username" type="text" value="' . $gen_setts['pg_authnet_username'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_AUTHNET_PASSWORD . '</td> '.
					'	<td><input name="pg_authnet_password" type="text" value="' . $gen_setts['pg_authnet_password'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_AUTHNET_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_authnet.php</b></td> '.
					'</tr> ';
				break;
			case 'Moneybookers':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_MB_EMAIL . '</td> '.
					'	<td><input name="pg_mb_email" type="text" value="' . $gen_setts['pg_mb_email'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_MB_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_moneybookers.php</b></td> '.
					'</tr> ';
				break;
			case 'Paymate':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_PAYMATE_MERCHANT_ID . '</td> '.
					'	<td><input name="pg_paymate_merchant_id" type="text" value="' . $gen_setts['pg_paymate_merchant_id'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_PAYMATE_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_paymate.php</b></td> '.
					'</tr> ';
				break;
			case 'Google Checkout':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_GC_MERCHANT_ID . '</td> '.
					'	<td><input name="pg_gc_merchant_id" type="text" value="' . $gen_setts['pg_gc_merchant_id'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_GC_MERCHANT_KEY . '</td> '.
					'	<td><input name="pg_gc_merchant_key" type="text" value="' . $gen_setts['pg_gc_merchant_key'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_GC_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_gc.php</b></td> '.
					'</tr> ';
				break;
			case 'Amazon':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_AMAZON_ACCESS_KEY . '</td> '.
					'	<td><input name="pg_amazon_access_key" type="text" value="' . $gen_setts['pg_amazon_access_key'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_AMAZON_SECRET_KEY . '</td> '.
					'	<td><input name="pg_amazon_secret_key" type="text" value="' . $gen_setts['pg_amazon_secret_key'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_AMAZON_PAYMENTS_NOTE . '</td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_AMAZON_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_amazon.php</b></td> '.
					'</tr> ';
				break;
			case 'AlertPay':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_ALERTPAY_ID . '</td> '.
					'	<td><input name="pg_alertpay_id" type="text" value="' . $gen_setts['pg_alertpay_id'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_ALERTPAY_SECURITY_CODE . '</td> '.
					'	<td><input name="pg_alertpay_securitycode" type="text" value="' . $gen_setts['pg_alertpay_securitycode'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_ALERTPAY_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_alertpay.php</b></td> '.
					'</tr> ';
				break;
			case 'GUNPAL':
				$pg_settings_rows .= '<tr class="' . $background . '"> '.
	      		'	<td width="250">' . GMSG_GUNPAL_ID . '</td> '.
					'	<td><input name="pg_gunpal_id" type="text" value="' . $gen_setts['pg_gunpal_id'] . '" size="50"></td> '.
					'</tr> ';
				$pg_settings_rows .= '<tr> '.
	      		'	<td></td> '.
					'	<td class="' . $background . '">' . GMSG_GUNPAL_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_gunpal.php</b></td> '.
					'</tr> ';
					break;
		}
		$template->set('pg_settings_rows', $pg_settings_rows);

		$pg_box_table_rows .= $template->process('fees_payment_gateways_pgbox.tpl.php');
	}

	$template->set('pg_box_table_rows', $pg_box_table_rows);

	$template_output .= $template->process('fees_payment_gateways.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>
