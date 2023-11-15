<?php	

  // $texto = "<script>while(true){alert('Has sido hackeado')}</script>";
  // $texto = "<script>alert('Has sido hackeado');</script>";
  //str_replace($caracter a remover, $nuevo_caracter, $texto_cambio)

  // function filtrar($cadenaEntrada){

  //   $textoFiltrado = str_replace("<","",$cadenaEntrada);
  //   $textoFiltrado = str_replace(">","",$textoFiltrado);
  //   $textoFiltrado = str_replace("*","",$textoFiltrado);
  //   $textoFiltrado = str_replace("/","",$textoFiltrado);
    
  //   return $textoFiltrado;
  // }
    

  function filtrar($cadenaEntrada){
    $caracteresProhibidos = array("<",">","*","/","{","}","[","]",";",",",".","(",")");
    $caracteresReemplazar= array("");
    return str_replace($caracteresProhibidos, $caracteresReemplazar, $cadenaEntrada);
  }

  // echo filtrar($texto);
?>