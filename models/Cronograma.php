<?php 
require_once 'Conexion.php';

class Cronograma extends Conexion{

  private $conexion;

  public function __CONSTRUCT(){
    $this->conexion = parent::getConexion();
  }

  public function listar_cronogramas(){
    try {
      $consulta = $this->conexion->prepare("CALL spu_cronogramas_listar()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  
  public function registrar_cronograma($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_cronogramas_registrar(?,?,?,?)");
      $consulta->execute(array(
        $datos['idequipo'],
        $datos['tipo_mantenimiento'],
        $datos['estado'],
        $datos['fecha_programada']
      ));
      // return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  
  public function modificar_cronograma($datos = ['']){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_listar()");
      $consulta->execute(array(
        $datos =[''],
        $datos =[''],
        $datos =[''],
        $datos =[''],
        $datos =['']
      ));
      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  
  public function eliminar_cronograma(){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_listar()");
      $consulta->execute(array(
        $datos['']
      ));
      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  
  public function listar_cronograma_id($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_cronogramas_listar_id(?)");
      $consulta->execute(array(
        $datos['idequipo']
      ));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


}
?>