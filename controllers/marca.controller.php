<?php

require_once '../models/Marca.php';

if (isset($_POST['operacion'])){

    $marca = new Marca();

    switch ($_POST['operacion']){
        case 'listar':
            echo json_encode($marca->listar());
        break;

        case 'registrar':
            $datosEnviar = [
                'marca' => $_POST['marca'],
            ];
            $marca->registrar($datosEnviar);
        break;
        
    }
}

?>