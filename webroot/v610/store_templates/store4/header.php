<table border="0" cellpadding="5" cellspacing="0" width="100%" class="store_main">
	<tr>
   	<td width="100%" bgcolor="#ffffff">
   		<table border="0" cellpadding="0" cellspacing="0" width="100%">
         	<tr>
            	<td background="store_templates/images/topbkg10.gif" valign="top" height="96" width="1%" nowrap><br></td>
            	<td background="store_templates/images/topbkg10.gif" valign="middle" height="96" align="left" width="100%" nowrap class="submenu_shop">
						&nbsp;&nbsp;<font color="#ffffff"><b><?=$shop_header_msg;?></b></font></td>
            	<td background="store_templates/images/topbkg10.gif" valign="top" height="96" width="279" nowrap><img src="store_templates/images/topright10.gif" border="0" height="96" width="279"> </td>
         	</tr>
      	</table>
      	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	         <tr>
   	         <td valign="top">
   	         	<br>
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<? if (!empty($user_details['shop_logo_path'])) { ?>
				         <tr>
				            <td class="storestand1" align="center">
				               <img src="<?=$user_details['shop_logo_path'];?>" border="0">
				            </td>
				         </tr>
				         <tr>
				            <td width="100%">&nbsp;</td>
				         </tr>
				         <? } ?>
				         <tr>
				            <td width="100%" class="storestand1">
				            	<?=$db->add_special_chars($user_details['shop_mainpage']);?>
				            </td>
				         </tr>
				         <tr>
				            <td width="100%">&nbsp;</td>
				         </tr>
				      </table></td>
	         </tr>
   	   </table>
      	<table height="22" background="store_templates/images/filmclip10.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
         	<tr>
            	<td width="100%">&nbsp;</td>
         	</tr>
      	</table>
			<br>
