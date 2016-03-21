<?php
require_once('models/class.Inventory.php');

$inventory=new Inventory();
$general=new General();

echo "Now: ".$inventory->GetStockbySku('4970856-A-G')."<br>";
echo $inventory->UpdateStockbySku('4970856-A-G','1');
echo "After: ".$inventory->GetStockbySku('4970856-A-G')."<br>";

?>