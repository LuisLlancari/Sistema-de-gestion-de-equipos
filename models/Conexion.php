<?php

class Conexion{
  private $servidor = "localhost";
  private $puerto = "3306";
  private $baseDatos = "SISCOMPU";
  private $usuario = "root";


  public function getConexion(){

    try{

      $pdo = new PDO(
        "mysql:host={$this->servidor};
        port={$this->puerto};
        dbname={$this->baseDatos};
        charset=UTF8",
        $this->usuario
      );
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    }
    catch(Exception $e){
      die($e->getMessage());  
    }
  }
  

}
?>