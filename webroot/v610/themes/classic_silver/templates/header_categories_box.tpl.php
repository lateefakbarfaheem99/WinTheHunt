<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
   <tr>
      <td class="c4"><img src="themes/default/img/pixel.gif" width="1" height="1"></td>
      <td class="c1"><img src="themes/default/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <? 
while ($cats_header_details = $db->fetch_array($sql_select_cats_list)) 
{
	$category_link = process_link('categories', array('category' => $category_lang[$cats_header_details['category_id']], 'parent_id' => $cats_header_details['category_id'])); ?>
   <tr>
      <td class="c1"><img src="themes/<?=$setts['default_theme'];?>/img/arrow.gif" width="8" height="8" hspace="4"></td>
      <td width="100%" class="c2 contentfont"><a href="<?=$category_link;?>" <?=((!empty($cats_header_details['hover_title'])) ? 'title="' . $cats_header_details['hover_title'] . '"' : '');?>>
         <?=$category_lang[$cats_header_details['category_id']];?>
         <?=(($setts['enable_cat_counters']) ? (($cats_header_details['items_counter']) ? '(<strong>' . $cats_header_details['items_counter'] . '</strong>)' : '(' . $cats_header_details['items_counter'] . ')') : '');?></a></td>
   </tr>
   <? } ?>
</table>
