-- MySQL Script generated by MySQL Workbench
-- Thu Apr  8 15:41:32 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering
-- Guerra Cervantes Sergio Enrique
-- Team Portal
-- SISTEMA EGRESADOS
-- Base de Datos version 5

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

-- -----------------------------------------------------
-- TableUsuario
-- -----------------------------------------------------
DROP TABLE IF EXISTS Usuario ;

CREATE TABLE IF NOT EXISTS Usuario (
  idUsuario INT NOT NULL AUTO_INCREMENT,
  Correo VARCHAR(45) NOT NULL,
  Password VARCHAR(45) NOT NULL,
  Nombres VARCHAR(45) NOT NULL,
  Apellidos VARCHAR(45) NOT NULL,
  Matricula VARCHAR(45) NOT NULL,
  Estatus VARCHAR(45) NOT NULL DEFAULT 'INACTIVO',
  PRIMARY KEY (idUsuario),
  UNIQUE INDEX ind(idUsuario, Correo))
;

-- -----------------------------------------------------
-- TableEstado
-- -----------------------------------------------------
DROP TABLE IF EXISTS Estado ;

CREATE TABLE IF NOT EXISTS Estado (
  idEstado INT NOT NULL AUTO_INCREMENT,
  Numero INT NOT NULL,
  Nombre VARCHAR(45) NOT NULL,
  PRIMARY KEY (idEstado))
;


-- -----------------------------------------------------
-- TableCiudad
-- -----------------------------------------------------
DROP TABLE IF EXISTS Ciudad ;

CREATE TABLE IF NOT EXISTS Ciudad (
  idCiudad INT NOT NULL AUTO_INCREMENT,
  Numero INT NOT NULL,
  Nombre VARCHAR(45) NOT NULL,
  Estado_idEstado INT NOT NULL,
  PRIMARY KEY (idCiudad),
  FOREIGN KEY (Estado_idEstado)
  REFERENCES Estado (idEstado)
  ON DELETE CASCADE)
;


-- -----------------------------------------------------
-- TableDatos_Personales
-- -----------------------------------------------------
DROP TABLE IF EXISTS Datos_Personales ;

CREATE TABLE IF NOT EXISTS Datos_Personales (
  idPersonal INT NOT NULL AUTO_INCREMENT,
  Usuario_idUsuario INT NOT NULL,
  -- Fecha_Nacimiento VARCHAR(45) NOT NULL,
  Fecha_Nacimiento DATE NOT NULL,
  Estado_idEstado INT NOT NULL,
  Ciudad_idCiudad INT NOT NULL,
  Domicilio VARCHAR(45) NOT NULL,
  Telefono VARCHAR(45) NOT NULL,
  PRIMARY KEY (idPersonal),
  UNIQUE INDEX (Usuario_idUsuario),
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE,
  FOREIGN KEY (Estado_idEstado)
  REFERENCES Estado (idEstado),
  FOREIGN KEY (Ciudad_idCiudad)
  REFERENCES Ciudad (idCiudad))
;


-- -----------------------------------------------------
-- TableUniversidad
-- -----------------------------------------------------
DROP TABLE IF EXISTS Universidad ;

CREATE TABLE IF NOT EXISTS Universidad (
  idUniversidad INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(45) NOT NULL,
  PRIMARY KEY (idUniversidad))
;


-- -----------------------------------------------------
-- TableCampus
-- -----------------------------------------------------
DROP TABLE IF EXISTS Campus ;

CREATE TABLE IF NOT EXISTS Campus (
  idCampus INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(45) NOT NULL,
  Universidad_idUniversidad INT NOT NULL,
  PRIMARY KEY (idCampus),
  FOREIGN KEY (Universidad_idUniversidad)
  REFERENCES Universidad (idUniversidad)
  ON DELETE CASCADE)
;


-- -----------------------------------------------------
-- TableFacultad
-- -----------------------------------------------------
DROP TABLE IF EXISTS Facultad ;

CREATE TABLE IF NOT EXISTS Facultad (
  idFacultad INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(45) NOT NULL,
  Campus_idCampus INT NOT NULL,
  PRIMARY KEY (idFacultad),
  FOREIGN KEY (Campus_idCampus)
  REFERENCES Campus (idCampus)
  ON DELETE CASCADE)
;


-- -----------------------------------------------------
-- TablePlan_Estudio
-- -----------------------------------------------------
DROP TABLE IF EXISTS Plan_Estudio ;

CREATE TABLE IF NOT EXISTS Plan_Estudio (
  idPlan_Estudio INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(45) NOT NULL,
  Facultad_idFacultad INT NOT NULL,
  PRIMARY KEY (idPlan_Estudio),
  FOREIGN KEY (Facultad_idFacultad)
  REFERENCES Facultad (idFacultad)
  ON DELETE CASCADE)
;

-- -----------------------------------------------------
-- TableDatos_Escolares
-- -----------------------------------------------------
DROP TABLE IF EXISTS Datos_Escolares ;

