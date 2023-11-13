<?php 
require_once 'Conexion.php';


class Usuario extends Conexion {

  private $conexion;
  //AGREGANDO UN VALOR RANDOM 
  public function __CONSTRUCT(){
    $this->conexion = parent ::getConexion();
  }


  //CREANDO LA FUNCION PARA LOGIN
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
  
  //CREANDO FUNCION PARA LISTAR
  public function listar_usuario(){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_listar()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e){
        die($e->getMessage());
    }
  }

  //CREANDO FUNCION PARA AGREGAR
  public function registrar_usuario($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_registrar(?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $datos['nombres'],
          $datos['apellidos'],
          $datos['rol'],
          $datos['claveacceso'],
          $datos['email'],
          $datos['avatar']
          )
        );
      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e){
        die($e->getMessage());
    }
  }
  
  //CREANDO FUNCION PARA ELIMINAR
  public function eliminar_usuario($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_eliminar(?)");
      $consulta->execute(array($datos['idusuario']));
      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e){
        die($e->getMessage());
    }
  }

  //CREANDO FUNCION PARA EDITAR
  public function modificar_usuario($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuario_modificar(?,?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $datos['idusuario'],
          $datos['nombres'],
          $datos['apellidos'],
          $datos['rol'],
          $datos['claveacceso'],
          $datos['email'],
          $datos['avatar']
        )
      );
      return $consulta->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e){
        die($e->getMessage());
    }
  }

  public function recuperar_usuario($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_recuperar(?)");
      $consulta->execute(array($datos['email']));
      return $consulta->fetch(PDO::FETCH_ASSOC);
      
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function generar_codigo($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_generar_clave(?,?)");
      $consulta->execute(
        array(
          $datos['idusuario'],
          $datos['codigo']
          )
        );
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function verificar_codigo($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_usuarios_verificar(?)");
      $consulta->execute(array($datos['idusuario']));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function cambiar_contraseña($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_canbiar_contraseña(?,?)");
      $consulta->execute(
        array(
          $datos['idusuario'],
          $datos['claveacceso']
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }

  }



} 

?>