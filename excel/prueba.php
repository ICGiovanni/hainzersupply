<?php
require_once('models/class.Inventory.php');
require_once('models/class.Log.php');

$inventory=new Inventory();
$log=new Log();

$inventory->UpdateStatusStock();

?>