<?php
require_once('../../models/class.Connection.php');

class Orders{
    private $connect;

    function __construct()
    {
        $c=new Connection();
        $this->connect=$c->db;
    }

    public function getProducts{
        $sql='SELECT (SELECT meta_value
FROM wp_postmeta wpm
WHERE meta_key=\'_sku\'
AND post_id=wp.ID) AS Sku,
wp.post_title AS Name,
"ROJO" AS Color,
"M" AS Size,
(SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key=\'_stock\'
AND post_id=wp.ID) AS Stock,
(SELECT ROUND(meta_value)
FROM wp_postmeta wpm
WHERE meta_key=\'_price\'
AND post_id=wp.ID) AS Price,
\'Descuento\' AS Category
FROM wp_posts wp
WHERE post_type=\'product_variation\'
AND post_parent!=0;';

        $statement=$this->connect->prepare($sql);
        $statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
