<table border="0" cellpadding="5" cellspacing="0" width="100%" class="store_main">
<tr>
   <td width="100%" bgcolor="#ffffff">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
            <td background="store_templates/images/sidebkg9.jpg" valign="top" width="1%"><img src="store_templates/images/topleft9.jpg" border="0" height="153" width="159"><br></td>
            <td valign="top" width="99%">
					<table background="store_templates/images/topbkg9.jpg" border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                     <td width="1%"><img src="store_templates/images/topbkg9.jpg" border="0" height="81" width="3"></td>
                  </tr>
               </table>
               <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                     <td valign="top" width="62%" align="center" class="contentfont">
                     	<? if (!empty($user_details['shop_logo_path'])) { ?>
                        	<img src="<?=$user_details['shop_logo_path'];?>" border="0"><br>
                        <? } ?>
                        <b><?=$shop_header_msg;?></b></td>
                     <td valign="top" width="43%">&nbsp;&nbsp;</td>
                  </tr>
                  <tr>
                     <td valign="top" width="62%" align="center"><img src="store_templates/images/sticks9.jpg" border="0" height="35" width="387"><br><font face="Arial" size="2"><?=$db->add_special_chars($user_details['shop_mainpage']);?> </font> </td>
                     <td valign="middle" align="center" width="43%"><img style="width: 139px; height: 128px;" src="store_templates/images/poolballs9.jpg" border="0"> </td>
                  </tr>
               </table>
				</td>
         </tr>
      </table>
      <br>
