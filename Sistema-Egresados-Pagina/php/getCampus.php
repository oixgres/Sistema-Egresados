<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUniversidad : INT
 *
 * Devuelve:
 * 	(JSON)
 *  idCampus : INT
 *  nombre   : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : No se mandó el idUniversidad
 *  -2 : Error consultando universidades
 *  -3 : Error consultando campus
*/

if(isset($_POST['idUniversidad'])) {
    $idUniversidad = $_POST['idUniversidad'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$json = array();
$sql = "SELECT idUniversidad FROM universidad
        WHERE idUniversidad = ${idUniversidad}";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean" and $res->num_rows != 0) {
    $sql = "SELECT idCampus, Nombre as nombre FROM campus
            WHERE Universidad_idUniversidad = ${idUniversidad}";
    $res = mysqli_query($conn, $sql);

    if(gettype($res) != "boolean" and $res->num_rows != 0) {
        while ($fila = mysqli_fetch_array($res)) {
            $json [] = array(
                'idCampus' => $fila['idCampus'],
                'nombre' => $fila['nombre']
            );
        }

        /*
         *	JSON Ejemplo:
         *	   string(37) "[{"idCampus":"1","nombre":"Tijuana"}]"
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