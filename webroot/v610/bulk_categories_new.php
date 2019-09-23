<? 
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=MSG_BULK_SCHEMA;?></title>
<link href="<? echo (IN_ADMIN == 1) ? '' : 'themes/' . $setts['default_theme'] . '/'; ?>style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<tr class="c4"> 
		<td width="100%"><b>Direct Payment Gateways IDs</b></td> 
	</tr> 
	<tr> 
		<td width="100%">Below are the IDs of the direct payment gateways available, you should use the category number listed on the left column.</td> 
	</tr> 
	<tr align="center"> 
		<td width="100%"> 
			<table width="100%" cellspacing="1" border="0" cellpadding="2" class="contentfont"> 
				<tr class="c3"> 
					<td width="25%" align="center"><b>Direct Payment Gateway ID</b></td> 
          		<td><b>Payment Gateway Name</b></td> 
				</tr> 
				<?
				$sql_select_dp = $db->query("SELECT * FROM " . DB_PREFIX . "payment_gateways WHERE dp_enabled=1");
				
				while ($dp_details = $db->fetch_array($sql_select_dp)) { ?>
				<tr valign="top" class="c1"> 
					<td align="center"><?=$dp_details['pg_id'];?></td> 
					<td><?=$dp_details['name'];?></td>
				</tr> 
				<? } ?>
      	</table></td> 
	</tr> 
</table> 
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<tr class="c4"> 
		<td width="100%"><b>Offline Payment Gateways IDs</b></td> 
	</tr> 
	<tr> 
		<td width="100%">Below are the IDs of the offline payment gateways available, you should use the category number listed on the left column.</td> 
	</tr> 
	<tr align="center"> 
		<td width="100%"> 
			<table width="100%" cellspacing="1" border="0" cellpadding="2" class="contentfont"> 
				<tr class="c3"> 
					<td width="25%" align="center"><b>Offline Payment Gateway ID</b></td> 
          		<td><b>Payment Gateway Name</b></td> 
				</tr> 
				<?
				$sql_select_op = $db->query("SELECT * FROM " . DB_PREFIX . "payment_options");
				
				while ($op_details = $db->fetch_array($sql_select_op)) { ?>
				<tr valign="top" class="c1"> 
					<td align="center"><?=$op_details['id'];?></td> 
					<td><?=$op_details['name'];?></td>
				</tr> 
				<? } ?>
      	</table></td> 
	</tr> 
</table> 
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
	<tr class="c4"> 
		<td width="100%"><b><?=MSG_CATEGORY_IDS;?></b></td> 
	</tr> 
	<tr> 
		<td width="100%"><?=MSG_BULK_NOTE;?></td> 
	</tr> 
	<tr align="center"> 
		<td width="100%"> 
			<table width="100%" cellspacing="1" border="0" cellpadding="2" class="contentfont"> 
				<tr class="c3"> 
					<td width="25%" align="center"><b><?=MSG_CATEGORY_ID;?></b></td> 
          		<td><b><?=MSG_CATEGORY_NAME;?></b></td> 
				</tr> 
				<?
				reset($categories_array);
			
				foreach ($categories_array as $key => $value)
				{
					list($category_name, $user_id) = $value;
			
					$has_subcats = $db->count_rows('categories', "WHERE parent_id='" . $key . "'");
					
					if (!$has_subcats && ($user_id == 0 || $user_id = $session->value('user_id')))	{ ?>
				<tr valign="top" class="c1"> 
					<td align="center"><?=$key;?></td> 
					<td><?=$category_name;?></td>
				</tr> 
					<? } ?>
				<? } ?>
      	</table></td> 
	</tr> 
	<tr align="center"> 
		<td width="100%"><a href="Javascript:window.close()"><?=GMSG_CLOSE;?></a></td> 
  	</tr> 
</table> 
</body>
</html>
