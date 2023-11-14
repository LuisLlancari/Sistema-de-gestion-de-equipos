<?php

require_once '../models/Sector.php';

if (isset($_POST['operacion'])){

    $sector = new Sector();

    switch ($_POST['operacion']){
        case 'listar':
            echo json_encode($sector->listar());
        break;

        case 'registrar':
            $datosEnviar = [
                'idequipo' => $_POST['idequipo'],
                'idusuario' => $_POST['idusuario'],
                'nombre' => $_POST['nombre'],
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin']
            ];

            echo json_encode($sector->registrar($datosEnviar));
        break;
        
    }
}

?>