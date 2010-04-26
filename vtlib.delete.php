<?php
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Module.php');

$module = Vtiger_Module::getInstance('Deliverynote');
if($module) {
    $module->delete();
}
?>