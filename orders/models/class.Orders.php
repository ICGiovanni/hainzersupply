
<?php
require_once('../models/connection/class.Connection.php');

class Order {
	private $connect;
	
	function __construct()
	{
		$c=new Connection();
		$this->connect=$c->db;
	}
	
	public function getProducts(){
		
		$sql="SELECT (SELECT meta_value FROM wp_postmeta wpm WHERE meta_key='_sku' AND post_id=wp.ID) AS Sku, wp.post_title AS Name, 'ROJO' AS Color, 'M' AS Size, IF((SELECT ROUND(meta_value) FROM wp_postmeta wpm WHERE meta_key='_stock' AND post_id=wp.ID)!=0,((SELECT ROUND(meta_value) FROM wp_postmeta wpm WHERE meta_key='_stock' AND post_id=wp.ID)),15) AS Stock, (SELECT ROUND(meta_value) FROM wp_postmeta wpm WHERE meta_key='_price' AND post_id=wp.ID) AS Price, 'Descuento,Custom' AS Category FROM wp_posts wp
WHERE post_type IN('product_variation','product')
AND (SELECT ROUND(meta_value) FROM wp_postmeta wpm WHERE meta_key='_price' AND post_id=wp.ID)!=0";

		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	/*
	inv_orders
	*/
	public function insertOrder($params){
		
		$timeStamp = time();
		$createDate = date("Y-m-d",$timeStamp);
		$sql = "INSERT INTO inv_orders (	
				inv_orden_compra_status,
				inv_orden_compra_productos,
				inv_orden_compra_suma_precio_lista,
				inv_orden_compra_factor_descuento,
				inv_orden_compra_suma_promociones,
				inv_orden_compra_subtotal,
				inv_orden_compra_iva,
				inv_orden_compra_total,
				inv_orden_compra_created_date, inv_orden_compra_created_timestamp
			) VALUES (
				:inv_orden_compra_status,
				:inv_orden_compra_productos,
				:inv_orden_compra_suma_precio_lista,
				:inv_orden_compra_factor_descuento,
				:inv_orden_compra_suma_promociones,
				:inv_orden_compra_subtotal,
				:inv_orden_compra_iva,
				:inv_orden_compra_total,
				'".$createDate."', '".$timeStamp."'
			)";
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':inv_orden_compra_status', $params['inv_orden_compra_status'], PDO::PARAM_STR);
        $statement->bindParam(':inv_orden_compra_productos', $params['inv_orden_compra_productos'], PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_suma_precio_lista', $params['inv_orden_compra_suma_precio_lista'], PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_factor_descuento', $params['inv_orden_compra_factor_descuento'], PDO::PARAM_STR);
        $statement->bindParam(':inv_orden_compra_suma_promociones', $params['inv_orden_compra_suma_promociones'], PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_subtotal', $params['inv_orden_compra_subtotal'], PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_iva', $params['inv_orden_compra_iva'], PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_total', $params['inv_orden_compra_total'], PDO::PARAM_STR);
		
		$statement->execute();
		die("order_id=".$this->connect->lastInsertId());
	}
}
?>

