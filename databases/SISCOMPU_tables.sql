CREATE DATABASE SISCOMPU;

USE SISCOMPU;

CREATE TABLE usuarios(
	idusuario 		INT PRIMARY KEY AUTO_INCREMENT,
    rol				VARCHAR(20)		NOT NULL,
    avatar			VARCHAR(200)	NULL,
    apellidos		VARCHAR(45) 	NOT NULL,
    nombres			VARCHAR(40) 	NOT NULL,
    email			VARCHAR(60)		NOT NULL,
    claveacceso		VARCHAR(60) 	NOT NULL,
    codigo			CHAR(6)			NULL,
    create_at		DATE			NOT NULL DEFAULT NOW(),
    update_at		DATE			NULL,
    incative_at		DATE			NULL
)ENGINE = INNODB;