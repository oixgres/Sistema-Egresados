<?php
require_once "dbh.php";
/*
 * Devuelve:
 * 	(JSON)
 *  idPuesto        : INT
 *  Nombre          : VARCHAR(200)
 *
 *  Códigos de error:
 *  -1 : Error consultando puestos
*/

$json = array();
$sql = "SELECT * FROM Puesto";
$res = mysqli_query($conn, $sql);

if (gettype($res) != "boolean" and $res->num_rows != 0) {
    while ($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idPuesto' => $fila['idPuesto'],
            'Nombre' => $fila['Nombre']
        );
    }
    /* JSON Ejemplo:
     *  string(41) "[{"idPuesto":"1","Nombre":"Programador"}]"
     */
    $jsonString = json_encode($json);    //convertir el json a cadena
    echo $jsonString;                    //retornar el json al frontendend
} else {
    echo -1;
}

$conn->close();
