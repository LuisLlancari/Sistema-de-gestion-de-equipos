<?php
session_start();
date_default_timezone_set("America/Lima");

require_once '../models/Mantenimiento.php';

if (isset($_POST['operacion'])){

    $mantenimiento = new Mantenimiento();

    switch ($_POST['operacion']){
        case 'listar_mantenimiento':
            $datosEnviar = [
                'categoria' => $_POST['categoria'],  
                'marca' => $_POST['marca']
            ];

            echo json_encode($mantenimiento->listar($datosEnviar));
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
                "descripcion"          => $_POST['descripcion']
            ];

            echo json_encode($mantenimiento->modificar($datosEnviar));

        break;

        case 'listar_mantenimiento_grafico':
            $datosEnviar = [
                "fechainicio" => $_POST['fechainicio'],
                "fechafin"    => $_POST['fechafin'] 
            ];
      
            echo json_encode($mantenimiento->listar_mantenimiento_grafico($datosEnviar));
          break;
        
    }
}

?>