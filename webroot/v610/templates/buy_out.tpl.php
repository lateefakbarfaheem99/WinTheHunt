<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright �2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script type="text/javascript">
function noenter() {
  return !(window.event && window.event.keyCode == 13); }
</script>
<?=$buy_out_header_message;?>

<table width="100%" border="0" cellpadding="0" cellspacing="2" class="subitem">
   <tr>
      <td><img src="themes/<?=$setts['default_theme'];?>/img/system/status1.gif" vspace="5" align="absmiddle"></td>
      <td nowrap><?=MSG_WELCOME;?>, <br>
         <b><?=$session->value('username');?></b></td>
      <td class="contentfont" width="100%" align="right" >>> <a href="<?=process_link('auction_details', array('auction_id' => $item_details['auction_id']));?>">
         <?=MSG_RETURN_TO_AUCTION_DETAILS_PAGE;?></a>&nbsp;&nbsp;</td>
   </tr>
</table>
<br>
<?=$buy_out_error_message;?>
<?=$check_voucher_message;?>
<?=$buy_out_page_content;?>