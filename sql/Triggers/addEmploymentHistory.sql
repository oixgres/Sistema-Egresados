DROP TRIGGER IF EXISTS addEmploymentHistory;

DELIMITER $$

CREATE TRIGGER addEmploymentHistory
AFTER INSERT ON Datos_Laborales
FOR EACH ROW
BEGIN 
  INSERT INTO Historial_Laboral
  (Usuario_idUsuario, Datos_Laborales_idDatos_Laborales, Empleo, Empresa, Puesto, Categoria, Correo_Emp, Departamento, Tecnologias, Actividades, Inicio)
  VALUES (NEW.Usuario_idUsuario, NEW.idDatos_Laborales, NEW.Empleo, NEW.Empresa, NEW.Puesto, NEW.Categoria, NEW.Correo_Emp, NEW.Departamento, NEW.Tecnologias, NEW.Actividades, NEW.Inicio);
END $$
