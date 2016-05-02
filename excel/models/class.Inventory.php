<?php
//require_once('class.Connection.php');
require_once($_SERVER["REDIRECT_PATH_CONFIG"].'models/connection/class.Connection.php');
require_once('class.General.php');
require_once('class.Upload.php');

class Inventory
{
	private $connect;
	
	function __construct()
	{
		$c=new Connection();
		$this->connect=$c->db;
	}
	
	public function getSku($sku)
	{
		$sql='';
		$statement='';
		
		$sql="SELECT post_id
				FROM wp_postmeta
				WHERE meta_key='_sku' AND meta_value=:sku";
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':sku',$sku,PDO::PARAM_STR);
		
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		
		if(isset($result[0]['post_id']))
		{
			return $result[0]['post_id'];
		}
		else
		{
			return false;
		}
	}
	
	public function getHosts()
	{
		$sql="SELECT option_value
				FROM wp_options
				WHERE option_name='siteurl'";
		
		$statement=$this->connect->prepare($sql);		
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		if(isset($result[0]['option_value']))
		{
			return $result[0]['option_value'];
		}
		else
		{
			return false;
		}
	}
	
	public function GetCategory($category)
	{		
		$general=new General();
		
		$category=trim($category);
				
		$sql="SELECT wt.term_id
				FROM wp_terms wt
				WHERE name='$category'";
		
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':category',$category,PDO::PARAM_STR);
		
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		if(isset($result[0]['term_id']))
		{
			return $result[0]['term_id'];
		}
		else
		{
			//die($category." ".mb_detect_encoding($category));
			return false;
		}
	}
	
	public function GetNextTerm()
	{
		$sql="SELECT MAX(term_id)+1 AS term_id
				FROM wp_term_taxonomy";
				
		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		if(isset($result[0]['term_id']))
        {
        	return $result[0]['term_id'];
        }
        else
        {
        	return 1;
        }
	}
	
	public function InsertCategory($category)
	{
		$general=new General();
		
		$categoryId=$this->GetNextTerm();
		
		$sql = "INSERT INTO wp_terms VALUES(:categoryId,:category,:categoryUrl,0)";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':categoryId',$categoryId,PDO::PARAM_STR);
		$statement->bindParam(':category',mb_convert_case($category, MB_CASE_TITLE, "UTF-8"),PDO::PARAM_STR);
		$statement->bindParam(':categoryUrl',$general->NameToURL($category),PDO::PARAM_STR);
		$statement->execute();
		
		$sql = "INSERT INTO wp_term_taxonomy VALUES(:categoryId,:categoryId,'product_cat','',0,0)";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':categoryId',$categoryId,PDO::PARAM_STR);
		$statement->execute();
		
		return $categoryId;
	}
	
	public function CheckCategoryProduct($productId,$categoryId)
	{
		$sql="SELECT object_id
		FROM wp_term_relationships
		WHERE object_id='$productId'
		AND term_taxonomy_id='$categoryId'";
	
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		if(isset($result[0]['object_id']))
		{
			return $result[0]['object_id'];
		}
		else
		{
			return false;
		}
	}
	
	public function InsertCategoryProduct($productId,$categoryId)
	{
		$sql = "INSERT INTO wp_term_relationships VALUES(:productId,:categoryId,0)";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':productId',$productId,PDO::PARAM_STR);
		$statement->bindParam(':categoryId',$categoryId,PDO::PARAM_STR);
		$statement->execute();
		
		$sql="UPDATE wp_term_taxonomy SET count=count+1 WHERE term_taxonomy_id=:categoryId";
		
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':categoryId',$categoryId,PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function GetDataProduct($ID)
	{
		$sql="SELECT *
				FROM wp_posts
				WHERE ID=:ID";
				
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);		
		
		return $result;
	}
	
	public function GetChildrensbyColor($ID,$color)
	{
		$general=new General();
		
		$color=$general->NameToURL($color);
		$sql="SELECT ID
				FROM wp_posts wp
				INNER JOIN wp_postmeta wpm ON wpm.post_id=wp.ID
				WHERE post_parent='$ID'
				AND meta_key='attribute_pa_colores'
				AND meta_value='$color'";
		
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		return $result;
	}
	
	public function GetNextID($field,$table)
	{
		$sql="SELECT MAX($field) AS ID
				FROM $table";
				
		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		$ID=$result[0]['ID']+1;
		
		return $ID;
	}
	
	public function GetID()
	{
		$sql="SELECT MAX(ID)+1 AS ID
				FROM wp_posts";
				
		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		$ID=$result[0]['ID'];
		
		return $ID;
	}
	
	public function GetNextChildren($IDParent)
	{
		$product_variation='product_variation';
		
		$sql="SELECT COUNT(*)+1 AS ID
				FROM wp_posts
				WHERE post_parent=':ID'
				AND post_type=':product_variation'";
			
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$IDParent,PDO::PARAM_STR);
		$statement->bindParam(':product_variation',$product_variation,PDO::PARAM_STR);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);	

		return $result[0]['ID'];
	}
	
	public function GetAttribute($attribute,$taxonomy,$IDParent)
	{
		$sql="SELECT wt.term_id
				FROM wp_woocommerce_termmeta wwt
				INNER JOIN wp_terms wt ON wt.term_id=wwt.woocommerce_term_id
				INNER JOIN wp_term_taxonomy wtt ON wtt.term_id=wt.term_id
				INNER JOIN wp_term_relationships wtr ON wtr.term_taxonomy_id=wt.term_id
				WHERE wt.name=:attribute AND taxonomy=:taxonomy
				AND wtr.object_id=:IDParent";
		
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':attribute',$attribute,PDO::PARAM_STR);
		$statement->bindParam(':taxonomy',$taxonomy,PDO::PARAM_STR);
		$statement->bindParam(':IDParent',$IDParent,PDO::PARAM_STR);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		if(isset($result[0]['term_id']))
		{
			return $result[0]['term_id'];
		}
		else
		{
			return false;
		}
	}
	
	public function GetTermIdbyName($attribute)
	{
		$sql="SELECT term_id
				FROM wp_terms
				WHERE name=:attribute";
				
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':attribute',$attribute,PDO::PARAM_STR);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		if(isset($result[0]['term_id']))
		{
			return $result[0]['term_id'];
		}
		else
		{
			return false;
		}
	}
	
	public function InsertAttribute($attribute,$type,$IDParent)
	{
		$general=new General();
		
		if($type=='Colores')
		{
			$meta_key='order_pa_colores';
			$taxonomy='pa_colores';
		}
		else if($type=='Tallas')
		{
			$meta_key='order_pa_colores';
			$taxonomy='pa_tallas';
		}
		
		$termId=$this->GetTermIdbyName($attribute);
		
		if(!$termId)
		{
			$termId=$this->GetNextTerm();
			$attribute=mb_convert_case($attribute, MB_CASE_TITLE, "UTF-8");
			$slug=$general->NameToURL($attribute);
			
			$sql="INSERT INTO wp_terms VALUES(:termId,:attribute,:slug,0)";
			
			$statement=$this->connect->prepare($sql);
			$statement->bindParam(':termId',$termId,PDO::PARAM_STR);
			$statement->bindParam(':attribute',$attribute,PDO::PARAM_STR);
			$statement->bindParam(':slug',$slug,PDO::PARAM_STR);
			$statement->execute();
			
			$sql = "INSERT INTO wp_term_taxonomy VALUES(:termTaxonomyId,:termId,:taxonomy,'',0,0)";
			
			$statement=$this->connect->prepare($sql);
			$statement->bindParam(':termTaxonomyId',$termId,PDO::PARAM_STR);
			$statement->bindParam(':termId',$termId,PDO::PARAM_STR);
			$statement->bindParam(':taxonomy',$taxonomy,PDO::PARAM_STR);
			$statement->execute();
			
			$metaId=$this->GetNextID('meta_id','wp_woocommerce_termmeta');
			
			$sql = "INSERT INTO wp_woocommerce_termmeta VALUES(:metaId,:termId,:meta_key,0)";
			
			$statement=$this->connect->prepare($sql);
			$statement->bindParam(':metaId',$metaId,PDO::PARAM_STR);
			$statement->bindParam(':termId',$termId,PDO::PARAM_STR);
			$statement->bindParam(':meta_key',$meta_key,PDO::PARAM_STR);
			$statement->execute();
		}
		
		if(!$this->GetTermRelationship($IDParent,$termId))
		{
			$sql = "INSERT INTO wp_term_relationships VALUES($IDParent,$termId,0)";
			
			$statement=$this->connect->prepare($sql);
			$statement->bindParam(':objectID',$IDParent,PDO::PARAM_STR);
			$statement->bindParam(':termId',$termId,PDO::PARAM_STR);
			$statement->execute();
		}		
	}
	
	public function getThumbnail($ID)
	{
		$sql="SELECT post_id
				FROM wp_postmeta wpm
				WHERE wpm.post_id='$ID'
				AND wpm.meta_key='_thumbnail_id'
				AND wpm.meta_value!=''
				AND wpm.meta_value!=0";
		
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		if(isset($result[0]['post_id']))
		{
			return $result[0]['post_id'];
		}
		else
		{
			return false;
		}
	}
	
	public function GetPropertyMeta($ID,$property)
	{
		$sql="SELECT post_id
		FROM wp_postmeta wpm
		WHERE wpm.post_id='$ID'
		AND wpm.meta_key='$property'";
	
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		if(isset($result[0]['post_id']))
		{
			return $result[0]['post_id'];
		}
		else
		{
			return false;
		}
	}
	
	public function getGallery($ID)
	{
		$sql="SELECT meta_value
				FROM wp_postmeta wpm
				WHERE wpm.post_id='$ID'
				AND meta_key='_product_image_gallery'";
	
		$statement=$this->connect->prepare($sql);
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		if(isset($result[0]['meta_value']))
		{
			return $result[0]['meta_value'];
		}
		else
		{
			return false;
		}
	}
	
	
	public function GetTermRelationship($ID,$termId)
	{
		$sql="SELECT term_taxonomy_id
				FROM wp_term_relationships
				WHERE object_id='$ID' AND term_taxonomy_id='$termId'";
	
		$statement=$this->connect->prepare($sql);
	
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':termId',$termId,PDO::PARAM_STR);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		if(isset($result[0]['term_taxonomy_id']))
		{
			return $result[0]['term_taxonomy_id'];
		}
		else
		{
			return false;
		}
	}
	
	public function InsertProductVariable($sku,$IDParent,$product,$stock,$price,$color,$size,$trademark,$typeProduct,$lineProduct,$genderProduct)
	{
		$general=new General();
				
		$ID=$this->GetID();
		
		$dataParent=$this->GetDataProduct($IDParent);
		
		$IDVariation=$this->GetNextChildren($IDParent);
		
		$color=$general->ReplaceSlash($color);
		
		$postAuthor=2;
		$postDate=date('Y-m-d H:i:s');
		$postDateGMT=$postDate;
		$postContent='';
		$postTitle=$product;
		$postExcert='';
		$postStatus='publish';
		$commentStatus='closed';
		$pingStatus='closed';
		$postPassword='';
		$postName='product-'.$IDParent.'-variation-'.$IDVariation;
		$toPing='';
		$pinged='';
		$postModified=$postDate;
		$postModifiedGMT=$postDate;
		$postContentFiltered='';
		$postParent=$IDParent;
		
		
		
		$guid=$this->getHosts().'/index.php/product_variation/'.$postName;
		
		$menuOrder=0;
		$postType='product_variation';
		$postMimeType='';
		$commentCount=0;
	
		
		$sql = "INSERT INTO wp_posts VALUES(:ID,:postAuthor,:postDate,:postDateGMT,:postContent,:postTitle,:postExcert,:postStatus,:commentStatus,:pingStatus,:postPassword,:postName,:toPing,:pinged,:postModified,:postModifiedGMT,:postContentFiltered,:postParent,:guid,:menuOrder,:postType,:postMimeType,:commentCount)";
		
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':postAuthor',$postAuthor,PDO::PARAM_STR);
		$statement->bindParam(':postDate',$postDate,PDO::PARAM_STR);
		$statement->bindParam(':postDateGMT',$postDateGMT,PDO::PARAM_STR);
		$statement->bindParam(':postContent',$postContent,PDO::PARAM_STR);
		$statement->bindParam(':postTitle',$postTitle,PDO::PARAM_STR);
		$statement->bindParam(':postExcert',$postExcert,PDO::PARAM_STR);
		$statement->bindParam(':postStatus',$postStatus,PDO::PARAM_STR);
		$statement->bindParam(':commentStatus',$commentStatus,PDO::PARAM_STR);
		$statement->bindParam(':pingStatus',$pingStatus,PDO::PARAM_STR);
		$statement->bindParam(':postPassword',$postPassword,PDO::PARAM_STR);
		$statement->bindParam(':postName',$postName,PDO::PARAM_STR);
		$statement->bindParam(':toPing',$toPing,PDO::PARAM_STR);
		$statement->bindParam(':pinged',$pinged,PDO::PARAM_STR);
		$statement->bindParam(':postModified',$postModified,PDO::PARAM_STR);
		$statement->bindParam(':postModifiedGMT',$postModifiedGMT,PDO::PARAM_STR);
		$statement->bindParam(':postContentFiltered',$postContentFiltered,PDO::PARAM_STR);
		$statement->bindParam(':postParent',$postParent,PDO::PARAM_STR);
		$statement->bindParam(':guid',$guid,PDO::PARAM_STR);
		$statement->bindParam(':menuOrder',$menuOrder,PDO::PARAM_STR);
		$statement->bindParam(':postType',$postType,PDO::PARAM_STR);
		$statement->bindParam(':postMimeType',$postMimeType,PDO::PARAM_STR);
		$statement->bindParam(':commentCount',$commentCount,PDO::PARAM_STR);
		
		$statement->execute();
		
		$termIdColor=$this->GetAttribute($color,'pa_colores',$IDParent);
		
		if(!$termIdColor)
		{
			$termIdColor=$this->InsertAttribute($color,'Colores',$IDParent);
		}
		
		$termIdSize=$this->GetAttribute($size,'pa_tallas',$IDParent);
		
		if(!$termIdSize)
		{
			$termIdSize=$this->InsertAttribute($size,'Tallas',$IDParent);
		}
		
		//_backorders
		$backorders='notify';
		$this->InsertPostMeta($ID,'_backorders',$backorders);
		
		//_downloadable
		$downloadable='no';
		$this->InsertPostMeta($ID,'_downloadable',$downloadable);
				
		//_height
		$height='';
		$this->InsertPostMeta($ID,'_height',$height);
		
		//_length
		$length='';
		$this->InsertPostMeta($ID,'_length',$length);
		
		//_manage_stock
		$manageStock='yes';
		$this->InsertPostMeta($ID,'_manage_stock',$manageStock);
		
		//_price
		$this->InsertPostMeta($ID,'_price',$price);
				
		//_regular_price
		$this->InsertPostMeta($ID,'_regular_price',$price);
		
		//_sale_price
		$salePrice='';
		$this->InsertPostMeta($ID,'_sale_price',$salePrice);
		
		//_sale_price_dates_from
		$salePriceDatesFrom='';
		$this->InsertPostMeta($ID,'_sale_price_dates_from',$salePriceDatesFrom);
		
		//_sale_price_dates_to
		$salePriceDatesTo='';
		$this->InsertPostMeta($ID,'_sale_price_dates_to',$salePriceDatesTo);
		
		//_sku
		$this->InsertPostMeta($ID,'_sku',$sku);
		
		//_stock
		$this->InsertPostMeta($ID,'_stock',$stock);
		
		//_stock_status
		$stockStatus='instock';
		$this->InsertPostMeta($ID,'_stock_status',$stockStatus);
		
		//_thumbnail_id
		$thumbnailId='';
		$this->InsertPostMeta($ID,'_thumbnail_id',$thumbnailId);
		
		//_variation_description
		$variationDescription='0';
		$this->InsertPostMeta($ID,'_upsell_ids',$variationDescription);
		
		//_virtual
		$virtual='no';
		$this->InsertPostMeta($ID,'_virtual',$virtual);
		
		//_weight
		$weight='';
		$this->InsertPostMeta($ID,'_weight',$weight);
		
		//_width
		$width='';
		$this->InsertPostMeta($ID,'_width',$width);
		
		//attribute_pa_colores
		$slug=$general->NameToURL($color);
		$this->InsertPostMeta($ID,'attribute_pa_colores',$slug);
		
		//attribute_pa_colores
		$slug=$general->NameToURL($size);
		$this->InsertPostMeta($ID,'attribute_pa_tallas',$slug);
		
		//_trademark
		$this->InsertPostMeta($ID,'_trademark',ucwords(strtolower($trademark)));
		
		//type_product
		$this->InsertPostMeta($ID,'type_product',ucwords(strtolower($typeProduct)));
		
		//line_product
		$this->InsertPostMeta($ID,'line_product',ucwords(strtolower($lineProduct)));
		
		//gender_product
		$this->InsertPostMeta($ID,'gender_product',ucwords(strtolower($genderProduct)));
	}
	
	public function InsertImage($image,$tmpImage,$route,$routeF)
	{
		$general=new General();
		$upload=new Upload();
	
		$ID=$this->GetID();
		$n=explode('.',$image);
		$nameImage=$n[0];
		$s=explode('_',$nameImage);
		$color="";
		$result="";
		$banderaGallery=false;
		$msj="";
	
		$g=explode('@',$s[0]);
			
		$skuParent=$g[0];
		$IDParent=$this->getSku($skuParent);
	
		if(count($s)>1)
		{
			$color=$s[1];
			$result=$this->GetChildrensbyColor($IDParent,$color);
				
			if(!count($result))
			{
				return "No existe Producto Hijo ".$color;
			}
		}
	
		if($IDParent)
		{
			$image=$general->NameToURL($nameImage).'.'.$n[1];
			$route='inventory/'.$image;
			$upload->UploadFile($tmpImage,$_SERVER["REDIRECT_UPLOAD_FILE"].'uploads/'.$route);
	
			$postAuthor=2;
			$postDate=date('Y-m-d H:i:s');
			$postDateGMT=$postDate;
			$postContent='';
			$postTitle=$image;
			$postExcert='';
			$postStatus='inherit';
			$commentStatus='open';
			$pingStatus='closed';
			$postPassword='';
			$postName=$image;
			$toPing='';
			$pinged='';
			$postModified=$postDate;
			$postModifiedGMT=$postDate;
			$postContentFiltered='';
			$postParent=0;
			$guid=$this->getHosts().'/wp-content/uploads/'.$route;
			$menuOrder=0;
			$postType='attachment';
			$postMimeType='image/jpeg';
			$commentCount=0;
				
			$sql = "INSERT INTO wp_posts VALUES(:ID,:postAuthor,:postDate,:postDateGMT,:postContent,:postTitle,:postExcert,:postStatus,:commentStatus,:pingStatus,:postPassword,:postName,:toPing,:pinged,:postModified,:postModifiedGMT,:postContentFiltered,:postParent,:guid,:menuOrder,:postType,:postMimeType,:commentCount)";
				
			$statement=$this->connect->prepare($sql);
				
			$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
			$statement->bindParam(':postAuthor',$postAuthor,PDO::PARAM_STR);
			$statement->bindParam(':postDate',$postDate,PDO::PARAM_STR);
			$statement->bindParam(':postDateGMT',$postDateGMT,PDO::PARAM_STR);
			$statement->bindParam(':postContent',$postContent,PDO::PARAM_STR);
			$statement->bindParam(':postTitle',$postTitle,PDO::PARAM_STR);
			$statement->bindParam(':postExcert',$postExcert,PDO::PARAM_STR);
			$statement->bindParam(':postStatus',$postStatus,PDO::PARAM_STR);
			$statement->bindParam(':commentStatus',$commentStatus,PDO::PARAM_STR);
			$statement->bindParam(':pingStatus',$pingStatus,PDO::PARAM_STR);
			$statement->bindParam(':postPassword',$postPassword,PDO::PARAM_STR);
			$statement->bindParam(':postName',$postName,PDO::PARAM_STR);
			$statement->bindParam(':toPing',$toPing,PDO::PARAM_STR);
			$statement->bindParam(':pinged',$pinged,PDO::PARAM_STR);
			$statement->bindParam(':postModified',$postModified,PDO::PARAM_STR);
			$statement->bindParam(':postModifiedGMT',$postModifiedGMT,PDO::PARAM_STR);
			$statement->bindParam(':postContentFiltered',$postContentFiltered,PDO::PARAM_STR);
			$statement->bindParam(':postParent',$postParent,PDO::PARAM_STR);
			$statement->bindParam(':guid',$guid,PDO::PARAM_STR);
			$statement->bindParam(':menuOrder',$menuOrder,PDO::PARAM_STR);
			$statement->bindParam(':postType',$postType,PDO::PARAM_STR);
			$statement->bindParam(':postMimeType',$postMimeType,PDO::PARAM_STR);
			$statement->bindParam(':commentCount',$commentCount,PDO::PARAM_STR);
				
			$statement->execute();
				
			//_wp_attached_file
			$this->InsertPostMeta($ID,'_wp_attached_file',$route);
				
			//_wp_attached_file
			$charFile=strlen($route);
			$charName=strlen($image);
			$metadata='a:5:{s:5:"width";i:1000;s:6:"height";i:1000;s:4:"file";s:'.$charFile.':"'.$route.'";s:5:"sizes";a:6:{s:9:"thumbnail";a:4:{s:4:"file";s:'.$charName.':"'.$image.'";s:5:"width";i:340;s:6:"height";i:340;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:'.$charName.':"'.$image.'";s:5:"width";i:800;s:6:"height";i:800;s:9:"mime-type";s:10:"image/jpeg";}s:12:"medium_large";a:4:{s:4:"file";s:'.$charName.':"'.$image.'";s:5:"width";i:768;s:6:"height";i:768;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:'.$charName.':"'.$image.'";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:'.$charName.':"'.$image.'";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:'.$charName.':"'.$image.'";s:5:"width";i:500;s:6:"height";i:500;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}}}';
			$this->InsertPostMeta($ID,'_wp_attachment_metadata',trim($metadata));
				
				
			if(!$color)
			{
				if($this->getThumbnail($IDParent))
				{
					$gallery=$this->getGallery($IDParent);
						
					if($gallery)
					{
						$gallery.=','.$ID;
					}
					else
					{
						$gallery=$ID;
					}
						
					$this->UpdatePostMeta($IDParent,'_product_image_gallery',$gallery);
						
					$msj="$ID Imagen Insertada en Galeria SKU ".$skuParent;
				}
				else
				{
					if($this->GetPropertyMeta($IDParent,'_thumbnail_id'))
					{
						$this->UpdatePostMeta($IDParent,'_thumbnail_id',$ID);
						$msj="$ID Imagen Insertada en Thumbnail SKU ".$skuParent;
					}
					else
					{
						$this->InsertPostMeta($IDParent,'_thumbnail_id',$ID);
							
						$msj="$ID Imagen Insertada en Thumbnail SKU ".$skuParent;
					}
				}
			}
			else
			{
				foreach($result as $r)
				{
					$IDChildren=$r['ID'];
						
					if($this->GetPropertyMeta($IDChildren,'_thumbnail_id'))
					{
						$this->UpdatePostMeta($IDChildren,'_thumbnail_id',$ID);
						$msj="Imagen Insertada en Hijo ".$color." SKU ".$skuParent;
					}
					else
					{
						$this->InsertPostMeta($IDChildren,'_thumbnail_id',$ID);
						$msj="Imagen Insertada en Hijo ".$color." SKU ".$skuParent;
					}
				}
			}
		}
		else
		{
			$msj="No existe SKU Padre";
		}
	
		return $msj;
	}
	
	public function InsertProductRoot($sku,$product,$description,$descriptionShort,$categories,$stock,$price,$trademark,$typeProduct,$lineProduct,$genderProduct)
	{
		$general=new General();
				
		$ID=$this->GetID();
		
		if(!$stock)
		{
			$stock=0;
		}
		
		$postAuthor=2;
		$postDate=date('Y-m-d H:i:s');
		$postDateGMT=$postDate;
		$postContent=$description;
		$postTitle=$descriptionShort;
		$postExcert=$product;
		$postStatus='publish';
		$commentStatus='open';
		$pingStatus='closed';
		$postPassword='';
		$postName=$general->NameToURL($sku.'-'.$postTitle);
		$toPing='';
		$pinged='';
		$postModified=$postDate;
		$postModifiedGMT=$postDate;
		$postContentFiltered='';
		$postParent=0;
		
		$guid=$this->getHosts().'/?post_type=product&#038;p='.$ID;
		
		$menuOrder=0;
		$postType='product';
		$postMimeType='';
		$commentCount=0;
	
		if(!$postContent)
		{
			$postContent="Descripcion Producto";
		}
		
		$sql = "INSERT INTO wp_posts VALUES(:ID,:postAuthor,:postDate,:postDateGMT,:postContent,:postTitle,:postExcert,:postStatus,:commentStatus,:pingStatus,:postPassword,:postName,:toPing,:pinged,:postModified,:postModifiedGMT,:postContentFiltered,:postParent,:guid,:menuOrder,:postType,:postMimeType,:commentCount)";
		
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':postAuthor',$postAuthor,PDO::PARAM_STR);
		$statement->bindParam(':postDate',$postDate,PDO::PARAM_STR);
		$statement->bindParam(':postDateGMT',$postDateGMT,PDO::PARAM_STR);
		$statement->bindParam(':postContent',$postContent,PDO::PARAM_STR);
		$statement->bindParam(':postTitle',$postTitle,PDO::PARAM_STR);
		$statement->bindParam(':postExcert',$postExcert,PDO::PARAM_STR);
		$statement->bindParam(':postStatus',$postStatus,PDO::PARAM_STR);
		$statement->bindParam(':commentStatus',$commentStatus,PDO::PARAM_STR);
		$statement->bindParam(':pingStatus',$pingStatus,PDO::PARAM_STR);
		$statement->bindParam(':postPassword',$postPassword,PDO::PARAM_STR);
		$statement->bindParam(':postName',$postName,PDO::PARAM_STR);
		$statement->bindParam(':toPing',$toPing,PDO::PARAM_STR);
		$statement->bindParam(':pinged',$pinged,PDO::PARAM_STR);
		$statement->bindParam(':postModified',$postModified,PDO::PARAM_STR);
		$statement->bindParam(':postModifiedGMT',$postModifiedGMT,PDO::PARAM_STR);
		$statement->bindParam(':postContentFiltered',$postContentFiltered,PDO::PARAM_STR);
		$statement->bindParam(':postParent',$postParent,PDO::PARAM_STR);
		$statement->bindParam(':guid',$guid,PDO::PARAM_STR);
		$statement->bindParam(':menuOrder',$menuOrder,PDO::PARAM_STR);
		$statement->bindParam(':postType',$postType,PDO::PARAM_STR);
		$statement->bindParam(':postMimeType',$postMimeType,PDO::PARAM_STR);
		$statement->bindParam(':commentCount',$commentCount,PDO::PARAM_STR);
		
		$statement->execute();
		
		$ct=explode(",",$categories);
		
		foreach($ct as $c)
		{
			$c=trim($c);
			$categoryId=$this->GetCategory($c);
			
			if($categoryId)
			{
				if(!$this->CheckCategoryProduct($ID,$categoryId))
				{
					$this->InsertCategoryProduct($ID,$categoryId);
				}
			}
			else
			{
				$categoryId=$this->InsertCategory($c);
				$this->InsertCategoryProduct($ID,$categoryId);
			}
			
		}
		
	//_trademark
		$trademark=ucwords(strtolower(trim($trademark)));
		$categoryId=$this->GetCategory($trademark);
			
		if($categoryId)
		{
			if(!$this->CheckCategoryProduct($ID,$categoryId))
			{
				$this->InsertCategoryProduct($ID,$categoryId);
			}
		}
		else
		{
			$categoryId=$this->InsertCategory($trademark);
			$this->InsertCategoryProduct($ID,$categoryId);
		}
		
		//type_product
		$typeProduct=ucwords(strtolower(trim($typeProduct)));
		$categoryId=$this->GetCategory($typeProduct);
			
		if($categoryId)
		{
			if(!$this->CheckCategoryProduct($ID,$categoryId))
			{
				$this->InsertCategoryProduct($ID,$categoryId);
			}
		}
		else
		{
			$categoryId=$this->InsertCategory($typeProduct);
			$this->InsertCategoryProduct($ID,$categoryId);
		}
		
		//lineProduct
		$lineProduct=ucwords(strtolower(trim($lineProduct)));
		$categoryId=$this->GetCategory($lineProduct);
			
		if($categoryId)
		{
			if(!$this->CheckCategoryProduct($ID,$categoryId))
			{
				$this->InsertCategoryProduct($ID,$categoryId);
			}
		}
		else
		{
			$categoryId=$this->InsertCategory($lineProduct);
			$this->InsertCategoryProduct($ID,$categoryId);
		}
		
		//genderProduct
		$genderProduct=ucwords(strtolower(trim($genderProduct)));
		$categoryId=$this->GetCategory($genderProduct);
			
		if($categoryId)
		{
			if(!$this->CheckCategoryProduct($productId,$categoryId))
			{
				$this->InsertCategoryProduct($ID,$categoryId);
			}
		}
		else
		{
			$categoryId=$this->InsertCategory($genderProduct);
			$this->InsertCategoryProduct($ID,$categoryId);
		}
						
		//_backorders
		$backorders='notify';
		$this->InsertPostMeta($ID,'_backorders',$backorders);
		
		//_crosssell_ids
		$crosssellIds='a:0:{}';
		$this->InsertPostMeta($ID,'_crosssell_ids',$crosssellIds);
		
		//_downloadable
		$downloadable='no';
		$this->InsertPostMeta($ID,'_downloadable',$downloadable);
		
		//_edit_last
		$this->InsertPostMeta($ID,'_edit_last',$postAuthor);
		
		//_edit_lock
		//$editLock=time().':'.$postAuthor;
		$editLock=strtotime("-1 hours").':'.$postAuthor;
		$this->InsertPostMeta($ID,'_edit_lock',$editLock);
		
		//_featured
		$featured='no';
		$this->InsertPostMeta($ID,'_featured',$featured);
		
		//_height
		$height='';
		$this->InsertPostMeta($ID,'_height',$height);
		
		//_length
		$length='';
		$this->InsertPostMeta($ID,'_length',$length);
		
		//_manage_stock
		$manageStock='yes';
		$this->InsertPostMeta($ID,'_manage_stock',$manageStock);
		
		//_price
		$this->InsertPostMeta($ID,'_price',$price);
		
		//_product_attributes
		$productAttributes='a:2:{s:10:"pa_colores";a:6:{s:4:"name";s:10:"pa_colores";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:1;}s:9:"pa_tallas";a:6:{s:4:"name";s:9:"pa_tallas";s:5:"value";s:0:"";s:8:"position";s:1:"1";s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:1;}}';
		$this->InsertPostMeta($ID,'_product_attributes',$productAttributes);
		
		//_product_image_gallery
		$productImageGallery='';
		$this->InsertPostMeta($ID,'_product_image_gallery',$productImageGallery);
		
		//_product_version
		$productVersion='2.5.2';
		$this->InsertPostMeta($ID,'_product_version',$productVersion);
		
		//_purchase_note
		$purchaseNote='';
		$this->InsertPostMeta($ID,'_purchase_note',$purchaseNote);
		
		//_regular_price
		$this->InsertPostMeta($ID,'_regular_price',$price);
		
		//_sale_price
		$salePrice='';
		$this->InsertPostMeta($ID,'_sale_price',$salePrice);
		
		//_sale_price_dates_from
		$salePriceDatesFrom='';
		$this->InsertPostMeta($ID,'_sale_price_dates_from',$salePriceDatesFrom);
		
		//_sale_price_dates_to
		$salePriceDatesTo='';
		$this->InsertPostMeta($ID,'_sale_price_dates_to',$salePriceDatesTo);
		
		//_sku
		$this->InsertPostMeta($ID,'_sku',$sku);
		
		//_sold_individually
		$soldIndividually='';
		$this->InsertPostMeta($ID,'_sold_individually',$soldIndividually);
		
		//_stock
		$this->InsertPostMeta($ID,'_stock',$stock);
		
		//_stock_status
		$stockStatus='instock';
		$this->InsertPostMeta($ID,'_stock_status',$stockStatus);
		
		//_upsell_ids
		$upsellIds='a:0:{}';
		$this->InsertPostMeta($ID,'_upsell_ids',$upsellIds);
		
		//_virtual
		$virtual='no';
		$this->InsertPostMeta($ID,'_virtual',$virtual);
		
		//_visibility
		$visibility='visible';
		$this->InsertPostMeta($ID,'_visibility',$visibility);
		
		//_weight
		$weight='';
		$this->InsertPostMeta($ID,'_weight',$weight);
		
		//_width
		$width='';
		$this->InsertPostMeta($ID,'_width',$width);
		
		//total_sales
		$totalSales=0;
		$this->InsertPostMeta($ID,'total_sales',$totalSales);
				
		//_trademark
		$this->InsertPostMeta($ID,'_trademark',$trademark);
		
		//type_product
		$this->InsertPostMeta($ID,'type_product',ucwords(strtolower($typeProduct)));
		
		//line_product
		$this->InsertPostMeta($ID,'line_product',ucwords(strtolower($lineProduct)));
		
		//gender_product
		$this->InsertPostMeta($ID,'gender_product',ucwords(strtolower($genderProduct)));
		
		//wc_productdata_options
		$wcProductDataOptions='a:1:{i:0;a:6:{s:11:"_bubble_new";s:0:"";s:12:"_bubble_text";s:0:"";s:17:"_custom_tab_title";s:0:"";s:11:"_custom_tab";s:0:"";s:14:"_product_video";s:0:"";s:19:"_product_video_size";s:0:"";}}';
		$this->InsertPostMeta($ID,'wc_productdata_options',$wcProductDataOptions);
		
		if($price)
		{
			$this->InsertProductTerms($ID,'2');
		}
		else
		{
			$this->InsertProductTerms($ID,'4');
		}
				
		return $ID;
	}
	
	public function UpdateStock($ID,$stock)
	{
		$sql="UPDATE wp_postmeta SET meta_value=:stock WHERE post_id=:ID AND meta_key='_stock'";
		
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':stock',$stock,PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function InsertPostMeta($ID,$metaKey,$metaValue)
	{
		$sql="INSERT INTO wp_postmeta VALUES('',:ID,:metaKey,:metaValue)";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':metaKey',$metaKey,PDO::PARAM_STR);
		$statement->bindParam(':metaValue',$metaValue,PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function UpdatePostMeta($ID,$metaKey,$metaValue)
	{
		$sql="UPDATE wp_postmeta SET meta_value=:metaValue
				WHERE post_id=:ID AND meta_key=:metaKey";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':metaKey',$metaKey,PDO::PARAM_STR);
		$statement->bindParam(':metaValue',$metaValue,PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function UpdateStockbySku($sku,$rest)
	{
		$ID=$this->getSku($sku);
		
		$sql="UPDATE wp_postmeta SET meta_value=meta_value-:rest
				WHERE meta_key='_stock'
				AND post_id=:ID";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':rest',$rest,PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function GetStockbySku($sku)
	{
		$sql="SELECT meta_value
				FROM wp_postmeta
				WHERE meta_key='_stock'
				AND post_id=(SELECT post_id
				FROM wp_postmeta
				WHERE meta_key='_sku' AND meta_value=:sku)";
		
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':sku',$sku,PDO::PARAM_STR);
		
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		
		if(isset($result[0]['meta_value']))
		{
			return $result[0]['meta_value'];
		}
		else
		{
			return false;
		}
	}
	
	public function UpdateProduct($ID,$stock,$price)
	{
		//Stock
		$this->UpdatePostMeta($ID,'_stock',$stock);
		
		//Price
		$price=$price+($price*0.16);
		$this->UpdatePostMeta($ID,'_price',round($price));
	}
	
	public function InsertProductTerms($ID,$term)
	{
		$sql="INSERT INTO wp_term_relationships VALUES(:ID,:term,'0')";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':term',$term,PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function getPrefix($sku,$color,$parent)
	{
		$general=new General();
		
		$prefix="";
				
		if($color)
		{
			$prefix.=$sku.'_'.$general->CleanName($color);
		}
		else
		{
			$prefix.=$sku.'@';
		}
				
		return $prefix;
	}
		
	public function UpdateDataProduct($ID,$name,$stock,$price)
	{
		$r=$this->GetDataProduct($ID);
		
		$postParent=$r[0]['post_parent'];
		
		if($postParent)
		{
			$postId=$postParent;
		}
		else
		{
			$postId=$ID;
		}
		
		$sql="UPDATE wp_posts SET post_title=:name WHERE ID=:ID";
		
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$postId,PDO::PARAM_STR);
		$statement->bindParam(':name',$name,PDO::PARAM_STR);
		$statement->execute();
		
		//_stock
		$this->UpdatePostMeta($ID,'_stock',$stock);
		
		//_price
		$this->UpdatePostMeta($ID,'_price',$price);
		
		//_regular_price
		$this->UpdatePostMeta($ID,'_regular_price',$price);
		
		return "Datos Actualizados";
	}
	
	public function UpdateStatusStock()
	{
		$sql="SELECT post_id
              FROM wp_postmeta
              WHERE meta_key='_stock'
              AND meta_value!=0";
		
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($result as $r)
		{
			$ID=$r['post_id'];
			//_stock_status
			$stockStatus='outofstock';
			$this->UpdatePostMeta($ID,'_stock_status',$stockStatus);
			
			$backorders='notify';
			$this->UpdatePostMeta($ID,'_backorders',$backorders);
		}
	}
	
	public function UpdateCategories()
	{
		$sql="SELECT post_id,meta_value
				FROM wp_postmeta
				WHERE meta_key IN('type_product','line_product','gender_product')";
	
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		foreach($result as $r)
		{
			$ID=$r['post_id'];
			$type=$r['meta_value'];
				
			$type=ucwords(strtolower(trim($type)));
			$categoryId=$this->GetCategory($type);
	
			if($categoryId)
			{
				//$this->InsertCategoryProduct($ID,$categoryId);
			}
			else
			{
				$categoryId=$this->InsertCategory($type);
				$this->InsertCategoryProduct($ID,$categoryId);
			}
				
			echo $ID." ".$type."<br>";
				
		}
	}
	
	public function GetIDParent($ID)
	{
		$sql="SELECT post_parent
		FROM wp_posts
		WHERE ID='$ID'";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
	
		if(isset($result[0]['post_parent']))
		{
			return $result[0]['post_parent'];
		}
		else
		{
			return false;
		}
	}
	
	public function DeleteCacheUpdate($ID)
	{
		$sql="SELECT *
		FROM wp_options
		WHERE option_name IN('_transient_timeout_wc_var_prices_$ID','_transient_wc_var_prices_$ID')";
		$statement=$this->connect->prepare($sql);
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		foreach($result as $r)
		{
			$option_name=$r['option_name'];
			$option_id=$r['option_id'];
				
			$sql="DELETE FROM wp_options WHERE option_id='$option_id'";
			$statement=$this->connect->prepare($sql);
			$statement->execute();
		}
	}
	
}

?>