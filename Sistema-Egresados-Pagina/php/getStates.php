<?php
require_once "dbh.php";
/*
 * Devuelve:
 * 	(JSON)
 *  idEstado : INT
 *  nombre   : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : Error consultando estados
*/

$json = array();
$sql = "SELECT idEstado, Nombre as nombre FROM Estado";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean") {
    while($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idEstado' => $fila['idEstado'],
            'nombre' => $fila['nombre']
        );
    }

    /*
     *	JSON Ejemplo:
     *	   string(137) "[{"idEstado":"1","nombre":"BC"},
     *                   {"idEstado":"2","nombre":"Sinaloa"},
     *                   {"idEstado":"3","nombre":"Ags"},
     *                   {"idEstado":"4","nombre":"Campeche"}]"
    */
    $jsonString = json_encode($json); 	//convertir el json a cadena
    echo $jsonString; 					//retornar el json al frontend
} else {
    echo -1;
}

$conn->close();