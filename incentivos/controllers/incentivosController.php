<?php session_start();
    include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
    include $_SERVER['REDIRECT_PATH_CONFIG'].'models/incentivos/class.Incentivos.php';

    $insIncentivos = new Incentivos();

    if($_POST) {
        extract($_POST);

        switch ($accion) {
            case "getIncentivos":
                $lista = $insIncentivos->getList();

                if($lista){
                    foreach($lista as $list){
                        echo "  <tr>
                                    <td>".$list['etiqueta']."</td>
                                    <td>".$list['descripcion']."</td>
                                    <td height='45px' width='70px'>
                                        <button class='btn btn-primary' onclick='loadIncentivo(".$list['idIncentivo'].")'><span class=\"glyphicon glyphicon-pencil\"></span></button>
                                    </td>
                                    <td>
                                        <button class='btn btn-danger' onclick='borrar(".$list['idIncentivo'].")'><span class=\"glyphicon glyphicon-trash\"></span></button>
                                    </td>
                                </tr>";
                    }
                }
                else{
                    echo "<tr><td colspan='4'>No hay registros</td></tr>";
                }

                break;

            case "agregarIncentivo":
                    $insIncentivos->guardarIncentivo($etiqueta, $descripcion);
                break;

            case "borrarIncentivos":
                    $insIncentivos->borrarIncentivo($idIncentivo);
                break;

            case "getIncentivo":
                    $result = $insIncentivos->getList($idIncentivo);
                    echo json_encode($result[0]);
                break;

            case "actualizarIncentivo":
                    $insIncentivos->actualizarIncentivo($idIncentivo, $etiqueta, $descripcion);
                break;
        }
    }
