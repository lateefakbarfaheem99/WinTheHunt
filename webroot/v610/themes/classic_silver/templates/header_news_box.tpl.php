<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table border="0" cellpadding="3" cellspacing="3" width="100%" class="c1 contentfont">
	<?	while ($news_details = $db->fetch_array($sql_select_news)) { ?>
	<tr> 
		<td class="c2"><img src="themes/<?=$setts['default_theme'];?>/img/arrow.gif" width="8" height="8" hspace="4"></td> 
		<td width="100%" class="c2 smallfont"><b><?=show_date($news_details['reg_date'], false);?></b></td> 
	</tr> 
	<tr class="contentfont"> 
		<td></td> 
		<td><a href="<?=process_link('content_pages', array('page' => 'news', 'topic_id' => $news_details['topic_id']));?>">
				<?=$news_details['topic_name'];?></a></td> 
	</tr>
	<? } ?>
	<tr class="contentfont">
		<td class="c2"></td>
		<td class="c2"><a href="<?=process_link('content_pages', array('page' => 'news'));?>"><?=MSG_VIEW_ALL;?></a> </td>
	</tr>
 </table>
