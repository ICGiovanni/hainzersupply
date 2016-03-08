<?php
require('../excel/models/class.Connection.php');

class Distribuidores{

    private $connect;

    function __construct(){

        $c=new Connection();
        $this->connect=$c->db;

    }

    public function getLastIdDistribuidor(){

        $sql="SELECT MAX(idDistribuidor) idDistribuidor
				FROM inv_distribuidores limit 1";

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);

        return $result[0]['idDistribuidor']+1;

    }

    public function getNiveles(){
        $sql="SELECT * FROM inv_niveles";

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

}

?>