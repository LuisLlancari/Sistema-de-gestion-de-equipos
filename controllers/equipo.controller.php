<?php
session_start();
date_default_timezone_set("America/Lima");

require_once "../models/Equipo.php";
require_once '../test/filtro.php';

if(isset($_POST['operacion'])){

    /**
     * CREAMOS UN OBJETO
     * $equipo => Objeto que almacena la clase Equipo en la variable $equipo 
     */
    $equipo = new Equipo();

    switch ($_POST['operacion']){
   
            
        case 'listar':
        
            echo json_encode($equipo->listar());
            break;
        


        case 'registrar':

            $hoy = date("dmYhis");

            $nombreImagen = sha1($hoy) . ".jpg";

            $datosEnviar = [

                "idcategoria"   => $_POST['idcategoria'],
                "idmarca"       => $_POST['idmarca'],
                "idusuario"     => $_SESSION['idusuario'],
                "descripcion"   => filtrar($_POST['descripcion']),
                "modelo_equipo" => filtrar($_POST['modelo_equipo']),
                "numero_serie"  => filtrar($_POST['numero_serie']),
                "imagen"        =>  $nombreImagen, 
                "estado"        =>  $_['estado'] 
            ];

            if(move_uploaded_file($_FILES['imagen']['tmp_name'], "../images/" . $nombreImagen)){

                $datosEnviar['imagen'] = $nombreImagen;
            }
            echo json_encode($equipo->registrar($datosEnviar));

            break;
        
        case 'modificar':

            $hoy = date("hmsYis");

            $nombreImagen = sha1($hoy) . ".jpg";

            $datosEnviar = [

                "idequipo"      => $_POST['idequipo'],
                "idcategoria"   => $_POST['idcategoria'],
                "idmarca"       => $_POST['idmarca'],
                "idusuario"     => $_SESSION['idusuario'],
                "descripcion"   => filtrar($_POST['descripcion']),
                "modelo_equipo" => filtrar($_POST['modelo_equipo']),
                "numero_serie"  => filtrar($_POST['numero_serie']),
                "imagen"        =>  $nombreImagen, 
                "estado"        =>  $_POST['estado'] 
            ];

            
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], "../images/" . $nombreImagen)){                
                $datosEnviar['imagen'] = $nombreImagen;
            }

            echo json_encode($equipo->modificar($datosEnviar));
            break;

        case 'obtenerEquipo' :

            $datosEnviar = ["idequipo" => $_POST['idequipo']];

            echo json_encode($equipo->getEquipo($datosEnviar));
            break;

        case 'otenerEquipoCat' :

            $datosEnviar = ["idcategoria" => $_POST['idcategoria']];
    
            echo json_encode($equipo->getEquipoCat($datosEnviar));
            break;
        
        case 'eliminar':

            $datosEnviar = ["idequipo" => $_POST['idequipo']];
            echo json_encode($equipo->eliminar($datosEnviar));

            break; 
    }
}