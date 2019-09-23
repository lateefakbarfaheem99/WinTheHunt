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
	<?	while ($news_details = $db->fetch_array($sql_select_news)) { ?>
	<tr> 
		<td><img src="themes/<?=$setts['default_theme'];?>/img/topbullet.gif" hspace="6" align="absmiddle"></td> 
		<td width="100%" class="smallfont"><b><?=show_date($news_details['reg_date'], false);?></b></td> 
	</tr> 
	<tr> 
		<td></td> 
		<td class="smallfont"><a href="<?=process_link('content_pages', array('page' => 'news', 'topic_id' => $news_details['topic_id']));?>"><?=$news_details['topic_name'];?></a></td> 
	</tr>
	<? } ?>
	<tr>
		<td></td>
		<td class="contentfont"><b><a href="<?=process_link('content_pages', array('page' => 'news'));?>"><?=MSG_VIEW_ALL;?></a></b>&nbsp;</td>
	</tr>
 </table>
 <div><img src="themes/<?=$setts['default_theme'];?>/img/catbottom.gif"></div>
