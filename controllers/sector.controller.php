<?php
session_start();
require_once '../models/Sector.php';

if (isset($_POST['operacion'])){

    $sector = new Sector();

    switch ($_POST['operacion']){
        case 'obtenerNC':
            echo json_encode($sector->obtenerNC());
        break;

        case 'listar_detalles_sector':
            $datosEnviar = [
                'idsector' => $_POST['idsector']
            ];

            echo json_encode($sector->listar_detalles_sector($datosEnviar));
        break;

        case 'registrar':
            $datosEnviar = [
                'sector' => $_POST['sector']
            ];

            echo json_encode($sector->registrar($datosEnviar));
        break;

        case 'activarSector';
            $datosEnviar = [
            "idsector"     => $_POST['idsector'],
            "activar"      => $_POST['activar']
            ];
            echo json_encode($sector->activarSector($datosEnviar));
        break;

        case 'registrarEquipos_Sector':
            $fotito = date('dmYhis');
            $nombreArchivo = sha1($fotito) . ".jpg";

            $datosEnviar = [
                'idcategoria'   => $_POST['idcategoria'],
                'idmarca'       => $_POST['idmarca'],
                'idusuario'     => $_POST['idusuario'],
                'descripcion'   => $_POST['descripcion'],
                'modelo_equipo' => $_POST['modelo_equipo'],
                'numero_serie'  => $_POST['numero_serie'],
                'imagen'        => '',
                'idsector'      => $_POST['idsector'],
            ];

            if (isset($_FILES['imagen'])) {
              if (move_uploaded_file($_FILES['imagen']['tmp_name'], "../images/" . $nombreArchivo)) {
                $datosEnviar["imagen"] = $nombreArchivo;
              } 
            }
            echo json_encode($sector->registrarEquipos_Sector($datosEnviar));
        break;

        case 'mover_equipo';
            $datosEnviar = [
            "iddetallesector" => $_POST['iddetallesector'],
            "idsector"        => $_POST['idsector'],
            "idusuario"       => $_SESSION['idusuario']
            ];
            echo json_encode($sector->modificar_equipo($datosEnviar));
        break;


        
    }
}

?>