<?
/* file version -> 6.10 */

$imgarrow = "<img src='themes/".$setts['default_theme']."/img/arrow.gif' width='9' height='9' hspace='4'>";
$imgarrow2 = "<img src='themes/".$setts['default_theme']."/img/arrowb.gif' width='8' height='8' hspace='4'>1";
$imgarrowit = "<img src='themes/".$setts['default_theme']."/img/arr_it.gif' width='11' height='11' hspace='4' align='absmiddle'>";
$imgwarning = "<img src='themes/".$setts['default_theme']."/img/warning.gif' width='11' height='11' hspace='4'>";
$imgarrwhite = "<img src='themes/".$setts['default_theme']."/img/arrow1.gif' width='9' height='9' hspace='2' align='absmiddle'>";
$imgarritem = "";


function header1($head_title) {
	global $setts;
	return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #6a7c03;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/feat_head.gif' width='35' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/feat_head_bg.gif' valign='bottom' style='padding-left: 5px; padding-bottom: 3px;'><b style='color: #404b02; font-size: 12px;'>$head_title</b></td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/feat_head_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}

function header2($head_title) {
global $setts;
return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #9c9c9c;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/5_start.gif' width='5' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/5_bg.gif' valign='bottom' style='padding-left: 5px; padding-bottom: 3px;'><b style='color: #333333; font-size: 12px;'>$head_title</b></td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/5_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}

function header3($head_title) {
global $setts;
return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #9c9c9c;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/5_start.gif' width='5' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/5_bg.gif' valign='bottom' style='padding-left: 5px; padding-bottom: 3px;'><b style='color: #333333; font-size: 12px;'>$head_title</b></td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/5_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}

function header4($head_title) {
global $setts;
return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #9c9c9c;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/5_start.gif' width='5' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/5_bg.gif' valign='bottom' style='padding-left: 5px; padding-bottom: 3px;'><b style='color: #333333; font-size: 12px;'>$head_title</b></td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/5_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}

function header5($head_title) {
	global $setts;
	return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #9c9c9c;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/5_start.gif' width='5' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/5_bg.gif' valign='bottom' style='padding-left: 5px; padding-bottom: 3px;'><b style='color: #333333; font-size: 12px;'>$head_title</b></td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/5_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}

function header6($head_title) {
	global $setts;
	return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #c05703;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/news_head.gif' width='35' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/news_head_bg.gif' valign='bottom' style='padding-left: 5px; padding-bottom: 3px;'><b style='color: #723402; font-size: 12px;'>$head_title</b></td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/news_head_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}

function header7($head_title) {
	global $setts;
	return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #6a7c03;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/mem_head.gif' width='28' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/feat_head_bg.gif' valign='bottom' style='padding-left: 5px; padding-bottom: 3px;'><b style='color: #404b02; font-size: 12px;'>$head_title</b></td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/feat_head_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}
function headercat($head_title) {
	global $setts;
	return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #b68500;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/cat_head.gif' width='35' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/cat_head_bg.gif' valign='bottom' class='cathead' style='padding-left: 5px; padding-bottom: 3px;'>$head_title</td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/cat_head_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}

function headerdetails($head_title) {
	global $setts;
	return "<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #a6a6a6;'>
        <tr>
        <td width='30'><img src='themes/".$setts['default_theme']."/img/det_start.gif' width='35' height='30' align='absmiddle'></td>
        <td width='100%' background='themes/".$setts['default_theme']."/img/det_bg.gif' valign='bottom' class='cathead' style='padding-left: 5px; padding-bottom: 3px;'>$head_title</td>
        <td width='5'><img src='themes/".$setts['default_theme']."/img/det_end.gif' width='5' height='30' align='absmiddle'></td>
        </tr>
        </table>";
}
$template->set('imgarrow', $imgarrow);

(string) $header_cell_width = null;
(int) $nb_header_buttons = 4;

## generate links
## -> index page
$index_link = process_link('index');
$template->set('index_link', $index_link);

if ($session->value('user_id'))
{
	$template->set('register_btn_msg', MSG_BTN_MEMBERS_AREA);
	$template->set('register_link', process_link('members_area'));

	$template->set('login_btn_msg', MSG_BTN_LOGOUT);
	$template->set('login_link', process_link('index', array('option' => 'logout')));
}
else
{
	$template->set('register_btn_msg', MSG_BTN_REGISTER);
	$template->set('register_link', process_link('register'));

	$template->set('login_btn_msg', MSG_BTN_LOGIN);
	$template->set('login_link', process_link('login'));
}


if (!$setts['enable_private_site'] || $session->value('is_seller'))
{
	$nb_header_buttons++;

	$template->set('place_ad_btn_msg', MSG_SELL_ITEM);

	if (!$session->value('user_id'))
	{
		$template->set('place_ad_link', process_link('login', array('redirect' => 'sell_item')));
	}
	else
	{
		$template->set('place_ad_link', process_link('sell_item', array('option' => 'new_item')));
	}
}

## display header banner
$site_banner = new banner();
$site_banner->setts = &$setts;

$template->set('banner_header_content', $site_banner->select_banner($_SERVER['PHP_SELF'], intval($_REQUEST['parent_id']), intval($_REQUEST['auction_id'])));

if ($setts['enable_stores'])
{
	$nb_header_buttons++;
}

if ($setts['enable_reverse_auctions'])
{
	$nb_header_buttons++;
}

if ($setts['enable_wanted_ads'])
{
	$nb_header_buttons++;
}

if ($layout['enable_site_fees_page'])
{
	$nb_header_buttons++;
}

$template->set('header_cell_width', round(100 / $nb_header_buttons) . '%');
?>