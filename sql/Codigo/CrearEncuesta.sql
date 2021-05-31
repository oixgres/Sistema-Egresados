CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSurvey`(survey_name VARCHAR(45), scope_name VARCHAR(45), scope VARCHAR(45), idUniversity INT)
BEGIN
	/*
		RECIBE:
			survey_name: NOMBRE DE LA ENCUESTA 
            scope_name: NOMBRE DE LA UNIVERSIDAD, FACULTAD, CAMPUS O PROGRAMA ACADEMICO
            scope: 0 SI ES PARA UNIVERSIDAD
				   1 SI ES PARA CAMPUS
				   2 SI ES PARA FACULTAD
                   3 SI ES PARA PROGRAMA ACADEMICO
            idUniversity: ID DE LA UNIVERSIDAD

    */

	DECLARE id_scope INT;		-- VARIABLE PARA GUARDAR EL idUniversidad
    DECLARE survey_exists INT; 	-- VARIABLE QUE INDICA SI LA ENCUESTA EXISTE
    DECLARE tempId INT; 	-- VALOR A RETORNAR
    DECLARE tempId2 INT; 	-- VALOR A RETORNAR


    CASE (scope)
    WHEN '0' THEN -- si es para universidad
        SELECT idEncuesta INTO survey_exists FROM Encuesta
        WHERE Encuesta.Nombre = survey_name AND Universidad_idUniversidad = idUniversity; -- verificar si no se repite el nombre de la encuesta

        IF(isnull(survey_exists)) THEN -- verificar si se puede crear la encuesta
            -- SE INSERTA LA CORRESPONDIENTE ENCUESTA EN ESTE CASO LA UNIVERSIDAD
            INSERT INTO Encuesta(Nombre, Universidad_idUniversidad)
            VALUES (survey_name, id_scope);

            SELECT last_insert_id() AS RESULT;  			   -- RETORNAR EL ID DE LA ENCUESTA INSERTADA
        ELSE
            SELECT -1 AS RESULT;
        END IF;
			
	WHEN '1' THEN
		SELECT idCampus INTO id_scope from Campus
        WHERE Campus.Nombre = scope_name AND Universidad_idUniversidad = idUniversity; -- traerme el idCampus (si existe)
		
        IF(NOT isnull(id_scope)) THEN -- VERIFICAR SI EL CAMPUS EXISTE 
			-- campus existe 
            SELECT idEncuesta INTO survey_exists FROM Encuesta
            WHERE Encuesta.Nombre = survey_name AND Campus_idCampus = id_scope; -- verificar si no se repite el nombre de la encuesta
            
            IF(isnull(survey_exists)) THEN -- verificar si se puede crear la encuesta
				
				-- SE INSERTA LA CORRESPONDIENTE ENCUESTA
                INSERT INTO Encuesta(Nombre, Campus_idCampus)
                VALUES (survey_name, id_scope);
			
                SELECT last_insert_id() AS RESULT;  			   -- RETORNAR EL ID DE LA ENCUESTA INSERTADA
            ELSE 
				SELECT -1 AS RESULT;
            END IF;
		ELSE 
			SELECT -2 AS RESULT;
        END IF;
        
	WHEN '2' THEN


		SELECT idFacultad INTO id_scope from Facultad
		INNER JOIN Campus ON Facultad.Campus_idCampus = Campus.idCampus
        INNER JOIN Universidad ON Universidad.idUniversidad = Campus.Universidad_idUniversidad
        WHERE Facultad.Nombre = scope_name; -- traerme el idFacultad (si existe)
		
        IF(NOT isnull(id_scope)) THEN -- VERIFICAR SI FACULTAD EXISTE 
			-- la facultad existe 
            SELECT idEncuesta INTO survey_exists FROM Encuesta
            WHERE Encuesta.Nombre = survey_name AND Facultad_idFacultad = id_scope; -- verificar si no se repite el nombre de la encuesta
            
            IF(isnull(survey_exists)) THEN -- verificar si se puede crear la encuesta
				
				-- SE INSERTA LA CORRESPONDIENTE ENCUESTA
                INSERT INTO Encuesta(Nombre, Facultad_idFacultad)
                VALUES (survey_name, id_scope);
			
                SELECT last_insert_id() AS RESULT;  			   -- RETORNAR EL ID DE LA ENCUESTA INSERTADA
			
            ELSE 
				SELECT -1 AS RESULT;
            END IF;
		ELSE 
			SELECT -2 AS RESULT;
        END IF;
        
	WHEN '3' THEN
    
		SELECT idPlan_Estudio INTO id_scope from Plan_Estudio
        INNER JOIN Facultad ON Plan_Estudio.Facultad_idFacultad = Facultad.idFacultad
		INNER JOIN Campus ON Facultad.Campus_idCampus = Campus.idCampus
        INNER JOIN Universidad ON Universidad.idUniversidad = Campus.Universidad_idUniversidad
        WHERE Plan_Estudio.Nombre = scope_name; -- traerme el idFacultad (si existe)
    
		
        IF(NOT isnull(id_scope)) THEN -- VERIFICAR SI PLAN EXISTE 
			-- el plan existe 
            SELECT idEncuesta INTO survey_exists FROM Encuesta
            WHERE Encuesta.Nombre = survey_name AND Plan_Estudio_idPlan_Estudio = id_scope; -- verificar si no se repite el nombre de la encuesta
            
            IF(isnull(survey_exists)) THEN -- verificar si se puede crear la encuesta
				
				-- SE INSERTA LA CORRESPONDIENTE ENCUESTA
                INSERT INTO Encuesta(Nombre, Plan_Estudio_idPlan_Estudio)
                VALUES (survey_name, id_scope);
			
                SELECT last_insert_id() AS RESULT;  			   -- RETORNAR EL ID DE LA ENCUESTA INSERTADA
            ELSE 
				SELECT -1 AS RESULT;
            END IF;
		ELSE 
			SELECT -2 AS RESULT;
        END IF;
        
	END CASE;
END