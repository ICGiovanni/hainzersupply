<?php
require_once('models/class.Inventory.php');

$inventory=new Inventory();
$general=new General();

//echo $inventory->getSku('3291-140-000');

//echo time();
echo $general->NameToURL('SQUADRON, LED ADVENTURE BIKE KIT');
?>