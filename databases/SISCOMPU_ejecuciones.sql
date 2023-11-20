-- ------------------------------------------------------------
-- ------------ EJECUCIONES DE CONSULTA -----------------------
-- ------------------------------------------------------------
-- 1°: Uso DB
USE SISCOMPU2;

-- LIMPIEZA
DELETE FROM sectores_detalle;
ALTER TABLE sectores_detalle AUTO_INCREMENT 1;

-- USUARIOS
-- Encriptando las claves : SENATI123
UPDATE usuarios SET
	claveacceso = '$2y$10$75lA.B0Xsqf12p96E/myo.MJG3EylGhH92ENeFKMcQ2Ysjk//FmHm'
	WHERE idusuario = 1;
    UPDATE usuarios SET
	rol = 'ADMIN';
select * from usuarios;
CALL spu_usuarios_login('adriana@gmail.com');
select * from sectores;
CALL spu_usuarios_login('adriana@gmail.com');
CALL spu_usuarios_registrar('Jose', 'Alcantara', 'ADMIN', 'SENATI123', 'jose@gmail.com', NULL);
CALL spu_usuarios_registrar('Adrian', 'Durand Buenamarca', 'Administrador', '$2y$10$75lA.B0Xsqf12p96E/myo.MJG3EylGhH92ENeFKMcQ2Ysjk//FmHm', 'adrian@gmail.com', NULL);
CALL spu_usuarios_listar();
-- EQUIPOS
INSERT INTO equipos (idcategoria, idmarca, idusuario, descripcion, modelo_equipo, numero_serie, imagen)
VALUES
    (1, 3, 1, 'Laptop HP EliteBook', 'EliteBook 840 G7', 'NS123456789', 'ruta/a/la/imagen1.jpg'),
    (2, 1, 1, 'PC de Escritorio Dell OptiPlex', 'OptiPlex 5080', 'NS987654321', 'ruta/a/la/imagen2.jpg'),
    (3, 2, 3, 'Tablet Apple iPad Pro', 'iPad Pro 12.9"', 'NS456789123', 'ruta/a/la/imagen3.jpg'),
    (4, 4, 1, 'Laptop Lenovo ThinkPad', 'ThinkPad X1 Carbon', 'NS654321987', 'ruta/a/la/imagen4.jpg'),
    (5, 5, 1, 'PC Gamer Asus ROG', 'ROG Strix G15', 'NS789456123', 'ruta/a/la/imagen5.jpg'),
    (6, 6, 3, 'Laptop Acer Aspire', 'Aspire 5', 'NS321654987', 'ruta/a/la/imagen6.jpg'),
    (7, 7, 1, 'Surface Pro Microsoft', 'Surface Pro 7', 'NS741852963', 'ruta/a/la/imagen7.jpg'),
    (8, 8, 1, 'Smartphone Samsung Galaxy S21', 'Galaxy S21 Ultra', 'NS369258147', 'ruta/a/la/imagen8.jpg'),
    (9, 9, 3, 'Laptop Sony VAIO', 'VAIO S', 'NS852147963', 'ruta/a/la/imagen9.jpg'),
    (10, 10, 3, 'Laptop Toshiba Satellite', 'Satellite Pro', 'NS147258369', 'ruta/a/la/imagen10.jpg'),
    (11, 11, 3, 'Procesador Intel Core i9', 'Core i9-11900K', 'NS963852741', 'ruta/a/la/imagen11.jpg'),
    (12, 12, 3, 'Procesador AMD Ryzen 7', 'Ryzen 7 5800X', 'NS258369147', 'ruta/a/la/imagen12.jpg'),
    (13, 13, 1, 'Tarjeta Gráfica Nvidia GeForce RTX 3080', 'RTX 3080', 'NS456123789', 'ruta/a/la/imagen13.jpg'),
    (14, 14, 1, 'Teclado Mecánico Logitech', 'Logitech G Pro X', 'NS123789456', 'ruta/a/la/imagen14.jpg'),
    (15, 15, 3, 'Memoria RAM Corsair Vengeance', 'Vengeance LPX', 'NS789654123', 'ruta/a/la/imagen15.jpg');
