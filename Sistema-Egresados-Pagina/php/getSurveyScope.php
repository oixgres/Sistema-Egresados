<?php
require_once "dbh.php";
/*
 * Recibe:
 *	idEncuesta : INT
 *
 * Devuelve:
 *	alcance : INT
 *
 *	Codigos de error:
 *  -1 : No se envio idEncuesta
 *	-2 : Error en consulta
*/

if(isset($_POST['idEncuesta'])) {
    $idEncuesta = $_POST['idEncuesta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

//Se obtiene las habilidades del usuario...
$sql = "SELECT Universidad_idUniversidad, Campus_idCampus, Facultad_idFacultad, Plan_Estudio_idPlan_Estudio
        FROM Encuesta
		WHERE idEncuesta = ${idEncuesta}";
$res = mysqli_query($conn,$sql);

if(gettype($res) != "boolean" and $res->num_rows > 0) {
    $surveyData = mysqli_fetch_assoc($res);

    if (isset($surveyData["Universidad_idUniversidad"])) {
        $idAlcance = $surveyData["Universidad_idUniversidad"];
    } else if (isset($surveyData["Campus_idCampus"])) {
        $idAlcance = $surveyData["Campus_idCampus"];
    } else if (isset($surveyData["Facultad_idFacultad"])) {
        $idAlcance = $surveyData["Facultad_idFacultad"];
    } else if (isset($surveyData["Plan_Estudio_idPlan_Estudio"])) {
        $idAlcance = $surveyData["Plan_Estudio_idPlan_Estudio"];
    }
    echo $idAlcance;
} else {
    echo -2;
}

$conn->close();