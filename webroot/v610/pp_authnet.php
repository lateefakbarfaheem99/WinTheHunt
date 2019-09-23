<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');

(string) $active_pg = 'Authorize.net';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

function setsrc($a)
{
	$d = explode('/', $_SERVER["PHP_SELF"]);
	$e = '/';
	for ($i = 0; isset($d[$i+1]); $i++)
	{
		$e .= $d[$i] . '/';
	}
	$a =  str_replace("src=\"", "src=\"http://" . $_SERVER["HTTP_HOST"] . $e, $a);
	$a =  str_replace("background=\"", "background=\"http://" . $_SERVER["HTTP_HOST"] . $e, $a);
	$a = str_replace("href=\"t", "href=\"http://" . $_SERVER["HTTP_HOST"] . $e . "t", $a);

	return str_replace("href=\"i", "href=\"http://" . $_SERVER["HTTP_HOST"] . $e . "i", $a);
}

ob_start(setsrc);
ob_end_flush();


$txnid = $_REQUEST['x_trans_id'];
$payment_gross = $_REQUEST['x_amount'];
$currentTime=time();

$payment_gross = $_POST['x_amount'];
$payment_currency = 'USD';
$txn_id = $_POST['x_trans_id'];

list($custom, $fee_table) = explode('TBL',$_POST['probid_id']);

if ($_REQUEST['x_response_code'] == 1)
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