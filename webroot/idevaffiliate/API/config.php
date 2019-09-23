<?PHP

#############################################################
## iDevAffiliate Version 6
## Copyright - iDevDirect.com L.L.C.
## Website: http://www.idevdirect.com/
## Support: http://www.idevsupport.com/
## Email:   support@idevdirect.com
#############################################################

	$install_directory_name = "/webroot/idevaffiliate";

######################################################################
################### DO NOT EDIT BELOW THIS LINE ######################
######################################################################
if (!isset($_SERVER['DOCUMENT_ROOT'])) {
$path = $_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF'])));
} else { $path = $_SERVER['DOCUMENT_ROOT']; }
$path = $path.'/'.$install_directory_name;
include($path.'/API/data.php');
######################################################################

?>