<?php

require_once 'Conexion.php';

class Sector extends Conexion{
    
    private $conexion;

    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

// FUNCION PARA LISTAR
    public function listar(){
        try{
            $consulta = $this->conexion->prepare("CALL spu_listar_MANsectores()");
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
            $consulta = $this->conexion->prepare("CALL spu_insertar_sectores(?,?,?,?,?)");
            $consulta->execute(
                array(
                    $datos ['idequipo'],
                    $datos ['idusuario'],
                    $datos ['nombre'],
                    $datos ['fecha_inicio'],
                    $datos ['fecha_fin']
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}

?>