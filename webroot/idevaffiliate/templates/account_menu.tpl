{*
-------------------------------------------------------
iDevAffiliate Version 5.1
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

<table border="0" cellpadding="0" cellspacing="1" width="100%">

	{* SECTION: TRAINING MATERIALS *}

{if isset($training_materials)}
<tr class="menu_text_indent_5">
<td width="100%" height="20" bgcolor="{$logged_menu}"><b>{$menu_heading_training_materials}</b></td>
</tr>
{/if}

{* Removal of the $valid_membership IF statement below will not enable the ability to watch videos. *}

{if isset($training_videos)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet.gif" width="8" height="8">&nbsp;
<a href="account.php?page=39"><font color="{$red_text}">{$menu_videos}</font></a></td>
</tr>
{/if}

{if isset($video_resources_link)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet.gif" width="8" height="8">&nbsp;
<a href="http://www.affiliateresourceguide.com/resource_links.php" target="_blank">Training Video Resources</a></td>
</tr>
{/if}

{if isset($pdf_training_count)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet.gif" width="8" height="8">&nbsp;
<a href="account.php?page=25"><font color="{$menu_links}">{$menu_pdf_training}</font></a></td>
</tr>
{/if}

{if isset($custom_tracking_enabled)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet.gif" width="8" height="8">&nbsp;
<a href="tutorials/Custom_Links.pdf" target="_blank"><font color="{$menu_links}">{$menu_custom_manual}</font></a></td>
</tr>
{/if}

	{* SECTION: MARKETING MATERIALS *}

<tr class="menu_text_indent_5">
<td width="100%" height="20" bgcolor="{$logged_menu}"><b>{$menu_heading_marketing}</b></td>
</tr>

{if isset($banner_count)}
<tr class="menu_text_indent_10">
<td width="85%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=7"><font color="{$menu_links}">{$menu_banners}</font></a></td>
</tr>
{/if}

{if isset($page_peel_count)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=37"><font color="{$menu_links}">{$menu_page_peels}</font></a></td>
</tr>
{/if}

{if isset($lightbox_count)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=38"><font color="{$menu_links}">{$menu_lightboxes}</font></a></td>
</tr>
{/if}

{if isset($textad_count)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=8"><font color="{$menu_links}">{$menu_text_ads}</font></a></td>
</tr>
{/if}

{if isset($htmlcount)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=23"><font color="{$menu_links}">{$menu_html_links}</font></a></td>
</tr>
{/if}

{if isset($textlink_count)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=9"><font color="{$menu_links}">{$menu_text_links}</font></a></td>
</tr>
{/if}

{if isset($email_links_available)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=10"><font color="{$menu_links}">{$menu_email_links}</font></a></td>
</tr>
{/if}

{if isset($etemplates_count)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=28"><font color="{$menu_links}">{$menu_etemplates}</font></a></td>
</tr>
{/if}

{if isset($offline_marketing)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=11"><font color="{$menu_links}">{$menu_offline}</font></a></td>
</tr>
{/if}

{if isset($second_tier)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=12"><font color="{$menu_links}">{$menu_tier_linking_code}</font></a></td>
</tr>
{/if}

{if isset($pdf_marketing_count)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=24"><font color="{$menu_links}">{$menu_pdf_marketing}</font></a></td>
</tr>
{/if}

{if isset($use_email)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_red.gif" width="8" height="8">&nbsp;
<a href="account.php?page=13"><font color="{$menu_links}">{$menu_email_friends}</font></a></td>
</tr>
{/if}


	{* SECTION: CUSTOM TRACKING LINKS *}


{if isset($custom_tracking_enabled)}
<tr class="menu_text_indent_5">
<td width="100%" height="20" bgcolor="{$logged_menu}"><b>{$menu_heading_custom_links}</b>
{if isset($custom_links_enabled) || isset($sub_affiliates_enabled)}
[ <a href="account.php?page=36"><font color="{$red_text}">{$menu_custom_reports}</font></a> ]
{/if}
</td>
</tr>
{/if}

{if isset($custom_links_enabled)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_blue.gif" width="8" height="8">&nbsp;
<a href="account.php?page=14"><font color="{$menu_links}">{$menu_keyword_links}</font></a></td>
</tr>
{/if}

{if isset($sub_affiliates_enabled)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_blue.gif" width="8" height="8">&nbsp;
<a href="account.php?page=26"><font color="{$menu_links}">{$menu_subid_links}</font></a></td>
</tr>
{/if}

{if isset($alternate_keywords_enabled)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_blue.gif" width="8" height="8">&nbsp;
<a href="account.php?page=35"><font color="{$menu_links}">{$menu_alteranate_links}</font></a></td>
</tr>
{/if}

	{* SECTION: COMMISSIONALERT & COMMISSIONSTATS *}

{if (isset($commission_alert)) || (isset($commission_stats))}
<tr class="menu_text_indent_5">
<td width="100%" height="20" bgcolor="{$logged_menu}"><b>{$menu_heading_additional}</b></td>
</tr>
{/if}

{if isset($commission_alert)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_white.gif" width="8" height="8">&nbsp;
<a href="account.php?page=15"><font color="{$menu_links}">{$menu_comalert}</font></a>
</td>
</tr>
{/if}

{if isset($commission_stats)}
<tr class="menu_text_indent_10">
<td width="100%" height="20" bgcolor="{$logged_menu}"><img border="0" src="images/bullet_white.gif" width="8" height="8">&nbsp;
<a href="account.php?page=16"><font color="{$menu_links}">{$menu_comstats}</font></a>
</td>
</tr>
{/if}

</table>