CREATE TABLE IF NOT EXISTS Datos_Escolares (
  idEscolar INT NOT NULL AUTO_INCREMENT,
  Usuario_idUsuario INT NOT NULL,
  Universidad_idUniversidad INT NOT NULL,
  Campus_idCampus INT NOT NULL,
  Facultad_idFacultad INT NOT NULL,
  Plan_Estudio_idPlan_Estudio INT NOT NULL,
  Ingreso DATE NOT NULL,
  Egreso DATE NOT NULL,
  Semestre_Grad INT NOT NULL,
  Generacion VARCHAR(45) NOT NULL,
  Titulacion DATE NOT NULL,
  Correo_Inst VARCHAR(45) NULL,
  PRIMARY KEY (idEscolar),
  UNIQUE INDEX (Usuario_idUsuario),
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE,
  FOREIGN KEY (Universidad_idUniversidad)
  REFERENCES Universidad (idUniversidad),
  FOREIGN KEY (Campus_idCampus)
  REFERENCES Campus (idCampus),
  FOREIGN KEY (Facultad_idFacultad)
  REFERENCES Facultad (idFacultad),
  FOREIGN KEY (Plan_Estudio_idPlan_Estudio)
  REFERENCES Plan_Estudio (idPlan_Estudio))
;


-- -----------------------------------------------------
-- TableDatos_Laborales
-- -----------------------------------------------------
DROP TABLE IF EXISTS Datos_Laborales ;

CREATE TABLE IF NOT EXISTS Datos_Laborales (
  idDatos_Laborales INT NOT NULL AUTO_INCREMENT,
  Usuario_idUsuario INT NOT NULL,
  Labora BIT(1) NOT NULL,
  Empleo VARCHAR(45) NULL,
  Empresa VARCHAR(45) NULL,
  Puesto VARCHAR(45) NULL,
  Categoria VARCHAR(45) NULL,
  Correo_Emp VARCHAR(45) NULL,
  Departamento VARCHAR(45) NULL,
  Tecnologias VARCHAR(200) NULL,
  Actividades VARCHAR(200) NULL,
  PRIMARY KEY (idDatos_Laborales),
  UNIQUE INDEX (Usuario_idUsuario),
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE)
;

-- -----------------------------------------------------
-- TableEncuesta
-- -----------------------------------------------------
DROP TABLE IF EXISTS Encuesta ;

CREATE TABLE IF NOT EXISTS Encuesta (
  idEncuesta INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(45) NOT NULL,
  Universidad_idUniversidad INT NULL,
  Campus_idCampus INT NULL,
  Facultad_idFacultad INT NULL,
  Plan_Estudio_idPlan_Estudio INT NULL,
  Estatus VARCHAR(45) NOT NULL,
  PRIMARY KEY (idEncuesta),
  FOREIGN KEY (Universidad_idUniversidad)
  REFERENCES Universidad (idUniversidad),
  FOREIGN KEY (Campus_idCampus)
  REFERENCES Campus (idCampus),
  FOREIGN KEY (Facultad_idFacultad)
  REFERENCES Facultad (idFacultad),
  FOREIGN KEY (Plan_Estudio_idPlan_Estudio)
  REFERENCES Plan_Estudio (idPlan_Estudio))
;

-- -----------------------------------------------------
-- TablePregunta
-- -----------------------------------------------------
DROP TABLE IF EXISTS Pregunta ;

CREATE TABLE IF NOT EXISTS Pregunta (
  idPregunta INT NOT NULL AUTO_INCREMENT,
  Pregunta VARCHAR(200) NOT NULL,
  Tipo INT NOT NULL,
  Encuesta_idEncuesta INT NOT NULL,
  Tema VARCHAR(45) NOT NULL,
  PRIMARY KEY (idPregunta, Encuesta_idEncuesta),
  FOREIGN KEY (Encuesta_idEncuesta)
  REFERENCES Encuesta (idEncuesta)
  ON DELETE CASCADE)
;


-- -----------------------------------------------------
-- TableRespuesta_Usuario
-- -----------------------------------------------------
DROP TABLE IF EXISTS Respuesta_Usuario ;

CREATE TABLE IF NOT EXISTS Respuesta_Usuario (
  idRespuesta_Usuario INT NOT NULL AUTO_INCREMENT,
  Respuesta VARCHAR(200) NOT NULL,
  Pregunta_idPregunta INT NOT NULL,
  Usuario_idUsuario INT NOT NULL,
  PRIMARY KEY (idRespuesta_Usuario, Pregunta_idPregunta, Usuario_idUsuario),
  FOREIGN KEY (Pregunta_idPregunta)
  REFERENCES Pregunta (idPregunta)
  ON DELETE CASCADE,
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE)
;


-- -----------------------------------------------------
-- TableHistorial_Laboral
-- -----------------------------------------------------
DROP TABLE IF EXISTS Historial_Laboral ;

