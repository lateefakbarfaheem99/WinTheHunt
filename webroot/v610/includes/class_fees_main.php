<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class fees_main extends voucher
{

	var $vars = array();
	var $display_free = false;

	## assign variables that will be used in the class.
	function set($name, $value)
	{
		$this->vars[$name] = $value;
	}

	function display_amount ($amount, $currency = null, $zero = false)
	{
		(string) $display_output = null;

		if ($amount == 99999999999) 
		{
			$display_output = GMSG_ABOVE;			
		}
		else 
		{
			$fee_amount = $amount;
	
			$currency = ($currency) ? $currency : $this->setts['currency'];
	
			$currency_symbol = $this->get_sql_field("SELECT currency_symbol FROM " . DB_PREFIX . "currencies WHERE symbol='" . $currency . "'", 'currency_symbol');
			
			$currency = (!empty($currency_symbol)) ? $this->add_special_chars($currency_symbol) : $currency;
			$spacing = (!empty($currency_symbol)) ? '' : ' ';
			
			$amount = ($this->setts['amount_format'] == 1) ? number_format($amount, $this->setts['amount_digits'], '.', ',') : number_format($amount, $this->setts['amount_digits'], ',', '.');
			$display_output = ($this->setts['currency_position'] == 1) ?  ($currency . $spacing . $amount) : ($amount . $spacing . $currency);
	
			if ($fee_amount == 0)
			{
				$display_output = ($zero) ? $display_output : (($this->setts['display_free_fees'] && $this->display_free) ? GMSG_FREE : '-');
			}
			else if ($fee_amount < 0)
			{
				$display_output = MSG_ITEM_SWAPPED;
			}
		}
		
		return $display_output;
	}

	function user_payment_mode($user_id)
	{
		$tmp = $this->get_sql_field("SELECT payment_mode FROM " . DB_PREFIX . "users WHERE user_id=" . intval($user_id), "payment_mode");

		if ($this->setts['account_mode_personal'] == 1)
		{
			$payment_mode = ($tmp) ? $tmp : 1;
		}
		else
		{
			$payment_mode = $this->setts['account_mode'];
		}

		return $payment_mode;
	}

	function budget_output($budget_id, $budget_details = null, $currency = null)
	{		
		if (empty($budget_details))
		{
			$budget_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "reverse_budgets 
				WHERE id='" . intval($budget_id) . "'");
		}
		
		$currency = ($currency) ? $currency : $this->setts['currency'];
		
		if ($budget_details['value_from'] > 0 || $budget_details['value_to'] > 0)
		{
			$budget_from = $this->display_amount($budget_details['value_from'], $currency);
			$budget_to = $this->display_amount($budget_details['value_to'], $currency);
			
			if ($budget_details['value_from'] > 0)
			{
				if ($budget_details['value_to'] > 0)
				{
					$output = GMSG_BETWEEN . ' ' . $budget_from . ' ' . GMSG_AND . ' ' . $budget_to;
				}
				else 
				{
					$output = GMSG_MORE_THAN . ' ' . $budget_from;
				}
			}
			else 
			{
				$output = GMSG_LESS_THAN . ' ' . $budget_to;
			}
		}
		else 
		{
			$output = GMSG_NA;
		}
		
		return $output;
	}
		
}

?>