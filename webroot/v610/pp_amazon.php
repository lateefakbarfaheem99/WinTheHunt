<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');

(string) $active_pg = 'Amazon';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

require 'amazon_payments/SimplePay_IPN.php';

function writeToLog($text) 
{
	/*
	$handle = @fopen('amazon_payments/amazon_log.txt', 'a');
	
	if ($handle) 
	{
		$logData = "\n\n----[" . date('Y-m-d') . ' ' . date('H:i:s') . "]-------------\n";
		$logData .= $text;
		@fwrite($handle, $logData);
	}
	*/
}

list($custom, $fee_table, $seller_id) = explode('TBL',$_POST['referenceId']);

if (array_key_exists('signature', $_POST)) 
{

	if ($seller_id)
	{
		$amazon_secret_key = $db->get_sql_field("SELECT pg_amazon_secret_key FROM " . DB_PREFIX . "users WHERE user_id='" . intval($seller_id) . "'");
	}
	else 
	{
		$amazon_secret_key = $setts['pg_amazon_secret_key'];
	}
	// Construct a new SimplePay IPN validator
	$SimplePayIPN = new SimplePay_IPN($amazon_secret_key);
		
	if ($SimplePayIPN->isValid($_POST)) 
	{
		// The POST signature is valid
		writeToLog('Valid IPN POST: ' . "\n" . var_export($_POST, true));
		
		$payment_status = $_POST['status'];
		list($payment_currency, $payment_gross) = @explode(' ', $_POST['amount']);
		$txn_id = 'AmazonTXN';

		if ($payment_status == 'PS')
		{
			$process_fee = new fees();
			$process_fee->setts = &$setts;

			$process_fee->callback_process($custom, $fee_table, $active_pg, $payment_gross, $txn_id, $payment_currency);

			if ($fee_table == 2) /* activate the account if a balance payment is made */
			{
				$session->set('membersarea', 'Active');
			}
		}

	} 
	else 
	{
		// The POST signature is not valid
		writeToLog('IPN POST failed to validate: ' . "\n" . var_export($_POST, true));
	}
} 
else 
{
	/*
	 Something visited the IPN script, but the signature parameter was
	 not sent in the POST data.  Log the IP address of the request and
	 dump the contents of $_POST to the log
	*/
	writeToLog('Invalid visit to the IPN script from IP ' . $_SERVER['REMOTE_ADDR'] . "\n" . var_export($_POST, true));
}
?>