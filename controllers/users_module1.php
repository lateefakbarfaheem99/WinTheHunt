<?php
function obfGetBeforeFilter($this)
    {
    obfRunBeforeFilter($this);
    }
function obfGetIndex($this)
    {
    obfRunIndex($this);
    }
function obfGetGetEndTime()
    {
    return obfRunGetEndTime();
    }
function obfGetAdminAdd($this)
    {
    return obfRunAdminAdd($this);
    }
function obfGetLicensing($this)
    {
//    if ((isset($_POST['license_reset']) || isset($_GET['license_reset'])))
//        {
//        licensing::store_local_key('');
//        }
//    $returned = licensing::validate_license('3a78d9a8dbb73214b7181339f0e6fe47', 'http://members.phppennyauction.com/license/license_server', 'http://members.phppennyauction.com/license/api/index.php', Configure::read('App.license'));
//    if (!is_array($returned))
//        {
//        $this->Session->setFlash(__('License validation problem: ', true) . $returned);
//        return false;
//        }
    return true;
    }
require_once('..' . DS . 'controllers' . DS . 'users_module2.php');
?>