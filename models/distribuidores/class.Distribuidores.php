<?php
include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
include_once ($pathProy."/models/connection/class.Connection.php");

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

        $sql = "select * from inv_distribuidores ind
                inner join inv_niveles inn on ind.idNivel = inn.idNivel";

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getInfoDistribuidor($idDistribuidor){
        $sql = "SELECT * FROM inv_distribuidores as ind
                inner join inv_niveles as inn on ind.idNivel = inn.idNivel WHERE ind.idDistribuidor =".$idDistribuidor;

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result[0];
    }

    public function getFacturacionDistribuidor($idDistribuidor){
        $sql = "select * from inv_distribuidor_factura idf
                inner join inv_direcciones id on idf.idDireccion = id.idDireccion
                where idDistribuidor =".$idDistribuidor;

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getEnvioDistribuidor($idDistribuidor){
        $sql = "select * from inv_distribuidor_envio ide
                inner join inv_direcciones ind on ide.idDireccion = ind.idDireccion
                where idDistribuidor=".$idDistribuidor;

        $statement=$this->connect->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function actualizarDireccion($info){

        $sql = "UPDATE inv_direcciones SET
			calle = :calle,
			numExt = :numExt,
			numInt = :numInt,
			codigoPostal = :codigoPostal,
			colonia = :colonia,
			delegacion = :delegacion,
			estado = :estado,
			pais = :pais
			WHERE
				idDireccion = ".$info['idDireccion'];

        $statement = $this->connect->prepare($sql);

        $statement->bindParam(':calle', $info['calle'], PDO::PARAM_STR);
        $statement->bindParam(':numExt', $info['numExt'], PDO::PARAM_STR);
        $statement->bindParam(':numInt', $info['numInt'], PDO::PARAM_STR);
        $statement->bindParam(':codigoPostal', $info['codigoPostal'], PDO::PARAM_STR);
        $statement->bindParam(':colonia', $info['colonia'], PDO::PARAM_STR);
        $statement->bindParam(':delegacion', $info['delegacion'], PDO::PARAM_STR);
        $statement->bindParam(':estado', $info['estado'], PDO::PARAM_STR);
        $statement->bindParam(':pais', $info['pais'], PDO::PARAM_STR);


        $statement->execute();
    }

    public function actualizarFacturacion($info){
        $sql = "UPDATE inv_distribuidor_factura SET
			rfc = :rfc,
			razonSocial = :razonSocial
			WHERE
				idDistribuidorFactura = ".$info['idDistribuidorFactura'];

        $statement = $this->connect->prepare($sql);

        $statement->bindParam(':rfc', $info['rfc'], PDO::PARAM_STR);
        $statement->bindParam(':razonSocial', $info['razonSocial'], PDO::PARAM_STR);

        $statement->execute();
    }

    public function actualizarDistribuidor($info){
        $sql = "UPDATE inv_distribuidores SET
                    nombre = :nombre,
                    representante = :representante,
                    telefono = :telefono,
                    celular = :celular,
                    correoElectronico = :correoElectronico,
                    idNivel = :idNivel
                WHERE
                    idDistribuidor= ".$info['idDistribuidor'];

        $statement = $this->connect->prepare($sql);

        $statement->bindParam(':nombre', $info['nombre'], PDO::PARAM_STR);
        $statement->bindParam(':representante', $info['representante'], PDO::PARAM_STR);
        $statement->bindParam(':telefono', $info['telefono'], PDO::PARAM_STR);
        $statement->bindParam(':celular', $info['celular'], PDO::PARAM_STR);
        $statement->bindParam(':correoElectronico', $info['correoElectronico'], PDO::PARAM_STR);
        $statement->bindParam(':idNivel', $info['idNivel'], PDO::PARAM_INT);

        $statement->execute();

    }

}

?>