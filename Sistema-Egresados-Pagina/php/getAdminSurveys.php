<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idAdmin : INT
 *
 * Devuelve:
 *
 *  (JSON)
 *  IdEncuesta : INT
 *	Nombre : VARCHAR(45)
 *  Alcance : INT
 *		[0 - Universidad    ]
 *		[1 - Campus         ]
 *	  	[2 - Facultad       ]
 *    	[3 - Plan academico ]
 *  Nombre del alcance : VARCHAR(45)
 *  Número de preguntas : INT
 *
 *  Códigos de error:
 *  -1 : No se mandó el idAdmin
 *  -2 : No existe el idAdmin en la base de datos
 *	-3 : No existen encuestas para este idAdmin
*/


if(isset($_POST['idAdmin'])) {
    $idAdmin = $_POST['idAdmin'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idAdmin FROM Admin WHERE idAdmin = '$idAdmin'";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "SELECT  Encuesta.idEncuesta,
                Encuesta.Nombre AS nombre,
                (CASE
                    WHEN Encuesta.Universidad_idUniversidad IS NOT NULL THEN 0
                    WHEN Encuesta.Campus_idCampus IS NOT NULL THEN 1
                    WHEN Encuesta.Facultad_idFacultad IS NOT NULL THEN 2
                    WHEN Encuesta.Plan_Estudio_idPlan_Estudio IS NOT NULL THEN 3
                END) AS tipoAlcance,
                (CASE
                    WHEN Encuesta.Universidad_idUniversidad IS NOT NULL THEN Universidad.Nombre
                    WHEN Encuesta.Campus_idCampus IS NOT NULL THEN Campus.Nombre
                    WHEN Encuesta.Facultad_idFacultad IS NOT NULL THEN Facultad.Nombre
                    WHEN Encuesta.Plan_Estudio_idPlan_Estudio IS NOT NULL THEN Plan_Estudio.Nombre
                END) AS alcance,
                COUNT(DISTINCT(Pregunta.idPregunta)) AS numPreguntas
        FROM Universidad
        INNER JOIN Admin ON Admin.Universidad_idUniversidad = Universidad.idUniversidad
        INNER JOIN Campus ON Campus.Universidad_idUniversidad = Universidad.idUniversidad
        INNER JOIN Facultad ON Facultad.Campus_idCampus = Campus.idCampus
        INNER JOIN Plan_Estudio ON Plan_Estudio.Facultad_idFacultad = Facultad.idFacultad
        INNER JOIN Encuesta ON Encuesta.Universidad_idUniversidad = Universidad.idUniversidad
                            OR Encuesta.Campus_idCampus = Campus.idCampus
                            OR Encuesta.Facultad_idFacultad = Facultad.idFacultad
                            OR Encuesta.Plan_Estudio_idPlan_Estudio = Plan_Estudio.idPlan_Estudio
        LEFT JOIN Pregunta ON Pregunta.Encuesta_idEncuesta = Encuesta.idEncuesta
        WHERE Admin.idAdmin = $idAdmin
        GROUP BY Encuesta.idEncuesta";
$res = mysqli_query($conn, $sql);

while($fila = mysqli_fetch_array($res)) {
    if (!isset($fila['idEncuesta'])) {
        echo -3;
        $conn->close();
        exit();
    }
    $json [] = array(
        'idEncuesta' => $fila['idEncuesta'],
        'nombre' => $fila['nombre'],
        'tipoAlcance' => $fila['tipoAlcance'],
        'alcance' => $fila['alcance'],
        'numPreguntas' => $fila['numPreguntas']
    );
}
/*
 *	JSON Ejemplo:
 *	   [{"idEncuesta":"1","nombre":"Historial trabajo","tipoAlcance":"0","alcance":"UABC","numPreguntas":"3"},
 *      {"idEncuesta":"3","nombre":"Desarrollo","tipoAlcance":"3","alcance":"Ing Comp","numPreguntas":"1"},
 *      {"idEncuesta":"4","nombre":"Capacitaciones","tipoAlcance":"1","alcance":"Ensenada","numPreguntas":"5"}]
*/
$jsonString = json_encode($json); 	//convertir el json a cadena
echo $jsonString; 					//retornar el json al frontend

$conn->close();