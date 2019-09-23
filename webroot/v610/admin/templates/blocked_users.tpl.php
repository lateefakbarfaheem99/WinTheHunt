<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript">
function popUp(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=2,location=0,statusbar=1,menubar=0,resizable=0,width=550,height=395,left = 80,top = 80');");
}
</script>

<div class="mainhead"><img src="images/user.gif" align="absmiddle"><?=$header_section;?></div>
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
   <tr>
      <td colspan="5" align="center"><?=$query_results_message;?></td>
   </tr>
   <tr class="c4">
      <td width="200"><?=AMSG_DETAILS;?></td>
      <td align="center" width="70"><?=AMSG_SHOW_REASON;?></td>
      <td><?=AMSG_BLOCK_REASON;?></td>
      <td width="110" align="center"><?=AMSG_OPTIONS;?></td>
   </tr>
   <form action="blocked_users.php" method="POST">
      <?=$blocked_users_content;?>
      <tr>
         <td colspan="5" align="center"><input name="form_save_settings" type="submit" id="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>" /></td>
      </tr>
      <tr>
         <td colspan="5" align="center"><?=$pagination;?></td>
      </tr>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
