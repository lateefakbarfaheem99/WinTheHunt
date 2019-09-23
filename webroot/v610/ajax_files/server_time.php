<?php 
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 
header("Expires: Fri, 1 Jan 2010 00:00:00 GMT"); // Date in the past 
$now = new DateTime(); 
echo $now->format("M j, Y H:i:s O")."\n"; 
?>