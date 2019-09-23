<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class tax extends fees_main
{
	var $selected_cid = null; // selected country/state ids, used for the shipping calculator

	function round_number($number, $round = 2)
	{
		// we will multiply by 10^$round, then get the floor value of that amount then divide by 10^round.
		## -> if it does problems, switch back to floor()
		$temp_value = $number * pow(10, $round);
		$temp_value = (!strpos($temp_value, '.')) ? $temp_value : floor($temp_value);
		$number = $temp_value / pow(10, $round);

		return $number;
	}

	function display_countries($countries_id)
	{
		(string) $display_output = null;
		(array) $countries_array = null;

		if ($countries_id)
		{
			$sql_select_countries = $this->query_silent("SELECT name FROM " . DB_PREFIX . "countries WHERE
				id IN (" . $countries_id . ")");
	
			if ($sql_select_countries)
			{
				while ($country_details = $this->fetch_array($sql_select_countries))
				{
					$countries_array[] = $country_details['name'];
				}
			}
		}

		$display_output = $this->implode_array($countries_array, ', ');

		return $display_output;
	}

	function show_country($country_name, $state_name)
	{
		(string)	$display_output = null;

		$display_output = ($state_name) ? $country_name . ' - ' . $state_name : $country_name;

		return $display_output;
	}

	function countries_dropdown($select_name, $selected_value, $form_refresh = null, $form_refresh_type = 'register', $add_null_field = false, $null_field_caption = null, $user_id = 0, $select_class = null)
	{
		(string) $display_output = null;

		$form_refresh_output = ($form_refresh_type != 'shipping_calculator') ? 'onChange = "state_box(this, ' . $user_id . ')"' : 'onChange = "javascript:shipping_calculator();"';

		$sql_select_countries = $this->query("SELECT c.id AS id, c.name FROM " . DB_PREFIX . "countries c WHERE c.parent_id=0 ". 
			((!empty($this->selected_cid)) ? " 
			AND c.id IN (" . $this->selected_cid . ") 
			UNION 
			SELECT c.parent_id AS id, cc.name FROM " . DB_PREFIX . "countries c 
			LEFT JOIN " . DB_PREFIX . "countries cc ON cc.id=c.parent_id 
			WHERE c.id IN (" . $this->selected_cid . ") AND c.parent_id!=0 GROUP BY c.parent_id" : ''));

		$display_output = '<select name="' . $select_name . '" id="' . $select_name . '" ' . (($form_refresh) ? $form_refresh_output : '') . ' ' . ((!empty($select_class)) ? 'class="' . $select_class . '"' : '') . '> ';

		if ($add_null_field)
		{
			$null_field_caption = (!empty($null_field_caption)) ? $null_field_caption : GMSG_ALL_COUNTRIES;
			
			$display_output .= '<option value="" selected>' . $null_field_caption . '</option>';
		}
		while ($country_details = $this->fetch_array($sql_select_countries))
		{
			$display_output .= '<option value="' . $country_details['id'] . '" ' . (($selected_value == $country_details['id']) ? 'selected' : ''). '>' . $country_details['name'] . '</option>';
		}

		$display_output .= '</select>';

		return $display_output;
	}

	function is_states($country_id)
	{
		$is_states = $this->count_rows('countries', "WHERE 
			parent_id='" . intval($country_id) . "' AND parent_id!=0 
			" . ((!empty($this->selected_cid)) ? " AND id IN (" . $this->selected_cid . ")" : ''));
			
		return ($is_states) ? true : false;
		
	}
	function states_box($box_name, $selected_value, $country_value = null, $form_refresh = null, $in_ajax = false)
	{
		(string) $display_output = null;

		if ($country_value)
		{
			$country_id = $country_value;
		}
		else
		{
			$country_id = $this->get_sql_field("SELECT id FROM " . DB_PREFIX . "countries WHERE	parent_id=0 
				ORDER BY country_order ASC, name ASC LIMIT 0,1", 'id');
		}

		$is_states = $this->is_states($country_id);

		if ($is_states)
		{
			$sql_select_states = $this->query("SELECT s.id, s.name FROM " . DB_PREFIX . "countries s WHERE
				s.parent_id='" . $country_value . "' 
				" . ((!empty($this->selected_cid)) ? "AND s.id IN (" . $this->selected_cid . ")" : '') . "
				ORDER BY s.country_order ASC, s.name ASC");

			if ($form_refresh)
			{
				$form_refresh = ($form_refresh == 'shipping_calculator_form') ? 'onChange = "javascript:shipping_calculator();"' : 'onChange = "submit_form(' . $form_refresh . ', \'\')"';
			}
			
			$display_output = '<select name="' . $box_name . '" id="' . $box_name . '" ' . $form_refresh . '> ';
			$display_output .= '<option value="" selected>' . MSG_SELECT_STATE . '</option> ';

			while ($state_details = $this->fetch_array($sql_select_states))
			{
				$display_output .= '<option value="' . $state_details['id'] . '" ' . (($selected_value == $state_details['id']) ? 'selected' : ''). '>' . $state_details['name'] . '</option>';
			}

			$display_output .= '</select>';

		}
		else
		{
			$selected_value = (is_numeric($selected_value)) ? '' : $selected_value;
			$display_output = '<input name="' . $box_name . '" type="text" id="' . $box_name . '" value="' . $selected_value . '" size="25" />';
		}
		
		$display_output = ($in_ajax) ? $display_output : '<div id="stateBox">' . $display_output . '</div>';

		return $display_output;
	}

	function apply_tax($fee_amount, $currency, $user_id, $enable_tax)
	{
		(array) $countries_array = null;
		(array) $output = null;

		$output['amount'] = $fee_amount;
		$output['apply_tax'] = false;
		$output['tax_rate'] = 0;

		if ($enable_tax)
		{
			$user_row = $this->get_sql_row("SELECT tax_exempted, country, state FROM " . DB_PREFIX . "users WHERE
				user_id=" . intval($user_id));

			if (!$user_row['tax_exempted'])
			{
				$tax_row = $this->get_sql_row("SELECT tax_name, amount, countries_id FROM " . DB_PREFIX . "tax_settings WHERE
					site_tax=1");

				$countries_array = @explode(',', $tax_row['countries_id']);

				if (in_array($user_row['country'], $countries_array) || in_array($user_row['state'], $countries_array))
				{
					$output['apply_tax'] = true;
					$output['tax_rate'] = $tax_row['amount'];
					$output['amount'] = $this->round_number($fee_amount + ($fee_amount * $tax_row['amount'] / 100));

					$output['tax_details'] = GMSG_THE_PRICE_INCLUDES . ' ' . $tax_row['amount'] . '% ' . $tax_row['tax_name'] . ' ' .
						'( ' . $this->display_amount($fee_amount, $currency) . ' + ' . $tax_row['amount'] . '% ' . $tax_row['tax_name'] . ' )';
				}
			}
		}
		$output['amount'] = $this->round_number($output['amount']); ## round to two decimals

		return $output;
	}

	function tax_amount($fee_amount, $currency, $user_id, $enable_tax)
	{
		(array) $countries_array = null;
		(array) $output = null;

		$output['amount'] = 0;
		$output['amount_no_tax'] = $fee_amount;
		$output['tax_rate'] = 0;

		if ($enable_tax)
		{
			$user_row = $this->get_sql_row("SELECT tax_exempted, country, state FROM " . DB_PREFIX . "users WHERE
				user_id=" . intval($user_id));

			if (!$user_row['tax_exempted'])
			{
				$tax_row = $this->get_sql_row("SELECT tax_name, amount, countries_id FROM " . DB_PREFIX . "tax_settings WHERE
					site_tax=1");

				$countries_array = @explode(',', $tax_row['countries_id']);

				if (in_array($user_row['country'], $countries_array) || in_array($user_row['state'], $countries_array))
				{
					$output['apply_tax'] = true;
					$output['tax_rate'] = $tax_row['amount'];
					$output['amount_no_tax'] = $this->round_number($fee_amount / (1 + $output['tax_rate'] / 100));
					$output['amount'] = $fee_amount - $output['amount_no_tax'];
				}
			}
		}
		
		return $output;		
	}
	
	function tax_user_type($tax_account_type, $tax_reg_number)
	{
		(string) $tax_user_type = null;
		if ($tax_account_type == 0 && empty($tax_reg_number)) /* individual and no tax number */
			$tax_user_type = 'd';
		else if ($tax_account_type == 0 && !empty($tax_reg_number)) /* individual with a tax number */
			$tax_user_type = 'c';
		else if ($tax_account_type == 1 && empty($tax_reg_number)) /* business and no tax number */
			$tax_user_type = 'b';
		else if ($tax_account_type == 1 && !empty($tax_reg_number)) /* business with a tax number */
			$tax_user_type = 'a';

		return $tax_user_type;
	}

	function can_add_tax($user_id, $enable_tax)
	{
		(array) $result = null;

		$user_row = $this->get_sql_row("SELECT tax_account_type, tax_reg_number, country, state, seller_tax_amount FROM
			" . DB_PREFIX . "users WHERE user_id=" . intval($user_id));
		
		$country_iso = get_country_iso($user_row['country']);
			
		if ($country_iso == 'US' && $user_row['seller_tax_amount'] > 0) /* override auction tax */
		{
			$result['tax_id'] = 0;
			$result['tax_reg_number'] = $user_row['tax_reg_number'];
			$result['can_add_tax'] = true;
			$result['override_tax'] = true;
			$result['amount'] = $user_row['seller_tax_amount'];
			$result['state'] = $user_row['state'];
		}
		else if ($enable_tax)
		{
			$tax_user_type = $this->tax_user_type($user_row['tax_account_type'], $user_row['tax_reg_number']);

			$can_add_tax = $this->get_sql_field("SELECT tax_id FROM
				" . DB_PREFIX . "tax_settings WHERE
				(LOCATE(',".$user_row['country'].",', CONCAT(',',seller_countries_id,','))>0 OR
				LOCATE(',".$user_row['state'].",', CONCAT(',',seller_countries_id,','))>0) AND
				LOCATE(',".$tax_user_type.",', CONCAT(',',tax_user_types,','))>0", 'tax_id');

			$result['tax_id'] = intval($can_add_tax);
			$result['tax_reg_number'] = $user_row['tax_reg_number'];
			$result['can_add_tax'] = (intval($can_add_tax)>0) ? true : false;
		}

		return $result;
	}

	/**
	 * this function will be used on the ad_details page to display to users from which
	 * locations tax will be charged for a particular item
	 *
	 * if buyer_id is specified, it will check if tax will apply for him
	 */

	function auction_tax($seller_id, $enable_tax, $buyer_id=0)
	{
		$output = array('display' => GMSG_NO_TAX_APPLIED, 'display_buyer' => null,
			'display_buyer_purchase' => null, 'apply' => false, 'amount' => 0, 'tax_name' => null, 'tax_reg_number' => null, 
			'display_short' => GMSG_NA);

		$can_add_tax = $this->can_add_tax($seller_id, $enable_tax);

		if ($can_add_tax['can_add_tax'])
		{
			$output['tax_reg_number'] = $can_add_tax['tax_reg_number'];

			if ($can_add_tax['override_tax'])
			{
				$tax_row = array(
					'tax_name' => MSG_STATE_TAX,
					'amount' => $can_add_tax['amount'],
					'countries_id' => $can_add_tax['state']
				);
			}
			else 
			{
				$tax_row = $this->get_sql_row("SELECT tax_name, amount, countries_id FROM
					" . DB_PREFIX . "tax_settings WHERE tax_id=" . intval($can_add_tax['tax_id']));
			}

			$output['display_short'] = $tax_row['amount'] . '%';
			$output['display'] = '<strong>' . $tax_row['amount'] . '% ' . $tax_row['tax_name'] . ' ' . GMSG_APPLIED_TO_USRS_FROM . ':</strong><br>' .
				$this->display_countries($tax_row['countries_id']);

			if ($buyer_id)
			{
				$buyer_row = $this->get_sql_row("SELECT tax_exempted, country, state FROM " . DB_PREFIX . "users WHERE
					user_id=" . intval($buyer_id));

				if (!$buyer_row['tax_exempted'])
				{
					$countries_array = @explode(',', $tax_row['countries_id']);

					if (in_array($buyer_row['country'], $countries_array) || in_array($buyer_row['state'], $countries_array))
					{
						$output['apply'] = true;
						$output['tax_name'] = $tax_row['tax_name'];
						$output['amount'] = $tax_row['amount'];

						if ($seller_id != $buyer_id)
						{
							$output['display_buyer'] = MSG_USER_TAX_LIABLE . ' ' . $tax_row['tax_name'] . '.';
						}

						$output['display_short'] = '+' . $tax_row['amount'] . '% ' . $tax_row['tax_name'];					
						$output['display_buyer_purchase'] = $tax_row['amount'] . '% ' . $tax_row['tax_name'] . ' ' .
							MSG_TAX_WINNING_BID_EXPL;
					}
				}
				else
				{
					$output['display_buyer'] = MSG_USER_TAX_EXEMPTED;
				}
			}
		}

		return $output;

	}
	
	function convert_tax()
	{
		$output = array('invoices' => 0, 'winners' => 0, 'result' => false);
		
		$output['invoices'] = $this->count_rows('invoices', "WHERE tax_calculated=0");
		$output['winners'] = $this->count_rows('winners', "WHERE tax_calculated=0 AND invoice_sent=1");
		
		$output['result'] = ($output['invoices'] || $output['winners']) ? true : false;
		
		return $output;	
	}
	
	/**
	 * this function will be used to hardcode the tax in the invoices and winners table.
	 * 50 rows will be done at a time, with the invoices table taking precedence.
	 */
	function hardcode_tax()
	{
		$output = true;

		$convert_tax = $this->convert_tax();
		
		if ($convert_tax['invoices'])
		{
			## do the stuff
			$sql_select_invoices = $this->query("SELECT * FROM " . DB_PREFIX . "invoices WHERE tax_calculated=0 LIMIT 100");

			while ($invoice_details = $this->fetch_array($sql_select_invoices))
			{
				$tax_settings = $this->tax_amount($invoice_details['amount'], $this->setts['currency'], $invoice_details['user_id'], $this->setts['enable_tax']);

				$this->query("UPDATE " . DB_PREFIX . "invoices SET
					tax_amount='" . $tax_settings['amount'] . "', 
					tax_rate='" . $tax_settings['tax_rate'] . "', 
					tax_calculated='1' WHERE invoice_id='" . $invoice_details['invoice_id'] . "'");
			}
		}
		else 
		{
			if ($convert_tax['winners'])
			{
				$sql_select_winners = $this->query("SELECT w.*, a.name, a.apply_tax, a.currency FROM " . DB_PREFIX . "winners w
					LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id WHERE 
					w.tax_calculated='0' AND w.invoice_sent='1' LIMIT 10");
				
				while ($invoice_details = $this->fetch_array($sql_select_winners))
				{
					$seller_details = $this->get_sql_row("SELECT u.name, u.address, u.city, u.zip_code,
						c.name AS country_name, s.name AS state_name, u.state FROM " . DB_PREFIX ."users u
						LEFT JOIN " . DB_PREFIX . "countries s ON u.state=s.id
						LEFT JOIN " . DB_PREFIX . "countries c ON u.country=c.id WHERE u.user_id=" . $invoice_details['seller_id']);
	
					$buyer_details = $this->get_sql_row("SELECT u.name, u.address, u.city, u.zip_code,
						c.name AS country_name, s.name AS state_name, u.state FROM " . DB_PREFIX ."users u
						LEFT JOIN " . DB_PREFIX . "countries s ON u.state=s.id
						LEFT JOIN " . DB_PREFIX . "countries c ON u.country=c.id WHERE u.user_id=" . $invoice_details['buyer_id']);
	
					$auction_tax = $this->auction_tax($invoice_details['seller_id'], $this->setts['enable_tax'], $invoice_details['buyer_id']);
					$invoice_details['apply_tax'] = ($this->setts['enable_tax']) ? $invoice_details['apply_tax'] : 0;
						
					$tax_details = array(
						'apply' => $invoice_details['apply_tax'],
						'tax_rate' => (($invoice_details['apply_tax']) ? $auction_tax['amount'] . '%' : '-')
					);
	
					$product_no_tax = $invoice_details['bid_amount'] * $invoice_details['quantity_offered'];
					$product_postage = ($invoice_details['postage_included']) ? $invoice_details['postage_amount'] : 0;
					$product_insurance = ($invoice_details['insurance_included']) ? $invoice_details['insurance_amount'] : 0;
						
					//$product_no_tax_pi = $product_no_tax + $product_postage + $product_insurance;
						
					$product_tax = ($invoice_details['apply_tax']) ? $product_no_tax * $auction_tax['amount'] / 100 : 0;
					
					## postage_amount and insurance_amount are specific for each invoice (not for each auction)!
					$this->query("UPDATE " . DB_PREFIX . "winners SET tax_amount='" . $product_tax . "', 
						tax_rate='" . $tax_details['tax_rate'] . "', tax_calculated='1' WHERE 
						winner_id='" . $invoice_details['winner_id'] . "'");					
				}
			}
			else 
			{
				$output = false;
			}
		}
		
		return $output;
	}
}

?>