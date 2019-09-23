{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------

Custom Page Instructions
------------------------

You can get to this page in the affiliate control panel here: /account.php?action=33

You really don't want to "hard code" any text into this page because using language packs will become useless.
In your admin center, create a "Custom Language Token" and use that token instead.

There is already a sample token provided for this page.

	{$custom_page_header}

You can see it being used below.
Change, remove or create new tokens as you wish.
------------------------
*}

<table border="0" cellspacing="0" width="95%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">

<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$custom_page_header}</font></b></td>
</tr>
<tr>
<td width="100%" bgcolor="{$lighter_cells}">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="100%">

<br />

{* The following are available tokens on all your template pages.  For more information, see the Custom Control Panel Pages area of the admin center. *}

{$affiliate_id}
<br />
{$affiliate_username}
<br />
{$affiliate_firstname}
<br />
{$affiliate_lastname}
<br />
{$affiliate_email}
<br />
<br />
{$site_homepage}
<br />
{$site_affhome}
<br />
{$site_textlink}
<br />
<br />

</td>
</tr>
</table>

</td>
</tr>

</table>

</td>
</tr>

</table>

<br />

