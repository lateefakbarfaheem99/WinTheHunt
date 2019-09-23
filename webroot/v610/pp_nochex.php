<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');

(string) $active_pg = 'Nochex';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

// Set this to 1 to troubleshoot problems!
$log = 0;

// Open logfile
if ($log)
{
  	$fh = fopen("config/Nochex.log", "a");
  	fputs($fh, "\n------------\n");
}

$res = http_post("www.nochex.com", 80, "/nochex.dll/apc/apc", $_POST);

$payment_status = $_POST['status'];
$payment_gross = $_POST['amount'];
$payment_currency = 'GBP';
$txn_id = $_POST['transaction_id'];

list($custom, $fee_table) = explode('TBL',$_POST['order_id']);

if ($log) fputs($fh, ">   " . $res);

if (strstr($res, 'AUTHORISED'))
{
	if (trim($payment_status) == 'live')
	{
		$process_fee = new fees();
		$process_fee->setts = &$setts;

		$process_fee->callback_process($custom, $fee_table, $active_pg, $payment_gross, $txn_id, $payment_currency);

		if ($log) fputs($fh, "\n* Nochex Payment Accepted (Live)\n");
	}
	else
	{
		if ($log) fputs($fh, "\n* Nochex Payment Accepted (Test Mode!)\n");
	}

	$redirect_url = SITE_PATH . 'payment_completed.php';
}
else
{
	if ($log) fputs($fh, "* Nochex Payment Declined.\n");

	$redirect_url = SITE_PATH . 'payment_failed.php';
}

header_redirect($redirect_url);
?>