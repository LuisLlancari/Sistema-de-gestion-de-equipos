<?php 
require_once 'Conexion.php';


class Usuario extends Conexion {

  private $conexion;

  public function __CONSTRUCT(){
    $this->conexion = parent ::getConexion();
  }

  public function login_usuario($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_login(?)");
      $consulta->execute(
        array($datos["email"])
      );
      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e){
        die($e->getMessage());
    }
  }


} 

?>