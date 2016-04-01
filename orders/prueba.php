<html>
<head></head>
<body>
<?php 
$json='{"rows":[{"sku":"2010071","name":"CLICK RELEASE SHIELD RACEHI-DEF YELL","quantity":"1","unit_list_price":"400","price":"400.00","type_price":"normal","amount_price":"340.00"},{"sku":"2010066","name":"CLICK RELEASE SHIELD HI-DEF YELLOW","quantity":"1","unit_list_price":"1206","price":"1206.00","type_price":"normal","amount_price":"1025.10"},{"sku":"2010063","name":"CLICK RELEASE SHIELDDRK SILVER IRIDIUM","quantity":"1","unit_list_price":"1824","price":"1824.00","type_price":"normal","amount_price":"1550.40"},{"sku":"2010062","name":"CLICK RELEASE SHIELD LT GOLD IRIDIUM","quantity":"1","unit_list_price":"1824","price":"1824.00","type_price":"normal","amount_price":"1550.40"},{"sku":"2010060","name":"CLICK RELEASE SHIELD LT SILVER IRIDIUM","quantity":"1","unit_list_price":"1824","price":"1824.00","type_price":"normal","amount_price":"1550.40"}]}';

$json=json_decode($json);

$cont=0;
foreach($json->rows as $j)
{
	echo $j->sku;
}
echo $cont;
?>
</body>
</html>