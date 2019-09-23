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
   <tr class="c2">
      <td class="categories"><? 
			while ($cats_header_details = $db->fetch_array($sql_select_cats_list)) 
			{
				$category_link = process_link('categories', array('category' => $category_lang[$cats_header_details['category_id']], 'parent_id' => $cats_header_details['category_id'])); ?>
         <img src="themes/<?=$setts['default_theme'];?>/img/arrow.gif" width="9" height="9" hspace="4" vspace="3" align="absmiddle"> <a href="<?=$category_link;?>" <?=((!empty($cats_header_details['hover_title'])) ? 'title="' . $cats_header_details['hover_title'] . '"' : '');?>>
         <?=$category_lang[$cats_header_details['category_id']];?>
         <?=(($setts['enable_cat_counters']) ? (($cats_header_details['items_counter']) ? '(<strong>' . $cats_header_details['items_counter'] . '</strong>)' : '(' . $cats_header_details['items_counter'] . ')') : '');?></a><br>
         <? } ?></td>
   </tr>
</table>
