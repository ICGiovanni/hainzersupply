
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
}
?>

