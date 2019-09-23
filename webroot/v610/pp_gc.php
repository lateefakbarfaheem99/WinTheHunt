<?
#################################################################
## PHP Pro Bid v6.05															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

## for direct payments, call the page like: pg_gc.php?user_id=<USER_ID> !!

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');

(string) $active_pg = 'Google Checkout';
(string) $error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) { die(GMSG_NOT_AUTHORIZED); }

require_once('google_checkout/library/googleresponse.php');
require_once('google_checkout/library/googlemerchantcalculations.php');
require_once('google_checkout/library/googleresult.php');
require_once('google_checkout/library/googlerequest.php');

define('RESPONSE_HANDLER_ERROR_LOG_FILE', 'googleerror.log');
define('RESPONSE_HANDLER_LOG_FILE', 'googlemessage.log');

$user_id = intval($_REQUEST['user_id']);

if ($user_id) /* we have a direct payment */
{
	$user_details = $db->get_sql_row("SELECT pg_gc_merchant_id, pg_gc_merchant_key FROM " . DB_PREFIX . "users 
		WHERE user_id=" . $user_id);
	
	$merchant_id = $user_details['pg_gc_merchant_id'];  
	$merchant_key = $user_details['pg_gc_merchant_key']; 
}
else /* we have a site fee payment */
{
	$merchant_id = $setts['pg_gc_merchant_id']; 
	$merchant_key = $setts['pg_gc_merchant_key']; 
}
$server_type = "sandbox";  // change this to go live
$currency = $setts['currency'];  

$Gresponse = new GoogleResponse($merchant_id, $merchant_key);

$Grequest = new GoogleRequest($merchant_id, $merchant_key, $server_type, $currency);

//Setup the log file
$Gresponse->SetLogFiles(RESPONSE_HANDLER_ERROR_LOG_FILE,
RESPONSE_HANDLER_LOG_FILE, L_ALL);

// Retrieve the XML sent in the HTTP POST request to the ResponseHandler
$xml_response = isset($HTTP_RAW_POST_DATA)?
$HTTP_RAW_POST_DATA:file_get_contents("php://input");
if (get_magic_quotes_gpc()) {
	$xml_response = stripslashes($xml_response);
}

/*
$fp = fopen('gctst.log', 'w+');

fputs($fp, $xml_response);

fclose($fp);
*/
list($root, $data) = $Gresponse->GetParsedXML($xml_response);

$Gresponse->SetMerchantAuthentication($merchant_id, $merchant_key);

$status = $Gresponse->HttpAuthentication();
if(! $status) {
	die('authentication failed');
}

/* Commands to send the various order processing APIs
* Send charge order : $Grequest->SendChargeOrder($data[$root]
*    ['google-order-number']['VALUE'], <amount>);
* Send process order : $Grequest->SendProcessOrder($data[$root]
*    ['google-order-number']['VALUE']);
* Send deliver order: $Grequest->SendDeliverOrder($data[$root]
*    ['google-order-number']['VALUE'], <carrier>, <tracking-number>,
*    <send_mail>);
* Send archive order: $Grequest->SendArchiveOrder($data[$root]
*    ['google-order-number']['VALUE']);
*
*/

switch ($root) 
{
	case "request-received": 
	{
		break;
	}
	case "error": 
	{
		break;
	}
	case "diagnosis": 
	{
		break;
	}
	case "checkout-redirect": 
	{
		break;
	}
	case "merchant-calculation-callback": 
	{
		// Create the results and send it
		$merchant_calc = new GoogleMerchantCalculations($currency);

		// Loop through the list of address ids from the callback
		$addresses = get_arr_result($data[$root]['calculate']['addresses']['anonymous-address']);
		
		foreach($addresses as $curr_address) 
		{
			$curr_id = $curr_address['id'];
			$country = $curr_address['country-code']['VALUE'];
			$city = $curr_address['city']['VALUE'];
			$region = $curr_address['region']['VALUE'];
			$postal_code = $curr_address['postal-code']['VALUE'];

			// Loop through each shipping method if merchant-calculated shipping
			// support is to be provided
			if(isset($data[$root]['calculate']['shipping'])) 
			{
				$shipping = get_arr_result($data[$root]['calculate']['shipping']['method']);
				foreach($shipping as $curr_ship) 
				{
					$name = $curr_ship['name'];
					//Compute the price for this shipping method and address id
					$price = 12; // Modify this to get the actual price
					$shippable = "true"; // Modify this as required
					$merchant_result = new GoogleResult($curr_id);
					$merchant_result->SetShippingDetails($name, $price, $shippable);

					if($data[$root]['calculate']['tax']['VALUE'] == "true") 
					{
						//Compute tax for this address id and shipping type
						$amount = 15; // Modify this to the actual tax value
						$merchant_result->SetTaxDetails($amount);
					}

					if(isset($data[$root]['calculate']['merchant-code-strings']
					['merchant-code-string'])) 
					{
						$codes = get_arr_result($data[$root]['calculate']['merchant-code-strings']
						['merchant-code-string']);
						foreach($codes as $curr_code) 
						{
							//Update this data as required to set whether the coupon is valid, the code and the amount
							$coupons = new GoogleCoupons("true", $curr_code['code'], 5, "test2");
							$merchant_result->AddCoupons($coupons);
						}
					}
					$merchant_calc->AddResult($merchant_result);
				}
			} 
			else 
			{
				$merchant_result = new GoogleResult($curr_id);
				if($data[$root]['calculate']['tax']['VALUE'] == "true") 
				{
					//Compute tax for this address id and shipping type
					$amount = 15; // Modify this to the actual tax value
					$merchant_result->SetTaxDetails($amount);
				}
				$codes = get_arr_result($data[$root]['calculate']['merchant-code-strings']
				['merchant-code-string']);
				foreach($codes as $curr_code) 
				{
					//Update this data as required to set whether the coupon is valid, the code and the amount
					$coupons = new GoogleCoupons("true", $curr_code['code'], 5, "test2");
					$merchant_result->AddCoupons($coupons);
				}
				$merchant_calc->AddResult($merchant_result);
			}
		}
		$Gresponse->ProcessMerchantCalculations($merchant_calc);
		break;
	}
	case "new-order-notification": 
	{
		## here it should mean that the order is successfull, so we add our code here
		$payment_gross 	= $data[$root]['shopping-cart']['items']['item']['unit-price']['VALUE'];
		$payment_currency = $data[$root]['shopping-cart']['items']['item']['unit-price']['currency'];
		$txn_id 				= $data[$root]['google-order-number']['VALUE'];
		
		list($custom, $fee_table, $buyer_id, $seller_id) = explode('TBL', $data[$root]['shopping-cart']['items']['item']['merchant-item-id']['VALUE']);
		
		$payment_description = $data[$root]['shopping-cart']['items']['item']['item-name']['VALUE'];
		
		## add data to gc_transactions		
		$db->query("INSERT INTO " . DB_PREFIX . "gc_transactions 
			(seller_id, buyer_id, google_order_number, gc_custom, 
			gc_table, gc_price, gc_currency, 
			gc_payment_description, reg_date) VALUES 
			('" . intval($seller_id) . "', '" . intval($buyer_id) . "', '" . $txn_id . "', '" . $custom . "', 
			'" . $fee_table . "', '" . $payment_gross . "', '" . $payment_currency . "', 
			'" . $db->rem_special_chars($payment_description) . "', '" . CURRENT_TIME . "')");

		$Gresponse->SendAck();
		break;
	}
	case "order-state-change-notification": 
	{
		$Gresponse->SendAck();
		$new_financial_state = $data[$root]['new-financial-order-state']['VALUE'];
		$new_fulfillment_order = $data[$root]['new-fulfillment-order-state']['VALUE'];

		switch($new_financial_state) 
		{
			case 'REVIEWING': 
			{
				break;
			}
			case 'CHARGEABLE': 
			{
				//$Grequest->SendProcessOrder($data[$root]['google-order-number']['VALUE']);
				//$Grequest->SendChargeOrder($data[$root]['google-order-number']['VALUE'],'');
				break;
			}
			case 'CHARGING': 
			{
				break;
			}
			case 'CHARGED': 
			{
				break;
			}
			case 'PAYMENT_DECLINED': 
			{
				break;
			}
			case 'CANCELLED': 
			{
				break;
			}
			case 'CANCELLED_BY_GOOGLE': 
			{
				//$Grequest->SendBuyerMessage($data[$root]['google-order-number']['VALUE'],
				//    "Sorry, your order is cancelled by Google", true);
				break;
			}
			default:
				break;
		}

		switch($new_fulfillment_order) 
		{
			case 'NEW': 
			{
				break;
			}
			case 'PROCESSING': 
			{
				break;
			}
			case 'DELIVERED': 
			{
				break;
			}
			case 'WILL_NOT_DELIVER': 
			{
				break;
			}
			default:
				break;
		}
		break;
	}
	case "charge-amount-notification": 
	{
		//$Grequest->SendDeliverOrder($data[$root]['google-order-number']['VALUE'],
		//    <carrier>, <tracking-number>, <send-email>);
		//$Grequest->SendArchiveOrder($data[$root]['google-order-number']['VALUE'] );
		$txn_id 				= $data[$root]['google-order-number']['VALUE'];
		
		$process_fee = new fees();
		$process_fee->setts = &$setts;
		
		$order_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "gc_transactions WHERE google_order_number='" . $txn_id . "'");
		
		$custom 				= $order_details['gc_custom'];
		$fee_table 			= $order_details['gc_table'];
		$payment_gross 	= $order_details['gc_price'];
		$payment_currency = $order_details['payment_currency'];
		
		$process_fee->callback_process($custom, $fee_table, $active_pg, $payment_gross, $txn_id, $payment_currency);
		$db->query("DELETE FROM " . DB_PREFIX . "gc_transactions WHERE google_order_number='" . $txn_id . "'");

		$Gresponse->SendAck();
		break;
	}
	case "chargeback-amount-notification": 
	{
		$Gresponse->SendAck();
		break;
	}
	case "refund-amount-notification": 
	{
		$Gresponse->SendAck();
		break;
	}
	case "risk-information-notification": 
	{
		$Gresponse->SendAck();
		break;
	}
	default:
		$Gresponse->SendBadRequestStatus("Invalid or not supported Message");
		break;
}


/* In case the XML API contains multiple open tags
with the same value, then invoke this function and
perform a foreach on the resultant array.
This takes care of cases when there is only one unique tag
or multiple tags.
Examples of this are "anonymous-address", "merchant-code-string"
from the merchant-calculations-callback API
*/
function get_arr_result($child_node) 
{
	$result = array();
	if(isset($child_node)) 
	{
		if(is_associative_array($child_node)) 
		{
			$result[] = $child_node;
		}
		else 
		{
			foreach($child_node as $curr_node)
			{
				$result[] = $curr_node;
			}
		}
	}
	return $result;
}

/* Returns true if a given variable represents an associative array */
function is_associative_array( $var ) 
{
	return is_array( $var ) && !is_numeric( implode( '', array_keys( $var ) ) );
}
?>