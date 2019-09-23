<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<tr>
   <td colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
         <tr>
            <td colspan="2" class="c4"><table border="0" cellspacing="1" cellpadding="0" width="100%">
                  <tr>
                     <td class="c1" width="150"><? echo ($pg_details['logo_url']) ? '<img src="../' . $pg_details['logo_url'] . '" border="0">' : ''; ?></td>
                     <td class="c4" style="padding-left: 20px;"><?=$pg_details['name'];?></td>
                     <td width="120" class="c1" align="center"><input type="checkbox" name="checked[]" value="<?=$pg_details['pg_id'];?>" <? echo ($pg_details['checked']==1) ? 'checked' : ''; ?> /> <?=AMSG_ENABLED;?></td>
                     <td width="220" class="c1" align="center"><input type="checkbox" name="dp_enabled[]" value="<?=$pg_details['pg_id'];?>" <? echo ($pg_details['dp_enabled']==1) ? 'checked' : ''; ?> /> <?=AMSG_DP_ENABLED;?></td>
                  </tr>
               </table></td>
         </tr>
		   <tr class="c5">
		      <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="250" height="1"></td>
		      <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
		   </tr>
			<?=$pg_settings_rows;?>
      </table></td>
</tr>
