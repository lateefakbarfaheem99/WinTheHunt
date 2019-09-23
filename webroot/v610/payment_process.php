<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once ('includes/global.php');## PHP Pro Bid v6.00 we need to figure out what payment gateway is used somehow## PHP Pro Bid v6.00 then depending on each payment gateway, we process the variables returned.## PHP Pro Bid v6.00 then we save the information, all info is the same for every gateway
?>