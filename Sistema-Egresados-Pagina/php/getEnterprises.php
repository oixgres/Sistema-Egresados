<?php
require_once "dbh.php";
/*
 * Devuelve:
 * 	(JSON)
 *  idEmpresa       : INT
 *  Nombre          : VARCHAR(200)
 *
 *  Códigos de error:
 *  -1 : Error consultando empresas
*/

$json = array();
$sql = "SELECT * FROM Empresa";
$res = mysqli_query($conn, $sql);

if (gettype($res) != "boolean" and $res->num_rows != 0) {
    while ($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idEmpresa' => $fila['idEmpresa'],
            'Nombre' => $fila['Nombre']
        );
    }
    /* JSON Ejemplo:
     *  string(37) "[{"idEmpresa":"1","Nombre":"Cortex"}]"
     */
    $jsonString = json_encode($json);    //convertir el json a cadena
    echo $jsonString;                    //retornar el json al frontend
} else {
    echo -1;
}

$conn->close();