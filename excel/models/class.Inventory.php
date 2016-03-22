<?php
//require_once('class.Connection.php');
require_once($_SERVER["REDIRECT_PATH_CONFIG"].'models/connection/class.Connection.php');
require_once('class.General.php');

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
		$sql='';
		$statement='';
		
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
			return false;
		}
	}
	
	public function GetNextTerm()
	{
		$sql="SELECT MAX(term_id)+1 AS term_id
				FROM wp_terms";
				
		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		
		return $result[0]['term_id'];
	}
	
	public function InsertCategory($category)
	{
		$general=new General();
		
		$categoryId=$this->GetNextTerm();
		
		$sql = "INSERT INTO wp_terms VALUES(:categoryId,:category,:categoryUrl,0)";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':categoryId',$categoryId,PDO::PARAM_STR);
		$statement->bindParam(':category',$category,PDO::PARAM_STR);
		$statement->bindParam(':categoryUrl',$general->NameToURL($category),PDO::PARAM_STR);
		$statement->execute();
		
		$sql = "INSERT INTO wp_term_taxonomy VALUES(:categoryId,:categoryId,'product_cat','',0,0)";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':categoryId',$categoryId,PDO::PARAM_STR);
		$statement->execute();
		
		return $categoryId;
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
				WHERE ID=':ID'";
				
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);		
		
		return $result;
	}
	
	public function GetChildrensbyColor($ID,$color)
	{
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
		$sql="SELECT MAX($field)+1 AS ID
				FROM $table";
				
		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		$ID=$result[0]['ID'];
		
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
				WHERE wt.name='$attribute' AND taxonomy='$taxonomy'
				AND wtr.object_id='$IDParent'";
		
		$statement=$this->connect->prepare($sql);
		
		$statement->bindParam(':attribute',$attribute,PDO::PARAM_STR);
		$statement->bindParam(':taxonomy',$taxonomy,PDO::PARAM_STR);
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
				WHERE name='$attribute'";
				
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
			$termId=$this->GetNextID('term_id','wp_terms');
			$attribute=ucwords(strtolower($attribute));
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
				AND wpm.meta_key='_thumbnail_id'";
		
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
		
		$color=$general->CleanName($color);
		
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
		$backorders='no';
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
		$thumbnailId='0';
		$this->InsertPostMeta($ID,'_upsell_ids',$thumbnailId);
		
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
	
	public function InsertImage($image,$route)
	{
		$general=new General();
	
		$ID=$this->GetID();
		$n=explode('.',$image);
		$nameImage=$n[0];
		$s=explode('_',$nameImage);
		$color="";
		$skuParent=$s[0];
		
		if(count($s)==4)
		{
			
			$color=$s[1];
		}
		
		
		$IDParent=$this->getSku($skuParent);
		
		if($IDParent)
		{
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
			$postName=$general->NameToURL($nameImage);
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
				}
				else
				{
					$this->InsertPostMeta($IDParent,'_thumbnail_id',$ID);
				}
			}
			else
			{
				$result=$this->GetChildrensbyColor($IDParent,$color);
				
				foreach($result as $r)
				{
					$IDChildren=$r['ID'];
					
					if($this->getThumbnail($IDChildren))
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
					}
					else 
					{
						$this->InsertPostMeta($IDChildren,'_thumbnail_id',$ID);
					}
				}
			}
			
			return "Imagen Insertada ".$skuParent;
			
		}
		else
		{
			return "No existe SKU Padre";
		}
	}
	
	public function InsertProductRoot($sku,$product,$description,$descriptionShort,$categories,$stock,$price,$trademark,$typeProduct,$lineProduct,$genderProduct)
	{
		$general=new General();
				
		$ID=$this->GetID();
		
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
		$postName=$general->NameToURL($postTitle);
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
			$categoryId=$this->GetCategory($c);
			
			if($categoryId)
			{
				$this->InsertCategoryProduct($ID,$categoryId);
			}
			else
			{
				$categoryId=$this->InsertCategory($c);
				$this->InsertCategoryProduct($ID,$categoryId);
			}
			
		}
				
		//_backorders
		$backorders='no';
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
		$this->InsertPostMeta($ID,'_trademark',ucwords(strtolower($trademark)));
		
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
		$this->UpdatePostMeta($ID,'_price',$price);
	}
	
	public function InsertProductTerms($ID,$term)
	{
		$sql="INSERT INTO wp_term_relationships VALUES(:ID,:term,'0')";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':term',$term,PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function getPrefix($sku,$color,$trademark,$product,$parent)
	{
		$general=new General();
		
		$prefix="";
		
		$trademark=$general->NameToURL($trademark);
		$product=$general->NameToURL($product);
		
		if($parent)
		{	
			$p=explode('-',$product);
			
			for($i=0;$i<count($p)-1;$i++)
			{
				if($i==0)
				{
					$product=$p[$i];
				}
				else
				{
					$product.='-'.$p[$i];
				}
			}
		}
		
		if($color)
		{
			$prefix.=$sku.'_'.$general->CleanName($color);
		}
		else
		{
			$prefix.=$sku;
		}
		
		$prefix.='_'.$trademark.'_'.$product;
		
		return $prefix;
	}
}

?>