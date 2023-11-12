<?php

require_once "../models/Datasheet.php";

if(isset($_POST['operacion'])){

    $datasheet = new Datasheet();

    switch($_POST['operacion']){
        case 'listar':

            $datosEnviar = ["idequipo" => $_POST['idequipo']];

            echo json_encode($datasheet->listar($datosEnviar));
            break;
        
        case 'registrar':

            $datosEnviar = [
                "idequipo"  => $_POST['idequipo'],
                "clave"     => $_POST['clave'],
                "valor"     => $_POST['valor'],
            ];

            echo json_encode($datasheet->registrar($datosEnviar));
            break;
    }
}