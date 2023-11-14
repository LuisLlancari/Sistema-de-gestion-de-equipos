<?php

require_once '../models/Mantenimiento.php';

if (isset($_POST['operacion'])){

    $mantenimiento = new Mantenimiento();

    switch ($_POST['operacion']){
        case 'listar':
            echo json_encode($mantenimiento->listar());
        break;

        case 'listarPorID':
            $datosEnviar = [
                'idmantenimiento' => $_POST['idmantenimiento']
            ];
            echo json_encode($mantenimiento->listarPorID($datosEnviar));
        break;
        

        case 'registrar':
            $datosEnviar = [
                'idusuario' => $_POST['idusuario'],
                'idcronograma' => $_POST['idcronograma'],
                'descripcion' => $_POST['descripcion']
            ];

            echo json_encode($mantenimiento->registrar($datosEnviar));
        break;

        case 'modificar';
            $datosEnviar = [
                "idmantenimiento"      => $_POST['idmantenimiento'],
                "idusuario"            => $_POST['idusuario'],
                "idcronograma"         => $_POST['idcronograma'],
                "descripcion"          => $_POST['descripcion']
            ];

            echo json_encode($mantenimiento->modificar($datosEnviar));

        break;
        
    }
}

?>