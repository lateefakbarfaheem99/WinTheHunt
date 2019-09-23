<?
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<br>
<form action="members_area.php?page=about_me&section=profile" method="POST">
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="2" class="c7"><b>
            <?=MSG_PROFILE_PAGE;?>
            </b></td>
      </tr>
      <tr class="c1">
         <td colspan="2"><?=MSG_PROFILE_PAGE_EXPL;?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_ENABLE_PROFILE_PAGE;?></td>
         <td><input name="enable_profile_page" type="checkbox" id="enable_profile_page" value="1" <? echo ($user_details['enable_profile_page']) ? 'checked' : ''; ?>></td>
      </tr>
      <tr class="c5">
         <td></td>
         <td width="100%"></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_WEBSITE;?></td>
         <td colspan="2"><input type="text" name="profile_www" value="<?=$user_details['profile_www'];?>" size="50"/></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_MSN;?></td>
         <td colspan="2"><input type="text" name="profile_msn" value="<?=$user_details['profile_msn'];?>" size="50"/></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_ICQ;?></td>
         <td colspan="2"><input type="text" name="profile_icq" value="<?=$user_details['profile_icq'];?>" size="50"/></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_AIM;?></td>
         <td colspan="2"><input type="text" name="profile_aim" value="<?=$user_details['profile_aim'];?>" size="50"/></td>
      </tr>
      <tr class="c1">
         <td align="right"><?=MSG_YIM;?></td>
         <td colspan="2"><input type="text" name="profile_yim" value="<?=$user_details['profile_yim'];?>" size="50"/></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
         <td colspan="2"><input type="submit" name="form_profile_save" value="<?=GMSG_PROCEED;?>" /></td>
      </tr>
   </table>
</form>
