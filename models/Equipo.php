<?php

require_once "Conexion.php";

class Equipo extends Conexion{

    private $conexion;

    /**
     * Método constructor, se invoca automáticamente al crear una nueva instancia de la clase
     */
    public function __CONSTRUCT(){
        //Accedemos al método getConexion de la clase padre(superclase)
        $this->conexion = parent::getConexion();
    }


    /**
     * MÉTODO QUE NOS LISTA TODOS LOS DATOS DE LA CONSULTA DE LA BASE DE DATOS DE LA TABLA EQUIPOS
     */
    public function listar(){

        try{
            $consulta = $this->conexion->prepare("CALL spu_equipos_listar()");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * MÉTODO QUE NOS SIRVE PARA INSERTAR REGISTROS A LA TABLA EQUIPOS EN LA BASE DE DATOS
     */
    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_equipos_registrar(?,?,?,?,?,?)");
            $consulta->execute(
                array(
                    $datos['idcategoria'],
                    $datos['idmarca'],
                    $datos['idusuario'],
                    $datos['modelo_equipo'],
                    $datos['numero_serie'],
                    $datos['imagen']
                )
            );

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * MÉTODO QUE NOS PERMITIRÁ MODIFICAR UN REGISTRO EN LA TABLA EQUIPOS, DE LA BASE DE DATOS
     */
    public function modificar($datos = []){
        try{
        $consulta = $this->conexion->prepare("CALL spu_equipos_modificar(?,?,?,?,?,?,?)");
        $consulta->execute(
            array(
                $datos['idequipo'],
                $datos['idcategoria'],
                $datos['idmarca'],
                $datos['idusuario'],
                $datos['modelo_equipo'],
                $datos['numero_serie'],
                $datos['imagen']
            )
        );

        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * Método que nos sirve para obtener los datos del equipo por id
     */
    public function getEquipo($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_equipos_obtener(?)");
            $consulta->execute(array($datos['idequipo']));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * método para obtener el equipo por idcategoria
     */
    public function getEquipoCat($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_equipos_listar_categoria(?)");
            $consulta->execute(array($datos['idcategoria']));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * MÉTODO QUE NOS PERMITIRÁ ELIMINAR UN REGISTRO EN LA TABLA EQUIPOS DE LA BASE DE DATOS (INECTIVE_AT => NOW())
     */
    public function eliminar($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_equipos_eliminar(?)");
            $consulta->execute(array($datos['idequipo']));
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
    
}