<?php
require_once('models/class.Inventory.php');
require_once('models/class.Log.php');

$inventory=new Inventory();
$log=new Log();

$name=date('YmdHis');
$log->GetRestore($name);

$log->Restore($name);

?>