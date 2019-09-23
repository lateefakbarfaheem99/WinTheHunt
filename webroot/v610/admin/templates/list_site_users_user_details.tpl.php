<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<? if ($print_view == 1) { ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="main.js"></script>
<? } ?>
<table width="100%" border="0" cellpadding="0" cellspacing="3" class="fside">
   <tr>
      <td class="c3" style="padding: 3px;"><b>
         <?=AMSG_USER_DETAILS;?>
         </b>
         <?=$user_details_print_link;?></td>
   </tr>
   <tr>
      <td><table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
            <tr>
               <td colspan="2" class="c4"><?=MSG_MAIN_DETAILS;?></td>
            </tr>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
            </tr>
            <tr class="c2">
               <td width="150" align="right" class="contentfont"><?=MSG_FULL_NAME;?></td>
               <td class="contentfont"><?=$user_details['name'];?></td>
            </tr>
            <tr class="c1">
               <td align="right" class="contentfont"><?=MSG_FULL_ADDRESS;?></td>
               <td class="contentfont"><?=$user_full_address;?></td>
            </tr>
            <tr class="c2">
               <td align="right" class="contentfont"><?=MSG_PHONE;?></td>
               <td class="contentfont"><?=$user_details['phone'];?></td>
            </tr>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c2">
               <td align="right" class="contentfont"><?=MSG_DATE_OF_BIRTH;?></td>
               <td class="contentfont"><?=$user_birthdate;?></td>
            </tr>
            <tr>
               <td colspan="2" class="c4"><?=MSG_USER_ACCOUNT_DETAILS;?></td>
            </tr>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
            </tr>
            <tr class="c2">
               <td align="right" class="contentfont"><?=MSG_USERNAME;?></td>
               <td class="contentfont"><?=$user_details['username'];?></td>
            </tr>
            <tr class="c1">
               <td align="right" class="contentfont"><?=MSG_EMAIL_ADDRESS;?>
               </td>
               <td class="contentfont"><?=$user_details['email'];?></td>
            </tr>
            <? if ($setts['enable_tax']) { ?>
            <tr>
               <td colspan="2" class="c4"><?=MSG_TAX_SETTINGS;?></td>
            </tr>
            <tr class="c5">
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
               <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
            </tr>
            <tr class="c2">
               <td align="right" class="contentfont"><?=MSG_REGISTERED_AS;?></td>
               <td class="contentfont"><?=$tax_account_type;?></td>
            </tr>
            <? if ($user_details['tax_account_type']) { ?>
            <tr class="c2">
               <td align="right" class="contentfont"><?=MSG_COMPANY_NAME;?></td>
               <td class="contentfont"><?=field_display($user_details['tax_company_name']);?></td>
            </tr>
            <? } ?>
            <tr class="c1">
               <td align="right" class="contentfont"><?=MSG_TAX_REG_NUMBER;?></td>
               <td><?=field_display($user_details['tax_reg_number']);?></td>
            </tr>
            <? } ?>
         </table>
         <?=$custom_sections_table;?>
      </td>
   </tr>
   <tr>
      <td><table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
            <tr class="c4">
               <td align="center" colspan="3"><b><?=AMSG_IP_ADDRESS_HISTORY;?></b></td>
            </tr>
            <tr class="c3">
               <td align="center"><b><?=AMSG_IP_ADDRESS;?></b></td>
               <td width="30%" align="center"><b><?=GMSG_START_TIME;?></b></td>
               <td width="30%" align="center"><b><?=GMSG_END_TIME;?></b></td>
            </tr>
            <?=$ip_address_history_content;?>
         </table></td>
   </tr>
</table>