INSERT INTO equipos (idcategoria, idmarca, idusuario, descripcion, modelo_equipo, numero_serie, imagen)
VALUES
    (1, 3, 3, 'Laptop HP EliteBook 2', 'EliteBook 840 G8', 'NS111111111', 'ruta/a/la/imagen11.jpg'),
    (2, 1, 3, 'PC de Escritorio Dell OptiPlex 2', 'OptiPlex 5090', 'NS222222222', 'ruta/a/la/imagen22.jpg'),
    (3, 2, 1, 'Tablet Apple iPad Pro 2', 'iPad Pro 11"', 'NS333333333', 'ruta/a/la/imagen33.jpg'),
    (4, 3, 3, 'Laptop HP EliteBook 3', 'EliteBook 840 G9', 'NS444444444', 'ruta/a/la/imagen44.jpg'),
    (5, 1, 3, 'PC de Escritorio Dell OptiPlex 3', 'OptiPlex 5100', 'NS555555555', 'ruta/a/la/imagen55.jpg'),
    (6, 2, 1, 'Tablet Apple iPad Pro 3', 'iPad Pro 10.5"', 'NS666666666', 'ruta/a/la/imagen66.jpg'),
    (13, 3, 3, 'Laptop HP EliteBook 4', 'EliteBook 840 G10', 'NS777777777', 'ruta/a/la/imagen77.jpg'),
    (14, 1, 3, 'PC de Escritorio Dell OptiPlex 4', 'OptiPlex 5110', 'NS888888888', 'ruta/a/la/imagen88.jpg'),
    (15, 2, 1, 'Tablet Apple iPad Pro 4', 'iPad Pro 10"', 'NS999999999', 'ruta/a/la/imagen99.jpg');
INSERT INTO equipos (idcategoria, idmarca, idusuario, descripcion, modelo_equipo, numero_serie, imagen)
VALUES   
    (4, 2, 1, 'Teclado Mecánico Logitech', 'Logitech G Pro X', 'NS123789450', 'ruta/a/la/imagen14.jpg');
    
CALL spu_equipos_registrar(1, 1, 1,'descripcion1', 'Equipo Nuevo Modelo', 'J11111112', NULL,'');
CALL spu_equipos_modificar(1,2,2,2,'0','0','111111111');
CALL spu_equipos_listar();
CALL spu_equipos_obtener(1);
CALL spu_equipos_listar_categoria();
select * from equipos;

-- CATEGORIAS
insert into equipos(idcategoria, idmarca, idusuario, modelo_equipo, numero_serie, imagen)
VALUES 
	(1,1,1,'ALl ON ONE','9876521',null),
	(1,1,1,'Monitor 4k','9876ds521',null);
insert into categorias(categoria) values("Pantallas"),("Ordenadores");
CALL spu_categorias_registrar("Computadoras");
CALL spu_categorias_registrar("Laptops");
CALL spu_listar_categorias;
INSERT INTO categorias (categoria) VALUES
    ('Laptops'),
    ('Computadoras de Escritorio'),
    ('Tablets'),
    ('Monitores'),
    ('Teclados'),
    ('Mouse'),
    ('Impresoras'),
    ('Almacenamiento'),
    ('Componentes de PC'),
    ('Software'),
    ('Accesorios'),
    ('Redes'),
    ('Audio'),
    ('Proyectores'),
    ('Energía');

-- MARCAS
insert into marcas(marca) values("Asus"),("lenovo");
CALL spu_listar_marca;
CALL spu_insertar_marca("SONY");
CALL spu_insertar_marca("EPSON");
INSERT INTO marcas (marca) VALUES
    ('HP'),
    ('Dell'),
    ('Apple'),
    ('Lenovo'),
    ('Asus'),
    ('Acer'),
    ('Microsoft'),
    ('Samsung'),
    ('Sony'),
    ('Toshiba'),
    ('Intel'),
    ('AMD'),
    ('Nvidia'),
    ('Logitech'),
    ('Corsair');


-- MANTENIMIENTO
select * from mantenimiento;

select * from sectores;
CALL spu_insertar_sectores(3,1,'Laboratorio', '2023-12-02', NULL);

CALL spu_mantenimiento_registrar(1, 1, 'Restauración del sistema; Formateo exitoso');
CALL spu_mantenimiento_listar;
CALL spu_mantenimiento_modificar(1, 1, 1, 'Modificación del Mantenimiento II');
CALL spu_mantenimiento_modificar(3, 1, 2, 'Segunda modificación de Prueba');
CALL spu_listar_mantenimiento_porID(1);
CALL spu_listar_MANsectores();

INSERT INTO sectores(sector) VALUES
("jar"),
("borrar");


