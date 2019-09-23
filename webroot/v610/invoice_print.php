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
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_user.php');
include_once ('includes/class_item.php');

if (!$session->value('user_id') && $session->value('adminarea') != 'Active')
{
	header_redirect('login.php');
}
else
{
	$display_invoice = false;

	$invoices_array = array('product_invoice', 'auction_invoice', 'wanted_ad_invoice', 'fee_invoice');

	$invoice_type = (in_array($_REQUEST['invoice_type'], $invoices_array)) ? $_REQUEST['invoice_type'] : '';
	$template->set('invoice_type', $invoice_type);

	$item = new item();
	$item->setts = &$setts;

	switch ($_REQUEST['invoice_type'])
	{
		case 'product_invoice':
			$invoice_name = GMSG_RECEIPT;
			
			$sql_select_products = $db->query("SELECT w.*, a.name, a.apply_tax, a.currency, a.direct_payment, a.payment_methods FROM " . DB_PREFIX . "winners w
				LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id WHERE w.invoice_id='" . $_REQUEST['invoice_id'] . "' AND
				(w.seller_id='" . $session->value('user_id') . "' OR w.buyer_id='" . $session->value('user_id') . "')");

			$single_settings = false;
			(string) $invoice_content = null;
			
			$direct_payment_methods = array();
			$offline_payment_methods = array();
			
			$is_invoice = $db->num_rows($sql_select_products);
			
			if ($is_invoice)
			{				
				$display_invoice = true;
				
				$total_postage = null;
				$total_insurance = null;
				while ($invoice_details = $db->fetch_array($sql_select_products))
				{									
					if (!$single_settings) /* some page settings will only be taken once */
					{
						$single_settings = true;
	
						$currency = $invoice_details['currency'];
						
						$template->set('invoice_header', '<img src="images/probidlogo.gif" border="0">');
						$template->set('invoice_comments', $invoice_details['invoice_comments']);
	
						$user = new user();
						$tax = new tax();
	
						$template->set('invoice_date', show_date($invoice_details['purchase_date'], false));
						$template->set('invoice_number', 'PR-' . $_REQUEST['invoice_id']);
	
						$seller_details = $db->get_sql_row("SELECT u.user_id, u.name, u.address, u.city, u.zip_code, u.tax_account_type, u.tax_company_name, u.username,
							c.name AS country_name, s.name AS state_name, u.state FROM " . DB_PREFIX ."users u
							LEFT JOIN " . DB_PREFIX . "countries s ON u.state=s.id
							LEFT JOIN " . DB_PREFIX . "countries c ON u.country=c.id WHERE u.user_id=" . $invoice_details['seller_id']);
		
						$seller_full_name = (($seller_details['tax_account_type'] && !empty($seller_details['tax_company_name'])) ? '<b>' . $seller_details['tax_company_name'] . '</b><br>' : '') . $seller_details['name']; 
						
						$template->set('seller_full_name', $seller_full_name);
						$template->set('seller_full_address',  $user->full_address($seller_details) . '<br><b>' . MSG_USERNAME . '</b>: ' . $seller_details['username']);
		
						$buyer_details = $db->get_sql_row("SELECT u.name, u.address, u.city, u.zip_code, u.tax_account_type, u.tax_company_name, u.username, 
							c.name AS country_name, s.name AS state_name, u.state FROM " . DB_PREFIX ."users u
							LEFT JOIN " . DB_PREFIX . "countries s ON u.state=s.id
							LEFT JOIN " . DB_PREFIX . "countries c ON u.country=c.id WHERE u.user_id=" . $invoice_details['buyer_id']);
		
						$buyer_full_name = (($buyer_details['tax_account_type'] && !empty($buyer_details['tax_company_name'])) ? '<b>' . $buyer_details['tax_company_name'] . '</b><br>' : '') . $buyer_details['name']; 
						
						$template->set('buyer_full_name', $buyer_full_name);
						$template->set('buyer_full_address',  $user->full_address($buyer_details) . '<br><b>' . MSG_USERNAME . '</b>: ' . $buyer_details['username']);								
						
						$direct_payment_methods = explode(',', $invoice_details['direct_payment']);
						$offline_payment_methods = explode(',', $invoice_details['payment_methods']);
					}
	
					$auction_tax = $tax->auction_tax($invoice_details['seller_id'], $setts['enable_tax'], $invoice_details['buyer_id']);
					$invoice_details['apply_tax'] = ($setts['enable_tax']) ? $invoice_details['apply_tax'] : 0;
					
					$tax_rate = ($invoice_details['tax_calculated']) ? $invoice_details['tax_rate'] : (($invoice_details['apply_tax']) ? $auction_tax['amount'] : 0);
					$tax_details = array(
						'apply' => $invoice_details['apply_tax'],
						'tax_reg_number' => (($invoice_details['apply_tax']) ? $auction_tax['tax_reg_number'] : '-'),
						'tax_rate' => (($tax_rate > 0) ? $tax_rate . '%' : '-')
					);
	
					$template->set('tax_details', $tax_details);
	
					$product_no_tax = $invoice_details['bid_amount'] * $invoice_details['quantity_offered'];
					
					$postage_amount = ($invoice_details['apply_tax']) ? ($invoice_details['postage_amount'] + ($invoice_details['postage_amount'] * $auction_tax['amount'] / 100)) : $invoice_details['postage_amount'];
					$insurance_amount = ($invoice_details['apply_tax']) ? ($invoice_details['insurance_amount'] + ($invoice_details['insurance_amount'] * $auction_tax['amount'] / 100)) : $invoice_details['insurance_amount'];
					
					$total_postage += ($invoice_details['postage_included']) ? (($invoice_details['pc_postage_type'] == 'item') ? ($postage_amount + $total_postage) : $postage_amount) : 0;
					$total_insurance += ($invoice_details['insurance_included']) ? $insurance_amount : 0;
					
					$total_no_tax += $product_no_tax;
					
					if ($invoice_details['tax_calculated'])
					{
						$product_tax = $invoice_details['tax_amount'];
					}
					else 
					{
						$product_tax = ($invoice_details['apply_tax']) ? $product_no_tax * $auction_tax['amount'] / 100 : 0;
					}
										
					$total_tax += $product_tax;
	
					$product_total = $product_no_tax + $product_tax;
					
					$total_amount += $product_total;				
					
					$invoice_content .= '<tr class="c1"> '.
	               '	<td align="center">' . $invoice_details['quantity_offered'] . '</td> '.
	               '	<td>[ ' . MSG_ID . ': ' . $invoice_details['auction_id'] . ' ] ' . $invoice_details['name'] . '</td> '.
	               '	<td align="center">' . $fees->display_amount($product_no_tax, $invoice_details['currency']) . '</td> '.
	               '	<td align="center">' . $tax_details['tax_rate'] . '</td> '.
	               '	<td align="center">' . $fees->display_amount($product_tax, $invoice_details['currency']) . '</td> '.
	               '	<td align="center">' . $fees->display_amount($product_total, $invoice_details['currency']) . '</td> '.
	            	'</tr> ';
	            	
	            $dp_methods = explode(',', $invoice_details['direct_payment']);
	            $direct_payment_methods = array_intersect($direct_payment_methods, $dp_methods);
	            $op_methods = explode(',', $invoice_details['payment_methods']);
	            $offline_payment_methods = array_intersect($offline_payment_methods, $op_methods);
				}				
			
				if ($display_invoice)
				{										
					$invoice_details['currency'] = $currency;
					
					$total_amount += $total_postage + $total_insurance;
					
	            $template->set('invoice_content', $invoice_content);
	            $template->set('total_postage', $fees->display_amount($total_postage, $invoice_details['currency']));
	            $template->set('total_insurance', $fees->display_amount($total_insurance, $invoice_details['currency']));
	            $template->set('total_no_tax', $fees->display_amount($total_no_tax, $invoice_details['currency']));
	            $template->set('total_tax', $fees->display_amount($total_tax, $invoice_details['currency']));
	            $template->set('total_amount', $fees->display_amount($total_amount, $invoice_details['currency']));	
	            
	            if (count($direct_payment_methods))
	            {
	            	$direct_payment_methods = $db->implode_array($direct_payment_methods);
	            	$direct_payment_methods = $item->select_direct_payment($direct_payment_methods, $seller_details['user_id'], true, true);
	            }

	            if (count($offline_payment_methods))
	            {
	            	$offline_payment_methods = $db->implode_array($offline_payment_methods);
	            	$offline_payment_methods = $item->select_offline_payment($offline_payment_methods, true, true);
	            }
	            
	            $payment_methods_accepted = array_merge((array)$direct_payment_methods, (array)$offline_payment_methods);
	            $template->set('payment_methods_accepted', $db->implode_array($payment_methods_accepted, ', ', true, GMSG_NA));
				}
			}

			break;
		case 'fee_invoice':
			$invoice_name = GMSG_RECEIPT;
			
			$addl_invoice_query = ($session->value('adminarea') == 'Active') ? '' : " AND user_id='" . $session->value('user_id') . "'";
			$invoice_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "invoices WHERE
				 invoice_id='" . $_REQUEST['invoice_id'] . "' AND live_fee=1 " . $addl_invoice_query);

			if ($item->count_contents($invoice_details))
			{
				$display_invoice = true;

				$template->set('invoice_header', $setts['invoice_header']);
				$template->set('invoice_comments', $setts['invoice_comments']);
				$template->set('invoice_footer', $setts['invoice_footer']);

				$buyer_details = $db->get_sql_row("SELECT u.name, u.address, u.city, u.zip_code, u.tax_account_type, u.tax_company_name, 
					c.name AS country_name, s.name AS state_name, u.state FROM " . DB_PREFIX ."users u
					LEFT JOIN " . DB_PREFIX . "countries s ON u.state=s.id
					LEFT JOIN " . DB_PREFIX . "countries c ON u.country=c.id WHERE u.user_id=" . $invoice_details['user_id']);

				$user = new user();

				$tax = new tax();
				$auction_tax = $tax->apply_tax(1, $setts['currency'], $invoice_details['user_id'], $setts['enable_tax']);

				$tax_rate = ($invoice_details['tax_calculated']) ? $invoice_details['tax_rate'] : (($auction_tax['apply_tax']) ? $auction_tax['tax_rate'] : 0);
				$tax_details = array(
					'apply' => $auction_tax['apply_tax'],
					'tax_reg_number' => (($auction_tax['apply_tax']) ? $setts['vat_number'] : '-'),
					'tax_rate' => (($tax_rate > 0) ? $tax_rate . '%' : '-')
				);

				$template->set('tax_details', $tax_details);

				$template->set('invoice_date', show_date($invoice_details['invoice_date'], false));
				$template->set('invoice_number', (($invoice_details['item_id'] > 0) ? 'LF-' : (($invoice_details['wanted_ad_id'] > 0) ? 'LWF-' : 'SF-')) . $_REQUEST['invoice_id']);

				$buyer_full_name = (($buyer_details['tax_account_type'] && !empty($buyer_details['tax_company_name'])) ? '<b>' . $buyer_details['tax_company_name'] . '</b><br>' : '') . $buyer_details['name']; 
				
				$template->set('buyer_full_name', $buyer_full_name);
				$template->set('buyer_full_address',  $user->full_address($buyer_details));

				$fee_total = $invoice_details['amount'];
				$fee_tax = '-';
				$fee_no_tax = $fee_total;

				if ($invoice_details['tax_calculated']) /* new version - tax is hardcoded in the invoice line */
				{
					$fee_no_tax = $fee_total - $invoice_details['tax_amount'];
					$fee_tax = $invoice_details['tax_amount'];
				}
				else if ($auction_tax['apply_tax'])
				{
					$fee_no_tax = ($auction_tax['apply_tax']) ? $tax->round_number($fee_total / (1 + $auction_tax['tax_rate'] / 100)) : 0;
					$fee_tax = $fee_total - $fee_no_tax;
				}## PHP Pro Bid v6.00 now create the invoice content
				$invoice_content = '<tr class="c1"> '.
               '	<td align="center">1</td> '.
               '	<td>' . $invoice_details['name'] . '</td> '.
               '	<td align="center">' . $fees->display_amount($fee_no_tax, $setts['currency']) . '</td> '.
               '	<td align="center">' . $tax_details['tax_rate'] . '</td> '.
               '	<td align="center">' . $fees->display_amount($fee_tax, $setts['currency']) . '</td> '.
               '	<td align="center">' . $fees->display_amount($fee_total, $setts['currency']) . '</td> '.
            	'</tr> ';

            $template->set('invoice_content', $invoice_content);
            $template->set('total_no_tax', $fees->display_amount($fee_no_tax, $setts['currency']));
            $template->set('total_tax', $fees->display_amount($fee_tax, $setts['currency']));
            $template->set('total_amount', $fees->display_amount($fee_total, $setts['currency']));
			}
			break;
		case 'auction_invoice':
			$invoice_name = GMSG_DEBIT;
			
			$addl_invoice_query = ($session->value('adminarea') == 'Active') ? '' : " AND user_id='" . $session->value('user_id') . "'";
			$sql_select_invoices = $db->query("SELECT * FROM " . DB_PREFIX . "invoices WHERE
				" . (($_REQUEST['auction_id'] > 0) ? 'item_id' : (($_REQUEST['wanted_ad_id'] > 0) ? 'wanted_ad_id' : 'reverse_id')) . "='" . 
				(($_REQUEST['auction_id'] > 0) ? intval($_REQUEST['auction_id']) : (($_REQUEST['wanted_ad_id'] > 0) ? intval($_REQUEST['wanted_ad_id']) : intval($_REQUEST['reverse_id']))) . "' AND
				live_fee=0 " . $addl_invoice_query);

			$is_invoice = $db->num_rows($sql_select_invoices);

			if ($is_invoice)
			{
				$display_invoice = true;

				$template->set('invoice_header', $setts['invoice_header']);
				$template->set('invoice_comments', $setts['invoice_comments']);
				$template->set('invoice_footer', $setts['invoice_footer']);

				(string) $invoice_content = null;

				$single_settings = false;
				
				while ($invoice_details = $db->fetch_array($sql_select_invoices))
				{
					if (!$single_settings)
					{
						$single_settings = true;

						$buyer_details = $db->get_sql_row("SELECT u.name, u.address, u.city, u.zip_code, u.tax_account_type, u.tax_company_name, 
							c.name AS country_name, s.name AS state_name, u.state FROM " . DB_PREFIX ."users u
							LEFT JOIN " . DB_PREFIX . "countries s ON u.state=s.id
							LEFT JOIN " . DB_PREFIX . "countries c ON u.country=c.id WHERE u.user_id=" . $invoice_details['user_id']);
		
						$user = new user();
		
						$tax = new tax();
						$auction_tax = $tax->apply_tax(1, $setts['currency'], $invoice_details['user_id'], $setts['enable_tax']);
		
						$tax_rate = ($invoice_details['tax_calculated']) ? $invoice_details['tax_rate'] : (($auction_tax['apply_tax']) ? $auction_tax['tax_rate'] : 0);
						
						$tax_details = array(
							'apply' => $auction_tax['apply_tax'],
							'tax_reg_number' => (($auction_tax['apply_tax']) ? $setts['vat_number'] : '-'),
							'tax_rate' => (($tax_rate > 0) ? $tax_rate . '%' : '-')
						);
		
						$template->set('tax_details', $tax_details);
		
						$buyer_full_name = (($buyer_details['tax_account_type'] && !empty($buyer_details['tax_company_name'])) ? '<b>' . $buyer_details['tax_company_name'] . '</b><br>' : '') . $buyer_details['name']; 
						
						$template->set('buyer_full_name', $buyer_full_name);
						$template->set('buyer_full_address',  $user->full_address($buyer_details));
		
						$template->set('invoice_number', (($invoice_details['item_id'] > 0) ? 'AF-' : (($invoice_details['wanted_ad_id'] > 0) ? 'WF-' : 'RF-')) . (($invoice_details['item_id'] > 0) ? $invoice_details['item_id'] : (($invoice_details['wanted_ad_id'] > 0) ? $invoice_details['wanted_ad_id'] : $invoice_details['reverse_id'])));

						$invoice_date = $invoice_details['invoice_date'];
					}

					$fee_total = $invoice_details['amount'];
					$fee_tax = '-';
					$fee_no_tax = $fee_total;

					$total_amount += $fee_total;

					if ($invoice_details['tax_calculated']) /* new version - tax is hardcoded in the invoice line */
					{
						$fee_no_tax = $fee_total - $invoice_details['tax_amount'];
						$fee_tax = $invoice_details['tax_amount'];
						
						$total_tax += $fee_tax;
						$total_no_tax += $fee_no_tax;
					}
					else if ($auction_tax['apply_tax'])
					{
						$fee_no_tax = ($auction_tax['apply_tax']) ? $tax->round_number($fee_total / (1 + $auction_tax['tax_rate'] / 100)) : 0;
						$fee_tax = $fee_total - $fee_no_tax;

						$total_tax += $fee_tax;
						$total_no_tax += $fee_no_tax;
					}## PHP Pro Bid v6.00 now create the invoice content
					$invoice_content .= '<tr class="c1"> '.
	               '	<td align="center">1</td> '.
	               '	<td>' . $invoice_details['name'] . '</td> '.
	               '	<td align="center">' . $fees->display_amount($fee_no_tax, $setts['currency']) . '</td> '.
	               '	<td align="center">' . $tax_details['tax_rate'] . '</td> '.
	               '	<td align="center">' . $fees->display_amount($fee_tax, $setts['currency']) . '</td> '.
	               '	<td align="center">' . $fees->display_amount($fee_total, $setts['currency']) . '</td> '.
	            	'</tr> ';

				}

				$template->set('invoice_date', show_date($invoice_date, false));

            $template->set('invoice_content', $invoice_content);
            $template->set('total_no_tax', $fees->display_amount($total_no_tax, $setts['currency']));
            $template->set('total_tax', $fees->display_amount($total_tax, $setts['currency']));
            $template->set('total_amount', $fees->display_amount($total_amount, $setts['currency']));
			}
			break;
	}

	if ($display_invoice)
	{
		$template->set('invoice_name', $invoice_name);
		$template->set('invoice_type', $invoice_type);
		$template_output = $template->process('invoice_print.tpl.php');
	}

	echo $template_output;
}
?>