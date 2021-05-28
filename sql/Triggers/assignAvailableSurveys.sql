  
DROP TRIGGER IF EXISTS assignAvailableSurveys;
DELIMITER $$

CREATE TRIGGER assignAvailableSurveys
    AFTER INSERT ON Usuario
    FOR EACH ROW
BEGIN
	INSERT INTO Encuestas_Pendientes(Encuesta_idEncuesta, Nombre, Usuario_idUsuario)
	SELECT Encuesta.idEncuesta, Encuesta.Nombre, New.idUsuario FROM Encuesta
	INNER JOIN Datos_Escolares ON New.idUsuario = Datos_Escolares.Usuario_idUsuario
	AND (Datos_Escolares.Universidad_idUniversidad = Encuesta.Universidad_idUniversidad
        OR Datos_Escolares.Campus_idCampus = Encuesta.Campus_idCampus
        OR Datos_Escolares.Facultad_idFacultad = Encuesta.Facultad_idFacultad
        OR Datos_Escolares.Plan_Estudio_idPlan_Estudio = Encuesta.Plan_Estudio_idPlan_Estudio);
END $$