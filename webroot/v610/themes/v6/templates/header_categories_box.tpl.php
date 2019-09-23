<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div><img src="themes/<?=$setts['default_theme'];?>/img/cattop.gif"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#fffdf4" style="border-left: 1px solid #cdc6ba; border-right: 1px solid #cdc6ba;">
   <? 
while ($cats_header_details = $db->fetch_array($sql_select_cats_list)) 
{
	$category_link = process_link('categories', array('category' => $category_lang[$cats_header_details['category_id']], 'parent_id' => $cats_header_details['category_id'])); ?>
   <tr>
      <td class="categories"><img src="themes/<?=$setts['default_theme'];?>/img/topbullet.gif" hspace="6" align="absmiddle"><a class="ln" href="<?=$category_link;?>" <?=((!empty($cats_header_details['hover_title'])) ? 'title="' . $cats_header_details['hover_title'] . '"' : '');?>>
         <?=$category_lang[$cats_header_details['category_id']];?>
         <?=(($setts['enable_cat_counters']) ? (($cats_header_details['items_counter']) ? '(<strong>' . $cats_header_details['items_counter'] . '</strong>)' : '(' . $cats_header_details['items_counter'] . ')') : '');?></a></td>
   </tr>
   <? } ?>
</table>
<div><img src="themes/<?=$setts['default_theme'];?>/img/catbottom.gif"></div>
