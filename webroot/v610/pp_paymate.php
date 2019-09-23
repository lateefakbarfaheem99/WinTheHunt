<?
#################################################################
## PHP Pro Bid v6.05															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');

(string) $active_pg = 'Paymate';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

$payment_gross 	= $_REQUEST['paymentAmount'];
$payment_currency = $_REQUEST['currency'];
$txn_id 				= $_REQUEST['transactionID'];

list($custom, $fee_table) = explode('TBL', $_REQUEST['ref']);

if ($_REQUEST['responseCode'] == 'PA') // payment approved
{
	$process_fee = new fees();
	$process_fee->setts = &$setts;

	$process_fee->callback_process($custom, $fee_table, $active_pg, $payment_gross, $txn_id, $payment_currency);

	$redirect_url = SITE_PATH . 'payment_completed.php';
}
else if ($_REQUEST['responseCode'] == 'PP')
{
	$redirect_url = SITE_PATH . 'payment_processing.php';	
}
else
{
	$redirect_url = SITE_PATH . 'payment_failed.php';
}

header_redirect($redirect_url);
?>