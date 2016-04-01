<?php
    include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
    include_once ($pathProy."/models/connection/class.Connection.php");

    class Incentivos{

        private $connect;

        function __construct(){

            $c = new Connection();
            $this->connect = $c->db;

        }

        public function getList($idIncentivo=0){
            $sql="SELECT * FROM inv_incentivos where estatus=1";

            if($idIncentivo!=0){
                $sql .= " and idIncentivo=".$idIncentivo;
            }

            $statement=$this->connect->prepare($sql);

            $statement->execute();
            $result=$statement->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        public function guardarIncentivo($etiqueta,$descripcion){
            $sql = "INSERT INTO inv_incentivos VALUES(0,:etiqueta,:descripcion,1)";
            $statement=$this->connect->prepare($sql);

            $statement->bindParam(':etiqueta',$etiqueta,PDO::PARAM_STR);
            $statement->bindParam(':descripcion',$descripcion,PDO::PARAM_STR);

            $statement->execute();

            return $this->connect->lastInsertId();
        }

        public function borrarIncentivo($idIncentivo){
            $sql = "UPDATE inv_incentivos SET
                    estatus = 0
                WHERE
                    idIncentivo= ".$idIncentivo;

            $statement = $this->connect->prepare($sql);

            $statement->execute();
            return $statement->execute();
        }

        public function actualizarIncentivo($idIncentivo, $etiqueta, $descripcion){
            $sql = "UPDATE inv_incentivos SET
                    etiqueta = :etiqueta,
                    descripcion = :descripcion
                WHERE
                    idIncentivo= ".$idIncentivo;

            $statement = $this->connect->prepare($sql);

            $statement->bindParam(':etiqueta',$etiqueta,PDO::PARAM_STR);
            $statement->bindParam(':descripcion',$descripcion,PDO::PARAM_STR);

            return $statement->execute();
        }

    }
?>