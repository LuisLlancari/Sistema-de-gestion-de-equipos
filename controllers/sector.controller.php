<?php

require_once '../models/Sector.php';

if (isset($_POST['operacion'])){

    $sector = new Sector();

    switch ($_POST['operacion']){
        case 'obtenerNC':
            echo json_encode($sector->obtenerNC());
        break;

        case 'listar_detalles_sector':
            echo json_encode($sector->listar_detalles_sector());
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