-- ------------------------------------------------------------
-- ------------ EJECUCIONES DE CONSULTA -----------------------
-- ------------------------------------------------------------
-- 1°: Uso DB
USE SISCOMPU;

-- LIMPIEZA
DELETE FROM usuarios;
ALTER TABLE usuarios AUTO_INCREMENT 1;

-- Encriptando las claves : SENATI123
UPDATE usuarios SET
	claveacceso = '$2y$10$75lA.B0Xsqf12p96E/myo.MJG3EylGhH92ENeFKMcQ2Ysjk//FmHm';
    
select * from usuarios;
select * from sectores;
select * from equipos;
select * from datasheet;
select * from sectores_detalle;
select * from mantenimiento;
select * from cronogramas;

-- USUARIOS
CALL spu_usuarios_registrar('Jose', 'Alcantara', 'ADMIN', 'SENATI123', 'jose@gmail.com', NULL);
CALL spu_usuarios_registrar('Adriana', 'Durand', 'ADMINISTRADOR', 'SENATI123', 'adriana@gmail.com', NULL);
CALL spu_usuarios_registrar('Jorge', 'Marcos', 'ADMINISTRADOR', 'SENATI123', 'jorge@gmail.com', NULL);
CALL spu_usuarios_registrar('Angélica', 'Maurtua', 'ADMINISTRADOR', 'SENATI123', 'angelica@gmail.com', NULL);
CALL spu_usuarios_registrar('Josefa', 'Arteaga', 'ADMINISTRADOR', 'SENATI123', 'josefa@gmail.com', NULL);
CALL spu_usuarios_registrar('Andrea', 'Galvez', 'ADMINISTRADOR', 'SENATI123', 'andrea@gmail.com', NULL);
CALL spu_usuarios_registrar('Carlos', 'Quiroz', 'ADMINISTRADOR', 'SENATI123', 'carlos@gmail.com', NULL);

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
    (1, 3, 5, 'Laptop HP EliteBook 2', 'EliteBook 840 G8', 'NS111111111', 'ruta/a/la/imagen11.jpg'),
    (2, 1, 3, 'PC de Escritorio Dell OptiPlex 2', 'OptiPlex 5090', 'NS222222222', 'ruta/a/la/imagen22.jpg'),
    (3, 2, 1, 'Tablet Apple iPad Pro 2', 'iPad Pro 11"', 'NS333333333', 'ruta/a/la/imagen33.jpg'),
    (4, 3, 5, 'Laptop HP EliteBook 3', 'EliteBook 840 G9', 'NS444444444', 'ruta/a/la/imagen44.jpg'),
    (5, 1, 3, 'PC de Escritorio Dell OptiPlex 3', 'OptiPlex 5100', 'NS555555555', 'ruta/a/la/imagen55.jpg'),
    (6, 2, 1, 'Tablet Apple iPad Pro 3', 'iPad Pro 10.5"', 'NS666666666', 'ruta/a/la/imagen66.jpg'),
    (13, 3, 5, 'Laptop HP EliteBook 4', 'EliteBook 840 G10', 'NS777777777', 'ruta/a/la/imagen77.jpg'),
    (14, 1, 3, 'PC de Escritorio Dell OptiPlex 4', 'OptiPlex 5110', 'NS888888888', 'ruta/a/la/imagen88.jpg'),
    (15, 2, 1, 'Tablet Apple iPad Pro 4', 'iPad Pro 10"', 'NS999999999', 'ruta/a/la/imagen99.jpg');
INSERT INTO equipos (idcategoria, idmarca, idusuario, descripcion, modelo_equipo, numero_serie, imagen)
VALUES   
    (4, 2, 1, 'Teclado Mecánico Logitech', 'Logitech G Pro X', 'NS123789450', 'ruta/a/la/imagen14.jpg');


-- CATEGORIAS
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


