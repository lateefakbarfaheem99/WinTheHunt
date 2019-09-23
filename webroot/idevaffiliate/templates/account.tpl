{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{include file='file:header.tpl'}

<table align="{$page_align}" border="0" cellspacing="0" width="{$panel_width}{$joinperc}" bgcolor="{$page_border}">
<tr>
<td>
<table border="0" cellpadding="4" cellspacing="0" width="100%" bgcolor="{$white_back}">
<tr>
<td width="100%">

<table border="0" cellspacing="1" width="100%" cellpadding="2">
<tr>
<td width="25%" bgcolor="{$table_top}">&nbsp;{$account_total_transactions}</td>
<td width="25%" bgcolor="{$light_cells}">&nbsp;{$total_transactions}</td>
<td width="50%" rowspan="5" valign="middle" bgcolor="{$lighter_cells}" align="center">
{if $linking_code == 'available'}
<b>{$account_standard_linking_code}</b></BR ><textarea rows="2" cols="40">{$box_code}</textarea><BR />{$account_copy_paste}
{elseif $linking_code == 'pending_approval'}
<b><font color="{$red_text}">{$account_not_approved}</font></b>
{elseif $linking_code == 'account_suspended'}
<b><font color="{$red_text}">{$account_suspended}</font></b>
{/if}
</td>
</tr>

<tr>
<td width="25%" bgcolor="{$table_top}">&nbsp;{$account_standard_earnings}</td>
<td width="25%" bgcolor="{$light_cells}">&nbsp;{$standard_amount_earnings} {if isset($insert_bonus)}{$account_inc_bonus}{/if}</td>
</tr>
<tr>
<td width="25%" bgcolor="{$table_top}">&nbsp;{$account_second_tier}</td>
<td width="25%" bgcolor="{$light_cells}">&nbsp;{$tier_amount_earned}</td>
</tr>
<tr>
<td width="25%" bgcolor="{$table_top}">&nbsp;{$account_recurring}</td>
<td width="25%" bgcolor="{$light_cells}">&nbsp;{$recurring_amount_earned}</td>
</tr>
<tr>
<td width="25%" bgcolor="{$table_top}">&nbsp;<b>{$account_earned_todate}</b></td>
<td width="25%" bgcolor="{$light_cells}"><b>&nbsp;{$total_amount_earned}</b></td>
</tr>
</table>

<div align="center">
<table border="0" cellspacing="1" cellpadding="1" width="100%">
<tr>
<td width="25%" valign="top" bgcolor="{$light_cells}">{include file='file:account_menu.tpl'}</td>
<td width="75%" valign="top">

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td width="100%" align="center">

{include file='file:menu_items.tpl'}

</td></tr>
</table>

<div align="center"><table border="0" cellspacing="0" width="100%" cellpadding="0">
<tr><td width="100%" height="10"></td></tr><tr><td width="100%"><div align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%"><tr><td width="100%" align="center">

{if isset($page_not_authorized)}
{include file='file:account_pending_approval.tpl'}

{elseif isset($affiliate_suspended)}
{include file='file:account_suspended.tpl'}

{else}

{if $internal_page == 1}
{include file='file:account_general_stats.tpl'}
{elseif $internal_page == 2}
{include file='file:account_tier_stats.tpl'}
{elseif $internal_page == 3}
{include file='file:account_payment_history.tpl'}
{elseif $internal_page == 4}
{if isset($sub_affiliates_enabled)}
{include file='file:account_commission_list_subs.tpl'}
{else}
{include file='file:account_commission_list.tpl'}
{/if}
{elseif $internal_page == 5}
{if isset($sub_affiliates_enabled)}
{include file='file:account_recurring_commissions_subs.tpl'}
{else}
{include file='file:account_recurring_commissions.tpl'}
{/if}
{elseif $internal_page == 6}
{include file='file:account_traffic_log.tpl'}
{elseif $internal_page == 7}
{include file='file:account_banners.tpl'}
{elseif $internal_page == 8}
{include file='file:account_text_ads.tpl'}
{elseif $internal_page == 9}
{include file='file:account_text_links.tpl'}
{elseif $internal_page == 10}
{include file='file:account_email_links.tpl'}
{elseif $internal_page == 11}
{include file='file:account_offline_marketing.tpl'}
{elseif $internal_page == 12}
{include file='file:account_tier_code.tpl'}
{elseif $internal_page == 13}
{include file='file:account_email_friends.tpl'}
{elseif $internal_page == 14}
{include file='file:account_keyword_links.tpl'}
{elseif $internal_page == 15}
{include file='file:account_commission_alert.tpl'}
{elseif $internal_page == 16}
{include file='file:account_commission_stats.tpl'}
{elseif $internal_page == 17}
{include file='file:account_edit.tpl'}
{elseif $internal_page == 18}
{include file='file:account_change_password.tpl'}
{elseif $internal_page == 19}
{include file='file:account_change_commission.tpl'}
{elseif $internal_page == 21}
{include file='file:account_faq.tpl'}
{elseif $internal_page == 22}
{include file='file:account_commission_details.tpl'}
{elseif $internal_page == 23}
{include file='file:account_html_ads.tpl'}
{elseif $internal_page == 24}
{include file='file:account_pdf_marketing.tpl'}
{elseif $internal_page == 25}
{include file='file:account_pdf_training.tpl'}
{elseif $internal_page == 26}
{include file='file:account_sub_affiliates.tpl'}
{elseif $internal_page == 27}
{include file='file:account_upload_logo.tpl'}
{elseif $internal_page == 28}
{include file='file:account_email_templates.tpl'}
{elseif $internal_page == 29}
{include file='file:account_sub_affiliates_test.tpl'}
{elseif $internal_page == 30}
{include file='file:custom/30.tpl'}
{elseif $internal_page == 31}
{include file='file:custom/31.tpl'}
{elseif $internal_page == 32}
{include file='file:custom/32.tpl'}
{elseif $internal_page == 33}
{include file='file:custom/33.tpl'}
{elseif $internal_page == 34}
{include file='file:custom/34.tpl'}
{elseif $internal_page == 35}
{include file='file:account_alternate_page_links.tpl'}
{elseif $internal_page == 36}
{include file='file:account_custom_reports.tpl'}
{elseif $internal_page == 37}
{include file='file:account_page_peels.tpl'}
{elseif $internal_page == 38}
{include file='file:account_lightboxes.tpl'}
{elseif $internal_page == 39}
{include file='file:training_videos.tpl'}
{/if}

{/if}

</td></tr></table></div></td></tr> </table></div> </td></tr></table></div>
</td></tr></table></td></tr></table></center>

{include file='file:footer.tpl'}

