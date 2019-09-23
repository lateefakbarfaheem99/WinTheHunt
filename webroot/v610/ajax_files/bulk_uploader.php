<?
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

if (isset($_FILES['bulk_file']) && is_uploaded_file($_FILES['bulk_file']['tmp_name']) && $_FILES['bulk_file']['error'] == 0) 
{
	$file_id = md5(uniqid(rand(2,99999999))); // generated the unique id for the new page
	$name = 'bulk_file-ID-' . $file_id . '.csv';
	$is_upload = copy($_FILES['bulk_file']['tmp_name'], '../uplimg/' . $name);
	echo $name;
}

exit(0);

?>