<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<form action="content_pages.php" method="post" name="form_content_pages">
	<input type="hidden" name="do" value="<?=$do;?>" />
	<input type="hidden" name="page_id" value="<?=$page_id;?>" />
	<input type="hidden" name="page" value="<?=$page_handle;?>" />
	<input type="hidden" name="field_name" value="<?=$field_name;?>">
	<input type="hidden" name="operation" value="submit" />
	<div class="mainhead"><img src="images/tables.gif" align="absmiddle">
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
      <tr>
         <td colspan="3" class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
            <?=strtoupper($subpage_title);?>
            </b></td>
      </tr>
      <tr class="c1">
         <td align="right" nowrap><?=AMSG_ENABLE_PAGE;?></td>
         <td><input name="field_value" type="checkbox" id="field_value" value="1" <? echo ($layout_tmp[$field_name]) ? 'checked' : ''; ?>></td>
      </tr>
      <? foreach ($languages as $value)
      {
      	$sql_select_topic = $db->query("SELECT * FROM " . DB_PREFIX . "content_pages WHERE
      		page_id='" . $page_id . "' AND topic_lang='" . $value . "' AND page_handle='" . $page_handle . "'");

      	$is_topic = $db->num_rows($sql_select_topic);

      	(array) $row_topic = null;

      	if ($is_topic) $row_topic = $db->fetch_array($sql_select_topic); ?>
      <tr class="c4">
         <td colspan="2"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2">
            <?=GMSG_LANGUAGE;?>
            : <b>
            <?=$value;?>
            </b></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><b>
            <?=AMSG_ENTER_CONTENT;?>
            </b></td>
         <td width="100%"><textarea id="topic_content_<?=$value;?>" name="topic_content_<?=$value;?>" class="tinymce"><?=$row_topic['topic_content'];?></textarea>></td>
      </tr>
      <? } ?>
      <tr>
         <td colspan="2" align="center"><input type="submit" name="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>">
         </td>
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
