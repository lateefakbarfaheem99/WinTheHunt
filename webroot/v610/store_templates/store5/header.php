<table border="0" cellpadding="5" cellspacing="0" width="100%" class="store_main">
	<tr>
   	<td width="100%">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="store_main">
         	<tr>
            	<td background="store_templates/images/sidebkg11.jpg" valign="top" width="1%"><img src="store_templates/images/topleft11.jpg" border="0" height="128" width="134">
	               <p>&nbsp;</p><p>&nbsp;</p></td>
            	<td valign="top" width="99%" bgcolor="#ffffff">
						<table background="store_templates/images/topbkg11.jpg" border="0" cellpadding="0" cellspacing="0" width="100%">
                  	<tr>
         					<td width="1%"><img src="store_templates/images/topbkg11.jpg" border="0" height="88" width="18"></td>
								<td valign="top" width="99%" class="submenu_shop"><br>
                        	<center><font color="#ffffff" size="4"><b><?=$shop_header_msg;?></b></font></center></td>
                  	</tr>
               	</table>
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<? if (!empty($user_details['shop_logo_path'])) { ?>
				         <tr>
				            <td class="storestand1" align="center">
				               <img src="<?=$user_details['shop_logo_path'];?>" border="0" hspace="3" vspace="3">
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
			<br>