-- DATASHEET
INSERT INTO datasheet (idequipo, clave, valor) VALUES
    (1, 'RAM', '8GB DDR4'),
    (1, 'Almacenamiento', '256GB SSD'),
    (1, 'Sistema Operativo', 'Windows 10'),
    (1, 'Procesador', 'Intel Core i5'),
    (1, 'Pantalla', '14" FHD'),
    (1, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0'),
    (1, 'Puertos', 'USB-C, HDMI, USB 3.0'),
    (1, 'Batería', 'Hasta 8 horas de duración'),
    (1, 'Tarjeta Gráfica', 'Intel UHD Graphics'),
    (1, 'Color', 'Plata');
    
    INSERT INTO datasheet (idequipo, clave, valor) VALUES
    (2, 'RAM', '8GB DDR4'),
    (2, 'Almacenamiento', '256GB SSD'),
    (2, 'Sistema Operativo', 'Windows 10'),
    (2, 'Procesador', 'Intel Core i5'),
    (2, 'Pantalla', '14" FHD'),
    (2, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0'),
    (2, 'Puertos', 'USB-C, HDMI, USB 3.0'),
    (2, 'Batería', 'Hasta 8 horas de duración'),
    (2, 'Tarjeta Gráfica', 'Intel UHD Graphics'),
    (2, 'Color', 'Plata');
    
	INSERT INTO datasheet (idequipo, clave, valor) VALUES
    (3, 'RAM', '8GB DDR4'),
    (3, 'Almacenamiento', '256GB SSD'),
    (3, 'Sistema Operativo', 'Windows 10'),
    (3, 'Procesador', 'Intel Core i5'),
    (3, 'Pantalla', '14" FHD'),
    (3, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0'),
    (3, 'Puertos', 'USB-C, HDMI, USB 3.0'),
    (3, 'Batería', 'Hasta 8 horas de duración'),
    (3, 'Tarjeta Gráfica', 'Intel UHD Graphics'),
    (3, 'Color', 'Plata');
    
INSERT INTO datasheet (idequipo, clave, valor) VALUES
    (4, 'RAM', '8GB DDR4'),
    (4, 'Almacenamiento', '256GB SSD'),
    (4, 'Sistema Operativo', 'Windows 10'),
    (4, 'Procesador', 'Intel Core i5'),
    (4, 'Pantalla', '14" FHD'),
    (4, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0'),
    (4, 'Puertos', 'USB-C, HDMI, USB 3.0'),
    (4, 'Batería', 'Hasta 8 horas de duración'),
    (4, 'Tarjeta Gráfica', 'Intel UHD Graphics'),
    (4, 'Color', 'Plata');

-- MANTENIMIENTO
INSERT INTO mantenimiento (idusuario, idcronograma, descripcion)
VALUES
    (1, 1, 'Reemplazo de piezas defectuosas'),
    (1, 2, 'Limpieza y ajuste de componentes'),
    (1, 3, 'Verificación del sistema eléctrico'),
    (1, 4, 'Cambio de filtros y aceite'),
    (3, 5, 'Revisión general de la maquinaria'),
    (3, 6, 'Calibración de sensores y controles'),
    (1, 7, 'Inspección de componentes críticos'),
    (1, 8, 'Alineación y balanceo de equipos'),
    (3, 9, 'Mantenimiento preventivo programado'),
    (3, 10, 'Reparación de circuitos electrónicos');

-- CROGRAMAS 
INSERT INTO cronogramas (idequipo, tipo_mantenimiento, estado, fecha_programada)
VALUES
    (1, 'Mantenimiento preventivo', 'pendiente', '2023-12-05 08:00:00'),
    (1, 'Mantenimiento correctivo', 'en proceso', '2023-12-10 10:30:00'),
    (1, 'Mantenimiento predictivo', 'pendiente', '2023-12-15 14:45:00'),
    (2, 'Mantenimiento correctivo', 'pendiente', '2023-12-08 09:15:00'),
    (2, 'Mantenimiento preventivo', 'en proceso', '2023-12-12 11:00:00'),
    (2, 'Mantenimiento predictivo', 'en proceso', '2023-12-18 16:20:00'),
    (3, 'Mantenimiento predictivo', 'pendiente', '2023-12-06 07:45:00'),
    (3, 'Mantenimiento preventivo', 'en proceso', '2023-12-11 10:00:00'),
    (3, 'Mantenimiento correctivo', 'pendiente', '2023-12-16 12:30:00'),
    (4, 'Mantenimiento correctivo', 'pendiente', '2023-12-09 08:30:00'),
    (4, 'Mantenimiento predictivo', 'en proceso', '2023-12-13 09:45:00'),
    (4, 'Mantenimiento preventivo', 'pendiente', '2023-12-19 11:15:00'),
    (5, 'Mantenimiento predictivo', 'en proceso', '2023-12-07 10:00:00'),
    (5, 'Mantenimiento correctivo', 'en proceso', '2023-12-14 12:00:00'),
    (5, 'Mantenimiento preventivo', 'pendiente', '2023-12-17 14:00:00');

-- ---------------------------------------------------------------------------------------LLV
insert into marcas(marca) values("Asus"),("lenovo");
insert into categorias(categoria) values("Pantallas"),("Ordenadores");

insert into equipos(idcategoria, idmarca, idusuario, modelo_equipo, numero_serie, imagen)
VALUES 
	(3,2,1,'Equipo1','je992_020_2',null),
	(1,3,4,'EquipoNuevo','99_20sjss_200',null);
    
insert into cronogramas(idequipo, tipo_mantenimiento, estado, fecha_programada)
VALUES
	(1,'Preventivo','pendiente','2023-11-20'),
	(2,'Mantenimiento','en curso','2023-11-18'),
	(2,'Mantenimiento','Realizado','2023-08-10'),
	(2,'Mantenimiento','Cancelado','2023-10-12');

insert into mantenimiento(idusuario,idcronograma,descripcion)
VALUES
	(1,2,'sin problemas'),
	(1,3,'con problemas'),
	(1,4,'algo raro paso');


CALL spu_insertar_sectores(1,1,'Laboratorio', '2023-12-02', NULL);
CALL spu_cronogramas_registrar(1, 'Formateo', 'Malo', '2023-12-12');
CALL spu_cronogramas_registrar(2, 'Cambio de pieza', 'Recuperable', '2023-01-23');
CALL spu_listar_detalleSectores();
CALL spu_obtenerCNsectores();
CALL spu_listar_detalleSectores(1);
CALL spu_mover_equipo();
CALL spu_listar_detalleSectores(1);
CALL spu_insertar_sector("Aula Zoom");
CALL spu_sector_eliminar(2);
CALL spu_mover_equipo(3,6,1);
CALL spu_mover_equipo(4,7,1);



