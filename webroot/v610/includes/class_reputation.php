<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class reputation extends item
{
	function rep_rate($rate)
	{
		(string) $display_output = null;

		if ($rate<=1) $display_output = '<img src="themes/' . $this->setts['default_theme'] .'/img/system/1stars.gif" border="0">';
		else if ($rate==2) $display_output =  '<img src="themes/' . $this->setts['default_theme'] .'/img/system/2stars.gif" border="0">';
		else if ($rate==3) $display_output =  '<img src="themes/' . $this->setts['default_theme'] .'/img/system/3stars.gif" border="0">';
		else if ($rate==4) $display_output =  '<img src="themes/' . $this->setts['default_theme'] .'/img/system/4stars.gif" border="0">';
		else if ($rate>=5) $display_output =  '<img src="themes/' . $this->setts['default_theme'] .'/img/system/5stars.gif" border="0">';

		return $display_output;
	}

	function save($variables_array, $user_id)
	{
		$variables_array = $this->rem_special_chars_array($variables_array);

		$reputation_id_array = @explode(',', $variables_array['reputation_ids']);
		
		foreach ($reputation_id_array as $reputation_id)
		{
			$this->query("UPDATE " . DB_PREFIX . "reputation SET reputation_content='" . $variables_array['reputation_content'] . "',
				reputation_rate='" . $variables_array['reputation_rate'] . "', reg_date='" . CURRENT_TIME . "',
				submitted=1 WHERE reputation_id='" . $reputation_id . "' AND from_id='" . $user_id . "'");
	
			$reputation_type = $this->get_sql_field("SELECT reputation_type FROM " . DB_PREFIX . "reputation WHERE 
				reputation_id='" . $reputation_id . "'", 'reputation_type');
	
			$reputation_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "reputation WHERE reputation_id='" . $reputation_id . "'");
			
			$page_handle = $this->cf_page_handle($reputation_details);
			$this->update_page_data($reputation_id, $page_handle, $variables_array);
		}
	}

	function calc_reputation($user_id, $reputation_type = null, $reverse_auction = false)
	{
		$output = array('percentage' => null, 'amount' => null);

		$addl_query = ($reputation_type) ? " AND reputation_type='" . $reputation_type . "'" : '';
		$addl_query .= ($reverse_auction) ? " AND reverse_id>0" : '';

		$rep_positive = $this->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND
			reputation_rate>3 " . $addl_query);

		$rep_negative = $this->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND
			reputation_rate<3 " . $addl_query);

		$output['amount'] = $rep_positive - $reg_negative;

		$rep_total_tmp = $rep_positive + $rep_negative;
		$rep_total_tmp = ($rep_total_tmp) ? $rep_total_tmp : 1;

		$output['percentage'] = number_format(($rep_positive * 100 / $rep_total_tmp),2) . '%';

		return $output;
	}

	function rep_table_small($user_id, $auction_id = 0)
	{
		(string) $display_output = null;

		$rep_output = $this->calc_reputation($user_id);

		$display_output = '<table width="100%" cellpadding="3" cellspacing="2" border="0" class="userrep"> '.
			'	<tr> '.
			'		<td nowrap class="c4"><b>' . MSG_REPUTATION_RATING . '</b></td> '.
			'		<td width="100%" class="c4">' . $rep_output['percentage'] . '</td> '.
			'	</tr> '.
			'	<tr class="c1 positive"> '.
			'		<td nowrap><img src="themes/' . $this->setts['default_theme'] .'/img/system/5stars.gif"></td> '.
			'		<td>' . $this->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_rate=5") . '</td> '.
			'	</tr> '.
			'	<tr class="c1 positive"> '.
			'		<td nowrap><img src="themes/' . $this->setts['default_theme'] .'/img/system/4stars.gif"></td> '.
			'		<td>' . $this->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_rate=4") . '</td> '.
         '	</tr> '.
			'	<tr class="c1 neutral"> '.
			'		<td nowrap><img src="themes/' . $this->setts['default_theme'] .'/img/system/3stars.gif"></td> '.
			'		<td>' . $this->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_rate=3") . '</td> '.
         '	</tr> '.
			'	<tr class="c1 negative"> '.
			'		<td nowrap><img src="themes/' . $this->setts['default_theme'] .'/img/system/2stars.gif"></td> '.
			'		<td>' . $this->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_rate=2") . '</td> '.
         '	</tr> '.
			'	<tr class="c1 negative"> '.
			'		<td nowrap><img src="themes/' . $this->setts['default_theme'] .'/img/system/1stars.gif"></td> '.
			'		<td>' . $this->count_rows('reputation', "WHERE user_id='" . $user_id . "' AND submitted=1 AND reputation_rate=1") . '</td> '.
         '	</tr> '.
			'	<tr> '.
			'		<td colspan="2" align="center" class="contentfont"> '.
			'			<a href="' . process_link('user_reputation', array('user_id' => $user_id, 'auction_id' => $auction_id)) . '">' . MSG_VIEW_REPUTATION . '</a></td> '.
			'	</tr> '.
			'	<tr class="c5"> '.
			'		<td colspan="2"><img src="themes/' . $this->setts['default_theme'] .'/img/system/pixel.gif" width="1" height="1"></td> '.
			'	</tr> '.
			'</table> ';

		return $display_output;
	}
	
	function reputation_type($reputation_details)
	{
		$output = GMSG_NA;
		
		switch ($reputation_details['reputation_type'])
		{
			case 'sale':
				$output = ($reputation_details['reverse_id']) ? GMSG_REP_REVERSE_PROJECT_POSTER : GMSG_REP_AUCTION_SALE;
				break;
			case 'purchase':
				$output = ($reputation_details['reverse_id']) ? GMSG_REP_REVERSE_PROJECT_PROVIDER : GMSG_REP_AUCTION_PURCHASE;
				break;
		}
		
		return $output;
	}
	
	function cf_page_handle($reputation_details)
	{
		switch ($reputation_details['reputation_type'])
		{
			case 'sale':
				$output = ($reputation_details['reverse_id']) ? 'reputation_poster' : 'reputation_sale';
				break;
			case 'purchase':
				$output = ($reputation_details['reverse_id']) ? 'reputation_provider' : 'reputation_purchase';
				break;
		}
		
		return $output;		
	}
}

?>