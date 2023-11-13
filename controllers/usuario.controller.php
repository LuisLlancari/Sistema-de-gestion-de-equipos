<?php 
session_start();

require_once '../models/Usuario.php';

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
          /* $_SESSION["idusuario"] = $registro["idusuario"];
          $_SESSION["rol"] = $registro["rol"];
          $_SESSION["apellidos"] = $registro["apellidos"];
          $_SESSION["nombres"] = $registro["nombres"]; */

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
      $datosEnviar = [
        "nombres"      => $_POST['nombres'],
        "apellidos"    => $_POST['apellidos'],
        "rol"          => $_POST['rol'],
        "claveacceso"  => $_POST['claveacceso'],
        "email"        => $_POST['email'],
        "avatar"       => $_POST['avatar']
      ];

      echo json_encode($usuario->registrar_usuario($datosEnviar));

    break;

    case 'eliminar_usuario';
      $datosEnviar = [
        "idusuario"     => $_POST['idusuario']
      ];

      $usuario->eliminar_usuario($datosEnviar);

    break;

    case 'modificar_usuario';
      $datosEnviar = [
        "idusuario"    => $_POST['idusuario'],
        "nombres"      => $_POST['nombres'],
        "apellidos"    => $_POST['apellidos'],
        "rol"          => $_POST['rol'],
        "claveacceso"  => $_POST['claveacceso'],
        "email"        => $_POST['email'],
        "avatar"       => $_POST['avatar']
      ];

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
        "codigo"    => $codigo
      ];
      echo json_encode($usuario->generar_codigo($datosEnviar));

      // if(strval($metodo) ==  "2"){
      //   enviarMail(strval($direccion),strval($codigo));
      // }
    break;

    case 'verificar_codigo';
      $datosEnviar = [
        "idusuario" => $_POST['idusuario'],
      ];

      echo json_encode($usuario->verificar_codigo($datosEnviar));
    break;
    
    case 'cambiar_contraseña';
      $datosEnviar = [
        "idusuario"   => $_POST['idusuario'],
        "claveacceso" => $_POST['claveacceso']
      ];
      echo json_encode($usuario->cambiar_contraseña($datosEnviar));
    break;
    
    case '';
    break;
  }

}

?>