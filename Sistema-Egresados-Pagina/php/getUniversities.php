<?php
require_once "dbh.php";
/*
 * Devuelve:
 * 	(JSON)
 *  idUniversidad : INT
 *  nombre        : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : Error consultando estados
*/

$json = array();
$sql = "SELECT idUniversidad, Nombre as nombre FROM Universidad";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean") {
    while($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idUniversidad' => $fila['idUniversidad'],
            'nombre' => $fila['nombre']
        );
    }

    /*
     *	JSON Ejemplo:
     *	   string(187) "[{"idUniversidad":"1","nombre":"UABC"},
     *                   {"idUniversidad":"2","nombre":"TEC"},
     *                   {"idUniversidad":"3","nombre":"ITT"},
     *                   {"idUniversidad":"4","nombre":"CUT"},
     *                   {"idUniversidad":"5","nombre":"UTT"}]"
    */
    $jsonString = json_encode($json); 	//convertir el json a cadena
    echo $jsonString; 					//retornar el json al frontend
} else {
    echo -1;
}

$conn->close();