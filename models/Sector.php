<?php

require_once 'Conexion.php';

class Sector extends Conexion{
    
    private $conexion;

    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

// FUNCION PARA DETALLES DE LA ASIGNACIÓN A SECTORES
    public function listar_detalles_sector($datos = [])
    {
        try {
            $consulta = $this->conexion->prepare("CALL spu_listar_detalleSectores()");
            $consulta->execute();
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
                die($e->getMessage());
            }
    }

// FUNCION PARA OBTENER NOMBRE Y CANTIDADES
    public function obtenerNC($datos = [])
    {
        try {
            $consulta = $this->conexion->prepare("CALL spu_obtenerCNsectores()");
            $consulta->execute();
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
                die($e->getMessage());
            }
    }

// FUNCION PARA OBTENER POR ID
    public function obtenerporID($datos = [])
    {
        try {
            $consulta = $this->conexion->prepare("CALL spu_obtenerporID(?)");
            $consulta->execute(
                array(
                    $datos ['idsector']
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