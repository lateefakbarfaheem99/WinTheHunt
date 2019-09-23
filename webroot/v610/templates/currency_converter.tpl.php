<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$page_header;?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<form action="currency_converter.php" method="get" name="currency_converter_form">
   <tr>
      <td colspan="3"><b><?=MSG_CURRENCY_CONVERTER;?></b></td>
   </tr>
   <tr>
      <td colspan="3" class="c4"></td>
   </tr>
   <tr>
      <td colspan="3" class="c1"><?=MSG_CONVERTER_EXPL;?></td>
   </tr>
   <tr>
      <td colspan="3" class="c4"></td>
   </tr>
   <?=$converter_result_box;?>
   <tr class="membmenu">
      <td width="20%"><?=MSG_CONVERT;?></td>
      <td width="40%"><?=MSG_FROM;?></td>
      <td><?=MSG_TO;?></td>
   </tr>
   <tr class="c4">
      <td></td>
      <td></td>
      <td></td>
   </tr>
   <tr class="c2">
      <td><input type="text" name="amount" value="<?=$amount;?>" size="8"></td>
      <td><?=$currency_from_box;?></td>
      <td><?=$currency_to_box;?></td>
   </tr>
   <tr>
      <td colspan="3" class="c4"></td>
   </tr>
   <tr>
      <td colspan="3"><input type="submit" value="<?=GMSG_PROCEED;?>" name="form_convert"></td>
   </tr>
   </form>
</table>
<?=$page_footer;?>
