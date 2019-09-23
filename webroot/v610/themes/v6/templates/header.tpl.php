<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>
<?=$page_title;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CODEPAGE;?>">
<?=$page_meta_tags;?>
<link href="themes/<?=$setts['default_theme'];?>/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.catfeatc3 { 
background-image:  url(themes/<?=$setts['default_theme'];?>/img/menuico.gif);
background-repeat: no-repeat;
background-position: 3px 7px;
padding-left: 17px;
} 
.catfeatpic {
background-image:  url(themes/<?=$setts['default_theme'];?>/img/fbg.gif);
background-repeat:repeat-x;
}
.topic_id { 
	background-image:  url(themes/<?=$setts['default_theme'];?>/img/ico_m.gif);
	background-repeat: no-repeat;
	background-position: 0px 0px;
	 }
-->
</style>

</head>
<body bgcolor="#ffffff" leftmargin="10" topmargin="5" marginwidth="10" marginheight="5">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
   <td width="100%"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="themes/<?=$setts['default_theme'];?>/img/headbg.gif">
         <tr valign="top" height="97">
            <td width="31" style="padding-top: 74px;"><a href="index.php"><img src="themes/<?=$setts['default_theme'];?>/img/homeico.gif" alt="Professional Auction Script Software by PHP Pro Bid" width="31" height="11" border="0"></a></td>
            <td width="260" style="background-image:url(themes/<?=$setts['default_theme'];?>/img/logo_bg.gif); background-repeat: no-repeat;" align="center" valign="middle"><div><a href="index.php"><a href="<?=$index_link;?>"><img src="images/probidlogo.gif" alt="Professional Auction Script Software by PHP Pro Bid" border="0"></a></div>
               <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="260" height="6"></div></td>
            <td width="100%" class="toplink" style="padding-top: 29px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr valign="top" align="left">
                     <td width="5"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="5" height="1"></td>
                     <? if (stristr($_SERVER['PHP_SELF'], "index.php")) { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=$index_link;?>">
                        <?=MSG_BTN_HOME;?>
                        </a>&nbsp;</td>
                     <? } else {?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" border="0" name="home" id="home"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=$index_link;?>" onMouseOver="MM_swapImage('home','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=MSG_BTN_HOME;?>
                        </a>&nbsp;</td>
                     <? }  
							if (!$setts['enable_private_site'] || $is_seller)  { 
								if (stristr($_SERVER['PHP_SELF'], "sell_item.php")) { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=$place_ad_link;?>">
                        <?=$place_ad_btn_msg;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="sell" id="sell"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=$place_ad_link;?>" onMouseOver="MM_swapImage('sell','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=$place_ad_btn_msg;?>
                        </a>&nbsp;</td>
                     <? } 
							} 
				  	 		if (stristr($_SERVER['PHP_SELF'], "members_area.php")||stristr($_SERVER['PHP_SELF'], "register.php")) { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=$register_link;?>">
                        <?=$register_btn_msg;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="reg" id="reg"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=$register_link;?>" onMouseOver="MM_swapImage('reg','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=$register_btn_msg;?>
                        </a>&nbsp;</td>
                     <? } if (stristr($_SERVER['PHP_SELF'], "login.php")) { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=$login_link;?>">
                        <?=$login_btn_msg;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="login" id="login"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=$login_link;?>" onMouseOver="MM_swapImage('login','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=$login_btn_msg;?>
                        </a>&nbsp;</td>
                     <? } if ($setts['enable_stores']) {	
                     		if (stristr($_SERVER['PHP_SELF'], "stores.php")) { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=process_link('stores');?>">
                        <?=MSG_BTN_STORES;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="store" id="store"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=process_link('stores');?>" onMouseOver="MM_swapImage('store','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=MSG_BTN_STORES;?>
                        </a>&nbsp;</td>
                     <? } }  if ($setts['enable_reverse_auctions']) {	if (stristr($_SERVER['PHP_SELF'], "reverse_auctions.php")) { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=process_link('reverse_auctions');?>">
                        <?=MSG_REVERSE;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="reverse" id="reverse"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=process_link('reverse_auctions');?>" onMouseOver="MM_swapImage('reverse','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=MSG_REVERSE;?>
                        </a>&nbsp;</td>
                     <? } } if ($setts['enable_wanted_ads']) { if (stristr($_SERVER['PHP_SELF'], "wanted_ads.php")) { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=process_link('wanted_ads');?>">
                        <?=MSG_BTN_WANTED_ADS;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="wanted" id="wanted"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=process_link('wanted_ads');?>" onMouseOver="MM_swapImage('wanted','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=MSG_BTN_WANTED_ADS;?>
                        </a>&nbsp;</td>
                     <? } } if ($_REQUEST['page']=='help') { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'help'));?>">
                        <?=MSG_BTN_HELP;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="help" id="help"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'help'));?>" onMouseOver="MM_swapImage('help','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=MSG_BTN_HELP;?>
                        </a>&nbsp;</td>
                     <? } if ($layout['enable_site_fees_page']) { if (stristr($_SERVER['PHP_SELF'], "site_fees.php")) { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=process_link('site_fees');?>">
                        <?=MSG_BTN_SITE_FEES;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="fees" id="fees"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=process_link('site_fees');?>" onMouseOver="MM_swapImage('fees','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=MSG_BTN_SITE_FEES;?>
                        </a>&nbsp;</td>
                     <? } } if ($layout['is_about']) { if ($_REQUEST['page']=='about_us') { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'about_us'));?>">
                        <?=MSG_BTN_ABOUT_US;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="about" id="about"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'about_us'));?>" onMouseOver="MM_swapImage('about','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=MSG_BTN_ABOUT_US;?>
                        </a>&nbsp;</td>
                     <? } }
							if ($layout['is_contact']) { if ($_REQUEST['page']=='contact_us') { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/db_bg.gif" width="16" height="30"></td>
                     <td nowrap class="db" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'contact_us'));?>">
                        <?=MSG_BTN_CONTACT_US;?>
                        </a>&nbsp;</td>
                     <? } else { ?>
                     <td width="16"><img src="themes/<?=$setts['default_theme'];?>/img/lb_bg.gif" width="16" height="30" name="contact" id="contact"></td>
                     <td nowrap class="lb" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'contact_us'));?>" onMouseOver="MM_swapImage('contact','','themes/<?=$setts['default_theme'];?>/img/db_bg.gif',1)" onMouseOut="MM_swapImgRestore()">
                        <?=MSG_BTN_CONTACT_US;?>
                        </a>&nbsp;</td>
                     <? } }?>
                  </tr>
               </table>
               <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="11"></div>
               <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                     <form action="auction_search.php" method="post">
                        <input type="hidden" name="option" value="basic_search">
                        <td class="search" nowrap>&nbsp;&nbsp;<a href="<?=process_link('search');?>">
                           <?=strtoupper(GMSG_SEARCH);?>
                           </a>&nbsp;&nbsp;&nbsp;</td>
                        <td class="search" nowrap><input type="text" size="25" name="basic_search">
                           &nbsp;&nbsp;&nbsp;</td>
                        <td class="search" nowrap><input name="form_basic_search" type="submit" value="<?=GMSG_SEARCH;?>">
                           &nbsp;&nbsp;&nbsp;</td>
                     </form>
                     <td class="search" nowrap style="border-left: 1px solid #dddddd;">&nbsp;&nbsp;&nbsp;
                        <?=strtoupper(GMSG_BROWSE);?>
                        &nbsp;&nbsp;</td>
                     <form name="cat_browse_form" method="get" action="categories.php">
                        <td class="search" width="100%"><?=$categories_browse_box;?></td>
                     </form>
                     <? if ($setts['enable_addthis']) { ?>
                     <td nowrap style="border-left: 1px solid #dddddd;" align="center">&nbsp;&nbsp;
                        <?=$share_code;?>
                        &nbsp;&nbsp;</td>
                     <? } ?>
                     <? if ($setts['user_lang']) { ?>
                     <td nowrap style="border-left: 1px solid #dddddd;" align="center">&nbsp;&nbsp;
                        <?=$languages_list;?>
                        &nbsp;&nbsp;</td>
                     <? } ?>
                  </tr>
               </table></td>
         </tr>
      </table>
      <br>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr valign="top">
      	<? if (!in_array($page_file_name, $browse_pages)) { ?>      	
         <td width="180"><table width="100%" border="0" cellpadding="0" cellspacing="0" height="22" bgcolor="#088ad3" background="themes/<?=$setts['default_theme'];?>/img/timebg.gif">
               <tr>
                  <td class="lb" align="center"><?=$current_date;?>
                     <span id="servertime"></span></td>
               </tr>
            </table>
            <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
            <script language="javascript">
					var ie4 = false;
                  if(document.all) {
							ie4 = true;
                  }
                  function getObject(id) {
                        if (ie4) {
                                return document.all[id];
                        } else {
                                return document.getElementById(id);
                        }
                  }

					function toggle(link, divId) {
						var lText = link.innerHTML;
						var d = getObject(divId);
                         if (lText == '+') {
                                 link.innerHTML = '&#8722;';
                                 d.style.display = 'block';
                         } else {
                                 link.innerHTML = '+';
                                 d.style.display = 'none';
                         }
					}
				</script>
            <? if ($is_announcements && $member_active == 'Active') { ?>
            <?=$announcements_box_header;?>
            <div id="exp1102170555">
               <?=$announcements_box_content;?>
            </div>
            <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
            <? } ?>
            <?=$menu_box_header;?>
            <?=$menu_box_content;?>
            <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
            <noscript>
            <?=MSG_JS_NOT_SUPPORTED;?>
            </noscript>
            <?=$category_box_header;?>
            <div id="exp1102170166">
               <?=$category_box_content;?>
            </div>
            <?=$banner_position[1];?>
            <?=$banner_position[2];?>
            <br>
            <div align="center"><a href="rss_feed.php"><img src="themes/<?=$setts['default_theme'];?>/img/system/rss.gif" border="0" alt="" align="absmiddle"></a></div>
				<? if ($setts['enable_skin_change']) { ?>
				<br>
				<form action="index.php" method="GET">
					<div align="center">
						<?=MSG_CHOOSE_SKIN;?>:<br>
						<?=$site_skins_dropdown;?>
						<input type="submit" name="change_skin" value="<?=GMSG_GO;?>">
					</div>   				
				</form>
				<? } ?>
            <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="180" height="1"></div></td>
         <td width="10"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="10" height="1"></td>
         <? } ?>
         <td width="100%">
         	<?=$banner_position[5];?>
