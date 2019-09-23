<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_shop.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_item.php');

include_once ('global_header.php');

$fees->display_free = true;

$template->set('site_fees_header_message', header5(MSG_BTN_SITE_FEES));
if (stristr($_REQUEST['category_id'], 'reverse'))
{
	list($fee_type, $category_id) = @explode('|', $_REQUEST['category_id']);
}
else
{
	$fee_type = $_REQUEST['fee_type'];
	$category_id = $_REQUEST['category_id'];
}
$category_id = intval($category_id);
$category_id = ($fee_type == 'reverse' && $category_id > 0) ? (-1) * $category_id : $category_id;
$template->set('category_id', $category_id);
$template->set('fee_type', $fee_type);

$fee_row = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "fees WHERE category_id = '" . $category_id . "'");
$template->set('fee_row', $fee_row);
      
$template->set('reverse_fees', unserialize($fee_row['reverse_fees']));

$show_categories_box = categories_list($category_id, 0, true, true, false);
$template->set('show_categories_box', $show_categories_box);

if ($show_categories_box)
{
	$template->set('fees_categories_box', categories_list($category_id, 0, true, true));
}

$sql_select_setup_fees = $db->query("SELECT * FROM " . DB_PREFIX . "fees_tiers WHERE 
	fee_type='setup' AND category_id='" . $category_id . "' ORDER BY fee_from ASC");

$is_setup_fee = $db->num_rows($sql_select_setup_fees);
$template->set('is_setup_fee', $is_setup_fee);

(string) $listing_fees_table = null;
while ($tier_details = $db->fetch_array($sql_select_setup_fees)) 
{
	$background = ($counter++%2) ? 'c1' : 'c2';
	
	$listing_fees_table .= '<tr class="' . $background . '"> '.
		'	<td width="100%">' . MSG_FROM . ' <b>' . $fees->display_amount($tier_details['fee_from']) . '</b> ' . MSG_TO . ' <b>' . $fees->display_amount($tier_details['fee_to']) . '</b></td> '.
		'	<td nowrap>' . (($tier_details['calc_type'] == 'flat') ? $fees->display_amount($tier_details['fee_amount']) : $tier_details['fee_amount'] . '%') . '</td> '.
		'</tr> ';
}

$template->set('listing_fees_table', $listing_fees_table);
            
$sql_select_stores = mysql_query("SELECT * FROM " . DB_PREFIX . "fees_tiers WHERE 
	fee_type='store' ORDER BY fee_amount ASC"); 

$is_stores = $db->num_rows($sql_select_stores);
$template->set('is_stores', $is_stores);

(string) $store_subscriptions_table = null;

$shop = new shop();
$shop->setts = &$setts;
$shop->user_id = 0;

while ($store_details = $db->fetch_array($sql_select_stores)) 
{
	$background = ($counter++%2) ? 'c1' : 'c2';

	$store_subscriptions_table .= '<tr class="' . $background . '"> '.
		'	<td class="contentfont"><strong>' . $store_details['store_name'] . '</strong></td> '.
		'	<td class="contentfont">' . $shop->shop_description($store_details, false) . '</td> '.
   	'</tr> ';
}

$template->set('store_subscriptions_table', $store_subscriptions_table);

$sql_select_sale_fees = $db->query("SELECT * FROM " . DB_PREFIX . "fees_tiers WHERE 
	fee_type='endauction' AND category_id='" . $category_id . "' ORDER BY fee_from ASC");

$is_sale_fee = $db->num_rows($sql_select_sale_fees);
$template->set('is_sale_fee', $is_sale_fee);

(string) $sale_fees_table = null;
while ($tier_details = $db->fetch_array($sql_select_sale_fees)) 
{
	$background = ($counter++%2) ? 'c1' : 'c2';
	
	$sale_fees_table .= '<tr class="' . $background . '"> '.
		'	<td width="100%">' . MSG_FROM . ' <b>' . $fees->display_amount($tier_details['fee_from']) . '</b> ' . MSG_TO . ' <b>' . $fees->display_amount($tier_details['fee_to']) . '</b></td> '.
		'	<td nowrap>' . (($tier_details['calc_type'] == 'flat') ? $fees->display_amount($tier_details['fee_amount']) : $tier_details['fee_amount'] . '%') . '</td> '.
		'</tr> ';
}

$template->set('sale_fees_table', $sale_fees_table);

$sql_select_reverse_sale_fees = $db->query("SELECT * FROM " . DB_PREFIX . "fees_tiers WHERE 
	fee_type='reverse_endauction' AND category_id='" . $category_id . "' ORDER BY fee_from ASC");

$is_reverse_sale_fee = $db->num_rows($sql_select_reverse_sale_fees);
$template->set('is_reverse_sale_fee', $is_reverse_sale_fee);

(string) $reverse_sale_fees_table = null;
while ($tier_details = $db->fetch_array($sql_select_reverse_sale_fees)) 
{
	$background = ($counter++%2) ? 'c1' : 'c2';
	
	$reverse_sale_fees_table .= '<tr class="' . $background . '"> '.
		'	<td width="100%">' . MSG_FROM . ' <b>' . $fees->display_amount($tier_details['fee_from']) . '</b> ' . MSG_TO . ' <b>' . $fees->display_amount($tier_details['fee_to']) . '</b></td> '.
		'	<td nowrap>' . (($tier_details['calc_type'] == 'flat') ? $fees->display_amount($tier_details['fee_amount']) : $tier_details['fee_amount'] . '%') . '</td> '.
		'</tr> ';
}

$template->set('reverse_sale_fees_table', $reverse_sale_fees_table);

if ($setts['enable_tax'])
{
	$tax = new tax();
	$tax_settings = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "tax_settings WHERE site_tax = 1");
	
	$tax_message = $tax_settings['amount'] . '% ' . $tax_settings['tax_name'] . ' ' . MSG_WILL_BE_APPLIED_TO_USERS_FROM . ' ' . $tax->display_countries($tax_settings['countries_id']);
	$template->set('tax_message', $tax_message);
	$template->set('tax_amount', $tax_settings['amount']);
}

$item = new item();
$item->setts = &$setts;

$durations_output = $item->durations_drop_down(null, null, null, null, $category_id, false);
$template->set('durations_output', $durations_output);

$template_output .= $template->process('site_fees.tpl.php');

include_once ('global_footer.php');

echo $template_output;

?>