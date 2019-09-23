<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<form action="<?=$post_url;?>" method="post">
	<input type="hidden" name="user_id" value="<?=$user_id;?>">
	<div class="mainhead"><img src="images/user.gif" align="absmiddle">
	   <?=$header_section;?>
	</div>
	<?=$msg_changes_saved;?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	   <tr>
	      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
	      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
	      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
	   </tr>
	</table>
	<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
	   <tr class="c3">
	      <td colspan="2"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
	         <?=strtoupper($subpage_title);?>
	         </b></td>
	   </tr>
	</table>
	<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
      <? if ($user_id) { ?>
      <tr class="c1">
         <td width="150"><?=AMSG_SEND_MSG_TO;?>
            :</td>
         <td><strong>
            <?=AMSG_USERNAME;?>
            </strong> :
            <?=$user_details['username'];?>
            <br>
            <strong>
            <?=AMSG_EMAIL_ADDR;?>
            </strong> :
            <?=$user_details['email'];?></td>
      </tr>
      <tr class="c1">
         <td width="150"><?=AMSG_SENDING_OPTIONS;?>
            :</td>
         <td><input type="radio" name="msg_method" value="0" checked>
            <?=AMSG_BY_EMAIL;?>
            <br>
            <input type="radio" name="msg_method" value="1" <? echo ($email_details['msg_method'] == 1) ? 'checked' : '';?>>
            <?=AMSG_INTERNAL_MESSAGING;?></td>
      </tr>
      <? } else { ?>
      <tr class="c1">
         <td width="150"><?=AMSG_SEND_NEWSLETTER_TO;?>
            :</td>
         <td><select name="newsletter_send" id="newsletter_send">
               <option value="1" selected>
               <?=AMSG_ALL_USERS;?> (<?=$total_users;?> <?=AMSG_USERS;?>)
               </option>
               <option value="2">
               <?=AMSG_ACTIVE_USERS;?> (<?=$active_users;?> <?=AMSG_USERS;?>)
               </option>
               <option value="3">
               <?=AMSG_SUSPENDED_USERS;?> (<?=$suspended_users;?> <?=AMSG_USERS;?>)
               </option>
               <option value="4">
               <?=AMSG_NEWSLETTER_SUBSCRIBERS;?> (<?=$nl_users;?> <?=AMSG_USERS;?>)
               </option>
               <? if ($setts['enable_stores']) { ?>
               <option value="5">
               <?=AMSG_STORE_OWNERS;?> (<?=$store_users;?> <?=AMSG_USERS;?>)
               </option>
               <? } ?>
               <? if ($setts['enable_private_site']){ ?>
               <option value="6">
               <?=AMSG_SELLERS;?> (<?=$nb_sellers;?> <?=AMSG_USERS;?>)
               </option>
               <? } ?>
               <? if ($setts['enable_seller_verification']){ ?>
               <option value="7">
               <?=AMSG_VERIFIED_SELLERS;?> (<?=$nb_verified_sellers;?> <?=AMSG_USERS;?>)
               </option>
					<? } ?>
            </select></td>
      </tr>
      <tr class="c1">
         <td width="150"><?=AMSG_SENDING_OPTIONS;?>
            :</td>
         <td><input type="radio" name="sending_method" value="0" checked>
            <?=AMSG_USE_CRON_JOB;?>
            <br>
            <input type="radio" name="sending_method" value="1" <? echo ($email_details['sending_method'] == 1) ? 'checked' : '';?>>
            <?=AMSG_SEND_DIRECTLY;?></td>
      </tr>
      <? } ?>
      <tr class="c1">
         <td><?=AMSG_SUBJECT;?>
            :</td>
         <td><input name="subject" type="text" id="subject" value="<?=$email_details['subject'];?>" size="40"></td>
      </tr>
      <tr class="c1">
         <td><?=AMSG_CONTENT;?>
            :</td>
         <td><textarea name="email_content" id="email_content" class="tinymce"><?=$db->add_special_chars($email_details['email_content']);?></textarea></td>
      </tr>
      <tr>
         <td colspan="2" align="center"><input name="form_send_email" type="submit" id="form_send_email" value="<?=GMSG_PROCEED;?>"></td>
      </tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	   <tr>
	      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
	      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
	      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
	   </tr>
	</table>
</form>
