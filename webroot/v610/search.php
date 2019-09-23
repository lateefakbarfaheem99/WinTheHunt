<?
#################################################################
## PHP Pro Bid v6.01															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');

include_once ('global_header.php');

$option = $db->rem_special_chars($_REQUEST['option']);
$option = (empty($option)) ? 'auction_search' : $option;
$template->set('option', $option);

$item_details = $db->rem_special_chars_array($_POST);
$template->set('item_details', $item_details);

$header_search_page = header5(GMSG_ADVANCED_SEARCH);
$template->set('header_search_page', $header_search_page);

if ($_REQUEST['search_empty'] == 1)
{
	$template->set('no_results_message', '<p align="center" class="errormessage">' . MSG_NO_RESULTS_QUERY . '</p>');
}

(string) $search_options_menu = null;
$search_options_menu .= display_link(process_link('search', array('option' => 'auction_search')), MSG_AUCTION_SEARCH, (($option == 'auction_search') ? false : true)) . ' | ';
$search_options_menu .= display_link(process_link('search', array('option' => 'seller_search')), MSG_SELLER_SEARCH, (($option == 'seller_search') ? false : true)) . ' | ';
$search_options_menu .= display_link(process_link('search', array('option' => 'buyer_search')), MSG_BUYER_SEARCH, (($option == 'buyer_search') ? false : true));

if ($setts['enable_stores']) 
{
	$search_options_menu .=  ' | ' . display_link(process_link('search', array('option' => 'store_search')), MSG_STORE_SEARCH, (($option == 'store_search') ? false : true));
}

$template->set('search_options_menu', $search_options_menu);

switch ($option)
{
	case 'auction_search':
		$search_options_title = MSG_AUCTION_SEARCH;
		
		$custom_fld = new custom_field();
		
		$custom_fld->new_table = false;
		$custom_fld->field_colspan = 2;
		$custom_fld->box_search = 1;
		$custom_sections_table = $custom_fld->display_sections($item_details, 'auction', false, 1, 0);
		$template->set('custom_sections_table', $custom_sections_table);

		$tax = new tax();		
		$template->set('country_dropdown', $tax->countries_dropdown('country', $item_details['country'], null, '', true));
		//$template->set('state_box', $tax->states_box('state', $item_details['state'], $item_details['country']));
		break;
	case 'seller_search':
		$search_options_title = MSG_SELLER_SEARCH;
		break;
	case 'buyer_search':
		$search_options_title = MSG_BUYER_SEARCH;
		break;
	case 'store_search':
		$search_options_title = MSG_STORE_SEARCH;
		break;
}
$template->set('search_options_title', $search_options_title);

$template_output .= $template->process('search.tpl.php');

include_once ('global_footer.php');

echo $template_output;

?>