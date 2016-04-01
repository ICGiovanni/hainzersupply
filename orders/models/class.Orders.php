<?php if(!isset($_SESSION)) {
			session_start();
	  }
	require_once($_SERVER["REDIRECT_PATH_CONFIG"].'models/connection/class.Connection.php');


class Order {
	private $connect;
	
	function __construct()
	{
		$c=new Connection();
		$this->connect=$c->db;
	}
	
	public function getProducts(){
		
		$sql="SELECT wp.ID,(SELECT meta_value
FROM wp_postmeta wpm
WHERE meta_key='_sku' AND post_id=wp.ID
LIMIT 0,1) AS Sku,wp.post_title AS Name,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='attribute_pa_colores'
AND wpm.post_id=wp.ID
LIMIT 0,1)!='',
(SELECT name
FROM wp_terms
WHERE slug=(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='attribute_pa_colores'
AND wpm.post_id=wp.ID
LIMIT 0,1)
LIMIT 0,1),'') AS Color,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='attribute_pa_tallas'
AND wpm.post_id=wp.ID
LIMIT 0,1)!='',
(SELECT name
FROM wp_terms
WHERE slug=(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='attribute_pa_tallas'
AND wpm.post_id=wp.ID
LIMIT 0,1)
LIMIT 0,1),'') AS Size,
IF((SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_stock' AND post_id=wp.ID
LIMIT 0,1)!=0,
((SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_stock' AND post_id=wp.ID
LIMIT 0,1)),15) AS Stock,
(SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_price' AND post_id=wp.ID
LIMIT 0,1) AS Price,
IF(post_parent=0,
(SELECT GROUP_CONCAT(name SEPARATOR ',')
FROM wp_term_relationships wtr
INNER JOIN wp_term_taxonomy wtt ON wtt.term_id=wtr.term_taxonomy_id
INNER JOIN wp_terms wt ON wt.term_id=wtt.term_id
WHERE object_id=wp.ID
AND wtt.taxonomy='product_cat'),
(SELECT GROUP_CONCAT(name SEPARATOR ',')
FROM wp_term_relationships wtr
INNER JOIN wp_term_taxonomy wtt ON wtt.term_id=wtr.term_taxonomy_id
INNER JOIN wp_terms wt ON wt.term_id=wtt.term_id
WHERE object_id=wp.post_parent
AND wtt.taxonomy='product_cat')) AS Category,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='_trademark'
AND wpm.post_id=wp.ID
LIMIT 0,1)!='',(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='_trademark'
AND wpm.post_id=wp.ID
LIMIT 0,1),'') AS Trademark,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='type_product'
AND wpm.post_id=wp.ID
LIMIT 0,1)!='',(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='type_product'
AND wpm.post_id=wp.ID
LIMIT 0,1),'') AS Type,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='line_product'
AND wpm.post_id=wp.ID
LIMIT 0,1)!='',(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='line_product'
AND wpm.post_id=wp.ID
LIMIT 0,1),'') AS Line,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='gender_product'
AND wpm.post_id=wp.ID
LIMIT 0,1)!='',(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='gender_product'
AND wpm.post_id=wp.ID
LIMIT 0,1),'') AS Gender,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='_thumbnail_id'
AND wpm.post_id=wp.ID
LIMIT 0,1)!=0,
(SELECT guid
FROM wp_posts
WHERE ID=(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='_thumbnail_id'
AND wpm.post_id=wp.ID
LIMIT 0,1)),'') AS Img
FROM wp_posts wp
WHERE post_type IN('product_variation','product')
AND (SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_price' AND post_id=wp.ID
LIMIT 0,1)!=0
AND (SELECT meta_value
FROM wp_postmeta wpm
WHERE meta_key='_sku' AND post_id=wp.ID
LIMIT 0,1)!=''
AND (SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_stock' AND post_id=wp.ID
LIMIT 0,1)!=0;";

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
		
		$sql = "INSERT INTO inv_orden_compra (	
				idDistribuidor,
				inv_orden_compra_status_id,
				inv_orden_compra_productos,
				inv_orden_compra_suma_precio_lista,
				inv_orden_compra_factor_descuento,
				inv_orden_compra_suma_promociones,
				inv_orden_compra_subtotal,
				inv_orden_compra_iva,
				inv_orden_compra_total,
				inv_orden_compra_created_date, inv_orden_compra_created_timestamp
			) VALUES (
				".$_SESSION['login_user']['idDistribuidor'].",
				:inv_orden_compra_status_id,
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
		
		$statement->bindParam(':inv_orden_compra_status_id', $params['inv_orden_compra_status_id'], PDO::PARAM_STR);
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
	
	public function getOrders($idDistribuidor = 0){
		
		$sql_by_distributor = '';
		if($idDistribuidor > 0){
			$sql_by_distributor = 'idDistribuidor = :idDistribuidor AND';
		}
		
		$sql="SELECT 
			idDistribuidor,
			nombre,
			inv_orden_compra_id,
			inv_orden_compra_status_id,
			inv_orden_compra_status_desc,
			inv_orden_compra_productos,
			inv_orden_compra_suma_precio_lista,
			inv_orden_compra_factor_descuento,
			inv_orden_compra_suma_promociones,
			inv_orden_compra_subtotal,
			inv_orden_compra_iva,
			inv_orden_compra_total,
			inv_orden_compra_created_date
		FROM inv_orden_compra 
		INNER JOIN inv_orden_compra_status USING(inv_orden_compra_status_id)
		INNER JOIN inv_distribuidores USING (idDistribuidor)
		WHERE ".$sql_by_distributor." (inv_orden_compra_status_id = 1 OR inv_orden_compra_created_date >= DATE_SUB(curdate(), INTERVAL 2 WEEK) )ORDER BY inv_orden_compra_id DESC";

		$statement=$this->connect->prepare($sql);
		if($idDistribuidor > 0){
			$statement->bindParam(':idDistribuidor', $idDistribuidor, PDO::PARAM_STR);
		}
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;

	}

	public function selectOrderStatus($idSelect='orderStatus', $idSelected='1'){

		$select = '<select id="'.$idSelect.'" name="'.$idSelect.'" class="form-control"><option >--Select Profile--</option>';

		$options = '';
		$opt_value = $this->getOrdersStatus();

		while(list($id, $name) = each($opt_value) ){
			$selected = '';
			if($id == $idSelected) $selected=' selected';
			$options.='<option value="'.$id.'"'.$selected.'>'.$name.'</option>';
		}

		$select.=$options.'</select>';
		return $select;
	}

	public function getOrdersStatus(){

		$sql = "SELECT inv_orden_compra_status_id, inv_orden_compra_status_desc FROM inv_orden_compra_status;";

		$statement = $this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

		$assoc_result = array();
		while(list(,$data)=each($result)){
			$assoc_result[$data['inv_orden_compra_status_id']]=$data['inv_orden_compra_status_desc'];
		}

		return(!empty($assoc_result))?$assoc_result:false;
	}

	public function changeOrderStatus($idOrder, $newStatusId, $jsonProducts){

		$products = json_decode($jsonProducts);
		$sinStock = '';
		if($newStatusId == 2){
			//die($_SERVER['REDIRECT_PATH_CONFIG'].'excel/models/class.Inventory.php');
			require_once($_SERVER['REDIRECT_PATH_CONFIG'].'excel/models/class.Inventory.php');

			$inventory=new Inventory();
			$general=new General();

			while(list($num, $item) = each($products->rows)){
				//echo "actualizar ".$item->sku." en stock menos ".$item->quantity."<br>";
				$now = intval($inventory->GetStockbySku($item->sku));

				if($now >= $item->quantity){
					//echo "actualiza ";
					$inventory->UpdateStockbySku($item->sku,$item->quantity);
				} else {
					$sinStock.="-sku= ".$item->sku.", items en stock=".$now.", items solicitados=".$item->quantity." <br>";
				}

			}
		}

		if(!empty($sinStock)){
			die($sinStock);
		}

		/////
		$sql = "UPDATE inv_orden_compra SET
			inv_orden_compra_status_id = :inv_orden_compra_status_id
			WHERE
				inv_orden_compra_id = :inv_orden_compra_id";

		$statement = $this->connect->prepare($sql);

		$statement->bindParam(':inv_orden_compra_status_id', $newStatusId, PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_id', $idOrder, PDO::PARAM_STR);

        $statement->execute();
		die("success update");
	}

	public function getProductoSinStock(){
		$sql="SELECT wp.ID,(SELECT meta_value
FROM wp_postmeta wpm
WHERE meta_key='_sku' AND post_id=wp.ID
LIMIT 0,1) AS Sku,wp.post_title AS Name,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='attribute_pa_colores'
		AND wpm.post_id=wp.ID
LIMIT 0,1)!='',
(SELECT name
FROM wp_terms
WHERE slug=(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='attribute_pa_colores'
		AND wpm.post_id=wp.ID
LIMIT 0,1)
LIMIT 0,1),'') AS Color,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='attribute_pa_tallas'
		AND wpm.post_id=wp.ID
