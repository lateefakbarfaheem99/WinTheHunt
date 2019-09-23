<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');

(string) $active_pg = 'Protx';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

function get_var($name, $default = 'none')
{
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}

$protx_amount = 0;
$protx_crypt = $_GET['crypt'];
$protx_plain = '';

$user_id = intval($_REQUEST['user_id']);

if ($user_id > 0) /* the tables for direct payment */
{
	$user_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id='" . $user_id . "'");
	$protx_username = $user_details['pg_protx_username'];
	$protx_password = $user_details['pg_protx_password'];
}
else
{
	$protx_username = $setts['pg_protx_username'];
	$protx_password = $setts['pg_protx_password'];
}

$protx_status = 'ERROR';## PHP Pro Bid v6.00 decode protx crypt
$protx_crypt = base64_decode($protx_crypt);
$key_values = array();

for ($i = 0; $i < strlen($protx_password); $i++)
{
	$key_values[$i] = ord(substr($protx_password, $i, 1));
}

for ($i = 0; $i < strlen($protx_crypt); $i++)
{
	$protx_plain .= chr(ord(substr($protx_crypt, $i, 1)) ^ ($key_values[$i % strlen($protx_password)]));
}

$protx_plain = $protx_plain . '&';## PHP Pro Bid v6.00 get payment amount and status
if (preg_match('/Amount=([^&]+)&/si', $protx_plain, $matches)) $protx_amount = $matches[1];
if (preg_match('/Status=([^&]+)&/si', $protx_plain, $matches)) $protx_status = $matches[1];
if (preg_match('/Currency=([^&]+)&/si', $protx_plain, $matches)) $protx_currency = $matches[1];
if (preg_match('/VPSTxId=([^&]+)&/si', $protx_plain, $matches)) $protx_txnid = $matches[1];
if (preg_match('/VendorTxCode=([^&-]+)TBL([^&-]+)TBL([^&-]+)&/si', $protx_plain, $matches))
{
	$custom = $matches[1];
	$fee_table = $matches[2];
}

$payment_gross = $protx_amount;
$payment_currency = $protx_currency;
$txn_id = $protx_txnid;

if ($custom != '' && $protx_status == 'OK')
{
	$process_fee = new fees();
	$process_fee->setts = &$setts;

	$process_fee->callback_process($custom, $fee_table, $active_pg, $payment_gross, $txn_id, $payment_currency);

	$redirect_url = SITE_PATH . 'payment_completed.php';
}
else
{
	$redirect_url = SITE_PATH . 'payment_failed.php';
}

header_redirect($redirect_url);

?>