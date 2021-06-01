<?php
require_once "dbh.php";
/*
 * Devuelve:
 * 	(JSON)
 *  idDepartamento  : INT
 *  Nombre          : VARCHAR(200)
 *
 *  Códigos de error:
 *  -1 : Error consultando departamentos
*/

$json = array();
$sql = "SELECT * FROM Departamento";
$res = mysqli_query($conn, $sql);

if (gettype($res) != "boolean" and $res->num_rows != 0) {
    while ($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idDepartamento' => $fila['idDepartamento'],
            'Nombre' => $fila['Nombre']
        );
    }
    /* JSON Ejemplo:
     *  string(49) "[{"idDepartamento":"1","Nombre":"Arquitecturas"}]"
     */

    $jsonString = json_encode($json);    //convertir el json a cadena
    echo $jsonString;                    //retornar el json al frontend
} else {
    echo -1;
}

$conn->close();