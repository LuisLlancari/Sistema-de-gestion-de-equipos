<?php

require_once "Conexion.php";

class Equipo extends Conexion{

    private $conexion;

    public function __COSTRUCT(){
        $this->conexion = parent::getConexion();
    }

    public function listar(){

        try{

        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}