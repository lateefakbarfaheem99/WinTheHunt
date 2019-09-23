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

(string) $active_pg = 'Ikobo';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

function get_var($name, $default = 'none')
{
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}

list($custom, $fee_table) = explode('TBL',get_var('item_id'));

if ($fee_table == 100) /* the tables for direct payment */
{## PHP Pro Bid v6.00 get the direct payment ikobo username/password
}
else
{
	$ikobo_username = $setts['pg_ikobo_username'];
	$ikobo_password = $setts['pg_ikobo_password'];
}
$account_no = get_var('account_no');
$payment_status = $_POST['payment_status'];
$payment_gross = get_var('total');
$payment_currency = 'USD';
$txn_id = get_var('confirmation');

if ((!empty($account_no) && strlen($account_no) >=8) && (get_var('pwd') == $ikobo_password))
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