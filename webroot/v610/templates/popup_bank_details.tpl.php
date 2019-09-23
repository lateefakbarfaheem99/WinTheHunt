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
<?=$message_title;?>
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
</head>
<body>
<?=$msg_changes_saved;?>
<table border="0" width="100%" cellpadding="3" cellspacing="2" class="border contentfont">
	<tr>
		<td nowrap><?=$message_title;?></td>
   </tr>
   <? if ($can_edit) { ?>
   <form name="bank_details_form" action="popup_bank_details.php" method="POST">
   <input type="hidden" name="auction_id" value="<?=$auction_id;?>">
   <? } ?>
	<tr class="c1">
		<td>
			<? if ($can_edit) { ?>
         <textarea name="message_content" style="width:100%; height: 130px;"><?=$message_content; ?></textarea>
         <? } else { ?>
         <?=str_ireplace("\n", '<br>', $message_content); ?>
         <? } ?>
		</td>
	</tr>
   <? if ($can_edit) { ?>
   <tr>
   	<td colspan="2" align="center" class="c2"><input type="submit" name="form_save_bank_details" value="<?=GMSG_PROCEED;?>"></td>
	</tr>
   </form>
   <? } ?>
</table>
</body>
</html>