CREATE TABLE IF NOT EXISTS Historial_Laboral (
  idHistorial_Laboral INT NOT NULL AUTO_INCREMENT,
  Usuario_idUsuario INT NOT NULL,
  Empleo VARCHAR(45) NOT NULL,
  Empresa VARCHAR(45) NOT NULL,
  Puesto VARCHAR(45) NOT NULL,
  Categoria VARCHAR(45) NOT NULL,
  Correo_Emp VARCHAR(45) NOT NULL,
  Departamento VARCHAR(45) NOT NULL,
  Tecnologias VARCHAR(45) NOT NULL,
  Actividades VARCHAR(45) NOT NULL,
  Inicio DATE NOT NULL,
  Fin DATE NULL,
  PRIMARY KEY (idHistorial_Laboral),
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE)
;


-- -----------------------------------------------------
-- TableAdmin
-- -----------------------------------------------------
DROP TABLE IF EXISTS Admin ;

CREATE TABLE IF NOT EXISTS Admin (
  idAdmin INT NOT NULL AUTO_INCREMENT,
  Correo VARCHAR(45) NOT NULL,
  Password VARCHAR(45) NOT NULL,
  Nombres VARCHAR(45) NOT NULL,
  Apellidos VARCHAR(45) NOT NULL,
  Universidad_idUniversidad INT NOT NULL,
  PRIMARY KEY (idAdmin),
  UNIQUE INDEX (Correo),
  FOREIGN KEY (Universidad_idUniversidad)
  REFERENCES Universidad (idUniversidad))
;


-- -----------------------------------------------------
-- TableRespuesta
-- -----------------------------------------------------
DROP TABLE IF EXISTS Respuesta ;

CREATE TABLE IF NOT EXISTS Respuesta (
  idRespuesta INT NOT NULL AUTO_INCREMENT,
  Respuesta VARCHAR(45) NOT NULL,
  Pregunta_idPregunta INT NOT NULL,
  PRIMARY KEY (idRespuesta, Pregunta_idPregunta),
  FOREIGN KEY (Pregunta_idPregunta)
  REFERENCES Pregunta (idPregunta)
  ON DELETE CASCADE)
;


-- -----------------------------------------------------
-- TableClaves_Confirmacion
-- -----------------------------------------------------
DROP TABLE IF EXISTS Claves_Confirmacion ;

CREATE TABLE IF NOT EXISTS Claves_Confirmacion (
  Usuario_idUsuario INT NOT NULL,
  Clave VARCHAR(45) NOT NULL,
  PRIMARY KEY (Usuario_idUsuario),
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE)
;

-- -----------------------------------------------------
-- Table Admin_Master
-- -----------------------------------------------------
DROP TABLE IF EXISTS Admin_Master;

CREATE TABLE IF NOT EXISTS Admin_Master (
  Admin_Masterid INT NOT NULL AUTO_INCREMENT,
  Correo VARCHAR(45) NOT NULL,
  Password VARCHAR(45) NOT NULL,
  PRIMARY KEY (Admin_Masterid))
;

-- -----------------------------------------------------
-- Table Encuestas_Pendientes
-- -----------------------------------------------------
DROP TABLE IF EXISTS Encuestas_Pendientes;

CREATE TABLE IF NOT EXISTS Encuestas_Pendientes (
  idEncuesta_Pendientes INT NOT NULL AUTO_INCREMENT,
  Encuesta_idEncuesta INT NOT NULL,
  Nombre VARCHAR(45) NOT NULL,
  Usuario_idUsuario INT NOT NULL,
  PRIMARY KEY (idEncuesta_Pendientes),
  FOREIGN KEY (Encuesta_idEncuesta)
  REFERENCES Encuesta (idEncuesta)
  ON DELETE CASCADE,
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE)
;

-- -----------------------------------------------------
-- Table Encuestas_Contestadas
-- -----------------------------------------------------
DROP TABLE IF EXISTS Encuestas_Contestadas;

CREATE TABLE IF NOT EXISTS Encuestas_Contestadas (
  idEncuesta_Pendientes INT NOT NULL AUTO_INCREMENT,
  Encuesta_idEncuesta INT NOT NULL,
  Nombre VARCHAR(45) NOT NULL,
  Usuario_idUsuario INT NOT NULL,
  PRIMARY KEY (idEncuesta_Pendientes),
  FOREIGN KEY (Encuesta_idEncuesta)
  REFERENCES Encuesta (idEncuesta)
  ON DELETE CASCADE,
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE)
;

-- -----------------------------------------------------
-- Table Enlaces_Usuario
-- -----------------------------------------------------
DROP TABLE IF EXISTS Enlaces_Usuario;

CREATE TABLE IF NOT EXISTS Enlaces_Usuario (
  idEnlaces_Usuario INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(45) NOT NULL,
  Link VARCHAR(200) NOT NULL,
  Usuario_idUsuario INT NOT NULL,
  PRIMARY KEY (idEnlaces_Usuario),
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE)
;

-- -----------------------------------------------------
-- Table Habilidades_Usuario
-- -----------------------------------------------------
DROP TABLE IF EXISTS Habilidades_Usuario;

CREATE TABLE IF NOT EXISTS Habilidades_Usuario (
  idHabilidades_Usuario INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(45) NOT NULL,
  Usuario_idUsuario INT NOT NULL,
  PRIMARY KEY (idHabilidades_Usuario),
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario (idUsuario)
  ON DELETE CASCADE)
;

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
