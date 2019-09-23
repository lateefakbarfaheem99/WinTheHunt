<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="bordercat">
	<?	while ($news_details = $db->fetch_array($sql_select_news)) { ?>
	<tr> 
		<td><img src="themes/<?=$setts['default_theme'];?>/img/arrow.gif" width="8" height="8" hspace="4"></td> 
		<td width="100%" class="smallfont"><b><?=show_date($news_details['reg_date'], false);?></b></td> 
	</tr> 
	<tr> 
		<td></td> 
		<td class="smallfont"><a href="<?=process_link('content_pages', array('page' => 'news', 'topic_id' => $news_details['topic_id']));?>"><?=$news_details['topic_name'];?></a></td> 
	</tr>
	<? } ?>
	<tr bgcolor="#fff1a1">
		<td></td>
		<td class="contentfont" align="right"><b><a href="<?=process_link('content_pages', array('page' => 'news'));?>"><?=MSG_VIEW_ALL;?></a></b>&nbsp;</td>
	</tr>
 </table>
