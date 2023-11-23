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
            $consulta = $this->conexion->prepare("CALL spu_listar_detalleSectores(?)");
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

// FUNCION PARA OBTENER NOMBRE Y CANTIDADES
    public function obtenerNC()
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

/* FUNCION PARA OBTENER POR ID
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
    }*/

// FUNCION PARA REGISTRAR
    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("CALL spu_insertar_sector(?)");
            $consulta->execute(
                array(
                    $datos ['sector']
                )
            );
            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }


    //FUNCION PARA ELIMINAR SECTOR
    public function eliminar($datos = []){
        try {
        $consulta = $this->conexion->prepare("CALL spu_sector_eliminar(?)");
        $consulta->execute(array($datos['idsector']));
        return $consulta->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    //FUNCION PARA REGISTRAR EQUIPOS A SECTORES
    public function registrarEquipos_Sector($datos = []){
        try {
        $consulta = $this->conexion->prepare("CALL spu_equipos_registrar_sector(?,?,?,?,?,?,?,?)");
        $consulta->execute(
            array(
              $datos['idcategoria'],  
              $datos['idmarca'],  
              $datos['idusuario'],  
              $datos['descripcion'],
              $datos['modelo_equipo'], 
              $datos['numero_serie'], 
              $datos['imagen'],
              $datos['idsector']  
              )
            );
        return $consulta->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e){
            die($e->getMessage());
        }
    }


    public function modificar_equipo($datos = []){
        try {
        $consulta = $this->conexion->prepare("CALL spu_mover_equipo(?,?,?)");
        $consulta->execute(array(
            $datos['iddetallesector'],
            $datos['idsector'],
            $datos['idusuario']
        ));
        return $consulta->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e){
            die($e->getMessage());
        }
    }


}

?>