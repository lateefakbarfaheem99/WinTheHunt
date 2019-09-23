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

<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td bgcolor="#0082D6"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="100%" bgcolor="#0082D6"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr bgcolor="#F1F1F5" class="footerfont">
      <td height="40" align="center" nowrap style="padding-left: 20px; padding-right: 20px; ">Copyright &copy;2009 <br>
         <a href="http://www.phpprobid.com/" target="_blank">PHP Pro Software LTD </a></td>
      <td width="100%" height="40">
      	&nbsp;&nbsp;<a href="<?=$index_link;?>"><?=MSG_BTN_HOME;?></a>
         <? if (!$setts['enable_private_site'] || $is_seller) { ?>
         &#8226; <a href="<?=$place_ad_link;?>"><?=$place_ad_btn_msg;?></a>
         <? } ?>
         &#8226; <a href="<?=$register_link;?>"><?=$register_btn_msg;?></a> 
         &#8226; <a href="<?=$login_link;?>"><?=$login_btn_msg;?></a> 
         &#8226; <a href="<?=process_link('content_pages', array('page' => 'help'));?>"><?=MSG_BTN_HELP;?></a> 
         &#8226; <a href="<?=process_link('content_pages', array('page' => 'faq'));?>"><?=MSG_BTN_FAQ;?></a> 
         <? if ($layout['enable_site_fees_page']) { ?>
         &#8226; <a href="<?=process_link('site_fees');?>"><?=MSG_BTN_SITE_FEES;?></a>
         <? } ?>
         <? if ($layout['is_about']) { ?>
         &#8226; <a href="<?=process_link('content_pages', array('page' => 'about_us'));?>"><?=MSG_BTN_ABOUT_US;?></a>
         <? } ?>
         <? if ($layout['is_contact']) { ?>
         &#8226; <a href="<?=process_link('content_pages', array('page' => 'contact_us'));?>"><?=MSG_BTN_CONTACT_US;?></a>
         <? } ?>
         <? if ($layout['is_terms']) { ?>
         &#8226; <a href="<?=process_link('content_pages', array('page' => 'terms'));?>"><?=MSG_BTN_TERMS;?></a>
         <? } ?>
         <? if ($layout['is_pp']) { ?>
         &#8226; <a href="<?=process_link('content_pages', array('page' => 'privacy'));?>"><?=MSG_BTN_PRIVACY;?></a>
         <? } ?>
         <?=$custom_pages_links;?></td>
   </tr>
</table>
<?=$banner_position[5];?>
<p align="center" class="footerfont">
   <?=GMSG_PAGE_LOADED_IN;?>
   <?=$time_passed;?>
   <?=GMSG_SECONDS;?>
</p>
<?=$setts['ga_code'];?>
</body></html>