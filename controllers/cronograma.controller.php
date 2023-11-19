<?php 
require_once '../models/Cronograma.php';

if(isset($_POST['operacion'])){

  $cronograma = new Cronograma();

  switch ($_POST['operacion']) {

//--
    case 'listar_cronograma':
      echo json_encode($cronograma->listar_cronogramas());
      break;
    
    case 'listar_cronograma_id':
      $datosEnviar = ["idequipo" => $_POST['idequipo']];

      echo json_encode($cronograma->listar_cronogramas_id($datosEnviar));
    break;
    

    case 'registrar_cronograma':
        $datosEnviar = [
          "equipo"              => $_POST['equipo'],
          "tipo_mantenimiento"    => $_POST['tipo_mantenimiento'],
          "fecha_programada"      => $_POST['fecha_programada']
        ];

        echo json_encode($cronograma->registrar_cronograma($datosEnviar));
    break;
      
      
    case 'modificar_cronograma':
        $datosEnviar = [
          "idcronograma"          => $_POST['idcronograma'],
          "tipo_mantenimiento"    => $_POST['tipo_mantenimiento'],
          "estado"                => $_POST['estado'],
          "fecha_programada"      => $_POST['fecha_programada'],
          "comentario"            => $_POST['comentario'],
          "idusuario"             => $_POST['idusuario']
        ];


        
        echo json_encode($cronograma->modificar_cronograma($datosEnviar));
    break;
        
      
    case 'eliminar_cronograma':
        $datosEnviar = ["idcronograma" => $_POST['idcronograma']];

        echo json_encode($cronograma->eliminar_cronograma($datosEnviar));
    break;
      


    case 'listar_cronograma_grafico':
      $datosEnviar = ["fechainicio" => $_POST['fechainicio'],"fechafin" => $_POST['fechafin'] ];

      echo json_encode($cronograma->listar_cronograma_grafico($datosEnviar));
    break;

    case '':
      # code...
    break;


  }

}
?>