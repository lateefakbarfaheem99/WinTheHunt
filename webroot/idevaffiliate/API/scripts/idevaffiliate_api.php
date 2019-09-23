<?PHP
#############################################################
## iDevAffiliate Version 6
## Copyright - iDevDirect.com L.L.C.
## Website: http://www.idevdirect.com/
## Support: http://www.idevsupport.com/
## Email:   support@idevdirect.com
#############################################################

// CONNECT TO THE DATABASE @ MAKE SITE CONFIG SETTINGS AVAILABLE
// ----------------------------------------------------------------
require_once("../../API/config.php");
include_once("../../includes/validation_functions.php");

// QUERY THE DATABASE FOR SECRET KEY
// ------------------------------------------------------------------------------
$s_key = mysql_query("select secret from idevaff_config");
$s_key = mysql_fetch_array($s_key);
$s_key = $s_key['secret'];

// CHECK VALID SECRET KEY IS PRESENT AND VALID
// - The variable is already sanitized.
// - The variable is already validated through global $$, _GET, or _POST.
// ------------------------------------------------------------------------------

$secret = check_type('secret');
if ($secret == $s_key) {

###################################################################
##  Write queries here.
##  For more information, login to your admin center and click on the Home link in the header.
##  Then click on the iDevAffiliate Information link in the upper right corner of the screen.
##  You'll find a link to the API manual on that page.
###################################################################

}

?>
