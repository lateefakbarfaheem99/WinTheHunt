<?
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2009 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');

(string) $active_pg = 'AlertPay';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

$post_details = $db->rem_special_chars($_REQUEST);

$payment_gross = $post_details['ap_amount'];
$txn_id = $post_details['ap_referencenumber'];

list($custom, $fee_table) = explode('TBL',$post_details['apc_1']);
$user_id = intval($post_details['apc_2']); //used for direct payment

if ($user_id > 0)
{
	$security_code = $db->get_sql_field("SELECT pg_alertpay_securitycode FROM " . DB_PREFIX . "users WHERE user_id='" . $user_id . "'", 'pg_alertpay_securitycode');
}
else 
{
	$security_code = $setts['pg_alertpay_securitycode'];
}

if ($post_details['ap_securitycode'] == $security_code && $post_details['ap_status'] == 'Success')
{
	$process_fee = new fees();
	$process_fee->setts = &$setts;

	$process_fee->callback_process($custom, $fee_table, $active_pg, $payment_gross, $txn_id, $payment_currency);
}

?>