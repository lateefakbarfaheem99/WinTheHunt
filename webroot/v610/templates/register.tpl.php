<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript">
	function checkEmail() {
		var email_check = document.getElementById('email_check').value;
		var email = document.getElementById('email').value;
		if (email == email_check)
		{
			document.getElementById('email_img').style.display = 'inline';
		}
		else
		{
			document.getElementById('email_img').style.display = 'none';			
		}
	}

	function checkPass() {
		if (document.registration_form.password.value==document.registration_form.password2.value) document.registration_form.pass_img.style.display="inline";
		else document.registration_form.pass_img.style.display="none";
	}

	function form_submit() {
		document.registration_form.operation.value = '';
		document.registration_form.edit_refresh.value = '1';
		document.registration_form.submit();
	}

	function copy_email_value() {
		document.getElementById('email_check').value = document.getElementById('email').value;
	}

	function copy_password_value() {
		document.registration_form.password2.value = document.registration_form.password.value;
	}

	function check_username()
	{
		var xmlHttp;

		if (window.XMLHttpRequest)
		{
			var xmlHttp = new XMLHttpRequest();

			if (XMLHttpRequest.overrideMimeType) 
			{
				xmlHttp.overrideMimeType('text/xml');
			}
		}
		else if (window.ActiveXObject) 
		{
			try 
			{
				var xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e) 
			{
				try 
				{
					var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(e) {}
			}
		}
		else 
		{
			alert('Your browser does not support XMLHTTP!');
			return false;
		}

		var uname    = document.getElementById('username').value;
		var url    = 'check_username.php';
		var action    = url + '?username=' + uname;

		if (uname != '') 
		{
			xmlHttp.onreadystatechange = function() { showResult(xmlHttp, usernameResult); };
			xmlHttp.open("GET", action, true);
			xmlHttp.send(null);
		}
		else 
		{
			document.getElementById('usernameResult').innerHTML = '<?=MSG_ENTER_USERNAME;?>';
		}
	}
</script>
<?=$header_registration_message;?>
<br>
<?=$banned_email_output;?>
<?=$display_formcheck_errors;?>
<?=$check_voucher_message;?>

<form action="<?=$register_post_url;?>" method="post" name="registration_form">
   <input type="hidden" name="operation" value="submit">
   <input type="hidden" name="do" value="<?=$do;?>">
   <input type="hidden" name="user_id" value="<?=$user_details['user_id'];?>">
   <input type="hidden" name="edit_refresh" value="0">
  	<input type="hidden" name="generated_pin" value="<?=$generated_pin;?>">
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="2" class="c3"><?=MSG_MAIN_DETAILS;?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_REGISTER_AS;?></td>
         <td class="contentfont">
         	<input name="tax_account_type" type="radio" value="0" onclick="form_submit();" checked />
            <?=GMSG_INDIVIDUAL;?>
            <input name="tax_account_type" type="radio" value="1" onclick="form_submit();" <? echo ($user_details['tax_account_type']) ? 'checked' : ''; ?> />
            <?=GMSG_BUSINESS;?></td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=MSG_REGISTER_AS_DESC;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_FULL_NAME;?></td>
         <td class="contentfont">
         	<div class="left">
         		<?=MSG_FIRST_NAME;?><br />
	         	<input name="first_name" type="text" id="first_name" value="<?=$user_details['first_name'];?>" size="25" />         		
         	</div>
         	<div class="left" style="padding-left: 10px;">
         		<?=MSG_LAST_NAME;?><br />
	         	<input name="last_name" type="text" id="last_name" value="<?=$user_details['last_name'];?>" size="25" />         		         		
         	</div>
				<!--<input name="name" type="text" id="name" value="<?=$user_details['name'];?>" size="40" />-->
         </td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=MSG_FULL_NAME_EXPL;?></td>
      </tr>
      <? if ($user_details['tax_account_type']) { ?>
      <tr class="c1">
         <td align="right" class="contentfont"><?=MSG_COMPANY_NAME;?></td>
         <td class="contentfont"><input name="tax_company_name" type="text" class="contentfont" id="tax_company_name" value="<?=$user_details['tax_company_name'];?>" size="40" /></td>
      </tr>
      <tr class="reguser">
         <td align="right" class="contentfont">&nbsp;</td>
         <td><?=MSG_COMPANY_NAME_DESC;?></td>
      </tr>
      <? } ?>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_ADDRESS;?></td>
         <td class="contentfont"><input name="address" type="text" id="address" value="<?=$user_details['address'];?>" size="40" /></td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=MSG_ADDRESS_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_CITY;?></td>
         <td class="contentfont"><input name="city" type="text" id="city" value="<?=$user_details['city'];?>" size="25" /></td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=MSG_CITY_EXPL;?></td>
      </tr>
   </table>
	<br />
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
      </tr>
      <tr class="c1">
         <td width="35%" class="contentfont"><?=MSG_COUNTRY;?></td>
         <td width="30%" class="contentfont"><?=MSG_STATE;?></td>
         <td class="contentfont"><?=MSG_ZIP_CODE;?></td>
      </tr>
      <tr class="c1">
         <td><?=$country_dropdown;?></td>
         <td><?=$state_box;?></td>
         <td><input name="zip_code" type="text" id="zip_code" value="<?=$user_details['zip_code'];?>" size="15" /></td>
      </tr>
   </table>
	<br />
	<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">

      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
      </tr>

      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_PHONE;?></td>
         <td class="contentfont">
         	<input name="phone" type="text" id="phone" value="<?=$user_details['phone'];?>" size="25" />
			</td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=MSG_PHONE_NEW_EXPL;?></td>
      </tr>
   </table>
   <?=$birthdate_box;?>
	<br />
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="2" class="c3"><?=MSG_USER_ACCOUNT_DETAILS; ?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_EMAIL_ADDRESS;?>
         </td>
         <td class="contentfont"><input name="email" type="text" class="contentfont" id="email" value="<?=$user_details['email'];?>" size="40" maxlength="120" <? echo (IN_ADMIN == 1) ? 'onchange="copy_email_value();"' : ''; ?> /></td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=MSG_EMAIL_EXPLANATION;?></td>
      </tr>
      <tr class="c1">
         <td align="right" class="contentfont"><?=MSG_RETYPE_EMAIL;?></td>
         <td class="contentfont"><input name="email_check" type="text" class="contentfont" id="email_check" value="<?=$email_check_value;?>" size="40" maxlength="120" onkeyup="checkEmail();">
            <img src="<?=$path_relative;?>themes/<?=$setts['default_theme'];?>/img/system/check_img.gif" id="email_img" align="absmiddle" style="display:none;" /></td>
      </tr>
      <tr class="c4">
      	<td></td>
      	<td></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_SUBSCRIBE_TO_NEWSLETTER;?>
         </td>
         <td class="contentfont"><input name="newsletter" type="checkbox" class="newsletter" id="email" value="1" <? echo ($user_details['newsletter']) ? 'checked' : '';?> /></td>
      </tr>
   </table>
   <br>
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_CREATE_USERNAME;?></td>
         <td class="contentfont"><table cellpadding="0" cellspacing="0" border="0">
         		<tr>
         			<td><input name="username" type="text" id="username" value="<?=$user_details['username'];?>" size="40" maxlength="30" <?=$edit_disabled;?> onchange="check_username();"/></td>
         			<td>&nbsp; &nbsp;</td>
         			<td id="usernameResult"><? echo (!$edit_user) ? MSG_ENTER_USERNAME : '';?></td>
         		</tr>
         	</table></td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=MSG_USERNAME_EXPLANATION;?></td>
      </tr>
      <tr class="c1">
         <td align="right" class="contentfont"><?=MSG_CREATE_PASS;?>
         </td>
         <td class="contentfont"><input name="password" type="password" class="contentfont" id="password" size="40" maxlength="20" <? echo (IN_ADMIN == 1) ? 'onchange="copy_password_value();"' : ''; ?> /></td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=MSG_PASSWORD_EXPLANATION;?></td>
      </tr>
      <tr class="c1">
         <td align="right" class="contentfont"><?=MSG_VERIFY_PASS;?></td>
         <td class="contentfont"><input name="password2" type="password"  id="password2" size="40" maxlength="20" onkeyup="checkPass();" />
            <img src="<?=$path_relative;?>themes/<?=$setts['default_theme'];?>/img/system/check_img.gif" id="pass_img" align="absmiddle" style="display:none;" /></td>
      </tr>
   </table>
   <?=$custom_sections_table;?>
   <? if (IN_ADMIN == 1) { ?>
   <br />
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="2" class="c3"><?=AMSG_PAYMENT_SETTINGS;?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=AMSG_PAYMENT_MODE;?></td>
         <td class="contentfont"><input type="radio" name="payment_mode" value="2" <? echo ($user_details['payment_mode']==2) ? 'checked' : '';?>>
            <?=GMSG_ACCOUNT;?>
            <input type="radio" name="payment_mode" value="1" <? echo ($user_details['payment_mode']==1) ? 'checked' : '';?>>
            <?=GMSG_LIVE;?></td>
      </tr>
      <? if ($user_details['payment_mode'] == 2) { ?>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=AMSG_PAYMENT_MODE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td align="right" class="contentfont"><?=AMSG_ACCOUNT_BALANCE;?>
         </td>
         <td class="contentfont"><?=$setts['currency']; ?> <input name="balance" value="<?=abs($user_details['balance']); ?>" size="8">
         	<select name="balance_type">
         		<option value="-1" selected><?=GMSG_CREDIT;?></option>
         		<option value="1" <? echo ($user_details['balance']>0) ? 'selected' : '';?> ><?=GMSG_DEBIT;?></option>
         	</select> &nbsp; <?=AMSG_BALANCE_ADJ_REASON;?>: <input type="text" name="adjustment_reason" size="20"> (<?=AMSG_OPTIONAL_FIELD;?>)</td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=AMSG_ACCOUNT_BALANCE_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td align="right" class="contentfont"><?=GMSG_MAX_DEBIT;?></td>
         <td class="contentfont"><?=$setts['currency']; ?> <input name="max_credit" value="<?=abs($user_details['max_credit']); ?>" size="8"></td>
      </tr>
      <tr class="reguser">
         <td>&nbsp;</td>
         <td><?=AMSG_MAX_DEBIT_EXPL;?></td>
      </tr>
      <? } ?>
   </table>
   <? } ?>
   <? if ($setts['enable_tax']) { ?>
   <br />
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="2" class="c3"><?=MSG_TAX_SETTINGS;?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_TAX_REG_NUMBER;?></td>
         <td><input name="tax_reg_number" type="text" class="contentfont" id="tax_reg_number" value="<?=$user_details['tax_reg_number'];?>" size="40" /></td>
      </tr>
      <tr class="reguser">
         <td align="right" class="contentfont">&nbsp;</td>
         <td><?=MSG_TAX_REG_NUMBER_DESC;?></td>
      </tr>
   </table>
   <? } ?>
   <? if (IN_ADMIN != 1 && !$edit_user) { ?>
   <br />
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1" /></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_REG_PIN;?></td>
         <td><?=$pin_image_output;?></td>
      </tr>
      <tr class="reguser">
         <td align="right" class="contentfont">&nbsp;</td>
         <td><?=MSG_REG_PIN_EXPL;?></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right" class="contentfont"><?=MSG_CONF_PIN;?></td>
         <td><input name="pin_value" type="text" class="contentfont" id="pin_value" value="" size="20" /></td>
      </tr>
   </table>
   <? } ?>
   <!--
   <? if (!empty($display_direct_payment_methods)) { ?>
   <br>
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="2" class="c3"><?=MSG_DIRECT_PAYMENT_SETTINGS;?></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <?=$display_direct_payment_methods;?>
   </table>
   <? } ?>
   -->
   
   <?=$signup_voucher_box;?>
   <?=$registration_terms_box;?>
   <br />
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td width="150" class="contentfont"><input name="form_register_proceed" type="submit" id="form_register_proceed" value="<?=$proceed_button;?>" />
         </td>
         <td class="contentfont">&nbsp;</td>
      </tr>
   </table>
</form>
