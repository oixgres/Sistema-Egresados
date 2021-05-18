<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idCampus : INT
 *
 * Devuelve:
 * 	(JSON)
 *  idFacultad : INT
 *  nombre     : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : No se mandó el idCampus
 *  -2 : Error consultando campus
 *  -3 : Error consultando facultades
*/

if(isset($_POST['idCampus'])) {
    $idCampus = $_POST['idCampus'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$json = array();
$sql = "SELECT idCampus FROM campus
        WHERE idCampus = ${idCampus}";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean" and $res->num_rows != 0) {
    $sql = "SELECT idFacultad, Nombre as nombre FROM facultad
            WHERE Campus_idCampus = ${idCampus}";
    $res = mysqli_query($conn, $sql);

    if(gettype($res) != "boolean" and $res->num_rows != 0) {
        while ($fila = mysqli_fetch_array($res)) {
            $json [] = array(
                'idFacultad' => $fila['idFacultad'],
                'nombre' => $fila['nombre']
            );
        }

        /*
         *	JSON Ejemplo:
         *	   string(36) "[{"idFacultad":"1","nombre":"FCQI"}]"
        */
        $jsonString = json_encode($json);    //convertir el json a cadena
        echo $jsonString;                    //retornar el json al frontend
    } else {
        echo -3;
    }
} else {
    echo -2;
}

$conn->close();