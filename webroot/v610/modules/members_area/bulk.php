<?
#################################################################
## PHP Pro Bid v6.10b														##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class Module_Members_Bulk 
	extends Module_Exception 
{
	var $db; // database class
	var $fees; // fees class
	var $item; // item class
	var $setts; // setts array
	var $categories_array = null;
	var $nb_imported_listings = 0;
	
	var $csv_delimiter = ',';
	
	
	var $user_id = null;

	var $user_details = array();
	
	var $list_in = array();
	var $auction_type = array();
	var $start_time_type = array('now', 'custom');	
	var $end_time_type = array();	
	var $durations = array();
	var $categories = array();
	var $currencies = array();
	var $type_service = array();
	var $buy_out = false;
	var $make_offer = false;
	var $swap_offer = false;
	var $countries = array();
	var $custom_fields = array();
	var $custom_fields_sample;
	
	function Module_Members_Bulk($user_id = null, $setts = null, $categories_array = null)
	{
		$this->csv_delimiter = ($setts['csv_delimiter'] == 'comma') ? ',' : ';';
		
		$this->user_id = $user_id;
		$this->db = new database();
		$this->setts = &$setts;
		$this->categories_array = &$categories_array;
		
		$this->setCategories();
		$this->setCountries();
		$this->setCustomFieldsTable();
		
		$this->user_details = $this->db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id='" . $this->user_id . "'");
	}
	
	function setName()
	{
		return array(
			'id' => 'name',
			'name' => MSG_ITEM_TITLE, 
			'description' => 'varchar(255)',
			'sample' => 'My Item',
			'formchecker' => array('field_empty', 'field_html'),
			'max_length' => 255, 'type' => 'char', 'mandatory' => true
		);
	}
	
	function setDescription()
	{
		return array(
			'id' => 'description',
			'name' => GMSG_DESCRIPTION, 
			'description' => 'longtext',
			'sample' => '"&middot; &raquo; standard text, ""quoted text""; some more standard text."',
			'formchecker' => array('field_empty', 'field_js', 'field_iframes', 'invalid_html'),			
			'max_length' => 4294967296, 'type' => 'char', 'mandatory' => true
		);
	}
		
	function setListIn()
	{
		//$this->list_in = null;
		
		if (!$this->setts['enable_store_only_mode'])
		{
			$this->list_in[] = 'auction';
		}
		
		if ($this->user_details['shop_active'])
		{
			$shop = new shop();
			$shop->setts = &$this->setts;
			
			$shop_status = $shop->shop_status($this->user_details, true);

			if ($shop_status['remaining_items'] > 0)
			{
				$this->list_in[] = 'both';
				
				$this->list_in[] = 'store';
			}
		}
		
		return array(
			'id' => 'list_in', 
			'name' => MSG_LIST_IN, 
			'description' => 'enum',
			'sample' => 'auction', 
			'formchecker' => array(array('in_array', $this->list_in)),
			'max_length' => 50, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => $this->list_in
		);		
	}

	function setAuctionType()
	{
		$this->auction_type = array(
			'standard', 'dutch'
		);
		
		if ($this->setts['enable_fb_auctions'])
		{
			$this->auction_type[] = 'first_bidder';
		}
		
		return array(
			'id' => 'auction_type',
			'name' => MSG_AUCTION_TYPE, 
			'description' => 'enum',
			'sample' => 'standard',
			'formchecker' => array(array('in_array', $this->auction_type)),
			'max_length' => 50, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => $this->auction_type
		);
	}
	
	function setStartTime()
	{
		return array(
			'id' => 'start_time', 
			'name' => GMSG_START_TIME, 
			'description' => 'int',
			'sample' => '',
			'formchecker' => array('field_number', array('field_greater_empty', CURRENT_TIME)),
			'max_length' => 11, 'type' => 'timestamp', 'mandatory' => true, 'notes' => MSG_BULK_START_TIME_NOTES
		);		
	}
	
	function setStartTimeType()
	{
		return array(
			'id' => 'start_time_type',
			'name' => MSG_START_TIME_TYPE, 
			'description' => 'enum',
			'sample' => 'now',
			'formchecker' => array(array('in_array', $this->start_time_type)),
			'max_length' => 10, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => $this->start_time_type, 'notes' => MSG_BULK_START_TIME_TYPE_NOTES
		);				
	}
	
	function setEndTime()
	{
		return array(
			'id' => 'end_time',
			'name' => GMSG_END_TIME, 
			'description' => 'int',
			'sample' => '',
			'formchecker' => array('field_number', array('field_greater_empty', 'start_time')), //to edit
			'max_length' => 11, 'type' => 'timestamp > start_time', 'mandatory' => true, 'notes' => MSG_BULK_END_TIME_NOTES
		);				
	}
	
	function setEndTimeType()
	{
		$this->end_time_type[] = 'duration';
		
		if ($this->setts['enable_custom_end_time'])
		{
			$this->end_time_type[] = 'custom';
		}
		
		return array(
			'id' => 'end_time_type', 
			'name' => MSG_END_TIME_TYPE, 
			'description' => 'enum',
			'sample' => 'duration',
			'formchecker' => array(array('in_array', $this->end_time_type)),
			'max_length' => 10, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => $this->end_time_type
		);				
	}
	
	function setDurations()
	{
		$this->durations = null;
		
		$sql_select_durations = $this->db->query("SELECT days FROM
			" . DB_PREFIX . "auction_durations ORDER BY order_id ASC, days ASC");
		
		while ($duration_details = $this->db->fetch_array($sql_select_durations)) 
		{
			$this->durations[] = $duration_details['days'];
		}

		if (in_array('store', $this->list_in))
		{
			$this->durations[] = 0;
		}
		
		return array(
			'id' => 'duration',
			'name' => GMSG_DURATION, 
			'description' => 'int',
			'sample' => $this->durations[0],
			'formchecker' => array(array('in_array', $this->durations)),
			'max_length' => 5, 'type' => 'int', 'mandatory' => true, 'accepted_values' => $this->durations, 'notes' => MSG_BULK_DURATION_NOTES
		);
	}
	
	function setQuantity()
	{
		return array(
			'id' => 'quantity', 
			'name' => GMSG_QUANTITY, 
			'description' => 'int',
			'sample' => '1',
			'formchecker' => array('field_number', array('field_quantity', 'auction_type')), //to edit
			'max_length' => 6, 'type' => 'int', 'mandatory' => true, 'notes' => MSG_BULK_QUANTITY_NOTES
		);		
	}
	
	function setCategories()
	{
		$sql_select_categories = $this->db->query("SELECT c.category_id FROM " . DB_PREFIX . "categories c WHERE 
			(SELECT count(*) FROM " . DB_PREFIX . "categories p WHERE p.parent_id=c.category_id)=0 AND (c.user_id=0 OR c.user_id='{$this->user_id}')");

		while ($category_details = $this->db->fetch_array($sql_select_categories))
		{
			$this->categories[] = array('id' => $category_details['category_id'], 'name' => $this->categories_array[$category_details['category_id']][0]);
		}
	}
	
	function setCategoryId()
	{
		return array(
			'id' => 'category_id', 
			'name' => MSG_CATEGORY_ID, 
			'description' => 'int',
			'sample' => $this->categories[0]['id'],
			'formchecker' => array('field_empty', 'field_number'),
			'max_length' => 11, 'type' => 'int', 'mandatory' => true, 'notes' => MSG_BULK_CATEGORY_NOTES
		);				
	}
	
	function setAddlCategoryId()
	{
		return array(
			'id' => 'addl_category_id', 
			'name' => MSG_ADDL_CATEGORY, 
			'description' => 'int',
			'sample' => $this->categories[1]['id'],
			'formchecker' => array('field_number', array('field_not_equal', 'category_id')), // to edit			
			'max_length' => 11, 'type' => 'int', 'mandatory' => false, 'notes' => MSG_BULK_CATEGORY_NOTES
		);				
	}
	
	function setCurrencies()
	{
		$sql_select_currencies = $this->db->query("SELECT symbol FROM " . DB_PREFIX . "currencies");
		
		while ($currency_details = $this->db->fetch_array($sql_select_currencies))
		{
			$this->currencies[] = $currency_details['symbol'];
		}

		return array(
			'id' => 'currency', 
			'name' => MSG_CURRENCY, 
			'description' => 'varchar(100)',
			'sample' => $this->currencies[0],
			'formchecker' => array(array('in_array', $this->currencies)),
			'max_length' => 100, 'type' => 'char', 'mandatory' => true, 'accepted_values' => $this->currencies
		);				
	}
	
	function setStartPrice()
	{
		return array(
			'id' => 'start_price', 
			'name' => MSG_START_BID, 
			'description' => 'float',
			'sample' => '5',
			'formchecker' => array('field_empty', 'field_number'),
			'max_length' => 16, 'type' => 'float', 'mandatory' => true
		);				
	}
	
	//, 'field_store_reserve'
	function setReservePrice()
	{
		return array(
			'id' => 'reserve_price', 
			'name' => MSG_RES_PRICE, 
			'description' => 'float',
			'sample' => '6',
			'formchecker' => array('field_number', array('field_greater_empty', 'start_price')),
			'max_length' => 16, 'type' => 'float', 'mandatory' => false
		);						
	}

	//, array('field_store_buyout', 'start_price')
	function setBuyoutPrice()
	{
		return array(
			'id' => 'buyout_price', 
			'name' => MSG_BUYOUT_PRICE, 
			'description' => 'float',
			'sample' => '10',
			'formchecker' => array('field_number', array('field_greater_equal_empty', 'start_price'), array('field_greater_empty', 'reserve_price')),			
			'max_length' => 16, 'type' => 'float', 'mandatory' => false, 'notes' => MSG_BULK_BUYOUT_PRICE_NOTES
		);						
	}
	
	function setOffer()
	{
		return array(
			'id' => 'is_offer', 
			'name' => GMSG_MAKE_OFFER, 
			'description' => 'tinyint',
			'sample' => '1',
			'formchecker' => array(array('in_array', array(0, 1))),			
			'max_length' => 1, 'type' => 'int', 'mandatory' => false, 'accepted_values' => array(0, 1)
		);								
	}

	function setOfferMinRange()
	{
		return array(
			'id' => 'offer_min', 
			'name' => MSG_OFFER_MIN, 
			'description' => 'float',
			'sample' => '5',
			'formchecker' => array('field_number'),			
			'max_length' => 16, 'type' => 'float', 'mandatory' => false, 'notes' => MSG_BULK_MIN_OFFER_NOTES
		);								
	}
	
	function setOfferMaxRange()
	{
		return array(
			'id' => 'offer_max', 
			'name' => MSG_OFFER_MAX, 
			'description' => 'float',
			'sample' => '25',
			'formchecker' => array('field_number', array('field_greater_empty', 'offer_min')),			
			'max_length' => 1, 'type' => 'float', 'mandatory' => false, 'notes' => MSG_BULK_MAX_OFFER_NOTES
		);								
	}

	function setSwap()
	{
		return array(
			'id' => 'enable_swap', 
			'name' => MSG_SWAP_OFFERS, 
			'description' => 'tinyint',
			'sample' => '1',
			'formchecker' => array(array('in_array', array(0, 1))),			
			'max_length' => 1, 'type' => 'int', 'mandatory' => false, 'accepted_values' => array(0, 1)
		);								
	}
	
	function setBidIncrement()
	{
		return array(
			'id' => 'bid_increment_amount', 
			'name' => MSG_BID_INCREMENT, 
			'description' => 'float',
			'sample' => '0',
			'formchecker' => array('field_number'),			
			'max_length' => 1, 'type' => 'float', 'mandatory' => false, 'notes' => MSG_BULK_BID_INCREMENT_NOTES
		);								
	}

	function setZipCode()
	{
		return array(
			'id' => 'zip_code', 
			'name' => MSG_ZIP_CODE, 
			'description' => 'varchar(50)',
			'sample' => 'zip code',
			'formchecker' => array('field_empty', 'field_html'),			
			'max_length' => 50, 'type' => 'char', 'mandatory' => true
		);										
	}

	function setState()
	{
		return array(
			'id' => 'state', 
			'name' => MSG_STATE, 
			'description' => 'varchar(100)',
			'sample' => 'state',
			'formchecker' => array('field_empty', 'field_html'),			
			'max_length' => 100, 'type' => 'char', 'mandatory' => true
		);										
	}

	function setCountries()
	{
		$sql_select_countries = $this->db->query("SELECT id, name FROM " . DB_PREFIX . "countries WHERE parent_id=0 ORDER BY country_order ASC");

		while ($country_details = $this->db->fetch_array($sql_select_countries))
		{
			$this->countries[] = array('id' => $country_details['id'], 'name' => $country_details['name']);
		}
	}
	
	function setCountryId()
	{
		return array(
			'id' => 'country', 
			'name' => MSG_COUNTRY, 
			'description' => 'varchar(100)',
			'sample' => $this->countries[0]['id'],
			'formchecker' => array('field_empty', 'field_number'),			
			'max_length' => 100, 'type' => 'integer', 'mandatory' => true, 'notes' => MSG_BULK_COUNTRY_NOTES
		);										
	}	
	
	function setPostageAmount()
	{
		return array(
			'id' => 'postage_amount', 
			'name' => MSG_POSTAGE, 
			'description' => 'float',
			'sample' => '5',
			'formchecker' => array('field_number'),			
			'max_length' => 16, 'type' => 'float', 'mandatory' => false
		);												
	}

	function setInsuranceAmount()
	{
		return array(
			'id' => 'insurance_amount', 
			'name' => MSG_INSURANCE, 
			'description' => 'float',
			'sample' => '3',
			'formchecker' => array('field_number'),			
			'max_length' => 16, 'type' => 'float', 'mandatory' => false
		);												
	}

	function setItemWeight()
	{
		return array(
			'id' => 'item_weight', 
			'name' => MSG_WEIGHT, 
			'description' => 'int',
			'sample' => '15',
			'formchecker' => array('field_number'),			
			'max_length' => 11, 'type' => 'int', 'mandatory' => false
		);												
	}
	
	function setShippingMethod()
	{
		return array(
			'id' => 'shipping_method', 
			'name' => MSG_SHIPPING_CONDITIONS, 
			'description' => 'enum',
			'sample' => '1',
			'formchecker' => array(array('in_array', array(1, 2))),			
			'max_length' => 1, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => array(1, 2), 'notes' => MSG_BULK_SHIP_METHOD_NOTES
		);														
	}
	
	function setShippingInt()
	{
		return array(
			'id' => 'shipping_int', 
			'name' => MSG_SELLER_SHIPS_INT, 
			'description' => 'enum',
			'sample' => '1',
			'formchecker' => array(array('in_array', array(0, 1))),			
			'max_length' => 1, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => array(0, 1)
		);																
	}

	function setTypeService()
	{
		$sql_select_type_service = $this->db->query("SELECT id, name FROM " . DB_PREFIX . "shipping_options");
		
		while ($type_service = $this->db->fetch_array($sql_select_type_service))
		{
			$this->type_service[] = $type_service['name'];
		}

		return array(
			'id' => 'type_service', 
			'name' => MSG_SHIP_METHOD, 
			'description' => 'enum',
			'sample' => $this->type_service[0],
			'formchecker' => array(array('in_array', $this->type_service)),
			'max_length' => 50, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => $this->type_service
		);				
	}
	
	function setShippingDetails()
	{
		return array(
			'id' => 'shipping_details', 
			'name' => MSG_SHIPPING_DETAILS, 
			'description' => 'text',
			'sample' => 'shipping details',
			'formchecker' => array('field_html'),
			'max_length' => 1000, 'type' => 'text', 'mandatory' => false
		);						
	}
	
	function setDirectPayment()
	{
		$this->item = new item();
		$this->item->setts = &$this->setts;
		
		$dp_gateways = $this->item->select_direct_payment(null, $this->user_id, false, false, false, true);
		$dp_gateways[] = array('id' => 0, 'name' => GMSG_NA);
		
		foreach ($dp_gateways as $value)
		{
			$dp_ids[] = $value['id']; 
			$dp_desc[] = $value['id'] . ' => ' . $value['name'];
		}
		
		return array(
			'id' => 'direct_payment', 
			'name' => MSG_DIRECT_PAYMENT, 
			'description' => 'enum',
			'sample' => $dp_ids[0],
			'formchecker' => array(array('compare_arrays', $dp_ids)),
			'max_length' => 10, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => $dp_ids, 'notes' => $this->db->implode_array($dp_desc, '<br>')
		);										
	}
	
	function setOfflinePayment()
	{
		$sql_select_options = $this->db->query("SELECT id, name FROM " . DB_PREFIX . "payment_options");
		
		while ($offline_payment = $this->db->fetch_array($sql_select_options))
		{
			$op_ids[] = $offline_payment['id']; 
			$op_desc[] = $offline_payment['id'] . ' => ' . $offline_payment['name'];
		}
		
		$op_ids[] = 0;
		$op_desc[] = '0 => ' . GMSG_NA;
		
		return array(
			'id' => 'payment_methods', 
			'name' => MSG_OFFLINE_PAYMENT, 
			'description' => 'enum',
			'sample' => $op_ids[0],
			'formchecker' => array(array('compare_arrays', $op_ids)),
			'max_length' => 10, 'type' => 'enum', 'mandatory' => true, 'accepted_values' => $op_ids, 'notes' => $this->db->implode_array($op_desc, '<br>')
		);										
	}
	
	function setHpFeat()
	{
		return array(
			'id' => 'hpfeat', 
			'name' => MSG_HP_FEATURED, 
			'description' => 'enum',
			'sample' => '0',
			'formchecker' => array(array('in_array', array(0, 1))),
			'max_length' => 1, 'type' => 'text', 'mandatory' => false, 'accepted_values' => array(0, 1), 'notes' => MSG_BULK_YES_NO_NOTES
		);								
	}
	
	function setCatFeat()
	{
		return array(
			'id' => 'catfeat', 
			'name' => MSG_CAT_FEATURED, 
			'description' => 'enum',
			'sample' => '0',
			'formchecker' => array(array('in_array', array(0, 1))),
			'max_length' => 1, 'type' => 'text', 'mandatory' => false, 'accepted_values' => array(0, 1), 'notes' => MSG_BULK_YES_NO_NOTES
		);								
	}
	
	function setBold()
	{
		return array(
			'id' => 'bold', 
			'name' => MSG_BOLD_AD, 
			'description' => 'enum',
			'sample' => '0',
			'formchecker' => array(array('in_array', array(0, 1))),
			'max_length' => 1, 'type' => 'text', 'mandatory' => false, 'accepted_values' => array(0, 1), 'notes' => MSG_BULK_YES_NO_NOTES
		);								
	}
	
	function setHl()
	{
		return array(
			'id' => 'hl', 
			'name' => MSG_HL_AD, 
			'description' => 'enum',
			'sample' => '0',
			'formchecker' => array(array('in_array', array(0, 1))),
			'max_length' => 1, 'type' => 'text', 'mandatory' => false, 'accepted_values' => array(0, 1), 'notes' => MSG_BULK_YES_NO_NOTES
		);								
	}
	
	function setHiddenBidding()
	{
		return array(
			'id' => 'hidden_bidding', 
			'name' => MSG_PRIVATE_AUCTION, 
			'description' => 'enum',
			'sample' => '0',
			'formchecker' => array(array('in_array', array(0, 1))),
			'max_length' => 1, 'type' => 'text', 'mandatory' => false, 'accepted_values' => array(0, 1), 'notes' => MSG_BULK_YES_NO_NOTES
		);								
	}
	
	function setApplyTax()
	{
		return array(
			'id' => 'apply_tax', 
			'name' => MSG_ADD_TAX, 
			'description' => 'enum',
			'sample' => '0',
			'formchecker' => array(array('in_array', array(0, 1))),
			'max_length' => 1, 'type' => 'text', 'mandatory' => false, 'accepted_values' => array(0, 1), 'notes' => MSG_BULK_YES_NO_NOTES
		);								
	}

	function setAutoRelistsNb()
	{
		return array(
			'id' => 'auto_relist_nb', 
			'name' => MSG_NB_AUTO_RELISTS, 
			'description' => 'int',
			'sample' => '0',
			'formchecker' => array('field_number', array('field_smaller_empty', $this->setts['nb_autorelist_max'])),
			'max_length' => 5, 'type' => 'int', 'mandatory' => false, 'notes' => '<' . $this->setts['nb_autorelist_max']
		);										
	}
	
	function setAutoRelistBids()
	{
		return array(
			'id' => 'auto_relist_bids', 
			'name' => MSG_AUTO_RELIST_SOLD, 
			'description' => 'enum',
			'sample' => '0',
			'formchecker' => array(array('in_array', array(0, 1))),
			'max_length' => 1, 'type' => 'text', 'mandatory' => false, 'accepted_values' => array(0, 1), 'notes' => MSG_BULK_YES_NO_NOTES
		);								
	}

	function setFbDecrementAmount()
	{
		return array(
			'id' => 'fb_decrement_amount', 
			'name' => MSG_FB_DECREMENT . '(' . GMSG_FIRST_BIDDER . ')', 
			'description' => 'float',
			'sample' => '0.5',
			'formchecker' => array('field_number', array('field_smaller_empty', 'start_price')),
			'max_length' => 16, 'type' => 'float', 'mandatory' => true, 'notes' => MSG_BULK_FIRST_BIDDER_NOTE
		);								
	}

	function setFbDecrementInterval()
	{
		return array(
			'id' => 'fb_decrement_interval', 
			'name' => MSG_FB_DECREMENT_INTERVAL . '(' . GMSG_FIRST_BIDDER . ')', 
			'description' => 'int',
			'sample' => '1',
			'formchecker' => array('field_number'),
			'max_length' => 11, 'type' => 'int', 'mandatory' => true, 'notes' => MSG_BULK_FIRST_BIDDER_NOTE
		);								
	}	
	
	function setImagesDetails()
	{
		return array(
			'id' => 'images_details', 
			'name' => MSG_UPLOAD_IMAGES,
			'description' => 'text', 
			'sample' => 'http://www.phpprosoftware.com/images/sample_image1.jpg|http://www.phpprosoftware.com/images/sample_image2.jpg', 
			'formchecker' => array('field_html'), 
			'max_length' => 5000, 'type' => 'text', 'mandatory' => false, 'notes' => MSG_BULK_MEDIA_IMAGE_NOTE
		);
	}

	function setVideosDetails()
	{
		return array(
			'id' => 'media_details', 
			'name' => MSG_UPLOAD_MEDIA,
			'description' => 'text', 
			'sample' => '', 
			'formchecker' => array(), 
			'max_length' => 5000, 'type' => 'text', 'mandatory' => false, 'notes' => MSG_BULK_MEDIA_VIDEO_NOTE
		);
	}

	function setDdDetails()
	{
		return array(
			'id' => 'dd_details', 
			'name' => MSG_DIGITAL_GOODS,
			'description' => 'text', 
			'sample' => '', 
			'formchecker' => array('field_html'), 
			'max_length' => 5000, 'type' => 'text', 'mandatory' => false, 'notes' => MSG_BULK_MEDIA_DD_NOTE
		);
	}
	
	function setCustomFieldsTable()
	{
		$sql_select_custom_fields = $this->db->query("SELECT b.box_id, IF(b.box_name!='', b.box_name, f.field_name) AS box_name, 
			f.category_id, b.box_type, t.box_type AS box_type_desc, b.box_value, b.mandatory, b.formchecker_functions, 
			f.active, f.category_id, f.page_handle   
			FROM " . DB_PREFIX . "custom_fields_boxes b
			LEFT JOIN " . DB_PREFIX . "custom_fields f ON f.field_id=b.field_id 
			LEFT JOIN " . DB_PREFIX . "custom_fields_types t ON t.type_id=b.box_type");

		while ($fields_details = $this->db->fetch_array($sql_select_custom_fields))
		{
			if ($fields_details['active'] && $fields_details['page_handle'] == 'auction')
			{
				$this->custom_fields[$fields_details['box_id']] = array(
					'id' => $fields_details['box_id'], 
					'name' => $fields_details['box_name'], 
					'category_id' => $fields_details['category_id'], 
					'category_name' => $this->categories_array[$fields_details['category_id']][0], 
					'box_type' => $fields_details['box_type'], 
					'box_type_desc' => $fields_details['box_type_desc'], 
					'box_value' => $fields_details['box_value'], 
					'mandatory' => $fields_details['mandatory'], 
					'formchecker_functions' => $fields_details['formchecker_functions']
				);
				
				$box_value = $this->splitCfValues($fields_details['box_value']);
				$box_value = (empty($fields_details['box_value'])) ? $fields_details['box_name'] : $box_value[0];
				
				$this->custom_fields_sample[] = $fields_details['box_id'] . '::' . $box_value;
			}
		}		
	}
		
	function setCustomFields()
	{
		return array(
			'id' => 'custom_fields_details', 
			'name' => MSG_CUSTOM_FIELDS, 
			'description' => 'text', 
			'sample' => $this->db->implode_array($this->custom_fields_sample, '|'), 
			'formchecker' => array(), 
			'max_length' => 5000, 'type' => 'text', 'mandatory' => false, 'notes' => MSG_BULK_CUSTOM_FIELDS_NOTES
		);
	}
	
	function splitCfValues($input)
	{
		return @explode('[]', $input);
	}
	
	function csvExplode($input, $delimiter, $enclose = '"')
	{
		/*
		$output = array();
		$n = 0;
		$enclosed_array = explode($enclose, $input);		
		$quote = false;
		
		foreach($enclosed_array as $enclosed_item)
		{
			if($n++%2)
			{
				array_push($output, array_pop($output) . ($quote ? $enclose : '') . $enclosed_item);
			}
			else
			{
				$delimited_array = explode($delimiter, $enclosed_item);
				array_push($output, array_pop($output) . array_shift($delimited_array));
				$output = array_merge($output, $delimited_array);
			}
			$quote = (empty($enclosed_item)) ? true : false;
		}
		return $output;
		*/
		$file_limit = 20 * 1024 * 1024; //20MB
		$length = strlen($input);
		$fp = fopen("php://temp/maxmemory:$file_limit", 'r+');
		fputs($fp, $input);
		rewind($fp);

		$data = fgetcsv($fp, $length, $delimiter, $enclose); //  $escape only got added in 5.3.0

		fclose($fp);
		return $data;
	}

}
?>