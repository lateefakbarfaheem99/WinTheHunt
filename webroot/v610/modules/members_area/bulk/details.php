<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class Module_Members_Bulk_Details 
	extends Module_Members_Bulk 
{
	var $display_output = null;
	var $fields_details = array();
	var $column_names = array();
	
	
	
	function Module_Members_Bulk_Details($user_id = null, $setts = null, $categories_array = null)
	{
		// not using __construct because of php4 compatibility.
		$this->Module_Members_Bulk($user_id, $setts, $categories_array);
		$this->setFields();
	}

	/**
	 * the function which will create all fields necessary for the bulk lister. 
	 * it is based on which settings are enabled from the admin area
	 */
	function setFields()
	{
		$this->fields_details[] = $this->setName();		
		$this->fields_details[] = $this->setDescription();
		$this->fields_details[] = $this->setListIn();
		$this->fields_details[] = $this->setAuctionType();
		$this->fields_details[] = $this->setStartTime();
		$this->fields_details[] = $this->setStartTimeType();
		$this->fields_details[] = $this->setEndTime();
		$this->fields_details[] = $this->setEndTimeType();
		$this->fields_details[] = $this->setDurations();
		$this->fields_details[] = $this->setQuantity();
		$this->fields_details[] = $this->setCategoryId();
		
		if ($this->setts['enable_addl_category'])
		{
			$this->fields_details[] = $this->setAddlCategoryId();
		}
		
		$this->fields_details[] = $this->setCurrencies();
		$this->fields_details[] = $this->setStartPrice();
		$this->fields_details[] = $this->setReservePrice();
		
		if ($this->setts['buyout_process'])
		{
			$this->fields_details[] = $this->setBuyoutPrice();			
		}
		
		if ($this->setts['makeoffer_process'])
		{
			$this->fields_details[] = $this->setOffer();
			$this->fields_details[] = $this->setOfferMinRange();
			$this->fields_details[] = $this->setOfferMaxRange();
		}
		
		if ($this->setts['enable_swaps'])
		{
			$this->fields_details[] = $this->setSwap();
		}
		
		$this->fields_details[] = $this->setBidIncrement();
		$this->fields_details[] = $this->setZipCode();
		$this->fields_details[] = $this->setState();
		$this->fields_details[] = $this->setCountryId();
		
		if ($this->setts['enable_shipping_costs']) 
		{
			$this->fields_details[] = $this->setPostageAmount();
		}
		
		$this->fields_details[] = $this->setInsuranceAmount();
		$this->fields_details[] = $this->setItemWeight();
		$this->fields_details[] = $this->setShippingMethod();
		$this->fields_details[] = $this->setShippingInt();
		$this->fields_details[] = $this->setTypeService();
		$this->fields_details[] = $this->setShippingDetails();
		
		$this->fields_details[] = $this->setDirectPayment();
		$this->fields_details[] = $this->setOfflinePayment();
		
		$this->fields_details[] = $this->setHpFeat();
		$this->fields_details[] = $this->setCatFeat();
		$this->fields_details[] = $this->setBold();
		$this->fields_details[] = $this->setHl();
		$this->fields_details[] = $this->setHiddenBidding();
		
		if ($this->setts['enable_tax'])
		{
			$this->fields_details[] = $this->setApplyTax();
		}
		
		if ($this->setts['enable_auto_relist'])
		{
			$this->fields_details[] = $this->setAutoRelistsNb();
			$this->fields_details[] = $this->setAutoRelistBids();
		}
		
		if ($this->setts['enable_fb_auctions'])
		{
			$this->fields_details[] = $this->setFbDecrementAmount();
			$this->fields_details[] = $this->setFbDecrementInterval();
		}

		if ($this->setts['max_images'])
		{
			$this->fields_details[] = $this->setImagesDetails();
		}
		
		if ($this->setts['max_media'])
		{
			$this->fields_details[] = $this->setVideosDetails();
		}
		
		if ($this->setts['dd_enabled'] && $this->setts['max_dd'])
		{
			$this->fields_details[] = $this->setDdDetails();
		}
		
		$is_custom_fields = $this->db->count_rows('custom_fields', "WHERE active=1 AND page_handle='auction'");
		
		if ($is_custom_fields)
		{
			$this->fields_details[] = $this->setCustomFields();
		}
		
		foreach ($this->fields_details as $details)
		{
			$this->column_names[] = $details['id'];			
		}
	}
	
	function displayMandatory($input)
	{
		return ($input) ? '<span class="greenfont">' . GMSG_YES . '</span>' : '<span class="redfont">' . GMSG_NO . '</span>';
	}
	
	function displayAcceptedValues($input)
	{
		if (is_array($input))
		{
			return $this->db->implode_array($input, ', ');
		}
		
		$input = (empty($input)) ? GMSG_NA : $input;
		
		return $input;
	}
	
	function generateSampleFile()
	{
		$fp = fopen('bulk_sample.csv', 'w+');
		
		if ($fp)
		{
			$file_header = null;
			$file_content = null;
			foreach ($this->fields_details as $key => $field)
			{
				$file_header[] = $field['name'];
				$file_content[] = $field['sample'];
			}
			
			$file = $this->db->implode_array($file_header, $this->csv_delimiter) . "\n" . $this->db->implode_array($file_content, $this->csv_delimiter);
			
			fputs($fp, $file, strlen($file));
	
			fclose($fp);	
			
			return true;
		}
		
		return false;
	}
	
	function importFile($input, $relative_path = null)
	{
		$valid_row = array();
		
		$is_upload = false;
		if (!empty($input))
		{
			$file['name'] = $input;
			$is_upload = true;		
		}
//		$is_upload = @copy($file['tmp_name'], 'uplimg/' . $file['name']);

		if ($is_upload)
		{
			$file_content = file($relative_path . 'uplimg/' . $file['name']);
			
			$fv = new formchecker();
			
			$session = new session();
			$user_id = $session->value('user_id');
			
			foreach ($file_content as $id => $row)
			{
				$import_errors = false;
				if ($id > 0)
				{
					//$imported_row = @explode($this->csv_delimiter, $row);
					$imported_row = $this->csvExplode($row, $this->csv_delimiter);
					
					$counter = 0;
					$error_details = null;
					foreach ($this->fields_details as $details)
					{
						$field = trim($imported_row[$counter]);
						
						if (!empty($details['formchecker']))
						{
							foreach ($details['formchecker'] as $form_checker)
							{
								if (is_array($form_checker))
								{
									list($function_name, $allowed_values) = $form_checker;
									
									$array_key = array_search($allowed_values, $this->column_names);
									if ($array_key)
									{
										$allowed_values = $imported_row[$array_key];
									}
												
															
									$fv_result = $fv->$function_name($field, $allowed_values, null);
								}
								else 
								{
									$fv_result = $fv->$form_checker($field, null);
								}
								
								if (!$fv_result)
								{
									$error_details[] = '<li>Field Name: <b>' . $details['name'] . '</b>; Function Error: <b>' . $function_name . '</b> - Details: ' . ((empty($field)) ? '<em>null</em>' : $this->error_field_display($field)) . ' != ' . $this->db->implode_array((array)$allowed_values) . '</li>';
								}
								$import_errors = (!$fv_result) ? true : $import_errors;
							}
						}
						$counter++;
					}
					
					if ($import_errors)
					{
						$this->setException(
							'<span class="redfont"><b>Error</b>:</span> 
							Errors reported on row <b>#' . ($id+1) . '</b>, Auction Name: <b>' . $imported_row[0] . '</b>. 
							The row cannot imported.'.
							'<ul style="padding: 0 25px; margin: 0">' . $this->db->implode_array($error_details, '') . '</ul>'
						);
					}
					else 
					{
						$valid_row[] = $imported_row;
					}
				}
			}
			
			@unlink($relative_path . 'uplimg/' . $file['name']);
			
			$this->nb_imported_listings = count($valid_row);
			if ($this->nb_imported_listings > 0)
			{
				// ready to import the file
				$this->saveRows($valid_row);
				return true;
			}
			else 
			{
				return false;
			}			
		}
		else 
		{
			return false;
		}
	}
	
	function error_field_display($field, $max_length = 300)
	{
		$field = strip_tags($field);
		
		$fieldSize = strlen($field);
		
		return '"' . (($fieldSize > $max_length) ? substr($field, 0, $max_length) . ' ... ' : $field) . '"';
	}

	function saveRows($input)
	{
		foreach ($input as $row)
		{
			$row = $this->db->rem_special_chars_array($row);
			$row = $this->db->array_add_quotes($row);
			
			$query = "INSERT INTO " . DB_PREFIX . "bulk_listings 
				(" . $this->db->implode_array($this->column_names) . ", owner_id, import_date) VALUES 
				(" . $this->db->implode_array($row) . ", '" . session::value('user_id') . "', '" . CURRENT_TIME . "')";
			
			$this->db->query($query);
		}
		
		return true;
	}
	
	function removeRows($ids, $all = false)
	{
		$owner_id = session::value('user_id');
		
		$where = null;
		if (!$all)
		{
			$ids = $this->db->implode_array($ids);
			$where = " AND auction_id IN (" . $ids . ") ";
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "bulk_listings 
			WHERE owner_id='" . $owner_id . "'" . $where);
		
		return true;
	}
	
	function resetBulkFlag($ids, $all = false)
	{
		$owner_id = session::value('user_id');
		
		$where = null;
		if (!$all)
		{
			$ids = $this->db->implode_array($ids);
			$where = " AND auction_id IN (" . $ids . ") ";
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "auctions SET bulk_list=0 
			WHERE owner_id='" . $owner_id . "'" . $where);
		
		return true;		
	}
	
	function uploadMedia($item_details)
	{
		$max_dd = ($this->setts['dd_enabled']) ? $this->setts['max_dd'] : 0;
		
		$details = array(
			1 => 	array (
						'content' => $item_details['images_details'], 
						'max' => $this->setts['max_images']
					), 
			2 => 	array (
						'content' => $item_details['media_details'], 
						'max' => $this->setts['max_media']
					), 
			3 => 	array (
						'content' => $item_details['dd_details'], 
						'max' => $max_dd
					)
		);
		
		$this->item = new item();
		$this->item->setts = &$this->setts;
		
		foreach ($details as $file_type => $values)
		{
			if (!empty($values['content']) && $values['max'])
			{
				$files = explode('|', $values['content']);
				
				foreach ($files as $file)
				{
					$file_upload_prefix = (($this->item->add_unique) ? $this->item->media_file_prefix($file_type) . '_' : '') . $item_details['auction_id'];

					if (stristr($file, 'http:') || stristr($file, 'https:'))
					{
						$file_name = $file;
					}
					else 
					{
						$file_details = array();
						$file_details['size'] = @filesize($file);
						$file_details['name'] = $file;
						$file_details['tmp_name'] = $file;
						
						$file_name = $this->item->upload_file($item_details['auction_id'], $file_type, $file_details, $file_upload_prefix, false, true);
					}
			
					if ($file_name)
					{
						$this->item->upload_create_row($item_details['auction_id'], $file_type, $file_name);						
					}					
				}
			}
		}
	}
	
	function formatCfBox($box_value, $box_type)
	{
		if ($box_type == 'checkbox')
		{
			$box_value = str_replace(',', '|', $box_value);
		}
		
		return $this->db->rem_special_chars($box_value);
	}
	
	function uploadCustomFields($cf_data, $auction_id, $category_id)
	{
		if (!empty($cf_data))
		{
			$cf_data = @explode('|', $cf_data);			
			foreach ($cf_data as $custom_field)
			{
				$cf = @explode('::', $custom_field);
				
				$categories = get_parent_cats($category_id);

				if ($cf[0] == $this->custom_fields[$cf[0]]['id'])
				{
					if (
						(!$this->custom_fields[$cf[0]]['mandatory'] || !empty($cf[1])) && 
						(in_array($this->custom_fields[$cf[0]]['category_id'], $categories) || !$this->custom_fields[$cf[0]]['category_id'])
					)
					{
						$this->db->query("INSERT INTO " . DB_PREFIX . "custom_fields_data 
							(box_id, owner_id, box_value, page_handle) VALUES 
							('" . intval($cf[0]) . "', '" . $auction_id . "', 
							'" . $this->formatCfBox($cf[1], $this->custom_fields[$cf[0]]['box_type_desc']) . "', 'auction')");
					}
				}
			}			
		}
	}
	
	function createListings($ids, $all = false)
	{
		$owner_id = session::value('user_id');

		$user_details = $this->db->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id='" . $owner_id . "'");
		
		
		$where = null;
		if (!$all)
		{
			$ids_remove = $ids;
			$ids = $this->db->implode_array($ids);
			$where = " AND auction_id IN (" . $ids . ") ";
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "auctions 
			(name, description, quantity, auction_type, start_price, reserve_price, buyout_price, bid_increment_amount,
			country, zip_code, shipping_method, shipping_int, payment_methods, category_id, owner_id, hpfeat, catfeat,
			bold, hl, hidden_bidding, currency, postage_amount, insurance_amount, type_service, enable_swap,
			addl_category_id, shipping_details, list_in, direct_payment, apply_tax, auto_relist_bids,
			is_offer, offer_min, offer_max, auto_relist_nb, state, item_weight, 
			start_time, start_time_type, 
			end_time, end_time_type, duration, bulk_list, 
			fb_decrement_amount, fb_decrement_interval, bulk_id) 
			SELECT 
			name, description, quantity, auction_type, start_price, 
			IF(list_in='store', 0, reserve_price), IF(list_in='store', start_price, buyout_price), bid_increment_amount, 
			country, zip_code, shipping_method, shipping_int, payment_methods, category_id, owner_id, 
			IF(list_in='store', 0, hpfeat), IF(list_in='store', 0, catfeat), IF(list_in='store', 0, bold), IF(list_in='store', 0, hl), 
			hidden_bidding, currency, postage_amount, insurance_amount, type_service, enable_swap,
			addl_category_id, shipping_details, list_in, direct_payment, apply_tax, auto_relist_bids,
			is_offer, offer_min, offer_max, auto_relist_nb, state, item_weight, 
			IF(start_time_type='now' or start_time<" . CURRENT_TIME . ", " . CURRENT_TIME . ", start_time), start_time_type, 
			IF(list_in='store', 0, (IF(end_time_type='duration', " . CURRENT_TIME . "+duration*86400, end_time))), 
			end_time_type, duration, 1, 
			fb_decrement_amount, fb_decrement_interval, auction_id  
			FROM " . DB_PREFIX . "bulk_listings WHERE owner_id='" . $owner_id . "'" . $where);		
		
		$sql_select_listings = $this->db->query("SELECT a.*, 
			b.images_details, b.media_details, b.dd_details, b.custom_fields_details 
			FROM " . DB_PREFIX . "auctions a 
  			LEFT JOIN " . DB_PREFIX . "bulk_listings b ON b.auction_id=a.bulk_id 
			WHERE a.owner_id='" . $owner_id . "' AND a.bulk_list=1");
		
		$this->item = new item();
		$this->item->setts = &$this->setts;
		
		$this->fees = new fees();
		$this->fees->setts = &$this->setts;
		$this->fees->bulk_lister = true;
		
		$total_fees = 0;
		$total_items = 0;		
		$bulk_list = array();
		while ($item_details = $this->db->fetch_array($sql_select_listings))
		{
			$total_items ++;
			$bulk_list[] = $item_details['auction_id'];
			
			// first we upload the media
			$this->uploadMedia($item_details);
			
			// then we add custom fields 
			$this->uploadCustomFields($item_details['custom_fields_details'], $item_details['auction_id'], $item_details['category_id']);
			
			$this->item->auction_approval($item_details, $owner_id, true);			
			
			$fee_output = $this->fees->setup($user_details, $item_details);
			$total_amount += $fee_output['amount'];
			$user_details['balance'] += $fee_output['amount'];
			
			$auction_id = array($item_details['auction_id']);
			$this->resetBulkFlag($auction_id);
		}
		
		$this->removeRows($ids_remove, $all);		
		
		return 'The import was successful.<br>A total of <b>' . $total_items . '</b> items have been imported.<br>A total of <b>' . $this->fees->display_amount($total_amount, null, true) . '</b> in listing fees have been applied.';
	}
}
?>