DROP PROCEDURE IF EXISTS updateScope;
DELIMITER $$

CREATE PROCEDURE `updateScope`(idSurvey INT, scopeType INT, idScope INT)
BEGIN
    /*
		RECIBE:
			idSurvey:   ID DE LA ENCUESTA
            scopeType:  0 SI ES PARA UNIVERSIDAD
				        1 SI ES PARA CAMPUS
				        2 SI ES PARA FACULTAD
                        3 SI ES PARA PLAN DE ESTUDIO
            idScope:    ID DEL ALCANCE
    */

    IF (NOT ISNULL(idSurvey) AND NOT ISNULL(scopeType)) THEN                        -- comprobar parametros
        IF EXISTS(SELECT idEncuesta FROM Encuesta WHERE idEncuesta = idSurvey) THEN -- si existe encuesta

            CASE (scopeType)
                WHEN 0 THEN                                                                     -- Universidad
                IF EXISTS(SELECT idUniversidad FROM Universidad WHERE idUniversidad = idScope) THEN -- si existe universidad
                    UPDATE encuesta SET Universidad_idUniversidad = idScope
                    WHERE idEncuesta = idSurvey;

                    UPDATE encuesta SET Campus_idCampus = NULL,             -- borrar el alcance actual de la encuesta
                                        Facultad_idFacultad = NULL,
                                        Plan_Estudio_idPlan_Estudio = NULL
                    WHERE idEncuesta = idSurvey;

                    SELECT 0 AS RESULT;
                ELSE
                    SELECT -3 AS RESULT;
                END IF;
                WHEN 1 THEN                                                                     -- Campus
                IF EXISTS(SELECT idCampus FROM Campus WHERE idCampus = idScope) THEN                -- si existe campus
                    UPDATE encuesta SET Campus_idCampus = idScope
                    WHERE idEncuesta = idSurvey;

                    UPDATE encuesta SET Universidad_idUniversidad = NULL,    -- borrar el alcance actual de la encuesta
                                        Facultad_idFacultad = NULL,
                                        Plan_Estudio_idPlan_Estudio = NULL
                    WHERE idEncuesta = idSurvey;

                    SELECT 0 AS RESULT;
                ELSE
                    SELECT -3 AS RESULT;
                END IF;
                WHEN 2 THEN                                                                     -- Facultad
                IF EXISTS(SELECT idFacultad FROM Facultad WHERE idFacultad = idScope) THEN         -- si existe facultad
                    UPDATE encuesta SET Facultad_idFacultad = idScope
                    WHERE idEncuesta = idSurvey;

                    UPDATE encuesta SET Universidad_idUniversidad = NULL,   -- borrar el alcance actual de la encuesta
                                        Campus_idCampus = NULL,
                                        Plan_Estudio_idPlan_Estudio = NULL
                    WHERE idEncuesta = idSurvey;

                    SELECT 0 AS RESULT;
                ELSE
                    SELECT -3 AS RESULT;
                END IF;
                WHEN 3 THEN                                                                     -- Plan de estudio
                IF EXISTS(SELECT idPlan_Estudio FROM Plan_Estudio WHERE idPlan_Estudio = idScope) THEN -- si existe plan de estudio
                    UPDATE encuesta SET Plan_Estudio_idPlan_Estudio = idScope
                    WHERE idEncuesta = idSurvey;

                    UPDATE encuesta SET Universidad_idUniversidad = NULL,   -- borrar el alcance actual de la encuesta
                                        Facultad_idFacultad = NULL,
                                        Campus_idCampus = NULL
                    WHERE idEncuesta = idSurvey;

                    SELECT 0 AS RESULT;
                ELSE
                    SELECT -3 AS RESULT;
                END IF;
                END CASE;
        ELSE
            SELECT -2 AS RESULT;    -- no existe encuesta
        END IF;
    ELSE
        SELECT -1 AS RESULT;    -- no se mando el idEncuesta o tipoAlcance
    END IF;
END $$
DELIMITER ;