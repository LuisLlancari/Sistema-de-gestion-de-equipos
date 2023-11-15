-- ------------------------------------------------------------
-- ------------ EJECUCIONES DE CONSULTA -----------------------
-- ------------------------------------------------------------
-- 1°: Uso DB
USE SISCOMPU;

CALL spu_usuarios_login('adriana@gmail.com');
CALL spu_usuarios_registrar('Adriana', 'Durand Buenamarca', 'Administrador', 'SENATI123', 'adriana@gmail.com', NULL)

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