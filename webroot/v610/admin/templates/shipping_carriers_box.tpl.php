<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<tr>
   <td colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
         <tr>
            <td colspan="2" class="c4"><table border="0" cellspacing="1" cellpadding="0" width="100%">
                  <tr>
                     <td class="c1" width="80"><? echo ($carrier_details['logo_url']) ? '<img src="../' . $carrier_details['logo_url'] . '" border="0">' : ''; ?></td>
                     <td class="c4" style="padding-left: 20px;"><?=$carrier_details['name'];?></td>
                     <td width="120" class="c1" align="center"><input type="checkbox" name="checked[]" value="<?=$carrier_details['carrier_id'];?>" <? echo ($carrier_details['enabled']==1) ? 'checked' : ''; ?> /> <?=AMSG_ENABLED;?></td>
                  </tr>
               </table></td>
         </tr>
		   <tr class="c5">
		      <td><img src="images/pixel.gif" width="250" height="1"></td>
		      <td width="100%"><img src="images/pixel.gif" width="1" height="1"></td>
		   </tr>
			<?=$carrier_settings_rows;?>
      </table></td>
</tr>
