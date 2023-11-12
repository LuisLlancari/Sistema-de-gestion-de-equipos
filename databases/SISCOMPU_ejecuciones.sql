USE SISCOMPU;

-- ------------------------------------------------------------
-- ------------ EJECUCIONES DE CONSULTA -----------------------
-- ------------------------------------------------------------
-- 1°: Uso DB
USE SISCOMPU;

-- USUARIOS :
	CALL spu_usuarios_login('adriana@gmail.com');
	CALL spu_usuarios_listar();
	CALL spu_usuarios_registrar('Adriana', 'Durand Buenamarca', 'Administrador', 'SENATI123', 'adriana@gmail.com', NULL);
    CALL spu_usuarios_registrar('Lucas', 'atuncar Valerio', 'Administrador', 'SENATI123', 'lucas@gmail.com', NULL);
    CALL spu_usuario_modificar(2,'Lucas', 'atuncar Valerio', 'Administrador', 'SENATI123', 'lucasatuncar1@gmail.com', NULL);
	CALL spu_usuarios_obtener(2);
    
    select * from usuarios;

-- CATEGORIAS :
	insert into categorias(categoria) values('monitores'),('teclados');
	select * from categorias;
    
    CALL spu_listar_categorias();
    CALL spu_categorias_registrar('proyectores');

-- MARCAS :
	insert into marcas(marca) values('LG'),('Samsung');
	select * from marcas;
    
    CALL spu_listar_marca();
    CALL spu_insertar_marca('LENOVO');
    
-- EQUIPOS :

	select * from equipos;

	CALL spu_equipos_listar();
	CALL spu_equipos_registrar(1,1,1,'model nuevo','asd12456','');
    CALL spu_equipos_modificar(1,1,1,1,'model nuevo','asd12456','');
	CALL spu_equipos_eliminar(2);
    CALL spu_equipos_obtener(2);
	update equipos set inactive_at = null