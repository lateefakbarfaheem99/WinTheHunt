<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class voucher extends database
{

	function voucher_settings ($variables_array)
	{
		(array) $output = null;

		//$output['assigned_users'] = $this->implode_array($variables_array['assigned_users']);

		$output['assigned_fees'] = ($variables_array['all_fees'] == 'all') ? 'all' : $this->implode_array($variables_array['assigned_fees']);

		$output['voucher_code'] = (!empty($variables_array['voucher_code'])) ? $variables_array['voucher_code'] : substr(md5(uniqid(rand(2, 999999999))),-12);

		$output['reg_date'] = ($variables_array['option'] == 'edit') ? $this->get_sql_field("SELECT regdate FROM " . DB_PREFIX . "vouchers WHERE voucher_id='".$variables_array['voucher_id']."'",'reg_date') : CURRENT_TIME;
		$output['exp_date'] = (!empty($variables_array['voucher_duration'])) ? ($output['reg_date'] + $variables_array['voucher_duration'] * 24 * 60 * 60) : 0;

		$output['voucher_reduction'] = ($variables_array['voucher_reduction']>100) ? 100 : $variables_array['voucher_reduction'];
		$output['voucher_reduction'] = ($output['voucher_reduction']<0) ? 0 : $output['voucher_reduction'];

		return $output;
	}

	function add_voucher($variables_array, $user_id = null)
	{
		$variables_array = $this->rem_special_chars_array($variables_array);

		$voucher_settings = $this->voucher_settings($variables_array);

		$voucher_type = ($user_id) ? 'seller_voucher' : $variables_array['voucher_type'];
		
		$sql_insert_voucher = $this->query("INSERT INTO " . DB_PREFIX . "vouchers
			(voucher_code, voucher_type, reg_date, exp_date, nb_uses, uses_left, voucher_reduction, assigned_users,
			assigned_fees, voucher_name, voucher_duration, user_id) VALUES
			('" . $voucher_settings['voucher_code'] . "', '" . $voucher_type . "',
			'" . $voucher_settings['reg_date'] . "', '" . $voucher_settings['exp_date'] . "',
			'" . $variables_array['nb_uses'] . "', '" . $variables_array['nb_uses'] . "',
			'" . $voucher_settings['voucher_reduction'] . "', '" . $voucher_settings['assigned_users'] . "',
			'" . $voucher_settings['assigned_fees'] . "', '" . $variables_array['voucher_name'] . "',
			'" . $variables_array['voucher_duration'] . "', '" . $user_id . "')");
	}

	function edit_voucher($variables_array, $user_id = null)
	{
		$variables_array = $this->rem_special_chars_array($variables_array);

		$voucher_settings = $this->voucher_settings($variables_array);

		$sql_update_voucher = $this->query("UPDATE " . DB_PREFIX . "vouchers SET
			voucher_code='" .$voucher_settings['voucher_code'] . "',
			exp_date='" . $voucher_settings['exp_date'] . "',
			nb_uses='" . $variables_array['nb_uses'] . "',
			uses_left='" . $variables_array['nb_uses'] . "',
			voucher_reduction='" . $voucher_settings['voucher_reduction'] . "',
			assigned_users='" . $voucher_settings['assigned_users'] . "',
			assigned_fees='" . $voucher_settings['assigned_fees'] . "',
			voucher_name='" . $variables_array['voucher_name'] . "',
			voucher_duration='" . $variables_array['voucher_duration'] . "' 
			WHERE voucher_id = '" . $variables_array['voucher_id'] . "'" . (($user_id) ? " AND user_id='" . $user_id . "'" : ''));
	}

	function delete_voucher($voucher_id, $user_id = null)
	{
		$sql_delete_voucher = $this->query("DELETE FROM " . DB_PREFIX . "vouchers WHERE voucher_id='" . $voucher_id . "' 
			" . (($user_id) ? " AND user_id='" . $user_id . "'" : ''));
	}

	function select_reduced_fees($variables_array)
	{
		(string) $display_output = null;

		$assigned_fees = explode(',', $variables_array['assigned_fees']);

		$display_output = '<input name="all_fees" type="checkbox" value="all" ' .
			((in_array('all', $assigned_fees)) ? 'checked' : '') .'> ' . AMSG_ALL_FEES . '<br><br> '.
			'<input name="assigned_fees[]" type="checkbox" value="setup" ' .
			((in_array('setup', $assigned_fees)) ? 'checked' : '') .'> ' .	GMSG_SETUP_FEE . '<br> '.
			'<input name="assigned_fees[]" type="checkbox" value="hpfeat_fee" ' .
			((in_array('hpfeat_fee', $assigned_fees)) ? 'checked' : '') .'> ' . GMSG_HPFEAT_FEE . '<br> '.
			'<input name="assigned_fees[]" type="checkbox" value="catfeat_fee" ' .
			((in_array('catfeat_fee', $assigned_fees)) ? 'checked' : '') .'> ' . GMSG_CATFEAT_FEE . '<br> '.
			'<input name="assigned_fees[]" type="checkbox" value="bolditem_fee" ' .
			((in_array('bolditem_fee', $assigned_fees)) ? 'checked' : '') .'> ' .	GMSG_BOLD_FEE . '<br> '.
			'<input name="assigned_fees[]" type="checkbox" value="hlitem_fee" ' .
			((in_array('hlitem_fee', $assigned_fees)) ? 'checked' : '') .'> ' . GMSG_HL_FEE . '<br> '.
			'<input name="assigned_fees[]" type="checkbox" value="rp_fee" ' .
			((in_array('rp_fee', $assigned_fees)) ? 'checked' : '') .'> ' . GMSG_RESPR_FEE . '<br> '.
			'<input name="assigned_fees[]" type="checkbox" value="buyout_fee" ' .
			((in_array('buyout_fee', $assigned_fees)) ? 'checked' : '') .'> ' . GMSG_BUYOUT_FEE . '<br> '.
			'<input name="assigned_fees[]" type="checkbox" value="picture_fee" ' .
			((in_array('picture_fee', $assigned_fees)) ? 'checked' : '') .'> ' . GMSG_IMG_UPL_FEE . '<br> '.
			'<input name="assigned_fees[]" type="checkbox" value="second_cat_fee" ' .
			((in_array('second_cat_fee', $assigned_fees)) ? 'checked' : '') .'> ' .	GMSG_ADDLCAT_FEE;

		return $display_output;
	}
}

?>