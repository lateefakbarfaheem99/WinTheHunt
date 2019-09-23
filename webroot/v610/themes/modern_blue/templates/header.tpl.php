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
.top {	background-image:  url(themes/<?=$setts['default_theme'];?>/img/menubg.gif); }
.topic_id { 
	background-image:  url(themes/<?=$setts['default_theme'];?>/img/arrow.gif);
	background-repeat: no-repeat;
	background-position: 3px 3px;
	 }
-->
</style>

</head>
<body bgcolor="#ffffff" leftmargin="2" topmargin="2" marginwidth="2" marginheight="2">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr height="65">
      <td><a href="index.php"><img src="images/probidlogo.gif" border="0"></a></td>
      <td width="100%" align="right"><?=$banner_header_content;?></td>
   </tr>
</table>
<table border="0" cellpadding="2" cellspacing="2" width="100%" style="border-top: 1px solid black;">
   <tr align="center" height="40" style="border-top: 1px solid black;">
      <td nowrap class="top">&nbsp;<a href="<?=$index_link;?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_home.gif" border="0"></a>&nbsp;</td>
      <? if (!$setts['enable_private_site'] || $is_seller) { ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=$place_ad_link;?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_sell.gif" border="0"></a></td>
      <? } ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=$register_link;?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_register.gif" border="0"></a></td>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=$login_link;?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_login.gif" border="0"></a></td>
      <? if ($setts['enable_stores']) { ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=process_link('stores');?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_store.gif" border="0"></a></td>
      <? } ?>
      <? if ($setts['enable_reverse_auctions']) { ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=process_link('reverse_auctions');?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_reverse.gif" border="0"></a></td>
      <? } ?>
      <? if ($setts['enable_wanted_ads']) { ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=process_link('wanted_ads');?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_ads.gif" border="0"></a></td>
      <? } ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'help'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_help.gif" border="0"></a></td>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'faq'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_faq.gif" border="0"></a></td>
      <? if ($layout['enable_site_fees_page']) { ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=process_link('site_fees');?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_fees.gif" border="0"></a></td>
      <? } ?>
      <? if ($layout['is_about']) { ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'about_us'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_about.gif" border="0"></a></td>
      <? } ?>
      <? if ($layout['is_contact']) { ?>
      <td nowrap class="top" width="<?=$header_cell_width;?>"><a href="<?=process_link('content_pages', array('page' => 'contact_us'));?>"><img src="themes/<?=$setts['default_theme'];?>/img/i_contact.gif" border="0"></a></td>
      <? } ?>
   </tr>
   <tr align="center">
      <td nowrap class="bordermenu">&nbsp;<a href="<?=$index_link;?>">
         <?=MSG_BTN_HOME;?>
         </a>&nbsp;</td>
      <? if (!$setts['enable_private_site'] || $is_seller) { ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=$place_ad_link;?>">
         <?=$place_ad_btn_msg;?>
         </a>&nbsp;</td>
      <? } ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=$register_link;?>">
         <?=$register_btn_msg;?>
         </a>&nbsp;</td>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=$login_link;?>">
         <?=$login_btn_msg;?>
         </a>&nbsp;</td>
      <? if ($setts['enable_stores']) { ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=process_link('stores');?>">
         <?=MSG_BTN_STORES;?>
         </a>&nbsp;</td>
      <? } ?>
      <? if ($setts['enable_reverse_auctions']) { ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=process_link('reverse_auctions');?>">
         <?=MSG_REVERSE;?>
         </a>&nbsp;</td>
      <? } ?>
      <? if ($setts['enable_wanted_ads']) { ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=process_link('wanted_ads');?>">
         <?=MSG_BTN_WANTED_ADS;?>
         </a>&nbsp;</td>
      <? } ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=process_link('content_pages', array('page' => 'help'));?>">
         <?=MSG_BTN_HELP;?>
         </a>&nbsp;</td>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=process_link('content_pages', array('page' => 'faq'));?>">
         <?=MSG_BTN_FAQ;?>
         </a>&nbsp;</td>
      <? if ($layout['enable_site_fees_page']) { ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=process_link('site_fees');?>">
         <?=MSG_BTN_SITE_FEES;?>
         </a>&nbsp;</td>
      <? } ?>
      <? if ($layout['is_about']) { ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=process_link('content_pages', array('page' => 'about_us'));?>">
         <?=MSG_BTN_ABOUT_US;?>
         </a>&nbsp;</td>
      <? } ?>
      <? if ($layout['is_contact']) { ?>
      <td nowrap class="bordermenu" width="<?=$header_cell_width;?>">&nbsp;<a href="<?=process_link('content_pages', array('page' => 'contact_us'));?>">
         <?=MSG_BTN_CONTACT_US;?>
         </a>&nbsp;</td>
      <? } ?>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="2">
   <tr>
      <td bgcolor="#e9e9eb" style="border-top: 2px solid #003C85; border-bottom: 1px solid #aaaaaa;"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="194" nowrap align="center" class="search">&nbsp;&nbsp;&nbsp;
                  <?=$current_date;?>
                  <span id="servertime"></span></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/sep.gif"></td>
               <form action="auction_search.php" method="post">
                  <input type="hidden" name="option" value="basic_search">
                  <td class="search" nowrap>&nbsp;
                     <?=strtoupper(GMSG_SEARCH);?>
                     &nbsp;</td>
                  <td class="search" nowrap><input type="text" size="25" name="basic_search">
                     &nbsp;</td>
                  <td class="search" nowrap><input name="form_basic_search" type="submit" value="<?=GMSG_SEARCH;?>">
                     &nbsp;&nbsp;</td>
               </form>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/sep.gif"></td>
               <td class="search" nowrap>&nbsp;&nbsp;
                  <?=strtoupper(GMSG_BROWSE);?>
                  &nbsp;</td>
               <form name="cat_browse_form" method="get" action="categories.php">
                  <td class="search" style="padding-right: 10px;"><?=$categories_browse_box;?></td>
               </form>
               <td width="100%" class="search" nowrap>&nbsp;&nbsp;<a href="<?=process_link('search');?>">
                  <?=strtoupper(GMSG_ADVANCED_SEARCH);?>
                  </a>&nbsp;&nbsp;</td>
               <? if ($setts['enable_addthis']) { ?>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/sep.gif"></td>
               <td nowrap align="center">&nbsp;
                  <?=$share_code;?>
                  &nbsp;</td>
               <? } ?>
               <? if ($setts['user_lang']) { ?>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/sep.gif"></td>
               <td nowrap align="center">&nbsp;
                  <?=$languages_list;?>
                  &nbsp;</td>
               <? } ?>
            </tr>
         </table></td>
   </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr valign="top">
  	<? if (!in_array($page_file_name, $browse_pages)) { ?>
   <td width="180"><script language="javascript">
					var ie4 = false; if(document.all) { ie4 = true; }
					function getObject(id) { if (ie4) { return document.all[id]; } else { return document.getElementById(id); } }
					function toggle(link, divId) { var lText = link.innerHTML; var d = getObject(divId);
					if (lText == '+') { link.innerHTML = '&#8211;'; d.style.display = 'block'; }
					else { link.innerHTML = '+'; d.style.display = 'none'; } }
				</script>
      <? if ($is_announcements && $member_active == 'Active') { ?>
      <?=$announcements_box_header;?>
      <div id="exp1102170555">
         <?=$announcements_box_content;?>
      </div>
      <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
      <? } ?>
      <?=$menu_box_header;?>
		<div id="exp1102170142">
         <?=$menu_box_content;?>
		</div>
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
      <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="180" height="1"></div>
      <div align="center"><a href="rss_feed.php"><img src="themes/<?=$setts['default_theme'];?>/img/system/rss.gif" border="0" alt="" align="absmiddle"></a></div>
		<? if ($setts['enable_skin_change']) { ?>
		<form action="index.php" method="GET">
			<div align="center">
				<?=MSG_CHOOSE_SKIN;?>:<br>
				<?=$site_skins_dropdown;?>
				<input type="submit" name="change_skin" value="<?=GMSG_GO;?>">
			</div>   				
		</form>
		<? } ?></td>
   <td background="themes/<?=$setts['default_theme'];?>/img/vline.gif"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="7" height="1"></td>
   <? } ?>
   <td width="100%">
