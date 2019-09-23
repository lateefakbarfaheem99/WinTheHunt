<?
#################################################################
## PHP Pro Bid v6.02															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=header5(MSG_COMPARE_ITEMS);?>

<br>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
   <form action="compare_items.php" method="POST">
   <tr>
   <?=$compared_items_content;?>
   </tr>
   <tr>
   	<td align="center" colspan="<?=$nb_auctions;?>"><input type="submit" name="form_compare_items" value="<?=MSG_COMPARE_AGAIN;?>"></td>
   </tr>
   </form>
</table>
<!--<p class="contentfont" align="center">[ <a href="<?=$redirect_url;?>"><?=MSG_BACK_TO_PREV_PAGE;?></a> ]</p>-->