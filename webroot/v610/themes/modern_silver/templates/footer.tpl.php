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

<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<div style="border-top: 2px solid #a6a6a6;"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<div align="center">
   <?=$banner_header_content;?>
</div>
<div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
<div align="center" style="padding: 5px;" class="footerfont">

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
            <?=$custom_pages_links;?>
</div>
<div align="center" class="footerfont1"> Copyright &copy;2009 <b><a href="http://www.phpprobid.com/" target="_blank">PHP Pro Software LTD</a></b>. 
	All Rights Reserved. Designated trademarks and brands are the property of their respective owners.<br>
   Use of this Web site constitutes acceptance of the <b>
   <?=$setts['sitename'];?>
   </b>
   <? if ($layout['is_terms']) { ?>
   <a href="<?=process_link('content_pages', array('page' => 'terms'));?>"><?=MSG_BTN_TERMS;?></a>
   <? } ?>
   <? if ($layout['is_pp']) { ?> 
   and <a href="<?=process_link('content_pages', array('page' => 'privacy'));?>"><?=MSG_BTN_PRIVACY;?></a>
   <? } ?>         
</div>
<div align="center" style="padding: 5px; color: #666666;">
<?=GMSG_PAGE_LOADED_IN;?> <?=$time_passed;?> <?=GMSG_SECONDS;?>
</div>

</td>
   </tr>
</table>
<?=$setts['ga_code'];?>
</body></html>