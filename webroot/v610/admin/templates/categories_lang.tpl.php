<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/cat.gif" align="absmiddle">
   <?=$header_section;?>
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="3" class="fside">
   <tr>
      <td colspan="2" class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
         <?=strtoupper($subpage_title);?>
         </b></td>
   </tr>
   <? if ($msg_changes_saved) { ?>
   <tr>
      <td align="center" colspan="2"><?=$msg_changes_saved;?></td>
   </tr>
   <? } ?>
   <form action="categories_lang.php" method="post">
		<input type="hidden" name="table" value="<?=$table;?>" />
      <tr class="c2">
         <td colspan="2"><b><?=AMSG_CHOOSE_LANGUAGE;?></b>: <?=$cat_lang_drop_down;?>
            <input name="form_choose_cat" type="submit" id="form_choose_cat" value="<?=GMSG_PROCEED;?>">
         </td>
      </tr>
      <? if ($cat_lang) { ?>
      <tr class="c1">
         <td align="center"><textarea name="file_orig" id="file_orig" style="width: 100%; height: 500px;" readonly><?=$file1_contents;?></textarea></td>
         <td align="center"><textarea name="file_edit" id="file_edit" style="width: 100%; height: 500px;" ><?=$file2_contents;?></textarea></td>
      </tr>
      <tr>
         <td align="center" colspan="2"><input name="form_file_save" type="submit" value="<?=GMSG_PROCESS_CHANGES;?>"></td>
      </tr>
      <? } ?>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
