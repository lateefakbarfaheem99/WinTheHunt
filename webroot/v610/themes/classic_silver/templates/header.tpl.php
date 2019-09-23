<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

## show sell button
 if ($member_active == 'Active') { 
	$btn2_link=$path."sellitem.php";
	$btn3_caption="<IMG SRC=\"themes/".$setts['default_theme']."/img/".$_SESSION['sess_lang']."/mem_t.gif\" width=\"83\" height=\"15\" BORDER=0 ALT=\"Members Area\" id=\"register\">";
	$btn3_link=$path."membersarea.php";
	$btn3_swap="themes/".$setts['default_theme']."/img/".$_SESSION['sess_lang']."/mem_to.gif";
	$btn4_caption="<IMG SRC=\"themes/".$setts['default_theme']."/img/".$_SESSION['sess_lang']."/logout_t.gif\" width=\"83\" height=\"15\" BORDER=0 ALT=\"Logout\" id=\"login\">";
	$btn4_link=$path."index.php?option=logout";
	$btn4_swap="themes/".$setts['default_theme']."/img/".$_SESSION['sess_lang']."/logout_to.gif";
} else {
	$btn2_link=$path."login.php?redirect=sell";
	$btn3_caption="<img src=\"themes/".$setts['default_theme']."/img/".$_SESSION['sess_lang']."/reg_t.gif\" width=\"83\" height=\"15\" border=\"0\" ALT=\"Register\" id=\"register\">";
	$btn3_link=$path_ssl."register.php";
	$btn3_swap="themes/".$setts['default_theme']."/img/".$_SESSION['sess_lang']."/reg_to.gif";
	$btn4_caption="<img src=\"themes/".$setts['default_theme']."/img/".$_SESSION['sess_lang']."/login_t.gif\" width=\"83\" height=\"15\" border=\"0\" ALT=\"Login\" id=\"login\">";
	$btn4_link=$path_ssl."login.php";
	$btn4_swap="themes/".$setts['default_theme']."/img/".$_SESSION['sess_lang']."/login_to.gif";
}
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

.topic_id { 
	background-image:  url(themes/<?=$setts['default_theme'];?>/img/arrow.gif);
	background-repeat: no-repeat;
	background-position: 0px 3px;
	 }

-->
</style>

