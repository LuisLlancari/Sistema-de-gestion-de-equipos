<?php 
    echo "El primer commit" ;
    $prueba = "123";

    $claveEncritada = password_hash($prueba,PASSWORD_BCRYPT);

    var_dump($claveEncritada);

    $contraseña = "SENATI123";

    if(password_verify($contraseña,$claveEncritada)){
        echo "bien";
      }else{
        echo "mal";
      }
?>