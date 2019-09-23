<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');
include_once ('includes/class_formchecker.php');
include_once ('includes/class_custom_field.php');
include_once ('includes/class_fees.php');
include_once ('includes/class_item.php');
include_once ('includes/class_currency_converter.php');

update_currency_data($currencies, $setts['currency']);

$page_header = $template->process('empty_header.tpl.php');
$template->set('page_header', $page_header);

$page_footer = $template->process('empty_footer.tpl.php');
$template->set('page_footer', $page_footer);

$template->set('amount', $_REQUEST['amount']);

$item = new item();
$item->setts = &$setts;
$item->layout = &$layout;

$currency_from = ($_REQUEST['currency_from']) ? $_REQUEST['currency_from'] : $_REQUEST['currency'];
$currency_to = ($_REQUEST['currency_to']) ? $_REQUEST['currency_to'] : '';

if (isset($_REQUEST['form_convert']))
{
	$currency_from_value = $db->get_sql_field("SELECT convert_rate FROM " . DB_PREFIX . "currencies WHERE symbol='" . $db->rem_special_chars($currency_from) . "'", 'convert_rate');
	$currency_to_value = $db->get_sql_field("SELECT convert_rate FROM " . DB_PREFIX . "currencies WHERE symbol='" . $db->rem_special_chars($currency_to) . "'", 'convert_rate');

	$converter_result = $_REQUEST['amount'] * $currency_to_value / $currency_from_value;

	$converter_result_box = '<tr> '.
		'	<td colspan="3" style="font-size=16px; font-weight: bold;" align="center">' . $fees->display_amount($_REQUEST['amount'], $_REQUEST['currency_from']) . ' = ' .
		'		' . $fees->display_amount($converter_result, $_REQUEST['currency_to']) . '</td> '.
   	'</tr> '.
   	'<tr> '.
      '	<td colspan="3" class="c4"></td> '.
   	'</tr> ';

   $template->set('converter_result_box', $converter_result_box);
}

$template->set('currency_from_box', $item->currency_drop_down('currency_from', $currency_from, 'currency_converter_form'));
$template->set('currency_to_box', $item->currency_drop_down('currency_to', $currency_to, 'currency_converter_form'));

$template_output .= $template->process('currency_converter.tpl.php');

echo $template_output;
?>