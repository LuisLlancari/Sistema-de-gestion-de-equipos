<?php

require_once 'Conexion.php';

class Mantenimiento extends Conexion{
    
    private $conexion;
    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

// FUNCION PARA LISTAR
    public function listar(){
        try{
            $consulta = $this->conexion->prepare("CALL spu_mantenimiento_listar()");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

// FUNCION PARA LISTAR POR ID
    public function listarPorID($datos = [])
    {
        try {
            $consulta = $this->conexion->prepare("CALL spu_listar_mantenimiento_porID(?)");
            $consulta->execute(
                array(
                    $datos ['idmantenimiento']
                )
            );
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) {
            die($e->getMessage());
        }
    }



// FUNCION PARA REGISTRAR
    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_mantenimiento_registrar(?,?,?)");
            $consulta->execute(
                array(
                    $datos ['idusuario'],
                    $datos ['idcronograma'],
                    $datos ['descripcion']
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

// FUNCION PARA EDITAR
    public function modificar($datos = []){
    try {
      $consulta = $this->conexion->prepare("CALL spu_mantenimiento_modificar(?,?,?,?)");
      $consulta->execute(
        array(
          $datos['idmantenimiento'],
          $datos['idusuario'],
          $datos['idcronograma'],
          $datos['descripcion']
        )
      );
      return $consulta->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e){
        die($e->getMessage());
    }
  }
}

?>