</head>
<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="76" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="290"><a href="index.php"><img src="images/probidlogo.gif" border="0"></a></td>
      <td width="100%" align="center"><?=$banner_header_content;?>
      </td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="themes/<?=$setts['default_theme'];?>/img/bgmenu.gif" style="border-top: 2px solid #0066CB;">
   <tr>
      <td width="83"><a href="<?=$index_link;?>" onMouseOver="MM_swapImage('home','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/home_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/home_i.gif" width="83" height="56" border="0"></a></td>
      <? if (!$setts['enable_private_site'] || $is_seller) { ?>
      <td width="83"><a href="<?=$place_ad_link;?>" onMouseOver="MM_swapImage('sell','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/sell_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/sell_i.gif" width="83" height="56" border="0"></a></td>
      <? } ?>
      <td width="83"><a href="<?=$register_link;?>" onMouseOver="MM_swapImage('register','','<?=$btn3_swap;?>',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/reg_i.gif" width="83" height="56" border="0"></a></td>
      <td width="83"><a href="<?=$login_link;?>" onMouseOver="MM_swapImage('login','','<?=$btn4_swap;?>',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/login_i.gif" width="83" height="56" border="0"></a></td>
      <? if ($setts['enable_wanted_ads']) { ?>
      <td width="83"><a href="<?=process_link('wanted_ads');?>" onMouseOver="MM_swapImage('wanted','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/ads_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/ads_i.gif" width="83" height="56" border="0"></a></td>
      <? } ?>
      <? if ($setts['enable_reverse_auctions']) { ?>
      <td width="83"><a href="<?=process_link('reverse_auctions');?>" onMouseOver="MM_swapImage('reverse','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/reverse_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/reverse_i.gif" width="83" height="56" border="0"></a></td>
      <? } ?>
      <? if ($setts['enable_stores']) { ?>
      <td width="83"><a href="<?=process_link('stores');?>" onMouseOver="MM_swapImage('stores','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/store_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/store_i.gif" width="83" height="56" border="0"></a></td>
      <? } ?>
      <td width="83"><a href="<?=process_link('content_pages', array('page' => 'help'));?>" onMouseOver="MM_swapImage('help','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/help_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/help_i.gif" width="83" height="56" border="0"></a></td>
      <td width="20"><img src="themes/<?=$setts['default_theme'];?>/img/1m.gif" width="20" height="56"></td>
      <td width="325" rowspan="2" align="right"><? if ($member_active == 'Active') {} else { ?>
         <table border="0" cellpadding="0" cellspacing="0" background="themes/<?=$setts['default_theme'];?>/img/log_bg.gif">
            <form action="login.php" method="post" name="loginbox">
               <input type="hidden" name="form_loginbox_proceed" value="yes">
               <input type="hidden" name="operation" value="submit">
               <input type="hidden" name="redirect" value="<?=$redirect;?>">
               <tr>
                  <td rowspan="5"><img src="themes/<?=$setts['default_theme'];?>/img/log_head.gif" width="32" height="62"></td>
                  <td nowrap class="user"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
                  <td nowrap class="user"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="7"></td>
                  <td rowspan="5"><input name="form_loginbox_proceed" type="image" id="form_loginbox_proceed" src="themes/<?=$setts['default_theme'];?>/img/login_go.gif" width="57" height="62" border="0"></td>
               </tr>
               <tr>
                  <td align="right" nowrap class="user"><?=MSG_USERNAME;?>
                     &nbsp;</td>
                  <td nowrap class="user"><input name="username" type="text" size="17"></td>
               </tr>
               <tr>
                  <td align="right" nowrap class="user"><?=MSG_PASSWORD;?>
                     &nbsp;</td>
                  <td nowrap class="user"><input name="password" type="password" size="17"></td>
               </tr>
               <tr>
                  <td nowrap class="user"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
                  <td nowrap class="user"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></td>
               </tr>
            </form>
         </table>
         <? } ?>
      </td>
      <td width="100%">&nbsp;</td>
   </tr>
   <tr>
      <td width="83"><a href="<?=$index_link;?>" onMouseOver="MM_swapImage('home','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/home_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/home_t.gif" name="home" width="83" height="15" border="0" id="home"></a></td>
      <? if (!$setts['enable_private_site'] || $is_seller) { ?>
      <td width="83"><a href="<?=$place_ad_link;?>" onMouseOver="MM_swapImage('sell','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/sell_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/sell_t.gif" name="sell" width="83" height="15" border="0" id="sell"></a></td>
      <? } ?>
      <td width="83"><a href="<?=$register_link;?>" onMouseOver="MM_swapImage('register','','<?=$btn3_swap;?>',1)" onMouseOut="MM_swapImgRestore()"><?=$btn3_caption;?></a></td>
      <td width="83"><a href="<?=$login_link;?>" onMouseOver="MM_swapImage('login','','<?=$btn4_swap;?>',1)" onMouseOut="MM_swapImgRestore()"><?=$btn4_caption;?></a></td>
      <? if ($setts['enable_wanted_ads']) { ?>
      <td width="83"><a href="<?=process_link('wanted_ads');?>" onMouseOver="MM_swapImage('wanted','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/ads_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/ads_t.gif" name="sell" width="83" height="15" border="0" id="wanted"></a></td>
      <? } ?>
      <? if ($setts['enable_reverse_auctions']) { ?>
      <td width="83"><a href="<?=process_link('reverse_auctions');?>" onMouseOver="MM_swapImage('reverse','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/reverse_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/reverse_t.gif" name="sell" width="83" height="15" border="0" id="reverse"></a></td>
      <? } ?>
      <? if ($setts['enable_stores']) { ?>
      <td width="83"><a href="<?=process_link('stores');?>" onMouseOver="MM_swapImage('stores','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/store_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/store_t.gif" name="sell" width="83" height="15" border="0" id="stores"></a></td>
      <? } ?>
      <td width="83"><a href="<?=process_link('content_pages', array('page' => 'help'));?>" onMouseOver="MM_swapImage('help','','themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/help_to.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="themes/<?=$setts['default_theme'];?>/img/<?=$_SESSION['sess_lang']?>/help_t.gif" name="help" width="83" height="15" border="0" id="help"></a></td>
      <td width="20"><img src="themes/<?=$setts['default_theme'];?>/img/2m.gif" width="20" height="15"></td>
      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
