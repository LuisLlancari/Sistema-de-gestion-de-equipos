<?php 
session_start();

require_once '../models/Usuario.php';

if(isset($_POST['operacion'])){

  $usuario = new Usuario();

  switch ($_POST['operacion']) {



    case 'login_usuario':

      $datosEnviar = ["email" => $_POST["email"]];


      //GUARDAMOS el registro de acceso (correcto), FALSE(incorrecto)
      $registro = $usuario->login_usuario($datosEnviar);

      //JSON  contenido del esado del login> usuario(view)
      $statusLogin = [
        "acceso" => false,
        "mensaje"=> ""
      ];

      if($registro == false){
        $_SESSION["status"] = false; //variables de sesiones (asociativas)
        //echo"No existe correo";
        $statusLogin["mensaje"] = "El correo no existe";
      }else{
        //si el correo exite, tenemos que validar la clave enviada($_POST)
        //contra la clave encriptada
        //echo"Correo correcto, valida clave";

        $claveEncriptada = $registro["claveacceso"];
        // $_SESSION["idusuario"] = $registro["idusuario"];
        // $_SESSION["nombres"] = $registro["nombres"];
        // $_SESSION["apellidos"] = $registro["apellidos"];
        // $_SESSION["nivelacceso"] = $registro["rol"];

        if(password_verify($_POST['claveacceso'],$claveEncriptada)){
          $_SESSION["status"] = true;
          $statusLogin["acceso"] = true;
          $statusLogin["mensaje"] = "Acceso correcto";
          //echo "La clave y el acceso son correctos";
        }else{  
          $_SESSION["status"] = FALSE;
          $statusLogin["mensaje"] = "Error en la contraseña";
          //echo "error en la clave";
        }

      }
      echo json_encode($registro);
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