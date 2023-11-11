<?php

require_once 'Conexion.php';

class Categoria extends Conexion{

    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

    public function listar(){
        try{
            $consulta = $this->conexion->prepare("CALL spu_listar_categorias()");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_categorias_registrar(?)");
            $consulta->execute(
                array(
                    $datos['categoria']
                )
            );
        }
        catch (Exception $e){
            die($e->getMessage());
        }
    }
}

?>