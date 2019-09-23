<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" align="center" class="border">
   <form action="content_pages.php?page=contact_us" method="post">
   	<input type="hidden" name="topic_id" value="<?=$topic_id;?>">
   	<input type="hidden" name="generated_pin" value="<?=$generated_pin;?>">
      <tr>
         <td colspan="2" class="c3"><b>
            <?=MSG_CONTACT_US;?>
            </b></td>
      </tr>
      <?=$display_formcheck_errors;?>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td width="100%"><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      </tr>
      <tr class="c1">
         <td align="right" nowrap><b>
            <?=MSG_FULL_NAME;?>
            </b></td>
         <td><input name="name" type="text" class="contentfont" id="name" value="<?=$user_details['name'];?>" size="50" <? echo ($topic_id) ? 'readonly' : '';?>></td>
      </tr>
      <tr class="c1">
         <td align="right" nowrap><b>
            <?=MSG_EMAIL_ADDRESS;?>
            </b></td>
         <td><input name="email" type="text" class="contentfont" id="email" value="<?=$user_details['email'];?>" size="50" <? echo ($topic_id) ? 'readonly' : '';?>></td>
      </tr>
      <tr class="c1">
         <td align="right" nowrap><strong>
            <?=MSG_USERNAME;?>
            </strong></td>
         <td><input name="username" type="text" class="contentfont" id="username" value="<?=$user_details['username'];?>" size="50" <? echo ($topic_id) ? 'readonly' : '';?>></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr class="c1">
         <td align="right"><b>
            <?=MSG_PIN_CODE;?>
            </b></td>
         <td><?=$pin_image_output;?></td>
      </tr>
      <tr class="c1">
         <td align="right"><b>
            <?=MSG_CONF_PIN;?>
            </b></td>
         <td><input name="pin_value" type="text" class="contentfont" id="pin_value" value="" size="20" /></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr class="c1">
         <td align="right"><b>
            <?=MSG_QUESTION_QUERY;?>
            </b></td>
         <td><textarea name="question_content" style="width: 100%; height: 150px;"><?=$user_details['question_content'];?></textarea></td>
      </tr>
      <tr class="c4">
         <td colspan="2"></td>
      </tr>
      <tr>
         <td colspan="2" align="center"><input name="form_contactus_send" type="submit" id="form_contactus_send" value="<?=GMSG_PROCEED;?>"></td>
      </tr>
   </form>
</table>
