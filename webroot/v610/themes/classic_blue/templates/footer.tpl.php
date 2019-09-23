<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

?>
</td>
</tr>
</table>

<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="2"></div>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
   <tr valign="top" bgcolor="#3A74AE">
      <td width="50%" valign="middle" class="footerfont1">Copyright &copy;2009 <a href="http://www.phpprobid.com/" target="_blank">PHP Pro Software LTD</a> </td>
      <td align="right" valign="middle" class="footerfont1"><a href="rss_feed.php"><img src="themes/<?=$setts['default_theme'];?>/img/system/rss.gif" border="0" alt="" align="absmiddle"></a></td>
   </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr valign="top">
      <td colspan="2" class="footerfont"><div align="center" style="padding: 5px;">
      		<a href="<?=$index_link;?>"><?=MSG_BTN_HOME;?></a>
				<? if (!$setts['enable_private_site'] || $is_seller) { ?>
				| <a href="<?=$place_ad_link;?>"><?=$place_ad_btn_msg;?></a>
				<? } ?>
				| <a href="<?=$register_link;?>"><?=$register_btn_msg;?></a>
				| <a href="<?=$login_link;?>"><?=$login_btn_msg;?></a>
				| <a href="<?=process_link('content_pages', array('page' => 'help'));?>"><?=MSG_BTN_HELP;?></a>
				| <a href="<?=process_link('content_pages', array('page' => 'faq'));?>"><?=MSG_BTN_FAQ;?></a>
				<? if ($layout['enable_site_fees_page']) { ?>
            | <a href="<?=process_link('site_fees');?>"><?=MSG_BTN_SITE_FEES;?></a>
            <? } ?>
            <? if ($layout['is_about']) { ?>
            | <a href="<?=process_link('content_pages', array('page' => 'about_us'));?>"><?=MSG_BTN_ABOUT_US;?></a>
            <? } ?>
            <? if ($layout['is_contact']) { ?>
            | <a href="<?=process_link('content_pages', array('page' => 'contact_us'));?>"><?=MSG_BTN_CONTACT_US;?></a>
            <? } ?>
            <? if ($layout['is_terms']) { ?>
            | <a href="<?=process_link('content_pages', array('page' => 'terms'));?>"><?=MSG_BTN_TERMS;?></a>
            <? } ?>
            <? if ($layout['is_pp']) { ?>
            | <a href="<?=process_link('content_pages', array('page' => 'privacy'));?>"><?=MSG_BTN_PRIVACY;?></a>
            <? } ?>
            <?=$custom_pages_links;?>
			</div></td>
   </tr>
</table>
</td>
</tr>
</table>
<br />
<?=$banner_position[5];?>
<br />
<table border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
      <td class=contentfont style="color: #666666;"><?=GMSG_PAGE_LOADED_IN;?>
         <?=$time_passed;?>
         <?=GMSG_SECONDS;?></td>
   </tr>
</table>
<!--
<table border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
      <td class=contentfont style="color: #666666;"><?=GMSG_MEMORY_USAGE;?>
         <?=$memory_usage;?> KB</td>
   </tr>
</table>
-->
<?=$setts['ga_code'];?>

</body></html>