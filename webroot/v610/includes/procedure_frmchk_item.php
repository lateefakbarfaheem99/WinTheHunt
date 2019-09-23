<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('FRMCHK_ITEM') ) { die("Access Denied"); }

$fv = new formchecker;

if ($frmchk_details['current_step'] == 'list_in' || EDIT_AUCTION == 1) /* list in step */
{
	if ($user_details['shop_active'])
	{
		$fv->field_empty($frmchk_details['list_in'], MSG_FRMCHK_LIST_IN);
	}
}

if ($frmchk_details['current_step'] == 'details' || EDIT_AUCTION == 1) /* item details step */
{
	$fv->check_box($frmchk_details['category_id'], MSG_MAIN_CATEGORY, array('field_empty', 'field_html'));
	
	if ($frmchk_details['category_id'] == $frmchk_details['addl_category_id'])
	{
		$fv->error_list[] = array('value' => $frmchk_details['category_id'], 'msg' => MSG_FRMCHK_SAME_CATS);
	}
	$fv->check_box($frmchk_details['name'], MSG_ITEM_TITLE, array('field_empty', 'field_html'));
	$fv->check_box($frmchk_details['description'], MSG_ITEM_DESCRIPTION, array('field_empty', 'field_js', 'field_iframes', 'invalid_html'));
}