LIMIT 0,1)!='',
(SELECT name
FROM wp_terms
WHERE slug=(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='attribute_pa_tallas'
		AND wpm.post_id=wp.ID
LIMIT 0,1)
LIMIT 0,1),'') AS Size,
IF((SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_stock' AND post_id=wp.ID
LIMIT 0,1)!=0,
((SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_stock' AND post_id=wp.ID
LIMIT 0,1)),15) AS Stock,
(SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_price' AND post_id=wp.ID
LIMIT 0,1) AS Price,
IF(post_parent=0,
(SELECT GROUP_CONCAT(name SEPARATOR ',')
FROM wp_term_relationships wtr
INNER JOIN wp_term_taxonomy wtt ON wtt.term_id=wtr.term_taxonomy_id
INNER JOIN wp_terms wt ON wt.term_id=wtt.term_id
WHERE object_id=wp.ID
		AND wtt.taxonomy='product_cat'),
(SELECT GROUP_CONCAT(name SEPARATOR ',')
FROM wp_term_relationships wtr
INNER JOIN wp_term_taxonomy wtt ON wtt.term_id=wtr.term_taxonomy_id
INNER JOIN wp_terms wt ON wt.term_id=wtt.term_id
WHERE object_id=wp.post_parent
		AND wtt.taxonomy='product_cat')) AS Category,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='_trademark'
		AND wpm.post_id=wp.ID
