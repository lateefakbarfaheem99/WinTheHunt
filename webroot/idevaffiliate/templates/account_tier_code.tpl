{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($tier_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$tlinks_title}</font></b>
</td>
</tr>

{if isset($forced_links)}

<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center"><BR />{$tlinks_forced_earn} <font color="{$red_text}">{$tier_payout_amount}</font> {$tlinks_type_switch}<BR />
{$tlinks_forced_two}<BR /><BR />
<b>{$tlinks_forced_code}</b><BR />
<textarea rows="3" cols="55">
{if isset($seo_links)}
<a href="{$siteurl}signup-{$link_id}.html">{$tlinks_forced_money}</a>
{else}
<a href="{$base_url}/index.php?ref={$link_id}">{$tlinks_forced_money}</a>
{/if}
</textarea>
<BR /><BR />{$tlinks_forced_paste}<BR /><BR />
</td>
</tr>

{else}

<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center"><BR />
<b>{$tlinks_embedded_one}</b><BR /><BR />
{$tlinks_embedded_two}<BR /><BR />
{$tlinks_embedded_current}: <font color="{$red_text}">{$tier_payout_amount}</font> {$tlinks_type_switch}<BR /><BR />
</td>
</tr>

{/if}

</table>
</td>
</tr>
</table>

{/if}

<BR />
