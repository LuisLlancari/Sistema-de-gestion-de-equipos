<?php 
require_once './Conexion.php'


class Usuario extends Conexion {

  private $conexion;

  public function __CONSTRUCT(){
    $this->conexion = parent ::getConexion();
  }

  public function login_usuario($datos = []){
    try {
      $consulta = $this->conexion->prepare()
      $consulta->execute(
        array($datos[""])
      );
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exeption $e) {
        die($e->getMessage());
    }
  }


} 

?>