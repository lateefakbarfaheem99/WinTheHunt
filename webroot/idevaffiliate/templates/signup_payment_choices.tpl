{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

<tr><td width="100%" colspan="4" bgcolor="{$table_top}">&nbsp;<font color="{$section_head_txt}"><b>{$signup_commission_title}</b></font></td></tr>

<tr>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$signup_commission_howtopay}&nbsp;&nbsp;</td>
<td width="75%" colspan="3" bgcolor="{$lighter_cells}" colspan="2">&nbsp;<select size="1" name="payme">
{if isset($commission_option_percentage)}
<option value="1"{$payme_selected_1}>{$signup_commission_style_PPS}: {$bot1}%</option>
{/if}
{if isset($commission_option_flatrate)}
<option value="2"{$payme_selected_2}>{$signup_commission_style_PPS}: {$cur_sym}{$bot2} {$currency}</option>
{/if}
{if isset($commission_option_perclick)}
<option value="3"{$payme_selected_3}>{$signup_commission_style_PPC}: {$cur_sym}{$bot3} {$currency}</option>
{/if}
</select>
</td>
</tr>

<tr><td width="100%" colspan="4" height="5"></td></tr>