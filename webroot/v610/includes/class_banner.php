<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class banner extends database
{
	function insert_banner($variables_array)
	{
		$post_details = $this->rem_special_chars_array($variables_array);

		$result = $this->query("INSERT INTO " . DB_PREFIX . "adverts
			(advert_url, advert_img_path, advert_alt_text, advert_text_under, views_purchased, clicks_purchased,
			advert_categories, advert_code, advert_type, section_id) VALUES
			('" . $post_details['advert_url'] . "', '" . get_main_image($variables_array['ad_image']) . "',
			'" . $post_details['advert_alt_text'] . "', '" . $post_details['advert_text_under'] . "',
			'" . $post_details['views_purchased'] . "', '" . $post_details['clicks_purchased'] . "',
			'" . $this->implode_array($variables_array['categories_id']) . "', '" . $post_details['advert_code'] . "',
			'" . $post_details['advert_type'] . "', '" . $post_details['section_id'] . "')");

		return $result;
	}

	function edit_banner($variables_array, $advert_id)
	{
		$post_details = $this->rem_special_chars_array($variables_array);

		$result = $this->query("UPDATE " . DB_PREFIX . "adverts SET
			advert_url='" . $post_details['advert_url'] . "', advert_img_path='" . get_main_image($variables_array['ad_image']) . "',
			advert_alt_text='" . $post_details['advert_alt_text'] . "',	advert_text_under='" . $post_details['advert_text_under'] . "',
			views_purchased='" . $post_details['views_purchased'] . "',	clicks_purchased='" . $post_details['clicks_purchased'] . "',
			advert_categories='" . $this->implode_array($variables_array['categories_id']) . "', advert_code='" . $post_details['advert_code'] . "',
			advert_type='" . $post_details['advert_type'] . "', section_id='" . $post_details['section_id'] . "' WHERE advert_id='" . $advert_id . "'");

		return result;
	}

	function delete_banner($advert_id)
	{
		$result = $this->query("DELETE FROM " . DB_PREFIX . "adverts WHERE advert_id='" . $advert_id . "'");

		return $result;
	}

	function banner_details($advert_row)
	{
		(string) $display_output = null;

		if ($advert_row['advert_type'] == 1)
		{
			$display_output .= GMSG_CLICKS . ': <b>' . $advert_row['clicks'] . '</b><br>'.
				GMSG_CLICKS_PURCHASED . ': <b>' . (($advert_row['clicks_purchased']) ? $advert_row['clicks_purchased'] : GMSG_NA) . '</b><br>';
		}

		$display_output .= GMSG_VIEWS . ': <b>' . $advert_row['views'] . '</b><br>'.
			GMSG_VIEWS_PURCHASED . ': <b>' . (($advert_row['views_purchased']) ? $advert_row['views_purchased'] : GMSG_NA) . '</b>';

		return $display_output;

	}

	function display_banner($advert_row, $in_admin = false)
	{
		(string) $display_output = null;

		$relative_path = ($in_admin && stristr($advert_row['advert_img_path'], 'http') === false) ? '../' : '';

		if (!$in_admin)
		{
			$add_view = $this->query("UPDATE " . DB_PREFIX . "adverts SET views=views+1 WHERE advert_id='" . $advert_row['advert_id'] . "'");
		}

		if ($advert_row['advert_type'] == 1) // custom advert
		{
			$display_output = '<table cellpadding="1" cellspacing="0"><tr><td align="center"><a href="banner_click.php?advert_id=' . $advert_row['advert_id'] . '" target="_blank">'.
				'<img src="' . $relative_path . $this->add_special_chars($advert_row['advert_img_path']) . '" border="0" alt="' . $advert_row['advert_alt_text'] . '"></a></td></tr>';

			$display_output .= ($advert_row['advert_text_under']) ? '<tr><td align="center">' . $advert_row['advert_text_under'] . '</td></tr>' : '';

			$display_output .= '</table>';
		}
		else if ($advert_row['advert_type'] == 2) // code advert
		{
			$display_output = $this->add_special_chars($advert_row['advert_code']);
		}

		return $display_output;

	}

	function select_banner($base_url, $parent_id, $auction_id, $section_id = 0)
	{
		(string) $display_output = null;
		(string) $advert_query = null;

		$ssl_url_simple = array('login', 'register');
		$ssl_url_enhanced = array('login', 'register', 'members_area', 'sell_item', 'edit_item', 'fee_payment', 'wanted_manage');
		
		$ssl_url_array = ($this->setts['enable_enhanced_ssl']) ? $ssl_url_enhanced : $ssl_url_simple;
		
		$advert_query = "WHERE (views_purchased=0 OR views_purchased>=views) AND
			(clicks_purchased=0 OR clicks_purchased>=clicks) AND section_id='" . intval($section_id) . "'";

		if ($this->setts['is_ssl'])
		{
			foreach ($ssl_url_array as $value)
			{
				if (stristr($base_url, $value))
				{
					$advert_query .= " AND advert_type=1";
				}
			}			
		}

		if (stristr($base_url, 'categories.php'))
		{
			$category_id = $this->main_category($parent_id);
			$advert_query_cats = " AND (LOCATE('," . $category_id . ",', CONCAT(',',advert_categories,','))>0 OR advert_categories='0')";

			$is_advert = $this->count_rows('adverts', $advert_query . $advert_query_cats);

			if ($is_advert)
			{
				$advert_query .= $advert_query_cats;
			}
			else 
			{
				$advert_query .= " AND advert_categories='0'";
			}
			
		}		
		else if (stristr($base_url, 'auction_details.php'))
		{
			
			$item_details = $this->get_sql_row("SELECT category_id, addl_category_id FROM " . DB_PREFIX . "auctions WHERE
				auction_id='" . $auction_id . "'");

			$category_id = $this->main_category($item_details['category_id']);
			$addl_category_id = $this->main_category($item_details['addl_category_id']);

			$advert_query_details = " AND (LOCATE('," . $category_id . ",', CONCAT(',',advert_categories,','))>0";

			if ($addl_category_id>0)
			{
				$advert_query_details .= " OR LOCATE('," . $addl_category_id . ",', CONCAT(',',advert_categories,','))>0";
			}

			$advert_query_details .= " OR advert_categories='0')";

			$is_advert = $this->count_rows('adverts', $advert_query . $advert_query_details);

			if ($is_advert)
			{
				$advert_query .= $advert_query_details;
			}
			else 
			{
				$advert_query .= " AND advert_categories='0'";
			}
		}
		else 
		{
			$advert_query .= " AND advert_categories='0'";
		}

		//$select_condition = $this->implode_array($advert_query, ' AND ');

		$advert_details = $this->random_rows('adverts', '*', $advert_query, 1);

		$display_output = $this->display_banner($advert_details[0]);


		return $display_output;
	}
}

?>