<?php
require_once('models/class.Inventory.php');

$inventory=new Inventory();

echo $inventory->getSku('3291-140-000');

echo time();

?>