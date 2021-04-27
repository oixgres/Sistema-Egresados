<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEncuesta : INT
 *	nombreAlcanceTop : VARCHAR(45)
 *	nombreAlcance : VARCHAR(45)
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idEncuesta o nombreAlcance o nombreAlcanceTop
 *  -2 : No existe el idEncuesta en la base de datos
 *	-3 : Error update
 *	-4 : No existe alcanceTop
 *	-5 : No existe alcance
 *	-6 : Trató de modificar encuesta con alcance universidad
*/

if(isset($_POST['idEncuesta']) && isset($_POST['nombreAlcance']) && isset($_POST['nombreAlcanceTop'])) {
    $idEncuesta = $_POST['idEncuesta'];
    $nombreAlcance = $_POST['nombreAlcance'];
    $nombreAlcanceTop = $_POST['nombreAlcanceTop'];
} else {
    echo -1;
    $conn->close();
    exit();
}
        //  Obtener id's pertenecientes a la encuesta
$sql = "SELECT  Universidad_idUniversidad,
                Campus_idCampus,
                Facultad_idFacultad,
                Plan_Estudio_idPlan_Estudio
        FROM Encuesta WHERE idEncuesta = {$idEncuesta}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {       // error: si no hubo resultados
    echo -2;
    $conn->close();
    exit();
}

$fila = mysqli_fetch_array($res);
// si trato de modificar una encuesta con alcance de universidad
if (!is_null($fila['Universidad_idUniversidad'])) {
    echo -6;
    $conn->close();
    exit();
}

if (!is_null($fila['Campus_idCampus'])) {   // encuesta con alcance de campus
    $sql = "SELECT idUniversidad FROM Universidad WHERE Nombre = '{$nombreAlcanceTop}'";
    $res = mysqli_query($conn, $sql);   //  obtener id de universidad del nombre
    $fila = mysqli_fetch_array($res);

    if (isset($fila['idUniversidad']) && !is_null($fila['idUniversidad'])) {    // comprobar que universidad existe
        $sql = "SELECT idCampus FROM Campus WHERE Nombre = '{$nombreAlcance}' AND Universidad_idUniversidad = {$fila['idUniversidad']}";
        $res = mysqli_query($conn, $sql);                                       // obtener id de campus del nombre
        $fila = mysqli_fetch_array($res);

        if (isset($fila['idCampus']) && !is_null($fila['idCampus'])) {          // comprobar que campus existe
            // preparar consulta para actualizar alcance de encuesta
            $sql = "UPDATE Encuesta
                    SET Campus_idCampus = {$fila['idCampus']}
                    WHERE idEncuesta = {$idEncuesta}";
        } else {
            echo -5;        // no existe campus
            $conn->close();
            exit();
        }
    } else {
        echo -4;            // no existe universidad
        $conn->close();
        exit();
    }
} else if (!is_null($fila['Facultad_idFacultad'])) {        // encuesta con alcance de facultad
    $sql = "SELECT idCampus FROM Campus WHERE Nombre = '{$nombreAlcanceTop}'";
    $res = mysqli_query($conn, $sql);               //  obtener id de campus del nombre
    $fila = mysqli_fetch_array($res);

    if (isset($fila['idCampus']) && !is_null($fila['idCampus'])) {  // comprobar que campus existe
        $sql = "SELECT idFacultad FROM Facultad WHERE Nombre = '{$nombreAlcance}' AND Campus_idCampus = {$fila['idCampus']}";
        $res = mysqli_query($conn, $sql);                       // obtener id de facultad del nombre
        $fila = mysqli_fetch_array($res);

        if (isset($fila['idFacultad']) && !is_null($fila['idFacultad'])) {  // comprobar que facultad existe
            // preparar consulta para actualizar alcance de encuesta
            $sql = "UPDATE Encuesta
                    SET Facultad_idFacultad = {$fila['idFacultad']}
                    WHERE idEncuesta = {$idEncuesta}";
        } else {
            echo -5;            // no existe facultad
            $conn->close();
            exit();
        }
    } else {
        echo -4;                // no existe campus
        $conn->close();
        exit();
    }
} else if (!is_null($fila['Plan_Estudio_idPlan_Estudio'])) {                // encuesta con alcance de plan de estudio
    $sql = "SELECT idFacultad FROM Facultad WHERE Nombre = '{$nombreAlcanceTop}'";
    $res = mysqli_query($conn, $sql);                                        //  obtener id de facultad del nombre
    $fila = mysqli_fetch_array($res);

    if (isset($fila['idFacultad']) && !is_null($fila['idFacultad'])) {      // comprobar que facultad existe
        $sql = "SELECT idPlan_Estudio FROM Plan_Estudio WHERE Nombre = '{$nombreAlcance}' AND Facultad_idFacultad = {$fila['idFacultad']}";
        $res = mysqli_query($conn, $sql);                                   // obtener id de plan de estudio del nombre
        $fila = mysqli_fetch_array($res);

        if (isset($fila['idPlan_Estudio']) && !is_null($fila['idPlan_Estudio'])) {  // comprobar que plan de estudio existe
            // preparar consulta para actualizar alcance de encuesta
            $sql = "UPDATE Encuesta
                    SET Plan_Estudio_idPlan_Estudio = {$fila['idPlan_Estudio']}
                    WHERE idEncuesta = {$idEncuesta}";
        } else {
            echo -5;                 // no existe plan de estudio
            $conn->close();
            exit();
        }
    } else {
        echo -4;                    // no existe facultad
        $conn->close();
        exit();
    }
}

if(mysqli_query($conn, $sql)) {     // ejecutar actualizacion de encuesta
    echo 0;         // exito
} else {
    echo -3;        // error de consulta
}

$conn->close();