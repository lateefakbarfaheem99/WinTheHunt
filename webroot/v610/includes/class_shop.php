<?
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class shop extends database
{
	var $fees;
	var $user_id;
	
	function shop_status($user_details, $view_all = false)
	{
		$output = array('enabled' => false, 'display' => '<span class="redfont">' . GMSG_DISABLED . '</span>', 
			'account_id' => 0, 'account_type' => GMSG_NONE, 'shop_description' => null, 
			'total_items' => 0, 'remaining_items' => 0	
		);
		
		if ($view_all)
		{
			$shop_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "fees_tiers WHERE 
				tier_id='" . $user_details['shop_account_id'] . "'");
		}

		if ($user_details['shop_account_id'])
		{
			$output['account_id'] = $user_details['shop_account_id'];
			
			if ($view_all)
			{					
				$output['account_type'] = $shop_details['store_name'];
				$output['shop_description'] = $this->shop_description($shop_details, false);
			}
		}
		
		if ($user_details['shop_active'])
		{
			$output['enabled'] = true;
			$output['display'] = '<span class="greenfont">' . GMSG_ENABLED . '</span>';

			if ($user_details['shop_account_id'])
			{
				if ($view_all)
				{					
					$output['total_items'] = $this->count_rows('auctions', "WHERE list_in!='auction' AND 
						active=1 AND approved=1 AND closed=0 AND deleted=0 AND owner_id='" . $user_details['user_id'] . "'");
					$output['remaining_items'] = $shop_details['store_nb_items'] - $output['total_items'];
					$output['remaining_items'] = ($output['remaining_items'] > 0) ? $output['remaining_items'] : 0;
				}
			}
			else 
			{
				## workaround so that there are an unlimited number of remaining items in case there are no 
				## subscriptions set up
				$output['remaining_items'] = 1; 
				$output['account_type'] = GMSG_DEFAULT;
				$output['shop_description'] = MSG_FREE_UNLIMITED_ITEMS;
			}
		}

		return $output;
	}

	function shop_description ($shop_details, $show_title = true)
	{
		(string) $display_output = null;
		
		$this->fees = new fees();
		$this->fees->setts = $this->setts;
		$this->fees->display_free = true;
		
		if ($show_title) 
		{
			$output[] = '<b>' . $shop_details['store_name'] . '</b>';
		}
		
		$shop_fee_amount = $shop_details['fee_amount'];
		## calculate the preferred seller and tax for the fee
		$preferred_seller = $this->get_sql_field("SELECT preferred_seller FROM " . DB_PREFIX . "users WHERE
			user_id='" . $this->user_id . "'", 'preferred_seller');
		
		if ($preferred_seller && $this->setts['enable_pref_sellers'])
		{
			$shop_fee_amount = $this->fees->round_number($shop_fee_amount - ($shop_fee_amount * ($this->setts['pref_sellers_reduction'] / 100)));
		}
		
		$tax_output = $this->fees->apply_tax($shop_fee_amount, $this->setts['currency'], $this->user_id, $this->setts['enable_tax']);
		$shop_fee_amount = $tax_output['amount'];
		
		$output[] = $shop_details['store_nb_items'] . ' ' . MSG_ITEMS;
		$output[] = MSG_PRICE . ': ' . $this->fees->display_amount($shop_fee_amount, $this->setts['currency']);
		$output[] = ($shop_details['store_recurring'] > 0) ? MSG_RECURRING_EVERY . ' ' . $shop_details['store_recurring'] . ' ' . GMSG_DAYS : MSG_FLAT_FEE;

		if ($shop_details['store_featured'])
		{
			$output[] = '[ <b>' . MSG_FEATURED_STORE . '</b> ]';
		}
		
		$display_output = $this->implode_array($output,', ');
		
		return $display_output;
	}
	function save_aboutme($form_details, $user_id)
	{
		$store_active = $this->get_sql_field("SELECT shop_active FROM
			" . DB_PREFIX . "users WHERE user_id=" . $user_id, 'shop_active');

		$store_active = ($form_details['enable_aboutme_page']) ? 0 : $store_active;

		$this->query("UPDATE " . DB_PREFIX . "users SET enable_aboutme_page='" . $form_details['enable_aboutme_page'] . "',
			aboutme_page_content='" . $this->rem_special_chars($form_details['aboutme_page_content']) . "' WHERE	user_id='" . $user_id . "'");
		
		##,shop_active='" . $store_active . "'
	}

	function favourite_store_link ($store_id, $user_id)
	{
		(string) $display_output = null;

		if ($user_id)
		{
			$is_favourite = $this->count_rows('favourite_stores', "WHERE store_id='" . $store_id . "' AND user_id='" . $user_id . "'");

			$fav_store = ($is_favourite) ? 'remove' : 'add';
			$fav_store_msg = ($is_favourite) ? MSG_ADD_TO_FAVOURITE_STORES : MSG_REMOVE_FROM_FAVOURITE_STORES;
			$display_output = ' [ <a href="' . process_link('shop', array('user_id' => $store_id, 'fav_store' => $fav_store)) . '">' . $fav_store_msg . '</a> ]';
		}

		return $display_output;
	}
	
	function store_templates_drop_down ($box_name = 'shop_template_id', $selected = null)
	{
		(string) $display_output = null;
		$store_template_names = array(MSG_STORE_TPL_DESIGN_0, MSG_STORE_TPL_DESIGN_1, MSG_STORE_TPL_DESIGN_2, 
			MSG_STORE_TPL_DESIGN_3, MSG_STORE_TPL_DESIGN_4, MSG_STORE_TPL_DESIGN_5);

		$nb_templates = 6; ## max template id = 5

		$display_output = '<select name="' . $box_name . '" id="' . $box_name . '" size="10"  onChange="previewPic(this)"> ';

		for ($i=0; $i<$nb_templates; $i++)
		{
			$display_output .= '<option value="' . $i . '" ' . (($i == $selected) ? 'selected' : '') . '>' . $store_template_names[$i] . '</option> ';
		}
		$display_output .= '</select> ';

		$display_output .= '&nbsp; <img src="store_templates/images/' . (($selected) ? $selected : '0') . '.jpg?' . rand(2,9999) . '" border="1" align="top" name="preview_pic"> ';
		
		return $display_output;		
	}
	
	function store_subscriptions_drop_down ($box_name = 'shop_account_id', $selected = null, $drop_down = false)
	{
		(string) $display_output = null;
		
		$sql_select_subscriptions = $this->query("SELECT * FROM " . DB_PREFIX . "fees_tiers WHERE fee_type='store' ORDER BY fee_amount ASC");
			
		$added_menu = false;
		$default_check = false;
		
		if ($drop_down)
		{
			$display_output = '<select name="' . $box_name . '"> ';
		}
      
		while ($subscr_details = $this->fetch_array($sql_select_subscriptions)) 
		{
			if ($drop_down)
			{
				$display_output .= '<option value="' . $subscr_details['tier_id'] . '" ' . (($subscr_details['tier_id'] == $selected) ? 'selected' : '') . '	>' . $this->shop_description($subscr_details) . '</option>';
			}
			else 
			{
				if (!$added_menu)
				{
					$added_menu = true;
					$display_output .= '<tr class="c1"> '.
						'	<td align="right">' . MSG_CHOOSE_SUBSCRIPTION . '</td> ';
				}
				else 
				{
					$display_output .= '<tr> '.
						'	<td></td> ';
						
				}
				$display_output .= '	<td class="c1"><input type="radio" name="shop_account_id" value="' . $subscr_details['tier_id'] . '" ' . (($subscr_details['tier_id'] == $selected || !$default_check) ? 'checked' : '') . '> ' . $this->shop_description($subscr_details) . '</td></tr>';				
			}
			
			$default_check = true;
		}
			
		if ($drop_down)
		{
			$display_output .= '</select>';
		}
		
		return $display_output;
	}
	
	function shop_save_settings($post_details, $user_id)
	{
		$shop_logo_path = get_main_image($post_details['ad_image']);
		$post_details = $this->rem_special_chars_array($post_details);

		$this->query("UPDATE " . DB_PREFIX . "users SET 
			shop_name='" . $post_details['shop_name'] . "', shop_mainpage='" . $post_details['shop_mainpage'] . "', 
			shop_logo_path='" . $shop_logo_path . "', shop_template_id='" . $post_details['shop_template_id'] . "', 
			shop_metatags='" . $post_details['shop_metatags'] . "', store_password='" . $post_details['store_password'] . "' WHERE 
			user_id='" . $user_id . "'");
	}
	
	function shop_save_pages($post_details, $user_id)
	{
		$post_details = $this->rem_special_chars_array($post_details);
		
		$feat_items_row = intval($post_details['shop_nb_feat_items_row']);
		$feat_items_row = ($feat_items_row<0 || $feat_items_row > $post_details['shop_nb_feat_items']) ? $post_details['shop_nb_feat_items'] : $feat_items_row;		
		
		$this->query("UPDATE " . DB_PREFIX . "users SET 
			shop_about='" . $post_details['shop_about'] . "', shop_specials='" . $post_details['shop_specials'] . "', 
			shop_shipping_info='" . $post_details['shop_shipping_info'] . "', shop_company_policies='" . $post_details['shop_company_policies'] . "', 
			shop_nb_feat_items_row='" . $feat_items_row . "', shop_nb_feat_items='" . $post_details['shop_nb_feat_items'] . "', 
			shop_nb_ending_items='" . $post_details['shop_nb_ending_items'] . "', 
			shop_nb_recent_items='" . $post_details['shop_nb_recent_items'] . "' WHERE user_id='" . $user_id . "'");		
	}
	
	function shop_save_subscription ($post_details, $user_id)
	{
		$output = array('display' => null, 'show_page' => true);
		(array) $query = null;
		
		$shop_details = $this->get_sql_row("SELECT enable_aboutme_page, shop_account_id, shop_active, shop_next_payment FROM
			" . DB_PREFIX . "users WHERE user_id=" . $user_id);
				
		$enable_aboutme_page = ($post_details['shop_active']) ? 0 : $shop_details['enable_aboutme_page'];
		$shop_active = $post_details['shop_active'];
		$store_inactivated = ($shop_active) ? 0 : 1;
		
		//$query[] = "enable_aboutme_page='" . $enable_aboutme_page . "'";
		
		if ($post_details['shop_account_id'])
		{
			$query[] = "shop_account_id='" . $post_details['shop_account_id'] . "'";
		}
		
		$charge_fees = false;
		/**
		 * the fee routine is called if the shop is active and we change the shop account or if
		 * the shop is inactive and we activate it
		 */
		if (($post_details['shop_account_id'] != $shop_details['shop_account_id'] && $shop_details['shop_active'] && $post_details['shop_account_id']) || ($post_details['shop_active'] && !$shop_details['shop_active'] && $shop_details['shop_next_payment'] < CURRENT_TIME))
		{
			## if we change the shop_account_id, shop_active = 0 until we go through the setup fee process
			$shop_active = 0;
			$charge_fees = true;
			$query[] = "shop_next_payment='" . CURRENT_TIME . "'";
		}
		else if ($post_details['shop_account_id'] != $shop_details['shop_account_id'] && !$shop_details['shop_active'] && !$post_details['shop_active'])
		{
			$shop_active = 0;
			$charge_fees = false;
			$query[] = "shop_next_payment='" . CURRENT_TIME . "'";			
		}
		
		$query[] = "shop_active='" . $shop_active . "', store_inactivated='" . $store_inactivated . "'";
		
		$override_fee = false;
		$fee_amount = null;
		$old_subscription_fee = $this->get_sql_field("SELECT fee_amount FROM " . DB_PREFIX . "fees_tiers WHERE tier_id='{$shop_details['shop_account_id']}'", 'fee_amount');
		$new_subscription_fee = $this->get_sql_field("SELECT fee_amount FROM " . DB_PREFIX . "fees_tiers WHERE tier_id='{$post_details['shop_account_id']}'", 'fee_amount');
		
		if (allow_store_upgrade($user_id))
		{
			$override_fee = true;
			$fee_amount = $new_subscription_fee - $old_subscription_fee;
			$fee_amount = ($fee_amount > 0) ? $fee_amount : 0;
		}
		else if (($new_subscription_fee - $old_subscription_fee) <= 0 && $shop_details['shop_next_payment'] > CURRENT_TIME)
		{
			$override_fee = true;
			$fee_amount = 0;
		}
		
		
		$shop_update_query = $this->implode_array($query, ', ');
		$this->query("UPDATE " . DB_PREFIX . "users SET " . $shop_update_query . " WHERE user_id=" . $user_id);
		
		if ($charge_fees)
		{
			$this->fees = new fees();
			$this->fees->setts = $this->setts;
			
			$store_subscription_fee = $this->fees->store_subscription($post_details['shop_account_id'], $user_id, $override_fee, $fee_amount);
			$output['display'] = $store_subscription_fee['display'];
			$output['show_page'] = false;
		}
		else 
		{
			$output['display'] = '<p align="center" class="contentfont">' . MSG_CHANGES_SAVED . '</p>';
		}
		
		return $output;	
	}
		
}

?>