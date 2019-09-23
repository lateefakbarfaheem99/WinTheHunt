<?php
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);
define ('IN_AJAX', 1);

include_once('../includes/global.php');

echo category_navigator(intval($_REQUEST['category_id']), false, true, null, null, GMSG_NONE_CAT, intval($_REQUEST['reverse']));

?>