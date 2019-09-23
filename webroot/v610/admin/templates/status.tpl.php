<? 
#################################################################
## PHP Pro Bid v6.07															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); } 
?>


<div class="mainhead1"><img src="images/stat.gif" align="absmiddle"> <?=AMSG_SYSTEM_STATUS;?></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  	<tr>
  		<td width="4"><img src="images/c1.gif" width="4" height="4"></td>
  		<td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
  		<td width="4"><img src="images/c2.gif" width="4" height="4"></td>
  	</tr>
</table> 
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="fside">
   <tr class="white">
      <td width="100%"><?=AMSG_SERVER_LOAD;?></td>
      <td><?=$site_status['server_load'];?>
      </td>
   </tr>
   <tr>
      <td width="100%"><strong><?=AMSG_NUMBER_OF_AUCTIONS;?></strong></td>
      <td><strong><?=$site_status['total_auctions'];?></strong></td>
   </tr>
   <tr class="white">
      <td width="100%"><?=AMSG_OPEN_AUCTIONS;?></td>
      <td><?=$site_status['open_auctions'];?>
      </td>
   </tr>
   <tr class="white">
      <td width="100%"><?=AMSG_CLOSED_AUCTIONS;?></td>
      <td><?=$site_status['closed_auctions'];?></td>
   </tr>
   <tr class="white">
      <td width="100%"><?=AMSG_SUSPENDED_AUCTIONS;?></td>
      <td><?=$site_status['suspended_auctions'];?></td>
   </tr>
   <tr class="white">
      <td width="100%"><?=AMSG_AUCTIONS_AWAITING_APPROVAL;?></td>
      <td><?=$site_status['unapproved_auctions'];?></td>
   </tr>
   <tr class="white">
      <td width="100%"><?=AMSG_AUCTIONS_MARKED_DELETED;?></td>
      <td><?=$site_status['deleted_auctions'];?></td>
   </tr>
   <tr>
      <td width="100%"><strong><?=AMSG_NUMBER_OF_USERS;?></strong></td>
      <td><strong><?=$site_status['total_users'];?></strong></td>
   </tr>
   <tr class="white">
      <td width="100%"><?=AMSG_ACTIVE_USERS;?></td>
      <td><?=$site_status['active_users'];?></td>
   </tr>
   <tr class="white">
      <td width="100%"><?=AMSG_SUSPENDED_USERS;?></td>
      <td><?=$site_status['suspended_users'];?></td>
   </tr>
   <tr class="white">
      <td width="100%"><?=AMSG_ONLINE_USERS;?></td>
      <td><?=online_users(true);?></td>
   </tr>
   
   <tr>
      <td width="100%" colspan="2"><strong><?=AMSG_TASKS;?></strong></td>
   </tr>
   <tr class="white">
      <td width="100%"><a href="list_auctions.php?status=approval"><?=AMSG_AUCTIONS_AWAITING_APPROVAL;?></a></td>
      <td><?=$site_status['awaiting_approval'];?></td>
   </tr>
   <tr class="white">
      <td width="100%"><a href="abuse_reports.php"><?=AMSG_ABUSE_REPORTS_TITLE;?></a></td>
      <td><?=$site_status['abuse_reports'];?></td>
   </tr>
   <tr class="white">
      <td width="100%"><a href="table_suggested_categories.php"><?=AMSG_SUGGESTED_CATEGORIES;?></a></td>
      <td><?=$site_status['suggested_categories'];?></td>
   </tr>
   <? if ($convert_tax['result']) { ?>
   <tr class="white">
      <td width="100%" colspan="2"><?=AMSG_TO_DO_TAX_1;?> <b><?=$convert_tax['invoices'];?></b> <?=AMSG_TO_DO_TAX_2;?>
      	<b><?=$convert_tax['winners'];?></b> <?=AMSG_TO_DO_TAX_3;?>.<br><br>
      	<?=AMSG_CLICK;?> [ <a href="general_settings.php?page=convert_tax"><?=AMSG_HERE;?></a> ] <?=AMSG_TO_DO_TAX_4;?></td>
   </tr>
   <? } ?>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
   	<td width="4"><img src="images/c3.gif" width="4" height="4"></td>
   	<td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
   	<td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table> 
<br>
<div class="mainhead1"><img src="images/stat.gif" align="absmiddle"> <?=AMSG_SERVER_INFO;?></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  	<tr>
  		<td width="4"><img src="images/c1.gif" width="4" height="4"></td>
  		<td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
  		<td width="4"><img src="images/c2.gif" width="4" height="4"></td>
  	</tr>
</table> 
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="fside">
   <tr class="white">
      <td width="100%" colspan="2"><b><?=AMSG_SERVER_SOFTWARE;?></b></td>
   </tr>
   <tr>
      <td width="100%" colspan="2"><?=$_SERVER['SERVER_SOFTWARE'];?></td>
   </tr>
   <tr class="white">
      <td><strong><?=AMSG_SERVER_NAME;?></strong></td>
      <td width="100%"><?=$_SERVER['SERVER_NAME'];?></td>
   </tr>
   <tr class="white">
      <td><strong><?=AMSG_SERVER_ADDRESS;?></strong></td>
      <td width="100%"><?=$_SERVER['SERVER_ADDR'];?></td>
   </tr>
   <tr class="white">
      <td><strong><?=AMSG_SERVER_PORT;?></strong></td>
      <td width="100%"><?=$_SERVER['SERVER_PORT'];?></td>
   </tr>
   <tr class="white">
      <td nowrap><strong><?=AMSG_GD_VERSION;?></strong></td>
      <td width="100%"><?=$gd_info['GD Version'];?></td>
   </tr>
   <tr class="white">
      <td nowrap><strong><?=AMSG_MYSQL_VERSION;?></strong></td>
      <td width="100%"><?=$db->get_sql_field("SELECT VERSION() AS VE", 'VE');?></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
   	<td width="4"><img src="images/c3.gif" width="4" height="4"></td>
   	<td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
   	<td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table> 
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="4"><img src="images/c1.gif" width="4" height="4"></td>
		<td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
		<td width="4"><img src="images/c2.gif" width="4" height="4"></td>
	</tr>
</table> 
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="fside">
	<tr>
		<td><b>
         <?=AMSG_ADMIN_AREA_LANGUAGE;?>
         </b></td>
	</tr>
   <form name="form_admin_area_language" method="post" action="index.php">
      <tr class="white">
         <td><?=AMSG_CURRENT_LANG;?>: <b>
            <?=$setts['admin_lang'];?>
            </b></td>
      </tr>
      <tr class="white">
         <td><?=$admin_lang_drop_down;?>
            <input type="submit" name="form_change_language" value="<?=GMSG_CHANGE;?>"></td>
      </tr>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 	<tr>
 		<td width="4"><img src="images/c3.gif" width="4" height="4"></td>
 		<td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
 		<td width="4"><img src="images/c4.gif" width="4" height="4"></td>
 	</tr>
</table>