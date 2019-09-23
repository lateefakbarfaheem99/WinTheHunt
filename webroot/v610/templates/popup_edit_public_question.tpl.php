<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>
<?=$setts['sitename'];?> -
<?=MSG_SUBMIT_EDIT_ANSWER;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CODEPAGE;?>">
<link href="themes/<?=$setts['default_theme'];?>/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
<script language="JavaScript">//<!--
	function copyForm() {
		opener.document.hidden_form.message_content.value = document.popup_form.message_content.value;
		opener.document.hidden_form.option.value = document.popup_form.option.value;
		opener.document.hidden_form.option.method = 'post';
		<? if ($auction_id) { ?>
		opener.document.hidden_form.auction_id.value = document.popup_form.auction_id.value;
		<? } else if ($wanted_ad_id) { ?>
		opener.document.hidden_form.wanted_ad_id.value = document.popup_form.wanted_ad_id.value;
		<? } ?>
		opener.document.hidden_form.question_id.value = document.popup_form.question_id.value;
		opener.document.hidden_form.submit();
		window.opener.focus;
		window.close();
		return false;
	}
//-->
</SCRIPT>
</head>
<body>
<table border="0" width="100%" cellpadding="2" cellspacing="2" class="border contentfont">
   <form name="popup_form" onSubmit="return copyForm()" method="post">
      <input type="hidden" name="auction_id" value="<?=$auction_id;?>">
      <input type="hidden" name="wanted_ad_id" value="<?=$wanted_ad_id;?>">
      <input type="hidden" name="question_id" value="<?=$question_id;?>">
      <input type="hidden" name="option" value="post_answer">
      <tr class="c1">
         <td nowrap><strong><?=MSG_SUBMIT_ANSWER;?></strong>:</td>
         <td width="100%"><textarea name="message_content" style="width:100%; height: 60px;"><?=$message_content; ?></textarea></td>
      </tr>
      <tr>
         <td colspan="2" align="center" class="c2"><input type="button" value="<?=GMSG_PROCEED;?>" onClick="copyForm()"></td>
      </tr>
   </form>
</table>
</body>
</html>