-- SECTORES 
CALL spu_insertar_sectores(1,1,'Laboratorio', '2023-12-02', NULL);

-- CRONOGRAMAS
CALL spu_cronogramas_registrar(1, 'Formateo', 'Malo', '2023-12-12');
CALL spu_cronogramas_registrar(2, 'Cambio de pieza', 'Recuperable', '2023-01-23');
-- Encriptando las claves : SENATI123
select*from equipos;
UPDATE usuarios SET
	claveacceso = '$2y$10$75lA.B0Xsqf12p96E/myo.MJG3EylGhH92ENeFKMcQ2Ysjk//FmHm'
	WHERE idusuario = 4;

-- esto de Luis Ll
insert into marcas(marca) values("Asus"),("lenovo");
insert into categorias(categoria) values("Pantallas"),("Ordenadores");

insert into equipos(idcategoria, idmarca, idusuario, modelo_equipo, numero_serie, imagen)
VALUES 
	(3,2,1,'Equipo1','je992_020_2',null),
	(1,3,4,'EquipoNuevo','99_20sjss_200',null);
   SELECT * FROM  EQUIPOS;
insert into cronogramas(idequipo, tipo_mantenimiento, estado, fecha_programada)
VALUES
	(61,'Preventivo','pendiente','2023-11-20'),
	(62,'Mantenimiento','en curso','2023-11-18'),
	(62,'Mantenimiento','Realizado','2023-08-10'),
	(62,'Mantenimiento','Cancelado','2023-10-12');

select * from mantenimiento;
select * from cronogramas;
insert into mantenimiento(idusuario,idcronograma,descripcion)
VALUES
	(1,5,'sin problemas'),
	(1,6,'con problemas'),
	(1,7,'algo raro paso');

-- DATASHEET
UPDATE datasheet SET
	inactive_at = null;
call spu_datasheet_registrar(1,'color','MORADO');
update datasheet set inactive_at = null;
select * FROM datasheet;
update datasheet set auto_increment = 1;