if ($frmchk_details['current_step'] == 'settings' || EDIT_AUCTION == 1) /* settings step */
{

	$fv->check_box($frmchk_details['quantity'], GMSG_QUANTITY, array('field_empty'));

	if ($frmchk_details['auction_type'] == 'dutch')
	{
		if ($frmchk_details['quantity'] < 2)
		{
			$fv->error_list[] = array('value' => $frmchk_details['quantity'], 'msg' => MSG_FRMCHK_QUANTITY_ERROR);
		}
	}

	if (!$setts['enable_store_only_mode'] && $item_details['listing_type'] != 'buy_out') /* v6.02 -> in store only mode, start_price is not required */
	{
		$fv->check_box($frmchk_details['start_price'], MSG_AUCTION_STARTS_AT, array('field_empty', 'field_number'));
	
		if ($frmchk_details['start_price'] <= 0)
		{
			$fv->error_list[] = array('value' => $frmchk_details['start_price'], 'msg' => MSG_FRMCHK_STARTPRICE);
		}
	}

	if ($frmchk_details['is_reserve'] == 1)
	{
		$fv->check_box($frmchk_details['reserve_price'], MSG_RES_PRICE, array('field_empty', 'field_number', 'field_greater'), 0, '0');
		if ($frmchk_details['start_price'] > $frmchk_details['reserve_price'] && $frmchk_details['auction_type'] != 'first_bidder')
		{
			$fv->error_list[] = array('value' => $frmchk_details['start_price'], 'msg' => MSG_FRMCHK_RP_SP_ERROR);
		}
		else if ($frmchk_details['start_price'] <= $frmchk_details['reserve_price'] && $frmchk_details['auction_type'] == 'first_bidder')
		{
			$fv->error_list[] = array('value' => $frmchk_details['start_price'], 'msg' => MSG_FRMCHK_RP_SP_FB_ERROR);
		}
		
	}
	
	if ($frmchk_details['auction_type'] == 'first_bidder')
	{
		$fv->check_box($frmchk_details['fb_decrement_amount'], MSG_FB_DECREMENT, array('field_empty', 'field_greater'), 0, '0');	
		$fv->check_box($frmchk_details['fb_decrement_interval'], MSG_FB_DECREMENT_INTERVAL, array('field_empty', 'field_greater'), 0, '0');	
	}
	
	if (!$frmchk_details['is_reserve'] && $frmchk_details['reserve_price'] > 0 && $item_details['quantity'] <= 1)
	{
		$fv->error_list[] = array('value' => $frmchk_details['is_reserve'], 'msg' => MSG_FRMCHK_RP_CHK_ERROR);		
	}

	if ($frmchk_details['is_buy_out'] == 1 || $setts['enable_store_only_mode'] || $item_details['listing_type'] == 'buy_out')
	{		
		$fv->check_box($frmchk_details['buyout_price'], MSG_BUYOUT_PRICE, array('field_empty', 'field_number'));
		if ($frmchk_details['buyout_price'] <= 0)
		{
			$fv->error_list[] = array('value' => $frmchk_details['buyout_price'], 'msg' => MSG_FRMCHK_BUYOUT_PRICE);
		}

		if (!$setts['enable_store_only_mode'] && $item_details['listing_type'] != 'buy_out')
		{
			if ($frmchk_details['start_price'] > $frmchk_details['buyout_price'])
			{
				$fv->error_list[] = array('value' => $frmchk_details['start_price'], 'msg' => MSG_FRMCHK_SP_BO_ERROR);
			}
	
			if ($frmchk_details['buyout_price'] <= $frmchk_details['reserve_price'])
			{
				$fv->error_list[] = array('value' => $frmchk_details['start_price'], 'msg' => MSG_FRMCHK_RP_BO_ERROR);
			}
		}
	}

	if (!$frmchk_details['is_buy_out'] && $frmchk_details['buyout_price'] > 0 && $item_details['listing_type'] != 'buy_out')
	{
		$fv->error_list[] = array('value' => $frmchk_details['is_buy_out'], 'msg' => MSG_FRMCHK_BO_CHK_ERROR);		
	}
	
	/* 6.02 modification -> sellers are not required to enter a make offer interval */
	if ($frmchk_details['is_offer'] == 1)
	{
		//$fv->check_box($frmchk_details['offer_min'], MSG_OFFER_MIN, array('field_empty', 'field_number', 'field_smaller'), $frmchk_details['offer_max'], MSG_OFFER_MAX);
		//$fv->check_box($frmchk_details['offer_max'], MSG_OFFER_MAX, array('field_empty', 'field_number'));
		
		(array) $offer_chk = null;
		if ($frmchk_details['offer_max'] > 0)
		{
			$offer_chk = array('field_number', 'field_smaller');
		}
		else 
		{
			$offer_chk = array('field_number');
		}
		
		$fv->check_box($frmchk_details['offer_min'], MSG_OFFER_MIN, $offer_chk, $frmchk_details['offer_max'], MSG_OFFER_MAX);
		$fv->check_box($frmchk_details['offer_max'], MSG_OFFER_MAX, array('field_number'));
	}
	
	if (!$frmchk_details['is_offer'] && ($frmchk_details['offer_min'] > 0 || $frmchk_details['offer_max'] > 0))
	{
		$fv->error_list[] = array('value' => $frmchk_details['is_offer'], 'msg' => MSG_FRMCHK_OFFER_CHK_ERROR);		
	}
	
	if ($frmchk_details['is_bid_increment'] == 1)
	{
		$fv->check_box($frmchk_details['bid_increment_amount'], MSG_CUSTOM_BID_INCREMENT, array('field_empty', 'field_number'));
		$fv->field_greater($frmchk_details['bid_increment_amount'], 0.01, MSG_FRMCHK_BI_ERROR);
	}

	if ($frmchk_details['start_time_type'] == 'custom')
	{
		$fv->field_greater($frmchk_details['start_time'], CURRENT_TIME, MSG_FRMCHK_START_TIME_PAST);
	}

	if ($frmchk_details['end_time_type'] == 'custom' && $frmchk_details['list_in'] != 'store')
	{
		$fv->field_greater($frmchk_details['end_time'], CURRENT_TIME, MSG_FRMCHK_END_TIME_PAST);
		$fv->field_greater($frmchk_details['end_time'], $frmchk_details['start_time'], MSG_FRMCHK_START_SMALLER_END_TIME);

	}

	## now check the custom boxes
	$fv->check_custom_fields($frmchk_details);
	
	## now check if there are any files not uploaded
	/*
	for ($i=1; $i<=3; $i++)
	{
		if (!empty($_REQUEST['item_file_upload_' . $i]) || !empty($_REQUEST['item_file_url_' . $i]))
		{
			$fv->error_list[] = array('value' => $frmchk_details['is_offer'], 'msg' => MSG_FRMCHK_UPLOAD_FILES);
		}
	}
	*/
	
	if ($frmchk_details['is_auto_relist'])
	{
		$fv->field_greater(($setts['nb_autorelist_max'] + 1), $frmchk_details['auto_relist_nb'], MSG_FRMCHK_AUTORELIST_NB_ERROR);
	}

	$fv->check_box($frmchk_details['zip_code'], MSG_ZIP_CODE, array('field_empty', 'field_html'));
}

if ($frmchk_details['current_step'] == 'shipping' || EDIT_AUCTION == 1) /* shipping step */
{
	if (empty($frmchk_details['direct_payment']) && empty($frmchk_details['payment_methods']))
	{
		$fv->error_list[] = array('value' => $frmchk_details['direct_payment'], 'msg' => MSG_FRMCHK_PM_METHODS);
	}
	$fv->check_box($frmchk_details['postage_amount'], MSG_POSTAGE, array('field_number'));
	$fv->check_box($frmchk_details['insurance_amount'], MSG_INSURANCE, array('field_number'));
	$fv->check_box($frmchk_details['shipping_details'], MSG_SHIPPING_DETAILS, array('field_js', 'field_iframes', 'invalid_html'));
}


?>
