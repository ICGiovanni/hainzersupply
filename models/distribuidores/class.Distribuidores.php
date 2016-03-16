<?php
include '../config.php';

include_once ($pathProy."models/connection/class.Connection.php");

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

    public function insertDistribuidor($info){

        $sql = "INSERT INTO inv_distribuidores VALUES(0,:nombre,:representante,:telefono,:celular,:correoElectronico,:idNivel)";
        $statement=$this->connect->prepare($sql);

        $statement->bindParam(':nombre',$info['nombre'],PDO::PARAM_STR);
        $statement->bindParam(':representante',$info['representante'],PDO::PARAM_STR);
        $statement->bindParam(':telefono',$info['telefono'],PDO::PARAM_STR);
        $statement->bindParam(':celular',$info['celular'],PDO::PARAM_STR);
        $statement->bindParam(':correoElectronico',$info['correoElectronico'],PDO::PARAM_STR);
        $statement->bindParam(':idNivel',$info['idNivel'],PDO::PARAM_INT);

        $statement->execute();

        return $this->connect->lastInsertId();

    }

    public function insertDireccion($info){
        $sql = "INSERT INTO inv_direcciones VALUES(0,:calle,:numExt,:numInt,:codigoPostal,:colonia,:delegacion,:estado,:pais)";
        $statement=$this->connect->prepare($sql);

        $statement->bindParam(':calle',$info['calle'],PDO::PARAM_STR);
        $statement->bindParam(':numExt',$info['numExt'],PDO::PARAM_STR);
        $statement->bindParam(':numInt',$info['numInt'],PDO::PARAM_STR);
        $statement->bindParam(':codigoPostal',$info['codigoPostal'],PDO::PARAM_STR);
        $statement->bindParam(':colonia',$info['colonia'],PDO::PARAM_STR);
        $statement->bindParam(':delegacion',$info['delegacion'],PDO::PARAM_STR);
        $statement->bindParam(':estado',$info['estado'],PDO::PARAM_STR);
        $statement->bindParam(':pais',$info['pais'],PDO::PARAM_STR);

        $statement->execute();

        return $this->connect->lastInsertId();
    }

    public function insertFacturacion($info){
        $sql = "INSERT INTO inv_distribuidor_factura VALUES(0,:rfc,:razonSocial,:idDireccion,:idDistribuidor)";
        $statement=$this->connect->prepare($sql);

        $statement->bindParam(':rfc',$info['rfc'],PDO::PARAM_STR);
        $statement->bindParam(':razonSocial',$info['razonSocial'],PDO::PARAM_STR);
        $statement->bindParam(':idDireccion',$info['idDireccion'],PDO::PARAM_INT);
        $statement->bindParam(':idDistribuidor',$info['idDistribuidor'],PDO::PARAM_INT);

        $statement->execute();
    }

    public function insertEnvioDistribuidor($info){

        $sql = "INSERT INTO inv_distribuidor_envio VALUES(0,:idDistribuidor,:idDireccion)";
        $statement=$this->connect->prepare($sql);

        $statement->bindParam(':idDireccion',$info['idDireccion'],PDO::PARAM_INT);
        $statement->bindParam(':idDistribuidor',$info['idDistribuidor'],PDO::PARAM_INT);

        $statement->execute();
    }

    public function listaDistribuidores(){

        $sql = "select * from inv_distribuidores";

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getInfoDistribuidor($idDistribuidor){
        $sql = "select * from inv_distribuidores WHERE idDistribuidor =".$idDistribuidor;

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result[0];
    }

}

?>