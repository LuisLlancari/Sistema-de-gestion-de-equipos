-- ------------------------------------------------------------
-- ------------ EJECUCIONES DE CONSULTA -----------------------
-- ------------------------------------------------------------
-- 1°: Uso DB
USE SISCOMPU;

CALL spu_usuarios_login('adriana@gmail.com');
CALL spu_equipos_registrar(2, 1, 1, 'Equipo Nuevo Modelo', 'JSYEKE-0928200', NULL);
CALL spu_usuarios_registrar('Adriana', 'Durand Buenamarca', 'Administrador', 'SENATI123', 'adriana@gmail.com', NULL);
CALL spu_categorias_registrar("Computadoras");
CALL spu_categorias_registrar("Laptops");
CALL spu_listar_categorias;
CALL spu_listar_marca;
CALL spu_insertar_marca("SONY");
CALL spu_insertar_marca("EPSON");
select * from mantenimiento;
CALL spu_insertar_sectores(1,1,'Laboratorio', '2023-12-02', NULL);
CALL spu_mantenimiento_registrar(1, 1, 'Restauración del sistema; Formateo exitoso');
CALL spu_cronogramas_registrar(1, 'Formateo', 'Malo', '2023-12-12');
CALL spu_cronogramas_registrar(2, 'Cambio de pieza', 'Recuperable', '2023-01-23');
CALL spu_mantenimiento_listar;
CALL spu_mantenimiento_modificar(1, 1, 1, 'Modificación del Mantenimiento II');
CALL spu_mantenimiento_modificar(3, 1, 2, 'Segunda modificación de Prueba');
CALL spu_listar_mantenimiento_porID(1);


-- Encriptando las claves : SENATI123
UPDATE usuarios SET
	claveacceso = '$2y$10$75lA.B0Xsqf12p96E/myo.MJG3EylGhH92ENeFKMcQ2Ysjk//FmHm'
	WHERE idusuario = 3;

-- esto de Luis Ll
insert into marcas(marca) values("Asus"),("lenovo");
insert into categorias(categoria) values("Pantallas"),("Ordenadores");

insert into equipos(idcategoria, idmarca, idusuario, modelo_equipo, numero_serie, imagen)
VALUES 
	(1,2,1,'ALl ON ONE','9876521',null),
	(1,1,2,'Monitor 4k','9876ds521',null);
    
insert into cronogramas(idequipo, tipo_mantenimiento, estado, fecha_programada)
VALUES
	(1,'Preventivo','pendiente','2023-11-20'),
	(2,'Mantenimiento','en curso','2023-11-18'),
	(2,'Mantenimiento','Realizado','2023-08-10'),
	(2,'Mantenimiento','Cancelado','2023-10-12');
