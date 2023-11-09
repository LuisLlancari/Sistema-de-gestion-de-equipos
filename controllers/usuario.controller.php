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

      /* echo json_encode($registro); */
      // $datosEnviar = ["email" => $_POST["email"]];

      // $registro = $usuario->login_usuario($datosEnviar);

      // $statusLogin = [
      //   "acceso" => false,
      //   "mensaje"=> ""
      // ];

      // if($registro == false){
      //   $_SESSION["status"] = false;

      //   $statusLogin["mensaje"] = "El correo no existe";
      // }else{

      //   $claveEncriptada = $registro['claveacceso'];
      

      //   if(password_verify($_POST["claveacceso"],$claveEncriptada)){
      //     $_SESSION["status"] = true;
      //     $statusLogin["acceso"] = true;
      //     $statusLogin["mensaje"] = "Acceso correcto";
      //   }else{
      //     $_SESSION["status"] = FALSE;
      //     $statusLogin["mensaje"] = "Error en la contraseña";
      //   }

      // }
      // var_dump($registro);
      // var_dump(gettype($registro));
      break;
    
   
    
  }

}

?>