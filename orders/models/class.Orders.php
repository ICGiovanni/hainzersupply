<?php session_start();
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
LIMIT 0,1) AS Sku,
IF(post_title!='',post_title,
(SELECT post_title
FROM wp_posts
WHERE ID=wp.post_parent)) AS Name,
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
LIMIT 0,1)),0) AS Stock,
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
				idDistribuidorFactura,
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
				:idDistribuidorFactura,
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
		$statement->bindParam(':idDistribuidorFactura', $params['idDistribuidorFactura'], PDO::PARAM_STR);
		
		$statement->execute();
		return $this->connect->lastInsertId();
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
			inv_orden_compra_costo_envio,
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
	
	public function getOrderData($idOrder){
		$sql="SELECT 
			idDistribuidor,
			nombre,
			inv_orden_compra_productos,
			inv_orden_compra_factor_descuento,
			inv_orden_compra_subtotal,
			inv_orden_compra_iva,
			inv_orden_compra_costo_envio,
			inv_orden_compra_total,
			inv_orden_compra_created_date,
			idDistribuidorFactura
		FROM inv_orden_compra 
		INNER JOIN inv_orden_compra_status USING(inv_orden_compra_status_id)
		INNER JOIN inv_distribuidores USING (idDistribuidor)
		WHERE inv_orden_compra_id = :inv_orden_compra_id ";

		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':inv_orden_compra_id', $idOrder, PDO::PARAM_STR);
		
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	public function selectOrderStatus($idSelect='orderStatus', $idSelected='1', $idDistribuidor=0){
		
		$select = '<select id="'.$idSelect.'" name="'.$idSelect.'" class="form-control"><option value="1" >--Select Profile--</option>';
		
		$options = '';		
		$opt_value = $this->getOrdersStatus();
		
		while(list($id, $name) = each($opt_value) ){
			$selected = '';
			if($id == $idSelected) 
				$selected=' selected';
			if($idDistribuidor==0 || $id != 2)
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
		$createBill = false;
		
		
		if($newStatusId == 2){ //compra realizada
			
			require_once($_SERVER['REDIRECT_PATH_CONFIG'].'excel/models/class.Inventory.php');
			$createBill = true;
			$inventory=new Inventory();
			$general=new General();

			while(list($num, $item) = each($products->rows)){
				//echo "actualizar ".$item->sku." en stock menos ".$item->quantity."<br>";
				$now = intval($inventory->GetStockbySku($item->sku));

				if($now >= $item->quantity){
					//echo "actualiza ";
					//$inventory->UpdateStockbySku($item->sku,$item->quantity);
				} else {
					$sinStock.="-sku= ".$item->sku.", items en stock=".$now.", items solicitados=".$item->quantity." <br>";
					$createBill = false;
				}
					
			}
		}
		
		if(!empty($sinStock)){
			return $sinStock;
			die();
		}
		
		/////
		$sql = "UPDATE inv_orden_compra SET
			inv_orden_compra_status_id = :inv_orden_compra_status_id
			WHERE
				inv_orden_compra_id = :inv_orden_compra_id";
			
		$statement = $this->connect->prepare($sql);

		$statement->bindParam(':inv_orden_compra_status_id', $newStatusId, PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_id', $idOrder, PDO::PARAM_STR); 

       // $statement->execute();
		
		
		if($createBill){
			
			$metodoPago = 'TRANSFERENCIA ELECTRÓNICA';
			$lugarExpedicion = 'CIUDAD DE MÉXICO';
			$numCuentaPago = '4712';			
			
			/* datos del emisor moto depot*/
			$rfc_e_19 = 'AAA010101AAA';//'MDE160125SJ8';
			$companyName_e_20 = 'Moto Depot S.A. De C.V.';
			$regime_e_21 = 'RÉGIMEN GENERAL DE LEY PERSONAS MORALES';
			$street_e_22 = 'Av. Venustiano Carranza';
			$exteriorNum_e_23 = '1475';
			$interiorNum_e_24 = '';
			$colonia_e_25 = 'Tequisquiapan';
			$municipio_e_28 = 'San Luis Potosí';
			$estado_e_29 = 'San Luis Potosí';
			$country_e_30 = 'MÉXICO';
			$postalCode_e_31 = '78250';
			/* datos del emisor moto depot*/

			/* datos de la orden de compra */			
			$dataOrderChange = $this->getOrderData($idOrder);

			$idDistribuidor = $dataOrderChange[0]["idDistribuidor"];
			$idDistribuidorFactura = $dataOrderChange[0]["idDistribuidorFactura"];
			$subtotal_188 = $dataOrderChange[0]["inv_orden_compra_subtotal"];
			$impuesto_trasladado_201 = 'IVA';
			$tasa_impuesto_trasladado_202 = '16.00';
			$importe_impuestos_trasladados_203 = $dataOrderChange[0]["inv_orden_compra_iva"];
			$total_impuestos_trasladados_204 = $dataOrderChange[0]["inv_orden_compra_iva"];
			$gran_total = $dataOrderChange[0]["inv_orden_compra_total"];
			$costo_envio = $dataOrderChange[0]["inv_orden_compra_costo_envio"];

			$products = json_decode($dataOrderChange[0]["inv_orden_compra_productos"]);
			$unidad_82 = "PZA.";
			$txtStringProductos = '';
	
			while(list($indexP,$product)=each($products->rows)){
				$cantidad_81 = $product->quantity;
				$descripcion_84 = $product->name;
				$precio_unitario_85 = $product->unit_list_price;
				$importe_86 = $product->amount_price;
				
				$txtStringProductos.= 'PTDA|'.$cantidad_81.'|'.$unidad_82.'|0|'.$descripcion_84.'|'.$precio_unitario_85.'|'.$importe_86.'||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||'.chr(13).chr(10);
			}
			
			if($costo_envio > 0){
				$costo_envio_sin_iva = round(($costo_envio / 1.16), 2);
				$iva_costo_envio = $costo_envio - $costo_envio_sin_iva;
				
				$cantidad_81 = "1";
				$unidad_82 = "N/A";
				$descripcion_84 = "costo de envío";
				$precio_unitario_85 = $costo_envio_sin_iva;
				$importe_86 = $costo_envio_sin_iva;

				$txtStringProductos.= 'PTDA|'.$cantidad_81.'|'.$unidad_82.'|0|'.$descripcion_84.'|'.$precio_unitario_85.'|'.$importe_86.'||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||'.chr(13).chr(10);

			}
			
			/* datos de la orden de compra */			
			
			/* datos del receptor */			
			require_once($_SERVER['REDIRECT_PATH_CONFIG']."models/distribuidores/class.Distribuidores.php");
			$insDistribuidor = new Distribuidores();
			$dataDistribuidor = $insDistribuidor->getRfcOrder($idDistribuidorFactura);
		
			$rfc_r_58 = 'NFF040520UH5'; //$dataDistribuidor["rfc"];
			$companyName_r_59 = $dataDistribuidor["razonSocial"];			
			$street_r_60 = $dataDistribuidor["calle"];
			$exteriorNum_r_61 = $dataDistribuidor["numExt"];
			$interiorNum_r_62 = $dataDistribuidor["numInt"];
			$colonia_r_63 = $dataDistribuidor["colonia"];
			$municipio_r_66 = $dataDistribuidor["delegacion"];
			$estado_r_67 = $dataDistribuidor["estado"];
			$country_r_68 = $dataDistribuidor["pais"];
			$postalCode_r_69 = $dataDistribuidor["codigoPostal"];
			$conector_r_70 = 'CONECTOR1';
			/* datos del emisor moto depot*/

			$txtString = 'Y|a10|a10'.chr(13).chr(10);
			$txtString.= 'START'.chr(13).chr(10);
			$txtString.= 'CFDI|FA|||PAGO EN UNA SOLA EXHIBICION||ingreso|'.$metodoPago.'|'.$lugarExpedicion.'|'.$numCuentaPago.'|||||||1|COMENTARIOS: |||||||||||||||||||'.chr(13).chr(10);
			$txtString.= 'EMSR|'.$rfc_e_19.'|'.$companyName_e_20.'|'.$regime_e_21.'|'.$street_e_22.'|'.$exteriorNum_e_23.'|'.$interiorNum_e_24.'|'.$colonia_e_25.'|||'.$municipio_e_28.'|'.$estado_e_29.'|'.$country_e_30.'|'.$postalCode_e_31.'||||||||||||||||||||'.chr(13).chr(10);
			$txtString.= 'R|'.$rfc_r_58.'|'.$companyName_r_59.'|'.$street_r_60.'|'.$exteriorNum_r_61.'|'.$interiorNum_r_62.'|'.$colonia_r_63.'|||'.$municipio_r_66.'|'.$estado_r_67.'|'.$country_r_68.'|'.$postalCode_r_69.'|'.$conector_r_70.'||||||||||||||||||||||||||||||'.chr(13).chr(10);
			$txtString.= $txtStringProductos;
			$txtString.= 'T|'.$subtotal_188.'|||||||||||||'.$impuesto_trasladado_201.'|'.$tasa_impuesto_trasladado_202.'|'.$importe_impuestos_trasladados_203.'|'.$total_impuestos_trasladados_204.'||||||'.$gran_total.'||||||||||||||||||||'.chr(13).chr(10);
			
			
			$dirFileTxt = $_SERVER['DOCUMENT_ROOT'].'/control/facturacion/'.$idDistribuidor;
			if(!is_dir($dirFileTxt)){
				mkdir($dirFileTxt,0775);
			}
			/*ZIP*/
			$rightNow = time();
			
			$nameFileTxt = 'F_XMAFAC_'.date("ymdHis", $rightNow).'.txt';
			$nameFileZip = 'F_XMAFAC_'.date("ymdHis", $rightNow).'.zip';
			$nameFileTrafficLight = 'F_XMAFAC_'.date("ymdHis", $rightNow).'_s';
			
			$txtString = mb_convert_encoding(utf8_decode($txtString), 'UTF-8', 'OLD-ENCODING');			
			file_put_contents($dirFileTxt.'/'.$nameFileTxt, $txtString);
			file_put_contents($dirFileTxt.'/'.$nameFileTrafficLight, "");
			
			$zip = new ZipArchive();
			if ($zip->open($dirFileTxt.'/'.$nameFileZip, ZipArchive::CREATE)!==TRUE) {
				exit("cannot open <$nameFileZip>\n");
			}
		
			$zip->addFile($dirFileTxt.'/'.$nameFileTxt,$nameFileTxt);			
			$zip->close();
			unlink($dirFileTxt.'/'.$nameFileTxt);
			/*ZIP*/

			/*SFTP*/
			require_once($_SERVER["REDIRECT_PATH_CONFIG"].'orders/models/Net/SFTP.php');
			$sftp = new Net_SFTP('prepcontenedor.buzone.com.mx');

			if (!$sftp->login('XMAFAC', '2AbajeswE*')) {
				exit('Login Failed');
			}			
			
			$sftp->put('/cygdrive/e/SFTPHome/XMAFAC/XMAFAC/23128/ENT/'.$nameFileZip, $dirFileTxt.'/'.$nameFileZip, NET_SFTP_LOCAL_FILE);
			//echo 'sent: '.$dirFileTxt.'/'.$nameFileZip.'<br>';
			$sftp->put('/cygdrive/e/SFTPHome/XMAFAC/XMAFAC/23128/ENT/'.$nameFileTrafficLight, $dirFileTxt.'/'.$nameFileTrafficLight, NET_SFTP_LOCAL_FILE);
			//echo 'sent: '.$dirFileTxt.'/'.$nameFileTrafficLight.'<br>';
			/*SFTP*/			
		}		
		return "success update";
	}
	
	public function changeShippingCost($idOrder, $costoEnvio){
		
		$costoEnvio = sprintf("%f",$costoEnvio);
		
		$costoEnvioSinIva = round(($costoEnvio / 1.16), 2);
		$costoEnvioIva = $costoEnvio - $costoEnvioSinIva;
				
		$sql = "UPDATE inv_orden_compra SET
			inv_orden_compra_total = inv_orden_compra_total - inv_orden_compra_costo_envio + :inv_orden_compra_costo_envio,
			inv_orden_compra_subtotal = inv_orden_compra_subtotal - inv_orden_compra_costo_envio_sin_iva + :inv_orden_compra_costo_envio_sin_iva,
			inv_orden_compra_iva = inv_orden_compra_iva - inv_orden_compra_costo_envio_iva + :inv_orden_compra_costo_envio_iva,
			inv_orden_compra_costo_envio = :inv_orden_compra_costo_envio,
			inv_orden_compra_costo_envio_sin_iva = :inv_orden_compra_costo_envio_sin_iva,
			inv_orden_compra_costo_envio_iva = :inv_orden_compra_costo_envio_iva
			WHERE
				inv_orden_compra_id = :inv_orden_compra_id";
			
		$statement = $this->connect->prepare($sql);

		$statement->bindParam(':inv_orden_compra_costo_envio', $costoEnvio, PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_costo_envio_sin_iva', $costoEnvioSinIva, PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_costo_envio_iva', $costoEnvioIva, PDO::PARAM_STR);
		$statement->bindParam(':inv_orden_compra_id', $idOrder, PDO::PARAM_STR); 

        $statement->execute();
		return "success update";
	}

	public function getProductoSinStock(){
		$sql="SELECT wp.ID,(SELECT meta_value
FROM wp_postmeta wpm
WHERE meta_key='_sku' AND post_id=wp.ID
LIMIT 0,1) AS Sku,
IF(post_title!='',post_title,
(SELECT post_title
FROM wp_posts
WHERE ID=wp.post_parent)) AS Name,
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
LIMIT 0,1)),0) AS Stock,
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
AND wp.ID NOT IN(SELECT DISTINCT(post_parent)
FROM wp_posts wp2
WHERE post_parent IS NOT NULL
AND post_type IN('product_variation','product'))";

		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);

		return $result;

	}
	
	public function sendEmailOrder($idOrder, $template = 1){
		require_once $_SERVER["REDIRECT_PATH_CONFIG"]."orders/models/class.PDF.php";
		require_once $_SERVER["REDIRECT_PATH_CONFIG"]."orders/models/class.phpmailer.php";
		require_once($_SERVER['REDIRECT_PATH_CONFIG']."models/distribuidores/class.Distribuidores.php");

		$dataOrder = $this->getOrderData($idOrder);
		
		$insDistribuidor = new Distribuidores();
		
		$dataDistribuidor = $insDistribuidor->getInfoDistribuidor($dataOrder[0]["idDistribuidor"]);
		
		
		$pdf=new PDF();
		$mail = new PHPMailer();
		
		$pdf->CreatePDF($idOrder,'L', $template);
		
		$fileName='pedido_'.$idOrder.'.pdf';
		$fileA=$rute=$_SERVER["REDIRECT_PATH_CONFIG"]."orders/pdf/".$fileName;
		$to = $dataDistribuidor['correoElectronico'];
		
		if($template == 1){
			$subject = "Moto Depot - Se ha creado el pedido #".$idOrder;
			$mjsEnvio = "(Envío no incluido)";
			$msjContent = "SU PEDIDO FUE PROCESADO Y ENVIADO CON EXITO, EN BREVE NOS PONDREMOS EN CONTACTO CON USTEDES PARA VERIFICAR ORDEN Y PAGO.";
		} else {
			$subject = "Moto Depot - Su pedido #".$idOrder." se ha actualizado";
			$mjsEnvio = "(ENVÍO INCLUIDO)";
			$msjContent = "SU PEDIDO HA SIDO ACTUALIZADO, FAVOR DE VERIFICAR LOS CAMBIOS";
		}
		
		$mail->SetFrom('test@motodepot.mx');
		
		$mail->AddReplyTo('test@motodepot.mx',"");
		$mail->AddAddress($to, "");
		
		$mail->Subject=$subject;
		
		$msj = "<html>
			<body style='background-color: #fff'>
				<p style='text-align: center; width: 300px'>
					<img src='http://motodepot.mx/control/images/Logo_MotoDepot_Control.png' width='200px' alt='Moto Depot'/>
				</p>
				<div style='background-color: #D71921'>&nbsp;</div>
				<div>	
					<br><br>					
					<table align='center'>
						<tr>
							<td><b>".$msjContent."</b></td>
						</tr>
						<tr>
							<td><b>NUMERO DE PEDIDO:</b> #".$idOrder."</td>
						</tr>
						<tr>
							<td><b>FECHA:</b> ".date("d/m/Y")."</td>
						</tr>
						<tr>
							<td><b>DISTRIBUIDOR: </b>".$dataDistribuidor[0]['nombre']."</td>
						</tr>
						<tr>
							<td><b>MONTO A PAGAR:</b> $".number_format($dataOrder[0]["inv_orden_compra_total"],2)." ".$mjsEnvio."</td>
						</tr>
						<tr>
							<td><br>EL PEDIDO VA <b>ADJUNTO</b> EN FORMATO <b>PDF</b> A ESTE CORREO.</td>
						</tr>
						<tr>
							<td>REVISAR PEDIDO EN LINEA <a href='http://motodepot.mx/control/login/' target='_blank'>AQUI</a></td>
						</tr>
						<tr>
							<td>GUARDA ESTA INFORMACIÓN PARA FUTURAS REFERENCIAS.</td>
						</tr>
					</table>
					--------------------------------------------------------------------------------------------------------
					<table align='center'>
						<tr>
							<td width='160'><img src='http://www.strodtbeck.co.uk/uploads/2/6/5/4/26549099/8452668_orig.png' width='150' /></td>
							<td>
								DATOS PARA TRANSFERENCIA O DEPÓSITO BANCARIO<br>
								BANCO: <b>Santander</b><br>
								TITULAR: Moto Depot S.A. De C.V.<br>
								No. CUENTA: 65-50554471-2<br>
								CLABE INTERBANCARIA: 014700655055447126<br>									
							</td>
						</tr>
						 <tr>
							<td colspan='2'>
								<span style='color:red; font-size:11px;'>Favor de enviar su comprabante de pago al siguiente correo: distribuidores@motodepot.mx,
								con titulo \"Pago de pedido #___\", para su procedimiento de entrega.</span>
							</td>								
						</tr>                            
					</table>
					<br><br>
				</div>
				<div style='background-color: #D71921'>
				<p style='text-align: center; padding:16px 0px; color:#fff;'>
					   <b>http://motodepot.mx/ / VISITA NUESTRO AVISO DE PRIVACIDAD PARA MAS INFORMACIÓN</b>
				</p>
				</div>
			</body>
		</html>";

		$mail->MsgHTML(utf8_decode($msj));		
		$mail->AddAttachment($fileA);
		
		if(!$mail->Send()){
			$return = "Error al enviar el mensaje: " . $mail­>ErrorInfo;
		}
		else{			
			$return = "Order ".$idOrder." sent";
		}

		if(file_exists($fileA)){
			unlink($fileA);
		}
	}
}
?>
