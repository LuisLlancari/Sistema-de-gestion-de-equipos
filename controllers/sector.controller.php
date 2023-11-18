<?php

require_once '../models/Sector.php';

if (isset($_POST['operacion'])){

    $sector = new Sector();

    switch ($_POST['operacion']){
        case 'obtenerNC':
            echo json_encode($sector->obtenerNC());
        break;

        case 'listar_detalles_sector':
            $idsector = isset($_POST['idsector']) ? $_POST['idsector'] : null;
            echo json_encode($sector->listar_detalles_sector(['idsector' => $idsector]));
        break; 

        case 'registrar':
            $datosEnviar = [
                'sector' => $_POST['sector']
            ];

            echo json_encode($sector->registrar($datosEnviar));
        break;
        
    }
}

?>