</table>
<table width="100%" height="37" border="0" cellpadding="0" cellspacing="0" background="themes/<?=$setts['default_theme'];?>/img/subg.gif">
   <tr>
      <td colspan="7"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="3"></td>
      <td width="32" rowspan="2"><img src="themes/<?=$setts['default_theme'];?>/img/user_stert.gif" width="32" height="37"></td>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="3"></td>
   </tr>
   <tr class="submenu">
      <form action="auction_search.php" method="post">
         <input type="hidden" name="option" value="basic_search">
         <td bgcolor="#0082D6">&nbsp;&nbsp;&nbsp;<a href="<?=process_link('search');?>"><?=strtoupper(GMSG_SEARCH);?></a>&nbsp;&nbsp;</td>
         <td bgcolor="#0082D6"><input type="text" size="20" name="basic_search"></td>
         <td bgcolor="#0082D6"><input name="form_basic_search" type="image" src="themes/<?=$setts['default_theme'];?>/img/search_go.gif" hspace=7></td>
      </form>
      <td nowrap bgcolor="#0082D6" class="submenu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=strtoupper(GMSG_BROWSE);?>&nbsp;&nbsp;</td>
      <form name="cat_browse_form" method="get" action="categories.php">
         <td bgcolor="#0082D6"><?=$categories_browse_box;?></td>
      </form>
      <td bgcolor="#0082D6">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td bgcolor="#0082D6">&nbsp;</td>
      <td width="100%" class="welcome"><? if ($member_active == 'Active') { ?>
         <?=MSG_WELCOME_BACK;?>
         , <b>
         <?=$member_username; ?>
         </b>
         <? } ?></td>
		<? if ($setts['enable_addthis']) { ?>
		<td nowrap style="padding-right: 10px;"><?=$share_code;?></td>
		<? } ?>
   </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="8">
<tr valign="top">
  	<? if (!in_array($page_file_name, $browse_pages)) { ?>
   <td width="180">
		<script language="javascript">
			var ie4 = false;
			if(document.all) { ie4 = true; }
		
			function getObject(id) { if (ie4) { return document.all[id]; } else { return document.getElementById(id); } }
			function toggle(link, divId) {
				var lText = link.innerHTML;
				var d = getObject(divId);
				if (lText == '+') { link.innerHTML = '&#8211;'; d.style.display = 'block'; }
				else { link.innerHTML = '+'; d.style.display = 'none'; }
			}
		</script>
      <? if ($is_announcements && $member_active == 'Active') { ?>
      <?=$announcements_box_header;?>
      <div id="exp1102170555">
         <?=$announcements_box_content;?>
      </div>
      <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
      <noscript>
      <?=MSG_JS_NOT_SUPPORTED;?>
      </noscript>
      <? } ?>
      <? if ($member_active == 'Active') { ?>
      <?=$menu_box_header;?>
      <?=$menu_box_content;?>
      <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
      <noscript>
      <?=MSG_JS_NOT_SUPPORTED;?>
      </noscript>
      <? } ?>
      <? if ($setts['enable_header_counter'] && stristr($_SERVER['PHP_SELF'], 'index.php')) { ?>
      <?=$header_site_status;?>
      <table width='100%' border='0' cellpadding='3' cellspacing='0'>
         <tr>
            <td class="c4"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            <td class="c2"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
         </tr>
         <tr class='c1'>
            <td width='20%' align='center'><b>
               <?=$nb_site_users;?>
               </b></td>
            <td width='80%'>&nbsp;<font style='font-size: 10px;'>
               <?=MSG_REGISTERED_USERS;?>
               </font></td>
         </tr>
         <tr class='c2'>
            <td width='20%' align='center'><b>
               <?=$nb_live_auctions;?>
               </b></td>
            <td width='80%'>&nbsp;<font style='font-size: 10px;'>
               <?=MSG_LIVE_AUCTIONS;?>
               </font></td>
         </tr>
         <? if ($setts['enable_wanted_ads']) { ?>
         <tr class='c1'>
            <td width='20%' align='center'><b>
               <?=$nb_live_wanted_ads;?>
               </b></td>
            <td width='80%'>&nbsp;<font style='font-size: 10px;'>
               <?=MSG_LIVE_WANT_ADS;?>
               </font></td>
         </tr>
         <? } ?>
         <? if ($setts['enable_stores']) { ?>
         <tr class='c2'>
            <td width='20%' align='center'><b>
               <?=$nb_live_stores;?>
               </b></td>
            <td width='80%'>&nbsp;<font style='font-size: 10px;'>
               <?=MSG_ACTIVE_STORES;?>
               </font></td>
         </tr>
         <? } ?>
         <tr class='c1'>
            <td width='20%' align='center'><b>
               <?=$nb_online_users;?>
               </b></td>
            <td width='80%'>&nbsp;<font style='font-size: 10px;'>
               <?=MSG_ONLINE_USERS;?>
               </font></td>
         </tr>
      </table>
      <div><img src='themes/<?=$setts['default_theme'];?>/img/pixel.gif' width='1' height='5'></div>
      <? } ?>
      <? if ($is_news && $layout['d_news_box']) { ?>
      <?=$news_box_header;?>
      <?=$news_box_content;?>
      <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
      <? } ?>
      <?=$category_box_header;?>
      <div id="exp1102170166">
         <?=$category_box_content;?>
      </div>
		<?=$banner_position[1];?>
		<?=$banner_position[2];?>
      <br>
      <? if ($setts['user_lang']) { ?>
      <div align="center">
         <?=$languages_list;?>
      </div>
      <? } ?>
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
	<? } ?>      
   <td width="100%">
