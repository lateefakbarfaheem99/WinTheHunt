<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class site_content extends database
{
	function subpage_title($page_handle)
	{
		(string) $output = null;

		switch ($page_handle)
		{
			case 'help': $output = AMSG_EDIT_HELP_SECTION;
				break;
			case 'news': $output = AMSG_EDIT_NEWS_SECTION;
				break;
			case 'faq': $output = AMSG_EDIT_FAQ_SECTION;
				break;
			case 'custom_page': $output = AMSG_CUSTOM_PAGES_MANAGEMENT;
				break;
			case 'about_us': $output = AMSG_EDIT_ABOUT_US_PAGE;
				break;
			case 'contact_us': $output = AMSG_EDIT_CONTACT_US_PAGE;
				break;
			case 'terms': $output = AMSG_EDIT_TERMS_PAGE;
				break;
			case 'privacy': $output = AMSG_EDIT_PRIVACY_PAGE;
				break;
			case 'announcements': $output = AMSG_EDIT_MEMBERS_ANNOUNCEMENTS;
				break;
			default:
				$output = GMSG_NA;
		}

		return $output;
	}

	function insert_topic($variables_array, $lang, $page_id, $page_handle)
	{
		$show_link = ($page_handle == 'custom_page') ? $variables_array['show_link'] : 1;
		
		$result = $this->query("INSERT INTO " . DB_PREFIX . "content_pages
			(topic_name, topic_content, topic_lang, reg_date, page_id, page_handle, show_link) VALUES
			('" . $variables_array['topic_name_' . $lang] . "', '" . $variables_array['topic_content_' . $lang] . "',
			'" . $lang . "', '" . CURRENT_TIME . "', '" . $page_id . "', '" . $page_handle . "', '" . $show_link . "')");

		return $result;
	}

	function edit_topic($variables_array, $lang, $page_id, $page_handle)
	{
		$is_topic = $this->count_rows('content_pages', "WHERE
			topic_lang='" . $lang . "' AND page_id='" . $page_id . "' AND page_handle='" . $page_handle . "'");

		if ($is_topic)
		{
			$show_link = ($page_handle == 'custom_page') ? $variables_array['show_link'] : 1;
			
			$result = $this->query("UPDATE " . DB_PREFIX . "content_pages SET
				topic_name='" . $variables_array['topic_name_' . $lang] . "',
				topic_content='" . $variables_array['topic_content_' . $lang] . "', show_link='" . $show_link . "' WHERE
				topic_lang='" . $lang . "' AND page_id='" . $page_id . "' AND page_handle='" . $page_handle . "'");
		}
		else
		{
			$result = $this->insert_topic($variables_array, $lang, $page_id, $page_handle);
		}

		return result;
	}

	function delete_topic($page_id, $page_handle)
	{
		$result = $this->query("DELETE FROM " . DB_PREFIX . "content_pages WHERE page_id='" . $page_id . "' AND page_handle='" . $page_handle . "'");

		return $result;
	}
}

?>