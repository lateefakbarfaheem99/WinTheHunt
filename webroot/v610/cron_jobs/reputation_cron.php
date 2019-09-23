<?
#################################################################
## PHP Pro Bid v6.100														##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

include('../language/' . $setts['site_lang'] . '/mails/reputation_cron_email.php')
?>