INSERT INTO datasheet (idequipo, clave, valor) VALUES
    (61, 'RAM', '8GB DDR4'),
    (61, 'Almacenamiento', '256GB SSD'),
    (61, 'Sistema Operativo', 'Windows 10'),
    (61, 'Procesador', 'Intel Core i5'),
    (61, 'Pantalla', '14" FHD'),
    (61, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0'),
    (61, 'Puertos', 'USB-C, HDMI, USB 3.0'),
    (61, 'Batería', 'Hasta 8 horas de duración'),
    (61, 'Tarjeta Gráfica', 'Intel UHD Graphics'),
    (61, 'Color', 'Plata');
    
    INSERT INTO datasheet (idequipo, clave, valor) VALUES
    (62, 'RAM', '8GB DDR4'),
    (62, 'Almacenamiento', '256GB SSD'),
    (62, 'Sistema Operativo', 'Windows 10'),
    (62, 'Procesador', 'Intel Core i5'),
    (62, 'Pantalla', '14" FHD'),
    (62, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0'),
    (62, 'Puertos', 'USB-C, HDMI, USB 3.0'),
    (62, 'Batería', 'Hasta 8 horas de duración'),
    (62, 'Tarjeta Gráfica', 'Intel UHD Graphics'),
    (62, 'Color', 'Plata');
    
	INSERT INTO datasheet (idequipo, clave, valor) VALUES
    (63, 'RAM', '8GB DDR4'),
    (63, 'Almacenamiento', '256GB SSD'),
    (63, 'Sistema Operativo', 'Windows 10'),
    (63, 'Procesador', 'Intel Core i5'),
    (63, 'Pantalla', '14" FHD'),
    (63, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0'),
    (63, 'Puertos', 'USB-C, HDMI, USB 3.0'),
    (63, 'Batería', 'Hasta 8 horas de duración'),
    (63, 'Tarjeta Gráfica', 'Intel UHD Graphics'),
    (63, 'Color', 'Plata');
    
INSERT INTO datasheet (idequipo, clave, valor) VALUES
    (64, 'RAM', '8GB DDR4'),
    (64, 'Almacenamiento', '256GB SSD'),
    (64, 'Sistema Operativo', 'Windows 10'),
    (64, 'Procesador', 'Intel Core i5'),
    (64, 'Pantalla', '14" FHD'),
    (64, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0'),
    (64, 'Puertos', 'USB-C, HDMI, USB 3.0'),
    (64, 'Batería', 'Hasta 8 horas de duración'),
    (64, 'Tarjeta Gráfica', 'Intel UHD Graphics'),
    (64, 'Color', 'Plata');
-- SECTORES
	INSERT INTO sectores (sector)values('psicología'),('secretaría'),('aula de profesores');
    select * from sectores;

-- MANTENIMIENTO SECTORES
select * from MAN_sectores;
    INSERT INTO MAN_sectores(idsector,idequipo,idusuario,fecha_inicio) value(1,1,1,'2023-12-12');

-- USUARIOS
UPDATE usuarios SET
	rol = 'ADMIN'
    WHERE idusuario = 1;

CALL spu_listar_detalleSectores();
    
select * from sectores;
select * from equipos;
select * from usuarios;
select * from sectores_detalle;
CALL spu_listar_categorias();
CALL spu_obtenerCNsectores();
CALL spu_listar_detalleSectores(1);
CALL spu_mover_equipo();
CALL spu_listar_detalleSectores(1);
CALL spu_insertar_sector("Aula Zoom");
CALL spu_sector_eliminar(2);

CALL spu_mover_equipo(3,6,1);
CALL spu_equipos_registrar_sector(1, 3, 1, 'descripcion?', 'MODE', 'SERIE00001', NULL, '1');
CALL spu_mover_equipo(4,7,1);

-- CROGRAMAS 
-- Insertar registros de ejemplo para idequipo máximo 15
INSERT INTO cronogramas (idequipo, tipo_mantenimiento, estado, fecha_programada)
VALUES
    (61, 'Mantenimiento preventivo', 'pendiente', '2023-12-05 08:00:00'),
    (61, 'Mantenimiento correctivo', 'en proceso', '2023-12-10 10:30:00'),
    (61, 'Mantenimiento predictivo', 'pendiente', '2023-12-15 14:45:00'),
    (62, 'Mantenimiento correctivo', 'pendiente', '2023-12-08 09:15:00'),
    (62, 'Mantenimiento preventivo', 'en proceso', '2023-12-12 11:00:00'),
    (62, 'Mantenimiento predictivo', 'en proceso', '2023-12-18 16:20:00'),
    (63, 'Mantenimiento predictivo', 'pendiente', '2023-12-06 07:45:00'),
    (63, 'Mantenimiento preventivo', 'en proceso', '2023-12-11 10:00:00'),
    (63, 'Mantenimiento correctivo', 'pendiente', '2023-12-16 12:30:00'),
    (64, 'Mantenimiento correctivo', 'pendiente', '2023-12-09 08:30:00'),
    (64, 'Mantenimiento predictivo', 'en proceso', '2023-12-13 09:45:00'),
    (64, 'Mantenimiento preventivo', 'pendiente', '2023-12-19 11:15:00'),
    (65, 'Mantenimiento predictivo', 'en proceso', '2023-12-07 10:00:00'),
    (65, 'Mantenimiento correctivo', 'en proceso', '2023-12-14 12:00:00'),
    (65, 'Mantenimiento preventivo', 'pendiente', '2023-12-17 14:00:00');
    select *from cronogramas;
-- MANTENIMIENTO
INSERT INTO mantenimiento (idusuario, idcronograma, descripcion)
VALUES
    /*(1, 5, 'Reemplazo de piezas defectuosas'),
    (1, 6, 'Limpieza y ajuste de componentes'),
    (1, 7, 'Verificación del sistema eléctrico'),*/
    (1, 8, 'Cambio de filtros y aceite'),
    (2, 9, 'Revisión general de la maquinaria'),
    (2, 10, 'Calibración de sensores y controles'),
    (1, 11, 'Inspección de componentes críticos'),
    (1, 12, 'Alineación y balanceo de equipos'),
    (2, 13, 'Mantenimiento preventivo programado'),
    (2, 14, 'Reparación de circuitos electrónicos');

-- SECTORES
INSERT INTO sectores (sector) VALUES
('Administración'),
('Docencia Primaria'),
('Docencia Secundaria'),
('Educación Física'),
('Departamento de Idiomas'),
('Consejería Estudiantil'),
('Biblioteca'),
('Tecnología Educativa'),
('Arte y Cultura'),
('Recursos Humanos');
select * from sectores;
INSERT INTO sectores_detalle(idsector,idequipo,idusuario)values(1,61,1),(2,61,1),(3,61,1);