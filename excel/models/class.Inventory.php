<?php
require_once('class.Connection.php');
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
	
	public function InsertCategory($category)
	{
		$general=new General();
		
		$sql="SELECT MAX(term_id)+1 AS term_id
				FROM wp_terms";
				
		$statement=$this->connect->prepare($sql);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		$categoryId=$result[0]['term_id'];
		
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
		$sql="SELECT COUNT(*)+1 AS ID
				FROM wp_posts
				WHERE post_parent=':ID'
				AND post_type='product_variation'";
				
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$IDParent,PDO::PARAM_STR);
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);		
		
	}
	
	public function InsertProductVariable($sku,$IDParent,$product,$stock,$price)
	{
		$general=new General();
				
		$ID=$this->GetID();
		
		$dataParent=$this->GetDataProduct($IDParent);
		
		$IDVariation=$this->GetNextChildren($IDParent);
		
		
		$postAuthor=2;
		$postDate=date('Y-m-d H:i:s');
		$postDateGMT=$postDate;
		$postContent='';
		$postTitle="Variación #".$IDParent." de ".$dataParent[0]['post_title'];
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
		$postParent=0;
		
		
		$sql="SELECT option_value
				FROM wp_options
				WHERE option_name='siteurl'";
		$statement=$this->connect->prepare($sql);		
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		$guid=$result[0]['option_value'].'/index.php/product_variation/'.$postName;
		
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
	}
	
	public function InsertProductRoot($sku,$product,$description,$descriptionShort,$categories,$stock,$price)
	{
		$general=new General();
				
		$ID=$this->GetID();
		
		$postAuthor=2;
		$postDate=date('Y-m-d H:i:s');
		$postDateGMT=$postDate;
		$postContent=$description;
		$postTitle=$product;
		$postExcert=$descriptionShort;
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
		
		
		$sql="SELECT option_value
				FROM wp_options
				WHERE option_name='siteurl'";
		$statement=$this->connect->prepare($sql);		
		$statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
		$guid=$result[0]['option_value'].'/?post_type=product&#038;p='.$ID;
		
		$menuOrder=0;
		$postType='product';
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
		
		//wc_productdata_options
		$wcProductDataOptions='a:1:{i:0;a:6:{s:11:"_bubble_new";s:0:"";s:12:"_bubble_text";s:0:"";s:17:"_custom_tab_title";s:0:"";s:11:"_custom_tab";s:0:"";s:14:"_product_video";s:0:"";s:19:"_product_video_size";s:0:"";}}';
		$this->InsertPostMeta($ID,'wc_productdata_options',$wcProductDataOptions);
		
		$this->InsertProductTerms($ID,'4');
		
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
	
	public function InsertProductTerms($ID,$term)
	{
		$sql="INSERT INTO wp_term_relationships VALUES(:ID,:term,'0')";
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':ID',$ID,PDO::PARAM_STR);
		$statement->bindParam(':term',$term,PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function getPrefix($sku,$trademark,$product)
	{
		$general=new General();
		
		$prefix="";
		$s=explode("-",$sku);
		
		$trademark=$general->NameToURL($trademark);
		$product=$general->NameToURL($product);
		
		if(isset($s[0]))
		{
			$prefix.=$s[0];
		}
		
		if(isset($s[1]))
		{
			$prefix.='-'.$s[1];
		}
		
		$prefix.='-'.$trademark.'-'.$product;
		
		return $prefix;
	}
}

?>