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

a.ln:link {
	background-image:  url(themes/<?=$setts['default_theme'];?>/img/sidem.gif);
}
a.ln:visited {
	background-image:  url(themes/<?=$setts['default_theme'];?>/img/sidem.gif);
}
a.ln:hover {
	background-image:  url(themes/<?=$setts['default_theme'];?>/img/sidemo.gif);
}

.topic_id { 
	background-image:  url(themes/<?=$setts['default_theme'];?>/img/arrow.gif);
	background-repeat: no-repeat;
	background-position: 0px 3px;
	 }

-->
</style>

</head>
<body bgcolor="#ffffff" leftmargin="5" topmargin="5" marginwidth="5" marginheight="5">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" style="border-bottom: 1px solid #999999;">
<tr>
   <td width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#ffffff" style="border-bottom: 1px solid #999999;">
         <tr height="70">
            <td><img src="images/probidlogo.gif" alt="Professional Classifieds Script Software by PHP Pro Ads"></td>
            <td width="100%" align="right"><?=$banner_header_content;?></td>
         </tr>
      </table>
      <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr height="25" bgcolor="#336699">
            <td nowrap class="bordermenu mainmenu"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7">&nbsp;<a href="<?=$index_link;?>">
               <?=MSG_BTN_HOME;?>
               </a>&nbsp;</td>
				<? if (!$setts['enable_private_site'] || $is_seller) { ?>
            <td nowrap class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=$place_ad_link;?>">
               <?=$place_ad_btn_msg;?>
               </a>&nbsp;</td>
            <? } ?>
            <td nowrap class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=$register_link;?>">
               <?=$register_btn_msg;?>
               </a>&nbsp;</td>
            <td nowrap class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=$login_link;?>">
               <?=$login_btn_msg;?>
               </a>&nbsp;</td>
            <? if ($setts['enable_stores']) { ?>
            <td nowrap class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=process_link('stores');?>">
               <?=MSG_BTN_STORES;?>
               </a>&nbsp;</td>
            <? } ?>
            <? if ($setts['enable_reverse_auctions']) { ?>
            <td nowrap class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=process_link('reverse_auctions');?>">
               <?=MSG_REVERSE;?>
               </a>&nbsp;</td>
            <? } ?>
            <? if ($setts['enable_wanted_ads']) { ?>
            <td nowrap class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=process_link('wanted_ads');?>">
               <?=MSG_BTN_WANTED_ADS;?>
               </a>&nbsp;</td>
            <? } ?>
            <td nowrap class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=process_link('content_pages', array('page' => 'help'));?>">
               <?=MSG_BTN_HELP;?>
               </a>&nbsp;</td>
            <td nowrap class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=process_link('content_pages', array('page' => 'faq'));?>">
               <?=MSG_BTN_FAQ;?>
               </a>&nbsp;</td>
            <? if ($layout['enable_site_fees_page']) { ?>
            <td nowrap bgcolor="#3A74AE" class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=process_link('site_fees');?>">
               <?=MSG_BTN_SITE_FEES;?>
               </a>&nbsp;</td>
            <? } ?>
            <? if ($layout['is_about']) { ?>
            <td nowrap bgcolor="#3A74AE" class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=process_link('content_pages', array('page' => 'about_us'));?>">
               <?=MSG_BTN_ABOUT_US;?>
               </a>&nbsp;</td>
            <? } ?>
            <? if ($layout['is_contact']) { ?>
            <td nowrap bgcolor="#3A74AE" class="bordermenu mainmenu" width="<?=$header_cell_width;?>"><img src="themes/<?=$setts['default_theme'];?>/img/sidem.gif" width="15" height="7"> &nbsp;<a href="<?=process_link('content_pages', array('page' => 'contact_us'));?>">
               <?=MSG_BTN_CONTACT_US;?>
               </a>&nbsp;</td>
            <? } ?>

         </tr>
      </table>
      <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="2"></div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#1271C1">
         <tr>
            <td><table width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                     <td width="194" nowrap align="center" class="search"><?=$current_date;?>
                        <span id="servertime"></span></td>
                     <form action="auction_search.php" method="post">
                     <input type="hidden" name="option" value="basic_search">
                     <td class="search" nowrap style="border-left: 1px solid #dddddd; padding-left: 10px; padding-right: 10px;"><?=strtoupper(GMSG_SEARCH);?></td>
                     <td class="search" nowrap style="padding-right: 10px;"><input type="text" size="25" name="basic_search"></td>
                     <td class="search" nowrap style="padding-right: 10px;"><input name="form_basic_search" type="submit" value="<?=GMSG_SEARCH;?>"></td>
                     </form>
                     <td class="search" nowrap style="border-left: 1px solid #dddddd; padding-left: 10px; padding-right: 10px;"><?=strtoupper(GMSG_BROWSE);?></td>
                     <form name="cat_browse_form" method="get" action="categories.php">
							<td class="search" style="padding-right: 10px;"><?=$categories_browse_box;?></td>
                     </form>
                     <td width="100%" class="search" nowrap style="border-left: 1px solid #dddddd; padding-left: 10px; padding-right: 10px;"><a href="<?=process_link('search');?>"><?=strtoupper(GMSG_ADVANCED_SEARCH);?></a></td>
                     <? if ($setts['enable_addthis']) { ?>
                     <td nowrap style="border-left: 1px solid #dddddd; padding-left: 10px; padding-right: 10px;">
                     <?=$share_code;?>
                     </td>
                     <? } ?>
                     <? if ($setts['user_lang']) { ?>
                     <td nowrap bgcolor="#2F99E3" style="border-left: 1px solid #dddddd; padding-left: 10px; padding-right: 10px;">
                     <?=$languages_list;?>
                     </td>
                     <? } ?>
                  </tr>
               </table></td>
         </tr>
      </table>
      <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="2"></div>
      <table width="100%" border="0" cellspacing="1" cellpadding="5" bgcolor="#ffffff" style="border-top: 5px solid #003366;">
      <tr valign="top">
      	<? if (!in_array($page_file_name, $browse_pages)) { ?>      	
         <td width="180" bgcolor="#EEF0F3" class="sbm">
	         <script language="javascript">
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
            <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="180" height="1"></div>
				<? } ?>
		      <?=$menu_box_header;?>
				<!--<div id="exp1102170142">-->
		         <?=$menu_box_content;?>
				<!--</div>-->
            <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="180" height="1"></div>
            <noscript>
            <?=MSG_JS_NOT_SUPPORTED;?>
            </noscript>
            <?=$category_box_header;?>
            <div id="exp1102170166">
               <?=$category_box_content;?>
            </div>            
            <?=$banner_position[1];?>
            <?=$banner_position[2];?>
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
            </td>
         <? } ?>
         <td width="100%">
