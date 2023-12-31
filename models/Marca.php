<?php

require_once 'Conexion.php';

class Marca extends Conexion{
    
    private $conexion;

    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

// FUNCION PARA LISTAR
    public function listar(){
        try{
            $consulta = $this->conexion->prepare("CALL spu_listar_marca()");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

// FUNCION PARA REGISTRAR
    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_insertar_marca(?)");
            $consulta->execute(
                array(
                    $datos ['marca']
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}

?>