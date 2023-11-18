<?php

require_once '../models/Mantenimiento.php';

if (isset($_POST['operacion'])){

    $mantenimiento = new Mantenimiento();

    switch ($_POST['operacion']){
        case 'listar_mantenimiento':
            echo json_encode($mantenimiento->listar());
        break;

        case 'listar_mantenimiento_id':
            $datosEnviar = [
                'idmantenimiento' => $_POST['idmantenimiento']
            ];
            echo json_encode($mantenimiento->listarPorID($datosEnviar));
        break;
        

        case 'registrar_mantenimiento':
            $datosEnviar = [
                'idusuario' => $_POST['idusuario'],
                'idcronograma' => $_POST['idcronograma'],
                'descripcion' => $_POST['descripcion']
            ];

            echo json_encode($mantenimiento->registrar($datosEnviar));
        break;

        case 'modificar_mantenimiento';
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