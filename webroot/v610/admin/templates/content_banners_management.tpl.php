<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/content.gif" align="absmiddle">
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
<?=$management_box;?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr>
      <td colspan="4" class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
         <?=$subpage_title;?>
         </b></td>
   </tr>
   <form action="content_banners_management.php" method="GET">
   <tr>
      <td colspan="4" align="center"><?=AMSG_SHOW_BANNERS_FROM_SECTION;?>: 
			<select name="filter_section_id">
				<option value="-1" selected><?=AMSG_ALL_SECTIONS;?></option>
         	<?	foreach ($banner_positions as $key => $value) { ?>
         	<option value="<?=$key;?>" <? echo ($filter_section_id == $key && !empty($filter_section_id)) ? 'selected' : ''; ?>><?=$value;?></option>
         	<? } ?>
         </select>
         
         <input type="submit" name="form_filter_section" value="<?=GMSG_PROCEED;?>"></td>
   </tr>
   </form>
   <tr class="c4">
      <td><?=AMSG_BANNER_PREVIEW;?></td>
      <td width="200" align="center"><?=AMSG_DETAILS;?></td>
      <td width="150" align="center"><?=AMSG_SECTION;?></td>
      <td width="150" align="center"><?=AMSG_OPTIONS;?></td>
   </tr>
   <?=$banners_management_content;?>
   <tr>
      <td colspan="4">[ <a href="content_banners_management.php?do=add_banner"><?=AMSG_ADD_BANNER;?></a> ] </td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
