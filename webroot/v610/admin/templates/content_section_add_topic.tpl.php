<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<form action="content_section.php" method="post" name="form_content_topics">
	<input type="hidden" name="do" value="<?=$do;?>" />
	<input type="hidden" name="page_id" value="<?=$page_id;?>" />
	<input type="hidden" name="page" value="<?=$page_handle;?>" />
	<input type="hidden" name="operation" value="submit" />
	<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
      <tr>
         <td colspan="2" align="center" class="c4"><?=$manage_box_title;?></td>
      </tr>
      <? foreach ($languages as $value)
      {
      	$sql_select_topic = $db->query("SELECT * FROM " . DB_PREFIX . "content_pages WHERE
      		page_id='" . $page_id . "' AND topic_lang='" . $value . "' AND page_handle='" . $page_handle . "'");

      	$is_topic = $db->num_rows($sql_select_topic);

      	(array) $row_topic = null;

      	if ($is_topic) $row_topic = $db->fetch_array($sql_select_topic); ?>
      <tr class="c3">
         <td colspan="2"><?=GMSG_LANGUAGE;?>
            : <b>
            <?=$value;?>
            </b></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><?=AMSG_TOPIC_NAME;?></td>
         <td width="100%"><input type="text" name="topic_name_<?=$value;?>" value="<?=$row_topic['topic_name'];?>" size="50" /></td>
      </tr>
      <tr class="c1">
         <td nowrap align="right"><?=AMSG_TOPIC_CONTENT;?></td>
         <td width="100%"><textarea id="topic_content_<?=$value;?>" name="topic_content_<?=$value;?>" class="tinymce"><?=$row_topic['topic_content'];?></textarea></td>
      </tr>
      <? if ($page_handle == 'custom_page') { ?>
      <tr class="c1">
         <td nowrap align="right"><?=AMSG_SHOW_LINK_HP;?></td>
         <td width="100%"><input type="checkbox" name="show_link" value="1" <? echo ($row_topic['show_link']==1) ? 'checked' : '';?>></td>
      </tr>
      <? } ?>
      <? } ?>
      <tr>
         <td colspan="2" align="center"><input type="submit" name="form_content_save" value="<?=AMSG_SAVE_CHANGES;?>">
         </td>
      </tr>
	</table>
</form>
