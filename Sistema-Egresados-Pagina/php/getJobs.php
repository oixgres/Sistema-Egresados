<?php
require_once "dbh.php";
/*
 * Devuelve:
 * 	(JSON)
 *  idEmpleo : INT
 *  Nombre   : VARCHAR(200)
 *
 *  Códigos de error:
 *  -1 : Error consultando empleos
*/

$json = array();
$sql = "SELECT * FROM Empleo";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean" and $res->num_rows != 0) {
    while ($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idEmpleo' => $fila['idEmpleo'],
            'Nombre' => $fila['Nombre']
        );
    }
    /* JSON Ejemplo:
     *  string(38) "[{"idEmpleo":"1","Nombre":"Sistemas"}]"
     */
    $jsonString = json_encode($json);    //convertir el json a cadena
    echo $jsonString;                    //retornar el json al frontend
} else {
    echo -1;
}

$conn->close();