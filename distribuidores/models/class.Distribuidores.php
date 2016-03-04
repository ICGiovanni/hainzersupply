<?php
require('../../excel/models/class.Connection.php');

class Distribuidores{

    private $connect;

    function __construct(){

        $c=new Connection();
        $this->connect=$c->db;

    }

    public function getLastIdDistribuidor(){

        $sql="SELECT MAX(id_distribuidor)
				FROM distribuidores limit 1";

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

}

$insDist = new Distribuidores();

print_r($insDist->getLastIdDistribuidor());

?>