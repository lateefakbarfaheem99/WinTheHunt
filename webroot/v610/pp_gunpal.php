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

(string) $active_pg = 'GUNPAL';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

$post_details = $_POST;

$payment_gross = $post_details['amount'];
$payment_currency = $post_details['currency']; // the currency in which the payment was made
$txn_id = $post_details['gp_transaction_id'];

list($transaction_id, $hash) = explode('|', $post_details['custom']);
$hash = base64_decode($hash);
$hash_created = sha1($transaction_id . GUNPAL_HASH);

list($custom, $fee_table) = explode('TBL', $transaction_id);

if ($post_details['response'] == 1 && $hash == $hash_created)
{
	$process_fee = new fees();
	$process_fee->setts = &$setts;

	$process_fee->callback_process($custom, $fee_table, $active_pg, $payment_gross, $txn_id, $payment_currency);
}
?>