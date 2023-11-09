<?php 
require_once '../models/Usuario.php';

if(isset($_POST['operacion'])){

  $usuario = new Usuario();

  switch ($_POST['operacion']) {
    case 'login_usuario':
      $datosEnnviar['' => $_POST[""]];


      $usuario->login_usuario($datosEnnviar)


      break;
    
   
    
  }

}

?>