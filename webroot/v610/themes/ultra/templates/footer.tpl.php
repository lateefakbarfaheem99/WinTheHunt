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

         	</td>
               <td width="10" style="border-right: 1px solid #bbbbbb;"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr>
               <td width="10"><img src="themes/<?=$setts['default_theme'];?>/img/c3.gif" width="10" height="10"></td>
               <td width="100%" style="border-bottom: 1px solid #bbbbbb;"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td width="10"><img src="themes/<?=$setts['default_theme'];?>/img/c4.gif" width="10" height="10"></td>
            </tr>
         </table>

         <div><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="5"></div>
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
		</td>
   </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var MenuBarCategories = new Spry.Widget.MenuBar("MenuBarCategories", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var MenuBarHelp = new Spry.Widget.MenuBar("MenuBarHelp", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
<? if (
	(stristr($_SERVER['PHP_SELF'], "index.php") && empty($_GET['change_language']) && empty($_GET['change_skin'])) || 
	stristr($_SERVER['PHP_SELF'], "auction_details.php") ||
	stristr($_SERVER['PHP_SELF'], "reverse_details.php") ||
	stristr($_SERVER['PHP_SELF'], "wanted_details.php")
) { ?>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
<? } ?>
<?=$setts['ga_code'];?>
</body></html>