LIMIT 0,1)!='',(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='_trademark'
		AND wpm.post_id=wp.ID
LIMIT 0,1),'') AS Trademark,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='type_product'
		AND wpm.post_id=wp.ID
LIMIT 0,1)!='',(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='type_product'
		AND wpm.post_id=wp.ID
LIMIT 0,1),'') AS Type,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='line_product'
		AND wpm.post_id=wp.ID
LIMIT 0,1)!='',(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='line_product'
		AND wpm.post_id=wp.ID
LIMIT 0,1),'') AS Line,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='gender_product'
		AND wpm.post_id=wp.ID
LIMIT 0,1)!='',(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='gender_product'
		AND wpm.post_id=wp.ID
LIMIT 0,1),'') AS Gender,
IF((SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='_thumbnail_id'
		AND wpm.post_id=wp.ID
LIMIT 0,1)!=0,
(SELECT guid
FROM wp_posts
WHERE ID=(SELECT meta_value
FROM wp_postmeta wpm
WHERE wpm.meta_key='_thumbnail_id'
		AND wpm.post_id=wp.ID
LIMIT 0,1)),'') AS Img
FROM wp_posts wp
WHERE post_type IN('product_variation','product')
		AND (SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key='_price' AND post_id=wp.ID
LIMIT 0,1)!=0
		AND (SELECT meta_value
FROM wp_postmeta wpm
WHERE meta_key='_sku' AND post_id=wp.ID
LIMIT 0,1)!=''";

		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);

		return $result;

	}
}
?>