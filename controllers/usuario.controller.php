<?php 
session_start();

require_once '../models/Usuario.php';
// require_once '../test/email.php';
require_once '../test/filtro.php';

if(isset($_POST['operacion'])){

  $usuario = new Usuario();

  switch ($_POST['operacion']) {



    case 'login_usuario':
      $datosEnviar = [
        "email" => $_POST['email']
      ];

      $statusLogin = [
          "acceso"    => false,
          "mensaje"   => ""
      ];

      $registro = $usuario->login_usuario($datosEnviar);

      if($registro == false){

          $_SESSION["status"] = false;
          $statusLogin["mensaje"] = "El correo no existe";
      }else{

          $ClaveEncriptada = $registro['claveacceso'];
          $_SESSION["idusuario"]  = $registro["idusuario"];
          $_SESSION["rol"]        = $registro["rol"];
          $_SESSION["apellidos"]  = $registro["apellidos"];
          $_SESSION["nombres"]    = $registro["nombres"]; 
          $_SESSION["avatar"]     = $registro["avatar"]; 

          if(password_verify($_POST['claveacceso'],$ClaveEncriptada)){

              $_SESSION["status"] = true;
              $statusLogin["acceso"] = true;
              $statusLogin["mensaje"] = "Acceso correcto";
          }else{
              $_SESSION["status"] = false;
              $statusLogin["mensaje"]  = "La contraseña es incorrecta";
          }
        }
        echo json_encode($statusLogin);

    break;

    case 'listar_usuario':
      echo json_encode($usuario->listar_usuario());
    break;

    
    case 'registrar_usuario':

      $claveEncritada = password_hash($_POST['claveacceso'],PASSWORD_BCRYPT);

      $ahora = date('dmYhis');
      $nombreArchivo = sha1($ahora). ".jpg";


      $datosEnviar = [
        "nombres"      => filtrar($_POST['nombres']),
        "apellidos"    => filtrar($_POST['apellidos']),
        "rol"          => $_POST['rol'],
        "claveacceso"  => $claveEncritada,
        "email"        => filtrar($_POST['email']),
        "avatar"       => $nombreArchivo
      ];

      if(isset($_FILES['avatar'])){
        if(move_uploaded_file($_FILES['avatar']['tmp_name'], "../images/" . $nombreArchivo)){ 
          $datosEnviar["avatar"]= $nombreArchivo;
        }   
      }

      echo json_encode($usuario->registrar_usuario($datosEnviar));

    break;

    case 'eliminar_usuario';
      $datosEnviar = [
        "idusuario"     => $_POST['idusuario']
      ];

      $usuario->eliminar_usuario($datosEnviar);

    break;
    

    case 'listar_usuario_por_id';
      $datosEnviar = [
        "idusuario"     => $_POST['idusuario']
      ];

      echo json_encode($usuario->listar_por_id($datosEnviar));

    break;


    case 'modificar_usuario';
      
      $ahora = date('dmYhis');
      $nombreArchivo = sha1($ahora). ".jpg";


      $datosEnviar = [
        "idusuario"    => $_POST['idusuario'],
        "nombres"      => filtrar($_POST['nombres']),
        "apellidos"    => filtrar($_POST['apellidos']),
        "rol"          => $_POST['rol'],
        "email"        => filtrar($_POST['email']),
        "avatar"       => $nombreArchivo
      ];

      if(isset($_FILES['avatar'])){
        if(move_uploaded_file($_FILES['avatar']['tmp_name'], "../images/" . $nombreArchivo)){ 
          $datosEnviar["avatar"]= $nombreArchivo;
        }   
      }

      echo json_encode($usuario->modificar_usuario($datosEnviar));

    break;


    case 'recuperar_usuario';
      $datosEnviar =[
        "email" => $_POST['email']
      ];
      echo json_encode($usuario->recuperar_usuario($datosEnviar));
    break;
    

    case 'generar_codigo';

      $codigo = random_int(100000 ,999999 );
  
      $datosEnviar = [
        "idusuario" => $_POST['idusuario'],
        "codigo"    => $codigo,
        $metodo    =   $_POST['metodo'],
        $direccion =   $_POST['direccion']
      ];
      echo json_encode($usuario->generar_codigo($datosEnviar));

      if(strval($metodo) ==  "2"){
        // enviarMail(strval($direccion),strval($codigo));
      }
    break;


    case 'verificar_codigo';
      $datosEnviar = [
        "idusuario" => $_POST['idusuario'],
      ];

      echo json_encode($usuario->verificar_codigo($datosEnviar));
    break;
    

    case 'cambiar_contraseña';

      $claveCambiada = password_hash($_POST['claveacceso'],PASSWORD_BCRYPT);


      $datosEnviar = [
        "idusuario"   => $_POST['idusuario'],
        "claveacceso" => $claveCambiada
      ];
      echo json_encode($usuario->cambiar_contraseña($datosEnviar));
    break;
    
    case '';
    break;
  }

}

/* Sesion destroy */

if (isset($_GET["operacion"])){

  if($_GET["operacion"] == "destroy"){

    session_destroy();
    session_unset();

    header("Location:../index.php");
  }
}

?>