<?php

require_once "Conexion.php";

class Datasheet extends Conexion{

    //Creamos el objeto
    private $conexion;

    //Iniciamos el constructor
    public function __CONSTRUCT()
    {
        $this->conexion = parent::getConexion();
    }

    public function listar($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_datasheet_listar(?)");
            $consulta->execute(array($datos['idequipo']));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_datasheet_registrar(?,?,?)");
            $consulta->execute(
                array(
                    $datos['idequipo'],
                    $datos['clave'],
                    $datos['valor'],
                )
            );

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }   
        catch(Exception $e){
            die($e->getMessage());
        }
    }

}