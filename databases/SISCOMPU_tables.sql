CREATE DATABASE SISCOMPU;
USE SISCOMPU;

CREATE TABLE usuarios(
	idusuario 		INT PRIMARY KEY AUTO_INCREMENT,
    nombres			VARCHAR(40) 	NOT NULL,
    apellidos		VARCHAR(45) 	NOT NULL,
    rol				VARCHAR(20)		NOT NULL,
	claveacceso		VARCHAR(60) 	NOT NULL,
	email			VARCHAR(60)		NOT NULL,
    avatar			VARCHAR(200)	NULL,
    codigo			CHAR(6)			NULL,
    create_at		DATE			NOT NULL DEFAULT NOW(),
    update_at		DATE			NULL,
    inactive_at		DATE			NULL,
    CONSTRAINT uk_email_usu UNIQUE(email)
)ENGINE = INNODB;