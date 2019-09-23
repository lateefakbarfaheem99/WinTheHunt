<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

$parent_dir = '../';

## google base plugin
define('Gbase_plugin', $parent_dir); // Path to plugin folder
include_once(Gbase_plugin . 'google_base/gbase.inc.php');

?>