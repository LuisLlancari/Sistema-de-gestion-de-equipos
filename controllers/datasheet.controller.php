<?php

require_once "../models/Datasheet.php";
require_once "../test/filtro.php";

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
                "clave"     => filtrar($_POST['clave']),
                "valor"     => filtrar($_POST['valor'])
                
            ];
            

            echo json_encode($datasheet->registrar($datosEnviar));
            break;
        
        case 'modificar':

            $datosEnviar = [
                "iddatasheet"   => $_POST['iddatasheet'],
                "idequipo"      => $_POST['idequipo'],
                "clave"         => filtrar($_POST['clave']),
                "valor"         => filtrar($_POST['valor'])
            ];

            echo json_encode($datasheet->modificar($datosEnviar));
            break;
        
        case 'eliminar':

            $datosEnviar = [ "iddatasheet" => $_POST['iddatasheet']];
        
        echo json_encode($datasheet->eliminar($datosEnviar));
    }
}