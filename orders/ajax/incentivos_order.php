<?php
    include $_SERVER['REDIRECT_PATH_CONFIG'].'models/incentivos/class.Incentivos.php';
    $instIncentivos = new Incentivos();

    if(!empty($_POST)){
        extract($_POST);

        switch($accion){
            case "listIncentivosOrden":
                $incentivosOrden = $instIncentivos->getIncentivosOrden($idOrden);
                $data['result']=false;
                if($incentivosOrden){
                    $data['result']=$incentivosOrden;
                }

                echo json_encode($data);

            break;

            case "agregarOrdenIncentivo":
                $instIncentivos->guardarOrdenIncentivo($idOrden,$idIncentivo);
            break;
        }
    }
?>