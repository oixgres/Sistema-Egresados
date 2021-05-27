DROP TRIGGER IF EXISTS registerAvailableSurvey;
DELIMITER $$

CREATE TRIGGER registerAvailableSurvey
    AFTER INSERT ON Encuesta
    FOR EACH ROW
BEGIN
    INSERT INTO Encuestas_Pendientes(Encuesta_idEncuesta, Nombre, Usuario_idUsuario)
    SELECT NEW.idEncuesta, NEW.Nombre, idUsuario FROM Usuario
    INNER JOIN Datos_Escolares ON Usuario.idUsuario = Datos_Escolares.Usuario_idUsuario
    AND (Datos_Escolares.Universidad_idUniversidad = NEW.Universidad_idUniversidad
        OR Datos_Escolares.Campus_idCampus = NEW.Campus_idCampus
        OR Datos_Escolares.Facultad_idFacultad = NEW.Facultad_idFacultad
        OR Datos_Escolares.Plan_Estudio_idPlan_Estudio = NEW.Plan_Estudio_idPlan_Estudio);
END $$