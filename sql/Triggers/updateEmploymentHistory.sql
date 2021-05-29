DROP TRIGGER IF EXISTS updateEmploymentHistory;

DELIMITER $$

CREATE TRIGGER updateEmploymentHistory
AFTER UPDATE ON Datos_Laborales
FOR EACH ROW
BEGIN 
  UPDATE Historial_Laboral SET
  Empleo=NEW.Empleo,Empresa=NEW.Empresa,Puesto=NEW.Puesto,Categoria=NEW.Categoria,Correo_Emp=NEW.Correo_Emp,Departamento=NEW.Departamento,Tecnologias=NEW.Tecnologias,Actividades=NEW.Actividades,Inicio=NEW.Inicio
  WHERE Datos_Laborales_idDatos_Laborales = NEW.idDatos_Laborales;
END $$
